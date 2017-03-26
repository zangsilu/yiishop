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
use Yii;

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

    /**
     * 订单详情
     * @return string
     */
    public function actionDetails()
    {
        $order_id = Yii::$app->request->get('order_id');

        $data = Order::find()->alias('o')
            ->select('o.*,u.useremail,a.address')
            ->leftJoin(User::tableName() . ' u', 'o.user_id = u.id')
            ->leftJoin(Address::tableName() . ' a', 'o.address_id = a.id')
            ->where('o.id = '.$order_id)
            ->asArray()
            ->one();

        $goodsInfo = OrderGoods::find()->alias('og')
            ->select('og.goods_num,og.goods_id,og.goods_price,g.goods_name,g.goods_img')
            ->leftJoin(Goods::tableName() . ' g', 'og.goods_id = g.id')
            ->where('og.order_id = '.$order_id)
            ->asArray()
            ->all();

        $data['goodsInfo'] = $goodsInfo;
        $data['status'] = Order::$status[$data['status']];

        return $this->render('details',compact('data'));
    }

    public function actionSend()
    {
        $order_id = Yii::$app->request->get('order_id');
        $model = Order::findOne($order_id);

        if(Yii::$app->request->isPost){
            $post = Yii::$app->request->post();
            //更改订单状态为已发货
            $model ->status = Order::SENDED;

            if($model->load($post) && $model->save()){
                Yii::$app->session->setFlash('info','发货成功!');
            }
        }
        return $this->render('send',compact('model'));
    }

}