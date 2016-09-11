<?php

namespace app\admin\controllers;

use yii\web\Controller;

/**
 * Default controller for the `admin` module
 */
class DefaultController extends Controller
{
    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {
        if(!\Yii::$app->session->has('admin')){
            $this->redirect(['public/login']);
        }

        $this->layout = 'admin_layout';
        return $this->render('index');
    }
}
