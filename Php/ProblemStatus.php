<?php
    require_once("LoadData.php");
    LoadData();
    
    if($User_Jurisdicton == JUR_ADMIN && isset($LandUser))
    {
        if(array_key_exists('Problem', $_GET))
        {
            $ProblemID = $_GET['Problem'];
            $sql = "SELECT * FROM oj_problem WHERE proNum=".$ProblemID;
            $result = mysql_query($sql);
            $row = mysql_fetch_array($result);

            if($row['Show'] == 1)
            {
                $sql = "UPDATE oj_problem SET `Show`= 0 where `proNum`=".$ProblemID;
            }
            else
            {
                $sql = "UPDATE oj_problem SET `Show`= 1 where `proNum`=".$ProblemID;
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