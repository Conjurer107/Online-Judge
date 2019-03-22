<!DOCTYPE html>

<html lang="zh-cn">

<?php require_once("Html_Head.php");?>

<body>
	<?php require_once("Header.php");?>

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

				<table class="autotable" align="center">

					<tr>
						<td><b>竞赛规则:</b><?php echo $ConData['Rule']?></td>
					</tr>

					<tr>
						<td><b>开始时间:</b><?php echo $ConData['StartTime']?></td>
						<td><b>结束时间:</b><?php echo $ConData['OverTime']?></td>
					</tr>

					<tr>
						<td><b>报名时间:</b><?php echo $ConData['EnrollStartTime']?></td>
						<td><b>报名截止:</b><?php echo $ConData['EnrollOverTime']?></td>
					</tr>

					<tr>
						<?php
						$ConStatus;
						$EnrollStatus;

						if($NowDate <= $ConData['StartTime'])
						{
							$ConStatus = 0;
							echo '<td><b>比赛状态:</b><font class="label label-primary">未开始</font></td>';
						}
						else if($NowDate <= $ConData['OverTime'])
						{
							$ConStatus = 1;
							echo '<td><b>比赛状态:</b><font class="label label-success">正在进行中</font></td>';
						}
						else
						{
							$ConStatus = 2;
							echo '<td><b>比赛状态:</b><font class="label label-default">已结束</font></td>';
						}

						if($NowDate <= $ConData['EnrollStartTime'])
						{
							echo '<td><b>报名状态:</b><font class="label label-primary">未开始</font></td>';
						}
						else
						{
							$AllPeople = $ConData['EnrollPeople'];
        					$Data = explode('|', $AllPeople);

							if($NowDate <= $ConData['EnrollOverTime'])
							{
								if(!in_array($LandUser, $Data) || !isset($LandUser))
        						{
									echo '<td><b>报名状态:</b><a class="label label-success" href="/Contest/JoinContest.php?ConID='.$ConID.'" target="myIframeNULL">立即报名</a></td>';
									echo '<iframe id="myIframe" name="myIframeNULL" style="display:none"></iframe>';
								}
								else
								{
									echo '<td><b>报名状态:</b><font class="label label-success">已报名</font></td>';
								}
							}
							else
							{
								if(!in_array($LandUser, $Data))
        						{
									echo '<td><b>报名状态:</b><font class="label label-default">报名已截止</font></td>';
								}
								else
								{
									if(!in_array($LandUser, $Data) || !isset($LandUser))
        							{
										echo '<td><b>报名状态:</b><font class="label label-default">报名已截止</font></td>';
									}
									else
									{
										echo '<td><b>报名状态:</b><font class="label label-success">已报名</font></td>';
									}
								}
							}
						}
					?>
					</tr>

					<?php
						$sql = "SELECT Fight FROM oj_user WHERE `name`='".$ConData['Organizer']."'";
						$result = mysql_query($sql);
						$Fight = mysql_fetch_array($result);
					?>
					<tr>
						<td><b>参赛人数:</b><?php echo (isset($Data) && ($AllPeople != ''))?count($Data):0?></td>
						<td><b>举办人:</b>
							<font class=<?php echo GetUserColor($Fight[0]) ?>><?php echo $ConData['Organizer']?></font>
						</td>
					</tr>

					<tr>
						<td><b>风险系数:</b><?php echo $ConData['RiskRatio']?></td>
						<?php
						if($ConData['RatingStatus'] == 0)
						{
							if(isset($LandUser) && $User_Jurisdicton == JUR_ADMIN)
							{
								echo '<td>';
								echo '<b>战斗力结算完毕:</b><a class="label label-warning" href="" target="myIframeNULL">立即结算</a>';
								echo '<iframe id="myIframe" name="myIframeNULL" style="display:none"></iframe>';
								echo '</td>';
							}
							else
							{
								echo '<td><b>战斗力结算完毕:</b><font class="label label-danger">未结算</font></td>';
							}
						}
						else
						{
							echo '<td><b>战斗力结算完毕:</b><font class="label label-success">已结算</font></td>';
						}
						?>
					</tr>

				</table>
				<h3>比赛简介</h3>
				<div class="panel panel-default">
					<div class="panel-body">
						<?php echo $ConData['Synopsis']?>
					</div>
				</div>

				<h3>题目列表</h3>
				<div class="panel panel-default">
					<table class="table table-striped table-hover">
						<thead>
							<tr>
								<th>题号</th>
								<th>题目名称</th>
								<?php
								if($ConData['Rule'] == 'ACM' || ($User_Jurisdicton == JUR_ADMIN) || $NowDate >= $ConData['OverTime'])
								{
									echo '<th>通过人数</th>';
									echo '<th>总提交次数</th>';
								}
								?>
							</tr>
						</thead>
						<tbody>

						<?php
							$AllProblem = explode('|', $ConData['Problem']);
							$ProNum = count($AllProblem);

							for($i=0; $i<$ProNum; $i++)
							{
								$sql = "SELECT * FROM oj_problem WHERE `proNum`=".$AllProblem[$i];
								$result = mysql_query($sql);
								if(!$result)
								{
									continue;
								}
								$ProblemData = mysql_fetch_array($result);
			
								$sql = "SELECT count(*) as value FROM oj_constatus where `Status` = 'Accepted' and `Show`=1 and `Problem` = ".$i." and `ConID`=".$ConID;
								if(isset($LandUser) && $User_Jurisdicton == JUR_ADMIN)
								{
									$sql = "SELECT count(*) as value FROM oj_constatus where `Status` = 'Accepted' and `Problem` = ".$i." and `ConID`=".$ConID;
								}
								$rs = mysql_query($sql);
								$PassNum = mysql_fetch_array($rs);

								$sql = "SELECT count(*) as value FROM oj_constatus where `Show`=1 and `Problem` = ".$i." and `ConID`=".$ConID;
								if(isset($LandUser) && $User_Jurisdicton == JUR_ADMIN)
								{
									$sql = "SELECT count(*) as value FROM oj_constatus where `Problem` = ".$i." and `ConID`=".$ConID;
								}
								$rs = mysql_query($sql);
								$SubNum = mysql_fetch_array($rs);

								echo '<tr>';

								echo '<td>'.$ProEngNum[$i].'</td>';
								echo '<td>';
								echo '<a href="/Contest/Problem.php?ConID='.$ConID.'&Problem='.$i.'">'.$ProblemData['Name'].'</a>';
								if($ConStatus == 2 || (isset($LandUser) && $User_Jurisdicton == JUR_ADMIN))
								{
									echo ' [题库题号 <a href="/Question.php?Problem='.$AllProblem[$i].'">P'.$AllProblem[$i].'</a>]';
								}
								echo '</td>';

								if($ConData['Rule'] == 'ACM' || ($User_Jurisdicton == JUR_ADMIN) || $NowDate >= $ConData['OverTime'])
								{
									echo '<td>'.$PassNum['value'].'</td>';
									echo '<td>'.$SubNum['value'].'</td>';
								}

								echo '</tr>';
							}
						?>
						</tbody>
					</table>
				</div>

			</div>
		</div>

	</div>

	<?php
  $PageActive = "#c_overview";
	require_once('Footer.php');
?>

</body>

</html>