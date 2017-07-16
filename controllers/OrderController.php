<?php
/**
 * Created by PhpStorm.
 * User: MBENBEN
 * Date: 2016/8/21
 * Time: 15:59
 */

namespace app\controllers;

use app\models\Address;
use app\models\Cart;
use app\models\Goods;
use app\models\Order;
use app\models\OrderGoods;
use app\models\Pay;
use app\models\User;
use dzer\express\Express;
use Yii;
use yii\filters\AccessControl;

class OrderController extends CommonController
{
    public function behaviors()
    {
        return array_merge([
            'accessFilter' => [
                'class'  => AccessControl::className(),
                'only'   => ['*'],//不设置或设置为空或"*"表示所有方法都受管制
                'except' => [],//除此之外
                'rules'  => [
                    [
                        'allow'   => false,//不允许访问
                        'actions' => [],// 不设置或设置为空表示所有,如果要限制单独某些方法,直接写方法名字
                        'roles'   => ['?'],// ? 表示 guest 未登入的
                    ],
                    [
                        'allow'   => true,//允许访问
                        'actions' => [],//不设置或设置为空表示所有,如果要限制单独某些方法,直接写方法名字
                        'roles'   => ['@'],// @ 表示 登入用户
                    ],
                ],
            ],
        ], parent::behaviors());
    }
    
    
    /* 订单结算页 */
    public function actionCheckout()
    {
        //指定页面使用的布局文件
        $this->layout = 'layout2';
        
        $order_id = Yii::$app->request->get('order_id');
        if (empty($order_id)) {
            return $this->redirect(['order/index']);
        }
        
        //判断当前订单是否是该用户的
        $user_id = Yii::$app->user->id;
        $r = Order::find()->where(['id' => $order_id, 'user_id' => $user_id])->count();
        if (!$r) {
            return $this->redirect(['order/index']);
        }
        
        //判断订单状态,非未付款订单不得进入订单结算页
        $status = Order::findOne($order_id)->status;
        if ($status != Order::PAYNO) {
            return $this->redirect(['order/index']);
        }
        
        //获取收货地址列表
        $addressInfo = Address::find()->where(['user_id' => $user_id])->all();
        
        //获取订单商品列表
        $orderGoodsInfo = OrderGoods::find()
            ->select('og.*,g.goods_img,g.goods_name')
            ->alias('og')
            ->leftJoin(Goods::tableName() . ' g', 'og.goods_id = g.id')
            ->where(['og.order_id' => $order_id])
            ->asArray()
            ->all();
        
        //获取快递列表
        $expressInfo = Yii::$app->params['express'];
        
        //获取订单总价(不含运费)
        $orderAmount = 0;
        foreach ($orderGoodsInfo as $k => $v) {
            $orderAmount += $v['goods_num'] * $v['goods_price'];
        }
        
        
        return $this->render('checkout', compact('addressInfo', 'orderGoodsInfo', 'expressInfo', 'orderAmount'));
    }
    
    /* 订单列表页 */
    public function actionIndex()
    {
        //指定页面使用的布局文件
        $this->layout = 'layout1';
        
        $orderList = Order::find()->alias('o')
            ->select('o.*,a.shou_name')
            ->leftJoin(Address::tableName() . ' a', 'o.address_id=a.id')
            ->leftJoin(User::tableName() . ' u', 'o.user_id = u.id')
            ->where(['u.id' => Yii::$app->user->id])
            ->orderBy('id desc')
            ->asArray()
            ->all();

        foreach ($orderList as $k => $v) {
            $orderList[$k]['goodsInfo'] = OrderGoods::find()->alias('og')
                ->select('og.*,g.goods_name,g.goods_img')
                ->leftJoin(Goods::tableName() . ' g', 'og.goods_id=g.id')
                ->where('og.order_id=' . $v['id'])
                ->asArray()
                ->all();
            $orderList[$k]['status'] = Order::$status[$v['status']];

            foreach (Yii::$app->params['express'] as $m => $n) {
                if (in_array($v['express'], $n)) {
                    $orderList[$k]['express_price'] = $n[1] ?? 0;
                }else{
                    $orderList[$k]['express_price'] = 0;
                }
            }
        }
        return $this->render('index', compact('orderList'));
    }
    
