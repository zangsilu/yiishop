<?php
/**
 * Created by PhpStorm.
 * User: MBENBEN
 * Date: 2016/8/21
 * Time: 13:07
 */

//用户模型类
namespace app\models;

use yii\db\ActiveRecord;

class Users extends ActiveRecord{

    public static function tableName()
    {
        //指定该模型映射的表名{{%}}写法表示自动调用/config/db.php里设置的表前缀;
        return "{{%user}}";
    }

}