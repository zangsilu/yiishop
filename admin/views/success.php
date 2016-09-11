

<!--操作成功 start-->
<div class="change_done bd_db">
    <p>
        <span class="ico_big ico_done"></span>
        <span class="fw_b fs_14"><?php echo isset($message)?$message:'操作成功' ?></span>
</p>
<p class="line_30">现在去，
    <?php
    foreach($links as $link){
        echo CHtml::link($link[0],$link[1],array('class'=>'c_06c mr10'));
    }
    ?>
</p>
<p class="c_666 ml40">该页将在 <span id='setouttime'>3</span>秒后自动跳转!</p>
</div>
<!--操作成功 end-->

<script language=javascript>
    var int=self.setInterval("countdown()",1000);
    function countdown(){
        var t=document.getElementById("setouttime").innerHTML-1;
        document.getElementById("setouttime").innerHTML=t;
        if(t===0){
            location='<?php echo $links[0][1]?>';
        }
    }
</script>