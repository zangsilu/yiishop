<?php
/**
 * User: 张世路
 * Date: 2016/11/26
 * Time: 22:39
 */

namespace app\admin\controllers;


use app\models\Address;
use app\models\Goods;
use app\models\Order;
use app\models\OrderGoods;
use app\models\User;
use yii\data\Pagination;

class OrderController extends BaseController
{
    public $layout = 'admin_layout';

    /**
     * 订单列表
     * @return string
     */
    public function actionIndex()
    {
        $data = Order::find()->alias('o')
            ->select('o.*,u.useremail,a.address')
            ->leftJoin(User::tableName() . ' u', 'o.user_id = u.id')
            ->leftJoin(Address::tableName() . ' a', 'o.address_id = a.id');

        $totalCount = $data->count();
        $pager = new Pagination(['totalCount'=>$totalCount,'pageSize'=>\Yii::$app->params['pageSize']['order']]);
        $data = $data->offset($pager->offset)->limit($pager->limit)->asArray()->all();

        foreach ($data as $k => $v) {
            $goodsInfo = OrderGoods::find()->alias('og')
                ->select('og.goods_num,og.goods_id,og.goods_price,g.goods_name')
                ->leftJoin(Goods::tableName() . ' g', 'og.goods_id = g.id')
                ->where('og.order_id = '.$v['id'])
                ->asArray()
                ->all();
            $data[$k]['goodsInfo'] = $goodsInfo;
            $data[$k]['status'] = Order::$status[$v['status']];
        }

        return $this->render('list',compact('data','pager'));
    }

}