<h1>尊敬的<?=$admin_user?>您好：</h1>

<p>您的找回密码连接如下：</p>

<?php $url = Yii::$app->urlManager->createAbsoluteUrl(['admin/manage/mailchangepass','tamp'=>$timestamp,'admin_user'=>$admin_user,'token'=>$token])?>
<p><a href="<?=$url?>"></a><?=$url?></p>

<p>该链接5分钟内有效,请勿发送给他人!</p>

<p>该邮件为系统自动发送,请勿回复.</p>