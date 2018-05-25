<?php include("db.php");?>

<?php 


	if(isset($_POST['insert_row'])){
		$s=semester();
		if($s=='Spring'||$s=='Summer'||$s=='Fall'){
					$s=semester();
					$current_year = date("Y"); 
					$y=$current_year;
		$offered_course_code=$_POST['insert_row'];  
		$section=mysqli_real_escape_string($connection, $_POST['sec_no']); 
     	$ins=mysqli_real_escape_string($connection, $_POST['username']); 
	    $semester=$s;
		$year=$y;
		$errors=array();

		if ($ins==""){
			$errors['ins']="Please select instructor name";
			echo '<script type="text/javascript">'; 
            echo 'setTimeout(function () {  swal("'.$errors['ins'].'");';
			echo '},300);</script>';
		}
		else if ($section==""){
			$errors['sec']="Please select total section";
			echo '<script type="text/javascript">'; 
            echo 'setTimeout(function () {  swal("'.$errors['sec'].'");';
			echo '},300);</script>';
		} 

		// else if (!preg_match("/^[a-zA-Z ]*$/",$section)) {
		// 	$errors['sec2']= "Only letters and white space allowed"; 
		// 	echo '<script type="text/javascript">'; 
  //           echo 'setTimeout(function () {  swal("'.$errors['sec2'].'");';
  //           echo '},300);</script>';
		//   }
	
			$sql6="SELECT * FROM course c join assigned_course a join offered_course o join semester s 
				WHERE c.course_id=o.course_id and a.offered_course_id=o.offered_course_id and s.semester_id=a.semester_id and o.year='$year' and s.semester='$semester' and a.sec_no='$section' and c.course_code='$offered_course_code'";
			if($result6=mysqli_query($connection,$sql6)){
				if(mysqli_num_rows($result6)>0){
					$row6 = mysqli_fetch_array($result6);
					$errors['sec1']="This section is already assigned";
          			echo '<script type="text/javascript">'; 
		            echo 'setTimeout(function () {  swal("'.$errors['sec1'].'");';
		            echo '},300);</script>';
				  }

			}
		if(count($errors)==0){
      	$sql8="SELECT semester_id FROM semester WHERE semester='$semester'";
			if($result8=mysqli_query($connection,$sql8)){
				if(mysqli_num_rows($result8)>0){
					$row8 = mysqli_fetch_array($result8);
          			$semester=$row8['semester_id'];

				}
      		}	

      	$sql9="SELECT o.offered_course_id FROM offered_course o join course c 
      			WHERE o.course_id=c.course_id and c.course_code='$offered_course_code'";
			if($result9=mysqli_query($connection,$sql9)){
				if(mysqli_num_rows($result9)>0){
					$row9 = mysqli_fetch_array($result9);
          			$offered_course_code=$row9['offered_course_id'];

				}
      		}
		}
		
     	 $sql7="SELECT faculty_id FROM faculty WHERE username='$ins'";
			if($result7=mysqli_query($connection,$sql7)){
				if(mysqli_num_rows($result7)>0){
					$row7 = mysqli_fetch_array($result7);
          			$user_id=$row7['faculty_id'];

				}
      		}
			$sql12 = "INSERT INTO assigned_course(offered_course_id,sec_no,semester_id,faculty_id) VALUES('$offered_course_code','$section','$semester','$user_id')";
			if($res12=mysqli_query($connection,$sql12)){
				echo '<script type="text/javascript">'; 
				echo 'setTimeout(function () { 	swal("Instructor has been assigned successfully");';
				echo '},300);</script>';
				//exit();
      }
      // else 
						// echo mysqli_error($connection);
			
      }
    
}
	if(isset($_POST['delete_row'])){
		$sql = "DELETE FROM assigned_course WHERE assigned_course_id='".$_POST["delete_row"]."'";
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
		header('Location:select_assign_course.php?value1='.$semester.'&value2='.$year.'&value3='.$dept_name);
	}
}
	if(isset($_POST['edit_row'])){
		$row_id=$_POST['edit_row'];
		$flag='2';
		header('Location:edit_offer_assign.php?value1='.$row_id.'&value2='.$flag);
	}
