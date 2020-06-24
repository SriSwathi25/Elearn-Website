<?php
session_start();
require_once "pdo.php";
require_once "bootstrap.php";
echo("<style>");
include 'mystyle.css';
echo("</style>");
include("banner.html");
include("_navbar.php");
echo("<h1><em><center>Login here...</em></center></h1>");
if(isset($_SESSION['user'])){
    header("Location:index.php");
    return;
}
if(isset($_POST['email']) && isset($_POST['pass'])){
    unset($_SESSION['user']);
    $pass = hash('md5',$_POST['pass']);
    $sql1 = 'SELECT * from student where student_email=:email and student_pass=:pass' ;
    
    $stmt1 = $pdo->prepare($sql1);
    $stmt1->execute(array(
        ':email' => $_POST['email'],
        ':pass' => $pass
    ));
    $sql2 = 'SELECT * from teacher where teacher_email=:a and teacher_pass=:b';
    

    $stmt2 = $pdo->prepare($sql2);
    $stmt2->execute(array(
        ':a' => $_POST['email'],
        ':b' => $pass
    ));

    if($stmt1->rowCount() > 0){
        $res = $stmt1->fetch(PDO::FETCH_ASSOC);
        $_SESSION['user'] = 'student';
        $_SESSION['username'] = $res['student_username'];

        error_log("LOGIN SUCCESS : ". $_POST['email']);
        header("Location:index.php");
        return;
    }

    else if($stmt2->rowCount() > 0){
        $res = $stmt2->fetch(PDO::FETCH_ASSOC);
        $_SESSION['user'] = 'teacher';
        $_SESSION['username'] = $res['teacher_username'];
        error_log("LOGIN SUCCESS : ". $_POST['email']);
        header("Location:index.php");
        return;
    }
    else{
        $_SESSION['error'] = "<ul><li class='alert-danger'>Invalid Login Credentials.</li></ul>";
        error_log("LOGIN FAIL : ". $_POST['email']);
            header("Location:login.php");
            return;
    }


}
?>
<html>
    <title>Elearn:Login</title>
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
            <div class="jumbotron" style="background-color: #3bceac; width:50%; margin:auto;">
        <form class="form-group" style="color:ghostwhite; font-size:1.2em;"  method="post">
            Email : <input type="email" class="form-control" name="email">
            <br>
            Password : <input type="password" class="form-control" name="pass" >
            <br>
            <center><input type="submit" class="btn-lg btn-success" value="LOGIN"></center>
        </form>
        </div>
        </div>
    </body>
</html>