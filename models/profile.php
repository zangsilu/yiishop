<?php
/**
 * User: 张世路
 * Date: 2016/9/25
 * Time: 15:25
 */

namespace app\models;

use yii\db\ActiveRecord;

class Profile extends ActiveRecord{

    public static function tableName()
    {
        return "{{%profile}}";
    }



}