<?php
	error_reporting(E_ALL ^ E_DEPRECATED);
	date_default_timezone_set('Asia/Kolkata');
	error_reporting(0);
	
	mysql_connect("localhost", "root","") or die("problem_conn");  //if error occurs thenmessage in die is printed
	mysql_select_db("internship");
?>