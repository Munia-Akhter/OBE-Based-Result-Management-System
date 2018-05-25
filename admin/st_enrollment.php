<?php include("db.php");
?>
<html lang="en">
 <head>
  <meta charset="utf-8">
  <title>Upload Excel file of student enrollment </title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="title" content="Hemant Vishwakarma">
  <meta name="description" content="Import Excel File To MySql Database Using php">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
 </head>
 <body>    
    <br><br>
        <div class="container">
            <div class="row">
             <div class="col-md-12 text-center"></div><h1>Student Enrollment</h1>
    <br>
                <div class="col-md-3 hidden-phone"></div>
                <div class="col-md-6" id="form-login">
                    <form class="well" action="import_st_enrollment.php" method="post" name="upload_excel" enctype="multipart/form-data">
                        <fieldset>
                            <legend>Upload xls/xlsx/csv-Excel file</legend>
                            <div class="control-group">
                                <div class="control-label">
                                    <label>xls/xlsx/csv-Excel:</label>
                                </div>
                                <div class="controls form-group">
                                    <input type="text" name="course_code" class="input-large form-control" placeholder="Enter Course Code" required>
                                    <br>
                                    <input type="text" name="sec_no" class="input-large form-control" placeholder="Enter Section" required>
                                    <br>
                                    <input type="file" name="file" id="file" class="input-large form-control" required>
                                </div>
                            </div>
                            
                            <div class="control-group">
                                <div class="controls">
                                <button type="submit" id="submit" name="Import" class="btn btn-success btn-flat btn-lg pull-right button-loading" data-loading-text="Loading...">Upload</button>
                                </div>
                            </div>
                        </fieldset>
                    </form>
                </div>
                <div class="col-md-3 hidden-phone"></div>
            </div>
            
        </div>
 </body>
</html>