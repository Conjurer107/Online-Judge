<!DOCTYPE html>

<html lang="zh-cn">

<?php require_once('Php/HTML_Head.php') ?>

<body>

	<?php require_once ('Php/Page_Header.php') ?>

    <div>
        <center>

        <?php 
        echo '<h1>'.$WebName.'</h1>';
        ?>
        <br>
        <a>评测机代码(C++)由 XiaoJiang 编写</a><br>
        <a>服务端代码(PHP)由 XiaoJiang 编写</a><br>
        <a>前端框架使用 Bootstrap</a><br><br>
        此评测平台仅供学习
        </center>
    <div>

    <div class="container">
    <h2>当前状态</h2>
    <div class="panel panel-default">
			<table class="table table-striped table-hover">
				<thead><tr>
					<th>评测机</th>
                    <th>运行状态</th>
                    <th>累计评测</th>
				</tr></thead>

				<tbody>
					<tr>
						<td class="maxtext" >
							<a>题库评测机</a>
						</td>
                        <td class="maxtext">
                            <?php
                            if($JudgeMac_1 == 1)
                            {
                                echo '<span class="label label-success">正常运行中</span>';
                            }
                            else
                            {
                                echo '<span class="label label-danger">已关闭</span>';
                            }
                            ?>
                        </td>
                        <td class="maxtext">
							<a><?echo ($JudgeAllRun_1)?> 次</a>
						</td>
					</tr>

                    <tr>
						<td class="maxtext">
							<a>比赛评测机</a>
						</td>
                        <td class="maxtext">
                        <?php
                            if($JudgeMac_2 == 1)
                            {
                                echo '<span class="label label-success">正常运行中</span>';
                            }
                            else
                            {
                                echo '<span class="label label-danger">已关闭</span>';
                            }
                            ?>
                        </td>
                        <td class="maxtext">
							<a><?echo ($JudgeAllRun_2)?> 次</a>
						</td>
					</tr>
				</tbody>
			</table>
		</div>

        如果您有什么意见或可反馈的问题，可以在这里提交
        <textarea data-ctrlenter="#post_submit" name="content" placeholder="这里填具体描述" style="margin-top:8px;height:80px" class="form-control"></textarea>
        <button id="post_submit" style="margin-top:10px;" class="btn btn-default">提交</button>
    </div>
    </div>
    </div>
    
    <?php
	$PageActive = '';
	require_once('Php/Page_Footer.php');
	?>
</body>

</html>