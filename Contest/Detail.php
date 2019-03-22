<!DOCTYPE html>

<html lang="zh-cn">

<?php require_once("Html_Head.php");?>

<body>

	<?php
		require_once("Header.php");

	const Wating = 0;
	const Queuing = 1;
	const Compiling = 2;
	const Running = 3;
	const Accepted = 4;
	const PresentationError = 5;
	const TimeLimitExceeded = 6;
	const MemoryLimitExceeded = 7;
	const WrongAnswer = 8;
	const RuntimeError = 9;
	const OutputLimitExceeded = 10;
	const CompileError = 11;
	const SystemError = 12;

	$AllStatusName = array("Wating", "Queuing", "Compiling", "Running", "Accepted", "Presentation Error", "Time Limit Exceeded", "Memory Limit Exceeded", "Wrong Answer", "Runtime Error", "Output Limit Exceeded", "Compile Error", "System Error");

	$RunID = 0;
	if(array_key_exists('RunID', $_GET))
  	{
		$RunID = $_GET['RunID'];

		if($RunID > $JudgeMacRunID - 1)
		{
			header('Location: /Message.php?Msg=信息获取出现错误');
			return;
		}
		else if($RunID < 1)
		{
			header('Location: /Message.php?Msg=信息获取出现错误');
			return;
		}
	}
	else
	{
		header('Location: /Contest/Status.php');
		//return;
	}

	$sql;
	if($User_Jurisdicton == JUR_ADMIN && isset($LandUser))
    {
		$sql = "SELECT * FROM oj_constatus where RunID='".$RunID."'";
	}
	else
	{
		$sql = "SELECT * FROM oj_constatus where RunID='".$RunID."' and `Show`=1";
	}
	$rs = mysql_query($sql);
	$row = mysql_fetch_array($rs);
	if(!$row)
	{
		header('Location: /Message.php?Msg=未找到该状态信息');
		return;
	}

	$StatusData = $row;

	$sql = "SELECT Fight FROM oj_user WHERE name='".$StatusData['User']."'";
	$result = mysql_query($sql);
	$row = mysql_fetch_array($result);
	$Fight = $row[0];

	$AllStatus = explode("|", $StatusData['AllStatus']);
	 ?>

	<div class="container">
		<div class="panel panel-default">
			<div id="contesthead" class="panel-heading" style="padding:0 0 0 0;">
				<ul class="nav nav-tabs" role="tablist">

					<li>
						<h4>&nbsp;</h4>
					</li>
				</ul>
			</div>
			<div class="panel-body">

				<link rel="stylesheet" href="/highlight/styles/default.css">
				<script src="/highlight/highlight.pack.js"></script>
				<script>hljs.initHighlightingOnLoad("C", "C++", "Java", "Python");</script>

				<h3>详细评测信息 ID: <?php echo $StatusData['RunID']?> &nbsp;&nbsp;评测机: SETIUO&nbsp;&nbsp;
					<?php
					if($User_Jurisdicton == JUR_ADMIN && isset($LandUser))
					{
						echo '<a class="label label-warning" href="/Contest/AfreshEva.php?ConID='.$ConID.'&ReEva='.$RunID.'" target="myIframeNULL">重测</a> ';

						if($StatusData['Show'] == 1)
						{
							echo ' <a class="label label-primary" href="/Contest/StatusShow.php?RunID='.$StatusData['RunID'].'" target="myIframeNULL">隐藏</a>';
						}
						else
						{
							echo ' <a class="label label-info" href="/Contest/StatusShow.php?RunID='.$StatusData['RunID'].'" target="myIframeNULL">显示</a>';
						}

						echo '<iframe id="myIframe" name="myIframeNULL" style="display:none"></iframe>';
					}
				?>

				</h3>
				<div class="panel panel-default">
					<table class="table table-striped table-hover">
						<thead>
							<tr>
								<th>运行ID</th>
								<th>用户</th>
								<th>题号</th>
								<th>评测结果</th>

								<?php
								if($ConData['Rule'] == 'ACM' || ($User_Jurisdicton == JUR_ADMIN) || $NowDate >= $ConData['OverTime'])
								{
									echo '<th>用时(ms)</th>';
									echo '<th>内存(KB)</th>';
								}
								?>

								<th>语言</th>
								<th>代码长度(B)</th>
								<th>提交时间</th>
							</tr>
						</thead>
						<tbody>
							<tr>

								<td><?php echo $StatusData['RunID']?></td>
								<td><a href=<?php echo '"/OtherUser.php?User='. $StatusData['User'].'"'?>
										class=<?php echo GetUserColor($Fight) ?>><?php echo $StatusData['User']?></a>
								</td>
								<td><a href=<?php echo '"/Contest/Problem.php?ConID='.$ConID.'&Problem='.$StatusData['Problem'].'"'?>>
										<?php echo $ProEngNum[$StatusData['Problem']]?></a></td>

								<td>
									<?php

									if($ConData['Rule'] == 'ACM' || ($User_Jurisdicton == JUR_ADMIN) || $NowDate >= $ConData['OverTime'])
									{
										if($StatusData['Status'] == 'Running' || $StatusData['Status'] == 'Compiling' || $StatusData['Status'] == 'Wating' || $StatusData['Status'] == 'Queuing')
											echo '<a class="label" href="javascript:location.reload();" data-status="'.$StatusData['Status'].'">'.$StatusData['Status'].'</a>';
										else
											echo '<span class="label" data-status="'.$StatusData['Status'].'">'.$StatusData['Status'].'</span>';
									}
									else
									{
										echo '<span class="label" data-status="Accepted">Submit Success</span>';
									}
								?>
								</td>

								<?php
									if($ConData['Rule'] == 'ACM' || ($User_Jurisdicton == JUR_ADMIN) || $NowDate >= $ConData['OverTime'])
									{
										echo '<td>'.$StatusData['UseTime'].'</td>';
										echo '<td>'.$StatusData['UseMemory'].'</td>';
									}
								?>

								<td><?php echo $StatusData['Language']?></td>
								<td><?php echo $StatusData['CodeLen']?></td>
								<td><?php echo $StatusData['SubTime']?></td>

							</tr>
						</tbody>
					</table>
				</div>
				
				<div class="panel panel-default">

					<?php
		if($StatusData['Status'] == 'Compile Error' && ($ConData['Rule'] == 'ACM' || ($User_Jurisdicton == JUR_ADMIN) || $NowDate >= $ConData['OverTime']))
		{
			echo '<div class="panel-heading">编译错误信息</div>';
			echo '<table class="table table-striped table-hover">';
			echo '<thead>';
			echo '<tr>';
			echo '<th>';
			$File_Path = '../Judge/Temporary_Error/'.$StatusData['RunID'].'.log';
			if(file_exists($File_Path))
			{
				$file_arr = file($File_Path);
				
				for($i = 0; $i < count($file_arr); $i++)
				{
					$str_encode = mb_convert_encoding($file_arr[$i], 'UTF-8', 'GBK');
					echo $str_encode . "<br/>";
				}
			}
			//$str = file_get_contents($File_Path);
			//$str = str_replace('\r', '<br/>', $str);
			echo '</th>';
			echo '</tr>';
			echo '</thead>';
			echo '</table>';
			echo '</div>';
		}
		else if($ConData['Rule'] == 'ACM' || ($User_Jurisdicton == JUR_ADMIN) || $NowDate >= $ConData['OverTime'])
		{
			echo '<div class="panel-heading">测试点详情</div>';
			echo '<table class="table table-striped table-hover">';
			echo '<thead>';
			echo '<tr>';
			echo '<th>测试点</th>';
			echo '<th>评测结果</th>';
			echo '<th>用时(ms)</th>';
			echo '<th>内存(KB)</th>';
			echo '<th>返回值</th>';
			echo '</tr>';
			echo '</thead>';
			echo '<tbody>';

			foreach($AllStatus as $val)
			{
					$iTest = explode("&", $val);

					if(count($iTest) == 5)
					{
						echo '<tr>';
					echo '<td>#'.$iTest[0].'</td>';
					echo '<td><span class="label" data-status="'.$AllStatusName[$iTest[1]].'">'.$AllStatusName[$iTest[1]].'</span></td>';
					echo '<td>'.$iTest[2].'</td>';
					echo '<td>'.$iTest[3].'</td>';
					echo '<td>'.$iTest[4].'</td>';
					echo '</tr>';
					}

			}
			echo '</tbody>';
			echo '</table>';
			echo '</div>';
		}
		?>


