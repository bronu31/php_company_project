<!--<!DOCUMENT html>
<html lang="en">
<head>
<meta charset="utf-8">
</head>
</html>-->

<?php function to_warehouse($name,$prod_id,$vol,$cost,$order_date){
// Create connection
$conn = new mysqli("localhost", "root", "root","company");

// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}
$sql = "SELECT  MAX(id) FROM delivery_to_warehouse";

$result = mysqli_query($conn,$sql)->fetch_array();
$num_id= intval($result[0]);



$num_id=$num_id+1;
$sql = "INSERT INTO  delivery_to_warehouse
VALUES (".$num_id.",".$name.",".$prod_id.",".$vol.",".$cost.",".date('Ymd', strtotime($order_date)).")";

if (mysqli_query($conn, $sql)) {
    echo "New record created successfully";
  } else {
    echo "Error: " . $sql . "<br>" . mysqli_error($conn);
  }

  $conn->close();
}
$name=$_GET["order_name"];
$prod_id=$_GET["to_warehouse"];
$vol=$_GET["volume"];
$cost=$_GET["cost"];
$order_date=$_GET["order_date"];

echo "Result is : " . to_warehouse($name,$prod_id,$vol,$cost,$order_date);
?>


