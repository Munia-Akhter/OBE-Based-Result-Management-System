<?php include("db.php");?>
<!DOCTYPE html>
<html>
<head>
  <title>Edit Course</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="../css/style_2.css">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-sweetalert/1.0.1/sweetalert.min.css">
  <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-sweetalert/1.0.1/sweetalert.min.js"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.4/css/bootstrap-select.min.css"></script>
  <script src="../js/sweetalert.min.js"></script>
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
      <div style="width:95%; margin:0px auto id='nb2'; ">
       <table id="tbl1" width="16%" height="565px">
        <tr><td valign="top"><br>
			<a href="#" class="glyphicon glyphicon-user">EWU</a><br><br>
	          <a href="admin_dashboard.php">Dhasboard</a><br><br>
	          <a href="department.php" >Department</a><br><br>
	          <a href="course.php">Course</a><br><br>
	          <a href="offered_course.php">Offer Course</a><br><br>
	          <a href="assign_course.php">Assign Course</a><br><br>
	          <a href="component.php">Component</a><br><br>
	          <a href="history.php">Student PO</a><br><br>
			  <a href="st_enrollment.php">Student Enrollment</a><br><br>
	          <a href="../logout.php" class="glyphicon glyphicon-log-out"></a>
          </td>
        </tr>
      </table>  
	  <div style="width:100%; margin:0px auto ; ">
	  <form method="POST" action="">
        <table id="tbl2" class="table table-secondary" width="40%">
			<tbody>
			<?php 
					$row_id=$_GET['value1'];
					$flag=$_GET['value2'];
					
						/*$smester=$_GET['value1'];
						$year=$_GET['value2'];
						$dept_name=$_GET['value3'];*/
						if($flag=='1'){
						$sql="SELECT * FROM offered_course o join course c WHERE o.course_id=c.course_id and o.offered_course_id='$row_id'";
						$result =mysqli_query($connection,$sql);
	                        if(mysqli_num_rows($result) > 0){
	                           $row = mysqli_fetch_array($result);
	                           ?>
	                           	<tr>
		                           <td>Offered Course Code: </td>
		                           <td><input type="text" name="offered_course_code" value="<?php echo $row['course_code'];?>">
		                           </td>
		                       	</tr>
	                           	<tr>
		                           <td>Section: </td>
		                           <td><input type="text" name="section" value="<?php echo $row['tot_sec'];?>"></td>
	                           	</tr>
	                           	<tr>
								   <td colspan="2"><input type="submit" name="save1" class="btn btn-primary btn-xs" value="Save"></td>
	                           	</tr>
	                           <?php
	                    	}
	                   }

	                   else if($flag=='2'){
						$sql="SELECT * FROM course c join offered_course o join assigned_course a join faculty f 
							WHERE c.course_id=o.course_id and o.offered_course_id=a.offered_course_id and a.faculty_id=f.faculty_id and  a.assigned_course_id='$row_id'";
						$result =mysqli_query($connection,$sql);
	                        if(mysqli_num_rows($result) > 0){
	                           $row = mysqli_fetch_array($result);
	                           ?>
	                           	<tr>
		                           <td>Offered Course Code: </td>
		                           <td><input type="text" name="offered_course_code" value="<?php echo $row['course_code'];?>">
		                           </td>
		                       	</tr>
	                           	<tr>
		                           <td>Section: </td>
		                           <td><input type="text" name="sec_no" value="<?php echo $row['sec_no'];?>"></td>
	                           	</tr>
								   
								   <tr>
		                           <td>Instructor name: </td>
		                           <td><input type="text" name="username" value="<?php echo $row['username'];?>"></td>
	                           	</tr>
								   
	                           	<tr>
								   <td colspan="2"><input type="submit" name="save2" class="btn btn-primary btn-xs" value="Save"></td>
	                           	</tr>
	                           <?php
	                       }
	                   }
					?>
				</table>
				</form>
				<br>
	   </div>
	</div>
