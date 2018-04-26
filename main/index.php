<?php
	include 'header.php';
	
	include 'connect.php';
	session_start();
		
	$next_m=date("Y-m-d", mktime(0, 0, 0, date("m")+1 , date("d"), date("Y")));
	$today=date("Y-m-d");
	
	if($_SESSION['logged']==false)
		include 'log_button.php';
	else if(isset($_SESSION['logged']) && $_SESSION['logged']==true)
		include 'name.php';
	else
	{	$_SESSION['logged']=false;
		include 'log_button.php';
	}
	
	$per_page=3;
	
	if($_SESSION['logged']==true && !is_null($_SESSION['user2'])){
		$p_by=$_SESSION['user2'];
		$page_q=mysql_query("select count(intern_id) from internships where posted_by='$p_by' and apply_by>'$today' ");
	}else
		$page_q=mysql_query("select count(intern_id) from internships where apply_by>'$today'");
	
	
	$pages=ceil((mysql_result($page_q, 0))/$per_page);
	
	$page=(isset($_GET['page']))?(int)$_GET['page']:1;
	if($page>$pages && $pages>0) header("Location:index.php");
	
	$start=($page-1)*$per_page;
	
	
	if($_SESSION['logged']==true && !is_null($_SESSION['user2'])){
		$p_by=$_SESSION['user2'];
		$qu=mysql_query("select * from internships where posted_by='$p_by' and apply_by>'$today' order by intern_id ASC limit $start,$per_page");}
	else
		$qu=mysql_query("select * from internships where apply_by>'$today' order by intern_id ASC limit $start,$per_page");
	$num=mysql_num_rows($qu);
?>


