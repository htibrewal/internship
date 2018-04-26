<?php
	include 'connect.php';
	if(isset($_GET["log"]))
	{	header("Refresh:1; url=log.php");}

	if(isset($_GET["sign"]))
		header("Refresh:1; url=signup.php");
?>

<!DOCTYPE html>
<html>
	<head>
		<style type="text/css">
			.button{
				
				margin-right:10px;
				margin-top:10px;
				border:none;
				padding: 10px 15px;
				text-align:center;
				font-size: 16px;
			}
			#log_but{
				position:absolute;
				right:100px;
				top:0;
				display:inline;}
			#sign_but{
				position:absolute;
				right:0;
				top:0;
				display:inline;
			}
		</style>
	</head>
	<body>
		<input type="button" onclick='location.href="?log=1"' id="log_but" class="button" value="LogIn" />
		<input type="button" onclick='location.href="?sign=1"' id="sign_but" class="button" value="Sign Up" />
	</body>
</html>