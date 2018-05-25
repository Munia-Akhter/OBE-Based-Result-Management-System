<?php include("db.php");
	session_start();
	$username= $_SESSION['username'];
    //$row_id= $_SESSION['row_id'];
?>

<!DOCTYPE html>
<html>
<head>
	<title>History</title>
	<link rel="stylesheet" type="text/css" href="../css/style.css">
	<script src="../js/jquery-3.2.1.min.js"></script>
	<script src="../js/sweetalert.min.js"></script>
</head>
<body class="body">
	<header class="mainHeader">
		<nav>
			<ul>
				<li><a href="faculty_home.php">Home</a></li>
				<li><a href="course.php">Course</a></li>	
				<li><a href="select_course.php">Marks Distribution</a></li>
				<li><a href="../logout.php">Logout</a></li>
			</ul>
		</nav>
	</header>
	<div class="mainContent">
		<div class="content">
		<center>
			<table>
				<tr><th>Instructor Name: </th>
					<td><?php echo $username;?></td>
				</tr>
			</table>
			<?php 
			
		    $sql = "SELECT a.title,a.credit,c.semester,c.year,c.offered_course_code,c.sec_no,c.username FROM course a JOIN offer_course b ON a.course_code = b.offered_course_code JOIN assign_course c ON b.offered_course_code = c.offered_course_code WHERE c.username='$username'";
		    if($result=mysqli_query($connection,$sql)){
		        if(mysqli_num_rows($result)>0){
		            $row=mysqli_fetch_array($result);
		            $course_code = $row["offered_course_code"];
		            $sec_no = $row["sec_no"];
		            $semester = $row["semester"];
		            $year = $row["year"];
		            $username=$row['username'];
		            echo "<table>";
		            echo "<tr>";
		            echo "<th>Course Code: </th>"."<td>".$row["offered_course_code"]."</td>";
		                            
		            echo "<th>Course Title: </th>"."<td>".$row["title"]."</td>";
		                            
		            echo "<th>Credit: </th>"."<td>".$row["credit"]."</td>";

		            echo "<th>Section: </th>"."<td>".$row["sec_no"]."</td>";
		                            
		            echo "<th>Semester: </th>"."<td>".$row["semester"]." ".$row["year"]."</td>";
		            echo "</tr>";
		            echo "</table>";
		        }
		        $sql1="SELECT * FROM enrollment where course_code='$course_code'";	//see all the students who r enrolled under sepcific Instructor!
                    			$select =mysqli_query($connection,$sql1);
                    		if(mysqli_num_rows($select) > 0) {
		
			?>
			<h2>Search by Student ID</h2>
			<form method="POST" action="">
				<table>
        			<tr>
            			<th>Selected ID</th>
        			</tr>
        			<tr>
						<td>
        					<select name="select_id">
        					<?php	
        						while ($row = mysqli_fetch_array($select)) {  
                        			
                 			?>

                    			<option value="<?php echo $row['s_id']?>"><?php echo $row['s_id'];?></option>
                    		<?php
                        		}
                    		}}
							?>
							</select>
        				</td>
        				<td> 
                    		<input type="submit" name="add_1" value="Search"> <!--button for searching history of a selected student id!-->
            			</td>
        			</tr>
	            </table>
            </form>
	</div>
	</div>
	<footer class="mainFooter"></footer>
