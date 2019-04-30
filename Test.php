<!DOCTYPE html>

<html lang="zh-cn">

<?php require_once('Php/HTML_Head.php')?>

<body class="fixed-sidebar boxed-layout">
<link href="css/style.min.css" rel="stylesheet">
    <?php //require_once ('Php/Page_Header.php') ?>
    
    <div class="navbar navbar-collapse" id="topNavbar">
			<ul class="nav navbar-nav navbar-right">
			<?php
			if(!isset($LandUser))
			{
				require_once("html/Login.html");
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
    </div>
    
    <div class="panel panel-default" id="wrapper" style="overflow:hidden">
        <nav class="navbar-default navbar-static-side" role="navigation">
            <div class="navbar navbar-default">
                <ul class="nav" id="side-menu">
                    <li>
                        <a class='J_menuItem' href="index.php" target="iframe0">
                            <i class="fa fa-home icored"></i>
                            <span class="nav-label">首页</span>
                        </a>
                    </li>
                    
                    <li>
                        <a class='J_menuItem' href="/Problem.php" target="iframe0">
                            <i class="fa fa-users icored"></i>
                            <span class="nav-label">题库</span>
                        </a>
                    </li>

                    <li>
                        <a class='J_menuItem' href="/Status.php" target="iframe0">
                            <i class="fa fa-users icored"></i>
                            <span class="nav-label">提交状态</span>
                        </a>
                    </li>

                    <li>
                        <a class='J_menuItem' href="/Contest.php" target="iframe0">
                            <i class="fa fa-users icored"></i>
                            <span class="nav-label">比赛</span>
                        </a>
                    </li>
                </ul>
            </div>
        </nav>
        
        <div id="page-wrapper" class="gray-bg dashbard-1">
            <div class="row J_mainContent" id="content-main">
                <iframe class="J_iframe" name="iframe0" width="100%" height="650" src="index.php" frameborder="0" data-id="homeIndex"></iframe>
            </div>
        </div>
    </div>
    
    <?php
	$PageActive = '';
	require_once('Php/Page_Footer.php');
	?>

</body>

</html>