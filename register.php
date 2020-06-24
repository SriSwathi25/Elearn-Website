<?php
session_start();
require_once "pdo.php";
require_once "bootstrap.php";
echo("<style>");
include 'mystyle.css';
echo("</style>");
include("banner.html");
include("_navbar.php");
echo("<h1><em><center>Register here...</em></center></h1>");
try{
if(isset($_POST['name']) && isset($_POST['dob']) && isset($_POST['username']) && isset($_POST['email']) && isset($_POST['pass']) && isset($_POST['user_is']) ){

        if($_POST['user_is'] == 'student'){
            echo("I am in student");
            $sql = "SELECT * from student where student_email=:email";
            $sql2 = "SELECT * from teacher where teacher_email=:email";
            
            $stmt = $pdo->prepare($sql);
                        $stmt->execute(array(
                            
                            ':email' => $_POST['email']
                        ));
            $stmt2 = $pdo->prepare($sql2);
            $stmt2->execute(array(
                
                ':email' => $_POST['email']
            ));
            #$row = $stmt->fetch();
            if($stmt->rowCount() > 0 || $stmt2->rowCount() > 0 ){
                $_SESSION['error'] = "<ul><li class='alert-danger'>A User with this email Address already exists. Please try another one.</li></ul>";
            header("Location:register.php");
            return;

            }
            $sql = "SELECT * from student where student_username=:uname";
            $sql2 = "SELECT * from teacher where teacher_username=:uname";
            
            $stmt = $pdo->prepare($sql);
                        $stmt->execute(array(
                            
                            ':uname' => $_POST['username']
                        ));
            $stmt2 = $pdo->prepare($sql2);
            $stmt2->execute(array(
                ':uname' => $_POST['username']
            ));
            #$row = $stmt->fetch();
            if($stmt->rowCount() > 0 || $stmt2->rowCount() > 0){
                $_SESSION['error'] = "<ul><li class='alert-danger'>A User with this Username already exists. Please try another one.</li></ul>";
            header("Location:register.php");
            return;

            }
            $pass = hash('md5',$_POST['pass']);

            if(isset($_FILES["pic"]["tmp_name"]) && is_uploaded_file($_FILES["pic"]["tmp_name"])){
                #echo("I am in picc");
                $target_dir = "pics/";
                #$target_file = $target_dir . $_POST['newname'];
         
                // Select file type
                $pic = $_FILES["pic"]["name"];
                $target_file = $target_dir . $_POST['username'] . ".jpg";
                echo($_FILES["pic"]['tmp_name']);
         
                     if(move_uploaded_file($_FILES['pic']['tmp_name'], $target_file)){
                        $sql = "INSERT into student (student_name, student_dob, student_username, student_email, student_pass, student_photo) values(:name, :dob, :uname, :email, :pass, :pic)";
                        $stmt = $pdo->prepare($sql);
                        $stmt->execute(array(
                            ':name' => $_POST['name'],
                            ':dob' => $_POST['dob'],
                            ':email' => $_POST['email'],
                            ':pass' => $pass,
                            ':uname' => $_POST['username'],
                            ':pic' => $target_file
                        ));
                       // Insert record
                       $_SESSION['success'] = "<ul><li class='alert-danger'>Account Created Successfully. Please Login.</li></ul>";
                       error_log("Registration Success : ".$_POST['email']);
            header("Location:login.php");
            return;
                    }
                    #}
            
            }
            else{
                #echo("BOOOO");
                $sql = "INSERT into student (student_name, student_dob, student_username, student_email, student_pass) values(:a, :b, :e, :c, :d)";
                $stmt = $pdo->prepare($sql);
                $stmt->execute(array(
                            ':a' => $_POST['name'],
                            ':b' => $_POST['dob'],
                            ':c' => $_POST['email'],
                            ':d' => $pass,
                            'e' => $_POST['username']
                        ));
                       // Insert record
                       $_SESSION['success'] = "<ul><li class='alert-danger'>Account Created Successfully. Please Login.</li></ul>";
                       error_log("Registration Success : ".$_POST['email']);
            header("Location:login.php");
            return;

            }

            
            }
            else if($_POST['user_is'] == 'teacher'){
                #echo("I am in student");
                $sql = "SELECT * from student where student_email=:email";
            $sql2 = "SELECT * from teacher where teacher_email=:email";
            
            $stmt = $pdo->prepare($sql);
                        $stmt->execute(array(
                            
                            ':email' => $_POST['email']
                        ));
            $stmt2 = $pdo->prepare($sql2);
            $stmt2->execute(array(
                
                ':email' => $_POST['email']
            ));
            #$row = $stmt->fetch();
            if($stmt->rowCount() > 0 || $stmt2->rowCount() > 0 ){
                $_SESSION['error'] = "<ul><li class='alert-danger'>A User with this email Address already exists. Please try another one.</li></ul>";
            header("Location:register.php");
            return;

            }
            $sql = "SELECT * from student where student_username=:uname";
            $sql2 = "SELECT * from teacher where teacher_username=:uname";
            
            $stmt = $pdo->prepare($sql);
                        $stmt->execute(array(
                            
                            ':uname' => $_POST['username']
                        ));
            $stmt2 = $pdo->prepare($sql2);
            $stmt2->execute(array(
                ':uname' => $_POST['username']
            ));
            #$row = $stmt->fetch();
            if($stmt->rowCount() > 0 || $stmt2->rowCount() > 0){
                $_SESSION['error'] = "<ul><li class='alert-danger'>A User with this Username already exists. Please try another one.</li></ul>";
            header("Location:register.php");
            return;

            }
            $pass = hash('md5',$_POST['pass']);
    
                if(isset($_FILES["pic"]["tmp_name"]) && is_uploaded_file($_FILES["pic"]["tmp_name"])){
                    echo("I am in picc");
                    $target_dir = "pics/";
                    #$target_file = $target_dir . $_POST['newname'];
             
                    // Select file type
                    $pic = $_FILES["pic"]["name"];
                    $target_file = $target_dir . $_POST['username'] . ".jpg";
                    echo($_FILES["pic"]['tmp_name']);
             
                         if(move_uploaded_file($_FILES['pic']['tmp_name'], $target_file)){
                            $sql = "INSERT into teacher (teacher_name, teacher_dob, teacher_username, teacher_email, teacher_pass, teacher_photo) values(:name, :dob, :uname, :email, :pass, :pic)";
                            $stmt = $pdo->prepare($sql);
                            $stmt->execute(array(
                                ':name' => $_POST['name'],
                                ':dob' => $_POST['dob'],
                                ':email' => $_POST['email'],
                                ':pass' => $pass,
                                ':uname' => $_POST['username'],
                                ':pic' => $target_file
                            ));
                           // Insert record
                           $_SESSION['success'] = "<ul><li class='alert-danger'>Teacher Account Created Successfully. Please Login.</li></ul>";
                           error_log("Registration Success : ".$_POST['email']);
                header("Location:login.php");
                return;
                        }
                        #}
                
                }
                else{
                    #echo("BOOOO");
                    $sql = "INSERT into teacher (teacher_name, teacher_dob, teacher_username, teacher_email, teacher_pass) values(:name, :dob, :uname, :email, :pass)";
                    $stmt = $pdo->prepare($sql);
                    $stmt->execute(array(
                        ':name' => $_POST['name'],
                        ':dob' => $_POST['dob'],
                        ':email' => $_POST['email'],
                        ':pass' => $pass,
                        ':uname' => $_POST['username'],
                    ));
                   // Insert record
                   $_SESSION['success'] = "<ul><li class='alert-danger'>Teacher Account Created Successfully. Please Login.</li></ul>";
                   error_log("Registration Success : ".$_POST['email']);
        header("Location:login.php");
        return;
    
                }
    
                
                }
    }
}
catch(PDOException $e){
    error_log("Registration Error : ".$e->getMessage());
    header("Location:errorPage.php");
    return;
}


