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

class User extends ActiveRecord{

    public $repass;//确认密码;

    public static function tableName()
    {
        //指定该模型映射的表名{{%}}写法表示自动调用/config/db.php里设置的表前缀;
        return "{{%user}}";
    }

    /* label字段名(显示于表单{label}) */
    public function attributeLabels()
    {
        return [
            'username'=>'用户名',
            'useremail'=>'电子邮箱',
            'userpass'=>'用户密码',
            'repass'=>'确认密码',
        ];
    }

    /* 验证规则(显示于表单{error}) */
    public function rules()
    {
        return [
            ['username','required','message'=>'用户名不能为空!','on'=>['addUser']],
            ['username','unique','message'=>'用户名已存在!','on'=>['addUser']],
            ['userpass','required','message'=>'密码不能为空!','on'=>['addUser']],
            ['repass','required','message'=>'确认密码不能为空!','on'=>['addUser']],
//            ['rememberMe','boolean','on'=>'login'],
//            ['userpass','validatePass','on'=>['addUser']],
            ['useremail','required','message'=>'邮箱不能为空!','on'=>['addUser']],
            ['useremail','email','message'=>'邮箱格式不正确!','on'=>['addUser']],
            ['useremail','unique','message'=>'邮箱已存在!','on'=>['addUser']],
//            ['admin_email','validateEmail','on'=>'seekpass'],
            ['repass','compare','compareAttribute'=>'userpass','message'=>'2次密码不一致!','on'=>'addUser'],

        ];
    }

    /* 添加会员 */
    public function addUser($data){

        $this->scenario = 'addUser';

        if($this->load($data) && $this->validate()){

            $this->createtime = time();
            $this->userpass = md5($this->userpass);
            
            if($this->save(false)){
                return true;
            }
            return false;
        }
        return false;

    }

}