<?php
session_start();
require_once "pdo.php";
require_once "bootstrap.php";
#include("banner.html");
include("_navbar.php");
#takes course_id and module_id
if(isset($_GET['course_id'])){
    if(strlen($_GET['course_id']) < 1){
        $_SESSION['error'] = "<ul><li class='alert-danger'>Invalid Update Request.</li></ul>";
        echo("BURRR");
        return;
    }
$course_id = $_GET['course_id'];
$sql1 = "SELECT * from course where course_id=:a";
$stmt1 = $pdo->prepare($sql1);
$stmt1->execute(
    array(
        ':a' => $course_id
    )
    );
}
if(isset($_POST['cancel'])){

    header("Location:../course.php/?course_id=".$course_id);
    return;
}
if(isset($_POST['publish'])){
    $sql = "INSERT into publish(course_id) values(:a)";
$stmt = $pdo->prepare($sql);
$stmt->execute(
    array(
        ':a' => $course_id
    ));
    $_SESSION['success'] = "<ul><li class='alert-danger'>Congratulations..! Course Published Successfully.</li></ul>";

    header("Location:../course.php/?course_id=".$course_id);
    return;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete Module</title>
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
    <h1>Are you sure you want to publish this course?</h1>
<form method="post">
<button class = 'btn btn-lg btn-default' name="publish" type="submit">Publish</button>
<button  class = 'btn btn-lg btn-warning' name="cancel">Cancel</button>
</form>
</body>
</html>