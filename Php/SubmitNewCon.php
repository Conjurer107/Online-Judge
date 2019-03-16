<?php
	require_once("LoadData.php");
    LoadData();

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

    $Type = ($_POST['Type'] == 'Public') ? 0 : 1;

    if($_POST['NewType'] == 1)
    {
        $sql = "UPDATE `oj_contest` SET `Title` = '".$_POST['Title']."', `ConID` = ".$_POST['ConID'].", `Synopsis` = '".$_POST['Synopsis']."', `Organizer` = '".$_POST['Organizer']."', `Rule` = '".$_POST['Rule']."', `Type` = ".$Type.", `PassWord` = '".$_POST['PassWord']."', `StartTime` = '".$_POST['StartTime']."', `OverTime` = '".$_POST['OverTime']."', `EnrollStartTime` = '".$_POST['EnrollStartTime']."', `EnrollOverTime` = '".$_POST['EnrollOverTime']."' , `RiskRatio` = ".$_POST['RiskRatio'].", `RatingStatus` = 0, `Problem` = '".$_POST['Problem']."' WHERE ConID = '".$_POST['ConID']."'";
        $result = mysql_query($sql);
        echo "<script>alert('修改比赛成功！');</script>";
    }
    else
    {
        $sql = "INSERT INTO `oj_contest` (`ConID`, `Title`, `Synopsis`, `Organizer`, `Rule`, `Type`, `PassWord`, `StartTime`, `OverTime`, `EnrollStartTime`, `EnrollOverTime`, `EnrollPeople`, `RiskRatio`, `RatingStatus`, `Problem`, `Show`) VALUES (".$_POST['ConID'].", '".$_POST['Title']."', '".$_POST['Synopsis']."', '".$_POST['Organizer']."','".$_POST['Rule']."', '".$Type."', '".$_POST['PassWord']."', '".$_POST['StartTime']."', '".$_POST['OverTime']."', '".$_POST['EnrollStartTime']."', '".$_POST['EnrollOverTime']."', '', '".$_POST['RiskRatio']."' ,'0' ,'".$_POST['Problem']."', 0);";
        $result = mysql_query($sql);
        echo "<script>alert('添加比赛成功！');</script>";
    }
    

    echo "<script>parent.GoHistoryPage();</script>";
?>