<?php 
include("db.php");
session_start();
$username=$_SESSION['username'];
?>
<!DOCTYPE html>
<html>
<head>
	<title>Student po</title>
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
                    <?php 
	
			 
    $sql1 = "SELECT distinct a.course_code, a.sec_no, a.semester, a.year, a.id, c.title, c.credit
FROM assigned_course a, student_enrollment b, course c
WHERE a.id = b.assigned_course_id
AND a.course_code = c.course_code";
                    if($result=mysqli_query($connection,$sql1)){
                        if(mysqli_num_rows($result)>0){
                            $row=mysqli_fetch_array($result);   
                            while($row = mysqli_fetch_array($result)){

                            
                   	$course_code = $row["course_code"];
                    $sec_no = $row["sec_no"];
                    $semester = $row["semester"];
                    $year = $row["year"];
                    $ass_course_id=$row['id'];
                    $title=$row["title"];
                    $credit=$row["credit"];
					
}}


$sql2="SELECT * FROM student_enrollment a,percent_of_co b where a.s_id=b.s_id and a.assigned_course_id='$ass_course_id' and b.course_code='$course_code' and b.sec_no='$sec_no' and b.semester='$semester' and b.year='$year'";
			    if($result2=mysqli_query($connection,$sql2)){
			        if(mysqli_num_rows($result2)>=0){
			        	$row_num=mysqli_num_rows($result2);
			        	//while ($row = mysqli_fetch_array($result2)){
	   
					if(mysqli_num_rows($result2)==0){

						$sql12="SELECT * FROM student_enrollment where assigned_course_id='$ass_course_id'";
			    if($result12=mysqli_query($connection,$sql12)){
			        if(mysqli_num_rows($result12)>0){
			        	$row_num=mysqli_num_rows($result12);
			        	while ($row12 = mysqli_fetch_array($result12)){
			        		 $s_id=$row12['s_id'];

			        $sql3="SELECT mapping_co_code,mapping_po_code FROM mapping WHERE assigned_course_id='$ass_course_id'";
					if($result3=mysqli_query($connection,$sql3)){echo $ass_course_id;
						if(mysqli_num_rows($result3)>0){echo "string";
							while ($row3 = mysqli_fetch_array($result3)) {
								echo $co=$row3['mapping_co_code'];
								$po=$row3['mapping_po_code'];

		   		 				$sql4 = "INSERT INTO percent_of_co
									(s_id,course_code,sec_no,semester,year,co,po) VALUES('$s_id','$course_code','$sec_no','$semester','$year','$co','$po')";
						        if($ins4=mysqli_query($connection,$sql4)){
						        }
							}
						}
					}
				}
			}
		}
}
	$sql3="SELECT b.co_code , a.course_code
                        FROM assigned_course a, course_outcome b
                        WHERE b.assigned_course_id = a.id
                        AND a.course_code =  '$course_code'
                        AND a.sec_no =  '$sec_no'
                        AND a.semester =  '$semester'
                        AND a.year =  '$year'";
                    if($result3=mysqli_query($connection,$sql3)){
                        if(mysqli_num_rows($result3)>0){
                            $row3 = mysqli_fetch_array($result3);
                                 $row_num2=mysqli_num_rows($result3);

				$s1="SELECT * FROM student_enrollment where assigned_course_id='$ass_course_id'";
			    if($r1=mysqli_query($connection,$s1)){
			        if(mysqli_num_rows($r1)>0){
			        	$row_num=mysqli_num_rows($r1);
			        	while ($r12 = mysqli_fetch_array($r1)){
			        		 $s_id=$r12['s_id'];
	 for ($row=1; $row <= $row_num2; $row++) {
                    $a='CO'.$row;
					$sql7="SELECT co_per FROM  co_attainment_individual WHERE s_id='$s_id'  AND course_code='$course_code' AND sec_no='$sec_no' AND semester='$semester' AND year='$year' AND co='$a'";
					if($result7=mysqli_query($connection,$sql7)){
		        		if(mysqli_num_rows($result7)>0){
		        			while ($row7 = mysqli_fetch_array($result7)){
		        					$co_per=$row7['co_per'];

								$query9 = "UPDATE percent_of_co  SET percent_co='$co_per' WHERE s_id='$s_id' AND course_code='$course_code' AND sec_no='$sec_no' AND semester='$semester' AND year='$year' AND co='$a'";
								if($result9 = mysqli_query($connection, $query9)){
				
								}
							}
						}
					}
				}

				for ($row=1; $row <= $row_num2; $row++) {
					$a='CO'.$row;
					$sql11="SELECT DISTINCT po FROM  percent_of_co  WHERE s_id='$s_id' And course_code='$course_code' AND sec_no='$sec_no' AND semester='$semester' AND year='$year' AND percent_co >=70";
					$datas=array();					
						if($result11=mysqli_query($connection,$sql11)){
        					if(mysqli_num_rows($result11)>0){
        						while ($row11 = mysqli_fetch_array($result11)){
									$po=$row11['po'];
									$datas[]=$row11['po'];
									$unique= array_unique($datas);
									$d=implode(", ", $unique);

									$query12 = "UPDATE percent_of_co  SET accepted_po='$d' WHERE s_id='$s_id' AND course_code='$course_code' AND sec_no='$sec_no' AND semester='$semester' AND year='$year' AND co='$a'";
									if($result12 = mysqli_query($connection, $query12)){
										$sql13="SELECT DISTINCT accepted_po, course_code
											FROM percent_of_co
											WHERE s_id =  '$s_id'
											AND co =  'CO1'";
							
										if($result13=mysqli_query($connection,$sql13)){
		        							if(mysqli_num_rows($result13)>0){
		        								while ($row13 = mysqli_fetch_array($result13)){echo "string";
													echo $datas3=$row13['accepted_po'];
													$g=explode(", ", $datas3);
													$unique3= array_unique($g);
													echo $margepo=implode(", ", $unique3);
													$query12 = "UPDATE percent_of_co  SET al_accepted_po='$margepo' WHERE s_id='$s_id' AND course_code='$course_code' AND sec_no='$sec_no' AND semester='$semester' AND year='$year' AND co='CO1'";
									if($result12 = mysqli_query($connection, $query12)){
									}}}}
												}
											}
										}
									}				
								}
						
						$sql12="SELECT DISTINCT po FROM  percent_of_co  WHERE s_id='$s_id' And course_code='$course_code' AND sec_no='$sec_no' AND semester='$semester' AND year='$year' AND percent_co <70";
						$datas=array();					
							if($result12=mysqli_query($connection,$sql12)){
	        					if(mysqli_num_rows($result12)>0){
	        						while ($row12 = mysqli_fetch_array($result12)){
									$po=$row12['po'];
										$datas[]=$row12['po'];
										$unique= array_unique($datas);
										$e=implode(", ", $unique);

										$query13 = "UPDATE percent_of_co  SET rejected_po='$e' WHERE s_id='$s_id' AND course_code='$course_code' AND sec_no='$sec_no' AND semester='$semester' AND year='$year' AND co='CO1'";

										if($result13 = mysqli_query($connection, $query13)){
										$sql14="SELECT distinct accepted_po, rejected_po FROM  percent_of_co  WHERE s_id='$s_id' And course_code='$course_code' AND sec_no='$sec_no' AND semester='$semester' AND year='$year' AND co='CO1'";
										$datas1=array();	
										if($result14=mysqli_query($connection,$sql14)){
				        					if(mysqli_num_rows($result14)>0){
				        						while ($row14 = mysqli_fetch_array($result14)){
				        							$accepted=$row14['accepted_po'];
				        							$rejected=$row14['rejected_po'];
				        							$f=explode(", ", $accepted);
			        								$g=explode(", ", $rejected);
			        					
			        								$unique2= array_diff($g,$f);
			        						
			        								$h=implode(", ", $unique2);
			        								$query15 = "UPDATE percent_of_co  SET rejected_po='$h' WHERE s_id='$s_id' AND course_code='$course_code' AND sec_no='$sec_no' AND semester='$semester' AND year='$year' AND co='$a'";
				        							if($result15 = mysqli_query($connection,  $query15));
				        								if($result14=mysqli_query($connection,$sql14)){
							        						if(mysqli_num_rows($result14)>0){
							        							while ($row14 = mysqli_fetch_array($result14)){
								        							$rejectedpo=$row14['rejected_po'];
								        							$accepted_po=$row14['accepted_po'];
		        												}
		        											}
		        										}
													}				
												}
											}
										}        				
									}	}
						}
					}}}			}}}}}
					
				
header('Location:st_marks.php?value='.$id);					
?>