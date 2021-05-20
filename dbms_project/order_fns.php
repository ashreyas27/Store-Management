<?php
function process_card($card_details) {
  // connect to payment gateway or
  // store in DB if you really want to

  return true;
}

function insert_order($order_details) {
  // extract order_details out as variables
  extract($order_details);

  $conn = db_connect();

  // we want to insert the order as a transaction
  // start one by turning off autocommit
  $conn->autocommit(FALSE);

  $customerid = $name;

  // $date = date("Y-m-d");
  date_default_timezone_set("Asia/Kolkata");
  $date = date("y-m-d H:i:s");

  $query = "insert into Purchase values
            ('', '".$customerid."', '".$date."', '".$mode."', NULL)";

  $result = $conn->query($query);
  if (!$result) {
    return false;
  }

  $query = "select Purchase_id from Purchase where
               Cust_id = '".$customerid."' and
               Time_stamp = '".$date."' and
               Payment_mode = '".$mode."'";

  $result = $conn->query($query);

  if($result->num_rows>0) {
    $order = $result->fetch_object();
    $orderid = $order->Purchase_id;
  } else {
    return false;
  }
  $_SESSION['O_id']=$orderid;
  // insert each book
  foreach($_SESSION['cart'] as $isbn => $quantity) {
    $detail = get_book_details($isbn);
    if($quantity<=$detail['Stock']){
      $query = "update Product set Stock = Stock-$quantity where
                Pdt_id = '".$isbn."'";
      $result = $conn->query($query);
      if(!$result){
        return false;
      }
    }else{
      echo '<script>alert("No Stock for requested quantity.");</script>';
      return false;
    }
    
    $query = "insert into Cart values
              ('".$orderid."', '".$isbn."', ".$quantity.", ".$detail['Selling_price']*$quantity.")";
    $result = $conn->query($query);
    if(!$result) {
      return false;
    }
  }

  // end transaction
  $conn->commit();
  $conn->autocommit(TRUE);

  return $orderid;
}

?>