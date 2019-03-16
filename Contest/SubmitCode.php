<?php
	require_once("../Php/LoadData.php");
	LoadData();
    
    if(isset($_POST["code"]) && isset($_POST["language"]) && isset($_POST["ConID"]) && isset($_POST["NowPro"]))
    {
		if(!isset($LandUser))
		{
			unset($_POST['code']);
			unset($_POST['language']);
			unset($_POST['ConID']);
			unset($_POST['NowPro']);
			echo "<script>parent.SkipPage('/Message.php?Msg=您未登陆，无法提交代码');</script>";
			return;
		}

		//获取问题编号
		$sql = "SELECT * FROM oj_contest WHERE `ConID`=".$_POST["ConID"];
		$result = mysql_query($sql);
		$ConData = mysql_fetch_array($result);

		$NowDate = date('Y-m-d H:i:s');
		if($NowDate > $ConData['OverTime'])
		{
			echo "<script>parent.SkipPage('/Message.php?Msg=比赛已经结束');</script>";
			return;
		}
		else if($NowDate < $ConData['StartTime'])
		{
			echo "<script>parent.SkipPage('/Message.php?Msg=比赛未开始');</script>";
			return;
		}

		$AllPeople = $ConData['EnrollPeople'];
        $Data = explode('|', $AllPeople);

		if(!in_array($LandUser, $Data))
		{
			//如果处于报名时间内，则添加报名人员
			if($NowDate >= $ConData['EnrollStartTime'] && $NowDate <= $ConData['EnrollOverTime'])
			{
				if($AllPeople == "")
            	{
             	   $AllPeople = $LandUser;
            	}
            	else
            	{
                	$AllPeople .= ('|' . $LandUser);
            	}

            	$sql = "UPDATE oj_contest SET `EnrollPeople` = '".$AllPeople."' WHERE ConID='".$_POST["ConID"]."'"; 
            	mysql_query($sql);
			}
			else
			{
				echo "<script>parent.SkipPage('/Message.php?Msg=您未报名比赛，无法提交代码');</script>";
				return;
			}
		}

		$AllProblem = explode('|', $ConData['Problem']);

		$sql = "SELECT * FROM oj_problem WHERE proNum='".$AllProblem[$_POST["NowPro"]]."'";
		$result = mysql_query($sql);
		$ProblemData = mysql_fetch_array($result);

		//获取运行ID
		$sql = "SELECT * FROM oj_data";
		$result = mysql_query($sql);
		$row = mysql_fetch_array($result);
		$RunID = $row['oj_runid'];

		//输出代码文件
        $myfile = fopen("../Judge/Temporary_Code/".$RunID, "w");
        fwrite($myfile, $_POST["code"]);
		fclose($myfile);

		//输出评测信息
		$myfile = fopen("../Judge/log/data_".$RunID, "w");
		fwrite($myfile, $_POST["language"]);
		fwrite($myfile, '|'.$LandUser);
		fwrite($myfile, '|'.$AllProblem[$_POST["NowPro"]]);
		fwrite($myfile, '|'.$ProblemData['LimitTime']);
		fwrite($myfile, '|'.$ProblemData['LimitMemory']);
		fwrite($myfile, '|');
		fwrite($myfile, $ProblemData['Test']);
		fclose($myfile);
		copy("../Judge/log/data_".$RunID, "../Judge/Temporary_ContestData/".$RunID);

		$CodeLen = mb_strlen($_POST["code"], "utf-8");
		$NowTime = date('Y-m-d H:i:s');
		//向数据库中插入状态
		$sql = 'INSERT INTO oj_constatus(`RunID`, `ConID`, `User`, `Problem`, `Status`, `UseTime`, `UseMemory`, `Language`, `CodeLen`, `SubTime`, `AllStatus`, `Show`) values('.$RunID.', '.$_POST['ConID'].', "'.$LandUser.'", '.$_POST["NowPro"].', "Wating", -1, -1, "'.$_POST["language"].'", '.$CodeLen.', "'.$NowTime.'", " ", 1)';
		$result = mysql_query($sql);
		
		//更新运行ID
		$RunID = $RunID + 1;
		$sql = "UPDATE oj_data SET oj_runid='$RunID' WHERE oj_name='$WebName'"; 
		mysql_query($sql);
		
		//清空post值
		unset($_POST['code']);
		unset($_POST['language']);
		echo "<script>parent.SkipPage('/Contest/Status.php?ConID=".$_POST["ConID"]."');</script>";
		//echo "<script>javascript:location.reload();</script>";
		//header('Location: '.$_SERVER['PHP_SELF']);
	}
	else
	{
		echo "<script>alert('提交代码失败');</script>";
	}
?>