    /**
     * 生成订单
     */
    public function actionAdd()
    {
        $orderModel = new Order();
        
        $transaction = Yii::$app->db->beginTransaction();
        try {
            //获取用户购物车中所有商品信息
            $cartInfo = Cart::find()
                ->alias('c')
                ->select('c.*,g.goods_price,c.username uid')
                ->leftJoin(Goods::tableName() . ' g', 'c.goods_id = g.id')
                ->where(['c.username' => Yii::$app->user->id])->asArray()->all();

            $amount = 0;
            foreach ($cartInfo as $k => $v) {
                $amount += $v['goods_num'] * $v['goods_price'];
            }
            
            $orderModel->user_id = $cartInfo[0]['uid'];
            $orderModel->amount = $amount;
            $orderModel->status = Order::PAYNO;

            if (!$orderModel->save()) {
                throw new \Exception;
            }
            
            $order_id = $orderModel->primaryKey;
            foreach ($cartInfo as $k => $v) {
                //TODO:必须在循环里面创建新对象,这样才会一直是insert,如果在循环外面创建的话,第二次就会变成update了,因为第二次的已经不是新对象了,它把第一次插入的数据又带出来了,赋给该对象自己了;
                $orderGoodsModel = new OrderGoods();
                $orderGoodsModel->order_id = $order_id;
                $orderGoodsModel->goods_num = $v['goods_num'];
                $orderGoodsModel->goods_price = $v['goods_price'];
                $orderGoodsModel->goods_id = $v['goods_id'];
                if (!$orderGoodsModel->save()) {
                    throw new \Exception;
                }

                //清空购物车中的该商品
                Cart::deleteAll(['id' => $v['id']]);
                //商品库存 减1
                Goods::updateAllCounters(['goods_num' => -$v['goods_num']], ['id' => $v['goods_id']]);
            }
            
            //2张表都插入成功,则提交事务;
            $transaction->commit();
        } catch (\Exception $e) {
//            var_dump($e->getMessage());die;
            //回滚
            $transaction->rollBack();
            $this->redirect(['cart/index']);

        }
        $this->redirect(['order/checkout', 'order_id' => $order_id]);
    }
    
    
    /**
     * 当选择快递时,ajax改变订单总价
     */
    public function actionChangeAmount()
    {
        $order_id = Yii::$app->request->get('order_id');
        $express = Yii::$app->request->get('express');
        
        //获取快递所对应的运费
        $expressPrice = Yii::$app->params['express'][$express][1];
        $expressName = Yii::$app->params['express'][$express][0];
        
        //获取订单商品总价(不含运费)
        $orderGoodsInfo = OrderGoods::find()->where(['order_id' => $order_id])->asArray()->all();
        $orderAmount = 0;
        foreach ($orderGoodsInfo as $k => $v) {
            $orderAmount += $v['goods_num'] * $v['goods_price'];
        }
        
        //重新计算订单总价并更新,以及快递信息更新(加上运费)
        $user_id = Yii::$app->user->id;
        $amount = $orderAmount + $expressPrice;
        Order::updateAll(
            ['amount' => $amount, 'express' => $expressName],
            ['id' => $order_id, 'user_id' => $user_id]);
        
        //返回总价
        return json_encode(['amount' => $amount]);
        
    }
    
    /**
     * 订单支付
     */
    public function actionPay()
    {
        $user_id = Yii::$app->user->id;
        
        try {
            $order_id = Yii::$app->request->post('orderId');
            $address_id = Yii::$app->request->post('address');
            $payType = Yii::$app->request->post('payType1');
            $payType = Yii::$app->params['payType'][$payType];
            if (empty($order_id) || empty($payType)) {
                throw new \Exception;
            }
            
            $orderModel = Order::findOne(['id' => $order_id, 'user_id' => $user_id]);
            if (empty($orderModel)) {
                throw new \Exception;
            }
            
            $orderModel->address_id = $address_id;
            $orderModel->payType = $payType;
            if (!$orderModel->save()) {
                throw new \Exception;
            }
            
            //调用支付宝支付接口
            if ($payType == '支付宝') {
                Pay::aliPay($order_id);
            }
            
            
        } catch (\Exception  $e) {
            /*var_dump($e);
            die;*/
            $this->redirect(['index/index']);
        }
    }
    
    /**
     * 物流查询
     */
    public function actionGetExpress()
    {
        $order_id = Yii::$app->request->get('order_id');
        $result = [];
        if (!empty($order_id)) {
            $expressNo = Order::find()->where(['id' => $order_id])->one()->express_no;
            $result = Express::search($expressNo);
        }
        return $result;
    }
    
    /**
     * 确认收货
     */
    public function actionConfirm()
    {
        $order_id = Yii::$app->request->post('order_id');
        if (!empty($order_id)) {
            $orderInfo = Order::findOne($order_id);
        }
        
        if (!empty($orderInfo) && $orderInfo->status == Order::SENDED) {
            $orderInfo->status = Order::DONE;
        }
        
        if ($orderInfo->save()) {
            return $this->redirect(['order/index']);
        }
    }
    
}
