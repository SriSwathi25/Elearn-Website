<?php
require_once "pdo.php";
require_once "bootstrap.php";
echo("<style>");
include 'mystyle.css';
echo("</style>");
?>
<nav class="navbar navbar-inverse">
  <div class="container-fluid">
    <div class="navbar-header">
      <a class="navbar-brand">ELearn</a>
    </div>
    <?php
    if($_SESSION['user']=='student'){
      $sql = "SELECT * from student where student_username=:name";
      $stmt = $pdo->prepare($sql);
      $stmt->execute(array(
        ':name' => $_SESSION['username']
    ));
    $ans = $stmt->fetch();
    $student_id = $ans['student_id'];
        echo('<ul class="nav navbar-nav">');
        echo('<li class="active"><a href="/Elearn/index.php">Home</a></li>');
        echo('<li><a href="/Elearn/student_courses.php">Courses</a></li>');
        echo('</ul>');
        echo('<ul class="nav navbar-nav navbar-right">');
        echo('<li><a href="/Elearn/student_my_courses.php/?student_id='.$student_id.'">My Courses</a></li>');
        echo('<li><a class="navbar-brand">'.$_SESSION['username'].'</a></li>');
        echo('<li><a href="logout.php">Logout</a></li>');

        echo('</ul>');
    }
    else if ($_SESSION['user']=='teacher'){
      $sql = "SELECT * from teacher where teacher_username=:name";
      $stmt = $pdo->prepare($sql);
      $stmt->execute(array(
        ':name' => $_SESSION['username']
    ));
    $ans = $stmt->fetch();
    $teacher_id = $ans['teacher_id'];
        echo('<ul class="nav navbar-nav">');
        echo('<li class="active"><a href="index.php">Home</a></li>');
        echo('<li><a href="/Elearn/myCourses.php/?t_id='.$teacher_id.'">My Courses</a></li>');
        echo('<li><a href="/Elearn/addCourse.php">Add Courses</a></li>');
        echo('</ul>');
        echo('<ul class="nav navbar-nav navbar-right">');
        echo('<li><a class="navbar-brand">'.$_SESSION['username'].'</a></li>');
        echo('<li><a href="logout.php">Logout</a></li>');
        echo('</ul>');
    }
    ?>
  </div>
</nav>