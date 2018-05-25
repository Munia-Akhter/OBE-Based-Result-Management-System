<?php  
include("db.php");
$id=$_GET['id'];
$username=$_GET['username'];
$sql = "SELECT b.id,a.title,a.credit,b.semester,b.year,b.course_code,b.sec_no,b.username 
FROM course a INNER JOIN assigned_course b ON a.course_code = b.course_code WHERE 
b.username='$username' AND b.id='$id'";
if($result=mysqli_query($connection,$sql)){
	if(mysqli_num_rows($result)>0){
		$row=mysqli_fetch_array($result);
		$course_code = $row["course_code"];
		$sec_no = $row["sec_no"];
		$semester = $row["semester"];
		$year = $row["year"];
		$username=$row['username'];
		$ass_course_id=$row['id'];
		
		}
	}
 $query =  "SELECT co_per, count(*) as number FROM co_attainment  WHERE 
 course_code='$course_code' AND sec_no='$sec_no' AND semester='$semester' AND year='$year'
GROUP BY co";
 $result = mysqli_query($connection, $query);  
 ?>  
 <!DOCTYPE html>  
 <html>  
      <head>  
           <title>Webslesson Tutorial | Make Simple Pie Chart by Google Chart API with PHP Mysql</title>  
           <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>  
           <script type="text/javascript">  
           google.charts.load('current', {'packages':['corechart']});  
           google.charts.setOnLoadCallback(drawChart);  
           function drawChart()  
           {  
                var data = google.visualization.arrayToDataTable([  
                          ['Total Marks', 'Number'],  
                          <?php  
                          while($row = mysqli_fetch_array($result))  
                          {  
                               echo "['".$row["co_per"]."', ".$row["number"]."],";  
                          }  
                          ?>  
                     ]);  
                var options = {  
                      title: 'Percentage of CO',  
                      //is3D:true,  
                      pieHole: 0.4  
                     };  
                var chart = new google.visualization.PieChart(document.getElementById('piechart'));  
                chart.draw(data, options);  
           }  
		   </script>  
		   <style>
			   #go_back{
				   margin-left: 400px;

			   }
		   </style>
      </head>  
      <body>  
           <br /><br />  
           <div style="width:900px;">  
				<h3 align="center">CO Attainment Graph</h3>  
				<div id='go_back' style="width: 100px; height: 30px;">
				<a href="co_att.php?value=<?php echo $id;?>">Go Back</a>
				</div> 
                <br />  
				<div id="piechart" style="width: 900px; height: 500px;"></div> 
           </div>  
      </body>  
 </html>  