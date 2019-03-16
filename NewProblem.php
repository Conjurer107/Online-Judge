<!DOCTYPE html>

<html lang="zh-cn">

<?php require_once('Php/HTML_Head.php') ?>

<?php

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

    $status = 0;
    $ProblemData;
    if(array_key_exists('Problem', $_GET))
    {
        $status = 1;

        $sql = "SELECT * FROM oj_problem WHERE proNum='".$_GET['Problem']."'";
	    $result = mysql_query($sql);

	    if($result)
	    {
		    $ProblemData = mysql_fetch_array($result);

		    if(!$ProblemData)
		    {
			    header('Location: /Message.php?Msg=未知题号');
			    return;
            }
	    }
	    else
	    {
		    header('Location: /Message.php?Msg=查找失败');
		    return;
	    }
    }
    
    $sql = "select max(proNum) as value from oj_problem";
	$result = mysql_query($sql);
	$NewID = mysql_fetch_array($result); 
?>

<body>

	<?php require_once ('Php/Page_Header.php') ?>

    <div class="container">
    <div class="panel panel-default">

    <div class="panel-heading">新建题目</div>

    <div class="panel-body">
    <form enctype="multipart/form-data" name="upload_form" action="Php/SubmitNewPro.php" method="post" target="myIframeSubNePro">
    <div class="panel panel-default float-center" style="width:750px;">
    <!--style="display:none"-->
    <input name="NewType" style="display:none" value=<?php echo $status;?>>

    <div class="input-group">
        <span class="input-group-addon">题目名称</span>
        <input name="ProName" type="text" class="form-control" value=<?php echo ($status == 1) ? '"'.$ProblemData['Name'].'"' : '""';?>>

        <?php
        echo '<span class="input-group-addon">题目编号</span>';
        if($status == 1)
        {
            echo '<input name="ProNum" type="number" class="form-control" value="'.$ProblemData['proNum'].'" readonly="readonly">';
        }
        else
        {
            echo '<input name="ProNum" type="number" class="form-control" value="'.($NewID['value'] + 1).'">';
        }
        ?>
        
    </div>
    <br/>

    <div class="input-group">
        <span class="input-group-addon">限制时间(ms)</span>
        <input name="LimitTime" type="number" class="form-control" placeholder="1000" value=<?php echo ($status == 1) ? $ProblemData['LimitTime'] : '1000';?>>
        <span class="input-group-addon">限制内存(kb)</span>
        <input name="LimitMemory" type="number" class="form-control" placeholder="65535" value=<?php echo ($status == 1) ? $ProblemData['LimitMemory'] : '65535';?>>
    </div>
    <br/>

    <div>
        <span class="input-group-addon">题目描述：</span>
        <center>开启标签字符过滤 <input type="checkbox" name="AlterStr[]" checked = "true" value="Description"/></center>
        <textarea name="Description" class="form-control" style="margin-top:8px;height:80px"><?php echo ($status == 1) ? RestoreString($ProblemData['Description']) : '';?></textarea>
    </div>
    <br/>

    <div>
        <span class="input-group-addon">输入格式：</span>
        <textarea name="InputFormat"  class="form-control" style="margin-top:8px;height:80px"><?php echo ($status == 1) ? RestoreString($ProblemData['InputFormat']) : '';?></textarea>
    </div>
    <br/>

    <div>
        <span class="input-group-addon">输出格式：</span>
        <textarea name="OutputFormat" class="form-control" style="margin-top:8px;height:80px"><?php echo ($status == 1) ? RestoreString($ProblemData['OutputFormat']) : '';?></textarea>
    </div>
    <br/>

    <div>
        <span class="input-group-addon">样例输入：</span>
        <textarea name="ExpInput"  class="form-control" style="margin-top:8px;height:80px"><?php echo ($status == 1) ? RestoreString($ProblemData['EmpInput']) : '';?></textarea>
    </div>
    <br/>

    <div>
        <span class="input-group-addon">样例输出：</span>
        <textarea name="ExpOutput" class="form-control" style="margin-top:8px;height:80px"><?php echo ($status == 1) ? RestoreString($ProblemData['EmpOutput']) : '';?></textarea>
    </div>
    <br/>

    <div>
        <span class="input-group-addon">提示</span>
        <center>开启标签字符过滤 <input type="checkbox" name="AlterStr[]" checked = "true" value="Hint"/></center>
        <textarea name="Hint" class="form-control" style="margin-top:8px;height:80px"><?php echo ($status == 1) ? RestoreString($ProblemData['Hint']) : '';?></textarea>
    </div>
    <br/>

    <div>
        <span class="input-group-addon">来源：</span>
        <textarea name="Source" class="form-control" style="margin-top:8px;height:80px"><?php echo ($status == 1) ? RestoreString($ProblemData['Source']) : '';?></textarea>
    </div>
    <br/>

    <div class="input-group">
        <span class="input-group-addon">测试点文件编号</span>
        <input name="Test" type="text" class="form-control" placeholder="1&2&3&4" value=<?php echo ($status == 1) ? '"'.$ProblemData['Test'].'"' : '""';?> >
    </div>

    <div class="input-group">
        <span class="input-group-addon">选择测试点文件</span>
        <input class="btn btn-default" type="hidden" name="MAX_FILE_SIZE" value="30000"/>
        <input class="btn btn-default" type="file" name="userfile"/>
    </div>

    <center><button id="post_submit" style="margin-top:10px; width:500px;" class="btn btn-default">提交</button></center>
    <br/>
    </div>
    </form>
    <iframe id="myIframe" name="myIframeSubNePro" style="display:none"></iframe>
    </div>
    </div>
</div>
    <?php
	$PageActive = '#admin';
	require_once('Php/Page_Footer.php');
	?>
</body>

</html>