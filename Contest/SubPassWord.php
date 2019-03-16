<?php
    require_once("../Php/LoadData.php");
    LoadData();
    
    if(isset($_POST["ConID"]) && isset($_POST["ConPassWord"]))  
    {
        $sql = "SELECT * FROM oj_contest WHERE `ConID`=".$_POST["ConID"];
        $result = mysql_query($sql);

        if(!isset($result))
        {
		    header('Location: /Message.php?Msg=比赛信息获取失败');
		    return;
        }

        $ConData = mysql_fetch_array($result);

        if($ConData['PassWord'] == $_POST["ConPassWord"])
        {
            $_SESSION['ConPassWord'] = $_POST["ConPassWord"];
            echo "<script>parent.SkipPage('/Contest/Pandect.php?ConID=".$_POST["ConID"]."');</script>";
        }
        else
        {
            echo "<script>alert('密码错误');</script>";
        }
    }
    else
    {
        echo "<script>parent.SkipPage('/Message.php?Msg=获取比赛信息时发生错误');</script>";
    }
?>