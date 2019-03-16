<script src="/js/click.js" type="text/javascript"></script>
	<nav class="navbar navbar-default navbar-static-top" role="navigation">
	<div class="container">
	  <!-- Brand and toggle get grouped for better mobile display -->
	  <div class="navbar-header">
		<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#topNavbar">
		  <span class="sr-only">Toggle navigation</span>
		  <span class="icon-bar"></span>
		  <span class="icon-bar"></span>
		  <span class="icon-bar"></span>
		</button>
		<a class="navbar-brand" href="/Contest.php">返回<?php echo $WebName?></a>
	  </div>

	  <!-- Collect the nav links, forms, and other content for toggling -->
	  <div class="collapse navbar-collapse" id="topNavbar">
		<ul class="nav navbar-nav">
		  <li id="c_overview" role="presentation"><a href= <?php echo '"/Contest/Pandect.php?ConID='.$ConID.'"';?>><span class="glyphicon glyphicon-home"><span class="font-size-1"> </span>比赛总览</span></a></li>
		  
			<?php
			if($NowDate >= $ConData['StartTime'] || ($User_Jurisdicton == JUR_ADMIN))
			{
				echo '<li id="c_problem" role="presentation"><a href= "/Contest/Problem.php?ConID='.$ConID.'"><span class="glyphicon glyphicon-file"><span class="font-size-1"> </span>题目列表</span></a></li>';
				echo '<li id="c_status" role="presentation"><a href= "/Contest/Status.php?ConID='.$ConID.'"><span class="glyphicon glyphicon-list-alt"><span class="font-size-1"> </span>提交记录</span></a></li>';
				echo '<li id="c_rank" role="presentation"><a href= "/Contest/Rank.php?ConID='.$ConID.'"><span class="glyphicon glyphicon-stats"><span class="font-size-1"> </span>排名</span></a></li>';
			}
			?>
			
			<?php
				if($ConData['RatingStatus'] == 1)
				{
					echo '<li id="c_rating" role="presentation"><a href="/Contest/Rating.php?ConID='.$ConID.'"><span class="	glyphicon glyphicon-flash"><span class="font-size-1"> </span>战斗力变化</span></a></li>';
				}
			?>
		  
		</ul>
		<ul class="nav navbar-nav navbar-right">
		
		
		<?php
			if(!isset($LandUser))
			{
				require_once("../html/Login.html");
			}
			else
			{
				if($User_Jurisdicton == JUR_ADMIN)
				{
					echo '<li id="admin"><a href="/Admin.php">管理员面板</a></li>';
				}
				echo '<li id="user"><a href="/User.php">'.$LandUser.'</a></li>';
				echo '<li><a href="/Php/Logout.php" target="myIframeLogout">退出账号</a></li>';
				echo '<iframe id="myIframe" name="myIframeLogout" style="display:none"></iframe>';
			}
			?>
		 
		</ul>
	  </div><!-- /.navbar-collapse -->
	  </div>
	</nav>

	<h1 class="text-center"><?php echo $ConData['Title']?>
		<?php
			if($User_Jurisdicton == JUR_ADMIN && isset($LandUser))
			{
				echo '<a class="label label-warning" href="/NewContest.php?ConID='.$ConData['ConID'].'">编辑</a> ';

				if($ConData['Show'] == 1)
                {
					echo '<a target="myIframeProShow" class="label label-primary" href="/Contest/ContestStatus.php?ConID='.$ConData['ConID'].'">隐藏</a>';
				}
				else
				{
					echo '<a target="myIframeProShow" class="label label-info" href="/Contest/ContestStatus.php?ConID='.$ConData['ConID'].'">显示</a>';
				}

				echo '<iframe id="myIframe" name="myIframeProShow" style="display:none">改变状态</iframe>';
			}
		?>
		</h1>