?>
<!DOCTYPE html>
<html>
<head>
  <title>Assign course</title>
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
						$sql="SELECT  dept FROM dept";
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
				<form  method="POST" action="">
					<table id="tbl2" class="table table-secondary" width="40%">
						<thead>
						<tr><th colspan="5">Offered Course</th></tr>
						<tr>
              <th>Offered Course Code(Total Section)</th>						
              <th>Action</th>
    				</tr>
						</thead>
						<tr>
				<?php
					function semester(){
						$current_month = date("m");
			            if($current_month==1||$current_month==2||$current_month==3||$current_month==4){
			                $s='Spring';
			                return $s;
			            }
			            if($current_month==5||$current_month==6||$current_month==7||$current_month==8){
			                $s='Summer';
			                return $s;
			            }
			            if($current_month==9||$current_month==10||$current_month==11||$current_month==12){
			                $s='Fall';
			                return $s;
			            }
            
				}
						$s=semester();
						$current_year = date("Y");
						$y=$current_year;
					?>
					<td><select name="offered_course_code" >
							<option></option>
							<?php	 
								$sql = "SELECT a.course_code,b.tot_sec FROM course a INNER JOIN offered_course b ON a.course_id=b.course_id INNER JOIN semester c ON b.semester_id=c.semester_id WHERE c.semester='$s' AND b.year='$y' ";
								$select =mysqli_query($connection,$sql);
								if(mysqli_num_rows($select) > 0) {
									while ($row = mysqli_fetch_array($select)) {
							?>
							<option value="<?php echo $row['course_code']?>"><?php echo $row['course_code'].'('.$row['tot_sec'].')'?></option>
							<?php
									}
								}
							?>
						</select>
					</td>
					<td colspan="2"><button type="submit" name="set_course_code" class="btn btn btn-danger btn-sm" style="font-size:16px"><i class="fa fa-plus-circle"></i></button></td>
					</tr>
           
				</tbody>
			  </table>
			</form><br><br><br><br><br><br><br><br><br>
				
				
			<div class="table-responsive">
			<form method="POST" action="">
		  <table id="tbl2" class="table table-secondary" width="40%">
        <?php 
  	if(isset($_POST['set_course_code'])){
  		
			$offered_course_code=mysqli_real_escape_string($connection, $_POST['offered_course_code']);  
			if($offered_course_code==""){
				$errors['off_course']="Please select offered course code";
				echo '<script type="text/javascript">'; 
							echo 'setTimeout(function () {  swal("'.$errors['off_course'].'");';
				echo '},300);</script>';
			}
	
            ?>
    
	  	
			<tbody>
			<tr>
			<th>Instructor name</th>
			<th>Section</th>
			<th>Action</th>
			</tr>
            <td>
			<select name="username" >
				<option></option>
				<?php	 
				 $sql7="SELECT c.dept_id FROM course c join dept d where c.dept_id=d.dept_id and c.course_code='$offered_course_code'";
               if($result7=mysqli_query($connection,$sql7)){
                if(mysqli_num_rows($result7)>0){
                	$row7 = mysqli_fetch_array($result7);
                	$dept_id=$row7['dept_id'];

                }
            }

               $sql8="SELECT username FROM faculty where dept_id='$dept_id'";
               if($result8=mysqli_query($connection,$sql8)){
                if(mysqli_num_rows($result8)>0){
                  while($row8 = mysqli_fetch_array($result8)){
              ?>
							<option value="<?php echo $row8['username']?>"> <?php echo $row8['username']?></option>
							<?php
									}
								}
							?>
						</select>
					</td> 
        <?php
          }
        if($s=='Spring' || $s=='Summer' || $s=='Fall'){
          $semester=$s;
          $current_year = date("Y");
          ?>
          <td>
          <select name="sec_no" >
            <option></option>
            <?php	 
             $sql8="SELECT b.tot_sec FROM course a INNER JOIN offered_course b INNER JOIN semester c WHERE
             a.course_code='$offered_course_code' AND c.semester='$s' AND a.course_id=b.course_id AND b.semester_id=c.semester_id  AND year='$current_year '";
            
             if($result8=mysqli_query($connection,$sql8)){
              if(mysqli_num_rows($result8)>0){
                while($row8 = mysqli_fetch_array($result8)){
                  $total_sec=$row8['tot_sec'];
                }
                for($i=1;$i<=$total_sec;$i++){
            ?>
            <option value="<?php echo $i;?>"> <?php echo $i;?></option>
            <?php
                }
              }
            ?>
          </select>
        </td>
        <td colspan="2"><button type="submit" name="insert_row" class="btn btn btn-danger btn-sm" value="<?php  echo $offered_course_code;?>" style="font-size:16px"><i class="fa fa-plus-circle"></i></button></td>
					 <?php
        }
      }
    }
?>
</tr>
</form>
</tbody>
</table>
</div>
<tr>

<div class="table-responsive">
	  	<form method="POST" action="">
		  <table id="tbl2" class="table table-secondary" width="40%">
			<tbody>
			<tr>
			<th>Offered Course Code</th>
			<th>Instructor name</th>
			<th>Section</th>
			<th colspan='2'>Action</th>
			</tr>
				<tr>
				<?php 
				
				if($s=='Spring'||$s=='Summer'||$s=='Fall'){
					$s=semester();
					$current_year = date("Y"); 
					$y=$current_year;
					$sql1 = "SELECT * FROM course c join offered_course o join assigned_course a join semester s join faculty f
						WHERE c.course_id=o.course_id and o.offered_course_id=a.offered_course_id and a.semester_id=s.semester_id and a.faculty_id=f.faculty_id  and s.semester='$s' AND o.year='$y' order by a.sec_no";

					if($result2=mysqli_query($connection,$sql1)){
						if(mysqli_num_rows($result2)>0){
											while($row=mysqli_fetch_array($result2)){
								echo "<tr>";
								echo "<td>".$row["course_code"]."</td>";
								echo "<td>".$row["username"]."</td>";
								echo "<td>".$row["sec_no"]."</td>";		
							?>
								<td><button type="submit" name="delete_row" class="btn btn btn-danger btn-sm" value="<?php echo $row['assigned_course_id']; ?>" onclick="return confirm('Are you confirm to delete?')" style="font-size:16px"><i class="fa fa-trash"></i></button></td>
						<td><button type="submit" name="edit_row" class="btn btn btn-danger btn-sm" value="<?php echo $row['assigned_course_id']; ?>" style="font-size:16px"><i class="fa fa-edit"></i></button></td>
				
							<?php
							
								 }
						 }
						}
					}
				?>
				</tr>
				</tbody>
				</table>
				</form>

	   </div>
    	</div>
</body>
</html>
