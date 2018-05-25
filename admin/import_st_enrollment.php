<?php

include 'db.php';

if(isset($_POST["Import"])){ 
    $current_month = date("m");
    $current_year = date("Y"); 
    if($current_month==1||$current_month==2||$current_month==3||$current_month==4){
        $semester='Spring';
        $year=$current_year;
    } 
    if($current_month==5||$current_month==6||$current_month==7||$current_month==8){
      $semester='Summer';
      $year=$current_year;
    }
    if($current_month==9||$current_month==10||$current_month==11||$current_month==12){
      $semester='Fall';
      $year=$current_year;
      } 
        
  $course_code=$_POST["course_code"];
  $sec_no=$_POST["sec_no"];

  

  $file_name = $_FILES["file"]["name"];
  $tmp = explode('.', $file_name);
  $extension = end($tmp); // For getting Extension of selected file
 //echo $extension;
 $allowed_extension = array("xls", "xlsx", "csv"); //allowed extension
 if(in_array($extension, $allowed_extension)) //check selected file extension is present in allowed extension array
 {
  $sq=" SELECT * FROM course c join offered_course o join assigned_course a WHERE c.course_id=o.course_id and o.offered_course_id=a.offered_course_id and c.course_code='$course_code' and a.sec_no='$sec_no'"; 
     if($r=mysqli_query($connection,$sq)){
    if(mysqli_num_rows($r)>0){
       $ro=mysqli_fetch_array($r);
       $assigned_course_id=$ro['assigned_course_id'];
     
  $sql = "SELECT * from st_en";

  if($result=mysqli_query($connection,$sql)){
    if(mysqli_num_rows($result)>=0){
       $file = $_FILES["file"]["tmp_name"]; // getting temporary source of excel file
  include("PHPExcel/IOFactory.php"); // Add PHPExcel Library in this code
  $objPHPExcel = PHPExcel_IOFactory::load($file); // create object of PHPExcel library by using load() method and in load method define path of selected file

      if(mysqli_num_rows($result)==0){
       
  foreach ($objPHPExcel->getWorksheetIterator() as $worksheet)
  {
   $highestRow = $worksheet->getHighestRow();

           for($row=2; $row<=$highestRow; $row++){
              $s_id = mysqli_real_escape_string($connection, $worksheet->getCellByColumnAndRow(0, $row)->getValue());
              $name = mysqli_real_escape_string($connection, $worksheet->getCellByColumnAndRow(1, $row)->getValue());
           
             $query2 = "INSERT INTO st_en(s_id, assigned_course_id  ,name) VALUES ( '".$s_id."','".$assigned_course_id."','".$name."')";
                $result2 = mysqli_query($connection, $query2);  

              echo "<script type=\"text/javascript\">
              alert(\" File has been successfully Imported.\");
              window.location = \"st_enrollment.php\"         
              </script>";  
          }
        }}
      
       if(mysqli_num_rows($result)>0){
     
      while($row=mysqli_fetch_array($result)){
    //    if($row['course_code']!=$course_code && $row['sec_no']!=$sec_no && $row['year']!=$year && $row['semester']!=$semester){echo "string";
        $sql1 = "SELECT * FROM st_en Where assigned_course_id='$assigned_course_id' ";
  if($result1=mysqli_query($connection,$sql1)){
    if(mysqli_num_rows($result1)>=0){
      if(mysqli_num_rows($result1)==0){
   

  foreach ($objPHPExcel->getWorksheetIterator() as $worksheet)
  {
   $highestRow = $worksheet->getHighestRow();

           for($row=2; $row<=$highestRow; $row++){
              $s_id = mysqli_real_escape_string($connection, $worksheet->getCellByColumnAndRow(0, $row)->getValue());
              $name = mysqli_real_escape_string($connection, $worksheet->getCellByColumnAndRow(1, $row)->getValue());

             $query3 = "INSERT INTO st_en(s_id, assigned_course_id  ,name) 
             VALUES ( '$s_id','$assigned_course_id','$name')";
                $result3 = mysqli_query($connection, $query3);
              echo "<script type=\"text/javascript\">
              alert(\" File has been successfully Imported.\");
             window.location = \"st_enrollment.php\"
              </script>";  
          }
        }

      }else{
          echo "<script type=\"text/javascript\">
alert(\"You have already enrolled students for the course.\");
window.location = \"st_enrollment.php\"
</script>";        
      }
    }}
     }

      }
      else
{
echo "<script type=\"text/javascript\">
alert(\"You have already enrolled students for the course.\");
window.location = \"st_enrollment.php\"
</script>";

}
    }
    }

}
 else{
           echo "<script type=\"text/javascript\">
              alert(\" Course is not assigned.\");
              window.location = \"st_enrollment.php\"         
              </script>"; 
        }


  }
}
 else
{
echo "<script type=\"text/javascript\">
alert(\"Invalid File:Please Upload CSV/xls/xlsx File.\");
window.location = \"st_enrollment.php\"
</script>";
}
}



 
?>