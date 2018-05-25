<?php include("db.php");

$start=0;
$limit=7;
if(isset($_GET['id'])){
	$id=$_GET['id'];
	$start=($id-1)*$limit;
}
else
	$id=1;
$query_1="SELECT * FROM course order by course_code";
if($result=mysqli_query($connection,$query_1)){
	$total=mysqli_num_rows($result);
}

//$page=5/2=2.5=3, display total 3 page 
if(isset($total)){
$page=$total/$limit;
}
$query_2="SELECT * FROM course LIMIT $start,$limit";
$select=mysqli_query($connection,$query_2);	
?>
<?php 
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
		else if (!preg_match("/^[a-zA-Z ]*$/",$dept_name)) {
			$errors['course_code_dept_name']= "Only letters and white space allowed"; 
			echo '<script type="text/javascript">'; 
            echo 'setTimeout(function () {  swal("'.$errors['course_code_$dept_name'].'");';
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
						exit();
					}
				}
			}
		}
		$sql="INSERT INTO course(course_code,title,dept_name,credit) VALUES('$course_code','$title','$dept_name','$credit')";
		if($result=mysqli_query($connection,$sql)){
			echo '<script type="text/javascript">'; 
	        echo 'setTimeout(function () {  swal("Successfully Inserted");';
			echo '},600);</script>';
			header('Location:course.php');
			}
			else 
				echo mysqli_error($connection);
		}
	}
if(isset($_POST['delete_row'])){
	 $row_id=$_POST['delete_row'];
        $sql="DELETE FROM course WHERE id='$row_id'";
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
      <div style="width:95%; margin:0px auto ; " id="nb2">
       <table id="tbl1" width="16%" height="565px">
        <tr><td valign="top"><br>
          <a href="#" class="glyphicon glyphicon-user"> EWU</a><br><br>
          <a href="admin_dashboard.php">Dhasboard</a><br><br>
          <a href="course.php" class="btn btn-info">Course</a><br><br>
          <a href="offered_course.php">Offer Course</a><br><br>
		  <a href="assign_course.php">Assign Course</a><br><br>
		  <a href="st_enrollment.php">Student Enrollment</a><br><br>
		  <a href="registration.php">Instructor Registration</a><br><br>
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
					<td><input type="text" name="course_code" value="<?php //if(isset($_POST['course_code'])) echo $_POST['course_code']; ?>"></td>
					<td><input type="text" name="title" value="<?php //if(isset($_POST['title'])) echo $_POST['title'];?>"></td>
					<td><input type="text" name="dept_name" value="<?php // if(isset($_POST['dept_name'])) echo $_POST['dept_name']; ?>"></td>
					<td><input type="text" name="credit" value="<?php // if(isset($_POST['credit'])) echo $_POST['credit'];?>"></td>
					<td colspan="2"><button type="submit" name="add" class="btn btn btn-danger btn-sm" style="font-size:16px"><i class="fa fa-plus-circle"></i></button></td>
				</tr>
				<tr><?php 
                    if(mysqli_num_rows($select) > 0){
                    	while ($row = mysqli_fetch_array($select)){
                        	echo "<tr>";
                            echo "<td>".$row['course_code']."</td>";
                            echo "<td>".$row['title']."</td>";
                            echo "<td>".$row['dept_name']."</td>";
                            echo "<td>".$row['credit']."</td>";
                    ?>
					<td><button type="submit" name="delete_row" class="btn btn btn-danger btn-sm" value="<?php echo $row['id']; ?>" onclick="return confirm('Are you confirm to delete?')" style="font-size:16px"><i class="fa fa-trash"></i></button></td>
					<td><button type="submit" name="edit_row" class="btn btn btn-danger btn-sm" value="<?php echo $row['id']; ?>" style="font-size:16px"><i class="fa fa-edit"></i></button></td>
					<?php
                echo "</tr>";  
                        }
                    }
                	?>
				</tbody>
			  </table>
			  </div>
			</form><br>
			<div class="container" id="pagination">
    			<ul class="pagination">
					<?php 
						if($id>1){
					?>
					<li><a href="?id=<?php echo ($id-1);?>">Previous</a></li>
					<?php 
						}
						if(isset($page)){
							for($i=1;$i<=$page;$i++){
					?>
					<li><a href="course.php?id=<?php echo $i;?>"><?php echo $i;?></a></li>
					<?php  }
						if($id!=$page){
					?>
					<li><a href="?id=<?php echo ($id+1);?>">Next</a></li>
					<?php  }
						}
					?>
            </div>
	   </div>
	</div>
</body>
</html>
