<?php
	require_once("LoadData.php");
	LoadData();
	
	if($User_Jurisdicton == JUR_ADMIN && isset($LandUser))
	{
		if(!file_exists("../Judge/log/data_".$_GET['ReEva']))
		{
			echo "<script>alert('文件日志不存在，无法重测');</script>";
		}
		else
		{
			$sql = "UPDATE `oj_status` SET `Status`='Wating' , `AllStatus`='', `UseTime`=-1 , `UseMemory`=-1 where `RunID`='".$_GET['ReEva']."'"; 
			mysql_query($sql);

			$sql = "SELECT * FROM `oj_status` WHERE `RunID`='".$_GET['ReEva']."'";
			$result = mysql_query($sql);
			$StatusData = mysql_fetch_array($result);

			$sql = "SELECT * FROM `oj_problem` WHERE `proNum`='".$StatusData['Problem']."'";
			$result = mysql_query($sql);
			$ProblemData = mysql_fetch_array($result);

			$myfile = fopen("../Judge/log/data_".$_GET['ReEva'], "w");
			fwrite($myfile, $StatusData['Language']);
			fwrite($myfile, '|'.$StatusData['User']);
			fwrite($myfile, '|'.$StatusData['Problem']);
			fwrite($myfile, '|'.$ProblemData['LimitTime']);
			fwrite($myfile, '|'.$ProblemData['LimitMemory']);
			fwrite($myfile, '|');
			fwrite($myfile, $ProblemData['Test']);
			fclose($myfile);
			copy("../Judge/log/data_".$_GET['ReEva'], "../Judge/Temporary_Data/".$_GET['ReEva']);

            echo '<script>parent.RefreshPage();</script>';
		}
	}
	else
	{
		echo "<script>alert('您没有权限重新测评');</script>";
	}
?>