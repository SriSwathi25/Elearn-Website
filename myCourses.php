<?php
session_start();
require_once "pdo.php";
include "bootstrap.php";
echo("<style>");
include 'mystyle.css';
echo("</style>");
#include("banner.html");
include("_navbar.php");
#var_dump($_GET);
if(isset($_GET['t_id'])){
    if(strlen($_GET['t_id'])<1){
        header("Location:../index.php");
        return;
    }
$teacher_id = $_GET['t_id'];
$sql = "SELECT * from course where teacher_id=:tid";
$stmt = $pdo->prepare($sql);
$stmt->execute(
    array(
        ':tid' => $teacher_id
    )
    );
    $empty = FALSE;
    if($stmt-> rowCount() == 0){
        $empty = TRUE;
         
    }
}
else{
    header("Location:../index.php");
    return;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Courses</title>
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
    <div class="container" style="border-radius:0.5em;;width:80%;background-color:#84a50d;" >
    <br><br>
    <?php
    if($empty){
        echo("<h1 class='text-center'>No Courses by you yet...</h1>");
    }
    else{

        while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        echo("<div class='row' style='align-items:center;'>");
        echo("<div class='container col-sm-12 col-md-12 col-lg-12' style='align-items:center;'>");
        echo("<div class='jumbotron'>");

        $sql2 = "SELECT * from Publish where course_id=:cid";
$stmt2 = $pdo->prepare($sql2);
$stmt2->execute(
    array(
        ':cid' => $row['course_id']
    )
    );
    if($stmt2->rowCount() == 0){
        echo("<button class='btn btn-lg btn-success'><a href='../publish.php/?course_id=".$row['course_id']."'>Publish</a></button>");
    }else{
        echo("<button class='btn btn-lg btn-success btn-disabled'>Published</button>");

    }
        echo("<h1 class='text-center'><a href='../course.php/?course_id=".$row['course_id']."'>".$row['course_name']."</a></h1>");
        echo("</div>");
        echo("</div>");
        echo("</div>");


        
        }
    }

    ?>
    
    </div>

    
</body>
</html>