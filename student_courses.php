<?php
session_start();
require_once "pdo.php";
require_once "bootstrap.php";
echo("<style>");
include 'mystyle.css';
echo("</style>");
#include("banner.html");
include("_navbar.php");
#echo("Heyy");
/************** Displaying all published courses*/
$sql = "SELECT * from course where course_id in (select course_id from publish)";
$stmt = $pdo->prepare($sql);
$stmt->execute();
if($stmt->rowCount() == 0){
    echo("ERROR : No Courses to show...");
}
$sql3 = "SELECT * from student where student_username=:a";
$stmt3 = $pdo->prepare($sql3);
$stmt3->execute(array(
    ':a' => $_SESSION['username']
));
$a1 = $stmt3->fetch();
$student_id = $a1['student_id'];

while($res = $stmt->fetch(PDO::FETCH_ASSOC)){
#echo($res['course_name']);
echo("<div class='row' style='align-items:center;'>");
        echo("<div class='container' style='align-items:center; '>");
        echo("<div class='jumbotron' style='background-color:#fcbf49;'>");
        $sql2 = "SELECT * from enrollment where student_id=:a and course_id=:b";
$stmt2 = $pdo->prepare($sql2);
$stmt2->execute(array(
    ':a' => $student_id,
    ':b' => $res['course_id']
));
$enrolled = FALSE;
if($stmt2->rowCount() >0){
    $enrolled = TRUE; 
}
if($enrolled){
    echo("<button class='btn btn-lg btn-success btn-disabled' style='float:right'>Enrolled</button>");
}
        echo("<h1 class='text-center'><a href='/Elearn/student_course_page.php/?course_id=".$res['course_id']."'>".$res['course_name']."</a></h1>");
        echo("</div>");
        echo("</div>");
        echo("</div>");
}

?>