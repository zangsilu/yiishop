<?php


?>


<link rel="stylesheet" href="<?php echo \yii\helpers\Url::home(true) ?>assets/admin/css/compiled/user-list.css"
      type="text/css" media="screen"/>
<!-- main container -->
<div class="content">
    <div class="container-fluid">
        <div id="pad-wrapper" class="users-list">
            <div class="row-fluid header">
                <h3>订单列表</h3></div>
            <!-- Users table -->
            <div class="row-fluid table">
                <table class="table table-hover">
                    <thead>
                    <tr>
                        <th class="span2 sortable">
                            <span class="line"></span>订单编号
                        </th>
                        <th class="span2 sortable">
                            <span class="line"></span>下单人
                        </th>
                        <th class="span3 sortable">
                            <span class="line"></span>收货地址
                        </th>
                        <th class="span3 sortable">
                            <span class="line"></span>快递方式
                        </th>
                        <th class="span2 sortable">
                            <span class="line"></span>订单总价
                        </th>
                        <th class="span3 sortable">
                            <span class="line"></span>商品列表
                        </th>
                        <th class="span3 sortable">
                            <span class="line"></span>订单状态
                        </th>
                        <th class="span2 sortable align-right">
                            <span class="line"></span>操作
                        </th>
                    </tr>
                    </thead>
                    <tbody>
                    <!-- row -->
                    <?php $data = empty($data)?[]:$data; ?>
                    <?php foreach ($data as $k => $v): ?>
                        <tr class="first">
                            <td><?= $v['id'] ?></td>
                            <td><?= $v['useremail'] ?></td>
                            <td><?= $v['address'] ?></td>
                            <td><?= $v['express'] ?></td>
                            <td><?= $v['amount'] ?></td>
                            <td>
                                <?php foreach ($v['goodsInfo'] as $m => $n): ?>
                                    <p title="<?= $n['goods_name'] ?>"
                                       style="width:250px;overflow: hidden; white-space: nowrap;text-overflow: ellipsis">
                                        <?= $n['goods_num'] ?> x
                                        <a target="_blank"
                                           href="<?= \yii\helpers\Url::to(['/goods/details?goods_id=' . $n['goods_id']]) ?>"><?= $n['goods_name'] ?></a>
                                    </p>
                                <?php endforeach; ?>
                            </td>
                            <td>
                                <span class="label label-success"><?= $v['status'] ?></span></td>
                            <td class="align-right">
                                <?php if($v['status'] == '已付款'): ?>
                                <a class="label label-warning" href="<?= \yii\helpers\Url::to(['order/send?order_id=' . $v['id']]) ?>">发货</a>
                                <?php endif;?>
                                <a href="<?= \yii\helpers\Url::to(['order/details?order_id=' . $v['id']]) ?>">查看</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            <div class="pagination pull-right">
                <?=
                    \yii\widgets\LinkPager::widget([
                        'pagination'=>$pager,
                        'prevPageLabel' => '&#8249;',
                        'nextPageLabel' => '&#8250;',
                    ])
                ?>
            </div>
            <!-- end users table --></div>
    </div>
</div>
<!-- end main container -->
