<!DOCTYPE html>
<html class="login-bg">

<?php use \yii\bootstrap\ActiveForm; ?>

<head>
    <title>慕课商城 - 找回密码</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <!-- bootstrap -->
    <link href="/assets/admin/css/bootstrap/bootstrap.css" rel="stylesheet" />
    <link href="/assets/admin/css/bootstrap/bootstrap-responsive.css" rel="stylesheet" />
    <link href="/assets/admin/css/bootstrap/bootstrap-overrides.css" type="text/css" rel="stylesheet" />
    <!-- global styles -->
    <link rel="stylesheet" type="text/css" href="/assets/admin/css/layout.css" />
    <link rel="stylesheet" type="text/css" href="/assets/admin/css/elements.css" />
    <link rel="stylesheet" type="text/css" href="/assets/admin/css/icons.css" />
    <!-- libraries -->
    <link rel="stylesheet" type="text/css" href="/assets/admin/css/lib/font-awesome.css" />
    <!-- this page specific styles -->
    <link rel="stylesheet" href="/assets/admin/css/compiled/signin.css" type="text/css" media="screen" />
    <!-- open sans font -->
    <!--[if lt IE 9]>
    <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" /></head>

<body>
<div class="row-fluid login-wrapper">
    <a class="brand" href="index.html"></a>

    <?php $form = ActiveForm::begin([
        'fieldConfig'=>[
            'template'=>'{error}{input}',
        ],
    ]) ?>

    <!--csrf认证 防止伪造表单攻击-->
    <input name="_csrf" type="hidden" id="_csrf" value="<?= Yii::$app->request->csrfToken ?>">

        <div class="span4 box">
            <div class="content-wrap">
                <h6>慕课商城 - 找回密码</h6>
                <?php echo Yii::$app->session->hasFlash('info') ? Yii::$app->session->getFlash('info'):'' ?>
                <div class="form-group field-admin-adminuser">
                    <p class="help-block help-block-error"></p>
                    <?php echo $form->field($admin,'admin_user')->textInput(['class'=>'span12','placeholder'=>'管理员账号'])  ?>
                <div class="form-group field-admin-adminpass">
                    <p class="help-block help-block-error"></p>
                    <?php echo $form->field($admin,'admin_email')->textInput(['class'=>'span12','placeholder'=>'管理员邮箱'])  ?>
                <a href="<?php echo \yii\helpers\Url::to(['public/login'])?>" class="forgot">返回登入</a>
                <button type="submit" class="btn-glow primary login">找回密码</button></div>
        </div>

    <?php ActiveForm::end() ?>

</div>
<!-- scripts -->
<script src="/assets/admin/js/jquery-latest.js"></script>
<script src="/assets/admin/js/bootstrap.min.js"></script>
<script src="/assets/admin/js/theme.js"></script>
<!-- pre load bg imgs -->
<script type="text/javascript">$(function() {
        // bg switcher
        var $btns = $(".bg-switch .bg");
        $btns.click(function(e) {
            e.preventDefault();
            $btns.removeClass("active");
            $(this).addClass("active");
            var bg = $(this).data("img");

            $("html").css("background-image", "url('img/bgs/" + bg + "')");
        });

    });</script>
</body>

</html>