<!-- Connection with database -->
<?php
$servername='localhost';
$username='root';
$password='';
$db='dbms_project';

$conn=mysqli_connect($servername,$username,$password,$db);
if (!$conn) {
    die("Connection failed with database: " . mysqli_connect_error());
}
?>