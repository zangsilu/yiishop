<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

?>

<div class="content">
    <div class="container-fluid">
        <div id="pad-wrapper" class="new-user">
            <div class="row-fluid header">
                <h3>添加新管理员</h3></div>
            <div class="row-fluid form-wrapper">
                <!-- left column -->
                <div class="span9 with-sidebar">
                    <div class="container">

                        <?php if(Yii::$app->session->hasFlash('info')){echo Yii::$app->session->getFlash('info');} ?>

                        <?php $form = ActiveForm::begin([
                            'options' => ['class'=>'new_user_form inline-input'],
                            'fieldConfig' => [
                                'template' => '<div class="span12 field-box">{label}{input}{error}</div>'
                            ],
                        ]); ?>
                <?php echo $form->field($admin,'admin_user')->textInput(['class'=>'span9']); ?>
                <?php echo $form->field($admin,'admin_email')->textInput(['class'=>'span9']); ?>
                <?php echo $form->field($admin,'admin_pass')->passwordInput(['class'=>'span9']); ?>
                <?php echo $form->field($admin,'repass')->passwordInput(['class'=>'span9']); ?>

                            <div class="span11 field-box actions">
                                <?php echo Html::submitButton('创建',['class'=>'btn-glow primary']) ?>
                                <?php echo Html::resetButton('取消',['class'=>'btn-glow reset']) ?>
                            </div>
                        <?php ActiveForm::end(); ?>
                    </div>
                </div>
                <!-- side right column -->
                <div class="span3 form-sidebar pull-right">
                    <div class="alert alert-info hidden-tablet">
                        <i class="icon-lightbulb pull-left"></i>请在左侧填写管理员相关信息，包括管理员账号，电子邮箱，以及密码</div>
                    <h6>重要提示：</h6>
                    <p>管理员可以管理后台功能模块</p>
                    <p>请谨慎添加</p>
                </div>
            </div>
        </div>
    </div>
</div>