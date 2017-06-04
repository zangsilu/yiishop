<!-- main container -->
<div class="content">
    <div class="container-fluid">
        <div id="pad-wrapper" class="users-list">
            <div class="row-fluid header">
                <h3>管理员列表</h3>
                <div class="span10 pull-right">
                    <a href="<?php echo \yii\helpers\Url::to(['manage/add']) ?>" class="btn-flat success pull-right">
                        <span>&#43;</span>添加新管理员</a></div>
            </div>
            <!-- Users table -->
            <div class="row-fluid table">
                <table class="table table-hover">
                    <thead>
                    <tr>
                        <th class="span2">管理员ID</th>
                        <th class="span2">
                            <span class="line"></span>管理员账号</th>
                        <th class="span2">
                            <span class="line"></span>管理员邮箱</th>
                        <th class="span3">
                            <span class="line"></span>最后登录时间</th>
                        <th class="span3">
                            <span class="line"></span>最后登录IP</th>
                        <th class="span2">
                            <span class="line"></span>添加时间</th>
                        <th class="span2">
                            <span class="line"></span>操作</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach($data as $k =>$v): ?>
                    <tr>
                        <td><?= $v->id; ?></td>
                        <td><?= $v->admin_user; ?></td>
                        <td><?= $v->admin_email; ?></td>
                        <td><?= date('Y-m-d H:i:s',$v->admin_login_time); ?></td>
                        <td><?= long2ip($v->admin_login_ip); ?></td>
                        <td><?= date('Y-m-d H:i:s',$v->admin_create_time); ?></td>
                        <td class="align-right">
                            <a href="<?= \yii\helpers\Url::to(['manage/assign','adminid'=>$v->id]) ?>">授权</a>

                        <a href="<?= \yii\helpers\Url::to(['manage/del','admin_id'=>$v->id]) ?>">删除</a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            <div class="pagination pull-right">
                <?php echo \yii\widgets\LinkPager::widget(['pagination'=>$pages]) ?>
            </div>
            <?php
             if(Yii::$app->session->hasFlash('info')){
                 echo Yii::$app->session->getFlash('info');
             }
            ?>
            <!-- end users table --></div>
    </div>
</div>
<!-- end main container -->