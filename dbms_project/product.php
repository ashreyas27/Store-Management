<?php
session_start();
include "dbcon.php";
if (!isset($_SESSION['Emp_id'])) {
    echo '<script>alert("You are logged out.");</script>';
    echo '<script>location.replace("login.php");</script>';
}
if (isset($_POST['Add'])) {
    $name = $_POST['Pdt_name'];
    $cat = $_POST['Category'];
    $bp = $_POST['Buying_price'];
    $sp = $_POST['Selling_price'];
    $ed = $_POST['Exp_date'];
    $stock = $_POST['Stock'];
    $dist_id = $_POST['Distributor_id'];

    $sql = "INSERT INTO Product(Pdt_name,Category,Buying_price,Selling_price,Exp_date,Stock,Distributor_id)
        values('$name','$cat','$bp','$sp','$ed','$stock','$dist_id') 
    ";

    if (mysqli_query($conn, $sql)) {
        echo '<script>alert("New Product Added.");</script>';
        echo '<script>location.replace("product.php");</script>';
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Details:: Sai krishna store</title>
    <?php include "links.php" ?>
</head>

<body>
    <div style="height: 60px;">
        <a href="main.php" class="btn btn-dark btn-md float-end">Back to main Page.</a>
    </div>

    <div class="container">
        <h3><b>Product details</b></h3>
        <br>
        <form action="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>" method="POST">
            <div class="row g-3 align-items-center justify-content-end">
                <div class="col-auto">
                    <label class="col-form-label" for="select">
                        <h5>Sort</h5>
                    </label>
                </div>
                <div class="col-auto">
                    <select class="form-select" id="select" name="select">
                        <option value="1">Buying Price</option>
                        <option value="2">Selling Price</option>
                        <option value="3">Category</option>
                        <option value="4">Exp. date</option>
                        <option value="5">Stock</option>
                    </select>
                </div>
                <div class="col-auto">
                    <button type="submit" class="btn btn-primary" name="sort">Go</button>
                </div>
            </div>
        </form>
        <div class="table-responsive">
            <table class="table table-hover table-striped" style="text-align: center;">
                <thead class="table-dark">
                    <tr>
                        <th scope="col">Id</th>
                        <th scope="col">Name</th>
                        <th scope="col">Category</th>
                        <th scope="col">Buying price</th>
                        <th scope="col">Selling price</th>
                        <th scope="col">Exp. date</th>
                        <th scope="col">Stock</th>
                        <th scope="col">Distributor id</th>
                        <th scope="col" colspan="2">Operation</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $sql = "SELECT * from Product";
                    if (isset($_POST['sort'])) {
                        $select = $_POST['select'];
                        $sql = "CALL sort_pdt($select)";
                    }
                    $result = mysqli_query($conn, $sql);
                    while ($row = mysqli_fetch_assoc($result)) {

                    ?>
                        <tr>
                            <th scope="row"><?php echo $row['Pdt_id'] ?></th>
                            <td><?php echo $row['Pdt_name'] ?></td>
                            <td><?php echo $row['Category'] ?></td>
                            <td><?php echo $row['Buying_price'] ?></td>
                            <td><?php echo $row['Selling_price'] ?></td>
                            <td><?php echo $row['Exp_date'] ?></td>
                            <td><?php echo $row['Stock'] ?></td>
                            <td><?php echo $row['Distributor_id'] ?></td>
                            <td><a href="product_form.php?id=<?php echo $row['Pdt_id'] ?>"><i class="bi bi-pencil-square" style="font-size: 1.3rem; color: cornflowerblue;"></i></a></td>
                            <td><a href="product_del.php?id=<?php echo $row['Pdt_id'] ?>"><i class="bi bi-trash" style="font-size: 1.3rem; color: red;"></i></a></td>
                        </tr>
                    <?php
                    }
                    ?>
                </tbody>
            </table>
        </div>

    </div>
    <div class="d-grid gap-2 fixed-bottom">
        <button type="button" class="btn btn-danger btn-lg py-2" data-bs-toggle="modal" data-bs-target="#add_info"><b><i class="bi bi-plus-circle" style="padding-right: 20px;font-size: 1.5rem;"></i>Add New Product</b></button>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="add_info" tabindex="-1" role="dialog" aria-labelledby="add_label" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="add_label"><b>Product details</b></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>" method="POST">
                        <div class="row mb-3">
                            <label class="col-sm-3 col-form-label">Name</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" name="Pdt_name" required>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class="col-sm-3 col-form-label">Category</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" name="Category" required>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class="col-sm-3 col-form-label">Buying price</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" name="Buying_price" required>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class="col-sm-3 col-form-label">Selling price</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" name="Selling_price" required>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class="col-sm-3 col-form-label">Exp. date</label>
                            <div class="col-sm-8">
                                <input type="date" class="form-control" name="Exp_date">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class="col-sm-3 col-form-label">Stock</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" name="Stock" required>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class="col-sm-3 col-form-label">Distributor id</label>
                            <div class="col-sm-8">
                                <select class="form-select" name="Distributor_id" required>
                                    <?php
                                    $sql = "SELECT Distributor_id,Shop_name from Distributor";
                                    $result = mysqli_query($conn, $sql);
                                    while ($row = mysqli_fetch_assoc($result)) {
                                        $d_id = $row['Distributor_id'];
                                        $d_name = $row['Shop_name'];
                                        echo "<option value=$d_id>$d_id-$d_name </option>";
                                    }
                                    ?>
                                </select>
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