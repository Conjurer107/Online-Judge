<?php
    require_once("LoadData.php");
    LoadData();

    if(isset($LandUser) && $_POST["Motto"])
    {
        $sql = "UPDATE oj_user SET signature='".$_POST["Motto"]."', skin='".$_POST["Css"]."' where name='".$LandUser."'"; 
        mysql_query($sql);

        if($_POST["Oldpassword"] != "")
        {
            $sql = "SELECT Name,Password from oj_user where Name = '$_POST[User]' and PassWord = '$_POST[Oldpassword]'";  
            $result = mysql_query($sql); 
            $num = mysql_num_rows($result);
            if($num)  
            {
                if($_POST["Newpassword"] != "")
                {
                    if($_POST["Newpassword"] == $_POST["Repassword"])
                    {
                        $sql = "UPDATE oj_user SET PassWord='".$_POST["Newpassword"]."' where name='".$LandUser."'"; 
                        mysql_query($sql);

                        echo "<script>alert('提交成功！');</script>";
                        echo '<script>parent.RefreshPage();</script>';
                    }
                    else
                    {
                        echo "<script>alert('两次密码输入不一致');</script>";
                    }
                }
                else
                {
                    echo "<script>alert('请输入新密码');</script>";
                }
            }
            else
            {
                echo "<script>alert('旧密码输入错误');</script>";
            }
        }
        else
        {
            echo "<script>alert('提交成功！');</script>";
            echo '<script>parent.RefreshPage();</script>';
        }
    }
    else
    {
        echo "<script>alert('数据提交失败');</script>";
    }
?>