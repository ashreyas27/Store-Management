<?php
session_start();
include "dbcon.php";
if (!isset($_SESSION['Emp_id'])) {
    echo '<script>alert("You are logged out.");</script>';
    echo '<script>location.replace("login.php");</script>';
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Transaction Details:: Sai krishna store</title>
    <?php include "links.php" ?>
</head>

<body>
    <div style="height: 60px;">
        <a href="main.php" class="btn btn-dark btn-md float-end">Back to main Page.</a>
    </div>

    <div class="container">
        <h3><b>Transaction details</b></h3>
        <br>
        <form action="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>" method="POST">
            <div class="row g-3 align-items-center justify-content-end">
                <div class="col-auto">
                    <label class="col-form-label" for="value">
                        <h5>Find</h5>
                    </label>
                </div>
                <div class="col-auto">
                    <input type="date" id="value" name="value">
                </div>
                <div class="col-auto">
                    <button type="submit" class="btn btn-primary" name="find">Go</button>
                </div>
                <div class="col-auto">
                    <a href="transaction.php" class="btn btn-dark">Reset</a>
                </div>
            </div>
        </form>
        <div class="table-responsive">
            <table class="table table-hover table-striped" style="text-align: center;">
                <thead class="table-dark">
                    <tr>
                        <th scope="col">Purchase Id</th>
                        <th scope="col">Customer Id</th>
                        <th scope="col">Time Stamp</th>
                        <th scope="col">Payment mode</th>
                        <th scope="col">Bank Transaction Id</th>
                        <th scope="col">Operation</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $sql = "SELECT * from Purchase order by Time_stamp desc";
                    if (isset($_POST['find'])) {
                        $select = $_POST['value'];
                        $sql = "SELECT * from Purchase where date(Time_stamp)='$select'";
                    }
                    $result = mysqli_query($conn, $sql);
                    while ($row = mysqli_fetch_assoc($result)) {

                    ?>
                        <tr>
                            <th scope="row"><?php echo $row['Purchase_id'] ?></th>
                            <td><?php echo $row['Cust_id'] ?></td>
                            <td><?php echo $row['Time_stamp'] ?></td>
                            <td><?php echo $row['Payment_mode'] ?></td>
                            <td><?php echo $row['Bank_transaction_id'] ?></td>
                            <td><a href="transaction_detail.php?id=<?php echo $row['Purchase_id'] ?>"><i class="bi bi-eye-fill" style="font-size: 1.3rem; color: grey;"></i></a></td>
                        </tr>
                    <?php
                    }
                    ?>
                </tbody>
            </table>
        </div>
        <p>***For Cancellation of transaction, Please go to Transaction detail Page</p>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js" integrity="sha384-JEW9xMcG8R+pH31jmWH6WWP0WintQrMb4s7ZOdauHnUtxwoG2vI5DkLtS3qm9Ekf" crossorigin="anonymous"></script>
</body>

</html>