<!DOCTYPE html>
<html>
	<head>
		<title>Kochi Interns..</title>
		<style type="text/css">
			div.box{
				width:82%;
				position:relative;
				top:40px;
				height:125px;
				border:1px solid blue;
				border-radius:5px;
				margin:15px;
				z-index:0;
				<!--background-color:#81c784;-->
				overflow:auto;
				}
			
			#id{
				position:absolute;
				top:0;
				left:930px;
			}				
		</style>
		<script>    
			if(typeof window.history.pushState == 'function') {                    //removes the ? part from the url
				window.history.pushState({}, "Hide", '<?php echo $_SERVER['PHP_SELF'];?>');
			}
		</script>
	</head>
	<body>
		<?php
			if($num>0){
				while($row=mysql_fetch_assoc($qu)){                        //will fetch all rows one by one which satisfy the query
					//if(date('Y-m-d')>$row['apply_by']) continue;
			?>
					<div class="box"><p style="position:absolute; top:0; left:5px;">Title : <?php echo $row['title'];?></p>
						<a href="index.php?apply=<?php echo $row['intern_id']; ?>" title="<?php if(!is_null($_SESSION['user2'])) echo "Click to View"; else echo "Click to Apply"; ?>" ><p id="id">Internship ID : <?php echo $row['intern_id'];?> </p></a>
						<p style="position:absolute; top:35%; left:5px;">Description : <?php echo $row['descript'];?></p>
						<p style="position:absolute; top:105px; left:5px;">Start Date : <?php echo $row['start'];?></p><p style="position:absolute; top:105px; left:25%;">Apply By Date : <?php echo $row['apply_by'];?></p><p style="position:absolute; top:105px; left:57%;">Stipend : <?php echo $row['stipend'];?></p><p style="position:absolute; top:105px; left:82%;">Posted By : <?php echo $row['posted_by'];?></p>
					</div>
					
			<?php
				}
				echo "<br><br><br>";
				$prev=$page-1;
				$next=$page+1;
				
				echo "<center>";
				if($page>1)
					echo '<a href="index.php?page='.$prev.'">Prev</a>&nbsp;&nbsp;';
				
				if($pages>=1 && $page<=$pages){
					for($x=1; $x<=$pages; $x++){
						echo '<a href="?page='.$x.' ">'.$x.'</a>&nbsp;&nbsp;';
					}
				}
			
				if($page<$pages)
					echo '<a href="index.php?page='.$next.'">Next</a>';
				echo "</center>";
			
				echo "<br><br><br><br>";
			}else echo "No internships found currently<br>";
			?>
			
	
		<div style="position:fixed; width:73%; height:30px; background-color:#8d6e63; padding:10px; z-index:1; bottom:5px">
			<form action="<?php echo $_SERVER["PHP_SELF"];?>" method="post">
				<input type="text" name="title" required placeholder="Enter Title">
				&nbsp;&nbsp;<input type="textarea" name="descr" placeholder="Enter Description">
				&nbsp;&nbsp;<input type="number" name="stipend" placeholder="Enter Stipend">
				&nbsp;&nbsp;<input type="date" name="start" required min="<?php echo $next_m; ?>" title="Enter Starting Date">
				&nbsp;&nbsp;<input type="date" name="apply" required min="<?php echo date('Y-m-d'); ?>" title="Enter Apply By Date">
				<!--&nbsp;&nbsp;<input type="text" name="provider" placeholder="Internship posted by..." title="Enter your Username">-->
				&nbsp;&nbsp;<input type="submit" name="post" value="Post your internship"><br>
		</form></div>
		
		<!--<table border="1"><th>Internship ID</th><th>Title</th><th>Description</th><th>Stipend (Rs)</th><th>Start Date</th><th>Apply By</th><th>Posted By</th>
 
		</table>-->
	
		<?php
		
			if($_SESSION['logged']==true && is_null($_SESSION['user1'])==false){                      //if student wants to apply
				$e=$_SESSION['user1'];
				
				$q=mysql_query("select applied_for from student where email='$e' ");
				$row=mysql_fetch_assoc($q);
				
				if(isset($_GET['apply'])){
					if(is_null($row['applied_for'])==false){
						if($row['applied_for']==$_GET['apply']) echo '<script type="text/javascript"> alert("You have already applied to this internship"); </script>';
						else echo '<script type="text/javascript"> alert("You have an ongoing internship"); </script>';
					}
					else{
						$v=$_GET['apply'];
					
						mysql_query("update student set applied_for='$v' where email='$e' ");
						echo '<script type="text/javascript"> alert("Applied for internship"); </script>';
						
						header("Refresh:1; url=index.php");
					}
				}
				$_GET['apply']=null;
			}
			else if(is_null($_SESSION['user1']) && isset($_GET['apply']) )                         //if clicked on id but not logged in
				echo '<script type="text/javascript"> alert("Login to apply for an internship"); </script>';
			
			
			
			if($_SESSION['logged']==true && !is_null($_SESSION['user2'])){                              //if employer wants to check who have applied
				
				if(isset($_GET['apply'])){
					$_SESSION['apply']=$_GET['apply'];
					header("Location: applied.php");				
				}
				$_GET['apply']=null;
			}
			
			if(isset($_POST["post"])){
				$title=$_POST['title'];
				$desc=$_POST['descr'];
				$stipend=$_POST['stipend'];
				$s_date=$_POST['start'];
				$a_date=$_POST['apply'];
				
				if($_SESSION['logged']==true && is_null($_SESSION['user2'])==false){
					$p_by=$_SESSION['user2'];
					$q=mysql_query("insert into internships(title, descript, stipend, start, apply_by, posted_by) values ('$title', '$desc', '$stipend', '$s_date', '$a_date', '$p_by') ");
					header("location:index.php");
				}else{
					echo '<script type="text/javascript"> alert("Login to post an Internship"); </script>';
					//header("location:log.php");
				}
			}
			
			//SELECT name FROM `student` join `internships` on `applied_for`=`intern_id` where posted_by='' and intern_id=''       - to view who have applied for an internship
		?>
		
		
	</body>
</html>