<?php


?>


<link rel="stylesheet" href="<?php use yii\grid\GridView;
use yii\helpers\Html;

echo \yii\helpers\Url::home(true) ?>assets/admin/css/compiled/user-list.css"
      type="text/css" media="screen"/>
<!-- main container -->
<div class="content">
    <div class="container-fluid">
        <div id="pad-wrapper" class="users-list">
            <div class="row-fluid header">
                <h3>角色列表</h3></div>



            <?php
            echo GridView::widget([
                'dataProvider' => $dataProvider,
                'columns' => [
                    [
                        'class' => 'yii\grid\SerialColumn',
                    ],
                    'description:text:名称',
                    'name:text:标识',
                    'rule_name:text:规则名称',
                    'created_at:datetime:创建时间',
                    'updated_at:datetime:更新时间',
                    [
                        'class' => 'yii\grid\ActionColumn',
                        'header' => '操作',
                        'template' => '{assign} {update} {delete}',
                        'buttons' => [
                            'assign' => function ($url, $model, $key) {
                                return Html::a('分配权限', ['assignitem', 'name' => $model['name']]);
                            },
                            'update' => function ($url, $model, $key) {
                                return Html::a('更新', ['updateitem', 'name' => $model['name']]);
                            },
                            'delete' => function ($url, $model, $key) {
                                return Html::a('删除', ['deleteitem', 'name' => $model['name']]);
                            }
                        ],
                    ],
                ],
                'layout' => "\n{items}\n{summary}<div class='pagination pull-right'>{pager}</div>",
            ]);
            ?>





        </div>
    </div>
</div>
<!-- end main container -->
