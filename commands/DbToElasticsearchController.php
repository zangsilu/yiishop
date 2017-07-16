<?php

namespace app\commands;


use app\elasticSearch\GoodsSearch;
use app\models\Goods;
use yii\console\Controller;

class DbToElasticsearchController extends Controller
{
    /**
     * 手动同步DB数据到ES
     * php yii db-to-elasticsearch/synchr
     */
    public function actionSynchr()
    {
        $sqlData = Goods::find()->all();

        /**
         * @var $v Goods
         */
        foreach ($sqlData as $v){

            $goodsSearch = GoodsSearch::findOne($v->id);
            if(!empty($goodsSearch)){
                foreach ($v as $field=>$value){
                    $goodsSearch->$field = $value;
                }
            }else{
                $goodsSearch = new GoodsSearch();
                foreach ($v as $field=>$value){
                    $goodsSearch->primaryKey = $v['id'];
                    $goodsSearch->$field = $value;
                }
            }
            $goodsSearch->save(false);
        }
        echo '同步完毕!';
    }
}