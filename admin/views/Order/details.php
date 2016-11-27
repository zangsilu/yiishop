<?php


?>


<link rel="stylesheet" href="<?php echo \yii\helpers\Url::home(true) ?>assets/admin/css/compiled/user-list.css"
      type="text/css" media="screen"/>
<!-- main container -->
<div class="content">
    <div class="container-fluid">
        <div id="pad-wrapper" class="users-list">
            <div class="row-fluid header">
                <h3>订单详情</h3></div>
            <div class="row-fluid">
                <p>订单编号：<?= $data['id'] ?></p>

                <p>下单用户：<?= $data['useremail'] ?></p>

                <p>收货地址：<?= $data['address'] ?></p>

                <p>订单总价：<?= $data['amount'] ?></p>

                <p>快递方式：<?= $data['express'] ?></p>

                <p>快递编号：<?= $data['express_no'] ?></p>

                <p>订单状态：<?= $data['status'] ?></p>

                <p>商品列表：</p>

                <p>
                <?php foreach($data['goodsInfo'] as $K=>$v): ?>
                <div>
                    <img src="<?= "http://". $v['goods_img'].'-100.100' ?>">　<?= $v['goods_num'] ?> x <?= $v['goods_name'] ?>
                </div>
                <?php endforeach; ?>
                </p>
            </div>
        </div>
    </div>
</div>
