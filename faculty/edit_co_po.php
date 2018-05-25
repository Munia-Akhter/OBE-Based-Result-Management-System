<?php 
include("db.php");
session_start();
$username=$_SESSION['username'];
?>
<!DOCTYPE html>
<html>
<head>
  <title>Edit course and program outcome</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-sweetalert/1.0.1/sweetalert.min.css">
  <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-sweetalert/1.0.1/sweetalert.min.js"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.4/css/bootstrap-select.min.css"></script>
</head>

<style type="text/css">

#login
{

    border-radius: 25px;
    border: 1px solid black;
    padding: 20px; 
    width: 400px;
    height: 220px; 
    text-align: center;
    margin: 0px auto; 
    margin-bottom: 20px;   
    background-color: #D4F2F7;

  }

 h4{
  	text-align: center; 
  }

#btn{
  	height: 30px;
  	width: 92px;
  	margin-left: 44px;
  }

#function{

	width: 100%;	
	margin:0px auto;
}

#nb {
	margin-top:0px;
	background-color: #020c13fc;
	color: #ffffff;
}
#nb li a:hover{
	color:#ffffff;
}
table th,td,tr{
	  text-align: center;
}


table th{
	  background-color: #081521;
	  color:#D5DBDB;
}

.faculty{
	text-align: center;
	margin-bottom: 40px;
	margin-top: 20px;

}

.jumbotron{
	min-height: 600px;

}
</style>
<body>
   <div id="function">
			<nav class="navbar navbar-default" id="nb">
        <div class="container-fluid" id="nb2">
			    <div class="navbar-header" id="nb3">
		        <a class="navbar-brand" href="#">East West University</a>
			    </div>
			    <ul class="nav navbar-nav">
						<li><a href="faculty_home.php">Home</a></li>
						<li><a href="course.php">Course</a></li>
						<li><a href="select_course.php">Mapping Course</a></li>
						<li><a href="select_course_grade.php">Grade Distribution</a></li>
		   	</ul>
         
				 <ul class="nav navbar-nav navbar-right">
				      <li><a href="#"><span class="glyphicon glyphicon-user"></span></a></li>
				      <li><a href="../logout.php"><span class="glyphicon glyphicon-log-in"></span></a></li>
				  </ul>
			  </div>
			</nav>
<div class="table-responsive">
<form method="POST">
    <table class="table table-striped" border="1px solid black">
                <?php 
                   
                    $flag=$_GET['value2'];
                    $username = $_GET['value5'];
                    $course_code = $_GET['value6'];
                    $sec_no = $_GET['value7'];
                    $semester = $_GET['value8'];
                    $year = $_GET['value9'];
                    //Edit course outcome (co)
                    if($flag=='1'){
                      $row_id=$_GET['value1'];
                      $sql="SELECT * FROM co WHERE co_id='$row_id'";
                      $result =mysqli_query($connection,$sql);
                      if(mysqli_num_rows($result) > 0){
                        $row = mysqli_fetch_array($result);
                    ?>
                    <tr>
                      <td>Course Outcome: </td>
                      <td><input type="text" name="co_text" value="<?php echo $row['co_text'];?>"></td>
                    </tr>
                    <tr>
                      <td>CO Marks: </td>
                      <td><input type="text" name="co_marks" value="<?php echo $row['co_marks'];?>"></td>
                    </tr>
                    <tr>
                      <td colspan="2"><button name="save1" class="btn btn btn-danger btn-sm">Save</button></td>
                    </tr>
                    <?php
                      }
                    }
                    //Edit CO threshold
                    if($flag=='2'){
                      $row_id=$_GET['value1'];
                      $sql="SELECT * FROM co WHERE co_id='$row_id'";
                      $result =mysqli_query($connection,$sql);
                      if(mysqli_num_rows($result) >= 0){
                        $row = mysqli_fetch_array($result);
                    ?>
                    <tr>
                      <td>Threshold: </td>
                      <td><input type="text" name="tr" value="<?php echo $row['co_tr'];?>"></td>
                    </tr>
                    <tr>
                      <td colspan="2"><button name="save2" class="btn btn btn-danger btn-sm">Save</button></td>
                    </tr>
                    <?php
                    }
                  }
                  if($flag=='3'){
                    ?>
<div class="table-responsive">
	<form method="POST">
		<table class="table table-striped" border="1px solid black">
			<thead>
			<?php
			echo "<tr><th colspan='13'>Edit course outcome in program outcome</th></tr>";
			echo "</thead>";
			echo "<tbody>";
			echo "<tr>";
      echo "<td>".$course_code."</td>";
      $sql1="SELECT * FROM po";
			if($result1=mysqli_query($connection,$sql1)){
				if(mysqli_num_rows($result1)>0){
					$row_num=mysqli_num_rows($result1);
					while ($row1 = mysqli_fetch_array($result1)){
							echo "<td>".$row1['po_code']."</td>";
						}
					}
				}
				echo "</tr>";
				
      echo "<tr>";
      $sql2="SELECT co_code FROM course_outcome WHERE course_code='$course_code' AND sec_no='$sec_no' AND semester='$semester' AND year='$year'";
			if($result2=mysqli_query($connection,$sql2)){
				if(mysqli_num_rows($result2)>0){
					while ($row2 = mysqli_fetch_array($result2)){
						$co_code=$row2['co_code'];
						echo "<td>".$co_code."</td>";
						if($result1=mysqli_query($connection,$sql1)){
						if(mysqli_num_rows($result1)>0){
							$row_num=mysqli_num_rows($result1);
							while ($row1 = mysqli_fetch_array($result1)){	
							$po=$row1['po_code'];	
	?>
	<td><input type="checkbox" name="check[]" value="<?php echo $co_code." ";?><?php echo $po;?>"></td>
	<?php
			}
		}
	}
	echo "</tr>";
		}
	}
}
	?> 
		<tr>
    <td colspan="13"><button name="edit_po"class="btn btn btn-danger btn-md">Save</button>
		</tr>
            <?php
			echo "</tbody>";
			echo "</table>";
			echo "</form>";
			echo "</div>";
              }
              
