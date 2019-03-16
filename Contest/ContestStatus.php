<?php
    require_once("../Php/LoadData.php");
    LoadData();
    
    if($User_Jurisdicton == JUR_ADMIN && isset($LandUser))
    {
        if(array_key_exists('ConID', $_GET))
        {
            $ConID = $_GET['ConID'];
            $sql = "SELECT * FROM oj_contest WHERE ConID=".$ConID;
            $result = mysql_query($sql);
            $row = mysql_fetch_array($result);

            if($row['Show'] == 1)
            {
                $sql = "UPDATE oj_contest SET `Show`= 0 where `ConID`=".$ConID;
            }
            else
            {
                $sql = "UPDATE oj_contest SET `Show`= 1 where `ConID`=".$ConID;
            }
            mysql_query($sql);

            echo "<script>parent.RefreshPage();</script>";
        }
        else
        {
            echo "<script>alert('改变题目状态失败'); parent.RefreshPage();</script>";
        }
    }
    else
    {
        echo "<script>alert('您没有权限改变题目状态'); </script>";
    }

?>