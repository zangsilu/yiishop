<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;


?>

<!-- main container -->
<div class="content">
    <div class="container-fluid">
        <div id="pad-wrapper" class="new-user">
            <div class="row-fluid header">
                <h3>编辑商品</h3>
                <?php
                if(Yii::$app->session->hasFlash('info')){
                    echo Yii::$app->session->getFlash('info');
                }
                ?>
            </div>
            <div class="row-fluid form-wrapper">
                <!-- left column -->
                <div class="span9 with-sidebar">
                    <div class="container">
                        <?php $form = ActiveForm::begin([
                            'options' => ['class'=>'new_user_form inline-input'],
                            'fieldConfig' => [
                                'template'=>'<div class="span12 field-box">{label}{input}{error}</div>'
                            ]
                        ]) ?>
                        <?php echo $form->field($model,'cid')->dropDownList($list) ?>
                        <?php echo $form->field($model,'goods_name')->textInput(['class'=>'span9']) ?>
                        <?php echo $form->field($model,'goods_price')->textInput(['class'=>'span9']) ?>
                        <?php echo $form->field($model,'is_hot')->radioList(['0'=>'否','1'=>'是']) ?>
                        <?php echo $form->field($model,'is_promote')->radioList(['0'=>'否','1'=>'是']) ?>
                        <?php echo $form->field($model,'promote_price')->textInput(['class'=>'span9']) ?>
                        <?php echo $form->field($model,'goods_num')->textInput(['class'=>'span9']) ?>
                        <?php  echo $form->field($model,'ison')->radioList(['0'=>'否','1'=>'是']) ?>
                        <?php  echo $form->field($model,'istui')->radioList(['0'=>'否','1'=>'是']) ?>
                        <?php  echo $form->field($model,'goods_img')->fileInput(['class'=>'span9']) ?>
                        <?php if(!empty($model->goods_img)){
                                echo '<img src="http://'.$model->goods_img.'-67.60" >';
                        }?>
                        <?php echo $form->field($model,'goods_pics[]')->fileInput(['class'=>'span9','id'=>'product-pics']) ?>
                        <?php
                            $pics = json_decode($model->goods_pics,true);

                            if(!empty($pics)){
                                foreach($pics as $k =>$v){
                                    $del_url = \yii\helpers\Url::to(['goods/del_pics','key'=>$k,'goods_id'=>$model->id]);
                                    echo '<img src="http://'.$v.'-67.60" >';
                                    echo "<a href='{$del_url}'>删除</a>";
                                }
                            }

                        ?>
                            <hr>
                            <input type='button' id="addpic" value='增加一个'>
                        <?php echo $form->field($model,'goods_desc')->widget(\kucha\ueditor\UEditor::className(),[]); ?>
                                <div class="span11 field-box actions">
                                <?php echo Html::submitButton('提交',['class'=>'btn-glow primary']) ?>
                                    <span>OR</span>
                                <?php echo Html::resetButton('取消',['class'=>'reset']) ?>
                                </div>
                        <?php $form->end(); ?>
                    </div>
                </div>
                <!-- side right column -->
                <div class="span3 form-sidebar pull-right">
                    <div class="alert alert-info hidden-tablet">
                        <i class="icon-lightbulb pull-left"></i>请在左侧表单当中填入要添加的商品信息,包括商品名称,描述,图片等</div>
                    <h6>商城用户说明</h6>
                    <p>可以在前台进行购物</p>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- end main container -->


