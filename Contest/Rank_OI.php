<?php
	$PeopleRank = array();

	$AllPeople = $ConData['EnrollPeople'];
	$Data = explode('|', $AllPeople);
	$PeoNum = count($Data);

	//遍历每个参赛者
	foreach($Data as $var)
	{
		$Score = 0;

		$iData = array('User' => $var,'Score'=> 0);

		for($i = 0; $i < $ProNum; $i++)
		{
            $iScore = 0;
            $iSubmit = 0;

			//获取参赛者最后一次提交的信息
			$sql = "SELECT * FROM oj_constatus WHERE (SubTime=(select max(SubTime) from oj_constatus WHERE `Show` = 1 and `ConID`=".$ConID." and `Problem`=".$i." and `User`='".$var."') and `User`='".$var."')";
    		if($User_Jurisdicton == JUR_ADMIN && isset($LandUser))
    		{
				$sql = "SELECT * FROM oj_constatus WHERE (SubTime=(select max(SubTime) from oj_constatus WHERE `ConID`=".$ConID." and `Problem`=".$i." and `User`='".$var."') and `User`='".$var."')";
			}
			$result = mysql_query($sql);
            $LastSubmit = mysql_fetch_array($result); 

            if($LastSubmit)
            {
                $iSubmit = 1;
                $AllStatus = explode("|", $LastSubmit['AllStatus']);

                $iTestNum = count($AllStatus);
                $EveTesScore = 100 / $iTestNum;
                foreach($AllStatus as $val)
			    {
                    $iTest = explode("&", $val);

                    if($iTest[1] == 4)
                    {
                        $iScore += $EveTesScore;
                    }
                }
            }

            $Score += $iScore;
            $iData[$i] = array('Score'=>$iScore, 'Submit'=>$iSubmit);
            
		}
		
		
		$iData['Score'] = $Score;
		array_push($PeopleRank, $iData);
    }
    
    $arr1 = array_map(create_function('$n', 'return $n["Score"];'), $PeopleRank);
    array_multisort($arr1, SORT_DESC, $PeopleRank);
?>

<thead>
	<tr>
		<th>排名</th>
		<th>用户名</th>
		<th>得分</th>

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
		//排名计算
		$LastPeoScore = 0;
		$PeoRank = 0;
		$EqualRank = 1;

		for($i=0; $i < $PeoNum; $i++)
		{
            if(($User_Jurisdicton != JUR_ADMIN) && ($NowDate <= $ConData['OverTime']))
            {
                break;
            }
			if(!$PeopleRank[$i]['User'])
			{
				continue;
			}

			if($LastPeoScore != $PeopleRank[$i]['Score'])
			{
				$LastPeoScore = $PeopleRank[$i]['Score'];
				$PeoRank += $EqualRank;
				$EqualRank = 1;
			}
			else
			{
				$EqualRank++;
			}
			echo '<tr>';

			echo '<td>'.($PeoRank).'</td>';
			$sql = "SELECT Fight FROM oj_user WHERE name='".$PeopleRank[$i]['User']."'";
			$result = mysql_query($sql);
			$row = mysql_fetch_array($result);
			echo '<td><a href="/OtherUser.php?User='.$PeopleRank[$i]['User'].'" class='.GetUserColor($row[0]).'>'.$PeopleRank[$i]['User'].'</a></td>';
			echo '<td>'.$PeopleRank[$i]['Score'].'</td>';

			for($j = 0; $j < $ProNum; $j++)
			{
                if(ceil($PeopleRank[$i][$j]['Score']) == 100 || floor($PeopleRank[$i][$j]['Score']) == 100)
                {
                    echo '<td class="SlateFixBlack rankyes">'.$PeopleRank[$i][$j]['Score'].'</td>';
                }
                else if($PeopleRank[$i][$j]['Submit'] == 1)
                {
                    echo '<td class="SlateFixBlack rankno">'.$PeopleRank[$i][$j]['Score'].'</td>';
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