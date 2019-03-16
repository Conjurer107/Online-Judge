<!DOCTYPE html>

<html lang="zh-cn">

<?php require_once("Html_Head.php");?>

<body>
	<?php require_once("Header.php"); ?>

	<?php

	$NowProblem = 0;
	if(array_key_exists('Problem', $_GET))
	{
		$NowProblem = $_GET['Problem'];
	}

	$AllProblem = explode('|', $ConData['Problem']);
	$ProNum = count($AllProblem);
	if($ProNum == 0)
	{
		header('Location: /Message.php?Msg=题目信息获取失败');
		return;
	}

	$sql = "SELECT * FROM oj_problem WHERE `proNum`=".$AllProblem[$NowProblem];
	$result = mysql_query($sql);
	
	if(!$result)
	{
		header('Location: /Message.php?Msg=题目信息获取失败');
		return;
	}
	$ProblemData = mysql_fetch_array($result);

	if(!isset($ProblemData))
	{
		header('Location: /Message.php?Msg=题目信息获取失败');
		return;
	}

	$NowDate = date('Y-m-d H:i:s');

	if($NowDate < $ConData['StartTime'])
	{
		if($User_Jurisdicton != JUR_ADMIN || !isset($LandUser))
		{
			header('Location: /Message.php?Msg=比赛未开始');
			return;
		}
	}

	$sql = "SELECT count(*) as value FROM oj_constatus where `Status` = 'Accepted' and `Show`=1 and `Problem` = ".$NowProblem." and `ConID`=".$ConID;
	if(isset($LandUser) && $User_Jurisdicton == JUR_ADMIN)
	{
		$sql = "SELECT count(*) as value FROM oj_constatus where `Status` = 'Accepted' and `Problem` = ".$NowProblem." and `ConID`=".$ConID;
	}
	$rs = mysql_query($sql);
	$PassNum = mysql_fetch_array($rs);

	$sql = "SELECT count(*) as value FROM oj_constatus where `Show`=1 and `Problem` = ".$NowProblem." and `ConID`=".$ConID;
	if(isset($LandUser) && $User_Jurisdicton == JUR_ADMIN)
	{
		$sql = "SELECT count(*) as value FROM oj_constatus where `Problem` = ".$NowProblem." and `ConID`=".$ConID;
	}
	$rs = mysql_query($sql);
	$SubNum = mysql_fetch_array($rs);
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

				<center>
					<ul class="pagination">
						<?php
						for($i = 0; $i < $ProNum; $i++)
						{
							echo '<li id="p_'.$ProEngNum[$i].'"><a href="/Contest/Problem.php?ConID='.$ConID.'&Problem='.$i.'">'.$ProEngNum[$i].'</a></li>';
						}
						?>

					</ul>
				</center>

				<link rel="stylesheet" href="/highlight/styles/default.css">
				<script src="/highlight/highlight.pack.js"></script>
				<script>hljs.initHighlightingOnLoad("gcc","g++", "C++", "Java", "Python");</script>

				<script src="/CodeMirror/codemirror.js"></script>
				<link rel="stylesheet" href="/CodeMirror/codemirror.css">
				<script src="/CodeMirror/clike.js"></script>
				<script src="/CodeMirror/pascal.js"></script>
				<script src="/CodeMirror/python.js"></script>
				<script src="/CodeMirror/matchbrackets.js"></script>

				<h1 class="text-center"><?php echo $ProblemData['Name']?></h1>
				<table class="autotable" align="center">
					<tr>
						<td><b>时间限制：</b><?php echo $ProblemData['LimitTime']?>ms</td>
						<td><b>内存限制：</b><?php echo $ProblemData['LimitMemory']?>KB</td>
					</tr>

					<?php
					if($ConData['Rule'] == 'ACM' || ($User_Jurisdicton == JUR_ADMIN) || $NowDate >= $ConData['OverTime'])
					{
						echo '<tr>';
						echo '<td><b>提交总数：</b>'.$SubNum['value'].'</td>';
						echo '<td><b>通过人数：</b>'.$PassNum['value'].'</td>';
						echo '</tr>';
					}
					?>

				</table>
				<br>

				<center>
					<div class="btn-group">
						<button type="button" class="btn btn-default" id="btnShowSubmit" data-backdrop="static" data-toggle="modal"
							data-target="#submitcode">提交代码</button>
						<a type="button" class="btn btn-default" href=<?php echo '"/Contest/Status.php?ConID='.$ConID.'&Problem='.$ProEngNum[$NowProblem].'"';?>>查看记录</a>
					</div>
				</center>
				<h3>题目描述</h3>
				<div class="panel panel-default">
					<div class="panel-body"><?php echo $ProblemData['Description']?></div>
				</div>
				<h3>输入格式</h3>
				<div class="panel panel-default">
					<div class="panel-body"><?php echo $ProblemData['InputFormat']?></div>
				</div>
				<h3>输出格式</h3>
				<div class="panel panel-default">
					<div class="panel-body"><?php echo $ProblemData['OutputFormat']?></div>
				</div>
				<h3>样例输入</h3>
				<div class="panel panel-default">
					<div class="panel-body"><?php echo $ProblemData['EmpInput']?></div>
				</div>
				<h3>样例输出</h3>
				<div class="panel panel-default">
					<div class="panel-body"><?php echo $ProblemData['EmpOutput']?></div>
				</div>

				<h3>提示</h3>
				<div class="panel panel-default">
					<div class="panel-body"><?php echo $ProblemData['Hint']?></div>
				</div>


				<h3>来源</h3>
				<div class="panel panel-default">
					<div class="panel-body"><?php echo $ProblemData['Source']?></div>
				</div>


				<center>
					<div class="btn-group">
						<button type="button" class="btn btn-default" id="btnShowSubmit" data-backdrop="static" data-toggle="modal"
							data-target="#submitcode">提交代码</button>
							<a type="button" class="btn btn-default" href=<?php echo '"/Contest/Status.php?ConID='.$ConID.'&Problem='.$ProEngNum[$NowProblem].'"';?>>查看记录</a>
					</div>
				</center>

				<div class="modal fade" id="submitcode" tabindex="-1" role="dialog" aria-hidden="true">
					<div class="modal-dialog">
						<div class="modal-content">
							<form action="/Contest/SubmitCode.php" method="post" target="myIframeSubCode">
								<div class="modal-body" id="codemodalbody">
									<textarea hidden name="code" id="codeeditor"></textarea>
									<textarea hidden name="ConID" id="ConID"><?php echo $ConID?></textarea>
									<textarea hidden name="NowPro" id="NowPro"><?php echo $NowProblem?></textarea>
								</div>
								<div class="modal-footer">
									<div class="float-left">
										语言：
										<select name="language" id="language" style="height:32px;width:120px;">

										<option value="gcc">gcc</option>
										<option value="g++">g++</option>
										<option value="C++">C++</option>
										<option value="Java">Java</option>
										<option value="Python">Python3.6</option>
										</select>
										<input type="submit" class="btn btn-primary" value="提交代码">
									</div>
									<button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
								</div>
							</form>
							<iframe id="myIframe" name="myIframeSubCode" style="display:none"></iframe>
						</div>
					</div>
				</div>


			</div>
		</div>

	</div>
	<?php
    $PageActive = "#c_problem,#p_".$ProEngNum[$NowProblem]."";
	require_once('Footer.php');
	?>
</body>

</html>