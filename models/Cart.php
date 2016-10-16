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
class Cart extends \yii\db\ActiveRecord
{


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
        return '{{%cart}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['goods_id', 'required', 'message' => '商品ID不能为空'],
            ['username', 'required', 'message' => '用户名不能为空'],
            ['goods_num', 'required', 'message' => '商品数量不能为空'],
        ];
    }

}
