<!DOCTYPE html>

<html lang="zh-cn">

<?php require_once("Html_Head.php");?>

<body>
    <?php
        require_once("Header.php");

        if($ConData['Type'] == 0)
	    {
            echo "<script>location.href='/Contest/Pandect.php?ConID=".$ConID."';</script>";
            return;
        }
    ?>
    <div class="container">
        <div class="panel panel-default">
            <div id="contesthead" class="panel-heading" style="padding:0 0 0 0;">
                <ul class="nav nav-tabs" role="tablist">

                    <li>
                        <h4>&nbsp;</h4>
                    </li>
                </ul>
            </div>
            <div class="panel-body">

                <h3>请输入比赛密码： </h3>
                <form method="post" class="input-group" autocomplete="off" action="/Contest/SubPassWord.php" target="myIframeSubPW">
                    <span class="input-group-addon">密码：</span>
                    <input type="password" name="ConPassWord" class="form-control">
                    <span class="input-group-btn">
                        <button class="btn btn-default" type="submit" name="ConID" value=<?php echo '"'.$ConID.'"';?>>Go!</button>
                    </span>
                </form>
                <iframe id="myIframe" name="myIframeSubPW" style="display:none"></iframe>
            </div>
        </div>

    </div>

    <?php
    $PageActive = "";
	require_once('Footer.php');
    ?>

</body>

</html>