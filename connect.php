<?php 
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "shopsite";

$conn = new mysqli($servername,$username,$password,$dbname);
if($conn === false){
   die("Connection failed". $conn->connect_error);
}
/* $sql = "SELECT * FROM order_list";
$qu = $conn->query($sql);
$RES = $qu->fetch_assoc();
print_r(date($RES['time'])); */
?>