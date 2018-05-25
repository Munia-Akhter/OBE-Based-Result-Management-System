<?php
define ('db_server','localhost');
define ('db_username','root');
define ('db_password','');
define ('db_database','obe');
$connection=mysqli_connect(db_server,db_username,db_password,db_database) or die(mysqli_error($connection));
?>