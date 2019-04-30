<!DOCTYPE html>

<html lang="zh-cn">

<?php require_once('Php/HTML_Head.php')?>

<?php
	//比赛显示优先级
	const ConDoing = 1;		//进行中
	const ConEnrolling = 2;	//报名中
	const ConnoStart = 3;		//未开始
	const ConOver = 4;			//已结束
	$ModeStr = array('', '正在进行中', '报名中', '未开始', '已结束');
	$ModeCss = array('', 'label-success', 'label-success', 'label-primary', 'label-default');

	$sql = "SELECT * FROM `oj_contest` WHERE `Show`=1 ORDER BY `ConID` desc limit 0, 10";
    if($User_Jurisdicton == JUR_ADMIN && isset($LandUser))
    {
		$sql = "SELECT * FROM `oj_contest` ORDER BY `ConID` desc limit 0, 10";
    }
	$result = mysql_query($sql);
	
	$NowDate = date('Y-m-d H:i:s');

	$AllContest = array();
    while($row = mysql_fetch_array($result))
    {
		$iMode = ConOver;
		if($NowDate <= $row['StartTime'])
		{
			if($NowDate >= $row['EnrollStartTime'] && $NowDate <= $row['EnrollOverTime'])
				$iMode = ConEnrolling;
			else
				$iMode = ConnoStart;
		}
		else if($NowDate <= $row['OverTime'])
		{
			$iMode = ConDoing;
		}
		else
		{
			$iMode = ConOver;
		}

		$AllContest[]= array(
			"ConID" => $row['ConID'],
      "Title" => $row['Title'],
      "Organizer" => $row['Organizer'],
      "Rule" => $row['Rule'],
			"Type" => $row['Type'],
			"Show" => $row['Show'],
			"StartTime" => $row['StartTime'],
			"OverTime" => $row['OverTime'],
			"Mode" => $iMode
        );
	}
	
	
	function my_sort($a, $b)
	{
		if($a['Mode'] == $b['Mode'])
		{
			return $a['ConID'] < $b['ConID'] ? 1 : -1;
		}

		return $a['Mode'] < $b['Mode'] ? -1 : 1;
	}

	usort($AllContest,"my_sort");
	
?>

