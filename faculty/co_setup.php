<?php include("db.php");
	session_start();
	$username=$_SESSION['username'];
?>
<!DOCTYPE html>
<html>
<head>
    <title>Course</title>
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
<body>
</body>
</html>
<?php
	include_once("db.php");
	$id=$_GET['value1'];
    $flag=$_GET['value2'];
    $username = $_GET['value5'];
 
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
		}
	}
	if($flag=='a'){
		$co_text = $_GET['value3'];
    	$co_marks = $_GET['value4'];
		$co_sum = 0;
		
        $sql1 = "SELECT * FROM assigned_course a join co WHERE a.assigned_course_id=co.assigned_course_id and co.assigned_course_id='$ass_course_id'";
        //SELECT * FROM course c join offered_course o join assigned_course a join semester s join co WHERE c.course_id=o.course_id and o.offered_course_id=a.offered_course_id and a.semester_id=s.semester_id and c.course_code='$course_code' AND a.sec_no='$sec_no' AND s.semester='$semester' AND o.year='$year'
       	if($result=mysqli_query($connection,$sql1)){
           	while($row = mysqli_fetch_array($result)){
               	  $co_sum += $row['co_marks'];
                		$co_code=$row['co_code'];
                		if($row['co_text']==$co_text){
							echo '<script type="text/javascript">';
							echo 'setTimeout(function () {  swal("You have already assigned'.$co_code.'");';
							echo '},300);</script>';
							?>
		 					<script>
								var id="<?php echo $id;?>";
								setTimeout(function () {  
								window.location.replace("co_po.php?value=" + id);
								},3000);
		 						</script>
		 					<?php
		                }

		                
               }
           }

           if(($co_sum+$co_marks)>100){
		                	$diff = ($co_sum+$co_marks)-100;
				            echo '<script type="text/javascript">'; 
				            echo 'setTimeout(function () {  swal("You have added '.$diff.' marks more");';
							echo '},600);</script>';
							?>
		 					<script>
								var id="<?php echo $id;?>";
								setTimeout(function () {  
									window.location.replace("co_po.php?value=" + id);
								},3000);
		 						</script>
		 					<?php

		                }
    	  	if(($co_sum+$co_marks)<=100){
    	  	//echo $co_sum; //100)||($co_sum+$co_marks)<
					$sql1 = "SELECT * FROM assigned_course a JOIN co c join faculty f WHERE a.assigned_course_id=c.assigned_course_id AND f.faculty_id=a.faculty_id and f.username='$username' AND c.assigned_course_id='$id'";
					$result1= mysqli_query($connection,$sql1);
						$row_num=mysqli_num_rows($result1);

						while($row1=mysqli_fetch_array($result1)){
							$ass_course_id=$row1['assigned_course_id'];
						}
						if($row_num==0){
							$co_code="CO1";
						}
						if($row_num>0){
							for($i=2;$i<=($row_num+1);$i++){
								$co_code="CO".$i;
								}
							}
							echo $ass_course_id. $co_code. $co_text .$co_marks;			
						$sql2 = "INSERT INTO co(assigned_course_id,	co_code,	co_text,co_marks,rest_co_marks ) VALUES('$ass_course_id','$co_code','$co_text','$co_marks','$co_marks')";
						if(mysqli_query($connection,$sql2)){echo "string";
						
							echo '<script type="text/javascript">'; 
							echo 'setTimeout(function () { 	swal("Course outcome have been setup");';
							echo '},300);</script>';
							header('Location:co_po.php?value='.$id.'&abc='.$username);
							?>
							<script>
								var id="<?php echo $id;?>";
								setTimeout(function () {  
									window.location.replace("co_po.php?value=" + id);
								},3000);
								</script>
							<?php

					// 	$sql4="SELECT distinct component FROM marks_component WHERE course_code='$course_code' AND sec_no='$sec_no' AND semester='$semester' AND year='$year'";
					// 	if($result=mysqli_query($connection,$sql4)){
					// 		if(mysqli_num_rows($result) > 0){
					//            	while($row4=mysqli_fetch_array($result)){
			  //              		$row_num=mysqli_num_rows($result);
					// 				$co_marks=0;	
					// 				$component=$row4['component'];
					
				 //        		$sql3 = "INSERT INTO marks_distribution(course_code,sec_no,semester,year,component,co_for_component,co_marks) VALUES('$course_code','$sec_no','$semester','$year','$component','$co_code','$co_marks')";
					// 				if(mysqli_query($connection,$sql3)){
					            	
					// 				}
					
					// 			}
					// 		}
					// 	}
					// }
					

			        }
			}
		}
		
?>