<?php

namespace app\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "{{%address}}".
 *
 * @property string $id
 * @property string $user_id
 * @property string $shou_name
 * @property string $address
 * @property integer $phone
 * @property string $created_at
 * @property string $updated_at
 */
class Address extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%address}}';
    }

    public function behaviors()
    {
        return[
            TimestampBehavior::className(),
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'phone', 'created_at', 'updated_at'], 'integer'],
            [['shou_name'], 'string', 'max' => 64],
            [['address'], 'string', 'max' => 512],
            [['zipcode'], 'string', 'max' => 6],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'shou_name' => 'Shou Name',
            'address' => 'Address',
            'phone' => 'Phone',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }
}
