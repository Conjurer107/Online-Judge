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

    $status = 0;
    $ContestData;
    if(array_key_exists('ConID', $_GET))
    {
        $status = 1;

        $sql = "SELECT * FROM oj_contest WHERE ConID='".$_GET['ConID']."'";
	    $result = mysql_query($sql);

	    if($result)
	    {
		    $ContestData = mysql_fetch_array($result);

		    if(!$ContestData)
		    {
			    header('Location: /Message.php?Msg=未知比赛ID');
			    return;
            }
	    }
	    else
	    {
		    header('Location: /Message.php?Msg=比赛查找失败');
		    return;
	    }
    }
    
    
    $sql = "select max(ConID) as value from oj_contest";
	$result = mysql_query($sql);
	$NewID = mysql_fetch_array($result); 
?>

<body>
    <?php require_once ('Php/Page_Header.php') ?>

    <script src="/ckeditor/ckeditor.js"></script>

    <script type="text/javascript">
        window.onload = function () {
            CKEDITOR.replace('Synopsis');
        };
    </script>

    <div class="container">
        <div class="panel panel-default">
            <div class="panel-heading">新建比赛</div>
            <div class="panel-body animated fadeInLeft">
                <form enctype="multipart/form-data" name="upload_form" action="Php/SubmitNewCon.php" method="post" target="myIframeNull">
                    <div class="panel panel-default float-center" style="width:1000px;">

                        <input name="NewType" style="display:none" value=<?php echo $status;?>>

                        <div class="input-group">
                            <span class="input-group-addon">比赛标题</span>
                            <input name="Title" type="text" class="form-control" value=<?php echo ($status == 1) ? '"'.$ContestData['Title'].'"' : '""';?>>

                            <?php
                            echo '<span class="input-group-addon">比赛ID</span>';
                            if($status == 1)
                            {
                                echo '<input name="ConID" type="number" class="form-control" value="'.$ContestData['ConID'].'" readonly="readonly">';
                            }
                            else
                            {
                                echo '<input name="ConID" type="number" class="form-control" value="'.($NewID['value'] + 1).'">';
                            }
                            ?>
                        </div>
                        <br />
                        <div class="input-group">
                            <span class="input-group-addon">比赛开始时间</span>
                            <?php
                            if($status == 1)
                            {
                                $StartTime = $ContestData['StartTime'];
                                $Time_1 = substr($StartTime, 0, 10); 
                                $Time_2 = substr($StartTime, 11, 5); 
                                $StartTime = $Time_1.'T'.$Time_2; 
                                echo '<input name="StartTime" type="datetime-local" class="form-control" value="'.$StartTime.'">';
                            }
                            else
                            {
                                echo '<input name="StartTime" type="datetime-local" class="form-control">';
                            }
        
                            ?>
                            <span class="input-group-addon">比赛结束时间</span>
                            <?php
                            if($status == 1)
                            {
                                $OverTime = $ContestData['OverTime'];
                                $Time_1 = substr($OverTime, 0, 10); 
                                $Time_2 = substr($OverTime, 11, 5); 
                                $OverTime = $Time_1.'T'.$Time_2; 
                                echo '<input name="OverTime" type="datetime-local" class="form-control" value="'.$OverTime.'">';
                            }
                            else
                            {
                                echo '<input name="OverTime" type="datetime-local" class="form-control" value="">';
                            }
                            ?>

                        </div>

                        <br />
                        <div class="input-group">
                            <span class="input-group-addon">报名开始时间</span>
                            <?php
                            if($status == 1)
                            {
                                $EnrollStartTime = $ContestData['EnrollStartTime'];
                                $Time_1 = substr($EnrollStartTime, 0, 10); 
                                $Time_2 = substr($EnrollStartTime, 11, 5); 
                                $EnrollStartTime = $Time_1.'T'.$Time_2; 
                                echo '<input name="EnrollStartTime" type="datetime-local" class="form-control" value="'.$EnrollStartTime.'">';
                            }
                            else
                            {
                                echo '<input name="EnrollStartTime" type="datetime-local" class="form-control">';
                            }
                            ?>
                            <span class="input-group-addon">报名结束时间</span>
                            <?php
                            if($status == 1)
                            {
                                $EnrollOverTime = $ContestData['EnrollOverTime'];
                                $Time_1 = substr($EnrollOverTime, 0, 10); 
                                $Time_2 = substr($EnrollOverTime, 11, 5); 
                                $EnrollOverTime = $Time_1.'T'.$Time_2; 
                                echo '<input name="EnrollOverTime" type="datetime-local" class="form-control" value="'.$EnrollOverTime.'">';
                            }
                            else
                            {
                                echo '<input name="EnrollOverTime" type="datetime-local" class="form-control">';
                            }
                            ?>
                        </div>

                        <br />
                        <div class="input-group">
                            <span class="input-group-addon">比赛规则</span>
                            <select name="Rule" class="form-control">
                                <?php
                                if($status == 1 && $ContestData['Rule'] == 'OI')
                                {
                                    echo '<option value="ACM">ACM</option>';
                                    echo '<option value="OI" selected = "selected">OI</option>';
                                }
                                else
                                {
                                    echo '<option value="ACM" selected = "selected">ACM</option>';
                                    echo '<option value="OI">OI</option>';
                                }
                                ?>
                            </select>
                            <span class="input-group-addon">比赛类型</span>
                            <select name="Type" class="form-control">
                                <?php
                                if($status == 1 && $ContestData['Type'] == 1)
                                {
                                    echo '<option value="Public">Public</option>';
                                    echo '<option value="Private" selected = "selected">Private</option>';
                                }
                                else
                                {
                                    echo '<option value="Public" selected = "selected">Public</option>';
                                    echo '<option value="Private">Private</option>';
                                }
                                ?>
                            </select>
                        </div>

                        <br />
                        <div class="input-group">
                            <span class="input-group-addon">密码</span>
                            <input name="PassWord" type="text" class="form-control"
                                value=<?php echo ($status == 1) ? '"'.$ContestData['PassWord'].'"' : '""';?>>
                        </div>

                        <br />
                        <div class="input-group">
                            <span class="input-group-addon">举办人</span>
                            <input name="Organizer" type="text" class="form-control"
                                value=<?php echo ($status == 1) ? '"'.$ContestData['Organizer'].'"' : $LandUser;?>>
                            <span class="input-group-addon">风险系数</span>
                            <input name="RiskRatio" type="number" step="0.1" class="form-control"
                                value=<?php echo ($status == 1) ? '"'.$ContestData['RiskRatio'].'"' : '""';?>>
                        </div>

                        <br />
                        <div class="input-group">
                            <span class="input-group-addon">题号</span>
                            <input name="Problem" type="text" class="form-control" placeholder="1000|1001|1002"
                                value=<?php echo ($status == 1) ? '"'.$ContestData['Problem'].'"' : '""';?>>
                        </div>

                        <br />
                        <div>
                            <span class="input-group-addon">比赛简介</span>
                            <textarea name="Synopsis" class="form-control"
                                style="margin-top:8px;height:80px"><?php echo ($status == 1) ? $ContestData['Synopsis'] : '';?></textarea>
                        </div>

                        <center><button id="post_submit" style="margin-top:10px; width:500px;"
                                class="btn btn-default">提交</button></center>
                        <br />
                    </div>
                </form>
                <iframe id="myIframe" name="myIframeNull" style="display:none"></iframe>
            </div>
        </div>
    </div>
    <?php
	$PageActive = '#admin';
	require_once('Php/Page_Footer.php');
	?>
</body>

</html>