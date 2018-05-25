<?php include("db.php");

	$errors=array();
	function test_input($data){
		$data = trim($data); 
		$data = stripslashes($data); 
		$data = htmlspecialchars($data);  
		return $data;
	}	

	if(isset($_POST['add'])){
		$course_code=mysqli_real_escape_string($connection, $_POST['course_code']);
		$course_code=test_input($course_code);
		
		$title=mysqli_real_escape_string($connection, $_POST['title']);
	    $title=test_input($title);
		
		$dept_name=mysqli_real_escape_string($connection, $_POST['dept_name']);
	    $dept_name=test_input($dept_name);
		
		$credit=mysqli_real_escape_string($connection, $_POST['credit']);
		$credit=test_input($credit);

		if(empty($_POST['course_code'])){
			$errors['course_code']="Please Enter Course Code";
			echo '<script type="text/javascript">'; 
            echo 'setTimeout(function () {  swal("'.$errors['course_code'].'");';
            echo '},300);</script>';
		}
		else if (!preg_match("/^[A-Za-z0-9]*$/",$course_code)) {
			$errors['course_code_preg']= "Letters and numbers allowed"; 
			echo '<script type="text/javascript">'; 
            echo 'setTimeout(function () {  swal("'.$errors['course_code_preg'].'");';
            echo '},300);</script>';
		  }
	   	else if(empty($_POST['title'])){
	       	$errors['title']="Please Enter Course Title";
			echo '<script type="text/javascript">'; 
            echo 'setTimeout(function () {  swal("'.$errors['title'].'");';
            echo '},300);</script>';
		}
		else if (!preg_match("/^[a-zA-Z ]*$/",$title)) {
			$errors['course_code_title']= "Only letters and white space allowed"; 
			echo '<script type="text/javascript">'; 
            echo 'setTimeout(function () {  swal("'.$errors['course_code_title'].'");';
            echo '},300);</script>';
		  }
	    else if(empty($_POST['dept_name'])){
	        $errors['dept_name']="Please Enter Department Name";
			echo '<script type="text/javascript">'; 
            echo 'setTimeout(function () {  swal("'.$errors['dept_name'].'");';
			echo '},300);</script>';
		}
		
	    else if(empty($_POST['credit'])){
	        $errors['credit']="Please Enter Course Credit";
			echo '<script type="text/javascript">'; 
            echo 'setTimeout(function () {  swal("'.$errors['credit'].'");';
			echo '},300);</script>';
		}

		else if (!preg_match("/^[0-9]*$/",$credit)) {
			$errors['course_code_credit']= "Only number allowed"; 
			echo '<script type="text/javascript">'; 
            echo 'setTimeout(function () {  swal("'.$errors['course_code_credit'].'");';
            echo '},300);</script>';
		}

	    if(count($errors)==0){
	    	$sql = "SELECT * FROM course";
	        if($result=mysqli_query($connection,$sql)){
	           	if(mysqli_num_rows($result) > 0){
					while($row = mysqli_fetch_array($result)){
						if($row['course_code']==$course_code){
						echo '<script type="text/javascript">'; 
						echo 'setTimeout(function () { 	swal("Course already exist !!");';
						echo '},600);</script>';
					//	exit();
					}
				}
			}
		}

		$sql11="SELECT dept_id FROM dept where dept='$dept_name'";
        $select11=mysqli_query($connection,$sql11);

		if(mysqli_num_rows($select11) > 0) {
			$row1 = mysqli_fetch_array($select11);
				$dept_id=$row1['dept_id'];

		}
		$sql="INSERT INTO course(course_code,dept_id,title,credit) VALUES('$course_code','$dept_id','$title','$credit')";
		if($result=mysqli_query($connection,$sql)){
			echo '<script type="text/javascript">'; 
	        echo 'setTimeout(function () {  swal("Successfully Inserted");';
			echo '},600);</script>';
			//header('Location:course.php');
			}
			
		}
	}
