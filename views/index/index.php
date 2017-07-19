<?php
$this->title = '首页 - ';
?>


    <!-- ============================================================= HEADER : END ============================================================= -->		<div id="top-banner-and-menu">
        <div class="container">

            <div class="col-xs-12 col-sm-4 col-md-3 sidemenu-holder">
                <!-- ================================== TOP NAVIGATION ================================== -->
                <div class="side-menu animate-dropdown">
                    <div class="head"><i class="fa fa-list"></i> 所有分类 </div>
                    <nav class="yamm megamenu-horizontal" role="navigation">
                        <ul class="nav">


                            <?php  foreach ($this->params['menu'] as $k =>$v): ?>
                            <li class="dropdown menu-item">
                                <a href="<?= \yii\helpers\Url::to(['goods/list?cid='.$v['id']]) ?>" class="dropdown-toggle" data-hover="dropdown"><?= $v['title'] ?></a>
                                <ul class="dropdown-menu mega-menu">
                                    <li class="yamm-content">
                                        <!-- ================================== MEGAMENU VERTICAL ================================== -->
                                        <div class="row">
                                            <div class="col-xs-12 col-lg-4">
                                                <ul>
                                                    <?php foreach ($v['child'] as $m=>$n): ?>
                                                        <li><a href="<?= \yii\helpers\Url::to(['goods/list?cid='.$n['id']]) ?>"><?= $n['title'] ?></a></li>
                                                    <?php endforeach; ?>
                                                </ul>
                                            </div>
                                        </div>
                                        <!-- ================================== MEGAMENU VERTICAL ================================== -->
                                    </li>
                                </ul>
                            </li><!-- /.menu-item -->
                            <?php endforeach; ?>



                            <!--<li><a href="http://themeforest.net/item/media-center-electronic-ecommerce-html-template/8178892?ref=shaikrilwan">Buy this Theme</a></li>-->
                        </ul><!-- /.nav -->
                    </nav><!-- /.megamenu-horizontal -->
                </div><!-- /.side-menu -->
                <!-- ================================== TOP NAVIGATION : END ================================== -->		</div><!-- /.sidemenu-holder -->

            <div class="col-xs-12 col-sm-8 col-md-9 homebanner-holder">
                <!-- ========================================== SECTION – HERO ========================================= -->

                <div id="hero">
                    <div id="owl-main" class="owl-carousel owl-inner-nav owl-ui-sm">

                        <div class="item" style="background-image: url(<?= \yii\helpers\Url::home(true).'home/images/sliders/slider01.jpg' ?>);">
                            <div class="container-fluid">
                            </div><!-- /.container-fluid -->
                        </div><!-- /.item -->

                        <div class="item" style="background-image: url(<?= \yii\helpers\Url::home(true).'home/images/sliders/slider02.jpg' ?>);">
                            <div class="container-fluid">
                                <div class="caption vertical-center text-left">
                            </div><!-- /.container-fluid -->
                        </div><!-- /.item -->

                    </div><!-- /.owl-carousel -->
                </div>

                <!-- ========================================= SECTION – HERO : END ========================================= -->
            </div><!-- /.homebanner-holder -->

        </div><!-- /.container -->
    </div><!-- /#top-banner-and-menu -->

    <!-- ========================================= HOME BANNERS ========================================= -->
    <section id="banner-holder" class="wow fadeInUp">
        <div class="container">
            <div class="col-xs-12 col-lg-6 no-margin banner">
                <a href="category-grid.html">
                    <div class="banner-text theblue">
                        <h1 style="font-family:'Microsoft Yahei';">尝尝鲜</h1>
                        <span class="tagline">查看最新分类</span>
                    </div>
                    <img style="width: 570px;" class="banner-image" alt="" src="/assets/images/blank.gif" data-echo="<?= \yii\helpers\Url::home(true).'home/images/banners/banner-narrow-01.jpg'?>" />
                </a>
            </div>
            <div class="col-xs-12 col-lg-6 no-margin text-right banner">
                <a href="category-grid.html">
                    <div class="banner-text right">
                        <h1 style="font-family:'Microsoft Yahei';">时尚流行</h1>
                        <span class="tagline">查看最新上架</span>
                    </div>
                    <img style="width: 570px;" class="banner-image" alt="" src="/assets/images/blank.gif" data-echo="<?= \yii\helpers\Url::home(true).'home/images/banners/banner-narrow-02.jpg'?>" />
                </a>
            </div>
        </div><!-- /.container -->
    </section><!-- /#banner-holder -->
    <!-- ========================================= HOME BANNERS : END ========================================= -->
    <div id="products-tab" class="wow fadeInUp">
        <div class="container">
            <div class="tab-holder">
                <!-- Nav tabs -->
                <ul class="nav nav-tabs" >
                    <li class="active"><a href="#featured" data-toggle="tab">推荐商品</a></li>
                    <li><a href="#new-arrivals" data-toggle="tab">最新上架</a></li>
                    <li><a href="#top-sales" data-toggle="tab">最佳热卖</a></li>
                </ul>

                <!-- Tab panes -->
                <div class="tab-content">
                    <div class="tab-pane active" id="featured">
                        <div class="product-grid-holder">

                            <?php foreach ($this->params['tui'] as $k=>$v):?>
                            <div class="col-sm-4 col-md-3  no-margin product-item-holder hover">
                                <div class="product-item">
                                    <div class="ribbon red"><span>sale</span></div>
                                    <div class="image">
                                        <a href="<?= \yii\helpers\Url::to(['goods/details','goods_id'=>$v->id]) ?>">
                                            <img style="width:246px;height:186px;" alt="" src="<?= 'http://'.$v->goods_img.'-246.246' ?>" data-echo="<?= 'http://'.$v->goods_img.'-246.246' ?>" />
                                        </a>
                                    </div>
                                    <div class="body">
                                        <div class="label-discount green">-50% sale</div>
                                        <div class="title">
                                            <a href="<?= \yii\helpers\Url::to(['goods/details','goods_id'=>$v->id]) ?>"><?= $v->goods_name ?></a>
                                        </div>
                                    </div>
                                    <div class="prices">
                                        <div class="price-current pull-right">￥<?= $v->goods_price ?></div>
                                    </div>

                                    <div class="hover-area">
                                        <div class="add-cart-button">
                                            <a href="single-product.html" class="le-button">加入购物车</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php endforeach; ?>

                        </div>
                        <div class="loadmore-holder text-center">
                            <a class="btn-loadmore" href="<?= \yii\helpers\Url::to(['goods/list']) ?>">
                                <i class="fa fa-plus"></i>
                                查看更多</a>
                        </div>

                    </div>
                    <div class="tab-pane" id="new-arrivals">
                        <div class="product-grid-holder">

                            <?php foreach ($this->params['new'] as $k=>$v):?>
                                <div class="col-sm-4 col-md-3  no-margin product-item-holder hover">
                                    <div class="product-item">
                                        <div class="ribbon blue"><span>new!</span></div>
                                        <div class="image">
                                            <a href="<?= \yii\helpers\Url::to(['goods/details','goods_id'=>$v->id]) ?>">
                                                <img style="width:246px;height:186px;" alt="" src="<?= 'http://'.$v->goods_img.'-246.246' ?>" data-echo="<?= 'http://'.$v->goods_img.'-246.246' ?>" />
                                            </a>
                                        </div>
                                        <div class="body">
                                            <div class="label-discount green">-50% sale</div>
                                            <div class="title">
                                                <a href="<?= \yii\helpers\Url::to(['goods/details','goods_id'=>$v->id]) ?>"><?= $v->goods_name ?></a>
                                            </div>
                                        </div>
                                        <div class="prices">
                                            <div class="price-current pull-right">￥<?= $v->goods_price ?></div>
                                        </div>

                                        <div class="hover-area">
                                            <div class="add-cart-button">
                                                <a href="single-product.html" class="le-button">加入购物车</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>


                        </div>
                        <div class="loadmore-holder text-center">
                            <a class="btn-loadmore" href="<?= \yii\helpers\Url::to(['goods/list']) ?>">
                                <i class="fa fa-plus"></i>
                                查看更多</a>
                        </div>

                    </div>

                    <div class="tab-pane" id="top-sales">
                        <div class="product-grid-holder">

                            <?php foreach ($this->params['hot'] as $k=>$v):?>
                                <div class="col-sm-4 col-md-3  no-margin product-item-holder hover">
                                    <div class="product-item">
                                        <div class="ribbon red"><span>sale</span></div>
                                        <div class="image">
                                            <a href="<?= \yii\helpers\Url::to(['goods/details','goods_id'=>$v->id]) ?>">
                                                <img style="width:246px;height:186px;" alt="" src="<?= 'http://'.$v->goods_img.'-246.246' ?>" data-echo="<?= 'http://'.$v->goods_img.'-246.246' ?>" />
                                            </a>
                                        </div>
                                        <div class="body">
                                            <div class="label-discount green">-50% sale</div>
                                            <div class="title">
                                                <a href="<?= \yii\helpers\Url::to(['goods/details','goods_id'=>$v->id]) ?>"><?= $v->goods_name ?></a>
                                            </div>
                                        </div>
                                        <div class="prices">
                                            <div class="price-current pull-right">￥<?= $v->goods_price ?></div>
                                        </div>

                                        <div class="hover-area">
                                            <div class="add-cart-button">
                                                <a href="single-product.html" class="le-button">加入购物车</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>



                        </div>
                        <div class="loadmore-holder text-center">
                            <a class="btn-loadmore" href="<?= \yii\helpers\Url::to(['goods/list']) ?>">
                                <i class="fa fa-plus"></i>
                                查看更多</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>