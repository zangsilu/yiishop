<?php
/**
 * User: 张世路
 * Date: 2016/10/5
 * Time: 22:22
 */

namespace app\admin\controllers;

use app\models\Category;
use Yii;
use yii\base\Exception;
use yii\behaviors\TimestampBehavior;
use yii\web\MethodNotAllowedHttpException;
use yii\web\Response;

class CategoryController extends BaseController
{
    
    
    public $layout = 'admin_layout';
    
    public function actionList()
    {
        
        $model = new Category();
        $list = $model->getOption();
        
        return $this->render('list', compact('list'));
        
    }
    
    
    public function actionAdd()
    {
        $model = new Category();
        $list = $model->getOption();
        
        if (Yii::$app->request->isPost) {
            $post = Yii::$app->request->post();
            if ($model->add($post)) {
                Yii::$app->session->setFlash('info', '添加成功!');
                $this->redirect(['category/list']);
            } else {
                Yii::$app->session->setFlash('info', '添加失败!');
            }
        }
        
        return $this->render('add', compact('model', 'list'));
    }
    
    
    public function actionEdit()
    {
        $id = Yii::$app->request->get('id');
        
        $model = Category::findOne($id);
        $list = $model->getOption();
        
        if (Yii::$app->request->isPost) {
            if ($model->load(Yii::$app->request->post()) && $model->save()) {
                Yii::$app->session->setFlash('info', '修改成功!');
            }
        }
        return $this->render('add', compact('model', 'list'));
    }
    
    
    public function actionDel()
    {
        try {
            $id = Yii::$app->request->get('id');
            if (empty($id)) {
                throw new Exception('id不存在!');
            }
            //有子分类的分类不允许删除
            $r = Category::find()->where(['pid' => $id])->one();
            if ($r) {
                throw new Exception('当前分类还有子分类,不允许删除!');
            }
            if (!Category::deleteAll(['id' => $id])) {
                throw new Exception('删除失败!');
            }
            
            
        } catch (Exception $e) {
            Yii::$app->session->setFlash('info', $e->getMessage());
            return $this->redirect(['category/list']);
        }
        Yii::$app->session->setFlash('info', '删除成功!');
        return $this->redirect(['category/list']);
    }
    
    
    /**
     * 获取分类树,用于js_tree插件显示
     * @return array
     */
    public function actionTree()
    {
//        $data = ["id" => 1, "text" => "服装", "children" =>[]];
        
        //指定返回json数据
        Yii::$app->response->format = Response::FORMAT_JSON;
        
        //获取数据
        $data = Category::getCategoryTreeList();
        
        return $data['data'] ?: [];
    }
    
    /**
     * ajax修改分类名称,用于js_tree插件
     */
    public function actionRename()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        
        if (!Yii::$app->request->isAjax) {
            throw  new MethodNotAllowedHttpException('access denied');
        }
        
        $newText = Yii::$app->request->post('newText');
        $oldText = Yii::$app->request->post('oldText');
        $id = Yii::$app->request->post('id');
        
        if (empty($newText)) {
            return ['code' => -1, 'message' => '参数错误'];
        }
        
        if ($newText == $oldText) {
            return ['code' => 0, 'message' => 'ok'];
        }
        
        $categoryModel = Category::findOne($id);
        $categoryModel->scenario = 'rename';
        $categoryModel->title = $newText;
        if ($categoryModel->save()) {
            return ['code' => 0, 'message' => 'ok'];
        }
        return ['code' => -1, 'message' => '修改失败'];
    }
    
    /**
     * ajax删除分类,用于js_tree插件
     */
    public function actionDelete()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        
        try {
            $id = Yii::$app->request->get('id');
            if (empty($id)) {
                throw new Exception('id不存在!');
            }
            //有子分类的分类不允许删除
            $r = Category::find()->where(['pid' => $id])->one();
            if ($r) {
                throw new Exception('当前分类还有子分类,不允许删除!');
            }
            if (!Category::deleteAll(['id' => $id])) {
                throw new Exception('删除失败!');
            }
            
            
        } catch (Exception $e) {
            return ['code' => -1, 'message' => $e->getMessage()];
        }
        return ['code' => 0, 'message' => 'ok'];
    }
    
    /**
     * ajax添加分类,用于js_tree插件
     */
    public function actionAddChild()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        
        $model = new Category();
        
        if (Yii::$app->request->isPost) {
            $post = Yii::$app->request->post();
            if ($model->add($post)) {
                return ['code' => 0, 'message' => 'ok'];
            }
            return ['code' => -1, 'message' => '添加失败'];
        }
    }
}