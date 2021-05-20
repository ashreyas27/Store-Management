<html>
  <head>
    <title>Sai Krishna Store</title>
    <meta name="viewport" content="width=device-width,initial scale=1.0" />
    <?php include "links.php" ?>
  </head>
  <body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
      <div class="container-fluid">
        <a class="navbar-brand" href="main.php"><img src="img/logo2.png" alt="" width="150px"></a>
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
    <?php
      include ('book_sc_fns.php');
      // The shopping cart needs sessions, so start one
      session_start();
      if (!isset($_SESSION['Emp_id'])) {
        echo '<script>alert("You are logged out.");</script>';
        echo '<script>location.replace("login.php");</script>';
      }
      
      do_html_header("Welcome to Sai Krishna Stores");

      echo "<p>Please choose a category:</p>";

      // get categories out of database
      $cat_array = get_categories();

      // display as links to cat pages
      display_categories($cat_array);

      do_html_footer();
    ?>
  </body>
</html>