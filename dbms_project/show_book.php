<?php
  include ('book_sc_fns.php');
  // The shopping cart needs sessions, so start one
  session_start();
  if (!isset($_SESSION['Emp_id'])) {
    echo '<script>alert("You are logged out.");</script>';
    echo '<script>location.replace("login.php");</script>';
  }

  $isbn = $_GET['Pdt_id'];

  // get this book out of database
  $book = get_book_details($isbn);
  do_html_header($book['Pdt_name']);
  display_book_details($book);

  // set url for "continue button"
  $target = "bill.php";
  if($book['Category']) {
    $target = "show_cat.php?Category=".$book['Category'];
  }

    display_button("show_cart.php?new=".$isbn, "add-to-cart",
                   "Add".$book['Pdt_name']." To My Shopping Cart");
    display_button($target, "continue-shopping", "Continue Shopping");

  do_html_footer();
?>