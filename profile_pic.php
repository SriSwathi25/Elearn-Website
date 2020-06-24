<?php
require_once "pdo.php";
require_once "bootstrap.php";
echo("<style>");
include 'mystyle.css';
echo("</style>");
if(isset($_SESSION['user'])){
if($_SESSION['user']=='student'){
    $sql = "SELECT * from student where student_username=:name";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(array(
      ':name' => $_SESSION['username']
  ));
  $ans = $stmt->fetch();
  $student_id = $ans['student_id'];
  $loc = $ans['student_photo'];
  if($loc==NULL){
      $loc = "pics/student.png";
  }
}
else if ($_SESSION['user']=='teacher'){
    $sql = "SELECT * from teacher where teacher_username=:name";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(array(
      ':name' => $_SESSION['username']
  ));
  $ans = $stmt->fetch();
  $teacher_id = $ans['teacher_id'];
  $loc = $ans['teacher_photo'];
  if($loc==NULL){
      $loc = "pics/teacher.png";
  }
}
echo('<div id="about-img">');
    echo('<a href="'.$loc.'"><img class="profile-photo" align="middle" height="150px" width="150px" style="border-radius:50%; border:20px; float:right;" src="'.$loc.'" /></a>');
echo('</div>');
}
?>
