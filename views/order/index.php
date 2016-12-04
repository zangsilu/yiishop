<!-- ============================================================= HEADER : END ============================================================= -->
<div id="single-product">
    <div class="container" style="padding-top:10px">

        <?php foreach ($orderList as $k => $v): ?>
            <div style="margin-bottom:30px;">
                <div class="trade-order-mainClose">
                    <div>
                        <table style="width:100%;border-collapse:collapse;border-spacing:0px;">
                            <colgroup>
                                <col style="width:38%;">
                                <col style="width:10%;">
                                <col style="width:5%;">
                                <col style="width:12%;">
                                <col style="width:12%;">
                                <col style="width:11%;">
                                <col style="width:12%;">
                            </colgroup>
                            <tbody>
                            <tr style="background-color:#F5F5F5;width:100%">
                                <td style="padding:10px 20px;text-align:left;">
                                    <label>
                                        <input type="checkbox" disabled="" style="margin-right:8px;">
                                        <strong title="<?= date('Y-m-d H:i:s', $v['created_at']) ?>"
                                                style="margin-right:8px;font-weight:bold;">
                                            <?= date('Y-m-d', $v['created_at']) ?>
                                        </strong>
                                    </label>
              <span>
                订单号：
              </span>
              <span>
              </span>
              <span>
                <?= $v['id'] ?>
              </span>
                                </td>

                            </tr>
                            </tbody>
                        </table>
                        <table style="width:100%;border-collapse:collapse;border-spacing:0px;">
                            <colgroup>
                                <col style="width:38%;">
                                <col style="width:10%;">
                                <col style="width:5%;">
                                <col style="width:12%;">
                                <col style="width:12%;">
                                <col style="width:11%;">
                                <col style="width:12%;">
                            </colgroup>
                            <tbody>
                            <?php foreach ($v['goodsInfo'] as $m => $n): ?>
                                <tr>
                                    <td style="text-align:left;vertical-align:top;padding-top:10px;padding-bottom:10px;border-right-width:0;border-right-style:solid;border-right-color:#E8E8E8;border-top-width:0;border-top-style:solid;border-top-color:#E8E8E8;padding-left:20px;">
                                        <div style="overflow:hidden;">
                                            <a class="tp-tag-a" href=""
                                               style="float:left;width:27%;margin-right:2%;text-align:center;"
                                               target="_blank">
                                                <img src="http://<?= $n['goods_img'] ?>"
                                                     style="border:1px solid #E8E8E8;max-width:80px;">
                                            </a>

                                            <div style="float:left;width:71%;word-wrap:break-word;">
                                                <div style="margin:0px;">
                                                    <a class="tp-tag-a" href="" target="_blank">
                      <span>
                        <?= $n['goods_name'] ?>
                      </span>
                                                    </a>
                    <span>
                    </span>
                                                </div>
                                                <div style="margin-top:8px;margin-bottom:0;color:#9C9C9C;">
                                                </div>

                  <span>
                  </span>
                                            </div>
                                        </div>
                                    </td>
                                    <td style="text-align:center;vertical-align:top;padding-top:10px;padding-bottom:10px;border-right-width:0;border-right-style:solid;border-right-color:#E8E8E8;border-top-width:0;border-top-style:solid;border-top-color:#E8E8E8;">
                                        <div style="font-family:verdana;font-style:normal;">
                                            <p>
                                                <?= $n['goods_price'] ?>
                                            </p>
                <span>
                </span>
                <span>
                </span>
                                        </div>
                                    </td>
                                    <td style="text-align:center;vertical-align:top;padding-top:10px;padding-bottom:10px;border-right-width:0;border-right-style:solid;border-right-color:#E8E8E8;border-top-width:0;border-top-style:solid;border-top-color:#E8E8E8;">
                                        <div>
                                            <div>
                                                <?= $n['goods_num'] ?>
                                            </div>
                                        </div>
                                    </td>
                                    <td style="text-align:center;vertical-align:top;padding-top:10px;padding-bottom:10px;border-right-width:1px;border-right-style:solid;border-right-color:#E8E8E8;border-top-width:0;border-top-style:solid;border-top-color:#E8E8E8;">
                                        <div>
                                            <div style="margin-bottom:3px;">
                  <span>
                    <span class="trade-ajax">
                      <span class="trade-tooltip-wrap">
                        <span>
                          <span class="trade-operate-text">
                            <?= $v['shou_name'] ?>
                          </span>
                        </span>
                      </span>
                      <noscript>
                      </noscript>
                    </span>
                  </span>
                                            </div>

                                        </div>
                                    </td>
                                    <?php if ($m == 0): ?>
                                        <td style="text-align:center;vertical-align:top;padding-top:10px;padding-bottom:10px;border-right-width:1px;border-right-style:solid;border-right-color:#E8E8E8;border-top-width:0;border-top-style:solid;border-top-color:#E8E8E8;">
                                            <div>
                                                <div style="font-family:verdana;font-style:normal;">
                  <span>
                  </span>
                  <span>
                  </span>

                                                    <p>
                                                        <strong>
                                                            <?= $v['amount'] ?>
                                                        </strong>
                                                    </p>
                  <span>
                  </span>
                                                </div>
                                                <p>
                  <span>
                    (含运费：
                  </span>
                  <span>
                    <?= $v['express_price'] ?>
                  </span>
                  <span>
                  </span>
                  <span>
                  </span>
                  <span>
                    )
                  </span>
                                                </p>

                                                <div>
                                                </div>
                                            </div>
                                        </td>
                                        <td style="text-align:center;vertical-align:top;padding-top:10px;padding-bottom:10px;border-right-width:1px;border-right-style:solid;border-right-color:#E8E8E8;border-top-width:0;border-top-style:solid;border-top-color:#E8E8E8;">
                                            <div>
                                                <div style="margin-bottom:3px;">
                                                    <a class="tp-tag-a" href="" target="_blank">
                                                        <?= $v['status'] ?>
                                                    </a>
                                                </div>
                                                <div>
                                                    <div style="margin-bottom:3px;">
                                                        <?php if ($v['status'] != '未付款' && $v['status'] != '已付款'): ?>

                                                            <span id="getExpress" style="position: relative">
                              <a order_id="<?= $v['id'] ?>" class="tp-tag-a" href="javascript:;" target="_blank">
                                <span class="trade-operate-text">
                                  查看物流
                                </span>
                              </a>
                                <div
                                    style="padding:10px;position:absolute;left:-170px;top:20px;width:300px;background: #fbfbfb;display: none;z-index: 10"
                                    id="expressContent">
                                    <h2>物流状态 <span style="font-size: 12px;"></span></h2>

                                    <div style="font-size: 12px;" class="exptessMain">
                                        <div>
                                        </div>
                            </span>

                                                        <?php endif; ?>

                                                    </div>

                                                </div>
                                                <?php if ($v['status'] == '已发货'): ?>

                                                    <span style="float: left;">
                                                        <form id="formConfirm" action="<?= \yii\helpers\Url::to(['order/confirm']) ?>" method="post">
                                                           <input type="hidden" name="_csrf" value="<?= Yii::$app->request->csrfToken ?>" ?>
                                                            <input type="hidden" name="order_id" value="<?= $v['id'] ?>">
                                                        </form>
                              <a class="tp-tag-a" href="javascript:;" id="confirm" target="_blank">
                                <span class="trade-operate-text">
                                  确认收货
                                </span>
                              </a>
                            </span>
                                                <?php endif; ?>
                                            </div>
                                        </td>
                                    <?php endif; ?>
                                </tr>
                            <?php endforeach; ?>
                            </tbody>
                        </table>
                        <div>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>

    <script src="<?php echo \yii\helpers\Url::home(true) ?>assets/js/jquery-1.10.2.min.js"></script>
    <script type="text/javascript">
        $('#getExpress a').hover(function () {
            $(this).parent().find('#expressContent').show();
            var _this = this;
            var order_id = $(this).attr('order_id');
            $.getJSON('<?= \yii\helpers\Url::to(['order/get-express']) ?>', {order_id: order_id}, function (data) {
                if (data.message == 'ok') {
                    $str = '';
                    $(data.data).each(function (k, v) {
                        $str += '<p>' + v.context + ' ' + v.time + '</p>';
                    })
                    $(_this).next().find('.exptessMain').html($str)
                    $(_this).next().find('h2 span').html(data.com)
                }else {
                    $(_this).next().find('.exptessMain').html(data.message)
                }
            })
        }, function () {
            $(this).parent().find('#expressContent').hide();
        });

        $('#confirm').click(function(){
            if(confirm('确认收货吗?')){
                $('#formConfirm').submit();
            }
        })

    </script>
