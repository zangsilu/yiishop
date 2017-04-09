<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yiidreamteam\jstree\JsTree;

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
                <?= JsTree::widget([
                    'containerOptions' => [
                        'class' => 'data-tree',
                    ],
                    'jsOptions' => [
                        'core' => [
                            'check_callback' => true,
                            'multiple' => false,
                            'data' => [
                                // [{"id" : 1, "text" : "服装", "children" : [{}, {}]}, {}]
                                'url' => \yii\helpers\Url::to(['category/tree']),
                            ],
                            'themes' => [
                                "stripes" => true,
                                "variant" => "large",
                            ]
                        ],
                        "plugins" => [
                            'contextmenu', 'dnd', 'search', 'state', 'types', 'wholerow'
                        ],
                    ]
                ]) ?>
            </div>
            <div class="pagination pull-right"></div>
            <!-- end users table --></div>
    </div>
</div>
<!-- end main container -->

<?php

$csrfVar = Yii::$app->request->csrfParam;
$csrfVal = Yii::$app->request->csrfToken;
$urlRename = \yii\helpers\Url::to(['category/rename']);
$urlDelete = \yii\helpers\Url::to(['category/delete']);
$urlCreate = \yii\helpers\Url::to(['category/add-child']);
$js = <<<JS
    $('#w0').on('rename_node.jstree',function(e,data) {
    var newText = data.text;
    var oldText = data.old;
    var id = data.node.id;
    var postData = {'$csrfVar':'$csrfVal','newText':newText,'oldText':oldText,'id':id};
    $.post('$urlRename',postData,function (data) {
      if(data.code != 0){
          alert(data.message);
          location.href = location.href;
      }
    })
    }).on('delete_node.jstree',function(e,data) {
    var id = data.node.id;
    var postData = {'$csrfVar':'$csrfVal','id':id};
    $.getJSON('$urlDelete',postData,function (data) {
      if(data.code != 0){
          alert(data.message);
          // location.href = location.href;
          window.location.reload();
      }
    })
    })
//    .on('create_node.jstree',function(e,data) {
//    var id = data.node.id;
//    var title =  data.text;
//    var postData = {'$csrfVar':'$csrfVal','pid':id,'title':title};
//    $.getJSON('$urlDelete',postData,function (data) {
//      if(data.code != 0){
//          alert(data.message);
//          return false;
//      }
//    })
//    })
    
    
JS;

$this->registerJs($js);




?>
