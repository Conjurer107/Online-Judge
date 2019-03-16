<?php
	require_once("LoadData.php");
    LoadData();

    if(!isset($LandUser))
    {
        header('Location: /Message.php?Msg=您没有登陆，无权访问');
		return;
    }
    if($User_Jurisdicton != JUR_ADMIN)
    {
        header('Location: /Message.php?Msg=您不是管理员，无权访问');
		return;
    }

    $Hint = $_POST['Hint'];
    $Description = $_POST['Description'];

    if(count($_POST['AlterStr']) != 0 && ($_POST['AlterStr'][0] == 'Hint' || $_POST['AlterStr'][1] == 'Hint'))
    {
        $Hint = AlterString($_POST['Hint']);
    }
    
    if(count($_POST['AlterStr']) != 0 && ($_POST['AlterStr'][0] == 'Description' || $_POST['AlterStr'][1] == 'Description'))
    {
        $Description = AlterString($_POST['Description']);
    }

    if($_POST['NewType'] == 1)
    {
        $sql = "UPDATE `oj_problem` SET `Name` = '".$_POST['ProName']."', `LimitTime` = '".$_POST['LimitTime']."', `LimitMemory` = '".$_POST['LimitMemory']."', `Description` = '".$Description."', `InputFormat` = '". AlterString($_POST['InputFormat'])."', `OutputFormat` = '".AlterString($_POST['OutputFormat'])."', `EmpInput` = '".AlterString($_POST['ExpInput'])."', `EmpOutput` = '". AlterString($_POST['ExpOutput']) ."', `Hint` = '".$Hint."', `Source` = '". AlterString($_POST['Source'])."', `Test` = '".$_POST['Test']."' WHERE proNum = '".$_POST['ProNum']."'";
        $result = mysql_query($sql);
        echo "<script>alert('修改题目成功！');</script>";
    }
    else
    {
        $sql = "INSERT INTO `oj_problem` (`Name`, `proNum`, `LimitTime`, `LimitMemory`, `Description`, `InputFormat`, `OutputFormat`, `EmpInput`, `EmpOutput`, `Hint`, `Source`, `CreateTime`, `Test`) VALUES ('".$_POST['ProName']."', '".$_POST['ProNum']."', '".$_POST['LimitTime']."', '".$_POST['LimitMemory']."','".$Description."', '". AlterString($_POST['InputFormat']) ."', '". AlterString($_POST['OutputFormat'])."', '". AlterString($_POST['ExpInput'])."', '". AlterString($_POST['ExpOutput'])."', '".$Hint."', '". AlterString($_POST['Source']) ."', '".date('Y-m-d')."', '".$_POST['Test']."');";
        $result = mysql_query($sql);
        echo "<script>alert('添加题目成功！');</script>";
    }
    

    echo "<script>parent.GoHistoryPage();</script>";
?>