?>
<html>
    <title>Elearn:Register</title>
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
        <div class="container">
            <div class="jumbotron" style="background-color: #ee4266; width:50%; margin:auto;">
        <form class="form-group" style="color:ghostwhite; font-size:1.2em;" method="post" enctype="multipart/form-data">
            Name : <input type="text" class="form-control" name="name" required>
            <br>
            Date Of Birth : <input type="date" name="dob" class="form-control" min="<?=date('Y-m-d',strtotime(date('Y-m-d').'-100 years'))?>" max="<?=date('Y-m-d',strtotime(date('Y-m-d').'-6 years'))?>" required >
            <br>
            Register as : 
            <div class="radio">
      <label><input type="radio" name="user_is" value="student" checked required>Student</label>
    </div>
    <div class="radio">
      <label><input type="radio" name="user_is" value="teacher" required >Teacher</label>
    </div>            <br> 
    Username (It must be unique): <input type="text" class="form-control" name="username" required>
    <br>
            Email : <input type="email" class="form-control" name="email" required>
            <br>
            Password : <input type="password" class="form-control" name="pass" required >
            <br>
            Profile Picture(optional) : <input type="file" id="pic" name="pic" >
            <br>
            <center><input type="submit" class="btn-lg btn-success" value="REGISTER"></center>
        </form>
        </div>
        </div>
    </body>
    
</html>