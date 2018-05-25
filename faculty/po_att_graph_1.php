<?php include("db.php");
session_start();
$username=$_GET['value2'];

$id=$_GET['value1'];
?>
<!DOCTYPE html>
<html>

<head>
    <title>ChartJS - BarGraph</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-sweetalert/1.0.1/sweetalert.min.css">
	<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-sweetalert/1.0.1/sweetalert.min.js"></script>
	
    <style type="text/css">
        #chart-container {
            width: 640px;
            height: auto;
        }
    </style>
</head>

<body onload="myFunction(<?php echo $username; ?>,<?php echo $id; ?>)">
<?php 
			
		    $sql = "SELECT a.title,a.credit,c.semester,c.year,c.offered_course_code,c.sec_no,c.username FROM course a JOIN offer_course b ON a.course_code = b.offered_course_code JOIN assign_course c ON b.offered_course_code = c.offered_course_code WHERE c.id='$id' AND c.username='$username'";
		    if($result=mysqli_query($connection,$sql)){
		        if(mysqli_num_rows($result)>0){
		            $row=mysqli_fetch_array($result);
		            $course_code = $row["offered_course_code"];
		            $sec_no = $row["sec_no"];
		            $semester = $row["semester"];
		            $year = $row["year"];
					$username=$row['username'];
					
					
		            }
		        }
?>	
    <div id="chart-container">
        <canvas id="mycanvas"></canvas>
    </div>
    <script type="text/javascript">
    $(document).ready(function() {
	    function myFunction(x,y) {
        var id=y;
        var username=x;
        swal(id);
    $.ajax({
        type: "GET",
        url: 'po_att_graph.php',
        data: { 
                id:id,
                username:username
            }
        success: function(data) {
            console.log(data);
            var po = [];
            var po_per = [];

            for (var i in data) {
                po.push(data[i].po);
                po_per.push(data[i].po_per);
            }
            alert( po_per);
            var chartdata = {
                labels: po,
                datasets: [{
                    label: 'Percentage of Students',
                    backgroundColor: 'rgba(31, 150, 134, 0.75)',
                    borderColor: 'rgba(31, 150, 134, 0.75)',
                    hoverBackgroundColor: 'rgba(16, 185, 232, 1)',
                    hoverBorderColor: 'rgba(16, 185, 232, 1)',
                    data: po_per
                }]
            };

            var ctx = $("#mycanvas");

            var barGraph = new Chart(ctx, {
                type: 'bar',
                data: chartdata
            });
        },
        error: function(data) {
            console.log(data);
        }
    });
}
});
</body>
</html>