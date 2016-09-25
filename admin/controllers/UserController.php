<?php
/**
 * User: 张世路
 * Date: 2016/9/17
 * Time: 21:56
 */

namespace app\admin\controllers;

use app\models\Profile;
use yii\data\Pagination;
use yii\helpers\Url;
use yii\web\Controller;
use app\models\User;
use Yii;

class UserController extends BaseController{

    public $layout = 'admin_layout';

    /* 添加新会员 */
    public function actionAdd(){

        $user = new User();

        if(Yii::$app->request->isPost){

            $post = Yii::$app->request->post();

            if($user -> addUser($post)){

                Yii::$app->session->setFlash('info','会员添加成功!');
            }

        }

        $user ->username = '';
        $user ->useremail = '';
        $user ->userpass = '';
        $user ->repass = '';
        return $this->render('add',compact('user'));

    }

    /* 会员列表 */
    public function actionList(){

     /*  $users = User::find()->select('u.username,p.*')->alias('u')
            ->leftJoin(Profile::tableName() .'p','u.id = p.user_id');*/

        $users = User::find()->joinWith('profile');

        //分页
        $count = $users ->count();
        $pageSize = Yii::$app->params['pageSize']['user'];
        $page = new Pagination(['totalCount'=>$count,'pageSize'=>$pageSize]);
        $users = $users->offset($page->offset)->limit($page->limit)->all();

        return $this->render('list',compact('users','page'));
}

    /* 删除用户(必须用户表和用户详情表的数据都删除成功,才算删除成功,否则回滚) */
    public function actionDel(){

        //用户id
        $user_id = (int)Yii::$app->request->get('user_id');

        try{

            //如果用户ID不存在抛错
            if(empty($user_id)){
                throw new \Exception();
            }

            //启动事务
            $trans = Yii::$app->db->beginTransaction();

            //先删除用户详情表中的这条记录
            if($obj = Profile::find()->where(['user_id'=>$user_id])->one()){
                $res = $obj -> deleteAll(['user_id'=>$user_id]);
                if(empty($res)){
                    throw new \Exception;
                }
            }

            //再删除用户表的这条记录
            if(!$res = User::deleteAll(['id'=>$user_id])){
                throw new \Exception;
            }

            //如果2个都删除成功了,那么事务提交
            $trans ->commit();

            //添加一条删除成功的消息
            Yii::$app->session->setFlash('info','删除成功!');

        }catch (\Exception $e){

            if(Yii::$app->db->getTransaction()){
                $trans->rollBack();
            }

        }

        //程序走完后,跳回用户列表
        $this->redirect(['user/list','a'=>10]);
    }



}