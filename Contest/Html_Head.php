<?php
	require_once("../Php/LoadData.php");
	LoadData();

	$Skin = "";

	if(isset($LandUser))
	{
		$sql = "SELECT * FROM oj_user where name='".$LandUser."'";
		$rs = mysql_query($sql);
		if(!$rs)
		{
			unset($_SESSION['username']);
			header('Location: /Message.php?Msg=用户信息载入失败');
			return;
		}
		$row = mysql_fetch_array($rs);
		$Skin = $row['skin'];
	}
	
	if(!array_key_exists('ConID', $_GET))
	{
		header('Location: /Message.php?Msg=比赛信息获取失败');
		return;
	}

	$ConID = $_GET['ConID'];

	$sql = "SELECT * FROM oj_contest WHERE `ConID`=".$ConID;
	$result = mysql_query($sql);
	$ConData = mysql_fetch_array($result);

	if(!$ConData)
  {
		header('Location: /Message.php?Msg=比赛信息获取失败');
		return;
	}
	
	if($ConData['Show'] == 0 && ($User_Jurisdicton != JUR_ADMIN))
  {
		header('Location: /Message.php?Msg=比赛已被隐藏');
		return;
	}

	if($ConData['Type'] == 1 && $_SERVER['PHP_SELF'] != "/Contest/PassWord.php" && ($User_Jurisdicton != JUR_ADMIN))
	{
		if(isset($_SESSION['ConPassWord']))
		{
			if($_SESSION['ConPassWord'] != $ConData['PassWord'])
			{
				unset($_SESSION['ConPassWord']);
				header('Location: /Contest/PassWord.php?ConID='.$ConID);
				return;
			}
		}
		else
		{
			header('Location: /Contest/PassWord.php?ConID='.$ConID);
			return;
		}
	}

	$ProEngNum = array('A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z');
	$NowDate = date('Y-m-d H:i:s');
?>


<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo $WebHtmlTitle?></title>
	<link href="/css/custom.css" rel="stylesheet">
	<link href="/css/community.css" rel="stylesheet">
    <script src="/js/jquery-1.11.1.min.js"></script>
	<script src="/js/jsencrypt.min.js"></script>
	<script>
	(function(){
		var addcss=function(file){
			document.write('<link href="'+file+'" rel="stylesheet">');
		};
		
		<?php
			if(isset($LandUser))
			{
				echo "addcss('/css/bootstrap.".$Skin.".min.css');";
			}
			else
			{
				echo "addcss('/css/bootstrap.spacelab.min.css');";
			}
			
			?>
		
	})();
	function RefreshPage()
	{
			location.reload();
	}

	function GoHistoryPage()
	{
			history.go(-1);
	}


	function SkipPage(href)
	{
			 location.href = href; 
	}
	</script>
</head>