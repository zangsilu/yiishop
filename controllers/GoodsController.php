<?php
/**
 * Created by PhpStorm.
 * User: MBENBEN
 * Date: 2016/8/21
 * Time: 15:03
 */
namespace app\controllers;

use app\elasticSearch\GoodsSearch;
use app\models\Category;
use app\models\Goods;
use Yii;
use yii\data\Pagination;

class GoodsController extends CommonController{

    //指定页面使用的布局文件
    public $layout = 'layout1';

    /* 商品列表页 */
    public function actionList(){

        $cid = Yii::$app->request->get('cid',0);

        $category = new Category();
        $cids = $category->getSubIds($cid);

        //取出商品
        $goodsInfo = Goods::find()->where(['ison'=>1,'cid'=>$cids]);
        $totalCount = $goodsInfo->count();
        $pageSize = Yii::$app->params['pageSize']['goods'];
        $pager = new Pagination(['totalCount'=>$totalCount,'pageSize'=>$pageSize]);
        $goodsInfo = $goodsInfo->offset($pager->offset)->limit($pager->limit)->orderBy(['created_at'=>'desc'])->all();

        return $this->render('list',compact('goodsInfo','pager','totalCount'));

    }

    /* 商品详情页 */
    public function actionDetails(){

        $id = Yii::$app->request->get('goods_id');

        $goodsInfo = Goods::findOne($id);
        $goodsInfo->goods_pics = json_decode($goodsInfo->goods_pics,true);


        return $this->render('details',compact('goodsInfo'));

    }

    /**
     * elasticSearch全文搜索
     */
    public function actionSearch()
    {
        $keyword = htmlentities(preg_replace('/\s/','',Yii::$app->request->get('keyword')));

        $totalCount = GoodsSearch::find()->query([
            "multi_match"=>[
                "query"=>$keyword,
                "fields"=>['goods_name','goods_desc']
            ]
        ])->all();
        $totalCount = count($totalCount);

        $pageSize = Yii::$app->params['pageSize']['goods'];
        $pager = new Pagination(['totalCount'=>$totalCount,'pageSize'=>$pageSize]);
        $goodsList = GoodsSearch::find()->query([
            "multi_match"=>[
                "query"=>$keyword,
                "fields"=>['goods_name','goods_desc']
            ]
        ])->highlight([
            "pre_tags"=>["<strong style='color: red'>"],
            "post_tags"=>["</strong>"],
            "fields"=>["goods_name"=>new \stdClass(),"goods_desc"=>new \stdClass()]
        ])->offset($pager->offset)->limit($pager->pageSize)->all();

        foreach ($goodsList as $k=>$v){
            if(is_array($v->highlight)){
                if(!empty($v->highlight['goods_name'])){
                    $goodsList[$k]['goods_name'] = $v->highlight['goods_name'][0];
                }
                if(!empty($v->highlight['goods_desc'])){
                    $goodsList[$k]['goods_desc'] = $v->highlight['goods_desc'][0];
                }
            }
        }
        return $this->render('searchList',compact('goodsList','pager','totalCount'));
    }
}
