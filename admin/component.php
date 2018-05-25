<?php include("db.php");

  $errors=array();
  function test_input($data){
    $data = trim($data); 
    $data = stripslashes($data); 
    $data = htmlspecialchars($data);  
    return $data;
  } 

  if(isset($_POST['add'])){

    $component=mysqli_real_escape_string($connection, $_POST['new_comp']);
    $component=test_input($component);
  
    

     if(empty($_POST['new_comp'])){  

         $errors['new_comp']="Please Enter component name" ;
         echo '<script type="text/javascript">'; 
         echo 'setTimeout(function () {  swal("'.$errors['new_comp'].'");';
         echo '},300);</script>';

    }

  

      if(count($errors)==0){

        $sql = "SELECT * FROM comp ";
          if($result=mysqli_query($connection,$sql)){
              if(mysqli_num_rows($result) > 0){
          while($row = mysqli_fetch_array($result)){
            if($row['component']==$component){
            echo '<script type="text/javascript">'; 
            echo 'setTimeout(function () {  swal("Component already exist !!");';
            echo '},600);</script>';
    
          }
        }
      }
    }



    $sql=" INSERT INTO comp(component) VALUES('$component')" ;

    if($result=mysqli_query($connection,$sql)){

      echo '<script type="text/javascript">'; 
          echo 'setTimeout(function () {  swal("Successfully Inserted");';
      echo '},600);</script>';

      //header('Location:course.php');
      }
      
    }
  }



if(isset($_POST['edit_row'])){
  $row_id=$_POST['edit_row'];
  header('Location:edit_comp.php?value='.$row_id);
} 


?>

<!DOCTYPE html>
<html>
<head>
  <title>Component</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="../css/style_2.css">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
  <link rel="stylesheet" href="../css/bootstrap.min.css">
  <script src="../js/sweetalert.min.js"></script>
  <script src="../js/jquery-3.2.1.min.js"></script>
  <script src="../js/bootstrap.min.js"></script>
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
          <a href="department.php" >Department</a><br><br>
          <a href="course.php">Course</a><br><br>
          <a href="offered_course.php">Offer Course</a><br><br>
          <a href="assign_course.php">Assign Course</a><br><br>
          <a href="component.php" class="btn btn-info">Component</a><br><br>
          <a href="history.php">Student PO</a><br><br>
          <a href="st_enrollment.php">Student Enrollment</a><br><br>
          <a href="../logout.php" class="glyphicon glyphicon-log-out"></a>
          </td>
        </tr>
      </table>  
    <div style="width:85%; margin:0px auto ; ">
    <form method="POST" action="">
    <div class="table-responsive">
        <table id="tbl2" class="table table-striped" border="1px solid black" width="35%">
      <thead>
        <tr>
            <th>Component Name</th>
    
            <th >Action</th>
        </tr>
      </thead>
           <tbody>
        <tr>
          <td><input type="text" name="new_comp" placeholder="Enter Component Name" size="20"> </td>
        

          <td colspan="2"><button type="submit" name="add" class="btn btn btn-danger btn-sm" style="font-size:16px"><i class="fa fa-plus-circle"></i></button></td>
        </tr>

               <?php 
         $query_2="SELECT *FROM comp";
        if($select=mysqli_query($connection,$query_2)){
                    if(mysqli_num_rows($select) > 0){
                      while ($row = mysqli_fetch_array($select)){
                          echo "<tr>";
                            echo "<td>".$row['component']."</td>";
                           
                      ?>

          <td><button type="submit" name="edit_row" class="btn btn btn-danger btn-sm" value="<?php echo $row['comp_id']; ?>" style="font-size:16px"><i class="fa fa-edit"></i></button></td>
          <?php
                echo "</tr>";  

                        }
                    }
                }

                  ?>
        </tbody>
        </table>
        </div>
      </form>
     </div>
  </div>
</body>
</html>
