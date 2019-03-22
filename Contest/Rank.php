<!DOCTYPE html>

<html lang="zh-cn">

<?php require_once("Html_Head.php");?>

<body>
	<?php 
	require_once("Header.php");

	$AllProblem = explode('|', $ConData['Problem']);
	$ProNum = count($AllProblem);

	$AllEnrollPeople = array();

	$sql = "SELECT * FROM oj_constatus WHERE `Show`=1 and `ConID`=".$ConID;

    if($User_Jurisdicton == JUR_ADMIN && isset($LandUser))
    {
        $sql = "SELECT * FROM oj_constatus WHERE `ConID`=".$ConID;
    }
	$result = mysql_query($sql);
	
	$AllStatus = array();
    while($row = mysql_fetch_array($result))
    {
		$AllStatus[]= array(
            "RunID" => $row['RunID'],
            "User" => $row['User'],
            "Problem" => $row['Problem'],
			"Status" => $row['Status'],
			"SubTime" => $row['SubTime']
        );
	}
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


				<div class="panel panel-default">
				<?php
					if($ConData['Rule'] == 'OI')
					{
						echo '<h3 class="text-center">注意：OI赛制不实时显示排名</h3>';
					}
				?>
					<table class="table table-striped table-hover text-center">
						<?php 
						if($ConData['Rule'] == 'ACM')
							include_once('Rank_ACM.php');
						else
							include_once('Rank_OI.php');
						?>
					</table>
				</div>
			</div>
			</div>
			</div>
				<?php
    $PageActive = "#c_rank";
	require_once('Footer.php');
	?>
</body>

</html>