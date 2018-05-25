<?php 
require_once("db.php");
$errors=array();
function test_input($data) {
  $data = trim($data); 
  $data = stripslashes($data); 
  $data = htmlspecialchars($data);  
  return $data;
  }
if(isset($_POST['submit'])){
  
    $name = mysqli_real_escape_string($connection, $_POST['name']);
    $dept = mysqli_real_escape_string($connection, $_POST['dept']);
    $nick_name = mysqli_real_escape_string($connection, $_POST['username']);
    $email  = mysqli_real_escape_string($connection, $_POST['email']);
    $password = mysqli_real_escape_string($connection, $_POST['pass']);
    $con_password = mysqli_real_escape_string($connection, $_POST['con_pass']);

    if(empty($_POST['name']))
    $errors['name']="Please enter name";
    
    if (!preg_match("/^[a-zA-Z ]*$/",$name)) {
      $errors['name']= "Only letters and white space allowed"; 
    }

    else
      $name=test_input($_POST['name']);

    if(empty($_POST['username']))
      $errors['username']="Please enter username";

    if (!preg_match("/^[a-zA-Z ]*$/",$nick_name)) {
      $errors['username']= "Only letters(in capital)and no white space"; 
    }

    else
      $nick_name=test_input($_POST['username']);

    if(empty($_POST['dept']))
      $errors['dept']="Please enter Dept name";

    if (!preg_match("/^[a-zA-Z]*$/",$dept)) {
      $errors['dept']= "Only letters(in capital)and no white space"; 
    }

    else
      $dept=test_input($_POST['dept']);

    if(empty($_POST['email']))
      $errors['email']="Please enter email address";
    if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
      $errors['email']= "Please enter a valid email address";
    }
    else
      $email=test_input($_POST['email']);
    
    if(empty($_POST['pass']))
      $errors['pass']="Please enter password";
    else
      $password=test_input($_POST['con_pass']);
    if(empty($_POST['con_pass']))
      $errors['con_pass']="Please confirm password";
    else
      $con_password=test_input($_POST['con_pass']);

    if($_POST['pass']!=$_POST['con_pass']){
      $errors['match']="Password did not match";
    }
    $sql1="SELECT * FROM faculty f join dept d where f.dept_id=d.dept_id";
        if($result1=mysqli_query($connection,$sql1)){
          if(mysqli_num_rows($result1) > 0){
            while($row1 = mysqli_fetch_array($result1)){
              if($row1['email']==$email && $row1['username']==$nick_name){
                 $errors['username']="You are already registered";
              echo '<script type="text/javascript">'; 
              echo 'setTimeout(function () {  swal("'.$errors['username'].'");';
              echo '},600);</script>';
              
              }
            }

          }
        }

    else{
    
    if(count($errors)==0){         
        $options = array("cost"=>4);
        $hashPassword = password_hash($con_password,PASSWORD_BCRYPT,$options);
        

          $query="SELECT * FROM user_type WHERE user_type='faculty'";
          if($result_q=mysqli_query($connection,$query)){
            if(mysqli_num_rows($result_q) > 0){
              $row_q = mysqli_fetch_array($result_q);
              $user_type=$row_q['user_type_id'];
            }
          }
           $query="SELECT * FROM dept WHERE dept='$dept'";
          if($result_q=mysqli_query($connection,$query)){
            if(mysqli_num_rows($result_q) > 0){
              $row_q = mysqli_fetch_array($result_q);
              $dept_id=$row_q['dept_id'];
            }
          }
          $sql2 = "INSERT INTO faculty (name, username,email,dept_id,password,user_type_id) VALUE ('".$name."', '". $nick_name ."','".$email."','".$dept_id."',  '".$hashPassword."','". $user_type."')";     
          if($result2 = mysqli_query($connection, $sql2)){
            echo '<script type="text/javascript">'; 
            echo 'setTimeout(function () {  swal("Registration is done successfully");';
            echo '},600);</script>';
          }
          else echo mysqli_error($connection);
          
        }
      }
    }
?>

<!DOCTYPE html>
<html>
<head>
  <title>Instructor Registration</title>

<meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-sweetalert/1.0.1/sweetalert.min.css">
  <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-sweetalert/1.0.1/sweetalert.min.js"></script>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

</head>
<style type="text/css">

  #reg{

    border-radius: 25px;
    border: 1px solid black;
    padding: 20px; 
    width: 490px;
    height: 450px; 
    text-align: center;
    margin: 0px auto; 
    margin-top: 100px;
    margin-bottom: 100px;
    background-color: #bba27a82;
}
  h4{
    text-align: center;
    color:#ffffff;
  }
  #table td{
    padding: 5px;
  }
  #btn{
    background-color:#09B7D3;
    color: #fff;
    height: 30px;
    width: 175px;
    margin-left: 70px;
    border-radius: 7px;
  }
  .reg_ins{
    margin-left: 90px;
  }
  .error{
  color:#d83a52;
  }
   
  .error.n :focus {
  background-color:red;
  }
}
</style>
<body>
     <div id="reg">
      <h4>Registration<br></h4><br>
        <form action="<?php echo $_SERVER['PHP_SELF']?>" method="post">
        <div class="reg_ins">
        <table id="table">
          <tr>
            <td> <input type="text" name="name" class="n" value="<?php if(isset($name)) echo $name;?>" placeholder="Enter name"></td><td class="error"><?php if(isset($errors['name'])) echo $errors['name'];?></td>
          </tr>
          <tr>
           <td> <input type="text" name="username" value="<?php if(isset($nick_name)) echo $nick_name;?>" placeholder="Enter user name"></td>
           <td class="error"><?php if(isset($errors['username'])) echo $errors['username'];?></td>
          </tr>
          <tr>
            <td> 
              <input type="text" name="dept" value="<?php if(isset($dept)) echo $dept;?>" placeholder="Enter department name">
            </td> 
            
            <td class="error"><?php if(isset($errors['dept'])) echo $errors['dept'];?></td>
          </tr>

          <tr>
            <td>
              <input type="text" name="email" value="<?php if(isset($email)) echo $email;?>" placeholder="Enter email">
            </td>
             <td class="error"><?php if(isset($errors['email'])) echo $errors['email'];?></td>
          </tr>

          <tr> 
            <td>
              <input type="password" name="pass" value="" placeholder="Enter password">
            </td>
            <td class="error"><?php if(isset($errors['pass'])) echo $errors['pass'];?></td>
          </tr>

          <tr>
            <td>
              <input type="password" name="con_pass" value="" placeholder="Confirm password">
            </td>

            <td class="error"><?php if(isset($errors["con_pass"])){ echo $errors["con_pass"];}if(isset($errors["match"])) {echo $errors["match"];}?></td>
            
            
          </tr>
          <tr>
            <td>
              <button type="submit" name="submit" class="btn btn btn-danger btn-md">Submit</buttom> 
            </td> 
            </tr>
            <tr>
            <td><div class="button">
             <a href='login.php' class="btn btn-primary">Back</a>
           </div></td>
            </tr>
        </table>
        </div>
      </div>
</body>
</html>
