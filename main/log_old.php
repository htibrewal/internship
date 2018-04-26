<?php
	include 'header.php';
	include'connect.php' ; //connects a database for taking entry
	session_start();  // session for a particular user starts here
	if(isset($_POST['login']))
	{
		$email=$_SESSION['user']=$_POST['email'];
		$pass=$_POST['password'];
		
		$q=mysql_query("select email,password from student where email='$email'");//selects email and password from table
		$r=mysql_num_rows($q);//checks whether email matches or not
		if($r==1)//email matches
		{
			$row=mysql_fetch_assoc($q);//fetches data  from that row
			$email=$row['email'];
			$password=$row['password'];//fetches email and password
			if($password==$pass)
			{
				$_SESSION['logged']=true;
				header("location:index.php");
			}else $_SESSION['logged']=false;
		}
		else echo"Email doesn't exist";
	}


if(isset($_POST['signin']))
{
	$username=$_POST['name'];
	$email=$_POST['email'];
	$password=$_POST['password'];
    $confirm=$_POST['confirm'];
	if($password==$confirm)
	{	$q=mysql_query("select email from student where email='$email'");
		$r=mysql_num_rows($q);
		if($r==0)
		{
			$querry=mysql_query("INSERT INTO student(name,email,password) values('$name','$email','$password')")or die(mysql_error());
			if($querry)
			{	$_SESSION['logged']=true;
				//echo "success";
				header("location:index.php");
			}
			else
			{	echo"Not registered";
				$_SESSION['logged']=false;
			}
		}
		else echo "Email already exits";
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
	left:800px;
	font-size:20px;
	border: 5px solid black;
	width: 300px;
    
    padding: 25px;
    margin: 25px;
}

#signin{
	position:absolute;
	top:200px;
	left:200px;
	font-size:20px;
	border: 5px solid black;
	width: 400px;
    
    padding: 25px;
    margin: 25px;
}

</style>

<br/>
<form method="post" Action="<?php echo $_SERVER['PHP_SELF'];?>">
<div id="student">
STUDENT'S LOG-IN<br/></br>
Email-Id <input type="text" name="email" required value="" title="email is necesary" placeholder="enter email"></br></br>
Password <input type="password" name="password" required value="" placeholder="enter password" minlength="6" maxlength="15"></br></br>
<input type="submit" name="login">
</div></br>
</form>
<form method="post" Action="<?php echo $_SERVER['PHP_SELF'];?>">
<div id="signin">
NEW STUDENT SIGN-IN<br/>
Name <input type="text" name="username" required value="" placeholder="enter your good names"></br></br>
Email-Id <input type="text" name="email" required value="" placeholder="Enter your email"></br></br>
Password <input type="password" name="password" required value="" placeholder="enter password"  minlength="6" maxlength="15"></br></br>
Confirm Password <input type="password" name="confirm" required value="" placeholder="enter password again"  minlength="6" maxlength="15" ></br></br>
<input type="submit" name="signin">
</div>
</form>
</html>
