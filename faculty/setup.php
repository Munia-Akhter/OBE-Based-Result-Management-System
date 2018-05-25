<?php
	include_once("db.php");
    session_start();
    $username= $_SESSION['username'];
	$id=$_GET['value1'];
    $co_marks1 = $_GET['value3'];
    $marks1=$_GET['value2'];
   
    $co_marks=unserialize($co_marks1);
    $marks3=unserialize($marks1);
    $k=0;
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

    
                $sql3="SELECT *
                    FROM course c join offered_course o join assigned_course a join semester s join  faculty f join co
                    WHERE c.course_id = o.course_id and o.offered_course_id=a.offered_course_id and 
                    a.semester_id=s.semester_id and a.assigned_course_id=co.assigned_course_id
                    AND c.course_code =  '$course_code'
                    AND a.sec_no =  '$sec_no'
                    AND s.semester =  '$semester'
                    AND o.year =  '$year'
                    AND f.username =  '$username'";
            if($result3=mysqli_query($connection,$sql3)){
                if(mysqli_num_rows($result3)>0){
                $row_num2=mysqli_num_rows($result3);
                $marks=array_chunk($co_marks,$row_num2);
            $sum=0;
            $sql1="SELECT * FROM marks_component where assigned_course_id=' $ass_course_id'";
            if($result1=mysqli_query($connection,$sql1)){
                if(mysqli_num_rows($result1)>0){
                    $row_num1=mysqli_num_rows($result1);
                    foreach ($marks as $row) {
                        for ($i=0; $i<count($row); $i++){ 
                            $sum+=$row[$i];
                    }
                    $sum;
                     while($row1=mysqli_fetch_array($result1)){
                        $component=$row1['marks_component_id'];
                       
                        $sql2="UPDATE marks_component SET cc_marks='$sum' WHERE assigned_course_id=' $ass_course_id' AND marks_component_id='$component'";  
                        $result = mysqli_query($connection,$sql2);
                        
                       
                        break;
                    }
                    $sum=0;  
                }
            }
        }
      $ratio=0;
        $sql2="SELECT * FROM marks_component where assigned_course_id='$ass_course_id' And ratio IS NULL";
            if($result2=mysqli_query($connection,$sql2)){
                if(mysqli_num_rows($result2)>0){
                      $row_num2=mysqli_num_rows($result2);
                    foreach ($marks3 as $marks) {
                        while($row2=mysqli_fetch_array($result2)){
                            $component=$row2['comp_id'];
                            $cc_marks=$row2['cc_marks'];
                            $ratio=sprintf('%0.2f',$marks/$cc_marks);
                            //echo $cc_marks;echo "string";
                            //print_r($marks);
                            echo $ratio;
                            $sql3="UPDATE marks_component SET ratio='$ratio' WHERE assigned_course_id=' $ass_course_id' AND comp_id='$component'";
                            $result = mysqli_query($connection,$sql3); 

                            break;
                        }
                        $ratio=0;
                    }
                }
            }
        }
    } 
   header('Location:course_setup.php?value='.$id);           
?>