<!DOCTYPE html>

<html lang="zh-cn">
<?php require_once('Php/HTML_Head.php') ?>

<?php
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
		header('Location: /Status.php');
		//return;
	}

	$sql;
	if($User_Jurisdicton == JUR_ADMIN && isset($LandUser))
    {
		$sql = "SELECT * FROM oj_status where RunID='".$RunID."'";
	}
	else
	{
		$sql = "SELECT * FROM oj_status where RunID='".$RunID."' and `Show`=1";
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

<body>
	<?php require_once ('Php/Page_Header.php') ?>

	<div class="container">

		<link rel="stylesheet" href="/highlight/styles/default.css">
		<script src="/highlight/highlight.pack.js"></script>
		<script>hljs.initHighlightingOnLoad("gcc","g++", "C++", "Java", "Python");</script>

		<h3 class="animated fadeInRight">详细评测信息 ID: <?php echo $StatusData['RunID']?> &nbsp;&nbsp;评测机: <?php echo $StatusData['Judger']?>&nbsp;&nbsp;
		<?php
			if($User_Jurisdicton == JUR_ADMIN && isset($LandUser))
			{
				echo '<a class="label label-warning" href="/Php/AfreshEva.php?ReEva='.$RunID.'" target="myIframeNull">重测</a> ';
				echo ' <a class="label label-default" href="/ShowLog.php?RunID='.$RunID.'">日志</a> ';
				echo '<iframe id="myIframe" name="myIframeNull" style="display:none"></iframe>';

				if($StatusData['Show'] == 1)
				{
					echo ' <a class="label label-primary" href="/Php/StatusShow.php?RunID='.$StatusData['RunID'].'" target="myIframeNull">隐藏</a>';
				}
				else
				{
					echo ' <a class="label label-info" href="/Php/StatusShow.php?RunID='.$StatusData['RunID'].'" target="myIframeNull">显示</a>';
				}
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

						<th>用时(ms)</th>
						<th>内存(KB)</th>

						<th>语言</th>
						<th>代码长度(B)</th>
						<th>提交时间</th>
					</tr>
				</thead>
				<tbody>
					<tr>

						<td><?php echo $StatusData['RunID']?></td>
						<td><a href= <?php echo '"/OtherUser.php?User='.$StatusData['User'].'"'?> class= <?php echo GetUserColor($Fight) ?>><?php echo $StatusData['User']?></a></td>
						<td><a href= <?php echo '"/Question.php?Problem='.$StatusData['Problem'].'"'?>> <?php echo $StatusData['Problem']?></a></td>

						<td>
						<?php
						$iStatic = $StatusData['Status'];
						if($iStatic == Wating || $iStatic == Queuing || $iStatic == Compiling || $iStatic == Running)
							echo '<a id="StatusTitle" data-content="点击刷新评测状态" class="label" href="javascript:location.reload();" data-status="'.$AllStatusName[$iStatic].'">'.$AllStatusCName[$iStatic].' '.$AllStatusName[$iStatic].'</a>';
						else
							echo '<span class="label" data-status="'.$AllStatusName[$iStatic].'">'.$AllStatusCName[$iStatic].' '.$AllStatusName[$iStatic].'</span>';
						?>
						</td>

						<td><?php echo $StatusData['UseTime']?></td>
						<td><?php echo $StatusData['UseMemory']?></td>

						<td><?php echo $StatusData['Language']?></td>
						<td><?php echo $StatusData['CodeLen']?></td>
						<td><?php echo $StatusData['SubTime']?></td>

					</tr>
				</tbody>
			</table>
		</div>
		<?php
		if($StatusData['Status'] == CompileError)
		{
			echo '<div class="panel panel-default animated fadeInDown">';
			echo '<div class="panel-heading">编译错误信息</div>';
			echo '<div class="panel-body">';
			$File_Path = './Judge/Temporary_Error/'.$StatusData['RunID'].'.log';
			if(file_exists($File_Path))
			{
				$file_arr = file($File_Path);

				for($i = 0; $i < count($file_arr); $i++)
				{
					$str_encode = mb_convert_encoding($file_arr[$i], 'UTF-8', 'GBK');

					echo $str_encode. "<br/>";
				}
			}
			//$str = file_get_contents($File_Path);
			//$str = str_replace('\r', '<br/>', $str);
			echo '</div>';
			echo '</div>';
		}
		else if($StatusData['Status'] != Wating && $StatusData['Status'] != Queuing && $StatusData['Status'] != Compiling && $StatusData['Status'] != Running)
		{
			echo '<div class="panel panel-default animated fadeInDown">';
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

					echo '<td>#'.$iTest[0];

					if(($User_Jurisdicton == JUR_ADMIN || $User_Jurisdicton == JUR_ONLYVIEWDATA) && isset($LandUser))
					{
						if($iTest[0] < 10)
							echo '&nbsp;&nbsp;&nbsp;';
						else
							echo '&nbsp;';

						echo '<a class="label label-success" href="/ViewData_Def.php?Problem='.$StatusData['Problem'].'&Data='.$iTest[0].'">数据</a>';
					}
					echo '</td>';

					echo '<td><span class="label" data-status="'.$AllStatusName[$iTest[1]].'">'.$AllStatusCName[$iTest[1]].' '.$AllStatusName[$iTest[1]].'</span></td>';
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

		<div class="panel panel-default animated fadeInDown">
			<div class="panel-heading">源代码</div>

			<?php
			if(isset($LandUser))
			{
				if($StatusData['User'] == $LandUser || $User_Jurisdicton == JUR_ADMIN)
				{

					echo '<div class="panel-body">';
					echo '<pre class="padding-0"><code class="C++">';

					$File_Path = './Judge/Temporary_Code/'.$StatusData['RunID'];
					
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
	<?php
	$PageActive = '#status';
	require_once('Php/Page_Footer.php');
	?>
</body>

</html>