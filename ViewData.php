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
	
	$sql = "SELECT * FROM oj_problem WHERE proNum='".$_GET['Problem']."'";
	$result = mysql_query($sql);
	$ProblemData = mysql_fetch_array($result);
	$AllData = explode('&', $ProblemData['Test']);

	if($User_Jurisdicton != JUR_ADMIN && ($ProblemData['Show'] == 0))
	{
		header('Location: /Message.php?Msg=题目已被隐藏，您无权查看测试点');
		return;
	}

?>

<body>
	<?php require_once ('Php/Page_Header.php') ?>
	<div class="container">

		<div class="panel panel-default">
			<div class="panel-heading">题目数据</div>
			<div class="panel-body">
				<div class="panel panel-default animated fadeInLeft">
					<table class="table table-striped table-hover">
						<thead>
							<tr>
								<th>测试点</th>
								<th>数据长度(B)</th>
								<th>查看</th>
							</tr>
						</thead>
						<tbody>

							<?php
							foreach($AllData as $Var)
							{
								$InPath = "./Judge/data/".$_GET['Problem']."/".$_GET['Problem']."_".$Var.".in";
								$OutPath = "./Judge/data/".$_GET['Problem']."/".$_GET['Problem']."_".$Var.".out";

								if(!file_exists($InPath) || !file_exists($OutPath) )
								{
									echo '<tr>';
									echo '<td>'.$Var.'</td>';
									echo '<td>-1</td>';
									echo '<td>测试点错误：文件缺失</td>';
									echo '</tr>';
									continue;
								}

								$Size_1= filesize($InPath);
								$Size_2= filesize($OutPath);
								echo '<tr>';
								echo '<td>'.$Var.'</td>';
								echo '<td>'.($Size_1 + $Size_2).'</td>';
								echo '<td><a href="/ViewData_Def.php?Problem='.$_GET['Problem'].'&Data='.$Var.'">点我~点我~就能看到数据了~</a></td>';
								echo '</tr>';
							}
							?>

						</tbody>
					</table>
				</div>
				<br />
				<center> <a class="btn btn-default" href="javascript:history.go(-1);">返回</a> </center>
			</div>
		</div>
	</div>

	<?php
	$PageActive = '#problem';
	require_once('Php/Page_Footer.php');
	?>
</body>

</html>