?>
				  </table>
      </form>
	</div><br>
</div>
</div>
</body>
</html>
<?php 
if(isset($_POST)){
//Save course outcome (co)
  if(isset($_POST['save1'])){
    $co_text=mysqli_real_escape_string($connection, $_POST['co_text']);
    $co_marks=mysqli_real_escape_string($connection, $_POST['co_marks']);
    
    $sql1="UPDATE co set co_text='$co_text',co_marks='$co_marks',rest_co_marks='$co_marks' WHERE co_id='$row_id'";
      if(mysqli_query($connection,$sql1)){
        echo '<script type="text/javascript">'; 
        echo 'setTimeout(function () {  swal("Successfully Saved !!");';
        echo '},600);</script>';
?>
        <script type="text/javascript">
            setTimeout(function (){
        <?php  
            $sql2="SELECT * FROM course c join offered_course o join assigned_course a join semester s join faculty f
                WHERE c.course_id=o.course_id and o.offered_course_id=a.offered_course_id and a.faculty_id= f.faculty_id and s.semester_id=o.semester_id and  c.course_code='$course_code' AND a.sec_no='$sec_no' AND s.semester='$semester' AND o.year='$year' AND f.username='$username'";
            if($result2=mysqli_query($connection,$sql2)){
              if(mysqli_num_rows($result2)>0){
                $row=mysqli_fetch_array($result2);
                $id=$row['assigned_course_id'];
                header('Location:co_po.php?value='.$id);
                }
            }
      
            ?>
              },2000);
          }
        </script>
            <?php
        }
    }
//Save CO threshold
if(isset($_POST['save2'])){
   $tr=mysqli_real_escape_string($connection, $_POST['tr']);
  echo $row_id;
  $sql1="UPDATE co set co_tr='$tr' WHERE co_id='$row_id'";
  if(mysqli_query($connection,$sql1)){
    echo '<script type="text/javascript">'; 
    echo 'setTimeout(function () {  swal("Successfully Saved !!");';
    echo '},600);</script>';
?>
    <script type="text/javascript">
      setTimeout(function (){
    <?php  
      $sql2="SELECT * FROM course c join offered_course o join assigned_course a join semester s join faculty f
        WHERE c.course_id=o.course_id and o.offered_course_id=a.offered_course_id and a.faculty_id= f.faculty_id and s.semester_id=o.semester_id and  c.course_code='$course_code' AND a.sec_no='$sec_no' AND s.semester='$semester' AND o.year='$year' AND f.username='$username'";
      if($result2=mysqli_query($connection,$sql2)){
        if(mysqli_num_rows($result2)>0){
          $row2=mysqli_fetch_array($result2);
          $id=$row2['assigned_course_id'];
         
        }
      } header('Location:co_po.php?value='.$id);     
     
    ?>
      },3000);
    }
    </script>
    <?php
  }
}
}
//Edit PO
if(isset($_POST['edit_po'])){
  if(isset($_POST['check'])){
    foreach($_POST['check'] as $check){
       $x=$check;
       $pieces = explode(" ", $x);
       $co= $pieces[0];
       $po= $pieces[1];
       $sql4="UPDATE mapping SET co_code='$co' WHERE course_code='$course_code' AND  
sec_no='$sec_no' AND semester='$semester' AND year='$year' AND po_code='$po'";
if($result4 = mysqli_query($connection,$sql4)){
echo '<script type="text/javascript">'; 
echo 'setTimeout(function () {  swal("Successfully Saved");';
echo '},600);</script>';
?>
<script type="text/javascript">
    setTimeout(function (){
<?php  
    $sql2="SELECT id FROM assign_course WHERE offered_course_code='$course_code' AND sec_no='$sec_no' AND semester='$semester' AND year='$year' AND username='$username'";
    if($result2=mysqli_query($connection,$sql2)){
      if(mysqli_num_rows($result2)>0){
        $row=mysqli_fetch_array($result2);
        $id=$row['id'];
        header('Location:co_po.php?value='.$id);
        }
    }

    ?>
      },1000);
  
</script>
    <?php

    }
    }
  }
}

?>