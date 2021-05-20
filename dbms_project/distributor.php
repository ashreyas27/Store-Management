<?php
session_start();
include "dbcon.php";
if (!isset($_SESSION['Emp_id'])) {
    echo '<script>alert("You are logged out.");</script>';
    echo '<script>location.replace("login.php");</script>';
}
if (isset($_POST['Add'])) {
    $name = $_POST['Distributor_name'];
    $mob = $_POST['Mobile'];
    $Shop_name = $_POST['Shop_name'];
    $Area = $_POST['Area'];
    $State = $_POST['State'];
    $Pin_code = $_POST['Pin_code'];

    $sql = "INSERT INTO Distributor(Distributor_name,Mobile_no,Shop_name,Area,State,Pin_code)
        values('$name','$mob','$Shop_name','$Area','$State','$Pin_code') 
    ";

    if (mysqli_query($conn, $sql)) {
        echo '<script>alert("New Distributor Added.");</script>';
        echo '<script>location.replace("distributor.php");</script>';
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Distributor Details:: Sai krishna store</title>
    <?php include "links.php" ?>
</head>

<body>
    <div style="height: 60px;">
        <a href="main.php" class="btn btn-dark btn-md float-end">Back to main Page.</a>
    </div>

    <div class="container">
        <h3><b>Distributor details</b></h3>
        <br>
        <form action="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>" method="POST">
            <div class="row g-3 align-items-center justify-content-end">
                <div class="col-auto">
                    <label class="col-form-label" for="value">
                        <h5>Find</h5>
                    </label>
                </div>
                <div class="col-auto">
                    <input type="text" id="value" name="value" placeholder="Name">
                </div>
                <div class="col-auto">
                    <button type="submit" class="btn btn-primary" name="find">Go</button>
                </div>
                <div class="col-auto">
                    <a href="distributor.php" class="btn btn-dark">Reset</a>
                </div>
            </div>
        </form>
        <div class="table-responsive">
            <table class="table table-hover table-striped" style="text-align: center;">
                <thead>
                    <tr class="table-dark">
                        <th scope="col">Id</th>
                        <th scope="col">Name</th>
                        <th scope="col">Mobile_no</th>
                        <th scope="col">Shop name</th>
                        <th scope="col">Area</th>
                        <th scope="col">State</th>
                        <th scope="col">Pin Code</th>
                        <th scope="col" colspan="2">Operation</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $sql = "SELECT * from Distributor";
                    if (isset($_POST['find'])) {
                        $select = $_POST['value'];
                        $sql = "SELECT * from Distributor where Distributor_name='$select'";
                    }
                    $result = mysqli_query($conn, $sql);
                    while ($row = mysqli_fetch_assoc($result)) {

                    ?>
                        <tr>
                            <th scope="row"><?php echo $row['Distributor_id'] ?></th>
                            <td><?php echo $row['Distributor_name'] ?></td>
                            <td><?php echo $row['Mobile_no'] ?></td>
                            <td><?php echo $row['Shop_name'] ?></td>
                            <td><?php echo $row['Area'] ?></td>
                            <td><?php echo $row['State'] ?></td>
                            <td><?php echo $row['Pin_code'] ?></td>
                            <td><a href="distributor_form.php?id=<?php echo $row['Distributor_id'] ?>"><i class="bi bi-pencil-square" style="font-size: 1.3rem; color: cornflowerblue;"></i></a></td>
                            <td><a href="distributor_info.php?id=<?php echo $row['Distributor_id'] ?>"><i class="bi bi-eye-fill" style="font-size: 1.3rem; color: red;"></i></a></td>
                        </tr>
                    <?php
                    }
                    ?>
                </tbody>
            </table>
        </div>

    </div>
    <div class="d-grid gap-2 fixed-bottom">
        <button type="button" class="btn btn-danger btn-lg py-2" data-bs-toggle="modal" data-bs-target="#add_info"><b><i class="bi bi-person-plus" style="padding-right: 20px;font-size: 1.5rem;"></i>Add New Distributor</b></button>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="add_info" tabindex="-1" role="dialog" aria-labelledby="add_label" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="add_label"><b>Distributor details</b></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>" method="POST">
                        <div class="row mb-3">
                            <label class="col-sm-3 col-form-label">Name</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" name="Distributor_name" required>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class="col-sm-3 col-form-label">Mobile no.</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" name="Mobile" required>
                            </div>
                        </div>
                        <h4 class="my-4"><u>Address</u></h4>
                        <div class="row mb-3">
                            <label class="col-sm-3 col-form-label">Shop name</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" name="Shop_name" required>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class="col-sm-3 col-form-label">Area</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" name="Area" required>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class="col-sm-3 col-form-label">State</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" name="State" required>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class="col-sm-3 col-form-label">Pin code</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" name="Pin_code" required>
                            </div>
                        </div>
                        <div class="mt-5">
                            <button type="submit" class="btn btn-primary mb-4" name="Add">Add</button>
                        </div>
                    </form>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js" integrity="sha384-JEW9xMcG8R+pH31jmWH6WWP0WintQrMb4s7ZOdauHnUtxwoG2vI5DkLtS3qm9Ekf" crossorigin="anonymous"></script>
</body>

</html>