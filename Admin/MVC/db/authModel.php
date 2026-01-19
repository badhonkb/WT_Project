<?php
include "config.php";

function checkAdminLogin($email) {
    global $conn;
    return $conn->query("SELECT * FROM admins WHERE email='$email'");
}

function checkStaffLogin($email) {
    global $conn;
    return $conn->query("SELECT * FROM staff WHERE email='$email'");
}
