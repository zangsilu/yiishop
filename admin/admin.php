<?php

namespace app\admin;

use yii\base\Module;

/**
 * admin module definition class
 */
class admin extends Module
{
    /**
     * @inheritdoc
     */
    public $controllerNamespace = 'app\admin\controllers';

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();

        // custom initialization code goes here
    }
}
