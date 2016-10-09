<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

?>


<link rel="stylesheet" href="<?php echo \yii\helpers\Url::home(true) ?>assets/admin/css/compiled/user-list.css" type="text/css" media="screen" />


<!-- main container -->
<div class="content">
    <div class="container-fluid">
        <div id="pad-wrapper" class="users-list">
            <div class="row-fluid header">
                <h3>分类列表</h3>
                <p>
                    <?php
                    if(Yii::$app->session->hasFlash('info')){
                        echo Yii::$app->session->getFlash('info');
                    }
                    ?>
                </p>
                <div class="span10 pull-right">
                    <a href="<?= \yii\helpers\Url::to(['category/add']) ?>" class="btn-flat success pull-right">
                        <span>&#43;</span>添加新分类</a></div>
            </div>
            <!-- Users table -->
            <div class="row-fluid table">
                <table class="table table-hover">
                    <thead>
                    <tr>
                        <th class="span3 sortable">
                            <span class="line"></span>分类ID</th>
                        <th class="span3 sortable">
                            <span class="line"></span>分类名称</th>
                        <th class="span3 sortable align-right">
                            <span class="line"></span>操作</th>
                    </tr>
                    </thead>
                    <tbody>
                    <!-- row -->
                    <?php foreach($list as $k=>$v): ?>
                    <tr class="first">
                        <td><?= $k ?></td>
                        <td><?= $v ?></td>
                        <td class="align-right">
                            <?php if($k != 0): ?>
                                <a href="<?= \yii\helpers\Url::to(['category/edit?id='.$k]) ?>">编辑</a>
                                <a href="<?= \yii\helpers\Url::to(['category/del?id='.$k]) ?>">删除</a>
                            <?php endif; ?>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            <div class="pagination pull-right"></div>
            <!-- end users table --></div>
    </div>
</div>
<!-- end main container -->
