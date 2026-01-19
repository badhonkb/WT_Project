<?php
session_start();

if (!isset($_SESSION['staff']) || $_SESSION['role'] !== 'Salesman') {
    header("Location: ../../Admin/MVC/html/login.php");
    exit();
}

require_once "../db/TopSellingReportModel.php";

$filter = isset($_GET['filter']) ? $_GET['filter'] : 'daily';

$result = getTopSellingMedicines($filter);
$topMedicines = [];

if ($result) {
    while ($row = $result->fetch_assoc()) {
        $topMedicines[] = $row;
    }
}

require "../html/top_selling.php";
