<?php
session_start();
require_once "pdo.php";
require_once "bootstrap.php";
echo("<style>");
include 'mystyle.css';
echo("</style>");
#include("banner.html");
include("_navbar.php");
#echo("BOOOM");
#var_dump($_POST);
if(isset($_GET['course_id'])){
    if(strlen($_GET['course_id']) <1){
        echo("INVALID REQUEST");
        return;
    }
    $course_id = $_GET['course_id'];
    $sql = "SELECT * from course where course_id=:id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(array(
        ':id' => $course_id
    ));
    $row = $stmt->fetch();
    $course_name = $row['course_name'];
    echo('<div class="container-fluid" style="border-radius:0.5em;;width:60%;background-color:#f7ede2;">');
    echo('<h2 style="display:inline;">Add Modules for </h2><h1 style="display:inline;">'.htmlentities($course_name) .'</h1>
    <p>Module Resources are optional. Provide if necessary.</p>');
if(isset($_POST['module_number']) && isset($_POST['module_title']) && (isset($_FILES["module_video"]["tmp_name"]) || is_uploaded_file($_FILES["module_video"]["tmp_name"])) &&  isset($_POST['module_notes'])  ){
    
    if(isset($_FILES["module_video"]["tmp_name"]) || is_uploaded_file($_FILES["module_video"]["tmp_name"]) ){
        $target_dir = "videos/";
        
        $video = $_FILES["module_video"]["name"];
        $FileType = strtolower(pathinfo($_FILES["module_video"]["name"],PATHINFO_EXTENSION));

        $target_file = $target_dir . $course_name."_". $_POST['module_number'] .".". $FileType;
        $module_video = $target_file;
        #echo($target_file);
             if(move_uploaded_file($_FILES["module_video"]["tmp_name"], $target_file)){
                 echo($target_file);
                 $module_video = $target_file;
    }
}

if(isset($_FILES["module_resources"]["tmp_name"]) || is_uploaded_file($_FILES["module_resources"]["tmp_name"]) ){
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

}
else{
    $module_resources = NULL;
}
  
    

    $course_id = $_GET['course_id'];
        
    $sql = "INSERT into module (course_id,module_number, module_title, module_video,module_content,module_resources) values(:a,:b,:f, :c,:d,:e)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(
        array(
            ':a' => $course_id,
            ':b' => $_POST['module_number'],
            ':c' => $module_video,
            ':d' => $_POST['module_notes'],
            ':e' => $module_resources,
            ':f' => $_POST['module_title']
            
            ));
            $_SESSION['success'] = "<ul><li class='alert-success'>Module Uploaded Successfully.</li></ul>";
            header("Location:/Elearn/course.php/?course_id=".$course_id);
            return;

        }
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
    
    
    <br>
    <br>
    <form method="post" enctype="multipart/form-data">
            <label for="module_number" style="font-size:1.5em;">Module Number :</label>
            <p>(Start Numbering the modules of the course from 1)</p>
             <input type="number" class="form-control" name="module_number" id="module_number">             
             <br>
             <label for="module_title" style="font-size:1.5em;">Module Title :</label>
             <input type="text" class="form-control" name="module_title" id="module_title">             
             <br>
             <label for="module_video" style="font-size:1.5em;">Module Video :</label>
             <input type="file" class="form-control" name="module_video" id="module_video">             
             <br>
             <label for="module_notes" style="font-size:1.5em;">Module Notes :</label>
             <textarea class="form-control" name="module_notes" id="module_notes" rows=20 cols=30></textarea>
             <script type="text/javascript">
                CKEDITOR.replace('module_notes');
            </script>
             <br>
             <label for="module_resources" style="font-size:1.5em;">Module Resources :</label>
             <p>(Notes in PDF Format or PPT Only)</p>
             <input type="file" class="form-control" name="module_resources" id="module_resources">             
             <br>
             <input  type="submit" style="float:center;" class="btn btn-lg btn-success" value="Upload">
             <br>
             <br>
    </form>
    </div>    
</body>
</html>