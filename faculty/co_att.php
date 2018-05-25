<?php include("db.php");
	session_start();
$username=$_SESSION['username'];
$id=$_GET['value'];
?>

<!DOCTYPE html>
<html>
<head>
	<title>CO Attainment</title>
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
$i=1;               
$sql3="SELECT * FROM co_attainment_individual";
if($result3=mysqli_query($connection,$sql3)){
	if(mysqli_num_rows($result3)>=0){
		if(mysqli_num_rows($result3)==0){
			$sql="SELECT a.s_id FROM student_enrollment a INNER JOIN assigned_course b ON a.assigned_course_id=b.id 
			AND a.assigned_course_id='$ass_course_id'";
		        if($result=mysqli_query($connection,$sql)){
		       		if(mysqli_num_rows($result)>0){
                        while ($row = mysqli_fetch_array($result)) {
						   $s_id=$row['s_id'];
							$sql1="SELECT * FROM course_outcome  a INNER JOIN assigned_course b ON a.assigned_course_id=b.id AND a.assigned_course_id='$ass_course_id'";
							if($result1=mysqli_query($connection,$sql1)){
		       		            if(mysqli_num_rows($result1)>0){
		       			            while ($row1 = mysqli_fetch_array($result1)){
										$co=$row1['co_code'];
										$sql4 = "INSERT INTO co_attainment_individual
								(s_id,course_code,sec_no,semester,year,co) VALUES('$s_id','$course_code','$sec_no','$semester','$year','$co')";
                                $ins4=mysqli_query($connection,$sql4);
									}
                            	}
                        	}	              
               		 	}
                    }
				}
		    }
			else if(mysqli_num_rows($result3)>0){
				while ($row3 = mysqli_fetch_array($result3)) {
				  	$sql="SELECT s.s_id,s.assigned_course_id FROM student_enrollment s
						WHERE s.s_id NOT IN (SELECT c.s_id FROM co_attainment_individual c WHERE 
						c.course_code='$course_code' AND c.sec_no='$sec_no' AND c.semester='$semester'
						 AND c.year='$year')";
		        if($result=mysqli_query($connection,$sql)){
		       		if(mysqli_num_rows($result)>0){
                        while ($row = mysqli_fetch_array($result)) {
							   $s_id=$row['s_id'];
							$sql1="SELECT * FROM course_outcome  a INNER JOIN assigned_course b ON a.assigned_course_id=b.id AND a.assigned_course_id='$ass_course_id'";
							if($result1=mysqli_query($connection,$sql1)){
		       		            if(mysqli_num_rows($result1)>0){
		       			            while ($row1 = mysqli_fetch_array($result1)){ 
		       			            	if( $s_id!=$row3['s_id'] && $ass_course_id=$row['assigned_course_id']){
                                        $co=$row1['co_code'];
										$sql4 = "INSERT INTO co_attainment_individual (s_id,course_code,sec_no,semester,year,co) 
												VALUES('$s_id','$course_code','$sec_no','$semester','$year','$co')";
                                		$ins4=mysqli_query($connection,$sql4);
										}
                            		}
                       	 		}              
                			}
                    	}
						
					}
				}
			}
		}

$co_marks=0;
$sql5="SELECT * FROM student_enrollment a INNER JOIN assigned_course b ON a.assigned_course_id=b.id
	AND a.assigned_course_id='$ass_course_id'";
if($result5=mysqli_query($connection,$sql5)){
	if(mysqli_num_rows($result5)>0){
		$total_st=mysqli_num_rows($result5);
			while($row5=mysqli_fetch_array($result5)){
				$s_id=$row5['s_id'];
			$sql6="SELECT * FROM course_outcome  a INNER JOIN assigned_course b ON a.assigned_course_id=b.id
			AND a.assigned_course_id='$ass_course_id'";
			if($result6=mysqli_query($connection,$sql6)){
				if(mysqli_num_rows($result6)>0){
					while($row6=mysqli_fetch_array($result6)){
						$co_code=$row6['co_code'];
					$co_marks_defined=$row6['co_marks'];
					$sql7="SELECT sum(total_marks_co),co,s_id FROM percent_of_co WHERE s_id='$s_id' AND course_code='$course_code' AND sec_no='$sec_no' AND semester='$semester' AND year='$year' AND co='$co_code'";
					if($result7=mysqli_query($connection,$sql7)){
						if(mysqli_num_rows($result7)>0){
						while($row7=mysqli_fetch_array($result7)){
							$s_id2=$row7['s_id'];
							if($s_id==$s_id2){
								$co_sum=$row7['sum(total_marks_co)'];
								$co_marks=$row7['sum(total_marks_co)'];
								$co_per=sprintf("%.2f",($row7['sum(total_marks_co)']/$co_marks_defined)*100);
								$sql8 ="UPDATE co_attainment_individual SET co_per='$co_per',co_sum='$co_sum' WHERE s_id='$s_id2' AND course_code='$course_code' AND sec_no='$sec_no' AND semester='$semester' AND year='$year' AND co='$co_code'";
									$result8=mysqli_query($connection,$sql8);
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
}
$co_per=0;
$sql9="SELECT * FROM co_attainment";
if($result9=mysqli_query($connection,$sql9)){
	if(mysqli_num_rows($result9)>=0){
		if(mysqli_num_rows($result9)==0){
			$sql10="SELECT * FROM course_outcome  a INNER JOIN assigned_course b ON a.assigned_course_id=b.id
			AND a.assigned_course_id='$ass_course_id'";
			if($result10=mysqli_query($connection,$sql10)){
				if(mysqli_num_rows($result10)>0){
					while($row10=mysqli_fetch_array($result10)){
						$co=$row10['co_code'];
						$sql11="SELECT sum(co_per) FROM co_attainment_individual WHERE course_code='$course_code' AND 
						sec_no='$sec_no' AND semester='$semester' AND year='$year' AND co='$co'";
						if($result11=mysqli_query($connection,$sql11)){
							if(mysqli_num_rows($result11)>0){
								while($row11=mysqli_fetch_array($result11)){
									$co_per_1=$row11['sum(co_per)'];
									$co_per_2=$co_per_1/$total_st;
									$sql13="INSERT INTO co_attainment (course_code,sec_no,semester,year,co,co_per) VALUES('$course_code','$sec_no','$semester','$year','$co','$co_per_2')";
									if($result13=mysqli_query($connection,$sql13)){
										//echo "insert";
									}
									else echo mysqli_error($connection);
									}
								}
							}
						}
					}
				}
		}
		if(mysqli_num_rows($result9)>0){
			while($row9=mysqli_fetch_array($result9)){
				$sql12="SELECT c1.assigned_course_id FROM course_outcome c1
				WHERE c1.course_code NOT IN (SELECT c2.course_code FROM co_attainment c2 WHERE 
				c2.course_code='$course_code' AND c2.sec_no='$sec_no' AND c2.semester='$semester'
				 AND c2.year='$year')";
			if($result12=mysqli_query($connection,$sql12)){
				if(mysqli_num_rows($result12)>0){
					while ($row12 = mysqli_fetch_array($result12)){
						$course_code=$row12['course_code'];
						$sql10="SELECT * FROM course_outcome  a INNER JOIN assigned_course b ON a.assigned_course_id=b.id
						AND a.assigned_course_id='$ass_course_id'";
						if($result10=mysqli_query($connection,$sql10)){
							if(mysqli_num_rows($result10)>0){
								while($row10=mysqli_fetch_array($result10)){
									$co=$row10['co_code'];
									$sql11="SELECT sum(co_per) FROM co_attainment_individual WHERE course_code='$course_code' AND 
									sec_no='$sec_no' AND semester='$semester' AND year='$year' AND co='$co'";
									if($result11=mysqli_query($connection,$sql11)){
										if(mysqli_num_rows($result11)>0){
											while($row11=mysqli_fetch_array($result11)){
												$co_per_1=$row11['sum(co_per)'];
												$co_per_2=$co_per_1/$total_st;
												if( $course_code!=$row9['course_code'] && $ass_course_id=$row['assigned_course_id']){
													$sql13="INSERT INTO co_attainment (course_code,sec_no,semester,year,co,co_per)
													 VALUES($course_code','$sec_no','$semester','$year','$co','$co_per_2')";
													$result13=mysqli_query($connection,$sql13);
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
	}
}

$co_marks=0;

$sql20="SELECT * FROM student_enrollment a INNER JOIN assigned_course b ON a.assigned_course_id=b.id
	AND a.assigned_course_id='$ass_course_id'";
if($result20=mysqli_query($connection,$sql20)){
	if(mysqli_num_rows($result20)>0){
		$total_st=mysqli_num_rows($result20);
			while($row20=mysqli_fetch_array($result20)){
				$s_id=$row20['s_id'];
		$sql17="SELECT * FROM course_outcome  a INNER JOIN assigned_course b ON a.assigned_course_id=b.id
			AND a.assigned_course_id='$ass_course_id'";
			if($result17=mysqli_query($connection,$sql17)){
				if(mysqli_num_rows($result6)>0){
					while($row17=mysqli_fetch_array($result17)){
						$co_code=$row17['co_code'];
					$co_marks_defined=$row17['co_marks'];
					$sql18="SELECT sum(co_per),co FROM co_attainment_individual WHERE course_code='$course_code'
							 AND sec_no='$sec_no' AND semester='$semester' AND year='$year' AND co='$co_code'";
					if($result18=mysqli_query($connection,$sql18)){
						if(mysqli_num_rows($result18)>0){
						while($row18=mysqli_fetch_array($result18)){
								$co_sum=$row18['sum(co_per)'];
								$co_marks=$row18['sum(co_per)'];
								$co_per=sprintf("%.2f",($row18['sum(co_per)']/($total_st)));
								$sql19 ="UPDATE co_attainment SET co_per='$co_per' WHERE 
										course_code='$course_code' AND sec_no='$sec_no' AND 
										semester='$semester' AND year='$year' AND co='$co_code'";
								$result19=mysqli_query($connection,$sql19);
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
?>
<?php 
		$sql14="SELECT * FROM course_outcome  a INNER JOIN assigned_course b ON a.assigned_course_id=b.id 
		AND a.assigned_course_id='$ass_course_id' ORDER BY co_code";
		if($result14=mysqli_query($connection,$sql14)){
			$x=mysqli_num_rows($result14);
			$col=$x;
			}
?>
<div style="width:80%; margin:0px auto ;">
			<form action=""></form>
			<div class="table-responsive">
				<table class="table table-striped" border="1px solid black">
					<thead>
						<tr>
						<th colspan='<?php echo $col;?>'>CO Attainment</th>
						</tr>
					</thead>
					<tbody>
						<tr>
						<?php
						$sql14="SELECT a.co_code,a.co_marks FROM course_outcome  a INNER JOIN assigned_course b ON a.assigned_course_id=b.id 
						AND b.id='$id' ORDER BY co_code";
						if($result14=mysqli_query($connection,$sql14)){
							if(mysqli_num_rows($result14)>0){
								while($row14=mysqli_fetch_array($result14)){
									echo "<td>".$row14['co_code']."</td>";
								}
							}
						}
						echo "</tr>";
						echo "<tr>";
						if($result14=mysqli_query($connection,$sql14)){
							if(mysqli_num_rows($result14)>0){
								while($row14=mysqli_fetch_array($result14)){
									echo "<td>".$row14['co_marks']."</td>";
								}
							}
						}
						echo "</tr>";
						$sql15="SELECT a.co_threshold FROM course_outcome  a INNER JOIN assigned_course b ON a.assigned_course_id=b.id AND co_code='CO1' ORDER BY co_code";
						if($result15=mysqli_query($connection,$sql15)){
							if(mysqli_num_rows($result15)>0){
								$row15=mysqli_fetch_array($result15);
								$tr=$row15['co_threshold'];	
							}
						}
						echo "<tr>";
						$sql16="SELECT * FROM  co_attainment WHERE course_code='$course_code' AND 
						sec_no='$sec_no' AND semester='$semester' AND year='$year' ORDER BY co";
						if($result16=mysqli_query($connection,$sql16)){
							if(mysqli_num_rows($result16)>0){
								while($row16=mysqli_fetch_array($result16)){
									if($row16['co_per']>=70){
										echo "<td>".$row16['co_per']."%</td>";
										
										}
									else{
										echo "<td>".$row16['co_per']."%</td>";
										
									}
								}
							}
						}
						echo "</tr>";
						?>
					</tbody>
				</table>
			</div>
			<br>	

<?php
$a=array();
$b=array();
$sql10="SELECT c.co_per ,c.co
FROM course a INNER JOIN assigned_course b ON a.course_code = b.course_code INNER JOIN co_attainment c ON b.course_code=c.course_code AND b.sec_no and c.sec_no and b.semester=c.semester and b.year=c.year WHERE 
b.username='$username' AND b.id='$id'";
if($result10=mysqli_query($connection,$sql10)){
    if(mysqli_num_rows($result10)>0){
        while($row10=mysqli_fetch_array($result10)){
            $a[]=$row10['co_per'];
            $b[]=$row10['co'];
        }
    }
}
?>
		</div>
	</div>
	</table>
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
                    label: 'Percentage of Attained CO',
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
