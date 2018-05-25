<?php include("db.php");

	$current_month = date("m");
	$current_year = date("Y"); 
	$flag = 0;
	
	if($current_month==1||$current_month==2||$current_month==3||$current_month==4){
		$s='Spring';
		$y=$current_year;
		$sql1 = "SELECT a.course_code as course_code,b.tot_sec as total_section 
				FROM course a INNER JOIN offered_course b INNER JOIN semester c WHERE 
			 	c.semester='$s' AND a.course_id=b.course_id AND b.semester_id=c.semester_id  AND b.year='$y'";
		$flag = 1; 
	}	
	if($current_month==5||$current_month==6||$current_month==7||$current_month==8){
		$s='Summer';
		$y=$current_year;
		$sql2 ="SELECT a.course_code as course_code,b.tot_sec as total_section 
		FROM course a INNER JOIN offered_course b INNER JOIN semester c WHERE 
		 c.semester='$s' AND a.course_id=b.course_id AND b.semester_id=c.semester_id  AND b.year='$y'";
		$flag = 2; 
	}
	if($current_month==9||$current_month==10||$current_month==11||$current_month==12){
		$s='Fall';
		$y=$current_year;
		$sql3 = "SELECT a.course_code as course_code,b.tot_sec as total_section 
		FROM course a INNER JOIN offered_course b INNER JOIN semester c WHERE 
		 c.semester='$s' AND a.course_id=b.course_id AND b.semester_id=c.semester_id  AND b.year='$y'";
		$flag = 3; 
	}	
	if(($flag==1 && ($result=mysqli_query($connection,$sql1)))||
		($flag==2 && ($result=mysqli_query($connection,$sql2)))||
		($flag==3 && ($result=mysqli_query($connection,$sql3)))){
		if(mysqli_num_rows($result)>0){
			$total=mysqli_num_rows($result);
		
			$semseter=$s;
			$year=$y;
		}
	}


	if(isset($_POST['insert_row'])){
		$offered_course_code=mysqli_real_escape_string($connection, $_POST['offered_course_code']);  
		$section=mysqli_real_escape_string($connection, $_POST['sec_no']); 
		$semester=$s;
		$year=$y;
		$errors=array();
		if($offered_course_code=="" && $section ==""){
			$errors['off_course']="Please enter offer course code and Section";
			echo '<script type="text/javascript">'; 
            echo 'setTimeout(function () {  swal("'.$errors['off_course'].'");';
			echo '},300);</script>';
		}
		
		else if($offered_course_code==""){
			$errors['off_course2']="Please select offered course code";
			echo '<script type="text/javascript">'; 
            echo 'setTimeout(function () {  swal("'.$errors['off_course2'].'");';
			echo '},300);</script>';
		} 
		else if ($section==""){
			$errors['sec']="Please enter total section";
			echo '<script type="text/javascript">'; 
            echo 'setTimeout(function () {  swal("'.$errors['sec'].'");';
			echo '},300);</script>';
		} 

		if(count($errors)==0){
			$sql1="SELECT course_id FROM course WHERE course_code='$offered_course_code'";
			if($result1=mysqli_query($connection,$sql1)){
				if(mysqli_num_rows($result1)>0){
					$row1 = mysqli_fetch_array($result1);
					$course_id=$row1['course_id'];
				}
			}
			else echo mysqli_error($connection);				
			$sql7="SELECT semester_id FROM semester WHERE semester='$semester'";
			if($result7=mysqli_query($connection,$sql7)){
				if(mysqli_num_rows($result7)>0){
					$row7 = mysqli_fetch_array($result7);
					$semester_id=$row7['semester_id'];
				}
			}
			if(isset($course_id) && isset($semester_id) ){
			$sql = "SELECT * FROM offered_course WHERE course_id='$course_id' AND semester_id='$semester_id' AND year='$year'";
			if($select =mysqli_query($connection,$sql)){
				while($row=mysqli_fetch_array($select)){
					echo '<script type="text/javascript">'; 
					echo 'setTimeout(function () { 	swal("Course already exist");';
					echo '},100);</script>';
					exit();
				}
			}				
			$sql1 = "INSERT INTO offered_course(course_id,semester_id,year,tot_sec) VALUES('$course_id','$semester_id','$year','$section')";
			if($ins=mysqli_query($connection,$sql1)){
				echo '<script type="text/javascript">'; 
				echo 'setTimeout(function () { 	swal("Course has been offered successfully");';
				echo '},300);</script>';
			}
			
			}
		}
	}

	if(isset($_POST['delete_row'])){ 
		$_POST['delete_row'];
		$sql = "DELETE FROM offered_course WHERE offered_course_id='".$_POST["delete_row"]."'";
		if(mysqli_query($connection,$sql)){
			$ins=mysqli_query($connection,$sql);
			echo '<script type="text/javascript">'; 
			echo 'setTimeout(function () { 	swal("Course has been deleted successfully");';
			echo '},100);</script>';
		}
		else
			echo "<h2>"."ERRORR:Couldn't Delete".mysqli_error($connection)."</h2>";
	} 

