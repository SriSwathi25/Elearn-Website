<?php
require_once "bootstrap.php";
?>
<nav class="navbar navbar-inverse">
  <div class="container-fluid">
    <div class="navbar-header">
      <a class="navbar-brand">ELearn</a>
    </div>
    <?php
    if($_SESSION['user']=='student'){
        echo('<ul class="nav navbar-nav">');
        echo('<li class="active"><a href="index.php">Home</a></li>');
        echo('<li><a href="#">My Courses</a></li>');
        echo('</ul>');
        echo('<ul class="nav navbar-nav navbar-right">');
        echo('<li><a class="navbar-brand">'.$_SESSION['username'].'</a></li>');
        echo('<li><a href="logout.php">Logout</a></li>');

        echo('</ul>');
    }
    else if ($_SESSION['user']=='teacher'){
        echo('<ul class="nav navbar-nav">');
        echo('<li class="active"><a href="index.php">Home</a></li>');
        echo('<li><a href="#">My Courses</a></li>');
        echo('<li><a href="addCourse.php">Add Courses</a></li>');
        echo('</ul>');
        echo('<ul class="nav navbar-nav navbar-right">');
        echo('<li><a class="navbar-brand">'.$_SESSION['username'].'</a></li>');
        echo('<li><a href="logout.php">Logout</a></li>');

        echo('</ul>');
    }
    ?>
  </div>
</nav>