<?php include("db.php");
	$semester=$_GET['value1'];
	$year=$_GET['value2'];
	$dept_name=$_GET['value3'];?>
<!DOCTYPE html>
<html>
<head>
  <title>Select offered course</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="../css/style_2.css">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-sweetalert/1.0.1/sweetalert.min.css">
  <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-sweetalert/1.0.1/sweetalert.min.js"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.4/css/bootstrap-select.min.css"></script>
</head>
<body>
   <div id="function">
	   <div>
			<nav class="navbar navbar-default" id="nb">
			  <div class="container-fluid">
			    <div class="navbar-header">
			      <a class="navbar-brand" href="#">Admin Dashboard</a>
			    </div>
			  </div>
		  </nav>
      <div style="width:95%; margin:0px auto ;" id="nb2">
       <table id="tbl1" width="16%" height="565px">
        <tr><td valign="top"><br>
			<a href="#" class="glyphicon glyphicon-user">EWU</a><br><br>
          	<a href="admin_dashboard.php">Dhasboard</a><br><br>
          	<a href="department.php" >Department</a><br><br>
          	<a href="course.php">Course</a><br><br>
          	<a href="offered_course.php">Offer Course</a><br><br>
          	<a href="assign_course.php" class="btn btn-info">Assign Course</a><br><br>
          	<a href="component.php">Component</a><br><br>
          	<a href="history.php">Student PO</a><br><br>
			<a href="st_enrollment.php">Student Enrollment</a><br><br>
          	<a href="../logout.php" class="glyphicon glyphicon-log-out"></a>
          </td>
        </tr>
      </table>  
	  <div style="width:100%; margin:0px auto ; ">
	 	<table id="tbl2" class="table table-striped" border="1px solid black" width="40%">
			<tr><th colspan="4">Offer Course</th></tr>
			<tr><?php 
					echo "<th>Department: </th>" ."<td>". $dept_name . "</td>";
					echo "<th>Semester: </th>". "<td>".$semester ." " .$year. "</td>";	
				?>
			</tr>
		</table>
	  <form method="POST" action="">
        <table id="tbl2" class="table table-striped" border="1px solid black" width="40%">
		<?php

		$sql2 = "SELECT * FROM course c JOIN offered_course o join assigned_course a JOIN semester s  JOIN dept d join faculty f 
			WHERE  c.course_id=o.course_id AND o.offered_course_id=a.offered_course_id and f.faculty_id=a.faculty_id and s.semester_id=o.semester_id and d.dept_id=c.dept_id AND  o.year='$year'and d.dept='$dept_name' AND s.semester='$semester'";
		$select=mysqli_query($connection,$sql2);
		if(mysqli_num_rows($select) > 0){
		?>
		<thead>
			<tr>
				<th>Course Code</th>
				<th>Instructor Name</th>
				<th>Section</th>
			</tr>
		</thead>
		<tbody>
				<?php
					 while($row=mysqli_fetch_array($select)){
						echo "<tr>";
						echo "<td>".$row["course_code"]."</td>";
						echo "<td>".$row["username"]."</td>";
						echo "<td>".$row["sec_no"]."</td>";
						echo "</tr>";
					}
				}
				else{
					// echo "<script>alert('Data not found');</script>";
					echo '<script type="text/javascript">'; 
	                echo 'setTimeout(function () {  swal("Data not found");';
	                echo '},600);</script>';
	                ?>
	               	<script type="text/javascript">
	                	setTimeout(function () {
	               			window.location="assign_course.php";
	               			},3000);
	                </script>
				<?php
				}
				?>
		</tbody>
		</table>

		 </div>		
	   </div>
	</div>
</body>
</html>
