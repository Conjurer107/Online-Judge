<?php
	$PeopleRank = array();

	$AllPeople = $ConData['EnrollPeople'];
	$Data = explode('|', $AllPeople);
	$PeoNum = count($Data);

	//遍历每个参赛者
	foreach($Data as $var)
	{
		$iUserACNum = 0;
		$iTimePenalty = 0;

		$iData = array('User' => $var,'ACNum'=> 0,'TimePenalty'=> 0);

		for($i = 0; $i < $ProNum; $i++)
		{
			$iACStatus = 0;
			$iAttemptNum = 0;
			$iUseTime = "";
			$iFirstAC = 0;

			//获取参赛者错误提交信息
			$sql = "SELECT count(*) as value FROM oj_constatus WHERE `Status`!='Accepted' and `Status`!='Compile Error' and `Show` = 1 and `ConID`=".$ConID." and `Problem`=".$i." and `User`='".$var."'";
    		if($User_Jurisdicton == JUR_ADMIN && isset($LandUser))
    		{
        		$sql = "SELECT count(*) as value FROM oj_constatus WHERE `Status`!='Accepted' and `Status`!='Compile Error' and `ConID`=".$ConID." and `Problem`=".$i." and `User`='".$var."'";
			}
			$rs = mysql_query($sql);
			$Num = mysql_fetch_array($rs);
			$iAttemptNum = $Num['value'];
			//增加罚时


			//获取每一个提交信息
			$sql = "SELECT * FROM oj_constatus WHERE (SubTime=(select min(SubTime) from oj_constatus WHERE`Status`='Accepted' and `Show` = 1 and `ConID`=".$ConID." and `Problem`=".$i."))";
    		if($User_Jurisdicton == JUR_ADMIN && isset($LandUser))
    		{
				$sql = "SELECT * FROM oj_constatus WHERE (SubTime=(select min(SubTime) from oj_constatus WHERE`Status`='Accepted' and `ConID`=".$ConID." and `Problem`=".$i."))";
			}
			$result = mysql_query($sql);
			$FirstAC = mysql_fetch_array($result); 

			//获取参赛者的AC提交信息
			$sql = "SELECT * FROM oj_constatus WHERE (SubTime=(select min(SubTime) from oj_constatus WHERE`Status`='Accepted' and `Show` = 1 and `ConID`=".$ConID." and `Problem`=".$i." and `User`='".$var."') and `User`='".$var."')";
    		if($User_Jurisdicton == JUR_ADMIN && isset($LandUser))
    		{
				$sql = "SELECT * FROM oj_constatus WHERE (SubTime=(select min(SubTime) from oj_constatus WHERE`Status`='Accepted' and `ConID`=".$ConID." and `Problem`=".$i." and `User`='".$var."') and `User`='".$var."')";
			}
			$result = mysql_query($sql);
			$IsAC = mysql_fetch_array($result); 
			//如果
			if($IsAC)
			{
				if($IsAC['SubTime'] == $FirstAC['SubTime'])
				{
					$iFirstAC = 1;
				}

				//已经AC,计算罚时
				$iTimePenalty += 20 * $iAttemptNum;

				$iACStatus = 1;
				$iUserACNum++;
				
				$Startdate = strtotime($ConData['StartTime']);
				$Enddate   = strtotime($IsAC['SubTime']);

				$Timediff = $Enddate - $Startdate;
				$Days =     intval($Timediff / 86400);
				$Remain =   $Timediff % 86400;
				$Hours =    intval($Remain / 3600);
				$Remain =   $Remain % 3600;
				$Mins =     intval($Remain / 60);
				$Secs =     $Remain % 60;
				
				$iTimePenalty += ($Mins + $Hours * 60 + $Days * 60 * 60);

				if($Days > 0)
				{
					$iUseTime = $Days.' days '.$Hours.':'.$Mins.':'.$Secs;
				}
				else
				{
					$iUseTime = $Hours.':'.$Mins.':'.$Secs;
				}
				
			}
			else if($iAttemptNum != 0)
			{
				$iACStatus = 2;
			}
			$iData[$i] = array('AttemptNum'=>$iAttemptNum, 'UseTime'=>$iUseTime, 'ACStatus'=>$iACStatus, 'FirstPass' => $iFirstAC);
		}
		
		
		$iData['ACNum'] = $iUserACNum;
		$iData['TimePenalty'] = $iTimePenalty;
		array_push($PeopleRank, $iData);
	}

	function my_sort($a, $b)
	{
		if ($a["ACNum"] == $b["ACNum"])
		{
			if($a["TimePenalty"] == $b["TimePenalty"])
			{
				return 0;
			}

			return ($a["TimePenalty"] < $b["TimePenalty"]) ? -1 : 1;
		}

		return ($a["ACNum"] > $b["ACNum"]) ? -1 : 1;
	}

	usort($PeopleRank,"my_sort");
