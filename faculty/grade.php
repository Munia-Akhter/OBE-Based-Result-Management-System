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
    <!-- javascript -->
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
				?>
				<div style="width: 100px; height: 30px;">
				<a href="select_course_grade.php?value=<?php ?>">Go Back</a>
			</div>
   <?php
	$per_grade=array();
	$grade=array();			
	$sql="SELECT a.assigned_course_id,b.id FROM assigned_course b INNER JOIN student_enrollment a 
	ON b.id = a.assigned_course_id  WHERE b.username='$username' AND b.id='$id'";
			 if($result=mysqli_query($connection,$sql)){
		if(mysqli_num_rows($result)>0){
			$row_num=mysqli_num_rows($result);
			$row = mysqli_fetch_array($result);
			$ass_course_id=$row['id'];
			$sql1="SELECT * FROM grade";
		    if($result1=mysqli_query($connection,$sql1)){
		       	if(mysqli_num_rows($result1)>0){
		    		$sql2="SELECT * FROM  grade_distribution";
					if($result2=mysqli_query($connection,$sql2)){
						if(mysqli_num_rows($result2)>=0){
														if(mysqli_num_rows($result2)==0){
							
								while ($row1 = mysqli_fetch_array($result1)) {
									
									$grade=$row1['grade'];
									$i=1; 
									$sql3 = "INSERT INTO grade_distribution (assigned_course_id,grade) VALUES('$ass_course_id','$grade')";
									if($result3=mysqli_query($connection,$sql3)){
										
									}
									else
										echo mysqli_error($connection);
								}	
							}
							else if(mysqli_num_rows($result2)>0){
								while ($row2 = mysqli_fetch_array($result2)){
									$sql="SELECT b.assigned_course_id FROM 
									assigned_course b INNER JOIN grade_distribution  a ON 
									b.id = g.assigned_course_id  WHERE b.id!='$id'";
									if($result=mysqli_query($connection,$sql)){
										if(mysqli_num_rows($result)>0){
											while ($row = mysqli_fetch_array($result)) {
												$ass_course_id=$row['id'];
												$sql3 = "INSERT INTO grade_distribution (assigned_course_id,grade) VALUES('$ass_course_id','$grade')";
												$result3=mysqli_query($connection,$sql3);
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
	}
$sql1="SELECT * FROM grade";
if($result1=mysqli_query($connection,$sql1)){
	if(mysqli_num_rows($result1)>0){
		while($row1=mysqli_fetch_array($result1)){
			 $grade=$row1['grade'];
			 "SELECT a.assigned_course_id,b.id FROM assigned_course b INNER JOIN grade_distribution a 
	ON b.id = a.assigned_course_id  WHERE b.username='$username' AND b.id='$id'";
	
			$sql4="SELECT a.assigned_course_id FROM student_enrollment a INNER JOIN assigned_course b 
			ON b.id=a.assigned_course_id WHERE b.id='$id' AND a.grade='$grade'";
			if($result4=mysqli_query($connection,$sql4)){
	   			if(mysqli_num_rows($result4)>0){
					   $row_num1=mysqli_num_rows($result4);
					   $row4=mysqli_fetch_array($result4);
					   $ass_course_id=$row4['assigned_course_id'];
		  			$per=sprintf("%.2f",($row_num1*100)/$row_num);
		 			$query8 = "UPDATE grade_distribution  SET perc_of_grade='$per' WHERE 
					   grade='$grade' AND assigned_course_id='$ass_course_id'";
						$result8 = mysqli_query($connection, $query8);

					}
				}
			}
		}
	}
?>
<div class="table-responsive">
	<table class="table table-striped" border="1px solid black">
		<thead>
			<tr>
		<?php 	$sql9="SELECT * FROM grade";
				if($result9=mysqli_query($connection,$sql9)){
					if(mysqli_num_rows($result9)>0){
						while($row9=mysqli_fetch_array($result9)){
							echo "<td>".$row9['grade']."</td>";
						}
					}
				}
					?>
		</tr>
		<tr>
			<?php 
				$sql10="SELECT a.perc_of_grade FROM grade_distribution a INNER JOIN assigned_course b
				ON a.assigned_course_id=b.id WHERE a.assigned_course_id='$ass_course_id' AND b.id='$id'";
			   if($result10=mysqli_query($connection,$sql10)){
					if(mysqli_num_rows($result10)>0){
						while($row10=mysqli_fetch_array($result10)){
							if(isset($per)){
								if($row10['perc_of_grade']!=NULL){
								$grade['0']='I';
								$per_1=$per."%";
								$per_grade['0']=$per;
								echo "<td>".$row10['perc_of_grade']." %</td>";
								}
								if($row10['perc_of_grade']==NULL){
									echo "<td>0 %</td>";
								}
							}
						}
					}
				}
		
				?>
			<?php
			
			?>
		</tr>
		</thead>
		<tbody>

		</tbody>
		</table>
		</div>
		<br>

<?php
$a=array();
$b=array();
$sql10="SELECT a.perc_of_grade,a.grade FROM grade_distribution a INNER JOIN assigned_course b
ON a.assigned_course_id=b.id WHERE a.assigned_course_id='$id'";
if($result10=mysqli_query($connection,$sql10)){
    if(mysqli_num_rows($result10)>0){
        while($row10=mysqli_fetch_array($result10)){
            $a[]=$row10['perc_of_grade'];
            $b[]=$row10['grade'];
        }
    }
}
?>
		<script type="text/javascript" src="js/jquery.min.js"></script>
    <script type="text/javascript" src="js/Chart.min.js"></script>
    <script>
    
    $(document).ready(function() {
        //alert("wfhwhd");
        var co_per=<?php echo json_encode($a);?>;
        var co=<?php echo json_encode($b);?>;
        var chartdata = {
                labels: co,
                datasets: [{
                    label: 'Percentage of Grade Distribution',
                    backgroundColor: 'rgba(31, 150, 134, 0.75)',
                    borderColor: 'rgba(31, 150, 134, 0.75)',
                    hoverBackgroundColor: 'rgba(16, 185, 232, 1)',
                    hoverBorderColor: 'rgba(16, 165, 150, 1)',
                    data: co_per
                }]
            };

            var ctx = $("#mycanvas");

            var barGraph = new Chart(ctx, {
                type: 'bar',
                data: chartdata,
                options:{
                responsive: true,
                maintainAspectRatio: false
            }
            });
    });
    </script>
   <div id="chart-container" style="width:500px; height:300px; margin-left:20%">
        <canvas id="mycanvas" ></canvas>
    </div>

	
	</div>
</div>
</body>
</html>
<?php 
	
?>