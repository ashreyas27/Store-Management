<?php
session_start();
if (!isset($_SESSION['Emp_id'])) {
  echo '<script>alert("You are logged out.");</script>';
  echo '<script>location.replace("login.php");</script>';
}
include "links.php";
include "dbcon.php";
?>
<html>

<head>
  <title>Sai Krishna Store</title>
  <meta name="viewport" content="width=device-width,initial scale=1.0" />
  <?php include "links.php" ?>
</head>

<body>
  <nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container-fluid">
      <a class="navbar-brand" href="main.php"><img src="img/logo.png" alt="" width="150px"></a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
          <li class="nav-item px-2">
            <a class="nav-link" aria-current="page" href="customer.php"><b>Customer Details</b></a>
          </li>
          <li class="nav-item px-2">
            <a class="nav-link" aria-current="page" href="distributor.php"><b>Distributor Details</b></a>
          </li>
          <li class="nav-item px-2">
            <a class="nav-link" aria-current="page" href="product.php"><b>Product Details</b></a>
          </li>
          <li class="nav-item px-2">
            <a class="nav-link" aria-current="page" href="transaction.php"><b>Transaction</b></a>
          </li>
          <li class="nav-item px-2">
            <a class="nav-link" aria-current="page" href="bill.php"><b>Bill Counter</b></a>
          </li>
          <li class="nav-item px-2">
            <a class="nav-link" aria-current="page" href="profile.php"><b>Profile</b></a>
          </li>
        </ul>
        <form class="d-flex">
          <a href="logout.php" class="btn btn-dark btn-lg">Logout</a>
        </form>
      </div>
    </div>
  </nav>
  <div class="container mt-5" style="text-align: center;">
    <div class="row">
      <div class="col-sm-4">
        <div class="card shadow mb-5 bg-body rounded">
          <div class="card-body">
            <h5 class="card-title"><b>Daily Profits</b></h5><br>
            <?php
            $sql = "SELECT daily_stat(date(CURRENT_TIMESTAMP()))";
            $row = mysqli_fetch_array(mysqli_query($conn, $sql));
            if ($row[0] != NULL) {
              echo "Today's profit: ₹" . $row[0] . "<br>";
            } else {
              echo "Today's profit: ₹0<br>";
            }
            ?><br>
            <form action="<?php echo htmlentities($_SERVER["PHP_SELF"]); ?>" method="POST">
              <label for="daily">Select date:</label>
              <input type="date" id="daily" name="daily">
              <input type="submit" class="btn btn-primary my-2" name='Submit1'>
            </form>
            <?php
            if (isset($_POST['Submit1'])) {
              $date = $_POST['daily'];
              $sql = "SELECT daily_stat('$date')";
              $row = mysqli_fetch_array(mysqli_query($conn, $sql));
              if ($row[0] != NULL) {

            ?>
                <div class="table-responsive">
                  <table class="table table-hover table-striped" style="text-align: center;">
                    <thead>
                      <tr>
                        <th scope="col">Date</th>
                        <th scope="col">Profit</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr>
                        <th scope="row"><?php echo $date ?></th>
                        <td>₹ <?php echo $row[0] ?></td>
                      </tr>
                    </tbody>
                  </table>
                </div>
            <?php
              } else {
                echo "0 results";
              }
            }
            ?>
          </div>
        </div>
      </div>
      <div class="col-sm-4">
        <div class="card shadow mb-5 bg-body rounded">
          <div class="card-body">
            <h5 class="card-title"><b>Monthly Profits</b></h5><br>
            <?php
            $sql1 = "SELECT monthly_stat(month(CURRENT_TIMESTAMP()),year(CURRENT_TIMESTAMP()))";
            $row = mysqli_fetch_array(mysqli_query($conn, $sql1));

            if ($row[0] != NULL) {
              echo "This month's profit: ₹" . $row[0] . "<br>";
            } else {
              echo "This month's profit: ₹0<br>";
            }
            ?><br>
            <form action="<?php echo htmlentities($_SERVER["PHP_SELF"]); ?>" method="POST">
              <label for="monthly">Select month:</label>
              <input type="month" id="monthly" name="monthly">
              <input type="submit" class="btn btn-primary my-2" name='Submit2'>
            </form>
            <?php
            if (isset($_POST['Submit2'])) {
              $date = $_POST['monthly'];
              $month = substr($date, 5, 2);
              $year = substr($date, 0, 4);
              $sql1 = "SELECT monthly_stat('$month','$year')";
              $row = mysqli_fetch_array(mysqli_query($conn, $sql1));

              if ($row[0] != NULL) {

            ?>
                <div class="table-responsive">
                  <table class="table table-hover table-striped" style="text-align: center;">
                    <thead>
                      <tr>
                        <th scope="col">Month</th>
                        <th scope="col">Profit</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr>
                        <th scope="row"><?php echo $date ?></th>
                        <td>₹ <?php echo $row[0] ?></td>
                      </tr>
                    </tbody>
                  </table>
                </div>
            <?php
              } else {
                echo "0 results";
              }
            }
            ?>
          </div>
        </div>
      </div>
      <div class="col-sm-4">
        <div class="card pb-2 shadow mb-5 bg-body rounded">
          <div class="card-body">
            <h5 class="card-title"><b>Out of stock items</b></h5><br>
            <?php
            $sql2 = "SELECT * FROM Product WHERE Stock=0";
            $result2 = mysqli_query($conn, $sql2);
            if (mysqli_num_rows($result2)) {
            ?>
              <div class="table-responsive">
                <table class="table table-hover table-striped" style="text-align: center;">
                  <thead>
                    <tr>
                      <th scope="col">Name</th>
                      <th scope="col">Category</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                    while ($row = mysqli_fetch_assoc($result2)) {
                    ?>
                      <tr>
                        <th scope="row"><?php echo $row['Pdt_name'] ?></th>
                        <td><?php echo $row["Category"] ?></td>
                      </tr>
                    <?php
                    }
                    ?>
                  </tbody>
                </table>
              </div>
            <?php
            } else {
              echo "No Product.";
            }
            ?>
          </div>
        </div>
      </div>
    </div>
  </div>

</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js" integrity="sha384-JEW9xMcG8R+pH31jmWH6WWP0WintQrMb4s7ZOdauHnUtxwoG2vI5DkLtS3qm9Ekf" crossorigin="anonymous"></script>

</html>