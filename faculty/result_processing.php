<script src="js/jquery-3.2.1.min.js"></script>
<script src="js/sweetalert.min.js"></script>
<?php
	include_once("db.php");
	$id=$_GET['value1'];
    $select_component=$_GET['value2'];
    $co_marks1 = $_GET['value3'];
    $co_marks=unserialize($co_marks1);
    print_r($co_marks);
    $username = $_GET['value4'];
    $i=0;
    $add=0;


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
                    $credit=$row["credit"];
					
	   
	   
		        $sql6="SELECT * FROM co c join st_en s join marks_component m join comp com WHERE com.comp_id=m.comp_id and  c.assigned_course_id = s.assigned_course_id AND m.assigned_course_id=s.assigned_course_id AND m.assigned_course_id ='$ass_course_id'	and com.component='$select_component'";
				if($result6=mysqli_query($connection,$sql6)){
					if(mysqli_num_rows($result6)>0){
					 	$row_num = mysqli_num_rows($result6);
						while ($row6 = mysqli_fetch_array($result6)){
						$co_id=$row6['co_id'];
						$s_id=$row6['st_en_id'];
						$comp_id=$row6['comp_id'];
						//for ($row=1; $row <= $row_num; $row++) {
						//	$co_for_component='CO'.$row;
						
						 /*   $sql6="SELECT co_code FROM course_outcome WHERE  course_code='$course_code' AND  sec_no='$sec_no' AND semester='$semester' AND year='$year' ";
							if($result6=mysqli_query($connection,$sql6)){
								if(mysqli_num_rows($result6)>0){
									$row_num = mysqli_num_rows($result6);
								}
							}*/
						
					// if( $i < count($co_marks)){
				 //      	$sql1 = "INSERT INTO res_process(assigned_course_id,st_en_id,	component_id,co_id,co_marks,mark_w) 
					//   	VALUES('$ass_course_id','$s_id','$comp_id','$co_id','$co_marks[$i]','$co_marks[$i]')";
				 //       if($ins=mysqli_query($connection,$sql1)){
				 //       		$i=$i+1;
				 //       	}
					// }       		
					       	
					       		
						  //break;     
							
						// }
						// if($co_marks[$i]=='W'){
					 //      	$sql1 = "INSERT INTO res_process(assigned_course_id,st_en_id,	component_id,co_id,mark_w) 
						//   	VALUES('$ass_course_id','$s_id','$comp_id','$co_id','$co_marks[$i]')";
					 //       	$ins=mysqli_query($connection,$sql1);
						       
						// 	$i=$i+1;
						// }
						} 
				    }  
    			}


   $sql3="SELECT * FROM st_en WHERE assigned_course_id='$ass_course_id' 
   ";
			if($result3=mysqli_query($connection,$sql3)){
				if(mysqli_num_rows($result3) > 0){
        	while($row3 = mysqli_fetch_array($result3)){
			        	$s_id=$row3['st_en_id'];
    $sql12="SELECT sum(r.co_marks),c.comp_id  FROM res_process r join comp c WHERE r.component_id=c.comp_id and  r.assigned_course_id='$ass_course_id' AND c.component='$select_component' AND r.st_en_id='$s_id'";
	if($result12 = mysqli_query($connection,$sql12)){
			if(mysqli_num_rows($result12) > 0){
				$row12=mysqli_fetch_array($result12);
					$sum_component=$row12['sum(r.co_marks)'];
					$comp_id=$row12['comp_id'];
	        	$sql13="UPDATE res_process SET tot_marks='$sum_component' WHERE assigned_course_id='$ass_course_id' AND st_en_id='$s_id' AND component_id='$comp_id' AND co_id='1'";
				$result13 = mysqli_query($connection,$sql13);
				$sql141="SELECT * FROM grade WHERE grade='W'";
				if($result141 = mysqli_query($connection,$sql141)){
			if(mysqli_num_rows($result141) > 0){
				$row141=mysqli_fetch_array($result141);
						$grade=$row141['grade_id'];
						$sql14="SELECT st_en_id FROM res_process WHERE assigned_course_id='$ass_course_id' AND mark_w='W'";
						if($result14 = mysqli_query($connection,$sql14)){
					if(mysqli_num_rows($result14) > 0){
						while($row14=mysqli_fetch_array($result14)){
							$s=$row14['st_en_id'];
						$sql15="UPDATE st_en SET grade_id='$grade' WHERE assigned_course_id='$ass_course_id' AND st_en_id='$s'";
						if($result15 = mysqli_query($connection,$sql15)){
						}
							}
						}
					}
				}
			}
		}
	}

}
   header('Location:result_submission.php?value='.$id);      
							}
							
						}
}
}
			
 
?>