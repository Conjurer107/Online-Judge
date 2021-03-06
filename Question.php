<!DOCTYPE html>

<html lang="zh-cn">
<?php require_once('Php/HTML_Head.php') ?>

<?php
	$ProblemID;

	if(array_key_exists('Problem', $_GET))
	{
		$ProblemID = $_GET['Problem'];

		$ProblemID = $_GET['Problem'];
		$sql = "SELECT * FROM oj_problem WHERE proNum=".$ProblemID;
		$result = mysql_query($sql);
		$ShowRow = mysql_fetch_array($result);

		if(!isset($ShowRow['Show']))
		{
			header('Location: /Message.php?Msg=未找到题目');
			return;
		}
		if($ShowRow['Show'] == 0 && ($User_Jurisdicton != JUR_ADMIN))
        {
			header('Location: /Message.php?Msg=题目已被隐藏');
			return;
		}
	}
	else
	{
		header('Location: /Message.php?Msg=未知题号');
		return;
	}

	$sql = "SELECT * FROM oj_problem WHERE proNum='".$ProblemID."'";
	$result = mysql_query($sql);
	$ProblemData;

	if($result)
	{
		$ProblemData = mysql_fetch_array($result);

		if(!$ProblemData)
		{
			header('Location: /Message.php?Msg=未知题号');
			return;
		}

	}
	else
	{
		header('Location: /Message.php?Msg=查找失败');
		return;
	}
	
	$sql = "SELECT count(*) as value FROM oj_status where `Status` = ".Accepted." and `Show`=1 and `Problem` = ".$ProblemID;
	if(isset($LandUser) && $User_Jurisdicton == JUR_ADMIN)
	{
		$sql = "SELECT count(*) as value FROM oj_status where Status = ".Accepted." and Problem = ".$ProblemID;
	}
    $rs = mysql_query($sql);
	$PassNum = mysql_fetch_array($rs);
	$PassNum = $PassNum['value'];

	$sql = "SELECT count(*) as value FROM oj_status where `Show`=1 and `Problem` = ".$ProblemID;
	if(isset($LandUser) && $User_Jurisdicton == JUR_ADMIN)
	{
		$sql = "SELECT count(*) as value FROM oj_status where `Problem` = ".$ProblemID;
	}
    $rs = mysql_query($sql);
	$SubNum = mysql_fetch_array($rs);
	$SubmitNum = $SubNum['value'];
?>

