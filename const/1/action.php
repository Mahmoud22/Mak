<?php require_once('../Connections/conn.php'); ?>
<?php
if (!function_exists("GetSQLValueString")) {
function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
if (PHP_VERSION < 6) {
$theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;
}

$theValue = function_exists("mysql_real_escape_string") ? mysql_real_escape_string($theValue) : mysql_escape_string($theValue);

switch ($theType) {
case "text":
$theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
break;    
case "long":
case "int":
$theValue = ($theValue != "") ? intval($theValue) : "NULL";
break;
case "double":
$theValue = ($theValue != "") ? doubleval($theValue) : "NULL";
break;
case "date":
$theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
break;
case "defined":
$theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;
break;
}
return $theValue;
}
}

if (!function_exists("GetSQLValueString")) {
function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
if (PHP_VERSION < 6) {
$theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;
}

$theValue = function_exists("mysql_real_escape_string") ? mysql_real_escape_string($theValue) : mysql_escape_string($theValue);

switch ($theType) {
case "text":
$theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
break;    
case "long":
case "int":
$theValue = ($theValue != "") ? intval($theValue) : "NULL";
break;
case "double":
$theValue = ($theValue != "") ? doubleval($theValue) : "NULL";
break;
case "date":
$theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
break;
case "int":
$theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;
break;
}
return $theValue;
}
}

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
$editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}



// select reciver name form receiver table
mysql_select_db($database_conn, $conn);
$query_Recordset1 = "SELECT name FROM receiver ORDER BY name DESC";
$Recordset1 = mysql_query($query_Recordset1, $conn) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);


// select name form product table
mysql_select_db($database_conn, $conn);
$query_Recordset2 = "SELECT name FROM products ORDER BY name ASC";
$Recordset2 = mysql_query($query_Recordset2, $conn) or die(mysql_error());
$row_Recordset2 = mysql_fetch_assoc($Recordset2);
$totalRows_Recordset2 = mysql_num_rows($Recordset2);

// select reciver name form receiver table to update page
mysql_select_db($database_conn, $conn);
$query_Recordset3 = "SELECT name FROM receiver";
$Recordset3 = mysql_query($query_Recordset3, $conn) or die(mysql_error());
$row_Recordset3 = mysql_fetch_assoc($Recordset3);
$totalRows_Recordset3 = mysql_num_rows($Recordset3);


// select name form product table to update page
mysql_select_db($database_conn, $conn);
$query_Recordset4 = "SELECT name FROM products";
$Recordset4 = mysql_query($query_Recordset4, $conn) or die(mysql_error());
$row_Recordset4 = mysql_fetch_assoc($Recordset4);
$totalRows_Recordset4 = mysql_num_rows($Recordset4);

?>

<?php
include('conn.php');
?>


<?php

// Fetch by id

if ($_SERVER["REQUEST_METHOD"] == "POST") {
// Database configuration
$host = 'localhost';  // Your database host
$dbname = 'logistic'; // Your database name
$username = 'root'; // Your database username
$password = ''; // Your database password

// Create connection
$conn = new mysqli($host, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
die("Connection failed: " . $conn->connect_error);
}

// Prepare and bind
$stmt = $conn->prepare("INSERT INTO client
(`name`, `product_name`, `from_date`, `to_date`, `Total`, `vehicle_type`, `quantity`, `weight`, `unit`, `date_time`) VALUES (?, ?, ?, ? ,?, ?, ?, ?, ?, ?)");
$stmt->bind_param("ssssisiiss", $name, $product, $start_date, $end_date, $total1, $truck, $quantity , $weight, $unit, $date); 

// Set parameters and execute
$start_date = $_POST['start_date'];
$end_date = $_POST['end_date'];
$name = $_POST['name'];
$product = $_POST['product'];
$truck = $_POST['truck'];
$total = $_POST['total'];
$quantity = $_POST['quantity'];
$weight = $_POST['weight'];
$unit = $_POST['unit'];
$date = $_POST['date'];
$total1 = $total * $quantity ;
	
if ($stmt->execute()) {

header("Location: index.php");
echo "New record created successfully.";
} else {
echo "Error: " . $stmt->error;
}


// Close statement and connection
$stmt->close();
$conn->close();
}


// Database connection
$conn = new mysqli('localhost', 'root', '', 'logistic');

// Check connection
if ($conn->connect_error) {
die("Connection failed: " . $conn->connect_error);
}

// Fetch items from database
$result = $conn->query("SELECT * FROM client");
$conn->close();

?>





