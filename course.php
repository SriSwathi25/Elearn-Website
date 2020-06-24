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
if(isset($_GET['course_id'])){
    if(strlen($_GET['course_id'])<1){
        header("Location:../index.php");
        return;
    }
$course_id = $_GET['course_id'];
$sql1 = "SELECT * from module where course_id=:a ORDER BY module_number";
$stmt1 = $pdo->prepare($sql1);
$stmt1->execute(
    array(
        ':a' => $course_id
    )
    );
    $empty = FALSE;
    if($stmt-> rowCount() == 0){
        $empty = TRUE;
        echo("Nothing to show..."); 
    }

$sql = "SELECT * from course where course_id=:cid";
$stmt = $pdo->prepare($sql);
$stmt->execute(
    array(
        ':cid' => $course_id
    )
    );
$course = $stmt->fetch();
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
    <link rel="stylesheet" href="mystyle.css" >
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
    <div class="container-fluid" style="border-radius:0.5em;width:80%;background-color:#fcbf49;" >
    <br>
    <br>
    <?php
    echo("<h1 style='font-size:50px;' class='text-center'>".$course['course_name']."</h1>");
    echo("<button class='btn btn-warning' style='float:right;'><a href='../addModule.php/?course_id=".$course['course_id']."'>Add Module</a></button><br><br>");

        while($row = $stmt1->fetch(PDO::FETCH_ASSOC)){
        echo("<div class='row' style='align-items:center;'>");
        echo("<div class='container ' style='margin:auto;'>");
        echo("<div class='jumbotron' style='background-color:#ffffff;margin:auto;'>");
        echo("<h1>".$row['module_title']."</h1><br>");
        echo("<button class='btn btn-warning' style='float:right;'><a href='../edit_module.php/?course_id=".$course_id."&module_id=".$row['module_id']."'>Edit Module</a></button><br><br>");

        echo("<button class='btn btn-danger' style='float:right;'><a href='../delete_module.php/?course_id=".$course_id."&module_id=".$row['module_id']."'>DELETE Module</a></button><br><br>");

        $video_loc = $row['module_video'];
        $res_loc = $row['module_resources'];
        #echo("<h1>".$video_loc."</h1><br>");
        echo("<video src='../".$video_loc."' controls width='1000px' height='500px' ></video><br>");
        echo("<br><br>");
        #echo("<video src='C:\xampp\htdocs\Elearn\videos' controls width='320px' height='200px' >");
        echo("<div class='container-fluid' style='align-items:center;'>");
        echo("<div class='jumbotron ' style='background-color:#fcbf49;color:#ffffff; width:100%; margin:auto;'>");        
        echo("<h2>Notes :</h2><br>");
        echo("<p>".html_entity_decode($row['module_content'])."</p>");
        echo("</div>");
        echo("</div>");
        echo("<br><br>");

        echo("<div class='container' style='align-items:center;'>");
        echo("<div class='jumbotron' style='background-color: #212529;color:#ffffff; width:50%; margin:auto; padding:10px;'>");        
        echo("<h2>Resources :</h2><br>");
        echo("<a href='../".$res_loc."'>Click here to download module resource files.</a>");
        echo("</div>");
        echo("</div>");
        echo("<br><br>");


        
        echo("</div>");
        echo("<br><br>");
        echo("</div>");
        echo("</div>");

    }

    ?>
    
    </div>

    
</body>
</html>