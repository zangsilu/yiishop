<?php
/**
 * User: 张世路
 * Date: 2016/11/12
 * Time: 22:24
 */

namespace app\models;


use app\Lib\AliPay\AlipayPay;
use yii\helpers\ArrayHelper;

class Pay
{

    /**
     * 发起支付宝支付
     */
    public static function aliPay($order_id)
    {
        //先获取订单总价
        $amount = Order::findOne($order_id)->amount;
        if(!empty($amount)){
            $giftname = 'Yii商城';
            $goodsNames = OrderGoods::find()->alias('og')
                ->select('g.goods_name')
                ->leftJoin(Goods::tableName().' g','og.goods_id = g.id')
                ->where('og.order_id = '.$order_id)
                ->asArray()
                ->all();
            $goodsNames = ArrayHelper::getColumn($goodsNames,'goods_name');

            $body = '';
            $body .= implode('-',$goodsNames);
            $body .= ' 等商品';
            $showUrl = "http://shop.mr-Jason.com";
            //实例话支付宝支付类
            $alipay = new AlipayPay();
            $html = $alipay -> requestPay($order_id,$giftname,$amount,$body,$showUrl);
            echo $html;die;

        }
    }


    /**
     * 处理支付异步通知
     * @param $data 接收到的支付宝返回的数据
     * @return bool
     */
    public static function notify($data)
    {
        $alipay = new AlipayPay();

        //验证支付通知
        $verify_result = $alipay->verifyNotify();
        if ($verify_result) {
            //发送给支付宝的本站订单号,原封不动返回
            $out_trade_no = $data['extra_common_param'];
            //支付宝交易凭证号
            $trade_no = $data['trade_no'];
            /**
             * 交易目前所属的状态
             * WAIT_BUYER_PAY	交易创建，等待买家付款
             * TRADE_CLOSED	    未付款交易超时关闭，或支付完成后全额退款
             * TRADE_SUCCESS	交易支付成功
             * TRADE_FINISHED	交易结束，不可退款
             */
            $trade_status = $data['trade_status'];

            //本订单状态先默认为 未付款
            $status = Order::PAYNO;

            if ($trade_status == 'TRADE_FINISHED' || $trade_status == 'TRADE_SUCCESS') {
                //支付成功 更改订单状态
                $status = Order::PAYSUCCESS;
                $order_info = Order::findOne($out_trade_no);
                if (!$order_info) {
                    return false;
                }
                //如果订单是未付款的话,更改订单状态 并保存到数据库
                if ($order_info->status == Order::PAYNO) {
                    Order::updateAll([
                        'status' => $status,
                        'trade_no' => $trade_no,
                        'trade_text' => json_encode($data)
                        ],['id'=>$order_info->id]);
                } else {
                    return false;
                }
            }
            return true;
        } else {
            return false;
        }
    }



}