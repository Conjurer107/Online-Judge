<?php
	require_once('Php/LoadData.php');
	
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
?>

<head>
	<meta name="robots" content="index">
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	
	<title><?php echo $WebHtmlTitle ?></title>

	<link href="css/custom.css" rel="stylesheet">
	<link href="css/community.css" rel="stylesheet">
	<script src="js/jquery-1.11.1.min.js"></script>
	<script src="js/jsencrypt.min.js"></script>

	<script>
		(function () {
			var addcss = function (file) {
				document.write('<link href="' + file + '" rel="stylesheet">');
			};
			
			<?php
			//$AllSkin = array('Cerulean', 'cosmo', 'custom', 'cyborg', 'darkly', 'flatly', 'journal', 'lumen', 'paper', 'readable', 'sandstone', 'simplex', 'Slate', 'spacelab', 'superhero', 'united', 'yeti');
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
	</script>

	<script language="javascript" type="text/javascript">

    function RefreshPage() {
        location.reload();
	}
	
	function GoHistoryPage() {
        history.go(-1);
	}
	

	function SkipPage(href) {
         location.href = href; 
	}
	
	</script>

</head>