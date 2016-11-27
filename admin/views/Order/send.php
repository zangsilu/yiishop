<?php


?>


<link rel="stylesheet" href="<?php echo \yii\helpers\Url::home(true) ?>assets/admin/css/compiled/user-list.css"
      type="text/css" media="screen"/>
<!-- main container -->
<div class="content">
    <div class="container-fluid">
        <div id="pad-wrapper" class="new-user">
            <div class="row-fluid header">
                <h3>发货</h3>
            </div>
            <p style="color: red;">
                <?php
                if(Yii::$app->session->hasFlash('info'))
                    {
                        echo Yii::$app->session->getFlash('info');
                    }
                ?>
            </p>
            <div class="row-fluid form-wrapper">
                <!-- left column -->
                <div class="span9 with-sidebar">
                    <div class="container">
                        <form id="w0" class="new_user_form inline-input"
                              action="<?= \yii\helpers\Url::to(['order/send', 'order_id' => $model->id]) ?>"
                              method="post">
                            <input type="hidden" name="_csrf" value="<?= Yii::$app->request->csrfToken ?>">

                            <div class="form-group field-order-expressno required">
                                <div class="span12 field-box">
                                    <label class="control-label" for="order-expressno">快递单号</label>
                                    <input type="text" id="order-expressno" class="span9" name="Order[express_no]"
                                           value=""></div>
                                <p class="help-block help-block-error"></p>
                            </div>
                            <div class="span11 field-box actions">
                                <button type="submit" class="btn-glow primary">发货</button>
                                <span>OR</span>
                                <button type="reset" class="reset">取消</button>
                            </div>
                        </form>
                    </div>
                </div>
                <!-- side right column -->
                <div class="span3 form-sidebar pull-right">
                    <div class="alert alert-info hidden-tablet">
                        <i class="icon-lightbulb pull-left"></i>请在左侧表单当中填写快递单号
                    </div>
                    <h6>快递单号说明</h6>

                    <p>填写快递单号</p>
                </div>
            </div>
        </div>
    </div>
</div>
