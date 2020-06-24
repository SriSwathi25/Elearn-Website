<?php
session_start();
session_destroy();
echo("<style>");
include 'mystyle.css';
echo("</style>");
header("Location:index.php");
return;
?>