<?php
	include 'connect.php';
	session_start();
	if(isset($_SESSION['user1'])) $user=$_SESSION['user1'];
	else $user=$_SESSION['user2'];
	
	if($_SESSION['logged']==true && isset($_GET['logout'])){
		$_SESSION['logged']=false;
		
		if(isset($_SESSION['user1'])) $_SESSION['user1']=null;
		else $_SESSION['user2']=null;
		
		header("Location: index.php");
	}
	
	$_GET['logout']=null;
?>

<!DOCTYPE html>
<html>
	<head>
		<style type="text/css">
			.button{
				position:fixed;
				margin-right:10px;
				margin-top:10px;
				right:0;
				top:0px;
				border:none;
				padding: 10px 20px;
				text-align:center;
				font-size: 16px;
			}
		</style>
	</head>
	<body>
		<p style="top:-40px; left:0; margin-right:10px;">Hi, <?php echo $user; ?></p>
		<input type="button" onclick='location.href="?logout=1"' class="button" value="LogOut" />
	</body>
</html>