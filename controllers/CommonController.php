<?php
/**
 * User: 张世路
 * Date: 2016/10/16
 * Time: 21:45
 */

/* 公共控制器 */
namespace app\controllers;

use app\models\Category;
use yii\web\Controller;

class CommonController extends Controller
{
    //该方法在调用每个继承该类的方法时自动执行
    public function init()
    {
        $menu = Category::getMenu();
        $this->view->params['menu'] = $menu;
    }
}