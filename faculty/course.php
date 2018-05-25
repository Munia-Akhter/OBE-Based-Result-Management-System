<?php 
include("db.php");
session_start();
$username=$_SESSION['username'];
?>
<!DOCTYPE html>
<html>
<head>
    <title>Course</title>
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
							<a href="course.php" class="btn btn-info">Course</a>
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

		<div><h4><b>Search Course</b></h4></div>
			<div id="login">
			<br>
			<form method="POST">
				Semester : <?php
						$query="SELECT semester FROM semester order by semester_id ";
							if(mysqli_query($connection,$query)){
            				$result=mysqli_query($connection,$query);
						?>
					<select name="semester" required style="width:75px">
					<?php    echo "string";
                    if(mysqli_num_rows($result) > 0){
                    	while ($row = mysqli_fetch_array($result)){
                    ?>
					<option value="<?php echo $row['semester'];?>"> <?php echo $row['semester'];?></option>
                    <?php
                        }
                    }
                }
                	?> </select><br><br>
				Year : <input type="text" name="year" size="9"><br><br>    
				<input type="submit" id="btn" class="btn btn-danger" name="submit" 
					value="Search">
				</form>
			</div>
			

			<?php
				if(isset($_POST['submit'])){
    				$semester = $_POST['semester'];
    				$year = $_POST['year'];
				 $sql = "SELECT * FROM course c JOIN offered_course o join assigned_course a join semester s join faculty f WHERE c.course_id=o.course_id and o.offered_course_id=a.offered_course_id and a.semester_id=s.semester_id and a.faculty_id=f.faculty_id and f.username='$username' AND s.semester='$semester' AND o.year='$year'";
			 if($result = mysqli_query($connection, $sql)){
            if(mysqli_num_rows($result) > 0){
            ?>
		<div style="width:80%; margin:0px auto ;">
            	<h4><b>Assigned Course</b></h4>
				<div class="table-responsive">
            	 <table class="table table-striped" border="1px solid black">
				    <thead>
				      <tr>
				        <th>Course Code</th>
				        <th>Course Title</th>
				        <th>Credit</th>
				        <th>Section</th>
				        <th>Semester</th>
				      </tr>
				    </thead>
				    <tbody>
            <?php
            	 while($row=mysqli_fetch_array($result)){
		            echo "<tr>";
		            echo "<td>".$row["course_code"]."</td>";
		            echo "<td>".$row["title"]."</td>";
		            echo "<td>".$row["credit"]."</td>";
		            echo "<td>".$row["sec_no"]."</td>";
		            echo "<td>".$row["semester"]." ".$row["year"]."</td>";
		            echo "</tr>";
		            }	
                }
             else{
				echo '<script type="text/javascript">'; 
				echo 'swal("No course was assigned");';
				echo '</script>';
				?>
				<script>
					var id="<?php echo $username;?>";
						setTimeout(function () {  
						window.location.replace("course.php?value=" + id);
					},3000);
				</script>
			<?php

        		}
            }
  		}
			?>
			</table>
			</div>
				<br>
          </div>
	  </div>
	</div>
</body>
</html>