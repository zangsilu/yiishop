<?php

namespace app\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "{{%order}}".
 *
 * @property string  $id
 * @property string  $user_id
 * @property string  $address_id
 * @property string  $express_id
 * @property string  $express_no
 * @property string  $amount
 * @property integer $status
 * @property string  $payType
 * @property string  $created_at
 * @property string  $updated_at
 */
class Order extends ActiveRecord
{

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%order}}';
    }

    public function behaviors()
    {
        return [
            TimestampBehavior::className(),
        ];
    }

    //0:未付款 1:已付款 2:已发货 3:已确认收货 4:已退货退款 5:订单完成
    const PAYNO = 0;
    const PAYSUCCESS = 1;
    const SENDED = 2;
    const TUIYES = 4;
    const DONE = 5;

    public static $status
        = [
            self::PAYNO      => '未付款',
            self::PAYSUCCESS => '已付款',
            self::SENDED     => '已发货',
            self::TUIYES     => '已退货退款',
            self::DONE       => '订单完成',
        ];

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [
                ['user_id', 'address_id', 'status', 'created_at', 'updated_at'],
                'integer',
            ],
            [['amount'], 'number'],
            [['express_no'], 'string', 'max' => 60],
            [['express', 'payType'], 'string', 'max' => 24],
            [['trade_no', 'trade_text'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id'         => 'ID',
            'user_id'    => 'User ID',
            'address_id' => 'Address ID',
            'express_id' => 'Express ID',
            'express_no' => 'Express No',
            'amount'     => 'Amount',
            'status'     => 'Status',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }
}
