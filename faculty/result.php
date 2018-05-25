<?php 
include("db.php");
session_start();
$username=$_SESSION['username'];
?>
<!DOCTYPE html>
<html>
<head>
	<title>Home</title>
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
							<a href="select_course.php">Mapping Course</a>
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
            <div class="table-responsive">
                <table class="table table-striped" border="1px solid black">
                    <?php 
			 $id = $_GET["value"];
			 $sql ="SELECT b.id,a.title,a.credit,b.semester,b.year,b.course_code,b.sec_no,b.username 
			 FROM course a INNER JOIN assigned_course b ON a.course_code = b.course_code WHERE 
			 b.username='$username' AND b.id='$id'";
			   if($result=mysqli_query($connection,$sql)){
				 if(mysqli_num_rows($result)>0){
					 $row=mysqli_fetch_array($result);
					 $course_code = $row["course_code"];
					 $sec_no = $row["sec_no"];
					 $semester = $row["semester"];
					 $year = $row["year"];
					 $username=$row['username'];
					 
					 echo "<tr>";
					 echo "<th>Course Code: </th>"."<td>".$row["course_code"]."</td>";
									 
					 echo "<th>Course Title: </th>"."<td>".$row["title"]."</td>";
						  
					 echo "<th>Credit: </th>"."<td>".$row["credit"]."</td>";
 
					 echo "<th>Section: </th>"."<td>".$row["sec_no"]."</td>";
									 
					 echo "<th>Semester: </th>"."<td>".$row["semester"]." ".$row["year"]."</td>";
					 echo "</tr>";
					 echo "</table>";
					 echo "</div>";
					 }
				}
			
		$sql1= "SELECT distinct a.id,a.s_id,a.assigned_course_id,a.grade FROM student_enrollment a INNER JOIN 
		assigned_course b ON b.id = a.assigned_course_id INNER JOIN result_processing c ON b.id=c.assigned_course_id
		WHERE b.id='$id'";
		   if($result1=mysqli_query($connection,$sql1)){
		if(mysqli_num_rows($result1)>0){
			$row_num=mysqli_num_rows($result1);
			while ($row1 = mysqli_fetch_array($result1)){
				 $se_id=$row1['id'];	
				 $s_id=$row1['s_id'];	
				 $g=$row1['grade'];
				// echo $g;
				$ass_course_id=$row1['assigned_course_id'];		   
	$sql2="SELECT a.assigned_course_id,SUM(a.marks) as marks FROM result_processing a INNER JOIN 
	 assigned_course c ON c.id=a.assigned_course_id WHERE a.assigned_course_id='$se_id' AND c.id='$id'";
if($result2=mysqli_query($connection,$sql2)){
	if(mysqli_num_rows($result2)>0){
		while($row2 = mysqli_fetch_array($result2)){
			$total_marks=$row2['marks'];
			
			$sql3="UPDATE student_enrollment SET total_marks='$total_marks' WHERE s_id='$s_id'";
			if($result3=mysqli_query($connection,$sql3)){
			}
			else echo mysqli_error($connection);
			$sql4="SELECT * FROM grade";
			if($result4=mysqli_query($connection,$sql4)){
				if(mysqli_num_rows($result4)>0){
					$row_num=mysqli_num_rows($result4);
					while ($row4 = mysqli_fetch_array($result4)){
						//echo "asd";
						//$g=$row4['grade'];
						$grade=$row4['grade'];
						$min=$row4['min_num'];
						$max=$row4['max_num'];
						if($total_marks>=$min && $total_marks<=$max && $g!='W'){
							echo $s_id;
							//echo $min."min ".$max."max ".$grade."<br>";
							$sql5="UPDATE student_enrollment SET grade='$grade' WHERE 
							assigned_course_id='$ass_course_id' AND s_id='$s_id' ";
							if($result5=mysqli_query($connection,$sql5)){
								//echo "dsa";
							}
							else echo mysqli_error($connection);
							}
						}
					}
				}
			}
		}
	}
}
}
}
else echo mysqli_error($connection);

// $sql5="SELECT DISTINCT a.student_enrollment_id FROM result_processing a INNER JOIN 
// student_enrollment b ON a.assigned_course_id=b.id INNER JOIN assigned_course c ON c.id=a.assigned_course_id 
// WHERE c.id='$id'";
// if($result5=mysqli_query($connection,$sql5)){
// if(mysqli_num_rows($result5)>0){
// 	while($row5 = mysqli_fetch_array($result5)){
// 		$s_id=$row5['student_enrollment_id'];
// 		$sql4="SELECT * FROM grade";
// 		if($result4=mysqli_query($connection,$sql4)){
// 			if(mysqli_num_rows($result4)>0){
// 				$row_num=mysqli_num_rows($result4);
// 				while ($row4 = mysqli_fetch_array($result4)){
// 					//echo "asd";
// 					$min=$row4['min_num'];
// 					$max=$row4['max_num'];
// 					if($total_marks>=$min && $total_marks<=$max){
// 						$grade=$row4['grade'];
// 						//echo $min."min ".$max."max ".$grade."<br>";
// 						$sql5="UPDATE student_enrollment SET grade='$grade' WHERE 
// 						 id='$s_id'";
// 						if($result5=mysqli_query($connection,$sql5)){
// 							//echo "dsa";
// 						}
// 						else echo mysqli_error($connection);
// 						}
// 					}
// 				}
// 			}
// 		}
// 	}
// }


 header('Location:st_po.php?value='.$id);

?>
			<br>
		</div>
	</div>
</body>

</html>

      