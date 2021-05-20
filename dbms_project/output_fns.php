<?php

function do_html_header($title = '') {
  // print an HTML header

  // declare the session variables we want access to inside the function
  if (!isset($_SESSION['items'])) {
    $_SESSION['items'] = '0';
  }
  if (!isset($_SESSION['total_price'])) {
    $_SESSION['total_price'] = '0.00';
  }
?>
  <html>
  <head>
    <title><?php echo $title; ?></title>
    <style>
      h2 { font-family: Arial, Helvetica, sans-serif; font-size: 22px; color: red; margin: 6px }
      body { font-family: Arial, Helvetica, sans-serif; font-size: 13px }
      li, td { font-family: Arial, Helvetica, sans-serif; font-size: 13px }
      hr { color: #FF0000; width=70%; text-align=center}
      a { color: #000000 }
    </style>
  </head>
  <body>
  <table width="100%" border="0" cellspacing="0" bgcolor="#cccccc">
  <tr>
  <td rowspan="2">
  <a href="bill.php"><img src="img/logo2.png" alt="Sai Krishna Stores" border="0"
       align="left" valign="bottom" height="" width="20%"/></a>
  </td>
  <td align="right" valign="bottom">
  <?php
       echo "Total Items = ".$_SESSION['items'];
  ?>
  </td>
  <td align="right" rowspan="2" width="135">
  <?php
       display_button('show_cart.php', 'view-cart', 'View Your Shopping Cart');
  ?>
  </tr>
  <tr>
  <td align="right" valign="top">
  <?php
       echo "Total Price = $".number_format($_SESSION['total_price'],2);
  ?>
  </td>
  </tr>
  </table>
<?php
  if($title) {
    do_html_heading($title);
  }
}

function do_html_footer() {
  // print an HTML footer
?>
  </body>
  </html>
<?php
}

function do_html_heading($heading) {
  // print heading
?>
  <h2><?php echo $heading; ?></h2>
<?php
}

function do_html_URL($url, $name) {
  // output URL as link and br
?>
  <a href="<?php echo $url; ?>"><?php echo $name; ?></a><br />
<?php
}

function display_categories($cat_array) {
  if (!is_array($cat_array)) {
     echo "<p>No categories currently available</p>";
     return;
  }
  echo "<ul>";
  foreach ($cat_array as $row)  {
    $url = "show_cat.php?Category=".$row['Category'];
    $title = $row['Category'];
    echo "<li>";
    do_html_url($url, $title);
    echo "</li>";
  }
  echo "</ul>";
  echo "<hr />";
}

function display_books($book_array) {
  //display all books in the array passed in
  if (!is_array($book_array)) {
    echo "<p>No Products currently available in this category</p>";
  } else {
    //create table
    echo "<table width=\"100%\" border=\"0\">";

    //create a table row for each book
    foreach ($book_array as $row) {
      $url = "show_book.php?Pdt_id=".$row['Pdt_id'];
      echo "<tr><td>";
      if (@file_exists("images/".$row['Pdt_id'].".jpg")) {
        $title = "<img src=\"images/".$row['Pdt_id'].".jpg\"
                  style=\"border: 1px solid black\"/>";
        do_html_url($url, $title);
      } else {
        echo "&nbsp;";
      }
      echo "</td><td>";
      $title = $row['Pdt_name'];
      do_html_url($url, $title);
      echo "</td></tr>";
    }

    echo "</table>";
  }

  echo "<hr />";
}

function display_book_details($book) {
  // display all details about this book
  if (is_array($book)) {
    echo "<table><tr>";
    //display the picture if there is one
    if (@file_exists("images/".$book['Pdt_id'].".jpg"))  {
      $size = GetImageSize("images/".$book['Pdt_id'].".jpg");
      if(($size[0] > 0) && ($size[1] > 0)) {
        echo "<td><img src=\"images/".$book['Pdt_id'].".jpg\"
              style=\"border: 1px solid black\"/></td>";
      }
    }
    echo "<td><ul>";
    echo "<li><strong>Product Name:</strong> ";
    echo $book['Pdt_name'];
    echo "</li><li><strong>Category:</strong> ";
    echo $book['Category'];
    echo "</li><li><strong>Our Price:</strong> ";
    echo number_format($book['Selling_price'], 2);
    echo "</li><li><strong>In Stock:</strong> ";
    echo $book['Stock'];
    echo "</li><li><strong>Expiry Date:</strong> ";
    echo $book['Exp_date'];
    echo "</li></ul></td></tr></table>";
  } else {
    echo "<p>The details of this book cannot be displayed at this time.</p>";
  }
  echo "<hr />";
}

function display_checkout_form() {
  //display the form that asks for name and address
  include "dbcon.php";
  $query = "SELECT * FROM Customer";
  $res = mysqli_query($conn,$query);
?>
  <br />
  <table border="0" width="100%" cellspacing="0">
  <form action="purchase.php" method="post">
  <tr><th colspan="2" bgcolor="#cccccc">Your Details</th></tr>
  <tr>
    <td>Select Customer id and Name</td>
    <td><select name="name" width="40" required>
      <option value="">Select Customer</option>
      <?php
      while($row = mysqli_fetch_assoc($res)){
        ?>
        <option value="<?php echo $row['Cust_id']; ?>">id:<?php echo $row['Cust_id']; ?>&nbsp;<?php echo $row['Cust_name']; ?></option>
        <?php
      }
      ?>
    </select></td>
  </tr>
  <tr>
    <td></td>
    <td></td>
  </tr>
  <tr>
    <td><input type="radio" id="cash" name="mode" value="cash" required>
        <label for="cash">Cash</label>
    </td>
    <td><input type="radio" id="upi" name="mode" value="upi">
        <label for="upi">UPI</label>
    </td>
  </tr>
  <tr>
    <td colspan="2" align="center"><p><strong>Please press Purchase to confirm
         your purchase, or Continue Shopping to add or remove items.</strong></p>
     <?php display_form_button("purchase", "Purchase These Items"); ?>
    </td>
  </tr>
  </form>
  </table><hr />
<?php
}

function display_shipping($shipping) {
  // display table row with shipping cost and total price including shipping
?>
  <!-- <table border="0" width="100%" cellspacing="0">
  <tr><td align="left">Shipping</td>
      <td align="right"> 
      <?php echo number_format($shipping, 2); ?>
      </td></tr>
  <tr><th bgcolor="#cccccc" align="left">TOTAL INCLUDING SHIPPING</th>
      <th bgcolor="#cccccc" align="right">$ 
      <?php echo number_format($shipping+$_SESSION['total_price'], 2); ?>
      </th>
  </tr>
  </table><br /> -->
<?php
}

function display_card_form($mode) {
  //display form asking for credit card details
?>
  <table border="0" width="100%" cellspacing="0">
  <form action="process.php" method="post">
  <?php
  if($mode == 'cash'){
    ?>
    <tr>
      <td></td>
      <td></td>
    </tr>
    <?php
  }else if($mode == 'upi'){
    ?>
    <tr>
      <td>Scan to pay</td>
      <td><input type="hidden" name="rcash" value=""/>
      <input type="image" src="img/upi.png"/></td>
    </tr>
    <tr>
      <input type="text" name="upitxnid" placeholder="Upi Transaction Id" required>
    </tr>
    <?php
  }
  ?>
  <!-- <tr><th colspan="2" bgcolor="#cccccc">Credit Card Details</th></tr>
  <tr>
    <td>Type</td>
    <td><select name="card_type">
        <option value="VISA">VISA</option>
        <option value="MasterCard">MasterCard</option>
        <option value="American Express">American Express</option>
        </select>
    </td>
  </tr>
  <tr>
    <td>Number</td>
    <td><input type="text" name="card_number" value="" maxlength="16" size="40"></td>
  </tr>
  <tr>
    <td>AMEX code (if required)</td>
    <td><input type="text" name="amex_code" value="" maxlength="4" size="4"></td>
  </tr>
  <tr>
    <td>Expiry Date</td>
    <td>Month
       <select name="card_month">
       <option value="01">01</option>
       <option value="02">02</option>
       <option value="03">03</option>
       <option value="04">04</option>
       <option value="05">05</option>
       <option value="06">06</option>
       <option value="07">07</option>
       <option value="08">08</option>
       <option value="09">09</option>
       <option value="10">10</option>
       <option value="11">11</option>
       <option value="12">12</option>
       </select>
       Year
       <select name="card_year">
       <?php
       for ($y = date("Y"); $y < date("Y") + 10; $y++) {
         echo "<option value=\"".$y."\">".$y."</option>";
       }
       ?>
       </select>
  </tr>
  <tr>
    <td>Name on Card</td>
    <td><input type="text" name="card_name" value = "<?php echo $name; ?>" maxlength="40" size="40"></td>
  </tr> -->
  <tr>
    <td colspan="2" align="center">
      <p><strong>Please press Purchase to confirm your purchase, or Continue Shopping to
      add or remove items</strong></p>
     <?php display_form_button('purchase', 'Purchase These Items'); ?>
    </td>
  </tr>
  </table>
<?php
}

function display_cart($cart, $change = true, $images = 1) {
  // display items in shopping cart
  // optionally allow changes (true or false)
  // optionally include images (1 - yes, 0 - no)

   echo "<table border=\"0\" width=\"100%\" cellspacing=\"0\">
         <form action=\"show_cart.php\" method=\"post\">
         <tr><th colspan=\"".(1 + $images)."\" bgcolor=\"#cccccc\">Item</th>
         <th bgcolor=\"#cccccc\">Price</th>
         <th bgcolor=\"#cccccc\">Quantity</th>
         <th bgcolor=\"#cccccc\">Total</th>
         </tr>";

  //display each item as a table row
  foreach ($cart as $isbn => $qty)  {
    $book = get_book_details($isbn);
    echo "<tr>";
    if($images == true) {
      echo "<td align=\"left\">";
      if (file_exists("img/".$isbn.".jpg")) {
         $size = GetImageSize("img/".$isbn.".jpg");
         if(($size[0] > 0) && ($size[1] > 0)) {
           echo "<img src=\"img/".$isbn.".jpg\"
                  style=\"border: 1px solid black\"
                  width=\"".($size[0]/3)."\"
                  height=\"".($size[1]/3)."\"/>";
         }
      } else {
         echo "&nbsp;";
      }
      echo "</td>";
    }
    echo "<td align=\"left\">
          <a href=\"show_book.php?Pdt_id=".$isbn."\">".$book['Pdt_name']."</a>"."</td>
          <td align=\"center\">\$".number_format($book['Selling_price'], 2)."</td>
          <td align=\"center\">";

    // if we allow changes, quantities are in text boxes
    if ($change == true) {
      echo "<input type=\"text\" name=\"".$isbn."\" value=\"".$qty."\" size=\"3\">";
    } else {
      echo $qty;
    }
    echo "</td><td align=\"center\">\$".number_format($book['Selling_price']*$qty,2)."</td></tr>\n";
  }
  // display total row
  echo "<tr>
        <th colspan=\"".(2+$images)."\" bgcolor=\"#cccccc\">&nbsp;</td>
        <th align=\"center\" bgcolor=\"#cccccc\">".$_SESSION['items']."</th>
        <th align=\"center\" bgcolor=\"#cccccc\">
            \$".number_format($_SESSION['total_price'], 2)."
        </th>
        </tr>";

  // display save change button
  if($change == true) {
    echo "<tr>
          <td colspan=\"".(2+$images)."\">&nbsp;</td>
          <td align=\"center\">
             <input type=\"hidden\" name=\"save\" value=\"true\"/>
             <input type=\"image\" src=\"img/save-changes.gif\"
                    border=\"0\" alt=\"Save Changes\"/>
          </td>
          <td>&nbsp;</td>
          </tr>";
  }
  echo "</form></table>";
}

function display_button($target, $image, $alt) {
  echo "<div align=\"center\"><a href=\"".$target."\">
          <img src=\"img/".$image.".gif\"
           alt=\"".$alt."\" border=\"0\" height=\"50\"
           width=\"135\"/></a></div>";
}

function display_form_button($image, $alt) {
  echo "<div align=\"center\"><input type=\"image\"
           src=\"img/".$image.".gif\"
           alt=\"".$alt."\" border=\"0\" height=\"50\"
           width=\"135\"/></div>";
}

?>