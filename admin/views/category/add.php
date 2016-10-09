<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

?>
<!-- main container -->
<div class="content">
    <div class="container-fluid">
        <div id="pad-wrapper" class="new-user">
            <div class="row-fluid header">
                <h3>添加新分类</h3></div>
            <?php
                if(Yii::$app->session->hasFlash('info')){
                    echo Yii::$app->session->getFlash('info');
                }
            ?>
            <div class="row-fluid form-wrapper">
                <!-- left column -->
                <div class="span9 with-sidebar">
                    <div class="container">
                        <?php $form = ActiveForm::begin([
                            'options' => ['class'=>'new_user_form inline-input'],
                            'fieldConfig' => [
                                'template' => '<div class="span12 field-box">{label}{input}{error}</div>',
                            ]
                        ]) ?>
                        <?php echo $form->field($model,'pid')->dropDownList($list) ?>
                        <?php echo $form->field($model,'title')->textInput(['class'=>'span3']) ?>

                            <div class="span11 field-box actions">
                                <?php echo Html::submitButton('添加',['class'=>'btn-glow primary']) ?>
                                <span>OR</span>
                                <?php echo Html::resetButton('取消',['class'=>'reset']) ?>
                            </div>
                        <?php $form->end(); ?>
                    </div>
                </div>
                <!-- side right column -->
                <div class="span3 form-sidebar pull-right">
                    <div class="alert alert-info hidden-tablet">
                        <i class="icon-lightbulb pull-left"></i>请在左侧表单当中填写要添加的分类，请选择好上级分类</div>
                    <h6>商城分类说明</h6>
                    <p>该分类为无限级分类</p>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- end main container -->