?>

<thead>
	<tr>
		<th>排名</th>
		<th>用户名</th>
		<th>AC题数</th>
		<th>罚时</th>

		<?php
			for($i = 0; $i < $ProNum; $i++)
			{
				$sql = "SELECT count(*) as value FROM oj_constatus where `ConID` = ".$ConID." and `Status` = 'Accepted' and `Show` = 1 and `Problem` = ".$i;
				if(isset($LandUser) && $User_Jurisdicton == JUR_ADMIN)
				{
					$sql = "SELECT count(*) as value FROM oj_constatus where `ConID` = ".$ConID." and `Status` = 'Accepted' and `Problem` = ".$i;
				}
              	$rs = mysql_query($sql);
				$PassProNum = mysql_fetch_array($rs);
									
				$sql = "SELECT count(*) as value FROM oj_constatus where `ConID` = ".$ConID." and `Show` = 1 and `Problem` = ".$i;
				if(isset($LandUser) && $User_Jurisdicton == JUR_ADMIN)
				{
					$sql = "SELECT count(*) as value FROM oj_constatus where `ConID` = ".$ConID." and `Problem` = ".$i;
				}
                $rs = mysql_query($sql);
				$AllProNum = mysql_fetch_array($rs);

				echo '<th><a href="/Contest/Problem.php?ConID='.$ConID.'&Problem='.$i.'">'.$ProEngNum[$i].'('.$PassProNum['value'].'/'.$AllProNum['value'].')</a></th>';
			}
			?>

	</tr>
</thead>
<tbody>
	<?php
		for($i=0; $i < $PeoNum; $i++)
		{
			if(!$PeopleRank[$i]['User'])
			{
				continue;
			}
			echo '<tr>';

			echo '<td>'.($i + 1).'</td>';
			$sql = "SELECT Fight FROM oj_user WHERE name='".$PeopleRank[$i]['User']."'";
			$result = mysql_query($sql);
			$row = mysql_fetch_array($result);
			echo '<td><a href="/OtherUser.php?User='.$PeopleRank[$i]['User'].'" class='.GetUserColor($row[0]).'>'.$PeopleRank[$i]['User'].'</a></td>';
			echo '<td>'.$PeopleRank[$i]['ACNum'].'</td>';
			echo '<td>'.$PeopleRank[$i]['TimePenalty'].'</td>';

			for($j = 0; $j < $ProNum; $j++)
			{
				if($PeopleRank[$i][$j]['ACStatus'] == 1)
				{
					if($PeopleRank[$i][$j]['FirstPass'] == 1)
					{
						echo '<td class="SlateFixBlack rankfirst">+'.$PeopleRank[$i][$j]['AttemptNum'].'<br>'.$PeopleRank[$i][$j]['UseTime'].'</td>';
					}
					else
					{
						echo '<td class="SlateFixBlack rankyes">+'.$PeopleRank[$i][$j]['AttemptNum'].'<br>'.$PeopleRank[$i][$j]['UseTime'].'</td>';
					}
				}
				else if($PeopleRank[$i][$j]['ACStatus'] == 2)
				{
					echo '<td class="SlateFixBlack rankno">-'.$PeopleRank[$i][$j]['AttemptNum'].'<br>'.$PeopleRank[$i][$j]['UseTime'].'</td>';
				}
				else
				{
					echo '<td></td>';
				}
			}

			echo '</tr>';
		}
		?>
</tbody>