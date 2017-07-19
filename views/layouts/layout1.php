<?php
/* @var $this \yii\web\View */
use app\assets\AppAsset;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\helpers\Html;

/* @var $content string */

AppAsset::register($this);
?>

<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="zh-cn" <?= Yii::$app->language; ?>>
<head>
    <?php $this->head() ?>
    <!-- Meta -->
    <meta charset="<?php echo Yii::$app->charset; ?>">
    <?php
    $this->registerMetaTag(['http-equiv' => 'Content-Type', 'content' => 'text/html; charset=UTF-8']);
    $this->registerMetaTag(['name'    => 'viewport',
                            'content' => 'width=device-width, initial-scale=1.0, user-scalable=no',
    ]);
    $this->registerMetaTag(['name' => 'description', 'content' => 'this is yii framework project']);
    $this->registerMetaTag(['name' => 'author', 'content' => 'zangsilu']);
    $this->registerMetaTag(['name' => 'keywords', 'content' => 'zangsilu, yii2, assets']);
    $this->registerMetaTag(['name' => 'robots', 'content' => 'all']);
    ?>
    <title>
        <?= \yii\helpers\Html::encode($this->title) . ' 木瓜商城' ?>
    </title>


    <!-- Favicon -->
    <link rel="shortcut icon" href="/home/images/favicon.ico">

    <script src="<?php echo \yii\helpers\Url::home(true) ?>home/js/jquery-1.10.2.min.js"></script>

