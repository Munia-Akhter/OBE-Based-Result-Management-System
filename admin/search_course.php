<?php include("db.php");
	session_start();?>

<!DOCTYPE html>
<html>
<head>
	<title>Course Outcome</title>
	<link rel="stylesheet" type="text/css" href="../css/stylesheet.css">
	<script src="../js/jquery-3.2.1.min.js"></script>
	<script src="../js/sweetalert.min.js"></script>
</head>
<body>
	<div class="dasboard"><h1>Admin Dashboard</h1></div>
	<div class="nav">
		<nav>
			<ul>
		        <li><a href="admin_dashboard.php">Dashboard</a></li>
		        <li><a href="course.php">Course</a></li>
		        <li><a href="offer_course.php">Offer Course</a></li>
		        <li><a href="select_assign_course.php">Assign Course</a></li>
		        <li><a href="course_outcome.php">Assign Course Outcome</a></li>
		        <li><a href="../logout.php">Log Out</a></li>
		   	</ul>
		</nav>
	</div>
	<div class="mainContent">
		<div class="content">
		<center>
				<form method="POST" action="">	
				<table>
				    <tr>
						<td>Semester</td>
						<td>
							<?php
								$sql="SELECT distinct semester FROM offered_course";
								if(mysqli_query($connection,$sql)){
            					$result=mysqli_query($connection,$sql);
							?>
							<select name="semester" required>
								<option></option>
								<option></option>
								<?php    
                                if(mysqli_num_rows($result) > 0) {
                                    while ($row = mysqli_fetch_array($result)) {
                            ?>
								<option value="<?php echo $row['semester'];
                            		?>"> <?php echo $row['semester'];?></option>
                            <?php
                                    }
                                }
                            ?>  
							</select>
						</td>
					</tr>
					<tr>
						<td>Year</td>
						<td>        					
        					<input type="text"  name="year" required size="6">
        				</td>	
					</tr>
					 <tr>
						<td>Department</td>
						<td>
							<?php
								$sql="SELECT distinct dept_name FROM course";
								if(mysqli_query($connection,$sql)){
            					$result=mysqli_query($connection,$sql);
							?>
							<select name="dept_name" required style="width:75px">
								<option></option>
								<?php    
                                if(mysqli_num_rows($result) > 0) {
                                    while ($row = mysqli_fetch_array($result)) {
                            ?>
								<option value="<?php echo $row['dept_name'];
                            		?>"> <?php echo $row['dept_name'];?></option>
                            <?php
                                    }
                                }
                            ?>  
							</select>
						</td>
					</tr>
			</table>	
			<br><hr>
			<input type="submit" name="search" class="button" value="Search"> 
			<hr>
			</form>
		</center>
		</div>
	</div>
	<footer class="mainFooter"></footer>
</body>
</html>
<?php 
	if($_POST){
		if(isset($_POST['search'])){
			$semester=mysqli_real_escape_string($connection, $_POST['semester']);
	    	$year=mysqli_real_escape_string($connection, $_POST['year']);
	    	$dept_name=mysqli_real_escape_string($connection, $_POST['dept_name']);
	    	header("Location:offered_course.php?value1=".$semester."&value2=".$year."&=value3".$dept_name);
		}
	}
?>