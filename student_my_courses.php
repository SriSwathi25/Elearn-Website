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
if(isset($_GET['student_id'])){
    if(strlen($_GET['student_id'])<1){
        header("Location:../index.php");
        return;
    }
$student_id = $_GET['student_id'];

$sql = "SELECT * from course where course_id in (select course_id from enrollment where student_id=:a)";
$stmt = $pdo->prepare($sql);
$stmt->execute(array(
    ':a' => $student_id
));
while($res = $stmt->fetch(PDO::FETCH_ASSOC)){
echo("<div class='row' style='align-items:center;'>");
        echo("<div class='container' style='align-items:center; '>");
        echo("<div class='jumbotron' style='background-color:#fcbf49;'>");
        echo("<h1 class='text-center'><a href='/Elearn/student_course_page.php/?course_id=".$res['course_id']."'>".$res['course_name']."</a></h1>");
        echo("</div>");
        echo("</div>");
        echo("</div>");
}


}
?>