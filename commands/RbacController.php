<?php

namespace app\commands;

use Yii;
use yii\console\Controller;

/**
 * User: 张世路
 * Date: 2017/4/23
 * Time: 21:23
 */
class RbacController extends Controller
{
    /**
     * 初始化权限列表
     */
    public function actionInit()
    {
        $transaction = Yii::$app->db->beginTransaction();
        try {
            /**
             * 获取后台所有控制器文件
             */
            $controllersDir = dirname(dirname(__FILE__)) . '/admin/controllers';
            $controllers = glob($controllersDir . '/*');

            /**
             * 获取所有 控制器/方法
             */
            $permissions = [];
            foreach ($controllers as $k => $v) {
                $file = file_get_contents($v);
                preg_match('/class ([a-zA-Z]+)Controller/', $file, $value);
                $cName = strtolower($value[1]);
                $permissions[] = $cName . '/*';
                preg_match_all('/public function action([a-zA-Z_]+)/', $file,
                    $values);
                foreach ($values[1] as $k => $v) {
                    $permissions[] = $cName . '/' . strtolower($v);
                }
            }

            /**
             * 判断权限是否已存在了,没存在就重新插入
             */
            $auth = Yii::$app->authManager;
            foreach ($permissions as $k => $v) {
                if (!$auth->getPermission($v)) {
                    $obj = $auth->createPermission($v);
                    $obj->description = $v;
                    $auth->add($obj);
                }
            }
            $transaction->commit();
            echo 'ok';
        } catch (\Exception $e) {
            $transaction->rollBack();
            echo 'failed';
        }
    }

}