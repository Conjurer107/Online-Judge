<script>
	var Stime = new Date(<?php echo $NowTime ?>);
	var Sdiff = new Date() - Stime;
</script>
<footer class="bs-docs-footer" role="contentinfo">
	<canvas id="canvas" style="width:210px;" height="100" width="700">当前浏览器不支持canvas，请更换浏览器后再试</canvas>
	<br />
	<div class="container">
		<ul class="footer-links">
			<li>
				<a href="/About.php">
				<span class="glyphicon glyphicon-star-empty">About</span>
				</a>
			</li>

			<li>
				<a href="/FAQ.php">FAQ</a>
			</li>
		</ul>
		<p>Copyright © 2019 XiaoJiang. All rights reserved.<br /></p>
	</div>
</footer>
<script>
	(function () {
		var activeLink = <?php echo "'".$PageActive."'"?>;
		activeLink && $(activeLink).addClass("active");
	})();
</script>

<script src="js/canvasTime.js"></script>
<script src="js/catalog.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="js/custom.js"></script>

<?php
//关闭数据库
mysql_close($con);
?>