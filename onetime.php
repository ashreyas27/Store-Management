<!-- Very first time setup -->

<?php
$servername='localhost';
$username='root';
$password='';

$conn=mysqli_connect($servername,$username,$password);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Create database
$sql = "CREATE DATABASE dbms_project";
if(!mysqli_query($conn, $sql)) {
    die("Error creating database: " . mysqli_error($conn));
}

$conn=mysqli_connect($servername,$username,$password,'dbms_project');
if (!$conn) {
    die("Connection failed with database: " . mysqli_connect_error());
}

//Table creation
$sql = "CREATE TABLE Customer(
    Cust_id int primary key auto_increment,
    Cust_name varchar(25) not null,
    Mobile_no varchar(10) not null,
    H_no varchar(10) not null,
    Area varchar(20) not null,
    Pin_code varchar(10) not null 
)";

if(!mysqli_query($conn, $sql)) {
    echo "Customer table not created".mysqli_error($conn);
}

$sql = "CREATE TABLE Employee(
    Emp_id int primary key auto_increment,
    Username varchar(15) not null unique,
    Password varchar(15) not null,
    Emp_name varchar(25) not null,
    Mobile_no varchar(10) not null,
    Acc_no varchar(25) null, 
    H_no varchar(10) not null,
    Area varchar(20) not null,
    Pin_code varchar(10) not null 
)";

if(!mysqli_query($conn, $sql)) {
    echo "Employee table not created".mysqli_error($conn);
}

$sql = "CREATE TABLE Distributor(
    Distributor_id int primary key auto_increment,
    Distributor_name varchar(25) not null,
    Mobile_no varchar(10) not null,
    Shop_name varchar(30) not null,
    Area varchar(20) not null,
    State varchar(15) not null,
    Pin_code varchar(10) not null 
)";

if(!mysqli_query($conn, $sql)) {
    echo "Distributor table not created".mysqli_error($conn);
}

$sql = "CREATE TABLE Product(
    Pdt_id int primary key auto_increment,
    Pdt_name varchar(35) not null,
    Category varchar(20) not null,
    Buying_price int not null,
    Selling_price int not null,
    Exp_date date,
    Stock int not null,
    Distributor_id int not null references Distributor(Distributor_id)
)";

if(!mysqli_query($conn, $sql)) {
    echo "Product table not created".mysqli_error($conn);
}

$sql = "CREATE TABLE Purchase(
    Purchase_id int primary key auto_increment,
    Cust_id int not null references Customer(Cust_id),
    Time_stamp datetime default CURRENT_TIMESTAMP(),
    Payment_mode varchar(10) not null,
    Bank_transaction_id varchar(20) default null
)";

if(!mysqli_query($conn, $sql)) {
    echo "Purchase table not created".mysqli_error($conn);
}

$sql = "CREATE TABLE Cart(
    Purchase_id int  not null references Purchase(Purchase_id),
    Pdt_id int not null references Product(Pdt_id),
    Quantity int not null,
    Total_Price int not null,
    Primary key (Purchase_id,Pdt_id)
)";

if(!mysqli_query($conn, $sql)) {
    echo "Cart table not created".mysqli_error($conn);
}

$sql = "INSERT INTO Employee values(
    1,'rockergang','957628','Mukesh nadda','9471241043',NULL,'B-202','Balaji nagar','325007'
)";

if(!mysqli_query($conn, $sql)) {
    echo "Main Employee data not inserted".mysqli_error($conn);
}

$sql = "CREATE FUNCTION daily_stat(val date)
RETURNS integer
BEGIN
	DECLARE result integer;
	SELECT (SUM(Total_Price) - SUM(Buying_price*Quantity)) into result FROM (Purchase natural join Cart natural join Product) WHERE date(Time_stamp)=val group by date(Time_stamp);
    RETURN result;
END";

if(!mysqli_query($conn, $sql)) {
    echo "Daily function not created".mysqli_error($conn);
}

$sql = "CREATE FUNCTION monthly_stat(val1 varchar(2),val2 varchar(4))
RETURNS integer
BEGIN
	DECLARE result integer;
	SELECT (SUM(Total_Price) - SUM(Buying_price*Quantity)) into result FROM (Purchase natural join Cart natural join Product) WHERE month(Time_stamp)=val1 and year(Time_stamp)=val2 group by month(Time_stamp);
    RETURN result;
END";

if(!mysqli_query($conn, $sql)) {
    echo "Monthly function not created".mysqli_error($conn);
}

$sql = "CREATE PROCEDURE sort_pdt(val varchar(1))
BEGIN
	CASE val
		when '1' then SELECT * from Product order by Buying_price desc;
        when '2' then SELECT * from Product order by Selling_price desc;
        when '3' then SELECT * from Product order by Category desc;
        when '4' then SELECT * from Product order by Exp_date desc;
        when '5' then SELECT * from Product order by Stock desc;
    END CASE;
END";

if(!mysqli_query($conn, $sql)) {
    echo "Product sort procedure not created".mysqli_error($conn);
}

$sql = "CREATE TRIGGER delete_cart BEFORE DELETE ON purchase FOR EACH ROW DELETE FROM cart WHERE Purchase_id=old.Purchase_id";

if(!mysqli_query($conn, $sql)) {
    echo "Cart deletion trigger not created".mysqli_error($conn);
}

$sql = "CREATE TRIGGER update_stock BEFORE DELETE ON cart FOR EACH ROW UPDATE product set Stock=Stock+old.Quantity where Pdt_id=old.Pdt_id";

if(!mysqli_query($conn, $sql)) {
    echo "Product stock update trigger not created".mysqli_error($conn);
}

$sql = "CREATE VIEW avl_product AS
SELECT * FROM product
WHERE Stock>0 AND (Exp_date>=CURDATE() OR Exp_date='0000-00-00');";

if(!mysqli_query($conn, $sql)) {
    echo "Available Product view is not created".mysqli_error($conn);
}

mysqli_close($conn);
?>