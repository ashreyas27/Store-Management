<?php
include('book_sc_fns.php');
// The shopping cart needs sessions, so start one
session_start();
if (!isset($_SESSION['Emp_id'])) {
  echo '<script>alert("You are logged out.");</script>';
  echo '<script>location.replace("login.php");</script>';
}

do_html_header('Checkout');

if (($_SESSION['cart'])) {
  //display cart, not allowing changes and without pictures
  display_cart($_SESSION['cart'], false, 0);

  // display_shipping(calculate_shipping_cost());

  if (process_card($_POST)) {
    if (isset($_POST['upitxnid'])) {
      include "dbcon.php";
      $txn_id = $_POST['upitxnid'];
      $id = $_SESSION['O_id'];
      $sql = "UPDATE purchase 
              SET Bank_transaction_id='$txn_id'
              where Purchase_id='$id'";
      mysqli_query($conn, $sql);
    }

    session_destroy();
    echo "<p>Thank you for shopping with us.</p>";
    display_button("bill.php", "continue-shopping", "Continue Shopping");
  } else {
    echo "<p>Could not process your card. Please contact the card issuer or try again.</p>";
    display_button("purchase.php", "back", "Back");
  }
} else {
  echo "<p>You did not fill in all the fields, please try again.</p><hr />";
  display_button("purchase.php", "back", "Back");
}

do_html_footer();
