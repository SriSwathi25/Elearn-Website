<?php
session_start();
require_once "pdo.php";
require_once "bootstrap.php";
include("banner.html");
include("_navbar.php");
#echo("BOOOM");
#var_dump($_POST);
if(isset($_POST['module_number']) && isset($_POST['module_title']) && (isset($_FILES["module_video"]["tmp_name"]) || is_uploaded_file($_FILES["module_video"]["tmp_name"])) &&  isset($_POST['module_notes'])  ){
    echo("HIII");
    /*if(strlen($_POST['module_number'])<1 || strlen($_POST['module_title'])<1 || strlen($_POST['module_notes'])<1 || !( isset($_FILES["module_video"]["tmp_name"]) || is_uploaded_file($_FILES["module_video"]["tmp_name"]) ) )
    {
        $_SESSION['error'] =  "<ul><li class='alert-danger text-center'>Add all required fields to upload Module successfully</li></ul>";
        header("Location:addModule.php");
        return;

    }
    */
    #echo("I am outt");
    if(isset($_FILES["module_video"]["tmp_name"]) || is_uploaded_file($_FILES["module_video"]["tmp_name"]) ){
        $target_dir = "videos/";
        #$target_file = $target_dir . $_POST['newname'];
 
        // Select file type
        $video = $_FILES["module_video"]["name"];
        $FileType = strtolower(pathinfo($_FILES["module_video"]["name"],PATHINFO_EXTENSION));

        $target_file = $target_dir . $_SESSION['course_name'] ."_". $_POST['module_number'] .".". $FileType;
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

    $target_file = $target_dir . $_session['course_name'] ."_". $_POST['module_number'] .".". $FileType;
    $module_resources = $target_file;
    

         if(move_uploaded_file($_FILES["module_resources"]["tmp_name"], $target_file)){
            echo($target_file);
             $module_resources = $target_file;
            }
}
else{
    $module_resources = NULL;
}
    $sql = "SELECT * from course where course_name=:name";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(array(
        ':name' => $_SESSION['course_name']
    ));
    if($stmt->rowCount() == 0){

    $sql = "SELECT * from teacher where teacher_username=:name";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(array(
        ':name' => $_SESSION['username']
    ));
    $ans = $stmt->fetch();
    $teacher_id = $ans['teacher_id'];

    
    $course_name = $_SESSION['course_name'];

    $sql2 = "INSERT into course(course_name,teacher_id) values(:a,:b)";
    $stmt2 = $pdo->prepare($sql2);
    $stmt2->execute(array(
        ':a' => $course_name,
        ':b' => $teacher_id
    ));
    }

    $sql = "SELECT * from course where course_name=:name";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(array(
        ':name' => $_SESSION['course_name']
    ));
    $row = $stmt->fetch();

    $course_id = $row['course_id'];
        
    $sql = "INSERT into module (course_id,module_number, module_video,module_content,module_resources) values(:a,:b,:c,:d,:e)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(
        array(
            ':a' => $course_id,
            ':b' => $_POST['module_number'],
            ':c' => $module_video,
            ':d' => $_POST['module_notes'],
            ':e' => $module_resources
            
            ));
            $_SESSION['success'] = "<ul><li class='alert-success'>Module Uploaded Successfully.</li></ul>";
            header("Location:addModule.php");
            return;


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
if(!isset($_SESSION['course_name'])){
    $_SESSION['error'] = "<ul><li class='alert-danger text-center'>Go to Add Courses, Enter Course Name to proceed further</li></ul>";
    echo("<h1>".$_SESSION['error']."</h1>");
    return;
     
}
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
    <h2 style="display:inline;">Add Modules for </h2><h1 style="display:inline;"> <?= htmlentities($_SESSION['course_name']) ?></h1>
    <p>Module Resources are optional. Provide if necessary.</p>
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