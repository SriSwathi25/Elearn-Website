<?php
session_start();
require_once "pdo.php";
require_once "bootstrap.php";
echo("<style>");
include 'mystyle.css';
echo("</style>");
#include("banner.html");
include("_navbar.php");
#takes course_id and module_id
if(isset($_GET['course_id']) && isset($_GET['module_id'])){
    if(strlen($_GET['course_id']) < 1 || strlen($_GET['module_id']) < 1){
        $_SESSION['error'] = "<ul><li class='alert-danger'>Invalid Update Request.</li></ul>";
        header("Location:../index.php");
        return;
    }
$course_id = $_GET['course_id'];
$module_id = $_GET['module_id'];
$sql1 = "SELECT * from module where course_id=:a and module_id=:b ORDER BY module_number";
$stmt1 = $pdo->prepare($sql1);
$stmt1->execute(
    array(
        ':a' => $course_id,
        ':b' => $module_id
    )
    );
}
if(isset($_POST['cancel'])){

    header("Location:../course.php/?course_id=".$course_id);
    return;
}
if(isset($_POST['delete'])){
    $sql = "DELETE from module where course_id=:a and module_id=:b";
$stmt = $pdo->prepare($sql);
$stmt->execute(
    array(
        ':a' => $course_id,
        ':b' => $module_id
    ));
    $_SESSION['success'] = "<ul><li class='alert-danger'>Module Deleted Successfully.</li></ul>";

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
    <h1>Are you sure you want to delete this module ?</h1>
<form method="post">
<button class = 'btn btn-lg btn-default' name="delete" type="submit">Delete</button>
<button  class = 'btn btn-lg btn-warning' name="cancel">Cancel</button>
</form>
</body>
</html>
