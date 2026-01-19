<?php
session_start();
if(!isset($_SESSION['admin'])){
    header("Location: ../html/login.php");
    exit();
}

include "../db/salesReportModel.php";

$filter = $_GET['filter'] ?? 'today';

$report = getSalesmanReport($filter);
$summary = getSalesSummary($filter);

$chartData = [];
while($r = $report->fetch_assoc()){
    $chartData[] = $r;
}

$report = getSalesmanReport($filter);

include "../html/salesReport.php";
