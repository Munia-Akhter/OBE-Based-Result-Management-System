<?php include("db.php");
	session_start();
	$username=$_SESSION['username'];
?>

<!DOCTYPE html>
<html>
<head>
	<title>PO Attainment</title>
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
		</nav>		<div style="width:80%; margin:0px auto ;">
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
// correct part 1 po_according_to_co
$po_per=0;
$sql1="SELECT * FROM po_according_to_co Where course_code='$course_code' AND sec_no='$sec_no' AND semester='$semester' AND
		 year='$year'";
if($result1=mysqli_query($connection,$sql1)){
	if(mysqli_num_rows($result1)>=0){
		if(mysqli_num_rows($result1)==0){
    $sql2="SELECT a.s_id FROM student_enrollment a INNER JOIN assigned_course b ON a.assigned_course_id=b.id 
	AND a.assigned_course_id='$ass_course_id'";
		if($result2=mysqli_query($connection,$sql2)){
        if(mysqli_num_rows($result2)>0){
            $total_st_1=mysqli_num_rows($result2);
                while($row2=mysqli_fetch_array($result2)){
					$s_id_1=$row2['s_id'];
	                $sql3="SELECT * FROM course_outcome  a INNER JOIN assigned_course b ON
				 	a.assigned_course_id=b.id AND a.assigned_course_id='$ass_course_id' ORDER BY co_code";
                if($result3=mysqli_query($connection,$sql3)){
                    if(mysqli_num_rows($result3)>0){
                        while($row3=mysqli_fetch_array($result3)){
                        $co_code=$row3['co_code'];
                        $sql4="SELECT distinct s_id,co,co_per FROM co_attainment_individual WHERE s_id='$s_id_1' AND course_code='$course_code' AND sec_no='$sec_no' AND semester='$semester' AND year='$year' AND co='$co_code'";
                        if($result4=mysqli_query($connection,$sql4)){
                            if(mysqli_num_rows($result4)>0){
                            while($row4=mysqli_fetch_array($result4)){
                                 $s_id_2=$row4['s_id'];
                                $co1=$row4['co'];
								$co_per=$row4['co_per'];
                                if($s_id_1==$s_id_2){
                                    $sql5 = "SELECT a.mapping_co_code,a.mapping_po_code from mapping a INNER JOIN assigned_course b ON
									a.assigned_course_id=b.id AND a.assigned_course_id='$ass_course_id'"; 
                                    if($result5 = mysqli_query($connection,$sql5)){
                                        if(mysqli_num_rows($result5) > 0){
                                            while($row5=mysqli_fetch_array($result5)){
                                             $po_code=$row5['mapping_po_code'];
                                                $co_code=$row5['mapping_co_code'];
												$k=0;
												if($co_code==$row5['mapping_co_code'] && $po_code==$row5['mapping_po_code']){
													$flag=1;
													$co2=$row5['mapping_co_code'];
												if($co1==$co2){
													$po_per=$co_per*$flag;
													echo "po per : ".$po_per;
													$sql6="INSERT INTO  po_according_to_co (s_id,course_code,sec_no,semester,year,po,co,po_per)
														VALUES('$s_id_1','$course_code','$sec_no','$semester','$year','$po_code','$co2','$po_per')";
														if($result6=mysqli_query($connection,$sql6)){
															echo "successfully inserted in po_according_to_co";
														}
														else
															echo mysqli_error($connection);
														}
													$k++;
												}
												else
													$flag=0;
														
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
}
}
}
else if(mysqli_num_rows($result1)>0){
	while ($row1 = mysqli_fetch_array($result1)) {
		$sql7="SELECT s.s_id,s.assigned_course_id FROM student_enrollment s
				WHERE s.s_id NOT IN (SELECT c.s_id FROM po_according_to_co c WHERE 
				c.course_code='$course_code' AND c.sec_no='$sec_no' AND c.semester='$semester'
				AND c.year='$year')";
		if($result7=mysqli_query($connection,$sql7)){
			if(mysqli_num_rows($result7)>0){
				while ($row7 = mysqli_fetch_array($result7)) {
					$s_id_3=$row7['s_id'];
					$sql8="SELECT * FROM course_outcome  a INNER JOIN assigned_course b ON
							a.assigned_course_id=b.id AND a.assigned_course_id='$ass_course_id' ORDER BY co_code";
					if($result8=mysqli_query($connection,$sql8)){
						if(mysqli_num_rows($result8)>0){
							while($row8=mysqli_fetch_array($result8)){
							$co_code=$row8['co_code'];
							$sql8="SELECT distinct s_id,co,co_per FROM co_attainment_individual WHERE s_id='$s_id_1' AND course_code='$course_code' AND sec_no='$sec_no' AND semester='$semester' AND year='$year' AND co='$co_code'";
							if($result8=mysqli_query($connection,$sql8)){
								if(mysqli_num_rows($result8)>0){
								while($row8=mysqli_fetch_array($result8)){
									$s_id_4=$row8['s_id'];
									$co1=$row8['co'];
									$co_per=$row8['co_per'];
									if($s_id_3==$s_id_4){
										$sql9 = "SELECT a.mapping_co_code,a.mapping_po_code from mapping a INNER JOIN assigned_course b ON
										a.assigned_course_id=b.id AND a.assigned_course_id='$ass_course_id'"; 
										if($result9 = mysqli_query($connection,$sql9)){
											if(mysqli_num_rows($result9) > 0){
												while($row9=mysqli_fetch_array($result9)){
													$po_code=$row9['mapping_po_code'];
													$co_code=$row9['mapping_co_code'];
													$k=0;
													if($co_code==$row9['mapping_co_code'] && $po_code==$row9['mapping_po_code']){
														$flag=1;
														$co2=$row9['mapping_co_code'];
													if($co1==$co2){
														$po_per=$co_per*$flag;
														echo "po per : ".$po_per;
														$sql10="INSERT INTO  po_according_to_co (s_id,course_code,sec_no,semester,year,po,co,po_per)
															VALUES('$s_id_3','$course_code','$sec_no','$semester','$year','$po_code','$co2','$po_per')";
															if($result10=mysqli_query($connection,$sql10)){
																echo "successfully inserted in po_according_to_co";
															}
															else
																echo mysqli_error($connection);
															}
														$k++;
													}
													else
														$flag=0;
															
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
}
}
// correct part 2 po_attainment_individual insertion
$sql11="SELECT * FROM po_attainment_individual WHERE course_code='$course_code' AND sec_no='$sec_no' AND semester='$semester' AND year='$year'";
if($result11=mysqli_query($connection,$sql11)){
	if(mysqli_num_rows($result11)>=0){
		if(mysqli_num_rows($result11)==0){
			$sql12="SELECT a.s_id FROM student_enrollment a INNER JOIN assigned_course b ON a.assigned_course_id=b.id"; 
			if($result12=mysqli_query($connection,$sql12)){
		       	if(mysqli_num_rows($result12)>0){
                	while ($row12 = mysqli_fetch_array($result12)) {
                        $s_id_5=$row12['s_id'];
                        $sql12="SELECT distinct a.mapping_po_code FROM mapping a INNER JOIN assigned_course b ON
						   		a.assigned_course_id=b.id AND a.assigned_course_id='$ass_course_id'";
                        if($result12=mysqli_query($connection,$sql12)){
		       		    	if(mysqli_num_rows($result12)>0){
		       			        while ($row12 = mysqli_fetch_array($result12)){
                                    $po=$row12['mapping_po_code'];
									$sql14 = "INSERT INTO po_attainment_individual
								(s_id,course_code,sec_no,semester,year,po) VALUES('$s_id_5','$course_code','$sec_no','$semester','$year','$po')";
                                $result14=mysqli_query($connection,$sql14);
                               		//echo "successfully inserted in po_attainment_individual";
									}
                            	}
                        	}	              
               		 	}
                    }
				}
			}
		    else if(mysqli_num_rows($result11)>0){
				while ($row11 = mysqli_fetch_array($result11)) {
					$sql15="SELECT s.s_id,s.assigned_course_id FROM student_enrollment s
							WHERE s.s_id NOT IN (SELECT c.s_id FROM po_attainment_individual c WHERE 
							c.course_code='$course_code' AND c.sec_no='$sec_no' AND c.semester='$semester'
							AND c.year='$year')";
					if($result15=mysqli_query($connection,$sql15)){
						if(mysqli_num_rows($result15)>0){
							while ($row15 = mysqli_fetch_array($result15)) {
								$s_id_6=$row15['s_id'];
								$sql16="SELECT distinct a.mapping_po_code FROM mapping a INNER JOIN assigned_course b ON
						   		a.assigned_course_id=b.id AND a.assigned_course_id='$ass_course_id'";
								if($result16=mysqli_query($connection,$sql16)){
									if(mysqli_num_rows($result16)>0){
										while ($row16 = mysqli_fetch_array($result16)){
											$po=$row16['mapping_po_code'];
											$sql17 = "INSERT INTO po_attainment_individual
										(s_id,course_code,sec_no,semester,year,po) VALUES('$s_id_6','$course_code','$sec_no','$semester','$year','$po')";
										$result17=mysqli_query($connection,$sql17);
											//echo "successfully inserted in po_attainment_individual in other section";
											}
										}
									}
								}
    						}
						}  
					}  
// correct part 2 po_attainment_individual update
$po_per_sum=0;
$i=1;
$co_array=array();
$sql19="SELECT * FROM course_outcome a INNER JOIN assigned_course b ON
  		a.assigned_course_id=b.id AND a.assigned_course_id='$ass_course_id' ORDER BY co_code";
if($result19=mysqli_query($connection,$sql19)){
    if(mysqli_num_rows($result19)>0){
        while($row19=mysqli_fetch_array($result19)){
			$co_code=$row19['co_code'];
			$total_co=mysqli_num_rows($result19);	
			$sql20="SELECT distinct s_id FROM co_attainment_individual WHERE course_code='$course_code'
			 AND sec_no='$sec_no' AND semester='$semester' AND year='$year' AND co='$co_code'";
			if($result20=mysqli_query($connection,$sql20)){
				if(mysqli_num_rows($result20)>0){
					while($row20=mysqli_fetch_array($result20)){
						$s_id_7=$row20['s_id'];
						$sql21="SELECT a.mapping_po_code FROM mapping a INNER JOIN assigned_course b ON
								a.assigned_course_id=b.id AND a.assigned_course_id='$ass_course_id'";
						if($result21=mysqli_query($connection,$sql21)){
							if(mysqli_num_rows($result21)>0){
								while($row21=mysqli_fetch_array($result21)){
									$po2=$row21['mapping_po_code'];
									$sql22="SELECT s_id,co,po,po_per,count(s_id) as 
											total_st FROM po_according_to_co WHERE s_id='$s_id_7' AND 
											course_code='$course_code' AND sec_no='$sec_no' AND 
											semester='$semester' AND year='$year' AND po='$po2'";
									if($result22=mysqli_query($connection,$sql22)){
										if(mysqli_num_rows($result22)>0){
											while($row22=mysqli_fetch_array($result22)){
												$total_st_2=$row22['total_st'];
												
												if($total_st_2!=0){
												$po_per_sum=sprintf("%.2f",$row22['po_per']/$total_st_2);  
												}
												
												$sql23 ="UPDATE po_attainment_individual SET po_per='$po_per_sum' WHERE s_id='$s_id_7' AND course_code='$course_code' AND sec_no='$sec_no' AND semester='$semester' AND year='$year' AND po='$po2'";
												if($result23=mysqli_query($connection,$sql23)){
												
												}
												else
													echo mysqli_error($connection); 
												$po_per_sum=0;
												$i++;	
											
												}
											}
										} 
									}
								}
							}
						}
					}
				} 
				// foreach ($co_array as $key => $val) {
				// 	echo "$key => $val, \n";
				// }
		
			//	echo "gor ";
			//	var_dump ($co_array);
			//	echo "<br>";
							  //UPDATE po_attainment_individual 
			}
		}
	}
}
}
}
$sql13="SELECT * FROM po_attainment Where course_code='$course_code' AND sec_no='$sec_no' AND semester='$semester' AND year='$year'";
if($result13=mysqli_query($connection,$sql13)){
	if(mysqli_num_rows($result13)>=0){
		if(mysqli_num_rows($result13)==0){
			$sql14="SELECT distinct a.mapping_po_code FROM mapping a INNER JOIN assigned_course b ON
			a.assigned_course_id=b.id AND a.assigned_course_id='$ass_course_id' ORDER BY mapping_co_code";         
			if($result14=mysqli_query($connection,$sql14)){
				if(mysqli_num_rows($result14)>0){
					while($row14=mysqli_fetch_array($result14)){
						$po3=$row14['mapping_po_code'];
						$sql15="SELECT sum(po_per) FROM po_attainment_individual WHERE course_code='$course_code' AND 
						sec_no='$sec_no' AND semester='$semester' AND year='$year' AND po='$po3'";
						if($result15=mysqli_query($connection,$sql15)){
							if(mysqli_num_rows($result15)>0){
								while($row15=mysqli_fetch_array($result15)){
									$po_per_1=$row15['sum(po_per)'];
									if(isset($total_st)){
									$po_per_2=$po_per_1/$total_st;
		
									$sql16="INSERT INTO po_attainment (course_code,sec_no,semester,year,po,po_per) VALUES('$course_code','$sec_no','$semester','$year','$po3','$po_per_2')";
									if($result16=mysqli_query($connection,$sql16)){
										echo "insert";
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
$po_per_sum=0;

$sql6="SELECT * FROM course_outcome a INNER JOIN assigned_course b ON
a.assigned_course_id=b.id AND a.assigned_course_id='$ass_course_id' ORDER BY co_code";
			  if($result6=mysqli_query($connection,$sql6)){
				  if(mysqli_num_rows($result6)>0){
					  while($row6=mysqli_fetch_array($result6)){
					  $co_code=$row6['co_code'];
  $sql10="SELECT a.mapping_po_code FROM mapping a INNER JOIN assigned_course b ON
  a.assigned_course_id=b.id AND a.assigned_course_id='$ass_course_id'";
  if($result10=mysqli_query($connection,$sql10)){
	  if(mysqli_num_rows($result10)>0){
		  while($row10=mysqli_fetch_array($result10)){
			  $po2=$row10['mapping_po_code'];
			  $sql11="SELECT po,sum(po_per) as po_per,count(*) as total_st FROM po_attainment_individual 
			  		WHERE course_code='$course_code' AND sec_no='$sec_no' AND semester='$semester' AND year='$year' AND po='$po2'";
			  if($result11=mysqli_query($connection,$sql11)){
				  if(mysqli_num_rows($result11)>0){
					  while($row11=mysqli_fetch_array($result11)){
						$total_st=$row11['total_st'];
						  if($total_st>0){
						  $po_per_sum=sprintf("%.2f",$row11['po_per']/$total_st);  
						  }
						 $sql12 ="UPDATE po_attainment SET po_per='$po_per_sum' WHERE course_code='$course_code' AND sec_no='$sec_no' AND semester='$semester' AND year='$year' AND po='$po2'";
								  if($result12=mysqli_query($connection,$sql12)){
									  //echo "updated";
								  }
								  else
									  echo mysqli_error($connection); 
									  $po_per_sum=0;
							  }
						  }
					  } 
				  }
			  }
		  }
	  }
  }
} 				  //UPDATE po_attainment

?>
<?php 
		$sql14="SELECT * FROM  mapping a INNER JOIN assigned_course b ON
		a.assigned_course_id=b.id AND a.assigned_course_id='$ass_course_id'";
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
						<th colspan='<?php echo $col;?>'>PO Attainment</th>
						</tr>
					</thead>
					<tbody>
						<tr>
						<?php
						$sql14="SELECT distinct a.mapping_po_code FROM  mapping a INNER JOIN assigned_course b ON
						a.assigned_course_id=b.id AND a.assigned_course_id='$ass_course_id'";
						if($result14=mysqli_query($connection,$sql14)){
							if(mysqli_num_rows($result14)>0){
								while($row14=mysqli_fetch_array($result14)){
									echo "<td>".$row14['mapping_po_code']."</td>";
								}
							}
						}
						echo "</tr>";
						echo "<tr>";
						if($result14=mysqli_query($connection,$sql14)){
							if(mysqli_num_rows($result14)>0){
								while($row14=mysqli_fetch_array($result14)){
									//echo "<td>".$row14['co_code']."</td>";
								}
							}
						}
						echo "</tr>";
						$sql15="SELECT a.co_threshold FROM  course_outcome a INNER JOIN assigned_course b ON
						a.assigned_course_id=b.id AND a.assigned_course_id='$ass_course_id' AND co_code='CO1' ORDER BY co_code";
						if($result15=mysqli_query($connection,$sql15)){
							if(mysqli_num_rows($result15)>0){
								$row15=mysqli_fetch_array($result15);
								$tr=$row15['co_threshold'];	
							}
						}
						echo "<tr>";
						$sql16="SELECT * FROM  po_attainment WHERE course_code='$course_code' AND 
						sec_no='$sec_no' AND semester='$semester' AND year='$year'";
						if($result16=mysqli_query($connection,$sql16)){
							if(mysqli_num_rows($result16)>0){
								
								while($row16=mysqli_fetch_array($result16)){
									if($row16['po_per']>=$tr){
									
										echo "<td>".$row16['po_per']."%</td>";
										
										}
									else{
										echo "<td>".$row16['po_per']."%</td>";
										
									}
								}
							}
						}
						echo "</tr>";
					?>
					</tbody>
				</table>
				<div>
		</div>
		
<?php
$a=array();
$b=array();
$sql10="SELECT c.po_per ,c.po
FROM course a INNER JOIN assigned_course b ON a.course_code = b.course_code INNER JOIN po_attainment c ON b.course_code=c.course_code AND b.sec_no and c.sec_no and b.semester=c.semester and b.year=c.year WHERE 
b.username='$username' AND b.id='$id'";
if($result10=mysqli_query($connection,$sql10)){
    if(mysqli_num_rows($result10)>0){
        while($row10=mysqli_fetch_array($result10)){
            $a[]=$row10['po_per'];
            $b[]=$row10['po'];
        }
    }
}
?>
	<script type="text/javascript" src="js/jquery.min.js"></script>
    <script type="text/javascript" src="js/Chart.min.js"></script>
    <script>
    
    $(document).ready(function() {
        //alert("wfhwhd");
        var po_per=<?php echo json_encode($a);?>;
        var po=<?php echo json_encode($b);?>;
        var chartdata = {
                labels: po,
                datasets: [{
                    label: 'Percentage of Attained PO',
                    backgroundColor: 'rgba(31, 150, 134, 0.75)',
                    borderColor: 'rgba(31, 150, 134, 0.75)',
                    hoverBackgroundColor: 'rgba(16, 185, 232, 1)',
                    hoverBorderColor: 'rgba(16, 165, 150, 1)',
                    data: po_per
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