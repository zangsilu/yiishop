<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;


?>

<!-- main container -->
<div class="content">
    <div class="container-fluid">
        <div id="pad-wrapper" class="new-user">
            <div class="row-fluid header">
                <h3>添加角色</h3>
                <?php
                if(Yii::$app->session->hasFlash('info')){
                    echo Yii::$app->session->getFlash('info');
                }
                ?>
            </div>
            <div class="row-fluid form-wrapper">
                <!-- left column -->
                <div class="span9 with-sidebar">
                    <div class="container">
                        <?php $form = ActiveForm::begin([
                            'options' => ['class'=>'new_user_form inline-input'],
                            'fieldConfig' => [
                                'template'=>'<div class="span12 field-box">{label}{input}{error}</div>'
                            ]
                        ]) ?>


                        <div class="span12 field-box">
                            <?php echo Html::label('名称', null). Html::textInput('description', '', ['class' => 'span9']); ?>
                        </div>
                        <div class="span12 field-box">
                            <?php echo Html::label('标识', null). Html::textInput('name', '', ['class' => 'span9']); ?>
                        </div>
                        <div class="span12 field-box">
                            <?php echo Html::label('规则名称', null). Html::textInput('rule_name', '', ['class' => 'span9']); ?>
                        </div>
                        <div class="span12 field-box">
                            <?php echo Html::label('数据', null). Html::textarea('data', '', ['class' => 'span9']); ?>
                        </div>


                                <div class="span11 field-box actions">
                                <?php echo Html::submitButton('提交',['class'=>'btn-glow primary']) ?>
                                    <span>OR</span>
                                <?php echo Html::resetButton('取消',['class'=>'reset']) ?>
                                </div>
                        <?php $form->end(); ?>
                    </div>
                </div>
                <!-- side right column -->
                <div class="span3 form-sidebar pull-right">
                    <div class="alert alert-info hidden-tablet">
                        <i class="icon-lightbulb pull-left"></i>请在左侧表单当中填入要添加的角色信息,包括角色名称,描述,图片等</div>
                    <h6>商城用户说明</h6>
                    <p>可以在前台进行购物</p>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- end main container -->


