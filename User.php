<!DOCTYPE html>

<html lang="zh-cn">

<?php require_once('Php/HTML_Head.php') ?>

<?php
	//防止用户没登陆直接进入
	if(!isset($LandUser))
	{
		header('Location: /Message.php?Msg=您还没有登陆');
		return;
	}

	//取得登陆的用户名
	$User = $LandUser;

	if(isset($User))
	{
		//查找数据库
		$sql = "SELECT * FROM oj_user where Name='".$User."'";
		$rs = mysql_query($sql);
		$UserData = mysql_fetch_array($rs);

		if(!isset($UserData['name']))
		{
			header('Location: /Message.php?Msg=用户信息载入失败');
		}

		//个性签名
		$Signature = $UserData['signature'];
		//获取战斗力
		$Fight = $UserData['fight'];
		//获取E-Mail
		$E_Mail = $UserData['email'];
		//获取注册时间
		$Regtime = $UserData['regtime'];
		//获取登陆时间
		$Logtime = $UserData['logtime'];
		//权限名称
		$AllJurisdicton = array('普通用户', '高级用户', '管理员');
		//根据权限值获得名称
		$Jurisdicton = $AllJurisdicton[$UserData['jurisdicton']];
		
		$Allsubnum = 0;

		$PassProblem=array();
		$PassProNum = 0;
		$sql = "SELECT * FROM oj_status where `User`='".$User."' and `Status` = ".Accepted." and `Show`=1";
		if($User_Jurisdicton == JUR_ADMIN && isset($LandUser))
		{
			$sql = "SELECT * FROM oj_status where `User`='".$User."' and `Status` = ".Accepted."";
		}
		$rs = mysql_query($sql);

		while($ProblemData = mysql_fetch_array($rs))
		{
			$Allsubnum++;

			if(!in_array($ProblemData['Problem'], $PassProblem))
			{
				array_push($PassProblem, $ProblemData['Problem']);
				$PassProNum++;
			}
		}

		sort($PassProblem);
		
		$nPassProblem = array();
		$nPassProNum = 0;
		$sql = "SELECT * FROM oj_status where `User`='".$User."' and `Status` != ".Accepted." and `Show`=1";
		if($User_Jurisdicton == JUR_ADMIN && isset($LandUser))
		{
			$sql = "SELECT * FROM oj_status where `User`='".$User."' and `Status` != ".Accepted."";
		}
		$rs = mysql_query($sql);

		while($ProblemData = mysql_fetch_array($rs))
		{
			$Allsubnum++;

			if(!in_array($ProblemData['Problem'], $PassProblem) && !in_array($ProblemData['Problem'], $PassProblem))
			{
				array_push($nPassProblem, $ProblemData['Problem']);
				$nPassProNum++;
			}
		}

		sort($nPassProblem);
	}
	else
	{
		header('Location: /Message.php?Msg=您还没有登陆');
	}

?>
<body>

	<?php require_once ('Php/Page_Header.php') ?>

	<div class="container">

		<div class="panel panel-default">
			<div class="panel-heading">个人信息</div>
			<div class="panel-body">
				<form method="post" action="Php/ChangeUserData.php" target="myIframeChanData">
					<div class="panel panel-default float-center animated fadeInLeft" style="width:450px;">
						<table class="table">
							<tr>
								<td>用户名</td>
								<td class=<?php echo GetUserColor($Fight) ?>> <?php echo $User?> </td>
							</tr>
							<!--
							<tr>
								<td>小尾巴
								<td>
									<input name="disp" class="form-control sminput" type="text" value=" ">
								</td>
							</tr>
							-->
							<tr>
								<td>E-mail</td>
								<td><?php echo $E_Mail?>


									<a href='' class="myuser-base myuser-purple"></a>

								</td>
							</tr>
							<tr>
								<td>用户权限</td>
								<td><?php echo $Jurisdicton?></td>
							</tr>
							<tr>
								<td>注册日期</td>
								<td><?php echo $Regtime ?></td>
							</tr>
							<tr>
								<td>最后登录日期</td>
								<td><?php echo $Logtime ?></td>
							</tr>
							<tr>
								<td>战斗力</td>
								<td><?php echo $Fight?></td>
							</tr>
							<tr>
								<td>通过题数/提交总次数</td>
								<td><?php echo $PassProNum?> / <?php echo $Allsubnum?></td>
							</tr>

							<tr>
								<td>Ratio(无用数据)</td>
								<td><?php echo number_format(($Allsubnum == 0 ? 0 : $PassProNum / $Allsubnum) * 100, 2)?>%</td>
							</tr>
							<tr>
								<td>个性签名</td>
								<td>
									<textarea class="form-control" name="Motto"><?php echo $Signature?> </textarea>
								</td>
							</tr>
							<tr>
								<td>OJ皮肤</td>
								<td>
									<select name="Css" id="CSS" style="height:32px;width:120px;">
									<?php
										$AllSkin = array('Cerulean', 'cosmo', 'custom', 'cyborg', 'darkly', 'flatly', 'journal', 'lumen', 'paper', 'readable', 'sandstone', 'simplex', 'Slate', 'spacelab', 'superhero', 'united', 'yeti');

										$sql = "SELECT * FROM oj_user where name='".$LandUser."'";
										$rs = mysql_query($sql);
										$row = mysql_fetch_array($rs);

										foreach ($AllSkin as $var)
										{
											if($var == $row['skin'])
											{
												echo '<option selected="selected" value="'.$var.'">'.$var.'</option>';
											}
											else
											{
												echo '<option value="'.$var.'">'.$var.'</option>';
											}
												
										}
									?>
									</select>
								</td>
							</tr>
							<tr>
								<td>旧密码</td>
								<td>
									<input name="Oldpassword" class="form-control sminput" type="password" placeholder="不改密码不用填">
								</td>
							</tr>
							<tr>
								<td>新密码</td>
								<td>
									<input name="Newpassword" class="form-control sminput" type="password">
								</td>
							</tr>
							<tr>
								<td>确认密码</td>
								<td>
									<input name="Repassword" class="form-control sminput" type="password">
								</td>
							</tr>

						</table>
						<center>
							<input type="submit" class="btn btn-default" value="提交更改">
						</center>
						<br>
					</div>
				</form>
				<iframe id="myIframe" name="myIframeChanData" style="display:none"></iframe>
			</div>
		</div>
		<div class="panel panel-default animated fadeInDown">
			<div class="panel-heading">已解决的问题编号
				<a href= <?php echo '"/Status.php?User='.$User.'&Status='.Accepted.'"'?> class="label label-primary">查看通过记录</a>
			</div>
			<div class="panel-body">
				
			<?php
			for($i = 1; $i <= $PassProNum; $i++)
			{
				echo '<a href="/Question.php?Problem='. $PassProblem[$i - 1]. '" class="label label-primary">'.$PassProblem[$i - 1].'</a> ';
			}
			?>

			</div>
		</div>

		<div class="panel panel-default animated fadeInDown">
			<div class="panel-heading">尝试过但尚未解决的问题编号
				<a href= <?php echo '"/Status.php?User='.$User.'"'?> class="label label-primary">查看全部记录</a>
			</div>
			<div class="panel-body">

			<?php
			for($i = 1; $i <= $nPassProNum; $i++)
			{
				echo '<a href="/Question.php?Problem='. $nPassProblem[$i - 1]. '"class="label label-default">'.$nPassProblem[$i - 1].'</a> ';
			}
			?>
			</div>
		</div>

	</div>
	<?php
	$PageActive = '#user';
	 require_once('Php/Page_Footer.php')
	 ?>
</body>

</html>