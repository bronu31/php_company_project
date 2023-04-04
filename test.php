
<!DOCUMENT html>
<html lang="en">
<head>
<meta charset="utf-8">
<title>test</title>

</head>
<body>
<label>
            Отправить в магазин
 </label>
<form action="to_shop.php" method="get">
<input type="text" name="order_name_shop" placeholder="Номер заказа">
    <select name="to_shop">
        <label>
            Choose operation
        </label>
        

<?php
$conn = new mysqli("localhost", "root", "root","company");

if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}
$sql = "SELECT  id,prod_name FROM warehouse";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
      echo "<option value=". $row["id"].">" . $row["prod_name"]. "</option>";
    }
  }
  $conn->close();
?>

    </select>
    <input type="text" name="volume_shop" placeholder="Введите количество для отправки">
    <input type="number" name="cost" placeholder="Цена заказа">
    <input type="date" id="start" name="order_date">
    <button type="submit">Отправить</button>
</form>

<label>
            Заказать доставку на склад
 </label>
<form action="to_warehouse.php" method="get">
<input type="text" name="order_name" placeholder="Номер заказа">
    <select name="to_warehouse">
    
    <?php
// Create connection
$conn = new mysqli("localhost", "root", "root","company");

// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}
$sql = "SELECT  id,prod_name FROM warehouse";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
      echo "<option value=". $row["id"].">" . $row["prod_name"]. "</option>";

    }
  }
  $conn->close();
?>
    </select>
    <input type="text" name="volume" placeholder="Кол-во товара для заказа">
    <input type="number" name="cost" placeholder="Цена заказа">
    <input type="date" id="start" name="order_date">
    <button type="submit">Заказать</button>
</form>


<table border="1">
    <tr>
        <td>Наименование товара</td> <td>Количество на складе(шт)</td>
    </tr>
<?php
// Create connection
$conn = new mysqli("localhost", "root", "root","company");

// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}
$sql = "SELECT  id,prod_name, on_hands FROM warehouse";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
      echo "<tr>";
      echo "<td name =prod-". $row["id"].">" . $row["prod_name"] . "</td>";
      echo "<td name =have-". $row["id"].">" . $row["on_hands"] . "</td>";
      echo "</tr>";
    }
  }
  $conn->close();
?>
    
</table>

</body>
</html>
