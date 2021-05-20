<?php
session_start();
include "dbcon.php";
if (!isset($_SESSION['Emp_id'])) {
    echo '<script>alert("You are logged out.");</script>';
    echo '<script>location.replace("login.php");</script>';
}
$emp_id=$_SESSION['Emp_id'];
$sql="SELECT * from Employee where Emp_id='$emp_id'";
$query=mysqli_query($conn,$sql);
$res=mysqli_fetch_assoc($query);

if (isset($_POST['Submit'])) {
    $Username=$_POST['Username'];
    $Password=$_POST['Password'];
    $Emp_name=$_POST['Name'];
    $Mob_no=$_POST['Mob'];
    $Acc=$_POST['Acc'];
    $H_no=$_POST['H_no'];
    $Area=$_POST['Area'];
    $Pin_code=$_POST['Pin'];

    $sql="Update Employee
            SET Username='$Username',
                Password='$Password',
                Emp_name='$Emp_name',
                Mobile_no='$Mob_no',
                Acc_no='$Acc',
                H_no='$H_no',
                Area='$Area',
                Pin_code='$Pin_code'
            where Emp_id='$emp_id' 
    ";
    
    if(mysqli_query($conn, $sql)) {
        echo '<script>alert("Update Sucessful.");</script>';
        echo '<script>location.replace("profile.php");</script>';
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile :: Sai krishna store</title>
    <?php include "links.php" ?>
</head>

<body>
    <div style="height: 60px;">
        <a href="main.php" class="btn btn-dark btn-md float-end">Back to main Page.</a>
    </div>

    <div class="container">
        <div class="card text-center">
            <h5 class="card-header"><b>Profile Details</b></h5>
            <div class="card-body">
            <img src="img/person-square.svg" alt="Image" style="margin-top: 25px;" width="100" height="100">
                <h5 class="card-title py-3 pt-4"><b><u><?php echo $res['Emp_name'] ?></u></b></h5>
                <p class="card-text pb-4">
                    Employee id : <?php echo $emp_id ?>
                    <br>Username : <?php echo $res['Username'] ?>
                    <br>Mobile no. : <?php echo $res['Mobile_no'] ?>
                    <br>Account no. : <?php echo $res['Acc_no']?$res['Acc_no']:"Not available"; ?>
                    <br><br><b style="font-size: 20px;"><u>Address-</u></b><br>
                    <br>House no. : <?php echo $res['H_no'] ?>
                    <br>Area : <?php echo $res['Area'] ?>
                    <br>Pin_code : <?php echo $res['Pin_code'] ?>
                </p>
            </div>
            <?php include "profile_form.php" ?> 
        </div>
    </div>
    <?php include "footer.php" ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js" integrity="sha384-JEW9xMcG8R+pH31jmWH6WWP0WintQrMb4s7ZOdauHnUtxwoG2vI5DkLtS3qm9Ekf" crossorigin="anonymous"></script>
</body>

</html>