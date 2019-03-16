<?php
    require_once("LoadData.php");
    LoadData();

    if(isset($LandUser))
    {
        session_unset();
        session_destroy();
        setcookie(session_name(), '', time() - 3600);
        
        echo '<script>parent.RefreshPage();</script>';
    }
    
?>

<!DOCTYPE html>

<body>
	<div >
		<h1>正在注销登陆...</h1>
	</div>
</body>
</html>