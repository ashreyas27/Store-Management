<?php
session_start();
include "dbcon.php";
if (!isset($_SESSION['Emp_id'])) {
    echo '<script>alert("You are logged out.");</script>';
    echo '<script>location.replace("login.php");</script>';
}

if (isset($_POST['Update'])) {
    $id=$_POST['Pdt_id'];
    $name=$_POST['Pdt_name'];
    $cat=$_POST['Category'];
    $bp=$_POST['Buying_price'];
    $sp=$_POST['Selling_price'];
    $ed=$_POST['Exp_date'];
    $stock=$_POST['Stock'];
    $dist_id=$_POST['Distributor_id'];

    $sql="Update Product
            SET Pdt_name='$name',
                Category='$cat',
                Buying_price='$bp',
                Selling_price='$sp',
                Exp_date='$ed',
                Stock='$stock',
                Distributor_id='$dist_id'
            where Pdt_id='$id' 
    ";
    
    if(mysqli_query($conn, $sql)) {
        echo '<script>alert("Update Sucessful.");</script>';
        echo '<script>location.replace("product.php");</script>';
    }
}
if (!isset($_GET['id'])) {
    echo '<script>location.replace("product.php");</script>';
}
$id=$_GET['id'];
$sql="SELECT * from Product where Pdt_id='$id'";
$query=mysqli_query($conn,$sql);
$row=mysqli_fetch_assoc($query);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Update Form :: Sai krishna store</title>
    <?php include "links.php" ?>
</head>

<body>
    <div style="height: 60px;">
        <a href="product.php" class="btn btn-dark btn-md float-end">Back to Product Page.</a>
    </div>

    <div class="container">
        <div class="card text-center">
            <h5 class="card-header"><b>Product Update Details</b></h5>
            <div class="card-body">
                <img src="img/person-square.svg" alt="Image" style="margin-top: 25px;" width="100" height="100">
                <form class="mt-5" action="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>" method="POST">
                    <input type="hidden" class="form-control" name="Pdt_id" value="<?php echo $row['Pdt_id'] ?>">
                    <div class="row mb-3">
                        <label class="col-sm-3 col-form-label">Name</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" name="Pdt_name" value="<?php echo $row['Pdt_name'] ?>" required>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label class="col-sm-3 col-form-label">Category</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" name="Category" value="<?php echo $row['Category'] ?>" required>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label class="col-sm-3 col-form-label">Buying price</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" name="Buying_price" value="<?php echo $row['Buying_price'] ?>" required>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label class="col-sm-3 col-form-label">Selling price</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" name="Selling_price" value="<?php echo $row['Selling_price'] ?>" required>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label class="col-sm-3 col-form-label">Exp. date</label>
                        <div class="col-sm-8">
                            <input type="date" class="form-control" name="Exp_date" value="<?php echo $row['Exp_date'] ?>">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label class="col-sm-3 col-form-label">Stock</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" name="Stock" value="<?php echo $row['Stock'] ?>" required>
                        </div>
                    </div>
                    <div class="row mb-3">
                            <label class="col-sm-3 col-form-label">Distributor id</label>
                            <div class="col-sm-8">
                                <select class="form-select" name="Distributor_id" value="<?php echo $row['Distributor_id'] ?>" required>
                                <?php
                                    $sql = "SELECT Distributor_id,Shop_name from Distributor";
                                    $result = mysqli_query($conn, $sql);
                                    while ($row = mysqli_fetch_assoc($result)) {
                                        $d_id=$row['Distributor_id'];
                                        $d_name = $row['Shop_name'];
                                        echo "<option value=$d_id>$d_id-$d_name</option>";
                                    }
                                ?>
                                </select>
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