</body>
</html>
<?php
if(isset($_POST['add_1'])){
		$select_id=$_POST['select_id'];
	   // $sql1="SELECT * FROM student where course_code='$course_code'";
		$sql6="SELECT * FROM enrollment where s_id='$select_id' AND grade IS NULL ";
		    if($result6=mysqli_query($connection,$sql6)){
			    if(mysqli_num_rows($result6)>0){
		        	while ($row6 = mysqli_fetch_array($result6)){
		        		echo '<script type="text/javascript">'; 
		                echo 'setTimeout(function () {  swal("NO Course is completed!");';
		                echo '},300);</script>';
		                exit();

		        	}}}

		//if($result1=mysqli_query($connection,$sql1)){
		//    if(mysqli_num_rows($result1)>0){
		//       	$row_num=mysqli_num_rows($result1);
		  //      while ($row1 = mysqli_fetch_array($result1)){
		    //    	$s_id=$row1['s_id'];
		      //  	$course_code=$row1['course_code'];
		        //	$sec_no=$row1['sec_no'];
		        //	$semester=$row1['semester'];
		        //	$year=$row1['year'];

		        	$sql2 = "SELECT *
							FROM enrollment
							WHERE s_id =  '$select_id'
							AND course_code NOT 
							IN (

							SELECT course_code
							FROM percent_of_co
							WHERE s_id =  '$select_id'
							)";
				   		if($result2=mysqli_query($connection,$sql2)){ 
	    					 if(mysqli_num_rows($result2)>0){
		  				        while ($row2 = mysqli_fetch_array($result2)){
		  				        	$coursecode=$row2['course_code'];
		  				        	$s_id=$row2['s_id'];
		  				        	$sec_no=$row2['sec_no'];
		  				        	$semester=$row2['semester'];
		  				        	$year=$row2['year'];

					        $sql3="SELECT co_code,po_code FROM mapping WHERE course_code='$coursecode' AND sec_no='$sec_no' AND semester='$semester' AND year='$year'";
							if($result3=mysqli_query($connection,$sql3)){
								if(mysqli_num_rows($result3)>0){
									while ($row3 = mysqli_fetch_array($result3)) {
										$co=$row3['co_code'];
										$po=$row3['po_code'];

			   		 					$sql4 = "INSERT INTO percent_of_co
										(s_id,course_code,sec_no,semester,year,co,po) VALUES('$select_id','$coursecode','$sec_no','$semester','$year','$co','$po')";
							        	$ins4=mysqli_query($connection,$sql4);
									}
								}
							}
						}
					}
				}

				$sql1="SELECT * FROM percent_of_co Where s_id='$select_id'";
				if($result1=mysqli_query($connection,$sql1)){
					if(mysqli_num_rows($result1)>0){ 	
		  	    	  	while ($row1 = mysqli_fetch_array($result1)){
		   			 	//$s_id=$row1['s_id'];
		      			$coursecode=$row1['course_code'];
		      			$secno=$row1['sec_no'];
		      			$sem=$row1['semester'];
		      			$y=$row1['year'];
	 echo "<table class='table_1'border='1'>";
			echo "<tr>";
				echo "<th>"."SL</th>";
			//if(isset($course_code))
				echo "<th>"."Course Code</th>";
				echo "<th>"."Section</th>";
				echo "<th>Grade</th>";

				$sql5="SELECT co_code,co_marks FROM course_outcome where course_code='$coursecode' AND sec_no='$secno' AND semester='$sem' AND year='$y'";
		    if($result5=mysqli_query($connection,$sql5)){
		        if(mysqli_num_rows($result5)>0){
		        	$row_num=mysqli_num_rows($result5);
		        	$row5 = mysqli_fetch_array($result5);
		        	$co_marks=$row5['co_marks'];
		        	//echo $row_num;
			for ($row=1; $row <= $row_num; $row++) {
				echo "<th>CO".$row."</th>";
			}
				echo "<th>Accepted PO</th>";
				echo "<th>Rejected PO</th>";
			echo "</tr>";
				$i=1;


				
	   	 	$sql6="SELECT * FROM enrollment where s_id='$select_id' AND grade IS NOT NULL";
		    if($result6=mysqli_query($connection,$sql6)){
			    if(mysqli_num_rows($result6)>0){
		        	while ($row6 = mysqli_fetch_array($result6)){
		        		$s_id=$row6['s_id'];
			        	$name=$row6['name'];
			        	$grade=$row6['grade'];
			        	$course_code=$row6['course_code'];
			        	$sec_no=$row6['sec_no'];
			        	$semester=$row6['semester'];
			        	$year=$row6['year'];
			echo "<tr>";
				echo "<td>".$i."</td>";
				echo "<td>".$course_code."</td>";
				echo "<td>".$sec_no."</td>";
				echo "<td>".$grade."</td>";
				for ($row=1; $row <= $row_num; $row++) {
					$a='CO'.$row;

					$sql7="SELECT SUM(marks)  FROM  result_processing WHERE s_id='$select_id' And course_code='$course_code' AND sec_no='$sec_no' AND semester='$semester' AND year='$year' AND co_for_component='$a'";
					if($result7=mysqli_query($connection,$sql7)){
		        		if(mysqli_num_rows($result7)>0){
		        			while ($row7 = mysqli_fetch_array($result7)){
		        				$b=$row7['SUM(marks)'];
							
								$query8 = "UPDATE percent_of_co  SET total_marks_co='$b' WHERE s_id='$select_id' AND course_code='$course_code' AND sec_no='$sec_no' AND semester='$semester' AND year='$year' AND co='$a'";
									if($result8 = mysqli_query($connection, $query8)){
										$c=sprintf("%.2f",(100*$b)/$co_marks);

										$query9 = "UPDATE percent_of_co  SET percent_co='$c' WHERE s_id='$select_id' AND course_code='$course_code' AND sec_no='$sec_no' AND semester='$semester' AND year='$year' AND co='$a'";
										if($result9 = mysqli_query($connection, $query9)){
											echo "<td>".$c."%</td>";
										}
									}
							}
						}
					}
				}
				$i++;

				for ($row=1; $row <= $row_num; $row++) {
					$a='CO'.$row;
				/*$sql10="SELECT  distinct po  FROM  percent_of_co  WHERE s_id='$select_id' And course_code='$course_code'";
				$datas=array();					
				if($result10=mysqli_query($connection,$sql10)){
		        	if(mysqli_num_rows($result10)>0){
		        		while ($row10 = mysqli_fetch_array($result10)){
		        				//$po=$row10['po'];	
		        				$datas[]=$row10['po'];
		        				//$account=count($datas);
		        				//$merge=array_merge($datas);
		        				//$datas[$row]=$row9['po'];
		        				//$data=$datas[];
		        				//print_r($datas);
								$unique= array_unique($datas);
								//$a=$unique;
		        				//$percent_co=$row9['percent_co'];
								
								
								//echo "<td></td>";
									//echo "<td>".$row9['po_code']."</td>";

						}*/
						$sql11="SELECT DISTINCT po FROM  percent_of_co  WHERE s_id='$select_id' And course_code='$course_code' AND sec_no='$sec_no' AND semester='$semester' AND year='$year' AND percent_co >=70";
						$datas=array();					
								if($result11=mysqli_query($connection,$sql11)){
		        					if(mysqli_num_rows($result11)>0){
		        						while ($row11 = mysqli_fetch_array($result11)){
											$po=$row11['po'];
											$datas[]=$row11['po'];
											$unique= array_unique($datas);
											$d=implode(", ", $unique);
											$query12 = "UPDATE percent_of_co  SET accepted_po='$d' WHERE s_id='$select_id' AND course_code='$course_code' AND sec_no='$sec_no' AND semester='$semester' AND year='$year' AND co='$a'";
									if($result12 = mysqli_query($connection, $query12)){
										$sql13="SELECT DISTINCT accepted_po, course_code
											FROM percent_of_co
											WHERE s_id =  '$select_id'
											AND co =  'CO1'";
								//$datas3=array();					
								if($result13=mysqli_query($connection,$sql13)){
		        					if(mysqli_num_rows($result13)>0){
		        						while ($row13 = mysqli_fetch_array($result13)){
											//$marge_po=$row13['po'];
											$datas3=$row13['accepted_po'];
											$g=explode(", ", $datas3);
											$unique3= array_unique($g);
											$margepo=implode(", ", $unique3);
										}}}
									}				
									        				//$percent_co=$row9['percent_co'];
								//if($percent_co<=70){
											
									//echo "<td>".$po."</td>";
								//}
							}}}
							$sql12="SELECT DISTINCT po FROM  percent_of_co  WHERE s_id='$select_id' And course_code='$course_code' AND sec_no='$sec_no' AND semester='$semester' AND year='$year' AND percent_co <70";
							$datas=array();					
								if($result12=mysqli_query($connection,$sql12)){
		        					if(mysqli_num_rows($result12)>0){
		        						while ($row12 = mysqli_fetch_array($result12)){
											$po=$row12['po'];
											$datas[]=$row12['po'];
											$unique= array_unique($datas);
											$e=implode(", ", $unique);

											$query13 = "UPDATE percent_of_co  SET rejected_po='$e' WHERE s_id='$select_id' AND course_code='$course_code' AND sec_no='$sec_no' AND semester='$semester' AND year='$year' AND co='$a'";
									if($result13 = mysqli_query($connection, $query13)){
										$sql14="SELECT distinct accepted_po, rejected_po FROM  percent_of_co  WHERE s_id='$select_id' And course_code='$course_code' AND sec_no='$sec_no' AND semester='$semester' AND year='$year' AND co='CO1'";
									$datas1=array();	
									//$accepted=array();					
									//$rejected=array();					
									//$i=0;
										if($result14=mysqli_query($connection,$sql14)){
				        					if(mysqli_num_rows($result14)>0){
				        						while ($row14 = mysqli_fetch_array($result14)){
				        							$accepted=$row14['accepted_po'];
				        							$rejected=$row14['rejected_po'];
				        							$f=explode(", ", $accepted);
				        							$g=explode(", ", $rejected);
				        							/*foreach($accepted_po as $row){
				        								$accepted[]=$row['i'];
				        							}
				        							foreach($rejected_po as $row){
				        								$rejected[]=$row;
				        							}*/
				        							//$datas1=array_intersect($rejected_po,$accepted_po);
				        							//print_r($datas1);
				        							//echo "hi";
				        							//$unique1= array_intersect($datas1);
				        							//$f=explode(", ", $accepted_po);
				        							//$g=explode(", ", $rejected_po);
				        							//$datas1= array_merge($f,$g);
				        							$unique2= array_diff($g,$f);
				        							//print_r($unique1);
				        							$h=implode(", ", $unique2);
				        							$query15 = "UPDATE percent_of_co  SET rejected_po='$h' WHERE s_id='$select_id' AND course_code='$course_code' AND sec_no='$sec_no' AND semester='$semester' AND year='$year' AND co='$a'";
				        							if($result15 = mysqli_query($connection,  $query15));
				        							if($result14=mysqli_query($connection,$sql14)){
				        					if(mysqli_num_rows($result14)>0){
				        						while ($row14 = mysqli_fetch_array($result14)){
				        							$rejectedpo=$row14['rejected_po'];
				        							$accepted_po=$row14['accepted_po'];
		        						}}}

											}				
									}}}        				//$percent_co=$row9['percent_co'];
								//if($percent_co<=70){
											
									//echo "<td>".$po."</td>";
								//}
							}}}

							//exit();

						//$unique= array_unique($merge);
					}	
					echo "<td>".$accepted_po."</td>";
					echo "<td>".$rejectedpo."</td>";
				}
			}
			//foreach ($unique as $key => $val) {
					
			//}
  			
			}
//	print_r($f);
	
	/*print_r($g);
	echo "<pre>";
	print_r($unique2);
	echo "</pre>";*/
	echo "</tr>";
	//echo "<td>";
	echo "</table>";
	echo "<table>";
	echo "<tr>";
	echo "<td>=>so far, Total Accepted PO's are:</td>";
	//echo "</tr>";
	//echo "<tr>";
	echo "<td>".$margepo."</td>";
	echo "</td>";
	echo "</tr>";	
	echo "</table>";
	
}}exit();
}	}}
	}

					
?>