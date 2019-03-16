<?php
	require_once("../Php/LoadData.php");
	LoadData();
	
	if($User_Jurisdicton == JUR_ADMIN && isset($LandUser))
	{
		if(!file_exists("../Judge/log/data_".$_GET['ReEva']))
		{
			echo "<script>alert('文件日志不存在，无法重测');</script>";
		}
		else
		{
			$sql = "UPDATE `oj_constatus` SET `Status`='Wating' , `AllStatus`='', `UseTime`=-1 , `UseMemory`=-1 where `RunID`='".$_GET['ReEva']."'"; 
			mysql_query($sql);

            //获取比赛提交状态的题号
			$sql = "SELECT * FROM oj_constatus WHERE RunID='".$_GET['ReEva']."'";
			$result = mysql_query($sql);
            $StatusData = mysql_fetch_array($result);
            $NowProblem = $StatusData['Problem'];

            //获取比赛信息中所有题号对应的题库的题号
            $sql = "SELECT * FROM oj_contest WHERE `ConID`=".$_GET['ConID'];
			$result = mysql_query($sql);
            $row = mysql_fetch_array($result);
            $AllProblem = explode('|', $row['Problem']);
            
            //获取题目信息
			$sql = "SELECT * FROM oj_problem WHERE `proNum`='".$AllProblem[$NowProblem]."'";
			$result = mysql_query($sql);
			$ProblemData = mysql_fetch_array($result);

			$myfile = fopen("../Judge/log/data_".$_GET['ReEva'], "w");
			fwrite($myfile, $StatusData['Language']);
			fwrite($myfile, '|'.$StatusData['User']);
			fwrite($myfile, '|'.$AllProblem[$NowProblem]);
			fwrite($myfile, '|'.$ProblemData['LimitTime']);
			fwrite($myfile, '|'.$ProblemData['LimitMemory']);
			fwrite($myfile, '|');
			fwrite($myfile, $ProblemData['Test']);
			fclose($myfile);
			copy("../Judge/log/data_".$_GET['ReEva'], "../Judge/Temporary_ContestData/".$_GET['ReEva']);

            echo '<script>parent.RefreshPage();</script>';
		}
	}
	else
	{
		echo "<script>alert('您没有权限重新测评');</script>";
	}
?>