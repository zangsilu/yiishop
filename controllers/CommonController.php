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

use Yii;
use yii\caching\DbDependency;
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
        /**
         * 判断redis缓存中是否存在菜单,有就从缓存中取,没有就从DB里取
         */
        $cache = Yii::$app->cache;
        $menu = $cache->get('menu');
        if(empty($menu)){
            $menu = Category::getMenu();
            $cache->set('menu',$menu,60);
        }


        //存放在view对象的params里这样在每个view层里都可以通过$this->params[]获取到
        $this->view->params['menu'] = $menu;

        /**
         * 缓存依赖
         */
        $dep = new DbDependency([
           'sql' => "SELECT MAX(updated_at) FROM {{%goods}}"
        ]);

        //取出推荐、最新、热卖商品(有查询缓存)
        $this->view->params['tui'] = Goods::getDb()->cache(function (){
            return Goods::find()->where(['ison'=>1,'istui'=>1])->orderBy('created_at desc')->limit(4)->all();
        },60,$dep);
        $this->view->params['new'] = Goods::getDb()->cache(function (){
            return Goods::find()->where(['ison'=>1])->orderBy('created_at desc')->limit(4)->all();
        },60,$dep);
        $this->view->params['hot'] = Goods::getDb()->cache(function (){
            return Goods::find()->where(['ison'=>1,'is_hot'=>1])->orderBy('created_at desc')->limit(4)->all();
        },60,$dep);

        $this->view->params['menu'] = $menu;

    }
}