<?php

namespace app\models;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "{{%goods}}".
 *
 * @property string $id
 * @property string $cid
 * @property string $goods_name
 * @property string $goods_desc
 * @property integer $goods_num
 * @property string $goods_price
 * @property string $goods_img
 * @property string $goods_pics
 * @property integer $is_promote
 * @property string $promote_price
 * @property integer $is_hot
 * @property integer $created_at
 * @property integer $updated_at
 */
class Goods extends \yii\db\ActiveRecord
{

    const accessKey = 'E7zfPclIPtfoQwF6_0vkHmOqZ1c9RnCvEAPbfV3Q';
    const secretKey = '9U3BreLGvnxobFyQr6US82Q-xBSrKrirRdW1A1nq';
    const DOMAIN = 'oemo6pq6s.bkt.clouddn.com';
    const BUCKET = 'yiishop';

    public function behaviors()
    {
        return[
            TimestampBehavior::className(),
        ];
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%goods}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['goods_name', 'required', 'message' => '标题不能为空'],
            ['cid', 'required', 'message' => '分类不能为空'],
            ['goods_price', 'required', 'message' => '单价不能为空'],
            [['goods_price','promote_price'], 'number', 'min' => 0.01, 'message' => '价格必须是数字'],
            ['goods_num', 'integer', 'min' => 0, 'message' => '库存必须是数字'],
            [['is_promote','goods_img','is_hot', 'goods_price', 'istui','ison','goods_pics','goods_desc'],'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'cid' => '分类名称',
            'goods_name' => '商品名称',
            'goods_desc' => '商品描述',
            'goods_num' => '商品库存',
            'goods_price' => '商品价格',
            'goods_img' => '商品封面图片',
            'goods_pics' => '商品图片',
            'is_promote' => '是否促销',
            'promote_price' => '促销价格',
            'is_hot' => '是否热卖',
            'ison' => '是否上架',
            'istui' => '是否推荐',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }
}
