<?php
/**
 * User: 张世路
 * Date: 2016/10/16
 * Time: 21:45
 */

/* 公共控制器 */
namespace app\controllers;

use app\models\Category;

use app\models\Goods;

use yii\filters\VerbFilter;
use yii\web\Controller;

class CommonController extends Controller
{

    protected $verbs = [];

    public function behaviors()
    {
        return array_merge(parent::behaviors(),[
          'verbFilter' => [
            'class' => VerbFilter::className(),
              'actions' => $this->verbs,
          ],
        ]);
    }

    //该方法在调用每个继承该类的方法时自动执行
    public function init()
    {
        $menu = Category::getMenu();


        //存放在view对象的params里这样在每个view层里都可以通过$this->params[]获取到
        $this->view->params['menu'] = $menu;

        //取出推荐、最新、热卖商品
        $this->view->params['tui'] = Goods::find()->where(['ison'=>1,'istui'=>1])->orderBy('created_at desc')->limit(4)->all();
        $this->view->params['new'] = Goods::find()->where(['ison'=>1])->orderBy('created_at desc')->limit(4)->all();
        $this->view->params['hot'] = Goods::find()->where(['ison'=>1,'is_hot'=>1])->orderBy('created_at desc')->limit(4)->all();



        $this->view->params['menu'] = $menu;

    }
}