<?php
session_start();
include "../db/commissionModel.php";

if (!isset($_SESSION["admin"])) {
    header("location: login.php");
    exit();
}


if (isset($_GET['action']) && $_GET['action'] == 'salesmen') {
    $res = getSalesmen();
    $data = [];
    while ($row = $res->fetch_assoc()) {
        $data[] = $row;
    }
    echo json_encode($data);
    exit();
}


if (isset($_GET['action']) && $_GET['action'] == 'report') {
    $days = $_GET['days'] ?? 7;
    $email = $_GET['email'] ?? null;

    $res = getCommissionReport($days, $email);
    $data = [];
    while ($row = $res->fetch_assoc()) {
        $data[] = $row;
    }
    echo json_encode($data);
    exit();
}