<body>
	<?php require_once ('Php/Page_Header.php') ?>
	
	<div class="container">

		<script src="/CodeMirror/codemirror.js"></script>
		<link rel="stylesheet" href="/CodeMirror/codemirror.css">
		<script src="/CodeMirror/clike.js"></script>
		<script src="/CodeMirror/pascal.js"></script>
		<script src="/CodeMirror/python.js"></script>
		<script src="/CodeMirror/matchbrackets.js"></script>

		<link rel="stylesheet" href="/highlight/styles/default.css">
		<script src="/highlight/highlight.pack.js"></script>
		<script>hljs.initHighlightingOnLoad("C", "C++", "Java", "Python");</script>

		<div class="animated fadeInDown">
		<h1 class="text-center"><?php echo $ProblemData['Name']?>
		<?php
			if($User_Jurisdicton == JUR_ADMIN && isset($LandUser))
			{
				echo '<a class="label label-success" href="/ViewData.php?Problem='.$ProblemID.'">查看数据</a> ';
				echo '<a class="label label-warning" href="/NewProblem.php?Problem='.$ProblemID.'">编辑</a> ';

				if($ShowRow['Show'] == 1)
                {
					echo '<a target="myIframeProShow" class="label label-primary" href="/Php/ProblemStatus.php?Problem='.$ProblemID.'">隐藏</a>';
				}
				else
				{
					echo '<a target="myIframeProShow" class="label label-info" href="/Php/ProblemStatus.php?Problem='.$ProblemID.'">显示</a>';
				}

				echo '<iframe id="myIframe" name="myIframeProShow" style="display:none">改变状态</iframe>';
			}
			else if($User_Jurisdicton == JUR_ONLYVIEWDATA && isset($LandUser))
			{
				echo '<a class="label label-success" href="/ViewData.php?Problem='.$ProblemID.'">查看数据</a> ';
			}
		?>
		</h1>

		<table class="autotable" align="center">
			<tr>
				<td><b>时间限制：</b><?php echo $ProblemData['LimitTime']?>ms</td>
				<td><b>内存限制：</b><?php echo $ProblemData['LimitMemory']?>kb</td>
			</tr>

			<tr>
				<td><b>提交总数：</b><?php echo $SubmitNum?></td>
				<td><b>通过数量：</b><?php echo $PassNum?></td>
			</tr>

		</table>
		<br>

		<center>
			<div class="btn-group">
				<button type="button" class="btn btn-default" id="btnShowSubmit" data-backdrop="static" data-toggle="modal"
				 data-target="#submitcode">提交代码</button>
				<a type="button" class="btn btn-default" href=<?php echo '"/Status.php?Problem='.$ProblemID.'"'?>>查看记录</a>
			</div>
		</center>
		<h3>题目描述</h3>
		<div class="panel panel-default">
			<div class="panel-body">
				<?php echo $ProblemData['Description']?>
			</div>
		</div>
		<h3>输入格式</h3>
		<div class="panel panel-default">
			<div class="panel-body">
				<?php echo $ProblemData['InputFormat']?>
			</div>
		</div>
		<h3>输出格式</h3>
		<div class="panel panel-default">
			<div class="panel-body">
				<?php echo $ProblemData['OutputFormat']?>
			</div>
		</div>
		<h3>样例输入</h3>
		<div class="panel panel-default">
			<div class="panel-body">
				<pre class="SlateFix"><?php echo $ProblemData['EmpInput']?></pre>
			</div>
		</div>
		<h3>样例输出</h3>
		<div class="panel panel-default">
			<div class="panel-body">
				<pre class="SlateFix"><?php echo $ProblemData['EmpOutput']?></pre>
			</div>
		</div>
		
		<?php if($ProblemData['Hint'] != ''){?>
		<h3>提示</h3>
		<div class="panel panel-default">
			<div class="panel-body">
				<?php echo $ProblemData['Hint']?>
			</div>
		</div>
		<?php }?>

		<?php if($ProblemData['Source'] != ''){?>
		<h3>来源</h3>
		<div class="panel panel-default">
			<div class="panel-body">
				<?php echo $ProblemData['Source']?>
			</div>
		</div>
		<?php }?>

		<center>
			<div class="btn-group">
				<button type="button" class="btn btn-default" id="btnShowSubmit" data-backdrop="static" data-toggle="modal"
				 data-target="#submitcode">提交代码</button>
				 <a type="button" class="btn btn-default" href=<?php echo '"/Status.php?Problem='.$ProblemID.'"'?>>查看记录</a>
			</div>
		</center>

		</div>
		<div class="modal fade" id="submitcode" tabindex="-1" role="dialog" aria-hidden="true">
			<div class="modal-dialog">
				<div class="modal-content">
					<form onsubmit="return(pstsubmit());" action="/Php/SubmitCode.php" method="post" target="myIframeSubCode">

						<div class="modal-body" id="codemodalbody">
							<textarea hidden name="code" id="codeeditor"></textarea>
							<!--<textarea hidden name="code1" id="code1"></textarea>-->
							<!--<textarea hidden name="code2" id="code2"></textarea>-->
							<textarea hidden name="pid" id="pid"><?php echo $ProblemID?></textarea>
						</div>

						<div class="modal-footer">
							<div class="float-left">
								语言：
								<select name="language" id="language" style="height:32px;width:120px;">
									<option value="Gcc">Gcc</option>
									<option value="G++">G++</option>
									<option value="C++">C++</option>
									<option value="Java">Java</option>
									<option value="Python">Python3.6</option>
								</select>
								<button id="SubmitCodeButton" type="submit" class="btn btn-primary">提交代码</button>
							</div>
							<button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
						</div>
					</form>
					
					<iframe id="myIframe" name="myIframeSubCode" style="display:none">提交中</iframe>

				</div>
			</div>
		</div>

	</div>

	<?php
	$PageActive = '#problem';
	require_once('Php/Page_Footer.php');
	?>
</body>

</html>