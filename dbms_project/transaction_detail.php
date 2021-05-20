<?php
session_start();
include "dbcon.php";
if (!isset($_SESSION['Emp_id'])) {
    echo '<script>alert("You are logged out.");</script>';
    echo '<script>location.replace("login.php");</script>';
}

if (isset($_POST['Update'])) {
    $id = $_POST['t_id'];
    $sql = "DELETE FROM purchase where Purchase_id='$id'";
    if (mysqli_query($conn, $sql)) {
        echo '<script>alert("This Transaction is deleted.");</script>';
        echo '<script>location.replace("transaction.php");</script>';
    }
}

if (!isset($_GET['id'])) {
    echo '<script>location.replace("transaction.php");</script>';
}
$id = $_GET['id'];
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Transaction details:: Sai krishna store</title>
    <?php include "links.php" ?>
</head>

<body>
    <div style="height: 60px;">
        <a href="transaction.php" class="btn btn-dark btn-md float-end">Back to Transaction Page.</a>
    </div>

    <div class="container">
        <div class="card text-center">
            <h5 class="card-header"><b>Transaction Related Details</b></h5>
            <div class="card-body">
                <i class="bi bi-cart-check-fill" style="font-size: 4rem; color:rebeccapurple;"></i>
                <h5><u>Transaction Info.</u></h5><br>
                <div class="table-responsive">
                    <table class="table table-success table-hover table-striped" style="text-align: center;">
                        <thead class="table-dark">
                            <tr>
                                <th scope="col">Purchase Id</th>
                                <th scope="col">Customer Id</th>
                                <th scope="col">Time Stamp</th>
                                <th scope="col">Payment mode</th>
                                <th scope="col">Bank Transaction Id</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $sql = "SELECT * from Purchase where Purchase_id='$id'";
                            $result = mysqli_query($conn, $sql);
                            $row = mysqli_fetch_assoc($result);
                            $t_date=$row['Time_stamp'];
                            ?>

                            <tr>
                                <th scope="row"><?php echo $row['Purchase_id'] ?></th>
                                <td><?php echo $row['Cust_id'] ?></td>
                                <td><?php echo $row['Time_stamp'] ?></td>
                                <td><?php echo $row['Payment_mode'] ?></td>
                                <td><?php echo $row['Bank_transaction_id'] ?></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <p>****<b>Order can be Cancelled on same day only.</b></p>
        <!-- Same day cancellation is for avoiding to accept the expired product -->
                <?php
                $sql = "SELECT 1 where date('$t_date')=CURDATE()";
                $result = mysqli_query($conn, $sql);
                if($row = mysqli_fetch_array($result)){
                ?>
                <form action="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>" method="POST">
                    <input type="text" name="t_id" value="<?=$id?>" hidden>
                    <button type="submit" name="Update" class="btn btn-danger mb-3">Return Order</button>
                </form>
                <?php
                }
                ?>

                <h5><u>Customer Info.</u></h5><br>
                <div class="table-responsive">
                    <table class="table table-success table-hover table-striped" style="text-align: center;">
                        <thead class="table-dark">
                            <tr>
                                <th scope="col">Customer Id</th>
                                <th scope="col">Name</th>
                                <th scope="col">Mobile_no</th>
                                <th scope="col">House no.</th>
                                <th scope="col">Area</th>
                                <th scope="col">Pin Code</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $sql = "SELECT * from Customer where Cust_id=(SELECT Cust_id from Purchase where Purchase_id='$id')";
                            $result = mysqli_query($conn, $sql);
                            $row = mysqli_fetch_assoc($result);
                            ?>

                            <tr>
                                <th scope="row"><?php echo $row['Cust_id'] ?></th>
                                <td><?php echo $row['Cust_name'] ?></td>
                                <td><?php echo $row['Mobile_no'] ?></td>
                                <td><?php echo $row['H_no'] ?></td>
                                <td><?php echo $row['Area'] ?></td>
                                <td><?php echo $row['Pin_code'] ?></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <br>

                <h5><u>Cart Info.</u></h5><br>
                <div class="table-responsive">
                    <table class="table table-success table-hover table-striped" style="text-align: center;">
                        <thead class="table-dark">
                            <tr>
                                <th scope="col">Product Id</th>
                                <th scope="col">Product Name</th>
                                <th scope="col">Quantity</th>
                                <th scope="col">Total Price</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $sql = "SELECT * from cart natural join product where Purchase_id='$id'";
                            $result = mysqli_query($conn, $sql);
                            while ($row = mysqli_fetch_assoc($result)) {
                            ?>

                                <tr>
                                    <th scope="row"><?php echo $row['Pdt_id'] ?></th>
                                    <td><?php echo $row['Pdt_name'] ?></td>
                                    <td><?php echo $row['Quantity'] ?></td>
                                    <td><?php echo $row['Total_Price'] ?></td>
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