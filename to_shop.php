<?php

function fib($n) {
    $initial = array(array(1,1),array(1,0));
    $Final = array(array(1,1),array(1,0));

    if ($n == 0)
      {return 0;}
    else {
      for($i = 1; $i < $n ; $i++) {
        $a = $Final[0][0]*$initial[0][0] + $Final[0][1]*$initial[1][0];
        $b = $Final[1][0]*$initial[0][0] + $Final[1][1]*$initial[1][0];
        $c = $Final[0][0]*$initial[0][1] + $Final[0][1]*$initial[1][1];
        $d = $Final[1][0]*$initial[0][1] + $Final[1][1]*$initial[1][1];
        $Final[0][0] = $a;
        $Final[1][0] = $b;
        $Final[0][1] = $c;
        $Final[1][1] = $d;
      }
    }
    return $Final[0][1];
  }




function to_warehouse($conn,$fibш,$name,$prod_id,$vol,$cost,$order_date){

$sql2 = "SELECT  MAX(id) FROM delivery_to_shop";

$result = mysqli_query($conn,$sql2)->fetch_array();
$num_id= intval($result[0]);

$cost=$cost/$fibш;

$num_id=$num_id+1;
$sql2 = "INSERT  delivery_to_shop
VALUES (".$num_id.",".mysqli_real_escape_string($conn,$name).",".$prod_id.",".$vol.",".$cost.",".date('Ymd', strtotime($order_date)).")";

#echo $num_id;
echo $sql2;
#echo $prod_id;
#echo $vol;
#echo $cost;
#echo date('Ymd', strtotime($order_date));
#echo;



if($prod_id==3){
    if (mysqli_query($conn, $sql2)) {
        return $cost;
      } else {
        echo "Error: " . $sql2 . "<br>" . mysqli_error($conn);
      }


    }else{if (mysqli_query($conn, $sql2)) {
    echo "New record created successfully";
  } else {
    echo "Error: " . $sql2 . "<br>" . mysqli_error($conn);
  }}

  $conn->close();
}
$name=$_GET["order_name_shop"];

$prod_id=$_GET["to_shop"];
$vol=$_GET["volume_shop"];
$cost=$_GET["cost"];
$order_date=$_GET["order_date"];
#echo strtotime($order_date);
#echo DateTime::createFromFormat('U',strtotime($order_date))->format('Y-m-d H:i:s');
#echo date_sub( DateTime::createFromFormat('U',strtotime($order_date)),date_interval_create_from_date_string("-1 days"))->format('Y-m-d H:i:s');


$conn = new mysqli("localhost", "root", "root","company");

// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}
$sql = "SELECT  on_hands FROM warehouse WHERE id=".$prod_id;
$result = $conn->query($sql);
$row = $result->fetch_assoc();



if($vol>$row["on_hands"]){
    echo "Недостаточно товара для отправки";
}else{
    $sql2 = "SELECT  MAX(date) as max FROM delivery_to_shop WHERE product_id=3";
    $result2 = $conn->query($sql2);
    $row2 = $result2->fetch_assoc();
    if(($prod_id==3)&&(is_null($row2["max"]) )){
        if($order_date<"2021-01-13"){
            echo "Result is : " . to_warehouse($conn,1,$name,$prod_id,$vol,$cost,$order_date);
        }else{
            if($order_date=="2021-01-13"||$order_date=="2021-01-14"){
                
                echo "Ожидается один заказ по цене ". to_warehouse($conn,1,$name,$prod_id,$vol,$cost,$order_date). "кол-во заказов 1";
            }else{
                if($order_date>"2021-01-13"){
                    if($row2["max"]==date_sub( DateTime::createFromFormat('U',strtotime($order_date)),date_interval_create_from_date_string("-1 days"))){
                        $fibш=fib($order_date->diff("2021-01-13"));
                        echo"Ожидается один заказ по цене за один заказ: ". to_warehouse($conn,$fibш,$name,$prod_id,$vol,$cost,$order_date), "кол-во заказов" .$fibш ;
                    }
                    else {echo "Невозможно расчитать, в предыдущий день не было отправки требуется вернуться назад во времени";}
                }
            }
        }
    }
    else{
        echo "Result is : " . to_warehouse($conn,1,$name,$prod_id,$vol,$cost,$order_date);
    }
    

}

?>