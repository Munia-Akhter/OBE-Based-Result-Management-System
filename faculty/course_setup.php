<?php 
include("db.php");
session_start();
$username=$_SESSION['username'];
?>
<!DOCTYPE html>
<html>

<head>
    <title>Course Setup</title>
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
                            <a href="select_course.php" class="btn btn-info"> Mapping Course</a>
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

<?php 
 if(isset($_POST['button'])){
  // if(isset($_POST['check'])){
  //       $sql = "SELECT * from marks_component m join comp c where m.comp_id=c.comp_id and assigned_course_id='$ass_course_id'"; 
  //       if($result = mysqli_query($connection,$sql)){
  //           if(mysqli_num_rows($result) > 0){
  //               while($row=mysqli_fetch_array($result)){
  //                   foreach($_POST['check'] as $check) {
  //                       if($row['component']==$check){
  //                           echo '<script type="text/javascript">';
  //                           echo 'alert("You have already Selected Components for the section !!!");</script>';
  //                          echo ("<script>location.href='select_course.php'</script>");
  //                        }
  //                   }
  //               }
  //           }
  //       }
  //   }
            
    if(isset($_POST['co_marks'])){ //echo "string";
        $id = $_GET["value"];
        $username1 = $username;
        $co_marks11=$_POST['co_marks']; //must be 100
        $marks11=$_POST['con_marks'];
       
        $co_marks_sum=array_sum($co_marks11); //must be 100
        $marks_sum=array_sum($marks11); 
       
        $co_marks1=array();
        $marks1=array();
        $x1=array();
        $k=0;
        $w=0;
        $l=0;
        $b=0;
        $j=0;
        $add=0;
        $count=0;
        $flag=0;
        $x=0;
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
                    $c=$row_num2;
                   while($row3=mysqli_fetch_array($result3)){
                       $course_outcome_id=$row3['co_id'];

                          for($i=$l;$i<count($co_marks11);$i++){
                            for($a=$b;$a<$c;$a++){
                                $co_marks11[$b]; ;
                                $count+=$co_marks11[$b]; 
                                
                                $b++;   
                            }   
                            if($count==0){
                               for($a=$b-4;$a<$c;$a++){
                                    unset($co_marks11[$b]);
                                $b++;   
                               }     
                            }
                            
                        //echo  $count.'='.$b.'=='.$i.'<br>';
                        $c+=$row_num2;
                        $l+=$row_num2;
                        $i=$b;

                        $count=0;
                      
                        }
                        $c_com=0;
                         foreach($_POST['check'] as $check) {
                            $c_com++;
                         }
                        
                        $m1=0;
                        $co_marks1 = array_values($co_marks11);

                      
                       
                          for ($ij = 0; $ij < $c_com*$row_num2; $ij++) {
                         
                            //if ($co_marks1[$ij] != 0) {
            $x1[$m1] = $co_marks1[$ij]; // if true, populate new array with value
            $m1++;
       //}
      }



                        $co_marks2=serialize($x1);
                        
                   // print_r($x1);
                        for($q=$w;$q<count($marks11);$q++){
                            
                                $count=$marks11[$w]; 
                                if($count==0){
                                    unset($marks11[$w]);
                                }
                                $w++;   
                                $count=0;
                            }   
                             $marks1 = array_values($marks11);
                           
                             //print_r($co_marks1);
                             $marks2=serialize($marks1);
                          

                        for($p=$j;$p<count($x1);$p+=$row_num2){
                            $add+=$co_marks1[$p];
                            //$add-='5';
                            //echo  $add;
                        }
                        
                        $j++;


                       
      // echo $add.'='.$row3['co_marks'].'===='.$co_marks_sum.'   ';
        
       
      //                 if( $add>$row3['co_marks'] && $co_marks_sum!=100 ){
      //                       echo '<script type="text/javascript">';
      //                       echo 'setTimeout(function () {  swal("'.$add.'is more then fixed value of CO which is: '.$row3["co_marks"].' ");';
      //                       echo '},600);</script>';
      //                       break;
      //                       header('Location:select_course.php');
      //                       }

      //                   if($co_marks_sum!=100 && ($row3['co_marks']>$add|| $add==0)){
      //                       echo '<script type="text/javascript">';
      //                       echo 'setTimeout(function () {  swal("'.$add.' is less then  fixed value value of CO Which is:'.$row3["co_marks"].' ");';
      //                       echo '},600);</script>';
      //                       break;
      //                      echo ("<script>location.href='select_course.php'</script>");
      //                   }
      //                   if( $co_marks_sum==100 && ($row3['co_marks']>$add || $row3['co_marks']<$add)){
      //                       echo '<script type="text/javascript">';
      //                       echo 'setTimeout(function () {  swal("Each CO value should be equal to the fixed CO values '.$row3["co_marks"].'");';
      //                       echo '},600);</script>';
      //                       break;
                       
      //                   } 
      //                  /*  if( $marks_sum!=100 && $co_marks_sum==100 ){
      //                       echo '<script type="text/javascript">';
      //                       echo 'setTimeout(function () {  swal("Total weight needs to be 100");';
      //                       echo '},600);</script>';
      //                       break;
                       
      //                   }*/
      //                   $add=0;
                        
}                        
    
        // if($co_marks_sum==100){echo "string";
          $flag=1;
        foreach($_POST['check'] as $check) {
            $component=$check;
        $s3="SELECT * FROM comp where component='$component' ";
        if($r3=mysqli_query($connection,$s3)){
                    if(mysqli_num_rows($r3)>0){
                         while($row3=mysqli_fetch_array($r3)){
                           $component_id=$row3['comp_id'];
        // $sql = "INSERT INTO marks_component(assigned_course_id,comp_id) VALUES('$ass_course_id','$component_id')";       
        //  $row=mysqli_query($connection,$sql);
                        
                  }  

                }
    }
  }
                //echo "string"; 
  
             $s51="SELECT * FROM marks_component a join co b WHERE a.assigned_course_id = b.assigned_course_id AND a.assigned_course_id = '$ass_course_id'  ORDER BY marks_component_id";
                if($r51=mysqli_query($connection,$s51)){
                    if(mysqli_num_rows($r51)>0){
                         while($row51=mysqli_fetch_array($r51)){
                              $course_outcome_id=$row51['comp_id'];
                              $marks_component_id=$row51['marks_component_id'];
                              $co_id=$row51['co_id'];
                              if( $k < count($x1)){
                                    $sql1 = "INSERT INTO marks_dist(assigned_course_id,marks_com_id,co_id, co_marks) VALUES('$ass_course_id','$marks_component_id',' $co_id','$x1[$k]')";    //'$x1[$k]'    
                                       if($row1=mysqli_query($connection,$sql1)){
                                        $k=$k+1; 
                                          $flag=1;

                               }
                                    } 
                              if($flag==1){

               header('Location:setup.php?value1='.$id.'&value2='.$marks2.'&value4='.$username1.'&value3='.$co_marks2); 
             }
           }
                                }
                            } 
                        
  }                   }
                 }
     }           
                 
    
   
                
