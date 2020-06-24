<?php
session_start();
require_once "pdo.php";
require_once "bootstrap.php";
echo("<style>");
include 'mystyle.css';
echo("</style>");

#include("banner.html");
include("_navbar.php");
    if(isset($_POST['course_name'])){
        if(strlen($_POST['course_name'])>1){
            $sql = "SELECT * from teacher where teacher_username=:name";
            $stmt = $pdo->prepare($sql);
            $stmt->execute(array(
                ':name' => $_SESSION['username']
            ));
            $ans = $stmt->fetch();
            $teacher_id = $ans['teacher_id'];     
            $course_name = $_POST['course_name'];
        
            $sql2 = "INSERT into course(course_name,teacher_id) values(:a,:b)";
            $stmt2 = $pdo->prepare($sql2);
            $stmt2->execute(array(
                ':a' => $course_name,
                ':b' => $teacher_id
            ));

            $sql3 = "Select * from course where course_name=:a and teacher_id=:b";
            $stmt3 = $pdo->prepare($sql3);
            $stmt3->execute(array(
                ':a' => $course_name,
                ':b' => $teacher_id
            ));
            $c = $stmt3->fetch();


            $_SESSION['success'] = "<ul><li class='alert-success'>".$course_name." added successfully !</li></ul>";
            header("Location:addModule.php/?course_id=".$c['course_id']);
        return;

        }
        else{
            $_SESSION['error'] = "<ul><li class='alert-warning'>Enter Course Name to proceed further</li></ul>";
            header("Location:addCourse.php");
        return;
        }
    }
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
    
    
</body>
</html>