?>
<?php
if(isset($_POST['search'])){
		$errors=array();
		function test_input($data){
		$data = trim($data); 
		$data = stripslashes($data); 
		$data = htmlspecialchars($data);  
		return $data;
	}	
		$semester=mysqli_real_escape_string($connection, $_POST['semester']);
		$semester=test_input($semester);
		$year=mysqli_real_escape_string($connection, $_POST['year']);
		$year=test_input($year);
		$dept_name=mysqli_real_escape_string($connection, $_POST['dept_name']);
		$dept_name=test_input($dept_name);
		if(empty($_POST['year'])){
	        $errors['year']="Please enter year";
			echo '<script type="text/javascript">'; 
            echo 'setTimeout(function () {  swal("'.$errors['year'].'");';
			echo '},300);</script>';
		}
		else if (!preg_match("/^[0-9]*$/",$year)) {
			$errors['year2']= "Only number allowed"; 
			echo '<script type="text/javascript">'; 
            echo 'setTimeout(function () {  swal("'.$errors['year2'].'");';
            echo '},300);</script>';
		  }
	if(count($errors)==0){
		header('Location:select_offered_course.php?value1='.$semester.'&value2='.$year.'&value3='.$dept_name);
	}
	}
	if(isset($_POST['edit_row'])){
		$row_id=$_POST['edit_row'];
		$flag='1';
		header('Location:edit_offer_assign.php?value1='.$row_id.'&value2='.$flag);
	}
