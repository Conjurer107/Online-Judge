<!DOCTYPE html>

<html lang="zh-cn">

<?php require_once('Php/HTML_Head.php') ?>

<?php

    if(!isset($LandUser))
    {
        header('Location: /Message.php?Msg=您没有登陆，无权访问');
		return;
    }
    if($User_Jurisdicton != JUR_ADMIN)
    {
        header('Location: /Message.php?Msg=您不是管理员，无权访问');
		return;
    }
?>

<body>

	<?php require_once ('Php/Page_Header.php') ?>

    <div class="container">

        如果您有什么意见或可反馈的问题，可以在这里提交
        <textarea data-ctrlenter="#post_submit" name="content" placeholder="这里填具体描述" style="margin-top:8px;height:80px" class="form-control"></textarea>
        <button id="post_submit" style="margin-top:10px;" class="btn btn-default">提交</button>
    </div>

    <?php
	$PageActive = '#admin';
	require_once('Php/Page_Footer.php');
	?>
</body>

</html>