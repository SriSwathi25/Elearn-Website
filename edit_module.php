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
        header("Location:index.php");
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


    $sql = "SELECT * from course where course_id=:id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(array(
        ':id' => $course_id
    ));
    $row = $stmt->fetch();
    $course_name = $row['course_name'];

$old = $stmt1->fetch();

    if(isset($_POST['module_number']) && isset($_POST['module_title']) &&  isset($_POST['module_notes'])  ){
        echo("HIII");
        /*if(strlen($_POST['module_number'])<1 || strlen($_POST['module_title'])<1 || strlen($_POST['module_notes'])<1 || !( isset($_FILES["module_video"]["tmp_name"]) || is_uploaded_file($_FILES["module_video"]["tmp_name"]) ) )
        {
            $_SESSION['error'] =  "<ul><li class='alert-danger text-center'>Add all required fields to upload Module successfully</li></ul>";
            header("Location:addModule.php");
            return;
    
        }
        */
        #echo("I am outt");
        if(is_uploaded_file($_FILES["module_video"]["tmp_name"]) ){
            
            $target_dir = "videos/";
            #$target_file = $target_dir . $_POST['newname'];
     
            // Select file type
            $video = $_FILES["module_video"]["name"];
            $FileType = strtolower(pathinfo($_FILES["module_video"]["name"],PATHINFO_EXTENSION));
    
            $target_file = $target_dir . $course_name ."_". $_POST['module_number'] .".". $FileType;
            $module_video = $target_file;
            #echo($target_file);
                 if(move_uploaded_file($_FILES["module_video"]["tmp_name"], $target_file)){
                     echo($target_file);
                     $module_video = $target_file;
        }
        //**********
        if(is_uploaded_file($_FILES["module_resources"]["tmp_name"]) ){
            $target_dir = "resources/";
            #$target_file = $target_dir . $_POST['newname'];
        
            // Select file type
            $resource = $_FILES["module_resources"]["name"];
            $FileType = strtolower(pathinfo($_FILES["module_resources"]["name"],PATHINFO_EXTENSION));
        
            $target_file = $target_dir . $course_name ."_". $_POST['module_number'] .".". $FileType;
            $module_resources = $target_file;
            
        
                 if(move_uploaded_file($_FILES["module_resources"]["tmp_name"], $target_file)){
                    echo($target_file);
                     $module_resources = $target_file;
                    }
                    $sql = "UPDATE module set module_number=:b, module_title=:f, module_video=:c,module_content=:d,module_resources=:e where course_id=:aa and module_id=:bb";
        $stmt = $pdo->prepare($sql);
        $stmt->execute(
            array(
                ':b' => $_POST['module_number'],
                ':c' => $module_video,
                ':d' => $_POST['module_notes'],
                ':e' => $module_resources,
                ':f' => $_POST['module_title'],
                ':aa' => $course_id,
                ':bb' => $module_id
                
                ));

        }
        else{
            $sql = "UPDATE module set module_number=:b, module_title=:f, module_video=:c,module_content=:d where course_id=:aa and module_id=:bb";
        $stmt = $pdo->prepare($sql);
        $stmt->execute(
            array(
                ':b' => $_POST['module_number'],
                ':c' => $module_video,
                ':d' => $_POST['module_notes'],
                
                ':f' => $_POST['module_title'],
                ':aa' => $course_id,
                ':bb' => $module_id
                
                ));
        }
         
    }
    else{   
        echo("I am here");
        $sql = "UPDATE module set module_number=:b, module_title=:f,module_content=:d where course_id=:aa and module_id=:bb";
        $stmt = $pdo->prepare($sql);
        $stmt->execute(
            array(
                ':b' => $_POST['module_number'],
                ':d' => $_POST['module_notes'],                
                ':f' => $_POST['module_title'],
                ':aa' => $course_id,
                ':bb' => $module_id
                
                ));
                
            } 
        
            $_SESSION['success'] = "<ul><li class='alert-success'>Module UPDATED Successfully.</li></ul>";
            header("Location:../course.php/?course_id=".$course_id);
            return;} 
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="//cdn.ckeditor.com/4.14.1/standard/ckeditor.js"></script>
    <title>Add Course</title>
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
    <div class="container-fluid" style="border-radius:0.5em;;width:60%;background-color:#f7ede2;">
    <h2 style="display:inline;">Update Module Here...</h1>
    <p>** Upload module Videos and resources again</p>
    <br>
    <br>
    <form method="post" enctype="multipart/form-data">
            <label for="module_number" style="font-size:1.5em;">Module Number :</label>
            <p>(Start Numbering the modules of the course from 1)</p>
             <input type="number" class="form-control" name="module_number" id="module_number" value="<?= htmlentities($old['module_number']) ?>">             
             <br>
             <label for="module_title" style="font-size:1.5em;">Module Title :</label>
             <input type="text" class="form-control" name="module_title" id="module_title" value="<?= htmlentities($old['module_title']) ?>">             
             <br>
             <label for="module_video" style="font-size:1.5em;">Module Video :</label>
             <input type="file" class="form-control" name="module_video" id="module_video">             
             <br>
             <label for="module_notes" style="font-size:1.5em;">Module Notes :</label>
             <textarea class="form-control" name="module_notes" id="module_notes" rows=20 cols=30><?= html_entity_decode($old['module_title']) ?></textarea>
             <script type="text/javascript">
                CKEDITOR.replace('module_notes');
            </script>
             <br>
             <label for="module_resources" style="font-size:1.5em;">Module Resources :</label>
             <p>(Notes in PDF Format or PPT Only)</p>
             <input type="file" class="form-control" name="module_resources" id="module_resources">             
             <br>
             <input  type="submit" style="float:center;" class="btn btn-lg btn-success" value="Update Module">
             <br>
             <br>
    </form>
    </div>    
</body>
</html>