</head>
<body>
<?php $this->beginBody() ?>
<div class="wrapper">
    <!-- ============================================================= TOP NAVIGATION ============================================================= -->
    <?php
    NavBar::begin([
        'options' => [
            "class" => "top-bar animate-dropdown",
        ],
    ]);
    echo Nav::widget([
        'options' => ['class' => 'navbar-nav navbar-left'],
        'items'   => [
            ['label' => '首页', 'url' => ['/index/index']],
            ['label' => '所有商品', 'url' => ['goods/list']],
            !Yii::$app->user->isGuest ? (
            ['label' => '我的购物车', 'url' => ['/cart/index']]
            ) : '',
            !Yii::$app->user->isGuest ? (
            ['label' => '我的订单', 'url' => ['/order/index']]
            ) : '',
        ],
    ]);
    echo Nav::widget([
        'options' => ['class' => 'navbar-nav navbar-right'],
        'items'   => [
            Yii::$app->user->isGuest ? (
            ['label' => '注册', 'url' => ['/member/auth']]
            ) : '',
            Yii::$app->user->isGuest ? (
            ['label' => '登录', 'url' => ['/member/auth']]
            ) : '',
            !Yii::$app->user->isGuest ? (
                '欢迎您回来，' . Yii::$app->user->identity->username . ' , ' .
                Html::a('退出', ['/member/logout'])
            ) : '',
        ],
    ]);
    NavBar::end();
    ?>

    <!-- ============================================================= TOP NAVIGATION : END ============================================================= -->
    <!-- ============================================================= HEADER ============================================================= -->
    <header>
        <div class="container no-padding">

            <div class="col-xs-12 col-sm-12 col-md-3 logo-holder">
                <!-- ============================================================= LOGO ============================================================= -->
                <div class="logo">
                    <a href="/">
                        <img alt="logo" src="/home/images/logo.PNG"/>
                    </a>
                </div><!-- /.logo -->
                <!-- ============================================================= LOGO : END ============================================================= -->
            </div><!-- /.logo-holder -->

            <div class="col-xs-12 col-sm-12 col-md-6 top-search-holder no-margin">
                <div class="contact-row">
                    <div class="phone inline">
                        <i class="fa fa-phone"></i> (+086) 123 456 7890
                    </div>
                    <div class="contact inline">
                        <i class="fa fa-envelope"></i> contact@<span class="le-color">zangsilu.com</span>
                    </div>
                </div><!-- /.contact-row -->
                <!-- ============================================================= SEARCH AREA ============================================================= -->
                <div class="search-area">
                    <?php
                    \yii\bootstrap\ActiveForm::begin([
                            'action'=>['goods/search'],
                            'method'=>'get'
                    ])
                    ?>
                        <div class="control-group">
                            <input value="<?= Yii::$app->request->get('keyword',''); ?>" class="search-field" placeholder="搜索商品" name="keyword"/>

                            <ul class="categories-filter animate-dropdown">
                                <li class="dropdown">

                                    <a class="dropdown-toggle" data-toggle="dropdown" href="category-grid.html">所有分类</a>

                                    <ul class="dropdown-menu" role="menu">
                                        <li role="presentation"><a role="menuitem" tabindex="-1"
                                                                   href="category-grid.html">电子产品</a></li>
                                        <li role="presentation"><a role="menuitem" tabindex="-1"
                                                                   href="category-grid.html">电子产品</a></li>
                                        <li role="presentation"><a role="menuitem" tabindex="-1"
                                                                   href="category-grid.html">电子产品</a></li>
                                        <li role="presentation"><a role="menuitem" tabindex="-1"
                                                                   href="category-grid.html">电子产品</a></li>

                                    </ul>
                                </li>
                            </ul>

                            <a style="padding:15px 15px 13px 12px" class="search-button" href="javascript:document.getElementById('w3').submit();"></a>

                        </div>
                    <?php
                    \yii\bootstrap\ActiveForm::end();
                    ?>
                </div><!-- /.search-area -->
                <!-- ============================================================= SEARCH AREA : END ============================================================= -->
            </div><!-- /.top-search-holder -->

            <div class="col-xs-12 col-sm-12 col-md-3 top-cart-row no-margin">
                <div class="top-cart-row-container">

                    <!-- ============================================================= SHOPPING CART DROPDOWN ============================================================= -->
                    <div class="top-cart-holder dropdown animate-dropdown">

                        <div class="basket">

                            <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                                <div class="basket-item-count">
                                    <span class="count">3</span>
                                    <img src="/home/images/icon-cart.png"
                                         alt=""/>
                                </div>

                                <div class="total-price-basket">
                                    <span class="lbl">您的购物车:</span>
                                    <span class="total-price">
                        <span class="sign">￥</span><span class="value">3219</span>
                    </span>
                                </div>
                            </a>

                            <ul class="dropdown-menu">
                                <li>
                                    <div class="basket-item">
                                        <div class="row">
                                            <div class="col-xs-4 col-sm-4 no-margin text-center">
                                                <div class="thumb">
                                                    <img alt=""
                                                         src="/home/images/products/product-small-01.jpg"/>
                                                </div>
                                            </div>
                                            <div class="col-xs-8 col-sm-8 no-margin">
                                                <div class="title">前端课程</div>
                                                <div class="price">￥270.00</div>
                                            </div>
                                        </div>
                                        <a class="close-btn" href="#"></a>
                                    </div>
                                </li>

                                <li>
                                    <div class="basket-item">
                                        <div class="row">
                                            <div class="col-xs-4 col-sm-4 no-margin text-center">
                                                <div class="thumb">
                                                    <img alt=""
                                                         src="/home/images/products/product-small-01.jpg"/>
                                                </div>
                                            </div>
                                            <div class="col-xs-8 col-sm-8 no-margin">
                                                <div class="title">Java课程</div>
                                                <div class="price">￥270.00</div>
                                            </div>
                                        </div>
                                        <a class="close-btn" href="#"></a>
                                    </div>
                                </li>

                                <li>
                                    <div class="basket-item">
                                        <div class="row">
                                            <div class="col-xs-4 col-sm-4 no-margin text-center">
                                                <div class="thumb">
                                                    <img alt=""
                                                         src="/home/images/products/product-small-01.jpg"/>
                                                </div>
                                            </div>
                                            <div class="col-xs-8 col-sm-8 no-margin">
                                                <div class="title">PHP课程</div>
                                                <div class="price">￥270.00</div>
                                            </div>
                                        </div>
                                        <a class="close-btn" href="#"></a>
                                    </div>
                                </li>


                                <li class="checkout">
                                    <div class="basket-item">
                                        <div class="row">
                                            <div class="col-xs-12 col-sm-6">
                                                <a href="cart.html" class="le-button inverse">查看购物车</a>
                                            </div>
                                            <div class="col-xs-12 col-sm-6">
                                                <a href="checkout.html" class="le-button">去往收银台</a>
                                            </div>
                                        </div>
                                    </div>
                                </li>

                            </ul>
                        </div><!-- /.basket -->
                    </div><!-- /.top-cart-holder -->
                </div><!-- /.top-cart-row-container -->
                <!-- ============================================================= SHOPPING CART DROPDOWN : END ============================================================= -->
            </div><!-- /.top-cart-row -->

        </div><!-- /.container -->

        <!-- ========================================= NAVIGATION ========================================= -->
        <nav id="top-megamenu-nav" class="megamenu-vertical animate-dropdown">
            <div class="container">
                <div class="yamm navbar">
                    <div class="navbar-header">
                        <button type="button" class="navbar-toggle" data-toggle="collapse"
                                data-target="#mc-horizontal-menu-collapse">
                            <span class="sr-only">Toggle navigation</span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                        </button>
                    </div><!-- /.navbar-header -->
                    <div class="collapse navbar-collapse" id="mc-horizontal-menu-collapse">
                        <ul class="nav navbar-nav">

                            <li class="dropdown">
                                <a href="<?php echo \yii\helpers\Url::to(['index/index']) ?>" class="dropdown-toggle"
                                   data-hover="dropdown">首页</a>
                            </li>


                            <?php foreach ($this->params['menu'] as $k => $v): ?>
                                <li class="dropdown">
                                    <a href="<?= \yii\helpers\Url::to(['goods/list?cid=' . $v['id']]) ?>"
                                       class="dropdown-toggle" data-hover="dropdown"><?= $v['title'] ?></a>
                                    <ul class="dropdown-menu">
                                        <li>
                                            <div class="yamm-content">
                                                <div class="row">
                                                    <div>
                                                        <?php foreach ($v['child'] as $m => $n): ?>
                                                            <a href="<?= \yii\helpers\Url::to(['goods/list?cid=' . $n['id']]) ?>">
                                                                <h2 style="padding-right: 10px;text-align: center"><?= $n['title'] ?></h2>
                                                            </a>
                                                        <?php endforeach; ?>
                                                    </div><!-- /.col -->
                                                </div><!-- /.row -->
                                            </div><!-- /.yamm-content --></li>
                                    </ul>
                                </li>
                            <?php endforeach; ?>

                        </ul><!-- /.navbar-nav -->
                    </div><!-- /.navbar-collapse -->
                </div><!-- /.navbar -->
            </div><!-- /.container -->
        </nav><!-- /.megamenu-vertical -->
        <!-- ========================================= NAVIGATION : END ========================================= -->
    </header>


    <?= $content ?>


    <footer id="footer" class="color-bg">

        <div class="sub-form-row">
            <!--<div class="container">
                <div class="col-xs-12 col-sm-8 col-sm-offset-2 no-padding">
                    <form role="form">
                        <input placeholder="Subscribe to our newsletter">
                        <button class="le-button">Subscribe</button>
                    </form>
                </div>
            </div>--><!-- /.container -->
        </div><!-- /.sub-form-row -->

        <div class="link-list-row">
            <div class="container no-padding">
                <div class="col-xs-12 col-md-12">
                    <!-- ============================================================= CONTACT INFO ============================================================= -->
                    <div style="width: 300px;margin: 0 auto;" class="contact-info">
                        <div class="footer-logo">
                            <img alt="logo" src="/home/images/logo.PNG"
                                 width="233" height="54"/>
                        </div><!-- /.footer-logo -->

                        <p class="regular-bold"> 请通过电话，电子邮件随时联系我们</p>

                        <p>
                            西城区二环到三环德胜门外大街10号TCL大厦3层(马甸桥南), 北京市西城区, 中国
                            <br>木瓜网 (QQ群:416465236)
                        </p>

                        <!--<div class="social-icons">
                            <h3>Get in touch</h3>
                            <ul>
                                <li><a href="http://facebook.com/transvelo" class="fa fa-facebook"></a></li>
                                <li><a href="#" class="fa fa-twitter"></a></li>
                                <li><a href="#" class="fa fa-pinterest"></a></li>
                                <li><a href="#" class="fa fa-linkedin"></a></li>
                                <li><a href="#" class="fa fa-stumbleupon"></a></li>
                                <li><a href="#" class="fa fa-dribbble"></a></li>
                                <li><a href="#" class="fa fa-vk"></a></li>
                            </ul>
                        </div>--><!-- /.social-icons -->

                    </div>
                    <!-- ============================================================= CONTACT INFO : END ============================================================= -->
                </div>

            </div><!-- /.container -->
        </div><!-- /.link-list-row -->

        <div class="copyright-bar">
            <div class="container">
                <div class="col-xs-12 col-sm-6 no-margin">
                    <div class="copyright">
                        &copy; <a href="index.html">Mgyii.pl39.com</a> - all rights reserved
                    </div><!-- /.copyright -->
                </div>
                <div class="col-xs-12 col-sm-6 no-margin">
                    <div class="payment-methods ">
                        <ul>
                            <li><img alt=""
                                     src="/home/images/payments/payment-visa.png">
                            </li>
                            <li><img alt=""
                                     src="/home/images/payments/payment-master.png">
                            </li>
                            <li><img alt=""
                                     src="/home/images/payments/payment-paypal.png">
                            </li>
                            <li><img alt=""
                                     src="/home/images/payments/payment-skrill.png">
                            </li>
                        </ul>
                    </div><!-- /.payment-methods -->
                </div>
            </div><!-- /.container -->
        </div><!-- /.copyright-bar -->

    </footer><!-- /#footer -->
    <!-- ============================================================= FOOTER : END ============================================================= -->
</div><!-- /.wrapper -->


<script>
    $("#createlink").click(function () {
        $(".billing-address").slideDown();
    });
</script>

<?php $this->endBody() ?>
<?php $this->endPage(); ?>
</body>
</html>
