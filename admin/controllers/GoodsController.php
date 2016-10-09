<?php
/**
 * User: 张世路
 * Date: 2016/10/6
 * Time: 18:26
 */

namespace app\admin\controllers;
use app\models\Category;
use app\models\Goods;
use crazyfd\qiniu\Qiniu;
use Yii;
use yii\data\Pagination;
use yii\helpers\ArrayHelper;

class GoodsController extends BaseController{

    public $layout = 'admin_layout';

    public function actions()
    {
        return [
            'upload' => [
                'class' => 'kucha\ueditor\UEditorAction',
                'config' => [
                    "imageUrlPrefix"  => "http://yiishop.com/",//图片访问路径前缀
                    "imagePathFormat" => "/upload/image/{yyyy}{mm}{dd}/{time}{rand:6}" //上传保存路径
                ],
            ]
        ];
    }

    public function actionList()
    {
        $model = Goods::find();
        $totalCount = $model->count();
        $pageSize = Yii::$app->params['pageSize']['goods'];
        $pager =new Pagination(['totalCount'=>$totalCount,'pageSize'=>$pageSize]);
        $data = $model->offset($pager->offset)->limit($pager->limit)->all();

        return $this->render('list',compact('data','pager'));

    }

    public function actionAdd()
    {
        $model = new Goods();
        $category = new Category();
        $list = $category -> getOption();
        unset($list[0]);

        if(Yii::$app->request->isPost){
            $post = Yii::$app->request->post();
            $pics = $this ->uploads();
            if(!$pics){
                $model->addError('goods_img','商品封面不能为空!');
            }else{
                $post['Goods']['goods_img']=$pics['goods_img'];
                $post['Goods']['goods_pics']=$pics['goods_pics'];
                if($model->load($post) && $model->save()){
                    Yii::$app->session->setFlash('info','商品添加成功!');
                }else{
                    Yii::$app->session->setFlash('info','商品添加失败!');
                }
            }

        }
        return $this->render('add',compact('model','list'));
    }


    /*使用七牛云存储做图片服务器,将图片上传至七牛云*/
    private function uploads()
    {
        $goods_img = null;
        $pics= null;
        //实例化七牛类
        $qiniu =new Qiniu(Goods::accessKey,Goods::secretKey,Goods::DOMAIN,Goods::BUCKET);

        //上传封面
        if($_FILES['Goods']['error']['goods_img'] == 0){

        //创建一个唯一key
        $key = uniqid();
        //上传
        $qiniu->uploadFile($_FILES['Goods']['tmp_name']['goods_img'],$key);
        //获取上传成功后的图片路径
        $goods_img = $qiniu->getLink($key);
        }

        //循环上传商品图片
        if(!empty($_FILES['Goods']['tmp_name']['goods_pics'])){
            $pics = [];
            foreach($_FILES['Goods']['tmp_name']['goods_pics'] as $k=>$v){
                //当前图片有错误,则跳出循环
                if($_FILES['Goods']['error']['goods_pics'][$k] > 0){
                    continue;
                }
                $key = uniqid();//唯一数,用于图片的下标
                $qiniu->uploadFile($_FILES['Goods']['tmp_name']['goods_pics'][$k],$key);
                $pics[$key] = $qiniu->getLink($key);
            }
        }
        return ['goods_img'=>$goods_img,'goods_pics'=>json_encode($pics)];
    }

    /* 商品编辑 */
    public function actionEdit($id){

        $model = Goods::findOne($id);
        $category = new Category();
        $list = $category -> getOption();

        if(Yii::$app->request->isPost){
            $post = Yii::$app->request->post();

            //先上传下图片
            $img = $this->uploads();
            //有新封面图片的话就为新图片,否则就为老图片
            if(!empty($img['goods_img'])){
                $post['Goods']['goods_img'] = $img['goods_img'];
            }else{
                $post['Goods']['goods_img'] = $model->goods_img;
            }

            $post['Goods']['goods_pics'] = json_encode(array_filter(array_merge((array)json_decode($model->goods_pics,true),(array)json_decode($img['goods_pics']))));

            if($model->load($post) && $model->save()){
                Yii::$app->session->setFlash('info','修改成功!');
                $this->redirect(['goods/list']);
            }else{
                Yii::$app->session->setFlash('info','修改失败!');
            }
        }

        return $this->render('edit',compact('model','list'));
    }

    /* 删除商品图片 */
    public function actionDel_pics()
    {
        $key = Yii::$app->request->get('key');
        $goods_id = Yii::$app->request->get('goods_id');

        //先删除七牛云上的图片
        $qiniu = new Qiniu(Goods::accessKey,Goods::secretKey,Goods::DOMAIN,Goods::BUCKET);
        $qiniu->delete($key);

        //再删除本地数据库保存的图片路径,再保存回去
        $model = Goods::findOne($goods_id);
        $pics = json_decode($model->goods_pics,true);
        unset($pics[$key]);
        Goods::updateAll(['goods_pics'=>json_encode($pics)],['id'=>$goods_id]);
        $this->redirect(['goods/edit','id'=>$goods_id]);
    }

    /* 删除商品 */
    public function actionDel()
    {
        $id =Yii::$app->request->get('id');
        $model = Goods::findOne($id);

        //先删除七牛云上的图片
        $qiniu = new Qiniu(Goods::accessKey,Goods::secretKey,Goods::DOMAIN,Goods::BUCKET);
        $goods_img = basename($model->goods_img);
        $qiniu->delete($goods_img);
        $goods_pics = json_decode($model->goods_pics,true);
        if(!empty($goods_pics)){
            foreach($goods_pics as $k=>$v){
                $qiniu->delete($k);
            }
        }
        //再删除本地数据
        $model->delete();

        //跳回列表
        $this->redirect(['goods/list']);
    }

    /* 上架 */
    public function actionOn(){
        $id = Yii::$app->request->get('id');
        $model = Goods::findOne($id);
        $model->updateAll(['ison'=>1],['id'=>$id]);
        $this->redirect(['goods/list']);
    }

    /* 下架 */
    public function actionOff(){
        $id = Yii::$app->request->get('id');
        $model = Goods::findOne($id);
        $model->updateAll(['ison'=>0],['id'=>$id]);
        $this->redirect(['goods/list']);
    }




}