</body>
</html>
<?php 
   if(isset($_POST)){
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

   		if(isset($_POST['save1'])){
   			$offered_course_code=mysqli_real_escape_string($connection, $_POST['offered_course_code']);
   		        
	        $section=mysqli_real_escape_string($connection, $_POST['section']);

	        $sql1="SELECT * FROM offered_course o join course c join semester s 
	        	WHERE o.course_id=c.course_id and s.semester_id=o.semester_id and  c.course_code='$offered_course_code' and s.semseter='$semseter' and  o.year='$year'";
			$result1 =mysqli_query($connection,$sql1);

            if(mysqli_num_rows($result1) > 0){
               $row1 = mysqli_fetch_array($result1);
               $offered_course_id=$row1['course_id'];
             }
             else{
             	echo '<script type="text/javascript">'; 
				echo 'setTimeout(function () { 	swal("Course does not exit");';
				echo '},100);</script>';
				exit();
             }

            $sql2="SELECT * FROM offered_course o join course c WHERE o.course_id=c.course_id and  c.course_code='$offered_course_code' and o.offered_course_id='$offered_course_id'";
			$result2 =mysqli_query($connection,$sql2);

            if(mysqli_num_rows($result2) > 0){
               	echo '<script type="text/javascript">'; 
				echo 'setTimeout(function () { 	swal("The course is already offered");';
				echo '},100);</script>';
				exit();
             }

	       
        	$sql="UPDATE offered_course set course_id='$offered_course_id',tot_sec='$section' WHERE offered_course_id='$row_id'";
	        if(mysqli_query($connection,$sql)){
	            $result=mysqli_query($connection,$sql);
	                echo '<script type="text/javascript">'; 
	                echo 'setTimeout(function () {  swal("Successfully Saved !!");';
	                echo '},600);</script>';
	                ?>
	               	<script type="text/javascript">
	                	setTimeout(function () {
	               			window.location="offered_course.php";
	               			},3000);
	                </script>
	           	<?php
	        	}
	    }

	    if(isset($_POST['save2'])){

			function test_input($data){
				$data = trim($data); 
				$data = stripslashes($data); 
				$data = htmlspecialchars($data);  
				return $data;
			}
	
			$offered_course_code=mysqli_real_escape_string($connection, $_POST['offered_course_code']);
			 
		 $section=mysqli_real_escape_string($connection, $_POST['sec_no']);
		 $username=mysqli_real_escape_string($connection, $_POST['username']);
		 $username=test_input($username);  

		 $sql="SELECT * FROM course c join offered_course o join assigned_course a join semester s 
			WHERE c.course_id=o.course_id and o.offered_course_id=a.offered_course_id and s.semester_id=a.semester_id ";
		$result =mysqli_query($connection,$sql);
            if(mysqli_num_rows($result) > 0){
	        	while($row = mysqli_fetch_array($result)){
				$offered_course_id=$row['offered_course_id'];
				$semester_id=$row['semester_id'];
	     //    	if($row ['course_code']==$offered_course_code && $row ['sec_no']==$section && $row ['assigned_course_id']!=$row_id){
	     //    		echo '<script type="text/javascript">'; 
	     //            echo 'setTimeout(function () {  swal("This section for this course is already assigned");';
	     //            echo '},600);</script>';
	     //            exit();
	    	// }
	    	if($row ['course_code']!=$offered_course_code ){
	        		echo '<script type="text/javascript">'; 
	                echo 'setTimeout(function () {  swal("This course does not exist");';
	                echo '},600);</script>';
	                //exit();
	    	}
	    	// if($section>$row['tot_sec']){
    		// 	echo '<script type="text/javascript">'; 
      //           echo 'setTimeout(function () {  swal("This section does not exist");';
      //           echo '},600);</script>';
      //           exit();
	    	}
	    }
	
	 
	$sql="SELECT * FROM course c join offered_course o join assigned_course a join semester s 
			WHERE c.course_id=o.course_id and o.offered_course_id=a.offered_course_id and s.semester_id=a.semester_id and c.course_code='$offered_course_code' ";
		$result =mysqli_query($connection,$sql);
            if(mysqli_num_rows($result) > 0){
	        	$row = mysqli_fetch_array($result);
				$offered_course_id=$row['offered_course_id'];
				$semester_id=$row['semester_id'];
	    	if($section>$row['tot_sec']){
    			echo '<script type="text/javascript">'; 
                echo 'setTimeout(function () {  swal("This section does not exist");';
                echo '},600);</script>';
                exit();
	    	}
	    }
	


	    $sql1="SELECT * FROM faculty f  join dept d
			WHERE  d.dept_id=f.dept_id ";
		$result1 =mysqli_query($connection,$sql1);
            if(mysqli_num_rows($result1) > 0){
	        	while($row = mysqli_fetch_array($result1)){
			    	if($row ['username']!=$username ){ 
			        		echo '<script type="text/javascript">'; 
			                echo 'setTimeout(function () {  swal("Wrong Username");';
			                echo '},600);</script>';
			         
	    			}break;
	    		}
	   		 }
		 $query="SELECT * FROM faculty f  join dept d
			WHERE  d.dept_id=f.dept_id and f.username='$username'";
		  if(mysqli_query($connection,$query)){
			$resultq=mysqli_query($connection,$query);
			$rowq=mysqli_fetch_array($resultq);
				$faculty_id=$rowq['faculty_id'];
	 echo $row_id;
		 $sql="UPDATE assigned_course set offered_course_id='$offered_course_id',sec_no='$section',semester_id='$semester_id'
		 ,faculty_id='$faculty_id' WHERE assigned_course_id='$row_id'"; 
		  if(mysqli_query($connection,$sql)){
			  
	            $result=mysqli_query($connection,$sql);
	                echo '<script type="text/javascript">'; 
	                echo 'setTimeout(function () {  swal("Successfully Updated !!");';
	                echo '},600);</script>';
	                ?>
	               	<script type="text/javascript">
	                	setTimeout(function () {
	               			window.location="assign_course.php";
	               			},3000);
	                </script>
	           	<?php
	        	}
			}
			

		
	
		}	
} 
?>
