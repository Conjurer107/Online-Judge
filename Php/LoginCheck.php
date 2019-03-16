<?php
    require_once("LoadData.php");
    LoadData();

    if(isset($_POST["submit"]) && $_POST["submit"] == "btnLogin")  
    {
        $user = $_POST["username"];  
        $psw = $_POST["password"];  

        if($user == "" || $psw == "")  
        {
            echo "<script>alert('未输入用户或密码'); </script>";
            unset($_SESSION['username']);//注销用户登陆
        } 
        else 
        {
            //核实数据库中的用户信息
            $sql = "SELECT Name,Password from oj_user where Name = '$_POST[username]' and PassWord = '$_POST[password]'";  
            $result = mysql_query($sql);  

            //查找失败
            if(!$result)
            {
                echo "<script>parent.SkipPage('/Message.php?Msg=数据库发生错误，可能服务器正在维护');</script>";
                return;
            }

            $num = mysql_num_rows($result);  

            if($num)  
            {
                //设置登陆信息
                $row = mysql_fetch_array($result);
                $_SESSION['username']  = $row[0];
                
                //更新数据库中的登陆日期
                $time = date('Y-m-d');
                $sql = "UPDATE oj_user SET logtime='$time' where name='$row[0]'"; 
                mysql_query($sql);

                echo '<script>parent.RefreshPage();</script>';
            }
            else 
            {
                echo "<script>alert('用户或密码输入错误');</script>";
                unset($_SESSION['username']);
            }
        }  
    }  
    else 
    {  
        echo "<script>alert('提交失败'); </script>";
        unset($_SESSION['username']);//注销用户登陆
    }  
 
?>

<!DOCTYPE html>

<body>
	<div >
		<h1>正在登陆...</h1>
	</div>
</body>
</html>