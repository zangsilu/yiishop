<?php
/**
 * User: 张世路
 * Date: 2016/11/26
 * Time: 22:39
 */

namespace app\admin\controllers;

use Yii;

class RbacController extends BaseController
{
    public $layout = 'admin_layout';

    /**
     * 角色列表
     */
    public function actionIndex()
    {

    }

    /**
     * 添加角色
     */
    public function actionCreate()
    {
        if (Yii::$app->request->isPost) {
            $post = Yii::$app->request->post();
            if (empty($post['name']) || empty($post['description'])) {
                Yii::$app->session->setFlash('info', '参数错误!');
            } else {
                $authManager = Yii::$app->authManager;
                //创建一个角色对象
                $role = $authManager->createRole(null);
                $role->name = $post['name'];
                $role->description = $post['description'];
                $role->ruleName = empty($post['rule_name']) ? null
                    : $post['rule_name'];
                $role->data = empty($post['data']) ? null : $post['data'];
                if ($authManager->add($role)) {
                    Yii::$app->session->setFlash('info', '角色添加成功!');
                }
            }
        }
        return $this->render('_createItem');
    }
}
