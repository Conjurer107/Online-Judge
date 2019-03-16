<?php
    require_once("LoadData.php");
    LoadData();
    
    if($User_Jurisdicton == JUR_ADMIN && isset($LandUser))
    {
        if(array_key_exists('RunID', $_GET))
        {
            $RunID = $_GET['RunID'];
            $sql = "SELECT * FROM oj_status WHERE `RunID`=".$RunID;
            $result = mysql_query($sql);
            $row = mysql_fetch_array($result);

            if($row['Show'] == 1)
            {
                $sql = "UPDATE oj_status SET `Show`= 0 where `RunID`=".$RunID;
            }
            else
            {
                $sql = "UPDATE oj_status SET `Show`= 1 where `RunID`=".$RunID;
            }
            mysql_query($sql);

            echo "<script>parent.RefreshPage();</script>";
        }
        else
        {
            echo "<script>alert('改变提交状态失败'); parent.RefreshPage();</script>";
        }
    }
    else
    {
        echo "<script>alert('您没有权限改变提交状态'); </script>";
    }

?>