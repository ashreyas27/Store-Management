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
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Distributor details:: Sai krishna store</title>
    <?php include "links.php" ?>
</head>

<body>
    <div style="height: 60px;">
        <a href="distributor.php" class="btn btn-dark btn-md float-end">Back to Distributor Page.</a>
    </div>

    <div class="container">
        <div class="card text-center">
            <h5 class="card-header"><b>Distributor Related Details</b></h5>
            <div class="card-body">
                <i class="bi bi-cart-check-fill" style="font-size: 4rem; color:rebeccapurple;"></i>
                <h5><u>Distributor Info.</u></h5><br>
                <div class="table-responsive">
                <table class="table table-success table-hover table-striped" style="text-align: center;">
                    <thead class="table-dark">
                        <tr>
                        <th scope="col">Id</th>
                        <th scope="col">Name</th>
                        <th scope="col">Mobile_no</th>
                        <th scope="col">Shop name</th>
                        <th scope="col">Area</th>
                        <th scope="col">State</th>
                        <th scope="col">Pin Code</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $sql = "SELECT * from Distributor where Distributor_id='$id'";
                        $result = mysqli_query($conn, $sql);
                        $row = mysqli_fetch_assoc($result);
                        ?>

                        <tr>
                        <th scope="row"><?php echo $row['Distributor_id'] ?></th>
                            <td><?php echo $row['Distributor_name'] ?></td>
                            <td><?php echo $row['Mobile_no'] ?></td>
                            <td><?php echo $row['Shop_name'] ?></td>
                            <td><?php echo $row['Area'] ?></td>
                            <td><?php echo $row['State'] ?></td>
                            <td><?php echo $row['Pin_code'] ?></td>
                        </tr>
                    </tbody>
                </table>
                </div>
                <br>

                <h5><u>Product Info.</u></h5><br>
                <div class="table-responsive">
                <table class="table table-success table-hover table-striped" style="text-align: center;">
                    <thead class="table-dark">
                        <tr>
                        <th scope="col">Id</th>
                        <th scope="col">Name</th>
                        <th scope="col">Category</th>
                        <th scope="col">Buying price</th>
                        <th scope="col">Selling price</th>
                        <th scope="col">Exp. date</th>
                        <th scope="col">Stock</th>
                    </tr>
                    </thead>
                    <tbody>
                        <?php
                        $sql = "SELECT * from product where Distributor_id='$id'";
                        $result = mysqli_query($conn, $sql);
                        while($row = mysqli_fetch_assoc($result)){
                        ?>

                        <tr>
                            <th scope="row"><?php echo $row['Pdt_id'] ?></th>
                            <td><?php echo $row['Pdt_name'] ?></td>
                            <td><?php echo $row['Category'] ?></td>
                            <td><?php echo $row['Buying_price'] ?></td>
                            <td><?php echo $row['Selling_price'] ?></td>
                            <td><?php echo $row['Exp_date'] ?></td>
                            <td><?php echo $row['Stock'] ?></td>
                        </tr>
                        <?php
                        }
                        ?>
                    </tbody>
                </table>
                </div>
            </div>
        </div>
    </div>
</body>

</html>