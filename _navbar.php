<?php
if(isset($_SESSION['user'])){
    include('after_login.php');   
}  
else{
    include('before_login.php');
}
?>
