<!DOCTYPE html>

<html lang="zh-cn">

<?php require_once("Html_Head.php");?>

<body>
	<?php 
	require_once("Header.php");

	$AddHref = "";
	$AllCmd = "";
	$result;

	
	if(!isset($LandUser) || $User_Jurisdicton != JUR_ADMIN)
	{
		$AllCmd = ' where `Show`=1';
	}

	if(array_key_exists('ConID', $_GET))
	{
		if($_GET['ConID'] != "")
		{
			$AddHref = $AddHref.'&ConID='.$_GET['ConID'];

			if($AllCmd == "")
				$AllCmd = ' where';
			else
				$AllCmd = $AllCmd.' and';
		
			$AllCmd = $AllCmd.' `ConID`='.$_GET['ConID'];
		}
	}

	if(array_key_exists('Problem', $_GET))
	{
		if($_GET['Problem'] != "")
		{
			$AddHref = $AddHref.'&Problem='.$_GET['Problem'];

			if($AllCmd == "")
				$AllCmd = ' where';
			else
				$AllCmd = $AllCmd.' and';
		
			$AllCmd = $AllCmd.' `Problem`='.(ord($_GET['Problem']) - ord('A') + 0);
		}
	}

	if(array_key_exists('Status', $_GET))
	{
		if($_GET['Status'] != "" && ($ConData['Rule'] == 'ACM' || ($User_Jurisdicton == JUR_ADMIN) || $NowDate >= $ConData['OverTime']))
		{
			$AddHref = $AddHref.'&Status='.$_GET['Status'];

			if($AllCmd == "")
				$AllCmd = ' where';
			else
				$AllCmd = $AllCmd.' and';
		
			$AllCmd = $AllCmd.' `Status`="'.$_GET['Status'].'"';
		}
	}

	if(array_key_exists('Language', $_GET))
	{
		if($_GET['Language'] != "")
		{
			$Language = str_replace("+","%2B", $_GET['Language']);
			$AddHref = $AddHref.'&Language='.$Language;

			if($AllCmd == "")
				$AllCmd = ' where';
			else
				$AllCmd = $AllCmd.' and';
		
			$AllCmd = $AllCmd.' `Language`="'.$_GET['Language'].'"';
		}
	}
	
	$OnlyMyself = false;
	if($NowDate <= $ConData['OverTime'] && $User_Jurisdicton != JUR_ADMIN)
	{
		$OnlyMyself = true;

		if($AllCmd == "")
			$AllCmd = ' where';
		else
			$AllCmd = $AllCmd.' and';
		
		$AllCmd = $AllCmd.' `User`="'.$LandUser.'"';
	}
	
	if(array_key_exists('User', $_GET) && !$OnlyMyself)
	{
		if($_GET['User'] != "")
		{
			$AddHref = $AddHref.'&User='.$_GET['User'];

			if($AllCmd == "")
				$AllCmd = ' where';
			else
				$AllCmd = $AllCmd.' and';
		
			$AllCmd = $AllCmd.' `User`="'.$_GET['User'].'"';
		}
	}

	//获取状态数量
	$sql = "SELECT count(*) as `value` FROM `oj_constatus` ".$AllCmd;
    $rs = mysql_query($sql);
    $StaCount = mysql_fetch_array($rs);
    $clength = $StaCount['value'];
	//获取当前页数
    $iPage = 1;
    if(array_key_exists('Page', $_GET))
    {
        $iPage = $_GET['Page'];
    }
	$iPage = floor($iPage);
	
	//定义常量，一页中最大显示数量
    define("MaxRankNum", 20);
    //定义常量，一页中最多显示按钮数量(奇数)
	define("MaxButtonNum", 5);

	//计算总页数
	$AllPage = $clength / MaxRankNum;

    //计算上一页的页数
    $LastPage = ($iPage - 1 <= 0) ? 1 : ($iPage - 1);
     //计算下一页的页数
    $NextPage = $iPage * MaxRankNum < $clength ? $iPage + 1: $iPage;
    //最小页数
    $MinPage = 1;
    $iPage = $iPage >=  $MinPage ? $iPage : 1;
    //最大页数
	$MaxPage = ceil(($clength * 1.0) / MaxRankNum);
	$MaxPage = $MaxPage > 0 ? $MaxPage : 1;
    $iPage = $iPage <=  $MaxPage ? $iPage : $MaxPage;
    //根据页数计算显示第一个的排名
    $Rank =  ($iPage - 1) * MaxRankNum;
    
    //开始显示的按钮数字
    $StaButNum;
    //至结束显示的按钮数字
    $EndButNum;
    
    //如果最大页数小于等于一页中最多显示按钮数量
    if($MaxPage <= MaxButtonNum)
    {
        $StaButNum = 1;
        $EndButNum = $MaxPage;
    }
    else
    {
        //将当前页的数字当作中间的按钮
        $iCenBuNum = $iPage;
        //开始显示的按钮数字为 最多显示按钮数量/2
        $StaButNum = $iCenBuNum - floor(MaxButtonNum / 2);
        //至结束显示的按钮的数字为 最多显示按钮数量/2
        $EndButNum = $iCenBuNum + floor(MaxButtonNum / 2);

        //如果开始显示的数字<=0，说明不能把当前页的数字当作中间的按钮
        if($StaButNum <= 0)
        {
            //将至结束显示的按钮的数字调整
            $EndButNum -= $StaButNum - 1;
            //开始显示的数字显示为1
            $StaButNum -= $StaButNum - 1;
        }
        
        //如果结束显示的数字>最多显示按钮数量，说明不能把当前页的数字当作中间的按钮
        if($EndButNum > $MaxPage)
        {
            //调整开始按钮的值
            $StaButNum -= ($EndButNum - $MaxPage);
            //结束显示的数字显示为最大值
            $EndButNum = $MaxPage;
        }
	}
	
	$LimitShowSql = " ORDER BY `RunID` desc limit ".($iPage - 1) * MaxRankNum.", ".MaxRankNum;
	$sql = "SELECT * FROM oj_constatus". $AllCmd . $LimitShowSql;
	$result = mysql_query($sql);

    if(!$result)
    {
		header('Location: /Message.php?Msg=提交状态获取失败');
		return;
    }

	$AllStatus = array();

    while($row = mysql_fetch_array($result))
    {
		$AllStatus[]= array(
			"RunID" => $row['RunID'],
			"ConID" => $row['ConID'],
            "User" => $row['User'],
            "Problem" => $row['Problem'],
            "Status" => $row['Status'],
			"UseTime" => $row['UseTime'],
			"UseMemory" => $row['UseMemory'],
			"Language" => $row['Language'],
			"CodeLen" => $row['CodeLen'],
			"SubTime" => $row['SubTime'],
			"AllStatus" => $row['AllStatus'],
			"Show" => $row['Show']
        );
	}

	//按运行ID排序
	//$arr1 = array_map(create_function('$n', 'return $n["RunID"];'), $AllStatus);
	//array_multisort($arr1, SORT_DESC, $AllStatus);
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

				<!--<meta http-equiv="refresh" content="5">-->
				<center>
				<ul class="pagination">
                <li><a href= <?php echo '"Status.php?Page='.($MinPage).$AddHref.'"'?>>&laquo;</a></li>
                <li><a href= <?php echo '"Status.php?Page='.($LastPage).$AddHref.'"'?> >&lt;</a></li>

                <?php
                for($i =  $StaButNum; $i <= $EndButNum; $i++)
                {
                    if($i == $iPage)
                        echo '<li class="active"><a href="Status.php?Page='.$i.$AddHref.'">'.$i.'</a></li>';
                    else
                        echo '<li><a href="Status.php?Page='.$i.$AddHref.'">'.$i.'</a></li>';
                }
                ?>

                <li><a href= <?php echo '"Status.php?Page='.($NextPage).$AddHref.'"'?> >&gt;</a></li>
                <li><a href= <?php echo '"Status.php?Page='.($MaxPage).$AddHref.'"'?>>&raquo;</a></li>
            	</ul>
				</center>

			<form>
			<div class="input-group" style="padding-bottom:15px;">
				<span class="input-group-addon">比赛ID</span>
				<input name="ConID" type="number" value=<?php if(array_key_exists('ConID', $_GET) && $_GET['ConID']!="") echo $_GET['ConID']; else echo '""'?> class="form-control" readonly="readonly">
				<span class="input-group-addon">用户名</span>
				<input name="User" type="text" value=<?php if(array_key_exists('User', $_GET) && $_GET['User']!="") echo $_GET['User']; else echo '""'?> class="form-control">
				<span class="input-group-addon">题号</span>
				<input name="Problem" type="text" value=<?php if(array_key_exists('Problem', $_GET) && $_GET['Problem']!="") echo $_GET['Problem']; else echo '""'?> class="form-control">

				<?php
					if($ConData['Rule'] == 'ACM' || ($User_Jurisdicton == JUR_ADMIN) || $NowDate >= $ConData['OverTime'])
					{
				?>
					<span class="input-group-addon">评测结果</span>

					<select name="Status" class="form-control">
						<option value=<?php echo Accepted;?>>Accepted</option>
						<option value=<?php echo PresentationError;?>>Presentation Error</option>
						<option value=<?php echo TimeLimitExceeded;?>>Time Limit Exceeded</option>
						<option value=<?php echo MemoryLimitExceeded;?>>Memory Limit Exceeded</option>
						<option value=<?php echo WrongAnswer;?>>Wrong Answer</option>
						<option value=<?php echo RuntimeError;?>>Runtime Error</option>
						<option value=<?php echo OutputLimitExceeded;?>>Output Limit Exceeded</option>
						<option value=<?php echo CompileError;?>>Compile Error</option>
						<option value=<?php echo SystemError;?>>System Error</option>
					</select>

					<script language= JavaScript>
     				document.getElementsByName("Status")[0].value = <? echo '"'.(isset($_GET['Status']) ? $_GET['Status'] : '').'"'?>;
    				</script>
				<?php
					}
				?>

				<span class="input-group-addon">语言</span>

				<select name="Language" class="form-control">
					<option value="">All</option>
					<option value="Gcc">Gcc</option>
					<option value="G++">G++</option>
					<option value="C++">C++</option>
					<option value="Java">Java</option>
					<option value="Python">Python3.6</option>
				</select>

				<script language= JavaScript>
     				document.getElementsByName("Language")[0].value = <? echo '"'.(isset($_GET['Language']) ? $_GET['Language'] : '').'"'?>;
    			</script>

				<span class="input-group-btn">
					<button class="btn btn-default">查询</button>
				</span>
			</div>
		</form>

				<div class="panel panel-default animated fadeInDown">
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
						<?php
				for($i = 0; $i < MaxRankNum; $i++)
				{
					if(!isset($AllStatus[$i]['RunID']))
                    {
                        continue;
                    }
					if($ConData['Rule'] == 'OI' && ($User_Jurisdicton != JUR_ADMIN) && $NowDate <= $ConData['OverTime'])
					{
						$sql = "SELECT Fight FROM oj_user WHERE name='".$AllStatus[$i]['User']."'";
						$result = mysql_query($sql);
						$row = mysql_fetch_array($result);

						echo '<tr>';

						if(isset($LandUser) && $User_Jurisdicton == JUR_ADMIN)
						{
							unset($_GET['ReEva']);
							echo '<td>';
							echo $AllStatus[$i]['RunID'];
							echo ' &nbsp;';
							echo '<a class="label label-warning" href="/Contest/AfreshEva.php?ConID='.$AllStatus[$i]['ConID'].'&ReEva='.$AllStatus[$i]['RunID'].'" target="myIframeNull">重测</a>';
							
							echo ' <a class="label label-default" href="/Contest/ShowLog.php?ConID='.$AllStatus[$i]['ConID'].'&RunID='.$AllStatus[$i]['RunID'].'" >日志</a>';

							if($AllStatus[$i]['Show'] == 1)
							{
								echo ' <a class="label label-primary" href="/Contest/StatusShow.php?RunID='.$AllStatus[$i]['RunID'].'" target="myIframeNull">隐藏</a>';
							}
							else
							{
								echo ' <a class="label label-info" href="/Contest/StatusShow.php?RunID='.$AllStatus[$i]['RunID'].'" target="myIframeNull">显示</a>';
							}
						
							echo '<iframe id="myIframe" name="myIframeNull" style="display:none"></iframe>';
							echo '</td>';
						}
						else
						{
							echo '<td>'.$AllStatus[$i]['RunID'].'</td>';
						}

						echo '<td>';
						echo '<a href="/OtherUser.php?User='.$AllStatus[$i]['User'].'" class='.GetUserColor($row[0]).'>'.$AllStatus[$i]['User'].'</a>';
						echo '</td>';

						echo '<td>';
						echo '<a href="/Contest/Problem.php?ConID='.$AllStatus[$i]['ConID'].'&Problem='.$AllStatus[$i]['Problem'].'">'.$ProEngNum[$AllStatus[$i]['Problem']].'</a>';
						echo '</td>';

						echo '<td>';
						echo '<a class="label" href="/Contest/Detail.php?ConID='.$AllStatus[$i]['ConID'].'&RunID='.$AllStatus[$i]['RunID'].'" data-status="Accepted">Submit Success</a>';
						echo '</td>';

						echo '<td>';
						echo $AllStatus[$i]['Language'];
						echo '</td>';

						echo '<td>';
						echo $AllStatus[$i]['CodeLen'];
						echo '</td>';

						echo '<td>';
						echo $AllStatus[$i]['SubTime'];
						echo '</td>';

						echo '</tr>';
					}
					else
					{
						$sql = "SELECT Fight FROM oj_user WHERE `name`='".$AllStatus[$i]['User']."'";
						$result = mysql_query($sql);
						$row = mysql_fetch_array($result);

						echo '<tr>';

						if(isset($LandUser) && $User_Jurisdicton == JUR_ADMIN)
						{
							unset($_GET['ReEva']);
							echo '<td>';
							echo $AllStatus[$i]['RunID'];
							echo ' &nbsp;';
							echo '<a class="label label-warning" href="/Contest/AfreshEva.php?ConID='.$AllStatus[$i]['ConID'].'&ReEva='.$AllStatus[$i]['RunID'].'" target="myIframeNull">重测</a>';
							echo ' <a class="label label-default" href="/Contest/ShowLog.php?ConID='.$AllStatus[$i]['ConID'].'&RunID='.$AllStatus[$i]['RunID'].'" >日志</a>';

							if($AllStatus[$i]['Show'] == 1)
							{
								echo ' <a class="label label-primary" href="/Contest/StatusShow.php?RunID='.$AllStatus[$i]['RunID'].'" target="myIframeNull">隐藏</a>';
							}
							else
							{
								echo ' <a class="label label-info" href="/Contest/StatusShow.php?RunID='.$AllStatus[$i]['RunID'].'" target="myIframeNull">显示</a>';
							}
						
							echo '<iframe id="myIframe" name="myIframeNull" style="display:none">隐藏</iframe>';
							echo '</td>';
						}
						else
						{
							echo '<td>'.$AllStatus[$i]['RunID'].'</td>';
						}

						echo '<td>';
						echo '<a href="/OtherUser.php?User='.$AllStatus[$i]['User'].'" class='.GetUserColor($row[0]).'>'.$AllStatus[$i]['User'].'</a>';
						echo '</td>';

						echo '<td>';
						echo '<a href="/Contest/Problem.php?ConID='.$AllStatus[$i]['ConID'].'&Problem='.$AllStatus[$i]['Problem'].'">'.$ProEngNum[$AllStatus[$i]['Problem']].'</a>';
						echo '</td>';

						echo '<td>';
						//if($AllStatus[$i]['Status'] == 'Running' || $AllStatus[$i]['Status'] == 'Compiling' || $AllStatus[$i]['Status'] == 'Wating' || $AllStatus[$i]['Status'] == 'Queuing')
							//echo '<a id="StatusTitle" data-content="点击刷新评测状态" class="label" href="javascript:location.reload();" data-status="'.$AllStatus[$i]['Status'].'">'.$AllStatus[$i]['Status'].'</a>';
						//else
						echo '<a class="label" href="/Contest/Detail.php?ConID='.$AllStatus[$i]['ConID'].'&RunID='.$AllStatus[$i]['RunID'].'" data-status="'.$AllStatusName[$AllStatus[$i]['Status']].'">'.$AllStatusCName[$AllStatus[$i]['Status']].' '.$AllStatusName[$AllStatus[$i]['Status']].'</a>';
						echo '</td>';

						echo '<td>';
						echo $AllStatus[$i]['UseTime'];
						echo '</td>';

						echo '<td>';
						echo $AllStatus[$i]['UseMemory'];
						echo '</td>';

						echo '<td>';
						echo $AllStatus[$i]['Language'];
						echo '</td>';

						echo '<td>';
						echo $AllStatus[$i]['CodeLen'];
						echo '</td>';

						echo '<td>';
						echo $AllStatus[$i]['SubTime'];
						echo '</td>';

						echo '</tr>';
					}
				}
				?>
						</tbody>
					</table>
				</div>
				<center>
				<ul class="pagination">
                <li><a href= <?php echo '"Status.php?Page='.($MinPage).$AddHref.'"'?>>&laquo;</a></li>
                <li><a href= <?php echo '"Status.php?Page='.($LastPage).$AddHref.'"'?> >&lt;</a></li>

                <?php
                for($i =  $StaButNum; $i <= $EndButNum; $i++)
                {
                    if($i == $iPage)
                        echo '<li class="active"><a href="Status.php?Page='.$i.$AddHref.'">'.$i.'</a></li>';
                    else
                        echo '<li><a href="Status.php?Page='.$i.$AddHref.'">'.$i.'</a></li>';
                }
                ?>

                <li><a href= <?php echo '"Status.php?Page='.($NextPage).$AddHref.'"'?> >&gt;</a></li>
                <li><a href= <?php echo '"Status.php?Page='.($MaxPage).$AddHref.'"'?>>&raquo;</a></li>
            	</ul>
				</center>
			</div>
		</div>
	</div>
	<?php
    $PageActive = "#c_status";
	require_once('Footer.php');
	?>
</body>

</html>