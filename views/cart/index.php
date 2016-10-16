

    <!-- ============================================================= HEADER : END ============================================================= -->		<section id="cart-page">
        <div class="container">
            <!-- ========================================= CONTENT ========================================= -->
            <div class="col-xs-12 col-md-9 items-holder no-margin">

                <?php foreach($cartInfo as $k=>$v): ?>
                <div class="row no-margin cart-item">
                    <div class="col-xs-12 col-sm-2 no-margin">
                        <a href="<?= \yii\helpers\Url::to(['goods/details','goods_id'=>$v['goods_id']]) ?>" class="thumb-holder">
                            <img class="lazy" alt="" src="<?= 'http://'.$v['goods_img'] ?>" />
                        </a>
                    </div>

                    <div class="col-xs-12 col-sm-5 ">
                        <div class="title">
                            <a href="<?= \yii\helpers\Url::to(['goods/details','goods_id'=>$v['goods_id']]) ?>"><?= $v['goods_name'] ?></a>
                        </div>
                    </div>

                    <div class="col-xs-12 col-sm-3 no-margin">
                        <input type="hidden" class="cart_id" value="<?= $v['cart_id'] ?>">
                        <div class="quantity">
                            <div class="le-quantity">
                                <form>
                                    <a class="minus" href="#reduce"></a>
                                    <input name="quantity" readonly="readonly" type="text" value="<?= $v['cart_goods_num'] ?>" />
                                    <a class="plus" href="#add"></a>
                                </form>
                            </div>
                        </div>
                    </div>

                    <div class="col-xs-12 col-sm-2 no-margin">
                        <div class="price">
                            ￥<?= $v['goods_price'] ?>
                        </div>
                        <a class="close-btn close-cart" href="javascript:;"></a>
                    </div>
                </div><!-- /.cart-item -->
                <?php endforeach;?>



            </div>
            <!-- ========================================= CONTENT : END ========================================= -->

            <!-- ========================================= SIDEBAR ========================================= -->

            <div class="col-xs-12 col-md-3 no-margin sidebar ">
                <div class="widget cart-summary">
                    <h1 class="border">商品购物车</h1>
                    <div class="body">
                        <ul class="tabled-data no-border inverse-bold">
                            <li>
                                <label>购物车总价</label>
                                <div class="value pull-right one">￥<?= sprintf('%.2f', $total); ?></div>
                            </li>
                            <li>
                                <label>运费</label>
                                <div class="value pull-right">￥10</div>
                            </li>
                        </ul>
                        <ul id="total-price" class="tabled-data inverse-bold no-border">
                            <li>
                                <label>订单总价</label>
                                <div class="value pull-right two">￥<?= sprintf('%.2f', $total+10 );?></div>
                            </li>
                        </ul>
                        <div class="buttons-holder">
                            <a class="le-button big" href="checkout.html" >去结算</a>
                            <a class="simple-link block" href="index.html" >继续购物</a>
                        </div>
                    </div>
                </div><!-- /.widget -->

                <div id="cupon-widget" class="widget">
                    <h1 class="border">使用优惠券</h1>
                    <div class="body">
                        <form>
                            <div class="inline-input">
                                <input data-placeholder="请输入优惠券码" type="text" />
                                <button class="le-button" type="submit">使用</button>
                            </div>
                        </form>
                    </div>
                </div><!-- /.widget -->
            </div><!-- /.sidebar -->

            <!-- ========================================= SIDEBAR : END ========================================= -->
        </div>
    </section>		<!-- ============================================================= FOOTER ============================================================= -->

    <script src="<?php echo \yii\helpers\Url::home(true) ?>assets/js/jquery-1.10.2.min.js"></script>
    <script type="text/javascript">
       $('.minus').click(function(){
            var cart_id = $(this).parent().parent().parent().prev('.cart_id').val();
            $.getJSON('<?= \yii\helpers\Url::to(['cart/change-num'])?>',{cart_id:cart_id,type:'jian'},function(data){
                $('.one').html('￥'+data.total)
                $('.two').html('￥'+(parseFloat(data.total)+10).toFixed(2))
            });
        })
       $('.plus').click(function(){
            var cart_id = $(this).parent().parent().parent().prev('.cart_id').val();
            $.getJSON('<?= \yii\helpers\Url::to(['cart/change-num'])?>',{cart_id:cart_id},function(data){
                $('.one').html('￥'+data.total)
                $('.two').html('￥'+(parseFloat(data.total)+10).toFixed(2))
            });
        })
        $('a.close-cart').click(function(){
            if(!confirm('确定从购物车中删除该商品吗?')){
                return false;
            }

            var cart_id = $(this).parent().prev().find('.cart_id').val();
            $.getJSON('<?= \yii\helpers\Url::to(['cart/del'])?>',{cart_id:cart_id},function(data){
                $('.one').html('￥'+data.total)
                $('.two').html('￥'+(parseFloat(data.total)+10).toFixed(2))
            });
            $(this).parent().parent().remove();
        })
    </script>