<?php
session_start();
include "dbcon.php";
if (!isset($_SESSION['Emp_id'])) {
    echo '<script>alert("You are logged out.");</script>';
    echo '<script>location.replace("login.php");</script>';
}
if (!isset($_GET['id'])) {
    echo '<script>location.replace("distributor.php");</script>';
}
$id=$_GET['id'];
$sql="DELETE from Distributor where Distributor_id='$id'";
$query=mysqli_query($conn,$sql);
if(mysqli_query($conn, $sql)) {
    echo '<script>alert("Distributor deleted.");</script>';
    echo '<script>location.replace("distributor.php");</script>';
}
?>