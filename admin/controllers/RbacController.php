<?php
/**
 * User: 张世路
 * Date: 2016/11/26
 * Time: 22:39
 */

namespace app\admin\controllers;

use app\admin\models\Rbac;
use Yii;
use yii\data\ActiveDataProvider;
use yii\db\Query;

class RbacController extends BaseController
{
    public $layout = 'admin_layout';

    /**
     * 角色列表
     */
    public function actionIndex()
    {
        $auth = Yii::$app->authManager;
        $data = new ActiveDataProvider([
            'query'      => (new Query)->from($auth->itemTable)
                ->where(['type' => 1])->orderBy('created_at desc'),
            'pagination' => [
                'pageSize' => 10,
            ],
        ]);
        return $this->render('_items', ['dataProvider' => $data]);
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

    /**
     * 删除角色
     */
    public function actionDelete()
    {
        $name = Yii::$app->request->get('name');
        $auth = Yii::$app->authManager;

        if($auth->remove($auth->getRole($name))){
            $this->redirect(['rbac/index']);
        }
    }

    /**
     * 分配权限
     *
     * @param $name
     *
     * @return string
     */
    public function actionAssignitem($name)
    {
        $name = htmlspecialchars($name);
        $auth = Yii::$app->authManager;
        $parent = $auth->getRole($name);

        if (Yii::$app->request->isPost) {
            $post = Yii::$app->request->post();
            if (Rbac::addChild($post['children'], $name)) {
                Yii::$app->session->setFlash('info', '分配成功');
            }
        }

        //获取该角色所拥有的角色或权限
        $children = Rbac::getChildrenByName($name);

        $roles = Rbac::getOptions($auth->getRoles(), $parent);
        $permissions = Rbac::getOptions($auth->getPermissions(), $parent);

        return $this->render('_assignitem', [
            'parent'      => $parent,
            'roles'       => $roles,
            'permissions' => $permissions,
            'children'    => $children,
        ]);
    }


}
