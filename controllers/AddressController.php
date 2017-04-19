<?php
/**
 * User: 张世路
 * Date: 2016/11/6
 * Time: 22:17
 */

namespace app\controllers;

use app\models\Address;
use app\models\User;
use yii;
use yii\filters\AccessControl;

class AddressController extends CommonController
{

    public function behaviors()
    {
        return array_merge([
            'accessFilter' => [
                'class'  => AccessControl::className(),
                'only'   => ['*'],//不设置或设置为空或"*"表示所有方法都受管制
                'except' => [],//除此之外
                'rules'  => [
                    [
                        'allow'   => false,//不允许访问
                        'actions' => [],// 不设置或设置为空表示所有,如果要限制单独某些方法,直接写方法名字
                        'roles'   => ['?'],// ? 表示 guest 未登入的
                    ],
                    [
                        'allow'   => true,//允许访问
                        'actions' => [],//不设置或设置为空表示所有,如果要限制单独某些方法,直接写方法名字
                        'roles'   => ['@'],// @ 表示 登入用户
                    ],
                ],
            ],
        ], parent::behaviors());
    }

    /**
     * 添加收货人
     */
    public function actionAdd()
    {
        if(Yii::$app->request->isPost){
            $post = yii::$app->request->post();
            $post['Address']['address'] = $post['Address']['address1'].$post['Address']['address2'];
            $post['Address']['user_id'] = User::find()->where(['useremail'=>Yii::$app->session['username']])->one()->id;

            $addressModel = new Address();
            if($addressModel->load($post) && $addressModel->save()){
                return $this->redirect($_SERVER['HTTP_REFERER']);
            }
            Yii::$app->session->setFlash('info',$addressModel->getFirstErrors());
            return $this->redirect($_SERVER['HTTP_REFERER']);
        }
    }

    /**
     * 删除收货人
     */
    public function actionDel()
    {
        if(Yii::$app->request->isAjax){
            $delAddress_id = Yii::$app->request->get('delAddress_id');
            $addressModel = Address::findOne($delAddress_id);
            $addressModel->delete();
        }
    }

}