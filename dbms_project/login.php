<?php
 session_start();
 if(isset($_POST['Submit'])){
    include "dbcon.php";
    $username=$_POST['Username'];
    $Password=$_POST['Password'];

    $user_search="SELECT Emp_id,Password from Employee where Username='$username'";
    $query=mysqli_query($conn,$user_search);
    
    if(mysqli_num_rows($query)){
        $res=mysqli_fetch_assoc($query);
        if($Password==$res['Password']){
            echo '<script>alert("Sucessfully logged in");</script>';
            $_SESSION['Emp_id']=$res['Emp_id'];
            echo '<script>location.replace("main.php");</script>';
        }else{
            echo '<script>alert("Wrong Password");</script>';
        }
    }else{
        echo '<script>alert("Invalid Username.");</script>';
    }
 }
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php include "links.php" ?>
    <!-- Custom styles for this template -->
    <link href="css/signin.css" rel="stylesheet">
    <title>Login :: Sai krishna store</title>   
</head>

<body class="text-center">
    <main class="form-signin">
        <form action="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>" method="POST">
            <img class="mb-3" src="img/logo.png" alt="Loading">
            <h1 class="h3 mb-3 fw-normal">Please sign in</h1>

            <div class="form-floating">
                <input type="text" class="form-control" id="floatingInput" placeholder="Username" name="Username">
                <label for="floatingInput">Username</label>
            </div>
            <div class="form-floating">
                <input type="password" class="form-control" id="floatingPassword" placeholder="Password" name="Password">
                <label for="floatingPassword">Password</label>
            </div>

            <button class="w-100 btn btn-lg btn-primary" type="submit" name="Submit">Sign in</button>
        </form>
        <?php include "footer.php" ?>
    </main>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-JEW9xMcG8R+pH31jmWH6WWP0WintQrMb4s7ZOdauHnUtxwoG2vI5DkLtS3qm9Ekf"
        crossorigin="anonymous"></script>

</body>
</html>