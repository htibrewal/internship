<?php
	include 'header.php';

	include 'connect.php' ;
	include 'log_button.php';
	session_start();
	
	if(isset($_POST['login_s']))                                  //login for student
	{
		$email=$_SESSION['user1']=$_POST['email'];  
		$pass=$_POST['password']; 
		$q=mysql_query("select email,password from student where email='$email'");
		
		$r=mysql_num_rows($q);
		if($r==1)
		{	$row=mysql_fetch_assoc($q);
	
			$password=$row['password'];
			if($password==$pass)
			{	$_SESSION['logged']=true;
				header("location:index.php");
			}else
				$_SESSION['logged_s']=false;
		}else echo"Login Unsuccessful";
	}


	if(isset($_POST['login_e']))
	{	//echo $_POST['login_e'];
		$username=$_SESSION['user2']=$_POST['username'];                           //user2 for employer
		$password=$_POST['password'];
		$q=mysql_query("select username,password from employer where username='$username'");
		
		$r=mysql_num_rows($q);
		if($r==1)
		{
			$row=mysql_fetch_assoc($q);
			$pass=$row['password'];
			if($password==$pass)
			{	$_SESSION['logged']=true;
				header("refresh:1; url=index.php");
			}else{
				echo "Wrong Password";
				$_SESSION['logged_e']=false;
			}
		}else
		{	echo "UserName Not Found";
			header("refresh:3; url=signup.php");
		}
	}
?>


<!doctypeHTML>
<html>
	<style type="text/css">
		h1{	
			position:absolute;
			top:0px;
			left:400px;
			font-size:60px;
		}
		body{
			background-image:url(5.jpg);
		}
		#student{
			position:absolute;
			top:200px;
			left:750px;
			font-size:20px;
			border: 5px solid black;
			border-radius:5px;
			width: 275px;
			
			padding: 25px;
			margin: 25px;
		}

		#signin{
			position:absolute;
			top:200px;
			left:200px;
			font-size:20px;
			border: 5px solid red;
			border-radius:5px;
			width: 300px;
			
			padding: 25px;
			margin: 25px;
		}
	</style>

<body>
	<form method="post" action="<?php echo $_SERVER['PHP_SELF'];?>">
		<div id="student">
			STUDENT'S LOG-IN<br/><br/>
			Email Id&nbsp;<input type="text" name="email" required placeholder="Enter Email"></br></br>
			Password&nbsp;<input type="password" name="password" required placeholder="Enter Password" minlength="6" maxlength="15"></br></br>
			<input type="submit" name="login_s" value="Student Login">
		</div></br>
	</form>
	<form method="post" action="<?php echo $_SERVER['PHP_SELF'];?>">
		<div id="signin">
			EMPOLYER'S LOG-IN<br/><br/>
			UserName&nbsp;<input type="text" name="username" required placeholder="Enter UserName"></br></br>
			Password&nbsp;<input type="password" name="password" required placeholder="Enter Password"  minlength="6" maxlength="15"></br></br>
			<input type="submit" name="login_e" value="Employer Login">
		</div>
	</form>
	</body>
</html>
