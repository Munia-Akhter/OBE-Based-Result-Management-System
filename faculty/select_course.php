<?php 
include("db.php");
session_start();
$username=$_SESSION['username'];

if(isset($_POST['select_cc'])){
	$id = $_POST['select_cc'];
	$s="SELECT id
	FROM course_outcome WHERE 
	assigned_course_id='$id'";
	if($r=mysqli_query($connection,$s)){
	if(mysqli_num_rows($r)>=0){
		if(mysqli_num_rows($r)>0){
	 //	$row_num = mysqli_num_rows($r);
		//while ($row6 = mysqli_fetch_array($r)){
	
	header('Location:course_setup.php?value='.$id);
}
if(mysqli_num_rows($r)==0){
	header('Location:select_course.php?value='.$id);
}
}
}

}
if(isset($_POST['co_marks'])){
	$id = $_POST['co_marks'];
	echo $id;
	header('Location:co_po.php?value='.$id);
}

if(isset($_POST['select_cc'])){
	
	echo $id = $_POST['select_cc'];
	header('Location:course_setup.php?value='.$id);
}

if(isset($_POST['st_marks'])){
	
	$id = $_POST['st_marks'];
	header('Location:result_submission.php?value='.$id);
}
?>
<!DOCTYPE html>
<html>
<head>
  <title>Marks Distribution</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="../css/style.css">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-sweetalert/1.0.1/sweetalert.min.css">
  <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-sweetalert/1.0.1/sweetalert.min.js"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.4/css/bootstrap-select.min.css"></script>
</head>
<body>
   <div id="function">
   <nav class="navbar navbar-default" id="nb">
			<div class="container-fluid" id="nb2">
				<div class="navbar-header" id="nb3">
					<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1"
					  aria-expanded="false">
						<span class="sr-only">Toggle navigation</span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
					</button>
					<a class="navbar-brand" href="#">East West University</a>
				</div>

				<!-- Collect the nav links, forms, and other content for toggling -->
				<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
					<ul class="nav navbar-nav">
						<li>
							<a href="faculty_home.php">Home</a>
						</li>
						<li>
							<a href="course.php">Course</a>
						</li>
						<li>
							<a href="select_course.php" class="btn btn-info">Mapping Course</a>
						</li>
						<li>
							<a href="select_course_grade.php">Grade Distribution</a>
						</li>
					</ul>
					<ul class="nav navbar-nav navbar-right">
						<li>
							<a href="#">
								<span class="glyphicon glyphicon-user"></span>
							</a>
						</li>
						<li>
							<a href="../logout.php">
								<span class="glyphicon glyphicon-log-in"></span>
							</a>
						</li>
					</ul>
				</div>
			</div>
		</nav>

		    <div style="width:80%; margin:0px auto ;">
            	<h4 class="asscourse"><b>Assigned Course</b></h4>
				<div class="table-responsive">
            	 <table class="table table-striped" border="1px solid black">
				<form method="POST">
				    <thead>
				      <tr>
				        <th>Course Code</th>
				        <th>Course Title</th>
				        <th>Credit</th>
				        <th>Section</th>
				        <th>Semester</th>
				        <th colspan="3">Action</th>
				      </tr>
				    </thead>
				    <tbody>
					<?php
				$current_month = date("m");
				$current_year = date("Y"); 
				$flag = 0;
				if($current_month==1||$current_month==2||$current_month==3||$current_month==4){
					$s='Spring';
					$sql1 = "SELECT *
					FROM course c join offered_course o JOIN assigned_course a join faculty f join semester s
                    WHERE c.course_id=o.course_id and o.offered_course_id=a.offered_course_id and a.faculty_id=f.faculty_id and s.semester_id=a.semester_id and
					f.username='$username' AND s.semester='$s' AND o.year='$current_year'";
						$flag = 1; 
							}	
							if($current_month==5||$current_month==6||$current_month==7||$current_month==8){
							$s='Summer';
					$sql2 ="SELECT *
					FROM course c join offered_course o JOIN assigned_course a join faculty f join semester s
                    WHERE c.course_id=o.course_id and o.offered_course_id=a.offered_course_id and a.faculty_id=f.faculty_id and s.semester_id=a.semester_id and
					f.username='$username' AND s.semester='$s' AND o.year='$current_year'";
						$s='Summer';
						$flag = 2; 
							}
							if($current_month==9||$current_month==10||$current_month==11||$current_month==12){
							$s='Fall';
					$sql3 ="SELECT *
					FROM course c join offered_course o JOIN assigned_course a join faculty f join semester s
                    WHERE c.course_id=o.course_id and o.offered_course_id=a.offered_course_id and a.faculty_id=f.faculty_id and s.semester_id=a.semester_id and
					f.username='$username' AND s.semester='$s' AND o.year='$current_year'";
					$s='Fall';
					$flag = 3; 
							}	
					
				if(($flag==1 && ($result=mysqli_query($connection,$sql1)))||
					($flag==2 && ($result=mysqli_query($connection,$sql2)))||
					($flag==3 && ($result=mysqli_query($connection,$sql3)))) {
					if(mysqli_num_rows($result)>0){
		                while($row=mysqli_fetch_array($result)){
		                	echo "<td>".$row["course_code"]."</td>";
		                	
		                	echo "<td>".$row["title"]."</td>";
		                	
		                	echo "<td>".$row["credit"]."</td>";
		                	
		                	echo "<td>".$row["sec_no"]."</td>";
		                	
		                	echo "<td>".$row["semester"]." ".$row["year"]."</td>";
		                	?>
		                	<td><button name="co_marks" class="btn btn btn-danger btn-sm" value="<?php echo $row["assigned_course_id"] ?>">Assign CO Marks</button>
		                	</td>
		                	<td><button name="select_cc" class="btn btn-danger btn-sm" value="<?php echo $row["assigned_course_id"] ?>">Select Course Component</button>
		                	</td>
		                	<td><button name="st_marks" class="btn btn-danger btn-sm" value="<?php echo $row["assigned_course_id"] ?>">Assign Student Marks</button>
		                	</td>
		                	<?php
		                	echo "</tr>";
		                }
		            }
				} 
	
?>
			</form>
		</tbody>
	</table>
	</div><br>
</div>
</div>
</body>
</html>
