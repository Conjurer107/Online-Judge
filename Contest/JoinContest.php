<?php
    require_once("../Php/LoadData.php");
    LoadData();

    if(!isset($LandUser))
	{
        echo "<script>alert('您未登陆，无法报名比赛');</script>";
		return;
    }
    
    if(isset($_GET["ConID"]))
    {
        $sql = "SELECT * FROM oj_contest WHERE `ConID`=".$_GET["ConID"];
        $result = mysql_query($sql);

        if(!$result)
        {
            echo "<script>alert('报名失败');</script>";
            return;
        }

        $ConData = mysql_fetch_array($result);
        
        $AllPeople = $ConData['EnrollPeople'];
        $Data = explode('|', $AllPeople);

        if(!in_array($LandUser, $Data))
        {
            if($AllPeople == "")
            {
                $AllPeople = $LandUser;
            }
            else
            {
                $AllPeople .= ('|' . $LandUser);
            }

            $sql = "UPDATE oj_contest SET `EnrollPeople` = '".$AllPeople."' WHERE ConID='".$_GET["ConID"]."'"; 
            mysql_query($sql);
            
            echo '<script>parent.RefreshPage();</script>';
        }
    }

?>