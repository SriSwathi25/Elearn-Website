

<?php
#TRASH>>>NOT USINGGGGG
#IF USING CHNAGE SESSION FOR COURSE NAME
session_start();
require_once "pdo.php";
require_once "bootstrap.php";
include("banner.html");
include("_navbar.php");
echo("<style>");
include 'mystyle.css';
echo("</style>");
if(isset($_GET['course_id'])){
    if(strlen($_GET['course_id'])<1){
        header("Location:../index.php");
        return;
    }
$course_id = $_GET['course_id'];

$sql = "SELECT * from course where course_id=:cid";
$stmt = $pdo->prepare($sql);
$stmt->execute(
    array(
        ':cid' => $course_id
    )
    );
$course = $stmt->fetch();


}
if(isset($_POST['course_name'])){
    if(strlen($_POST['course_name'])>1){
    $_SESSION['course_name'] = $_POST['course_name'];
    $sql2 = "UPDATE course set course_name=:a where course_id=:b";
$stmt2 = $pdo->prepare($sql2);
$stmt2->execute(
    array(
        ':b' => $course_id,
        ':a' => $_POST['course_name']    )
    );
    $_SESSION['success'] = "<ul><li class='alert-success'>Course Name updated.</li></ul>";
        header("Location:../course.php/?course_id=".$course_id);
    return;
    }
    else{
        $_SESSION['error'] = "<ul><li class='alert-warning'>Enter Course Name to proceed further</li></ul>";
        header("Location:../addCourse.php");
    return;
    }
}

/*
else{
    header("Location:../index.php");
    return;
}
*/


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Course</title>
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
            <label for="course_name" style="font-size:1.5em;">New Course Name :</label>
            <p>Course Name should be informative. Please include attractive and suitable title for your course.</p>
             <input type="text" class="form-control" name="course_name" id="course_name" value="<?= htmlentities($course['course_name']) ?>" >
             
             <br>
             <input style="margin:auto;" type="submit" class="btn btn-lg btn-info" value="Update">
             <br>
             <br>
    </form>
    </div>

    
</body>
</html>