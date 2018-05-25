<?php include("db.php");?>
<!DOCTYPE html>
<html>
<head>
  <title>Edit Component</title>
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
      <div style="width:95%; margin:0px auto ; " id="nb2">
       <table id="tbl1" width="16%" height="565px">
        <tr><td valign="top"><br>
          <a href="#" class="glyphicon glyphicon-user">EWU</a><br><br>
          <a href="admin_dashboard.php" >Dhasboard</a><br><br>
          <a href="department.php" >Department</a><br><br>
          <a href="course.php">Course</a><br><br>
          <a href="offered_course.php">Offer Course</a><br><br>
          <a href="assign_course.php">Assign Course</a><br><br>
          <a href="component.php" class="btn btn-info">Component</a><br><br>
          <a href="history.php">Student PO</a><br><br>
		  <a href="st_enrollment.php">Student Enrollment</a><br><br>
          <a href="../logout.php" class="glyphicon glyphicon-log-out"></a>
          </td>
        </tr>
      </table>  
	  <div style="width:100%; margin:0px auto ; ">

	  	<br>
	  	<br><br>
	  <form method="POST" action="">
        <table id="tbl2" class="table table-secondary" width="40%">
			<tbody>
			<?php 

			$row_id=$_GET['value'];
			$sql="SELECT * FROM comp WHERE comp_id='$row_id'";
			$result =mysqli_query($connection,$sql);
	        if(mysqli_num_rows($result) > 0){
	            $row = mysqli_fetch_array($result);

	        ?>
			
	            <tr>
		        	<td>Component Name: </td>
		        	<td><input type="text" name="comp_name" value="<?php echo $row['component'];?>">
		        	</td>
	            </tr>
	            
	            
	             <tr>
					<td colspan="2" ><button type="submit" id="save" name="save" class="btn btn btn-danger btn-sm" style="font-size:16px">Save</button></td>
			     </tr>

	            <?php
	                }
				?>
				</tbody>
			  </table>
			</form><br>
	   </div>
	</div>
</body>
</html>

<?php 
   if(isset($_POST)){
   		if(isset($_POST['save'])){
   			
   		        
	  

	        
	        $comp_name=mysqli_real_escape_string($connection, $_POST['comp_name']);
	        
	     
			

        	$sql="UPDATE comp set component='$comp_name' WHERE comp_id='$row_id'";
	        if(mysqli_query($connection,$sql)){
	            $result=mysqli_query($connection,$sql);
	                echo '<script type="text/javascript">'; 
	                echo 'setTimeout(function () {  swal("Successfully Updated");';
	                echo '},600);</script>';
	                ?>
	               	<script type="text/javascript">
	                	setTimeout(function () {
	               			window.location="component.php";
	               			},3000);
	                </script>
	           	<?php
	        	}
	    	}
	    } 
?>
