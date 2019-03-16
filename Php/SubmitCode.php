<?php
	require_once("LoadData.php");
	LoadData();
    
    if(isset($_POST["code"]) && $_POST["language"])
    {
		if(!isset($LandUser))
		{
			unset($_POST['code']);
			unset($_POST['language']);
			echo "<script>parent.SkipPage('/Message.php?Msg=您未登陆，无法提交代码');</script>";
			return;
		}

		$sql = "SELECT * FROM oj_problem WHERE proNum='".$_POST["pid"]."'";
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
		fwrite($myfile, '|'.$_POST["pid"]);
		fwrite($myfile, '|'.$ProblemData['LimitTime']);
		fwrite($myfile, '|'.$ProblemData['LimitMemory']);
		fwrite($myfile, '|');
		fwrite($myfile, $ProblemData['Test']);
		fclose($myfile);
		copy("../Judge/log/data_".$RunID, "../Judge/Temporary_Data/".$RunID);

		$CodeLen = mb_strlen($_POST["code"], "utf-8");
		$NowTime = date('Y-m-d H:i:s');
		//向数据库中插入状态
		$sql = 'INSERT INTO oj_status(`RunID`, `User`, `Problem`, `Status`, `UseTime`, `UseMemory`, `Language`, `CodeLen`, `SubTime`, `AllStatus`, `Show`) values('.$RunID.', "'.$LandUser.'", '.$_POST["pid"].', "Wating", -1, -1, "'.$_POST["language"].'", '.$CodeLen.', "'.$NowTime.'", " ", 1)';
		$result = mysql_query($sql);
		
		//更新运行ID
		$RunID = $RunID + 1;
		$sql = "UPDATE oj_data SET oj_runid='$RunID' WHERE oj_name='$WebName'"; 
		mysql_query($sql);
		
		//清空post值
		unset($_POST['code']);
		unset($_POST['language']);
		echo "<script>parent.SkipPage('/Status.php');</script>";
		//echo "<script>javascript:location.reload();</script>";
		//header('Location: '.$_SERVER['PHP_SELF']);
	}
?>