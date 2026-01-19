<?php
include "config.php";


function getStaffByEmail($email){
    global $conn;
    $email = $conn->real_escape_string($email);
    $sql = "SELECT * FROM staff WHERE email='$email' LIMIT 1";
    $res = $conn->query($sql);
    return $res ? $res->fetch_assoc() : null;
}


function updateStaffPassword($id, $hashedPassword){
    global $conn;
    $sql = "UPDATE staff SET password='$hashedPassword' WHERE id=$id";
    return $conn->query($sql);
}
?>
