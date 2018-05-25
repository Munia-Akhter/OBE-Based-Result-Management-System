<?php
	session_start();
	include 'db.php';
    $errors=array();
    function test_input($data) {
	$data = trim($data); 
	$data = stripslashes($data); 
	$data = htmlspecialchars($data);  
	return $data;
	}
        if(isset($_POST['login'])){

        	$username=mysqli_real_escape_string($connection, $_POST['username']);
	        $password=mysqli_real_escape_string($connection, $_POST['pass']);

	        $username=test_input($username);
	        $password=test_input($password);

        	if(empty($_POST['username']))
           		$errors['username']="Please Enter Username";
	       	else
	            $username=test_input($_POST['username']);
	       	if(empty($_POST['pass']))
	            $errors['pass']="Please Enter Password";
	        else
	            $password=test_input($_POST['pass']);
	



	     if(count($errors)==0)
	     {

	           $sql1="SELECT a.username,a.password,a.user_type_id FROM  faculty a JOIN user_type b WHERE username='$username' AND a.user_type_id=b.user_type_id";

				

	           if($result=mysqli_query($connection,$sql1)){

	             if(mysqli_num_rows($result)>0){
	
		                while($row=mysqli_fetch_assoc($result)){

		                   
							
					         if(password_verify($password,$row['password']))
					         {     

					         	    $_SESSION['username']=$username;
					        

									header('Location:faculty/faculty_home.php');
									exit();
							         
							  }
							  else{

							  	$errors["wrong_pass"]="You have entered wrong password";							  }
							
						   }	
				    	}
					}



			 $sql2="SELECT a.username,a.password,a.user_type_id FROM admin a JOIN user_type b WHERE username='$username'  AND a.user_type_id=b.user_type_id ";

						if($result2=mysqli_query($connection,$sql2)){

							if(mysqli_num_rows($result2) > 0){

								while($row2=mysqli_fetch_assoc($result2)){

									if(password_verify($password,$row2['password']))
								    {

									    $_SESSION['username']=$username;
										header('Location:admin/admin_dashboard.php');
							
										exit();
									}
									else
										$errors["wrong_pass"]="You have entered wrong password";
								}
							}
						}
						else
							$errors["wrong_pass"]="No user found"; 
				}
			}

?>
<!DOCTYPE html>
<html>
<head>
  <title>login</title>
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

	#login{

    border-radius: 25px;
    border: 1px solid black;
    padding: 20px; 
    width: 460px;
    height: 300px; 
    text-align: center;
    margin: 0px auto; 
    margin-top: 200px;
    background-color:#bba27a82;

  }
  h4{
  	text-align: center;
  	color:#ffffff;
  }
  #btn{
  	height: 30px;
  	width: 175px;
  	margin-left: 70px;
  }
  .error{
	  color:#d83a52;
  }
  #login table td{
	  padding: 5px;
  }
  #new
  {
  	font-size: 20px;
  }
</style>
<body>
<div id="login">
	<h4>Log In<br></h4><br>
	<form method="POST">
  		<table>
  			<tr>
  				<td>Username: </td>
				<td><input type="text" name="username" value="<?php if(isset($username)) echo $username;?>"></td>
  				<td class="error"><?php if(isset($errors['username'])) echo $errors['username'];?></td>
			</tr>
			<tr>
  				<td>Password: </td>
				<td><input type="password" name="pass"></td>
				<td class="error"><?php if(isset($errors['pass'])) echo $errors['pass']; if(isset($errors['wrong_pass'])) echo $errors['wrong_pass'];?></td>
			</tr>
			<tr>
  				<td colspan="2"><input type="submit" id="btn" class="btn btn btn-danger btn-md"
  				 name="login" value="Log in"></td>
			</tr>
		</table>
	</form>
	<br>
	<br>
	<p id="new">Not a Registred Faculty ? <a href="registration.php">Sign Up</a> here. </p>
</div>
</body>
</html>