<body>
	<?php require_once ('Php/Page_Header.php') ?>

	<div class="container animated fadeInLeft">
		<div class="jumbotron">
			<h1><?php echo $WebName ?></h1>
			<p><?php echo $WebTitle ?></p>
			<p><a href="/problem.php" class="btn btn-primary btn-lg" role="button">我要刷题！</a></p>
		</div>

		<h2>近期比赛</h2>

		<div class="panel panel-default">
			<table class="table table-striped table-hover">
				<thead>
					<tr>
						<th>比赛ID</th>
						<?php
						if(isset($LandUser) && $User_Jurisdicton == JUR_ADMIN)
						{
							echo '<th>功能</th>';
						}
						?>
						<th>标题</th>
						<th>比赛状态</th>
						<th>开始时间</th>
						<th>竞赛时长</th>
						<th>比赛规则</th>
						<th>类型</th>
						<th>举办人</th>
					</tr>
				</thead>
				<tbody>
					<?php
						for($i = 0; $i <=  9; $i++)
						{
							if(!isset($AllContest[$i]['ConID']))
                   			{
                    			continue;
							}
							
							echo '<tr>';

							echo '<td>';
							echo '<a href="Contest/Pandect.php?ConID='.$AllContest[$i]['ConID'].'">'.$AllContest[$i]['ConID'].'</a>';
							echo '</td>';

							if(isset($LandUser) && $User_Jurisdicton == JUR_ADMIN)
							{
								echo '<td>';
                        		echo ' <a class="label label-warning" href="/NewContest.php?ConID='.$AllContest[$i]['ConID'].'">编辑</a>';

                        		if($AllContest[$i]['Show'] == 1)
                        		{
                           		 echo ' <a target="myIframeProShow" class="label label-primary" href="/Contest/ContestStatus.php?ConID='.$AllContest[$i]['ConID'].'">隐藏</a>';
                        		}
                        		else
                        		{
                            		echo ' <a target="myIframeProShow" class="label label-info" href="/Contest/ContestStatus.php?ConID='.$AllContest[$i]['ConID'].'">显示</a>';
                        		}
                        
								echo '<iframe id="myIframe" name="myIframeProShow" style="display:none"></iframe>';
								echo '</td>';
							}
							
							echo '<td>';
							echo '<a href="Contest/Pandect.php?ConID='.$AllContest[$i]['ConID'].'">'.$AllContest[$i]['Title'].'</a>';
							echo '</td>';
							
							echo '<td>';
							echo '<span class="label '.$ModeCss[$AllContest[$i]['Mode']].'">'.$ModeStr[$AllContest[$i]['Mode']].'</span>';
							echo '</td>';

							echo '<td>'.$AllContest[$i]['StartTime'].'</td>';

							$Startdate = strtotime($AllContest[$i]['StartTime']);
							$Enddate   = strtotime($AllContest[$i]['OverTime']);

							$Timediff = $Enddate-$Startdate;
							$Days =     intval($Timediff / 86400);
							$Remain =   $Timediff % 86400;
							$Hours =    intval($Remain / 3600);
							$Remain =   $Remain % 3600;
							$Mins =     intval($Remain / 60);
							$Secs =     $Remain % 60;

							echo '<td>';
							if($Days > 0)
							{
								echo $Days.' days ';
							}
							echo $Hours.':'.$Mins.':'.$Secs;

							echo '<td>'.$AllContest[$i]['Rule'].'</td>';
							
							if($AllContest[$i]['Type'] == 1)
							{
								echo '<td><font color="red">Private</font></td>';
							}
							else
							{
								echo '<td><font color="green">Public</font></td>';
							}

							$sql = "SELECT Fight FROM oj_user WHERE name='".$AllContest[$i]['Organizer']."'";
							$result = mysql_query($sql);
							$row = mysql_fetch_array($result);

							echo '<td><a href="/OtherUser.php?User='.$AllContest[$i]['Organizer'].'" class='.GetUserColor($row[0]).'>'.$AllContest[$i]['Organizer'].'</a></td>';

							echo '</tr>';
						}
					
					?>
				</tbody>
			</table>
		</div>

		<h2>注意事项</h2>

		<div class="panel-group" id="accordion">
			<div class="panel panel-default">
				<div class="panel-heading">
					<h4 class="panel-title">
						<span class="label label-danger">置顶</span>
						<a style="color:red" data-toggle="collapse" data-parent="#accordion" href="#collapseOne">禁止向OJ中提交任何恶意代码</a>
					</h4>
				</div>
				<div id="collapseOne" class="panel-collapse collapse in">
					<div class="panel-body">
						评测机在编写时未做安全防护机制，所以请不要在OJ中提交任何恶意代码
					</div>
				</div>
			</div>
			<div class="panel panel-default">
				<div class="panel-heading">
					<h4 class="panel-title">
						<span class="label label-warning">注</span>
						<a data-toggle="collapse" data-parent="#accordion" href="#collapseTwo">
							Java代码注意事项
						</a>
					</h4>
				</div>
				<div id="collapseTwo" class="panel-collapse collapse">
					<div class="panel-body">
						Java代码的类名必须为Main<br>
					</div>
				</div>
			</div>
			<div class="panel panel-default">
				<div class="panel-heading">
					<h4 class="panel-title">
						<a data-toggle="collapse" data-parent="#accordion" href="#collapseThree">
							欢迎来到OpenJudge评测平台
						</a>
					</h4>
				</div>
				<div id="collapseThree" class="panel-collapse collapse">
					<div class="panel-body">
						作者耗费1个月时间编写整个系统框架，欢迎反馈BUG
					</div>
				</div>
			</div>
			<div class="panel panel-default">
				<div class="panel-heading">
					<h4 class="panel-title">
						<a data-toggle="collapse" data-parent="#accordion" href="#collapseFour">
							更新日志
						</a>
					</h4>
				</div>
				<div id="collapseFour" class="panel-collapse collapse">
					<div class="panel-body">
						2019/4/29 修复了比赛界面点击姓名链接无法查看信息的BUG<br>
						2019/4/21 更新题目和比赛页面，如果没有来源、提示或比赛描述，则不显示空内容<br>
						2019/4/21 修改编辑题目&比赛页面的普通编辑框为富文本编辑框<br>
						2019/4/20 修复了选择框默认内容显示错误的BUG<br>
						2019/4/19 更新了分页算法，提高了数据库的读取效率，减轻服务器负担<br>
						2019/4/17 修复了评测机监控内存大小异常的BUG<br>
						2019/4/16 增加了页面的动态显示效果<br>
						2019/4/14 增加了管理员评测日志查看功能<br>
						2019/4/18 修复了评测记录中评测机名称显示错误的BUG<br>
						2019/3/30 更改了连接数据库的方式，提高页面显示效率<br>
						2019/3/27 修复了评测机在TLE时判WrongAnswer的BUG<br>
						2019/3/25 增加了题库和比赛的关键字搜索功能<br>
						2019/3/20 增加了比赛对OI赛制的支持<br>
						2019/3/17 增加了评测机对Java和Python3.6语言的评测支持<br>
					</div>
				</div>
			</div>
		</div>
	</div>

	<?php
	$PageActive = '';
	require_once('Php/Page_Footer.php');
	?>

</body>

</html>