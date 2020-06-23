<?php
session_start();
require_once "pdo.php";
require_once "bootstrap.php";
include("banner.html");
include("_navbar.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Course</title>
</head>
<body>
<?php
    if(isset($_SESSION['error'])){
        echo $_SESSION['error'];
        unset($_SESSION['error']);
    }
    if(isset($_SESSION['success'])){
        echo $_SESSION['success'];
        unset($_SESSION['success']);
    }
    ?>
    <div class="container-fluid" style="border-radius:0.5em;;width:60%;background-color:#84a59d;">
    <form method="post" enctype="multipart/form-data">
            <label for="course_name" style="font-size:1.5em;">Course Name :</label>
            <p>Course Name should be informative. Please include attractive and suitable title for your course.</p>
             <input type="text" class="form-control" name="course_name" id="course_name" >
             
             <br>
             <input style="float:right;" type="submit" class="btn btn-lg btn-info" value="+Add Module">
             <br>
             <br>
    </form>
    </div>
    <?php
    if(isset($_POST['course_name'])){
        if(strlen($_POST['course_name'])>1){
        $_SESSION['course_name'] = $_POST['course_name'];
        header("Location:addModule.php");
        return;
        }
        else{
            $_SESSION['error'] = "<ul><li class='alert-warning'>Enter Course Name to proceed further</li></ul>";
            header("Location:addCourse.php");
        return;
        }
    }


?>
    
</body>
</html>