<?php
session_start();
include('connect.php');
unset($_SESSION['email']);
session_destroy();
header('Location:homepage.php');
?>