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
							<a href="history.php">History</a>
						</li>
						<li>
							<a href="select_course.php">Marks Distribution</a>
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
			<form action=""></form>
			<div class="table-responsive">
				<table class="table table-striped" border="1px solid black">
					<thead>
						
					</thead>
					<tbody>
						
					</tbody>
				</table>
			</div>
			<br>
			<div style="width:80%; margin:0px auto ;">
            <div class="table-responsive">
                <table class="table table-striped" border="1px solid black">
                    <?php 
			 $id= $_GET["value"];

		     $sql = "SELECT b.id,a.title,a.credit,b.semester,b.year,b.course_code,b.sec_no,b.username 
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
                    $ass_course_id=$row['id'];
                    $title=$row['title'];
                    $credit=$row['credit'];
					
					
					echo "<tr>";
		            echo "<th>Course Code: </th>"."<td>".$course_code."</td>";
		                            
		            echo "<th>Course Title: </th>"."<td>".$row["title"]."</td>";
		                 
		            echo "<th>Credit: </th>"."<td>".$row["credit"]."</td>";

		            echo "<th>Section: </th>"."<td>".$row["sec_no"]."</td>";
		                            
		            echo "<th>Semester: </th>"."<td>".$row["semester"]." ".$row["year"]."</td>";
		            echo "</tr>";
					echo "</table>";
					echo "</div>";
		            }
		        }
				$sql2="SELECT * FROM student_enrollment where assigned_course_id='$ass_course_id'";
			    if($result2=mysqli_query($connection,$sql2)){
			        if(mysqli_num_rows($result2)>0){
			        	$row_num=mysqli_num_rows($result2);
			        	while ($row = mysqli_fetch_array($result2)){
			        		$s_id=$row['s_id'];
			        		$s="SELECT sum(a.marks) as marks
								FROM  result_processing a, student_enrollment b
								WHERE a.assigned_course_id = b.assigned_course_id
								AND a.student_enrollment_id = b.id
								AND a.assigned_course_id =   '$ass_course_id'
								AND b.s_id =  '$s_id'
								";
								if($result6=mysqli_query($connection,$s)){
								if(mysqli_num_rows($result6)>0){
									while ($row6 = mysqli_fetch_array($result6)){
											$sum=$row6['marks'];
											$q="UPDATE student_enrollment SET total_marks='$sum' WHERE s_id='$s_id' AND assigned_course_id='$ass_course_id' ";
									if($resultq = mysqli_query($connection, $q)){
										//$c=sprintf("%.2f",(100*$b)/$co_marks);
}
								
						}}}
			        	}
			    }
			}
			echo "<table class='table table-striped' border='1px solid black'>";
			
			echo "<tr>";
			if(isset($course_code))
				echo "<th>"."Course Code</th>"."<th>".$course_code."</th>";
			if(isset($sec_no))
				echo "<th>Section ".$sec_no."</th>";
				
			$sql3="SELECT distinct component FROM result_processing WHERE assigned_course_id='$ass_course_id'";
			if($result3=mysqli_query($connection,$sql3)){
			    if(mysqli_num_rows($result3)>0){
			        while ($row3 = mysqli_fetch_array($result3)){
			        	$component=$row3['component'];
			        	$sql="SELECT cc_marks FROM marks_component WHERE assigned_course_id='$ass_course_id' AND component='$component'";
			        	
			        		//echo "<td rowspan='4'>Obtained</td>";
			        	if($result=mysqli_query($connection,$sql)){
			    if(mysqli_num_rows($result)>0){
			        while ($row = mysqli_fetch_array($result)){
			        	echo "<th rowspan='2' colspan='3'>".$row3['component']."</th><td rowspan='2'>".$row['cc_marks']."</td>";
			        }
			    }
			}
		}
	}
}
echo "<td rowspan='3'>"."Total Marks"."</td>";
			echo "<td rowspan='4'>"."Letter Grade"."</td>";
			echo "</tr>";
			echo "<tr>";
				
			if(isset($title))
				echo "<th >Course Title</th>"."<th colspan='2'>".$title."</th>";

				echo "</tr>";
				echo "<tr>";
			if(isset($credit))
				echo "<th>Credit</th>"."<th>".$credit."</th>";
			if(isset($semester)&&isset($year))
				echo "<th>".$semester." ".$year."</th>";
				if($result3=mysqli_query($connection,$sql3)){
			    	if(mysqli_num_rows($result3)>0){
			        	while ($row3 = mysqli_fetch_array($result3)){
			        		$component=$row3['component'];
				        	$sql4="SELECT a.course_outcome_id
							FROM marks_distribution a, marks_component b
							WHERE a.assigned_course_id = b.assigned_course_id
							AND b.id = a.marks_component_id
							AND a.assigned_course_id =  '$ass_course_id'
							AND b.component =  '$component'";
				        	if($result4=mysqli_query($connection,$sql4)){
				    			if(mysqli_num_rows($result4)>0){
							        while ($row4 = mysqli_fetch_array($result4)){
							        	echo "<td>".'CO'.$row4['course_outcome_id']."</td>";
							        	 }
							    }
							}
				        }
				    }
				}
			/**if($result4=mysqli_query($connection,$sql4))
				$row_num=mysqli_num_rows($result4);*/
			echo "</tr>";
			echo "<tr>";
			echo "<th>SL</th>"."<th>"."Student ID"."</th>";
			echo "<th>Name</th>";
			$sum=0;
	if($result3=mysqli_query($connection,$sql3)){
		if(mysqli_num_rows($result3)>0){
			while ($row3 = mysqli_fetch_array($result3)){
			   $component=$row3['component']; 
			   $sql5="
			 			SELECT a.co_marks,a.course_outcome_id, b.component
							FROM marks_distribution a, marks_component b
							WHERE a.assigned_course_id = b.assigned_course_id
							AND b.id = a.marks_component_id
							AND a.assigned_course_id =  '$ass_course_id'
							AND b.component =  '$component'";
				if($result5=mysqli_query($connection,$sql5)){
					if(mysqli_num_rows($result5)>0){
						while ($row5 = mysqli_fetch_array($result5)){
							$co_for_component=$row5['course_outcome_id'];	
							
								echo "<td>".$row5['co_marks']."</td>";
							/*	$sql5="
			 			SELECT total_marks
							FROM student_enrollment
							WHERE assigned_course_id =  '$ass_course_id'
							ORDER BY RIGHT(s_id, 3) ASC;";
				if($result5=mysqli_query($connection,$sql5)){
					if(mysqli_num_rows($result5)>0){
						while ($row5 = mysqli_fetch_array($result5)){
						}}}*/

								
			        }
			    }
			}
			}
		}
	}
			echo "<td>".$sum."</td>";
			echo "</tr>";
			$i=1;
			
			if($result2=mysqli_query($connection,$sql2)){
			    if(mysqli_num_rows($result2)>0){
			       	$row_num=mysqli_num_rows($result2);
			        while ($row = mysqli_fetch_array($result2)){
				        	
			        	$s_id=$row['s_id'];
			        	$name=$row['name'];
			
					echo "<tr>";
						echo "<td>".$i."</td>";
						echo "<td>".$s_id."</td>";
						echo "<td>".$name."</td>";
					
				$i++;
			

				
				//echo "<tr>";	
				//echo "<td></td>";
				//echo "<td></td>";
				//echo "<td>Obtained marks</td>";	



				/*				$sql3="SELECT component FROM marks_component WHERE course_code='$course_code' AND sec_no='$sec_no' AND semester='$semester' AND year='$year'";
								if($result3=mysqli_query($connection,$sql3)){
					        	while($row3 = mysqli_fetch_array($result3)){
								        	$component=$row3['component'];
						
								  $sql12="SELECT total_marks  FROM result_processing  WHERE course_code='$course_code' AND sec_no='$sec_no' AND semester='$semester' AND year='$year' AND component='$component' AND s_id='$s_id'";
									if($result6=mysqli_query($connection,$sql6)){
										if(mysqli_num_rows($result6)>0){
											while($row6 = mysqli_fetch_array($result6)){

//												$sum_component=$row6['marks'];
//												$sum=array_chunk($sum_component,$row_num);
//												$total=array_sum($sum);
				echo "<td colspan='4'> = ".$row6['total_marks']."</td>";
					*/
$sql1="SELECT a.marks 
FROM result_processing a, student_enrollment b, component c
WHERE a.assigned_course_id = b.assigned_course_id
AND a.component = c.component
AND a.assigned_course_id =  '$ass_course_id'
AND b.assigned_course_id =  '$ass_course_id'
AND b.id = a.student_enrollment_id
AND b.s_id =  '$s_id'";

			    if($result1=mysqli_query($connection,$sql1)){
			        if(mysqli_num_rows($result1)>0){
			        	$row_num=mysqli_num_rows($result1);
			        	while ($row1 = mysqli_fetch_array($result1)){
								echo "<td>".$row1['marks']."</td>";
			        			
				
									}
								}
							}
				$sql1="SELECT * FROM student_enrollment where assigned_course_id='$ass_course_id' AND s_id='$s_id'";
			    if($result1=mysqli_query($connection,$sql1)){
			        if(mysqli_num_rows($result1)>0){
			        	$row_num=mysqli_num_rows($result1);
			        	while ($row1 = mysqli_fetch_array($result1)){
								echo "<td>".$row1['total_marks']."</td>";
			        			echo "<td>".$row1['grade']."</td>";
				
									}
								}
							}
						}
					}
				}

				echo "</tr>";

			    
			
		
			echo "</table>";
			?>
		</div>
	</div>
</body>

</html>
