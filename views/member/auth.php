

    <!-- ============================================================= HEADER : END ============================================================= -->		<!-- ========================================= MAIN ========================================= -->
    <main id="authentication" class="inner-bottom-md">
        <div class="container">
            <div class="row">



                <div class="col-md-6">
                    <section class="section sign-in inner-right-xs">
                        <h2 class="bordered">登录</h2>

<span style="color: red;"><?php if(Yii::$app->session->hasFlash('info'))echo Yii::$app->session->getFlash('info'); ?></span>

                        <p><strong><?php if(Yii::$app->session['username'])echo Yii::$app->session['username']; ?></strong>欢迎您回来，请您输入您的账户名密码</p>

                        <div class="social-auth-buttons">
                            <div class="row">
                                <div class="col-md-6">
                                    <button class="btn-block btn-lg btn btn-facebook"><i class="fa fa-qq"></i> 使用QQ账号登录</button>
                                </div>
                                <div class="col-md-6">
                                    <button class="btn-block btn-lg btn btn-twitter"><i class="fa fa-weibo"></i> 使用新浪微博账号登录</button>
                                </div>
                            </div>
                        </div>

                        <form role="form" method="post" class="login-form cf-style-1">
                            <input type="hidden" name="_csrf" id="_csrf" value="<?= Yii::$app->request->csrfToken; ?>">
                            <div class="field-row">
                                <label>电子邮箱</label>
                                <input  type="text" name="User[useremail]" class="le-input">
                            </div><!-- /.field-row -->

                            <div class="field-row">
                                <label>密码</label>
                                <input type="password" name="User[userpass]" class="le-input">
                            </div><!-- /.field-row -->

                            <div class="field-row clearfix">
                        	<span class="pull-left">
                        		<label class="content-color"><input type="checkbox" name="User[rememberMe]" class="le-checbox auto-width inline"> <span class="bold">记住我</span></label>
                        	</span>
                        	<span class="pull-right">
                        		<a href="javascript:;" class="content-color bold">忘记密码 ?</a>
                        	</span>
                            </div>

                            <div class="buttons-holder">
                                <button type="submit" class="le-button huge">安全登录</button>
                            </div><!-- /.buttons-holder -->
                        </form><!-- /.cf-style-1 -->

                    </section><!-- /.sign-in -->
                </div><!-- /.col -->




                <div class="col-md-6">
                    <section class="section register inner-left-xs">
                        <h2 class="bordered">新建账户</h2>
                        <p>创建一个属于你自己的账户</p>

                        <form role="form" method="post" action="<?php echo \yii\helpers\Url::to(['member/register']); ?>" class="register-form cf-style-1">
                            <input type="hidden" name="_csrf" id="_csrf" value="<?php echo Yii::$app->request->csrfToken ?>">
                            <div class="field-row">
                                <label>电子邮箱</label>
                                <input name="User[useremail]" type="text" class="le-input">
                            </div><!-- /.field-row -->

                            <div class="buttons-holder">
                                <button type="submit" class="le-button huge">注册</button>
                            </div><!-- /.buttons-holder -->
                        </form>

                        <h2 class="semi-bold">加入我们您将会享受到前所未有的购物体验 :</h2>

                        <ul class="list-unstyled list-benefits">
                            <li><i class="fa fa-check primary-color"></i> 快捷的购物体验</li>
                            <li><i class="fa fa-check primary-color"></i> 便捷的下单方式</li>
                            <li><i class="fa fa-check primary-color"></i> 更加低廉的商品</li>
                        </ul>

                    </section><!-- /.register -->

                </div><!-- /.col -->

            </div><!-- /.row -->
        </div><!-- /.container -->
    </main><!-- /.authentication -->
    <!-- ========================================= MAIN : END ========================================= -->		<!-- ============================================================= FOOTER ============================================================= -->
