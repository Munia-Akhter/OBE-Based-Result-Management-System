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
                    $title=$row["title"];
                    $credit=$row["credit"];
					
					
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
?>
					<div style="width:80%; margin:0px auto ;">
						<h4 style="margin-bottom: 30px;">
							<b>Assign Student's marks</b>
						</h4>
						<div class="table-responsive">
							<form method="POST">

								<table class="table table-striped" border="1px solid black">
									<thead>
										<tr>
											<th colspan='2'>Selected Components</th>
										</tr>
									</thead>
									<tbody>
										<tr>
											<td>
												<select name="select_component">
													<?php	
        						$sql =  "SELECT  component FROM marks_component where assigned_course_id='$ass_course_id'";
                    			$select =mysqli_query($connection,$sql);

                             	if(mysqli_num_rows($select) > 0) {
                        			while ($row = mysqli_fetch_array($select)) {  
                        			
                 			?>

														<option value="<?php echo $row['component']?>">
															<?php echo $row['component'];?>
														</option>
														<?php
                        		}
                    		}
							?>
												</select>
											</td>
											<td>
												<button name="add_1" class="btn btn btn-danger btn-md">Select</button>
											</td>

										</tr>

									</tbody>
								</table>
							</form>
						</div>
						<br>
					</div>
			</div>
</body>

</html>
<?php

if(isset($_POST['add_1'])){
	$select_component=$_POST['select_component'];
	$_SESSION['select_component']=$select_component;
	$id = $_GET["value"];
	 $sql = "SELECT component,marks from result_processing where assigned_course_id='$ass_course_id'"; 
	if($result = mysqli_query($connection,$sql)){
		if(mysqli_num_rows($result) > 0){
			while($row=mysqli_fetch_array($result)){
				//foreach($_POST['check'] as $check) {
					if($row['component']==$select_component){
						echo '<script type="text/javascript">';
						echo 'setTimeout(function () {  swal("You have already Selected Component:('.$select_component.') for this section !!!");';
						echo '},50);</script>';
						exit();
					}
			}
		}
	}


	/*$sql1 = "SELECT a.title,a.credit,c.semester,c.year,c.offered_course_code,c.sec_no,c.username FROM course a JOIN offer_course b ON a.course_code = b.offered_course_code JOIN assign_course c ON b.offered_course_code = c.offered_course_code WHERE c.id='$id' AND c.username='$username'";
	if($result1=mysqli_query($connection,$sql1)){
		if(mysqli_num_rows($result1)>0){
			   $row=mysqli_fetch_array($result1);
			   $course_code = $row["offered_course_code"];
			$sec_no = $row["sec_no"];
			$title = $row["title"];
			$credit = $row["credit"];
			$semester = $row["semester"];
			$year = $row["year"];
			$username=$row['username'];

		}
	}*/
	
	$sql2="SELECT s_id,name FROM student_enrollment where assigned_course_id='$ass_course_id' AND grade IS NULL";
		if($result2=mysqli_query($connection,$sql2)){
			if(mysqli_num_rows($result2)>0){
				$row_num=mysqli_num_rows($result2);
				while ($row = mysqli_fetch_array($result2)){
					$s_id=$row['s_id'];
					$name=$row['name'];
				}
			}
		}
		echo "<form method='POST'>";
		echo "<table class='table_1'border='1'>";
		echo "<tr>";
		if(isset($course_code))
			echo "<th>"."Course Code</th>"."<th>".$course_code."</th>";
		if(isset($sec_no))
			echo "<th>Section ".$sec_no."</th>";
		$sql3="SELECT * FROM marks_component WHERE assigned_course_id='$ass_course_id' AND component='$select_component'";
		if($result3=mysqli_query($connection,$sql3)){
			if(mysqli_num_rows($result3)>0){
				while ($row3 = mysqli_fetch_array($result3)){
					echo "<th rowspan='2' colspan='3'>".$row3['component']."</th><td rowspan='2'>".$row3['cc_marks']."</td>";
						//echo "<td rowspan='4'>Obtained</td>";
				}
			}
		}

		echo "</tr>";
		echo "<tr>";
			
		if(isset($title))
			echo "<th>Course Title</th>"."<th colspan='2'>".$title."</th>";
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
						AND b.component =  '$select_component'";
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
		if($result4=mysqli_query($connection,$sql4))
			$row_num=mysqli_num_rows($result4);
		echo "</tr>";
		echo "<tr>";
		echo "<th>SL</th>"."<th>"."Student ID"."</th>";
		echo "<th>Name</th>";
if($result3=mysqli_query($connection,$sql3)){
	if(mysqli_num_rows($result3)>0){
		while ($row3 = mysqli_fetch_array($result3)){
		   $component=$row3['component']; 
		   $sql5="SELECT a.co_marks, a.course_outcome_id,b.component,a.marks_component_id
						FROM marks_distribution a, marks_component b
						WHERE a.assigned_course_id = b.assigned_course_id
						AND b.id = a.marks_component_id
						AND a.assigned_course_id =  '$ass_course_id'
						AND b.component =  '$select_component'";
			if($result5=mysqli_query($connection,$sql5)){
				if(mysqli_num_rows($result5)>0){
					while ($row5 = mysqli_fetch_array($result5)){
						$co_for_component=$row5['course_outcome_id'];	
						
							echo "<td>".$row5['co_marks']."</td>";
						
					
				}
			}
		}
		}
	}
}
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
			//echo "</tr>";
			

			$sql6="SELECT co_code
			 FROM course_outcome WHERE assigned_course_id='$ass_course_id'  ";
			if($result6=mysqli_query($connection,$sql6)){
				if(mysqli_num_rows($result6)>0){
					$row6 = mysqli_fetch_array($result6);
						$row_num=mysqli_num_rows($result6);
							for ($row=0; $row < $row_num; $row++) { 
								echo "<td><input type='text' name='co_marks[]' value='0' size='1'></td>";
								}
						echo "</tr>";
						$i++;
					}
				}
			}
		}
	}
		echo "<tr><td></td><td></td>";
		echo "<td><input type='submit' name='add_2' value='save'></td></tr>";
		echo "</table>";
		echo "</form>";
		
}


