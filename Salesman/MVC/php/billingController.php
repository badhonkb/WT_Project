<?php
session_start();
require_once "../db/billingModel.php";

if(!isset($_SESSION['staff']) || $_SESSION['role'] !== 'Salesman'){
    header("Location: ../../../Admin/MVC/html/login.php");
    exit();
}


if(isset($_GET['search'])){
    $keyword = trim($_GET['search']);

    $result = searchMedicines($keyword);
    $medicines = [];

    while($row = $result->fetch_assoc()){
        $medicines[] = $row;
    }

    echo json_encode($medicines);
    exit();
}


if(isset($_POST['submitSale'])){

    $customer_id = (int)$_POST['customer_id'];
    $items = json_decode($_POST['items'], true);
    $discountPercent = floatval($_POST['discount']);

    
    if($customer_id <= 0){
        echo json_encode([
            'status' => 'error',
            'message' => 'Invalid customer selected'
        ]);
        exit();
    }

    if(empty($items) || !is_array($items)){
        echo json_encode([
            'status' => 'error',
            'message' => 'Cart is empty'
        ]);
        exit();
    }

    $total = 0;

   
    foreach($items as $item){

        $medicine_id = (int)$item['id'];
        $qty = (int)$item['quantity'];
        $price = floatval($item['price']);

        if($medicine_id <= 0 || $qty <= 0){
            echo json_encode([
                'status' => 'error',
                'message' => 'Invalid item quantity detected'
            ]);
            exit();
        }

        $availableStock = getAvailableStock($medicine_id);

        if($qty > $availableStock){
            echo json_encode([
                'status' => 'error',
                'message' => 'Maximum stock reached. Please check stock.'
            ]);
            exit();
        }

        $total += ($qty * $price);
    }

   
    if($discountPercent < 0) $discountPercent = 0;
    if($discountPercent > 100) $discountPercent = 100;

    $discountAmount = ($total * $discountPercent) / 100;
    $grandTotal = $total - $discountAmount;

   
    $sale_id = createSale(
        $customer_id,
        $_SESSION['staff'],
        $total,
        $discountAmount,
        $grandTotal
    );

    if(!$sale_id){
        echo json_encode([
            'status' => 'error',
            'message' => 'Failed to save sale'
        ]);
        exit();
    }

 
    foreach($items as $item){

        addSaleItem(
            $sale_id,
            $item['id'],
            $item['quantity'],
            $item['price'],
            $item['quantity'] * $item['price']
        );

        reduceStock($item['id'], $item['quantity']);
    }

   
    echo json_encode([
        'status' => 'success',
        'message' => 'Sale completed successfully'
    ]);
    exit();
}
