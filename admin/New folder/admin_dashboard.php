<?php include("db.php");?>
<!DOCTYPE html>
<html>
<head>
  <title>Admin Dashboard</title>
  <meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="../css/style_2.css">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.4/css/bootstrap-select.min.css"></script>
  <style>
   img{ 
    margin-top: 80px;
    margin-left: 250px;
   }
  </style>
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
          <a href="admin_dashboard.php">Dhasboard</a><br><br>
          <a href="course.php">Course</a><br><br>
          <a href="offered_course.php">Offer Course</a><br><br>
          <a href="assign_course.php">Assign Course</a><br><br>
          <a href="history.php">Student PO</a><br><br>
					<a href="st_enrollment.php">Student Enrollment</a><br><br>
          <a href="../logout.php" class="glyphicon glyphicon-log-out"></a>
          </td>
        </tr>
      </table> 
      <img src="../images/4.jpg" width="900px" height="480px" style="float:right; margin-left:0px;">
		</div>
    <div class="admin">

    </div>           
</body>
</html>