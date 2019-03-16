<!DOCTYPE html>

<html lang="zh-cn">
<?php require_once('Php/HTML_Head.php') ?>

<?php

	if(!isset($LandUser))
    {
        header('Location: /Message.php?Msg=您没有登陆，无权访问测试点页面');
		return;
    }
    if($User_Jurisdicton != JUR_ADMIN && $User_Jurisdicton != JUR_ONLYVIEWDATA)
    {
        header('Location: /Message.php?Msg=您无权访问测试点页面');
		return;
	}
	if(!array_key_exists('Problem', $_GET))
	{
		header('Location: /Message.php?Msg=未知题号');
		return;
	}
	if(!array_key_exists('Data', $_GET))
	{
		header('Location: /Message.php?Msg=未知测试点');
		return;
	}

	if($User_Jurisdicton != JUR_ADMIN)
	{
		$sql = "SELECT * FROM oj_problem WHERE proNum='".$_GET['Problem']."'";
		$result = mysql_query($sql);
		$ProblemData = mysql_fetch_array($result);

		if($ProblemData['Show'] == 0)
		{
			header('Location: /Message.php?Msg=题目已被隐藏，您无权查看测试点');
			return;
		}
	}
	$FileIn_Path = "./Judge/data/".$_GET['Problem']."/".$_GET['Problem']."_".$_GET['Data'].".in";
	$FileOut_Path = "./Judge/data/".$_GET['Problem']."/".$_GET['Problem']."_".$_GET['Data'].".out";
?>

<body>
	<?php require_once ('Php/Page_Header.php') ?>
	<div class="container">


		<h3>测试点 # <?php echo $_GET['Data']?></h3>
		<br>
		<div class="panel panel-default">
			<div class="panel-heading">输入数据</div>
			<div class="panel-body">
				<pre class="SlateFix"><?php
					if(file_exists($FileIn_Path))
					{
						$file_arr = file($FileIn_Path);
						
						for($i = 0; $i < count($file_arr); $i++)
						{
							$str = $file_arr[$i];
							$str = str_replace("<","&lt;", $str);
							$str = str_replace(">","&gt;", $str);
							echo $str;
						}
					}
					?>
				</pre>
			</div>
		</div>

		<div class="panel panel-default">
			<div class="panel-heading">输出数据</div>
			<div class="panel-body">
				<pre class="SlateFix"><?php
					if(file_exists($FileOut_Path))
					{
						$file_arr = file($FileOut_Path);
						
						for($i = 0; $i < count($file_arr); $i++)
						{
							$str = $file_arr[$i];
							$str = str_replace("<","&lt;", $str);
							$str = str_replace(">","&gt;", $str);
							echo $str;
						}
					}
					?>
				</pre>
			</div>
		</div>

	</div>
	<?php
	$PageActive = '#problem';
	require_once('Php/Page_Footer.php');
	?>
</body>

</html>