if(isset($_POST['add_2'])){
	$id = $_GET["value"];
	$username1 = $username;
	//$flag='a';
	$select_component=$_SESSION['select_component'];
	$co_marks1=$_POST['co_marks'];
	$co_marks1_sum=array_sum($co_marks1);
	$co_marks2=serialize($co_marks1);
	//$_SESSION['array_name'] = $co_marks1;
	//$co_marks=0;

	//print_r($co_marks1);
	$co_marks=array();

	$co_marks[]=$co_marks1;
 $sql3="SELECT id
			 FROM course_outcome WHERE assigned_course_id='$ass_course_id' ORDER BY co_code";
		if($result3=mysqli_query($connection,$sql3)){
			if(mysqli_num_rows($result3)>0){
			$row_num2=mysqli_num_rows($result3);
			while($row3=mysqli_fetch_array($result3)){
			$co=$row3['id'];
			$sql1="SELECT a.co_marks, a.course_outcome_id, b.component, b.id
FROM marks_distribution a, marks_component b
WHERE a.assigned_course_id = b.assigned_course_id
AND b.id = a.marks_component_id
AND a.assigned_course_id =  '$ass_course_id'
AND a.course_outcome_id =  '$co'
AND b.component =  '$select_component'";
			if($result1=mysqli_query($connection,$sql1)){
				while($row1 = mysqli_fetch_array($result1)){
					if($row1['component']==$select_component && $row1['course_outcome_id']==$co){
						foreach ($co_marks as $co_marks1) {
						for($i=0; $i<count($co_marks1);$i++){
						//for($j=1; $j<=$row_num2;$j++){
				if($co_marks1[$i]>$row1['co_marks'] && $co_marks1[$i]!='W'){
						echo '<script type="text/javascript">';
						echo 'alert("Input Marks '.$co_marks1[$i].' for component: '.$row1['component'].' is greater than acutal value: '.$row1['co_marks'].'");</script>';
						exit();
						echo '},600);</script>';
					
					}
					if($co_marks1[$i]<0 ){
						echo '<script type="text/javascript">';
						echo 'alert("Input Marks '.$co_marks1[$i].' for component: '.$row1['component'].' is negative!!!!");</script>';
						exit();
						echo '},600);</script>';
					}
					if($co_marks1_sum==0){
						echo '<script type="text/javascript">';
						echo 'alert("You have not set the marks");</script>';
						exit();
						echo '},600);</script>';
					}
					
					//if($co_marks1[$i]<=$row1['co_marks']){echo $co_marks1[$i];
					//	header('Location:result_processing.php?value1='.$id.'&value2='.$select_component.'&value4='.$username1.'&value3='.$co_marks2);
					//}
					
			  }$i++;
				}
				
			}}}
			header('Location:result_processing.php?value1='.$id.'&value2='.$select_component.'&value4='.$username1.'&value3='.$co_marks2);
		}}}
		}
		
				

				?>