?>
<!DOCTYPE html>
<html>
<head>
  <title>Offer course</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="../css/style_2.css">
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
          <a href="admin_dashboard.php" >Dhasboard</a><br><br>
          <a href="department.php" >Department</a><br><br>
          <a href="course.php">Course</a><br><br>
          <a href="offered_course.php" class="btn btn-info">Offer Course</a><br><br>
          <a href="assign_course.php">Assign Course</a><br><br>
          <a href="component.php">Component</a><br><br>
          <a href="history.php">Student PO</a><br><br>
		  <a href="st_enrollment.php">Student Enrollment</a><br><br>
          <a href="../logout.php" class="glyphicon glyphicon-log-out"></a>
          </td>
        </tr>
      </table>  
	  	<div style="width:100%; margin:0px auto ;">
		<div class="table-responsive">
	  	<form method="POST" action="">
		  <table id="tbl2" class="table table-secondary" width="40%">
			<tbody>
				<tr>
					<td>Semester:</td>
					<td><?php
						$query="SELECT distinct semester FROM semester ORDER BY semester_id";
							if(mysqli_query($connection,$query)){
            				$result=mysqli_query($connection,$query);
						?>
					<select name="semester" required style="width:75px">
					<?php    
                    if(mysqli_num_rows($result) > 0){
                    	while ($row = mysqli_fetch_array($result)){
                    ?>
					<option value="<?php echo $row['semester'];?>"> <?php echo $row['semester'];?></option>
                    <?php
                        }
                    }
                }
                	?>  </select></td>
				</tr>
				<tr>
					<td>Year:</td>
					<td><input type="text"  name="year" required size="6"></td>
				</tr>
				<tr>
					<td>Department:</td>
					<td>		 <?php
						$sql="SELECT distinct dept FROM dept";
							if(mysqli_query($connection,$sql)){
            				$result=mysqli_query($connection,$sql);
						?>
					<select name="dept_name" required style="width:75px">
					<?php    
                    if(mysqli_num_rows($result) > 0){
                    	while ($row = mysqli_fetch_array($result)){
                    ?>
					<option value="<?php echo $row['dept'];?>"> <?php echo $row['dept'];?></option>
                    <?php
                        }
                    }
                }
                	?>  
					</select></td>
				</tr>
				<tr>
					<td colspan="2"><input type="submit" name="search" class="btn btn btn-danger btn-sm" value="Select"></td>
				</tr>
					</form>
				</tbody>
				</table>
			</div>
				<form  method="POST" name='f2'>
					<table id="tbl2" class="table table-secondary" width="40%">
						<thead>
						<tr><th colspan="5">Offered Course</th></tr>
						<tr>
							<th>Course Code</th>
							<th>Total Section</th>
							<th colspan="2">Action</th>
						</tr>
						</thead>
					
						<tr>
					<td>
						<select name="offered_course_code" >
							<option></option>
							<?php	 
								$sql = "SELECT distinct course_code FROM course ";
								$select =mysqli_query($connection,$sql);
								if(mysqli_num_rows($select) > 0) {
									while ($row = mysqli_fetch_array($select)) {
							?>
							<option value="<?php echo $row['course_code']?>"><?php echo $row['course_code']?></option>
							<?php
									}
								}
							?>
						</select>
					</td>
					<td><input type="text" name="sec_no"></td>
					<td colspan="2"><button type="submit" name="insert_row" class="btn btn btn-danger btn-sm" style="font-size:16px"><i class="fa fa-plus-circle"></i></button></td>
					</tr>
				
					<?php 
							if($current_month==1||$current_month==2||$current_month==3||$current_month==4){
								$s='Spring';
								$y=$current_year;
								$sql4 = "SELECT a.course_code as course_code,b.tot_sec as total_section ,b.offered_course_id,b.year
								FROM course a INNER JOIN offered_course b INNER JOIN semester c WHERE 
							 	c.semester='$s' AND a.course_id=b.course_id AND b.semester_id=c.semester_id  AND b.year='$y' ";
								$flag = 1; 
							   }	
							   if($current_month==5||$current_month==6||$current_month==7||$current_month==8){
								$s='Summer'; 
								$y=$current_year;
								$sql5 = "SELECT a.course_code as course_code,b.tot_sec as total_section ,b.offered_course_id,b.year
								FROM course a INNER JOIN offered_course b INNER JOIN semester c WHERE 
							 	c.semester='$s' AND a.course_id=b.course_id AND b.semester_id=c.semester_id  AND b.year='$y'";
							$flag = 2; 

							   }
							   if($current_month==9||$current_month==10||$current_month==11||$current_month==12){
								$s='Fall';
								$y=$current_year;
								$sql6 ="SELECT a.course_code as course_code,b.tot_sec as total_section,b.offered_course_id,b.year
								FROM course a INNER JOIN offered_course b INNER JOIN semester c WHERE 
							 	c.semester='$s' AND a.course_id=b.course_id AND b.semester_id=c.semester_id  AND b.year='$y' ";
								$flag = 3; 
							   }	
							if(($flag==1 && ($result2=mysqli_query($connection,$sql4)))||
								($flag==2 && ($result2=mysqli_query($connection,$sql5)))||
								($flag==3 && ($result2=mysqli_query($connection,$sql6)))){
								if(mysqli_num_rows($result2)>0){
		                			while($row=mysqli_fetch_array($result2)){
										echo "<tr>";
										echo "<td>".$row["course_code"]."</td>";
										echo "<td>".$row["total_section"]."</td>";		
		                ?>
						<td><button type="submit" name="delete_row" class="btn btn btn-danger btn-sm" value="<?php echo $row['offered_course_id']; ?>" onclick="return confirm('Are you confirm to delete?')" style="font-size:16px"><i class="fa fa-trash"></i></button></td>
						<td><button type="submit" name="edit_row" class="btn btn btn-danger btn-sm" value="<?php echo $row['offered_course_id']; ?>" style="font-size:16px"><i class="fa fa-edit"></i></button></td>
					</tr>
					<?php
		                }
		            }
				}
			?>
				</tbody>
			  </table>
			</form><br>
			
	
	   </div>
	</div>
</body>
</html>
