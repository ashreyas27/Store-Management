<?php
  include ('book_sc_fns.php');
  // The shopping cart needs sessions, so start one
  session_start();
  if (!isset($_SESSION['Emp_id'])) {
    echo '<script>alert("You are logged out.");</script>';
    echo '<script>location.replace("login.php");</script>';
  }

  $name = $_GET['Category'];

  do_html_header($name);

  // get the book info out from db
  $book_array = get_books($name);

  display_books($book_array);

    display_button("index.php", "continue-shopping", "Continue Shopping");

  do_html_footer();
?>