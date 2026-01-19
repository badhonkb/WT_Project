<?php
session_start();
include "../db/monthlyTargetModel.php";


if (!isset($_SESSION["admin"])) {
    header("location: login.php");
    exit();
}



if(isset($_GET['getSalesmen'])){
    $salesmen = getAllSalesmen();
    echo json_encode($salesmen);
    exit();
}


if(isset($_POST['setTarget'])){
    $email = $_POST['salesman_email'];
    $amount = floatval($_POST['target_amount']);
    $days = intval($_POST['duration_days']);
    $res = setMonthlyTarget($email, $amount, $days);
    echo json_encode($res);
    exit();
}


if(isset($_GET['getTargets'])){
    $targets = getAllTargetsWithProgress();
    echo json_encode($targets);
    exit();
}
?>
