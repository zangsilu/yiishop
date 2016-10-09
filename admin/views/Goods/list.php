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
                <h3>商品列表</h3>
                <div class="span10 pull-right">
                    <a href="<?= \yii\helpers\Url::to(['goods/add']) ?>" class="btn-flat success pull-right">
                        <span>&#43;</span>添加新商品</a></div>
            </div>
            <!-- Users table -->
            <div class="row-fluid table">
                <table class="table table-hover">
                    <thead>
                    <tr>
                        <th class="span6 sortable">
                            <span class="line"></span>商品名称</th>
                        <th class="span2 sortable">
                            <span class="line"></span>商品库存</th>
                        <th class="span2 sortable">
                            <span class="line"></span>商品单价</th>
                        <th class="span2 sortable">
                            <span class="line"></span>是否热卖</th>
                        <th class="span2 sortable">
                            <span class="line"></span>是否促销</th>
                        <th class="span2 sortable">
                            <span class="line"></span>促销价</th>
                        <th class="span2 sortable">
                            <span class="line"></span>是否上架</th>
                        <th class="span2 sortable">
                            <span class="line"></span>是否推荐</th>
                        <th class="span3 sortable align-right">
                            <span class="line"></span>操作</th>
                    </tr>
                    </thead>
                    <tbody>

                    <?php foreach($data as $k=>$v): ?>
                    <tr class="first">
                        <td>
                            <img src="<?= 'http://'.$v->goods_img ?>-goodsimg.433.325" class="img-circle avatar hidden-phone" />
                            <a href="#" class="name"><?= $v->goods_name ?></a></td>
                        <td><?= $v->goods_num ?></td>
                        <td><?= $v->goods_price ?></td>
                        <td>
                            <?php
                            $is_hot = ['非热卖','热卖'];
                            echo $is_hot[$v->is_hot];
                            ?>
                        </td>
                        <td>
                            <?php
                            $is_promote = ['非促销','促销'];
                            echo $is_promote[$v->is_promote];
                            ?>
                        </td>
                        <td><?= $v->promote_price ?></td>
                        <td>
                            <?php
                            $is_on = ['否','是'];
                            echo $is_on[$v->ison];
                            ?>
                        </td>
                        <td>
                            <?php
                            $is_tui = ['否','是'];
                            echo $is_tui[$v->istui];
                            ?>
                        </td>
                        <td class="align-right">
                            <a href="<?php echo \yii\helpers\Url::to(['goods/edit','id'=>$v->id]) ?>">编辑</a>
                            <a href="<?php  echo \yii\helpers\Url::to(['goods/on','id'=>$v->id]) ?>">上架</a>
                            <a href="<?php echo \yii\helpers\Url::to(['goods/off','id'=>$v->id]) ?>">下架</a>
                            <a class="del" href="<?php echo \yii\helpers\Url::to(['goods/del','id'=>$v->id]) ?>">删除</a></td>
                    </tr>
                    <?php endforeach;?>

                    </tbody>
                </table>
            </div>
            <div class="pagination pull-right">
                <?php echo \yii\widgets\LinkPager::widget([
                    'pagination' =>$pager,
                    'prevPageLabel' => '&#8249;',
                    'nextPageLabel' => '&#8250;',
                ]) ?>
            </div>
            <!-- end users table --></div>
    </div>
</div>
<!-- end main container -->
