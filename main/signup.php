<?php
	session_start();
	include 'header.php';
	include 'connect.php';

	if(isset($_POST['studentsign']))
	{ 
		$username=$_POST['username'];
		$email=$_POST['email'];
		$password=$_POST['password'];
		$confirm=$_POST['confirm'];	
		
		if($password==$confirm)
		{
			$q=mysql_query("select email from student where email='$email'");
			$r=mysql_num_rows($q);
			if($r==0)
			{
				$querry=mysql_query("INSERT INTO student(name,email,password) values('$username','$email','$password')")or die(mysql_error());
				if($querry)
				{
					$_SESSION['logged']=true;
					$_SESSION['user1']=$email;
					header("location:index.php");
				}else{
					echo "Failure";
				}
			}else
			{	$_SESSION['logged']=false;
				echo "Email already exists";
			}
		}else
			echo "Password does not match";
	}

	if(isset($_POST['signin']))
	{
		$username=$_POST['username'];
		$name=$_POST['name'];
		$email=$_POST['email'];
		$password=$_POST['password'];
		$confirm=$_POST['confirm'];	
		
		if($password==$confirm)
		{
			$q=mysql_query("select username from employer where username='$username'");
			$r=mysql_num_rows($q);
			if($r==0)
			{
				$querry=mysql_query("INSERT INTO employer(username,name,email,password) values('$username','$name','$email','$password')")or die(mysql_error());
				if($querry)
				{
					$_SESSION['logged']=true;
					$_SESSION['user2']=$username;
					header("location:index.php");
				}else{
					echo "Failure";
					$_SESSION['logged']=false;
				}
			}else{
				$_SESSION['logged']=false;
				echo "Username already exists";
			}
		}else
			echo "Password does not match";
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
#sign1{
	position:absolute;
	top:130px;
	left:750px;
	font-size:20px;
	border: 5px solid black;
	width: 250px;
    border-radius:5px;
    padding: 15px 25px;
    margin: 25px;
}

#sign2{
	position:absolute;
	top:130px;
	left:200px;
	font-size:20px;
	border: 5px solid magenta;
	width: 250px;
    border-radius:5px;
    padding: 15px 25px;
    margin: 25px;
}
</style>
<form method="post" Action="<?php echo $_SERVER['PHP_SELF'];?>">
<div id="sign1">
STUDENT'S SIGN-IN<br/></br>
Student Name</br><input type="text" name="username" required placeholder="enter your good name"><br/></br>
Email Id</br><input type="text" name="email" required title="email is necesary" placeholder="enter email"></br></br>
Password</br><input type="password" name="password" required placeholder="enter password" minlength="6" maxlength="15"></br></br>
Confirm Password<br><input type="password" name="confirm" required placeholder="enter password again" minlength="6" maxlength="15"></br></br>
<input type="submit" name="studentsign">
</div></br>
</form>
<form method="post" Action="<?php echo $_SERVER['PHP_SELF'];?>">
<div id="sign2">
EMPOLYER'S SIGN-IN<br/><br/>
UserName</br><input type="text" name="username" required value="" placeholder="enter company id" title="it should be unique"></br></br>
Name</br><input type="text" name="name" required value="" placeholder="Enter Full Name"></br></br>
Email Id</br><input type="text" name="email" required title="email is optional" placeholder="enter email"></br></br>
Password</br><input type="password" name="password" required value="" placeholder="enter password"  minlength="6" maxlength="15"></br></br>
Confirm Password</br><input type="password" name="confirm" required value="" placeholder="enter password again"  minlength="6" maxlength="15"></br></br>
<input type="submit" name="signin">
</div>
</form>