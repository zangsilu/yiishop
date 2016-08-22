<?php
/**
 * Created by PhpStorm.
 * User: MBENBEN
 * Date: 2016/8/21
 * Time: 23:03
 */
namespace app\admin\models;

use yii\db\ActiveRecord;

class Admin extends ActiveRecord{

    //定义一个admin表中没有的字段("记住我"),用于创建表单
    public $rememberMe = false;//默认不"记住我";

    public static function tableName()
    {
        return "{{%admin}}";
    }

}