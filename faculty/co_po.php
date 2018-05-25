<?php 
include("db.php");
session_start();
$username=$_SESSION['username'];
?>
<!DOCTYPE html>
<html>
<head>
    <title>Course and Program outcome</title>
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
<?php 

if(isset($_GET["alert"])){
	$alert=$_GET["alert"];
	if($alert==1){
	echo '<script type="text/javascript">';
	echo 'setTimeout(function () {  swal("You have already assigned'.$co_code.'");';
	echo '},600);</script>';
	}
}
?>
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
							<a href="select_course.php" class="btn btn-info">Mapping Course</a>
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
			 $sql = "SELECT *
					FROM course c JOIN offered_course o join assigned_course a join faculty f join semester s
                    WHERE c.course_id=o.course_id and o.offered_course_id=a.offered_course_id and a.faculty_id=f.faculty_id AND s.semester_id=a.semester_id and
					f.username='$username' AND a.assigned_course_id='$id'";
	  				if($result=mysqli_query($connection,$sql)){
						if(mysqli_num_rows($result)>0){
							$row=mysqli_fetch_array($result);	
					$course_code = $row["course_code"];
                    $sec_no = $row["sec_no"];
                    $semester = $row["semester"];
                    $year = $row["year"];
					$username=$row['username'];
					$ass_course_id=$row['assigned_course_id'];
		
					echo "<tr>";
		            echo "<th>Course Code: </th>"."<td>".$row["course_code"]."</td>";
		                            
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
				</tbody>
		 </table>
<?php
if(isset($_POST['add_1'])){
	function test_input($data){
		$data = trim($data); 
		$data = stripslashes($data); 
		$data = htmlspecialchars($data);  
		return $data;
	}	
	$flag='a';
	$co_text=mysqli_real_escape_string($connection, $_POST['co_text']);
	$co_text=test_input($co_text);

	$co_marks=mysqli_real_escape_string($connection, $_POST['co_marks']);
	$co_marks=test_input($co_marks);

	        //CO code and Text validation
	        if(empty($_POST['co_text'])){
	       		$errors['co_text']="Enter CO Text";
				echo '<script type="text/javascript">'; 
               	echo 'setTimeout(function () {  swal("'.$errors['co_text'].'");';
                echo '},300);</script>';
			}
			
			else if(empty($_POST['co_marks'])){
				$errors['co_marks']="Please Enter CO Marks";
				echo '<script type="text/javascript">'; 
                echo 'setTimeout(function () {  swal("'.$errors['co_marks'].'");';
                echo '},300);</script>';
			}
			
			if(count($errors)==0){
				header('Location:co_setup.php?value1='.$id.'&value2='.$flag.'&value3='.$co_text.'&value4='.$co_marks.'&value5='.$username);
			}
		}
	
if(isset($_POST['edit_1'])){
	$row_id=$_POST['edit_1'];
	$flag='1';
	header('Location:edit_co_po.php?value1='.$row_id.'&value2='.$flag.'&value5='.$username.'&value6='.$course_code.'&value7='.$sec_no.'&value8='.$semester.'&value9='.$year);
}
	
if(isset($_POST['edit_tr'])){
	$row_id=$_POST['edit_tr'];
	$flag='2';
	header('Location:edit_co_po.php?value1='.$row_id.'&value2='.$flag.'&value5='.$username.'&value6='.$course_code.'&value7='.$sec_no.'&value8='.$semester.'&value9='.$year);
}	
if(isset($_POST['edit_po'])){
	$flag='3';
	header('Location:edit_co_po.php?value2='.$flag.'&value5='.$username.'&value6='.$course_code.'&value7='.$sec_no.'&value8='.$semester.'&value9='.$year);
	}
				
?>
<div class="table-responsive">
	<form method="POST">
		<table class="table table-striped" border="1px solid black">
			<thead>				
				<tr>
					<th colspan="5">Add Course Outcome (CO)</th>
				</tr>
				<tr>
					<th>CO</th>
					<th>Course Outcome</th>
					<th>CO Marks</th>
					<th colspan="2">Action</th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td></td>
					<td><input type="text" name="co_text"></td>
					<td><input type="text" name="co_marks"></td>
					<td colspan="2"><button type="submit" name="add_1"   class="btn btn btn-danger btn-md" style="font-size:12px"><i class="fa fa-plus-circle"></i></button></td>
				</tr>
				<?php
					$sql = "SELECT * FROM assigned_course a JOIN co c join faculty f WHERE a.assigned_course_id=c.assigned_course_id AND f.faculty_id=a.faculty_id and f.username='$username' AND c.assigned_course_id='$id'";
				$co_sum = 0;
					$result = mysqli_query($connection,$sql);
					if(mysqli_num_rows($result)>0){
						while ($row = mysqli_fetch_array($result)) {
							$co_sum+= $row['co_marks'];
							echo "<tr>";
							echo "<td>".$row['co_code']."</td>";
							echo "<td>".$row['co_text']."</td>";
							echo "<td>".$row['co_marks']."</td>";
				?>
				<td colspan="2"><button type="submit" name="edit_1" value="<?php echo $row['co_id']; ?>"  class="btn btn btn-danger btn-sm" style="font-size:16px"><i class="fa fa-edit"></i></button></td>
				<?php
							echo "</tr>"; 
							 }
						}
                			if($co_sum<=100)
                           		echo "<tr><td colspan='5'>Total CO: ".$co_sum."% </td></tr>";
							if($co_sum!=100)
								echo "<tr><td colspan='5'>Total CO marks sould be 100</td></tr>";
                    ?>
					</tbody>
                </table>
			</form>
		</div>
<div class="table-responsive">
	<form method="POST">
		<table class="table table-striped" border="1px solid black">
			<thead>
				<tr>
					<th colspan="3">CO Treshold</th>
				</tr>
			</thead>
			<tbody>			
			<tr>
				<td>Treshold</td>
				<td><input type="text" name="tr"></td>
				<td colspan="2"><button type="submit" name="add_tr" value="<?php echo $row['id']; ?>"  class="btn btn btn-danger btn-md" style="font-size:12px"><i class="fa fa-plus-circle"></i></button></td>
			</tr>
			<tr>
				<?php 
					$query="SELECT * FROM assigned_course a JOIN co WHERE a.assigned_course_id=co.assigned_course_id and co.assigned_course_id='$ass_course_id' and  co.co_code='CO1'";
						if($result_q = mysqli_query($connection,$query)){
					if(mysqli_num_rows($result_q)>0){
						$row_q = mysqli_fetch_array($result_q);
							echo "<td>Given threshold</td>";
							echo "<td>".$row_q['co_tr']."</td>";

				?>
				<td colspan="2"><button type="submit" name="edit_tr" value="<?php echo $row_q['co_id']; ?>"  class="btn btn btn-danger btn-sm" style="font-size:16px"><i class="fa fa-edit"></i></button></td>
			<?php }
			}
		?>
			</tr>
			</tbody>
		</table>
	</form>
</div>
<?php
			$sql2="SELECT * FROM assigned_course a JOIN co join faculty f 
					WHERE a.assigned_course_id=co.assigned_course_id and a.faculty_id=f.faculty_id and f.username='$username' and co.assigned_course_id='$ass_course_id'";
				if($result2=mysqli_query($connection,$sql2)){
				if(mysqli_num_rows($result2)>0){
				$row_num2=mysqli_num_rows($result2);
				}
			}
			$flag=0;
			?>
<div class="table-responsive">
	<form method="POST">
		<table class="table table-striped" border="1px solid black">
			<thead>
			<?php
			echo "<tr><th colspan='13'>Selected Course</th></tr>";
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
			<td colspan="13"><button name="button" class="btn btn btn-danger btn-md">ADD</button>
			<button type="submit" name="edit_po" value="<?php echo $row['assigned_course_id']; ?>"  class="btn btn btn-danger btn-sm" style="font-size:16px"><i class="fa fa-edit"></i></button></td>
		</tr>
            <?php
			echo "</tbody>";
			echo "</table>";
			echo "</form>";
			echo "</div>";
			$sql3="SELECT * FROM assigned_course a JOIN mapping m join po p JOIN faculty f join co c
					WHERE a.assigned_course_id=m.assigned_course_id and f.faculty_id=a.faculty_id and m.po_id=p.po_id and m.co_id=c.co_id and  f.username='$username' AND a.assigned_course_id='$id'";
				
			?>
	<div class="table-responsive">
		<table class="table table-striped" border="1px solid black">
			<thead>
			<?php
				echo "<tr><th colspan='2'>PO Table</th></tr>";
				echo "</thead>";
				echo "<tbody>";
				$data = array();
				if($result3=mysqli_query($connection,$sql3)){
					if(mysqli_num_rows($result3)>0){
						echo "<tr>";
							echo "<td style='text-align:left;'>";
						for ($i=1; $i <=$row_num2 ; $i++) { 
							echo "<br>".$co_codes='CO'.$i." - ";
						
						while ($row3 = mysqli_fetch_array($result3)){
							$po_code=$row3['po_code'];
							$co_id=$row3['co_id'];
						
						$sql31="SELECT * FROM mapping 
						WHERE assigned_course_id='$id' and co_id='$co_id'";
						if($result31=mysqli_query($connection,$sql31)){
					if(mysqli_num_rows($result31)>0){
						while ($row31 = mysqli_fetch_array($result31)){
						// echo 'PO'.$row31['po_id'].', ';	
							// array_push($data,"$row31['po_id']");
							// print_r($data );
							//break;
							// $data[]=array($row3['po_code']);
							// foreach($data as $d)
							// {
							//    echo $d[0];
							// }
						}}
						//continue;	// echo ', <br>';
						}
						continue;
						break;
					}

							// echo $row3['po_code'].', ';
							// $sql4="SELECT b.mapping_co_code FROM assigned_course a INNER JOIN mapping b
							// ON a.id = b.assigned_course_id  WHERE a.username='$username' AND a.id='$id'";
							// 	if($result4=mysqli_query($connection,$sql4)){
							// 		if(mysqli_num_rows($result4)>0){
										//$i=0;
										
										//while ($row4 = mysqli_fetch_array($result4)){
										// foreach ($co_codes as $co_code) {
										// 	echo $row3['co_code']." &nbsp;&nbsp;";
										// 	$i++;	
										// }
											//echo $row3['co_code']." &nbsp;&nbsp;";
											//$i++;
											
										}
										//echo "<span style='color:#e62626;'>";
										//echo "Total CO: ".$i;
										//echo "</span>";
									}
								}
								echo "</td>";
								echo "</tr>";
					// 		}
					// 	}
					// }
					echo "</tbody>";
				echo "</table>";
			?>

<div class="table-responsive">
		<table class="table table-striped" border="1px solid black">
			<thead>
			<?php 
				$sql1="SELECT * FROM po";
				if($result1=mysqli_query($connection,$sql1)){
		       		echo "<tr>"."<th colspan='2'>Program Outcome</th>"."</tr></thead>";
		       		if(mysqli_num_rows($result1)>0){
		       			$row_num1=mysqli_num_rows($result1);
		       			while ($row1 = mysqli_fetch_array($result1)){
							echo "<tbody>";
		       				echo "<tr>";
		       				echo "<td>".$row1['po_code']."</td>";
		       				echo "<td style='text-align:left;'>".$row1['po_text']."</td>";
		       				echo "</tr>";
						   }
						   echo "</tbody>";
						   echo "</table>"; 
						   echo "</div>";
					}
				}
				?>
		</div>
	</div>
		</body>
		</html>
<?php 

	if(isset($_POST['button'])){
   		if(isset($_POST['check'])){
   			foreach($_POST['check'] as $check){
	        	$x=$check;
	        	$pieces = explode(" ", $x);
	        	$co= $pieces[0];
				$po= $pieces[1];
	        	$sql = "SELECT * FROM assigned_course a JOIN mapping m join co join po 
						WHERE a.assigned_course_id=m.assigned_course_id  and  m.co_id=co.co_id and m.po_id=po.po_id AND  a.assigned_course_id='$id'";
				if($result = mysqli_query($connection,$sql)){
	            if(mysqli_num_rows($result) >= 0){
	            	
	                while($row=mysqli_fetch_array($result)){
						$ass_course_id=$row['assigned_course_id'];
						$co_id=$row['co_id'];
						$po_id=$row['po_id'];
	                    foreach($_POST['check'] as $check) {
	                        if($row['co_code']==$co && $row['po_code']==$po){
	                            echo '<script type="text/javascript">';
	                            echo 'setTimeout(function () {  swal("You have already Selected PO for the CO !!!");';
	                            echo '},600);</script>';
	                             exit();
	                    }
	                }
	            }
			
				$s1="SELECT * FROM assigned_course a join co WHERE a.assigned_course_id=co.assigned_course_id AND co.co_code='$co' and a.assigned_course_id='$id'";
				if($r1 = mysqli_query($connection,$s1)){echo "string";
					if(mysqli_num_rows($r1) > 0){
	                while($row=mysqli_fetch_array($r1)){
	                	$co_id=$row['co_id'];
	                	$s2="SELECT * FROM po WHERE po_code='$po'";
	                	if($r2 = mysqli_query($connection,$s2)){
							if(mysqli_num_rows($r2) > 0){
	                			while($row=mysqli_fetch_array($r2)){
								$po_id=$row['po_id'];
	        	$sql3="INSERT INTO mapping(assigned_course_id,co_id,po_id)VALUES('$ass_course_id','$co_id','$po_id')";
	                    if(mysqli_query($connection,$sql3)){
	                        echo '<script type="text/javascript">'; 
	                        echo 'setTimeout(function () {  swal("Successfully Selected");';
	                        echo '},600);</script>';
					}
					else echo mysqli_error($connection);
			}}}}}}
		}
	}
}
	}
}

		   
if(isset($_POST['add_tr'])){
	$errors=array();
	function test_input($data){
		$data = trim($data); 
		$data = stripslashes($data); 
		$data = htmlspecialchars($data);  
		return $data;
	}	
	$tr=mysqli_real_escape_string($connection, $_POST['tr']);
	if(empty($_POST['tr'])){
		$errors['tr']="Please Enter CO threshold";
		echo '<script type="text/javascript">'; 
		echo 'setTimeout(function () {  swal("'.$errors['tr'].'");';
		echo '},300);</script>';
	}
	if(count($errors)==0){
		$sql5="SELECT * FROM assigned_course a JOIN co
			WHERE a.assigned_course_id=co.assigned_course_id and co.assigned_course_id='$ass_course_id' and co.co_code='CO1'";
		if($result5 = mysqli_query($connection,$sql5)){
			if(mysqli_num_rows($result5) >= 0){
				while($row5=mysqli_fetch_array($result5)){
					if(!empty($row5['co_tr'])){
						echo '<script type="text/javascript">'; 
						echo 'setTimeout(function () {  swal("You have already selected CO threshold");';
						echo '},300);</script>';
						exit();
					}
					else{
						echo $row_id=$row5['co_id'];
						$sql4="UPDATE co SET co_tr='$tr' WHERE co_id='$row_id'";
						$result4 = mysqli_query($connection,$sql4);
					}
				}
			}
		}
	}
}


?>
<center>
<button name="button" class="btn btn-dark"><a href="select_course.php">Back</a></button>
</center>