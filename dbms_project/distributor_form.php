<?php
session_start();
include "dbcon.php";
if (!isset($_SESSION['Emp_id'])) {
    echo '<script>alert("You are logged out.");</script>';
    echo '<script>location.replace("login.php");</script>';
}

if (isset($_POST['Update'])) {
    $id=$_POST['Distributor_id'];
    $name=$_POST['Distributor_name'];
    $mob=$_POST['Mobile'];
    $Shop_name=$_POST['Shop_name'];
    $Area=$_POST['Area'];
    $State=$_POST['State'];
    $Pin_code=$_POST['Pin_code'];

    $sql="Update Distributor
            SET Distributor_name='$name',
                Mobile_no='$mob',
                Shop_name='$Shop_name',
                Area='$Area',
                State='$State',
                Pin_code='$Pin_code'
            where Distributor_id='$id' 
    ";
    
    if(mysqli_query($conn, $sql)) {
        echo '<script>alert("Update Sucessful.");</script>';
        echo '<script>location.replace("distributor.php");</script>';
    }
}
if (!isset($_GET['id'])) {
    echo '<script>location.replace("distributor.php");</script>';
}
$id=$_GET['id'];
$sql="SELECT * from Distributor where Distributor_id='$id'";
$query=mysqli_query($conn,$sql);
$row=mysqli_fetch_assoc($query);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Distributor Update Form :: Sai krishna store</title>
    <?php include "links.php" ?>
</head>

<body>
    <div style="height: 60px;">
        <a href="distributor.php" class="btn btn-dark btn-md float-end">Back to Distributor Page.</a>
    </div>

    <div class="container">
        <div class="card text-center">
            <h5 class="card-header"><b>Distributor Update Details</b></h5>
            <div class="card-body">
                <img src="img/person-square.svg" alt="Image" style="margin-top: 25px;" width="100" height="100">
                <form class="mt-5" action="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>" method="POST">
                    <input type="hidden" class="form-control" name="Distributor_id" value="<?php echo $row['Distributor_id'] ?>">
                    <div class="row mb-3">
                        <label class="col-sm-3 col-form-label">Name</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" name="Distributor_name" value="<?php echo $row['Distributor_name'] ?>" required>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label class="col-sm-3 col-form-label">Mobile no.</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" name="Mobile" value="<?php echo $row['Mobile_no'] ?>" required>
                        </div>
                    </div>
                    <h4 class="my-4"><u>Address</u></h4>
                    <div class="row mb-3">
                        <label class="col-sm-3 col-form-label">Shop name</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" name="Shop_name" value="<?php echo $row['Shop_name'] ?>" required>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label class="col-sm-3 col-form-label">Area</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" name="Area" value="<?php echo $row['Area'] ?>" required>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label class="col-sm-3 col-form-label">State</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" name="State" value="<?php echo $row['State'] ?>" required>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label class="col-sm-3 col-form-label">Pin code</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" name="Pin_code" value="<?php echo $row['Pin_code'] ?>" required>
                        </div>
                    </div>
                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-primary mt-4 py-2" name="Update">Update</button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</body>

</html>