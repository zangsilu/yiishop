<?php
/**
 * Created by PhpStorm.
 * User: MBENBEN
 * Date: 2016/8/21
 * Time: 23:03
 */
namespace app\admin\models;

use Yii;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;

class Admin extends ActiveRecord implements IdentityInterface {

    //定义一个admin表中没有的字段("记住我"),用于创建表单
    public $rememberMe = false;//默认不"记住我";
    public $repass;//确认密码(重置密码使用)

    public static function tableName()
    {
        return "{{%admin}}";
    }

    /* label字段名(显示于表单{label}) */
    public function attributeLabels()
    {
        return [
          'admin_user'=>'管理员名称',
          'admin_email'=>'管理员邮箱',
          'admin_pass'=>'管理员密码',
          'repass'=>'确认密码',
        ];
    }


    /* 验证规则(显示于表单{error}) */
    public function rules()
    {
        return [
            ['admin_user','required','message'=>'用户名不能为空!','on'=>['login','seekpass','changepass','add','changeemail']],
            ['admin_user','unique','message'=>'用户名已存在!','on'=>['add']],
            ['admin_pass','required','message'=>'密码不能为空!','on'=>['login','changepass','add','changeemail']],
            ['repass','required','message'=>'确认密码不能为空!','on'=>['changepass','add']],
            ['rememberMe','boolean','on'=>'login'],
            ['admin_pass','validatePass','on'=>['changeemail']],
            ['admin_email','required','message'=>'邮箱不能为空!','on'=>['seekpass','add','changeemail']],
            ['admin_email','email','message'=>'邮箱格式不正确!','on'=>['seekpass','add','changeemail']],
            ['admin_email','unique','message'=>'邮箱已存在!','on'=>['add','changeemail']],
            ['admin_email','validateEmail','on'=>'seekpass'],
            ['repass','compare','compareAttribute'=>'admin_pass','message'=>'2次密码不一致!','on'=>'changepass'],

        ];
    }

    /* 自定义验证密码 */
    public function validatePass(){

        //如果前面没有错误
        if(!$this->hasErrors()){
            $data = self::find()->where('admin_user=:user and admin_pass=:pass',[':user'=>$this->admin_user,':pass'=>md5($this->admin_pass)])->one();

            if(is_null($data)){
                $this->addError('admin_pass','用户名或密码错误!');
            }
        }
    }

    /* 自定义验证邮箱 */
    public function validateEmail(){

        //如果前面没有错误
        if(!$this->hasErrors()){
            $re = self::find()->where("admin_user = '{$this->admin_user}' and admin_email = '{$this->admin_email}'")->one();
            if(is_null($re)){
                $this->addError('admin_email','管理员邮箱不匹配!');
            }
        }

    }

    /* 管理员添加 */
    public function add($data){

        //验证规则作用域名称
        $this->scenario = 'add';

        //如果载入成功,并且验证成功
        if($this->load($data) && $this->validate()){

            //密码MD5加密
            $this->admin_pass = md5($this->admin_pass);
            //记录添加时间
            $this->admin_create_time = time();

            //如果添加成功返回true ($this->save(false) false的意思是不进行验证了,因为save()方法默认会走一次验证规则)
            if($this->save(false)){
                return true;
            }
        }
        return false;
    }

    /* 管理员登录(执行验证,写入session) */
    public function login($data){
        //起个验证规则的作用域名称
        $this->scenario='login';
        //如果载入成功,并且验证成功
        if($this->load($data) && $this->validate()){
            /*//判断是否勾选"记住密码";
            $liftTime=$this->rememberMe ? 24*3600 : 0;
            //实例化session组件
            $session = \Yii::$app->session;
            //设置session的过期时间
            session_set_cookie_params($liftTime);
            //数据存入session
            $session['admin']=[
                'admin_user'=>$this->admin_user,
                'isLogin' => 1,
            ];*/

            /**
             * 使用admin用户组件实现登入
             */
            $result = Yii::$app->admin->login($this->getAdmin(),$this->rememberMe ? 24*3600*7 : 0);
            if($result){
                //更新登入时间与登入ip
                self::updateAll(['admin_login_time'=>time(),'admin_login_ip'=>ip2long(Yii::$app->request->userIP)],'admin_user=:user',[':user' =>$this->admin_user]);
                //返回bool
                return true;
            }
            $this->addError('admin_pass','用户名或密码错误!');
        }
        return false;
    }

    public function getAdmin()
    {
        return self::findOne(['admin_user'=>$this->admin_user,'admin_pass'=>md5($this->admin_pass)]);
    }

    /* 找回密码 */
    public function seekpass($data){

        //起个验证规则的作用域名称
        $this->scenario='seekpass';

        //如果验证成功,那么就发送邮件
        if($this->load($data) && $this->validate()){
            //设置邮件发送的内容模板
            $mailer = Yii::$app->mailer->compose('layouts/seekpass',[
                'admin_user'=>$this->admin_user,
                'timestamp' =>time(),
                'token' =>$this->createToken(time(),$this->admin_user)
            ])
            ->setFrom(Yii::$app->params['defaultValue']['admin_email'])
            ->setTo($this->admin_email)
            ->setSubject('木瓜商城-密码找回');
            if($mailer->send()){
                Yii::$app->session->setFlash('info','邮件发送成功,请查收!');
            }
        }
        return false;
    }

    /* 创建邮箱验证token */
    public function createToken($time,$user){

        $userIp = Yii::$app->request->userIP;
        return md5($time.$user.base64_encode($userIp));

    }

    /* 修改密码(重置密码) */
    public function changepass($data){

        $this->scenario = 'changepass';

        if($this->load($data) && $this->validate()){
            
            return (bool)$this->updateAll(['admin_pass'=>md5($this->admin_pass)],'admin_user = :user',[':user'=>$this->admin_user]);

        }
        return false;

    }

    /* 修改管理员邮箱 */
    public function changeemail($data){

        $this->scenario = 'changeemail';

        if($this->load($data) && $this->validate()){

            return (bool)$this->updateAll(['admin_email'=>$this->admin_email],'admin_user = :user',[':user'=>$this->admin_user]);
        }
        return false;
    }

    public static function findIdentity($id)
    {
        return static::findOne($id);
    }

    public static function findIdentityByAccessToken($token, $type = null)
    {
        return null;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getAuthKey()
    {
        return null;
    }

    public function validateAuthKey($authKey)
    {
        return true;
    }
}