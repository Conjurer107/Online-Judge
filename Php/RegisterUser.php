<?php
    require_once("LoadData.php");
    LoadData();

    if(isset($_POST['username']) && isset($_POST['password']) && isset($_POST['email']))
    {
        $sql = 'INSERT INTO oj_user(`name`, `uid`, `password`, `jurisdicton`, `signature`, `email`, `regtime`, `logtime`, `fight`, `skin`) values("'.AlterString($_POST['username']).'", 3, "'.$_POST['password'].'", 0, "", "'.$_POST['email'].'", "'.date("Y-m-d").'", "'.date("Y-m-d").'", 1000, "spacelab")';
        $result = mysql_query($sql);

        if($result)
        {
            
            echo "<script>alert('注册成功！即将转入主页面。');</script>";
            echo "<script>parent.SkipPage('/');</script>";
        }
        else
        {
            echo "<script>alert('注册失败。');</script>";
        }
    }
    else
    {
        echo "<script>alert('注册失败。');</script>";
    }
?>