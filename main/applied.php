<html>
	<head>
		<style>
			td, th{
				text-align:left;
			}
			
			#button{
				position:fixed;
				margin-right:10px;
				margin-top:10px;
				right:0;
				top:50px;
				padding: 10px 20px;
						text-align:center;
						font-size: 16px;
						border:none;
			}
		</style>
	</head>
	<body>
		<input type="button" onclick='location.href="?back=1"' id="button" value="Back" />
		
	</body>
</html>
	
	
<?php
	include 'header.php';
	include 'connect.php';
	include 'name.php';
	session_start();
	
	$user=$_SESSION['user2'];
	$val=$_SESSION['apply'];
	
	$q=mysql_query("select stud_id, name, email from student join internships on applied_for=intern_id where posted_by='$user' and  intern_id='$val' ");
	$num=mysql_num_rows($q);
					
	if($num>0){
		echo "<br><br><table style=width:40%><th>Student Id</th><th>Name</th><th>Email</th>";
		while($row=mysql_fetch_assoc($q))
			echo "<tr><td>".$row['stud_id']."</td><td>".$row['name']."</td><td>".$row['email']."</td></tr>";
						
		echo "</table>";}
	else echo "<br><br>No one has applied to the selected internship";
	
	if(isset($_GET["back"]))
	{	header("Refresh:1; url=index.php");
		$_GET["back"]=null;
	}
?>