<div class="panel panel-default">
			<div class="panel-heading">源代码</div>

			<?php
			if(isset($LandUser))
			{
				if($StatusData['User'] == $LandUser || $User_Jurisdicton == JUR_ADMIN)
				{

					echo '<div class="panel-body">';
					echo '<pre class="padding-0"><code class="C++">';

					$File_Path = '../Judge/Temporary_Code/'.$StatusData['RunID'];
					
					if(file_exists($File_Path))
					{
						$file_arr = file($File_Path);
						
						for($i = 0; $i < count($file_arr); $i++)
						{
							$str = $file_arr[$i];
							$str = str_replace("<","&lt;", $str);
							$str = str_replace(">","&gt;", $str);
							echo $str;
						}
					}

					echo '</code></pre></div>';
				}
				else
				{
					echo <<<NOTCODE
				<div class="panel-body">
				<p>您只能查看自己的代码哦~</p>
				</div>
NOTCODE;
				}
			}
			else
			{
				echo <<<NOTCODE
				<div class="panel-body">
				<p>您还没有登陆，不能查看代码哦~</p>
				</div>
NOTCODE;
			}
			?>
		</div>
		</div>

	</div>
	</div>
		<?php
    $PageActive = "#c_status";
	require_once('Footer.php');
	?>
</body>

</html>