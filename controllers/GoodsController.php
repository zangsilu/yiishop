<?php
/**
 * Created by PhpStorm.
 * User: MBENBEN
 * Date: 2016/8/21
 * Time: 15:03
 */
namespace app\controllers;

<<<<<<< HEAD
use app\models\Category;
use app\models\Goods;
use Yii;

=======
>>>>>>> 3ac67aa422fc0955aa9315d3cd6633a5043a32a2
class GoodsController extends CommonController{

    //指定页面使用的布局文件
    public $layout = 'layout1';

    /* 商品列表页 */
    public function actionList(){

        $cid = Yii::$app->request->get('cid',0);

        $category = new Category();
        $cids = $category->getSubIds($cid);

        //取出商品
        $goodsInfo = Goods::find()->where(['ison'=>1,'cid'=>$cids])->orderBy(['created_at'=>'desc'])->all();

        return $this->render('list',compact('goodsInfo'));

    }

    /* 商品详情页 */
    public function actionDetails(){

        $id = Yii::$app->request->get('goods_id');

        $goodsInfo = Goods::findOne($id);
        $goodsInfo->goods_pics = json_decode($goodsInfo->goods_pics,true);


        return $this->render('details',compact('goodsInfo'));

    }

}