?>


                    <div style="width:80%; margin:0px auto ;">
                        <div style="text-align:center;">
                            <h2>Set component marks</h2>
                        </div>
                        <div class="table-responsive">
                        <form method="POST">
                            <table class="table table-striped" border="1px solid black">
                                <thead>
                                    <tr>
                                        <th>Assesment area</th>
                                       
                                        
                                        
                <?php 
                    $sql1="SELECT *
                        FROM course c join offered_course o join assigned_course a join semester s join  faculty f join co
                        WHERE c.course_id = o.course_id and o.offered_course_id=a.offered_course_id and 
                        a.semester_id=s.semester_id and a.assigned_course_id=co.assigned_course_id
                        AND c.course_code =  '$course_code'
                        AND a.sec_no =  '$sec_no'
                        AND s.semester =  '$semester'
                        AND o.year =  '$year'
                           AND f.username =  '$username'";
                    if($result1=mysqli_query($connection,$sql1)){
                        if(mysqli_num_rows($result1)>0){
                             $row_num2=mysqli_num_rows($result1);
                            while($row1=mysqli_fetch_array($result1)){
                                echo "<th>".$row1['co_code']."</th>";
                                }
                            }
                        }
                        echo" <th>Con.Mark</th>";
                        echo "</tr>";
                        echo "</thead>";
                        $sql1="SELECT * FROM comp";
                        if($result1=mysqli_query($connection,$sql1)){
                            if(mysqli_num_rows($result1)>0){
                                while($row1=mysqli_fetch_array($result1)){
                                    $component=$row1['component'];
                        ?>
                                        <tbody>
                                            <tr>
                    <td><input type="checkbox" name="check[]" value="<?php echo $row1['component']; ?>" checked="checked"><?php echo $row1['component']; ?></td>


                    <?php
                    
                    $i=1;      
                    for ($row=0; $row < $row_num2; $row++){ 

                    ?>

                    <td>
                        <input type="text" name="co_marks[]" value="0" size='2' required>
                    </td>
                  <?php                           
                        }

                        $i++;
                    echo "<td><input type='text' name='con_marks[]' value='0' size='2' ></td>";

                    echo "</tr>";
                    } 
                            echo "<td colspan='1'></td>";
                                        //course_outcome
                                        for($j=1;$j<=$row_num2;$j++){
                                            $sco_sum['$j']=0;
                                            $co=$j;
                                            //marks_distribution
                                            $sql4 ="SELECT * FROM marks_dist WHERE assigned_course_id='$ass_course_id' AND co_id='$co'";
                                            if($result4=mysqli_query($connection,$sql4)){
                                                if(mysqli_num_rows($result4)>0){
                                                    while ($row4 = mysqli_fetch_array($result4)){
                                                        if($co==$row4['co_id']){
                                                            $sco_sum['$j']+=$row4['co_marks']; 
                                                        }
                                                    }
                                                }
                                            }
                                                echo "<td>".$sco_sum['$j']."</td>";
                                      }
                                          $sql12 ="SELECT sum(cc_marks) as cc_marks FROM marks_component WHERE assigned_course_id='$ass_course_id'
";
                                        
                                        if($result12 = mysqli_query($connection,$sql12)){
                                            if(mysqli_num_rows($result12)>0){
                                                while ($row12 = mysqli_fetch_array($result12)){
                                                     $cc_sum=$row12['cc_marks'];
                                                  
                                               }}}
                                               echo "<td>".$cc_sum."</td>";
                                    if($cc_sum<=100)
                                    
                                    echo "</tr>";
                                    echo "<tr>";
                                    echo "<td colspan='1'>Fixed value of each course outcome respectively </td>";
                                     $sql6="SELECT co_marks
                                            FROM co
                                            WHERE assigned_course_id =  '$ass_course_id'";
                if($result6=mysqli_query($connection,$sql6)){
                    if(mysqli_num_rows($result6)>0){
                        $row_num = mysqli_num_rows($result6);
                        while ($row6 = mysqli_fetch_array($result6)){
                                    echo "<td>".$row6['co_marks']."</td>";

                                }}}
                                echo "<td></td>";
                                    echo "</tr>";
                                    echo "<tr>";
                                    $col=$row_num2+4;

                                    echo "<td colspan='$col'><input type='submit' name='button' class='btn btn btn-danger btn-md' value='Save'></td>
                                    </tr>";


                                    if($cc_sum!=100)
                                        echo "<tr><td colspan='$col'>Total CC marks sould be 100</td></tr>";
                                      echo "<tr><td colspan='$col'><button name='button' class='btn btn-dark'><a href='select_course.php'>Back</a></button></td></tr>";
                                        }       

                                    }

                                    ?>
                                        </tbody>
                            </table>
                            </form>
                        </div>
                        <br>
                    </div>
            </div>
</body>

</html>