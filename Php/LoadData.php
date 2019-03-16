<?php
session_start();

define("SQL_PASSWORD", "ieIAjVBw02");

function LoadData()
{
    global $WebName;
    global $WebTitle;
    global $WebHtmlTitle;
    global $NowTime;
    global $JudgeMac_1;
    global $JudgeMac_2;
    global $JudgeAllRun_1;
    global $JudgeAllRun_2;
    global $JudgeMacRunID;
    global $con;
    
    //设置时区
    date_default_timezone_set('Asia/Shanghai');
    $iTime = date('H:i:s');
    $iYear = date('Y');
    $iMonth = date('m');
    $AllMon = array('', 'Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec');
    $iStrMon = $AllMon[intval($iMonth)];
    $iDay = date('d');
    $WeekDay = date('l');
    $WeekDay = substr ($WeekDay , 0, 3);
    
    $NowTime = "'". $WeekDay. " " . $iStrMon. " ". $iDay. " ". $iYear. " ". $iTime. " GMT+0800 (中国标准时间)'";
    //$NowTime = "'Thu Jan 24 2019 ".$iTime." GMT+0800 (中国标准时间)'";


    //连接数据库
    header("Content-Type: text/html; charset=utf-8");//防止界面乱码

    $con = mysql_connect('localhost','root', SQL_PASSWORD); //数据库用户名，密码

    if(!$con)
        header('Location: /Message.php?Msg=数据库连接失败');

    @mysql_select_db("openjudge", $con);
    @mysql_query('set names utf8');
    
    $sql = "SELECT * FROM oj_data";
    $result = mysql_query($sql);
    $row = mysql_fetch_array($result);

    $WebName = $row['oj_name'];
    $WebTitle = $row['oj_title'];
    $WebHtmlTitle = $row['oj_html_title'];
    $JudgeMac_1 = $row['oj_EvaMacState_1'];
    $JudgeMac_2 = $row['oj_EvaMacState_2'];
    $JudgeMacRunID = $row['oj_runid'];
    $JudgeAllRun_1 = $row['oj_allrun_1'];
    $JudgeAllRun_2 = $row['oj_allrun_2'];
}

function GetUserColor($Fight)
{
    if($Fight >= 3200)
        return '"myuser-base myuser-red"';
    else if($Fight >= 2800)
        return '"myuser-base myuser-fire"';
    else if($Fight >= 2600)
        return '"myuser-base myuser-orange"';
    else if($Fight >= 2400)
        return '"myuser-base myuser-yellow"';
    else if($Fight >= 2200)
        return '"myuser-base myuser-purple"';
    else if($Fight >= 2000)
        return '"myuser-base myuser-violet"';
    else if($Fight >= 1700)
        return '"myuser-base myuser-blue"';
    else if($Fight >= 1600)
        return '"myuser-base myuser-cyan"';
    else
        return '"myuser-base myuser-green"';
}

//改变字符串
function AlterString($Str)
{
    $iStr = $Str;
    $iStr = str_replace("<", "&lt;", $iStr);
    $iStr = str_replace(">", "&gt;", $iStr);
    $iStr = str_replace("\r\n", "<br/>", $iStr);
    return $iStr;
}

//还原字符串
function RestoreString($Str)
{
    $iStr = $Str;
    $iStr = str_replace("&lt;", "<", $iStr);
    $iStr = str_replace("&gt;", ">", $iStr);
    $iStr = str_replace("<br/>","\r\n",  $iStr);
    return $iStr;
}

LoadData();

    global $LandUser;
    global $User_Jurisdicton;
    $User_Jurisdicton = 0;

    if(isset($_SESSION['username']))
	{
        $sql = "SELECT * FROM oj_user where Name='".$_SESSION['username']."'";
        $rs = mysql_query($sql);
        $row = mysql_fetch_array($rs);

        if($row)
        {
            $LandUser = $_SESSION['username'];
            $User_Jurisdicton = $row['jurisdicton'];
        }
        else
        {
            session_unset();
            session_destroy();
            setcookie(session_name(), '', time() - 3600);
        }
    }

    define('JUR_ADMIN', 2);
    define('JUR_ONLYVIEWDATA', 1);
?>