if(isset($_POST['delete_row'])){
	 $row_id=$_POST['delete_row'];
        $sql="DELETE FROM course WHERE course_id='$row_id'";
        if(mysqli_query($connection,$sql)){
            $result=mysqli_query($connection,$sql);
                echo '<script type="text/javascript">'; 
                echo 'setTimeout(function () {  swal("Successfully Deleted !!");';
                echo '},600);</script>';
        }
    }
if(isset($_POST['edit_row'])){
	$row_id=$_POST['edit_row'];
	header('Location:edit_course.php?value='.$row_id);
}   
?>

<!DOCTYPE html>
<html>
<head>
  <title>Course</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="../css/style_2.css">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
  <link rel="stylesheet" href="../css/bootstrap.min.css">
  <script src="../js/sweetalert.min.js"></script>
  <script src="../js/jquery-3.2.1.min.js"></script>
  <script src="../js/bootstrap.min.js"></script>
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
      <div style="width:85%; margin:0px auto ; " id="nb2">
       <table id="tbl1" width="16%" height="565px">
        <tr><td valign="top"><br>
          <a href="#" class="glyphicon glyphicon-user">EWU</a><br><br>
          <a href="admin_dashboard.php" >Dhasboard</a><br><br>
          <a href="department.php" >Department</a><br><br>
          <a href="course.php" class="btn btn-info">Course</a><br><br>
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
	  <div class="table-responsive">
        <table id="tbl2" class="table table-striped" border="1px solid black" width="35%">
			<thead>
				<tr>
				    <th>Course Code</th>
				    <th>Title</th>
				    <th>Dept. Name</th>
				    <th>Credit</th>
				    <th colspan="2">Action</th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td><input type="text" name="course_code" placeholder="Ex: CSE101" value="<?php //if(isset($_POST['course_code'])) echo $_POST['course_code']; ?>"></td>
					<td><input type="text" name="title" value="<?php //if(isset($_POST['title'])) echo $_POST['title'];?>"></td>
					<td>
					<?php                
							$sql11="SELECT dept FROM dept";
                            $select11=mysqli_query($connection,$sql11);
				
                    		if(mysqli_num_rows($select11) > 0) {
                    ?>

						<select name="dept_name">
        					<?php	
        						while ($row1 = mysqli_fetch_array($select11)) {
                        			
                 			?>

                    			<option value="<?php echo $row1['dept'];?>" ><?php echo $row1['dept'];?></option>
                    		<?php
                        		}
                    		}

					?>
					</td>
					<td><input type="text" name="credit" value="<?php // if(isset($_POST['credit'])) echo $_POST['credit'];?>"></td>
					<td colspan="2"><button type="submit" name="add" class="btn btn btn-danger btn-sm" style="font-size:16px"><i class="fa fa-plus-circle"></i></button></td>
				</tr>
				<tr><?php 
				$query_2="SELECT d.dept,c.course_id,c.course_code,c.title,c.credit FROM course c join dept d where c.dept_id=d.dept_id";
				if($select=mysqli_query($connection,$query_2)){
                    if(mysqli_num_rows($select) > 0){
                    	while ($row = mysqli_fetch_array($select)){
                        	echo "<tr>";
                            echo "<td>".$row['course_code']."</td>";
                            echo "<td>".$row['title']."</td>";
                            echo "<td>".$row['dept']."</td>";
                            echo "<td>".$row['credit']."</td>";
                    ?>
					<td><button type="submit" name="delete_row" class="btn btn btn-danger btn-sm" value="<?php echo $row['course_id']; ?>" onclick="return confirm('Are you confirm to delete?')" style="font-size:16px"><i class="fa fa-trash"></i></button></td>
					<td><button type="submit" name="edit_row" class="btn btn btn-danger btn-sm" value="<?php echo $row['course_id']; ?>" style="font-size:16px"><i class="fa fa-edit"></i></button></td>
					<?php
                echo "</tr>";  
                        }
                    }
                }
                	?>
				</tbody>
			  </table>
			  </div>
			</form>
	   </div>
	</div>
</body>
</html>
