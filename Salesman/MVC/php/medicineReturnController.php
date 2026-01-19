<?php
session_start();
include "../db/medicineReturnModel.php";

if(!isset($_SESSION['staff']) || $_SESSION['role'] != 'Salesman') {
    header("Location: ../Admin/MVC/html/login.php");
    exit();
}


if(isset($_POST['submit_return'])) {
    $sale_id = (int)$_POST['sale_id'];
    $customer_id = (int)$_POST['customer_id'];
    $reason = $_POST['reason'];
    $medicines = $_POST['medicines']; 
    $total_return = 0;

    $return_id = createReturn($sale_id, $customer_id, $reason, $total_return);

    foreach($medicines as $med_id => $qty) {
        if($qty <= 0) continue;

       
        $items = getSaleById($sale_id)['items'];
        $price = 0;
        while($row = $items->fetch_assoc()) {
            if($row['medicine_id'] == $med_id) $price = $row['price'];
        }
        $subtotal = $price * $qty;
        $total_return += $subtotal;

        addReturnItem($return_id, $med_id, $qty, $price, $subtotal);
        increaseStock($med_id, $qty);
    }

   
    $conn->query("UPDATE medicine_returns SET total_return=$total_return WHERE id=$return_id");

    header("Location: ../html/medicine_return.php?success=Return processed successfully");
    exit();
}
?>
