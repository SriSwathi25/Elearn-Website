<?php
session_start();
require_once "pdo.php";
require_once "bootstrap.php";
echo("<style>");
include 'mystyle.css';
echo("</style>");
#include("banner.html");
include("_navbar.php");
#var_dump($_GET);
if(isset($_GET['course_id']) && isset($_GET['student_id'])){
    if(strlen($_GET['course_id'])<1 || strlen($_GET['student_id'])<1 ){
        header("Location:../index.php");
        return;
    }

$course_id = $_GET['course_id'];
$student_id = $_GET['student_id'];

if(isset($_POST['enroll'])){
    $boo = "INSERT into enrollment(course_id,student_id) values(:a,:b)";
    $boww = $pdo->prepare($boo);
    $boww->execute(array(
        ':a' => $course_id,
        ':b' => $student_id
    ));
    $_SESSION['success'] = "<ul><li class='alert-success'>Enrolled Successfully.</li></ul>";
            header("Location:/Elearn/student_my_courses.php/?student_id=".$student_id);
            return;} 
}


$sql = "SELECT * from course where course_id=:cid";
$stmt = $pdo->prepare($sql);
$stmt->execute(
    array(
        ':cid' => $course_id
    )
    );
    $course = $stmt->fetch(PDO::FETCH_ASSOC);




    echo("<h1 style='font-size:50px;' class='text-center'>".$course['course_name']."</h1>");
$sql2 = "SELECT * from teacher where teacher_id=:tid";
$stmt2 = $pdo->prepare($sql2);
$stmt2->execute(
    array(
        ':tid' => $course['teacher_id']
    )
    );
$teacher = $stmt2->fetch();
    echo("<p style='font-size:25px;' class='text-center'>Course By : Prof.  ".$teacher['teacher_name']."</hp>");

    $sql1 = "SELECT * from module where course_id=:a ORDER BY module_number";
$stmt1 = $pdo->prepare($sql1);
$stmt1->execute(
    array(
        ':a' => $course_id
    )
    );
    echo('<h1>Course Contents :</h1>');
    echo('<div class="container-fluid" style="border-radius:0.5em;width:80%;background-color:#fcbf49;" >');
    while($module = $stmt1->fetch(PDO::FETCH_ASSOC)){
        echo("<p style='font-size:25px;'>".$module['module_number'].". ".$module['module_title']."</p>");
    }
    echo("<div>");



?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Enroll</title>
</head>
<body>
    <form  method="post">
        <button type='submit' name='enroll' class='btn btn-success'>Enroll</button>
    </form>
    
</body>
</html>