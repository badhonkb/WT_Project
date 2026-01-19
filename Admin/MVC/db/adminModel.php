<?php
include "config.php";

function adminEmailExists($email) {
    global $conn;
    $sql = "SELECT id FROM admins WHERE email='$email'";
    return $conn->query($sql);
}

function insertAdmin($name, $email, $password) {
    global $conn;
    $hashPass = password_hash($password, PASSWORD_DEFAULT);
    $sql = "INSERT INTO admins (name,email,password)
            VALUES ('$name','$email','$hashPass')";
    return $conn->query($sql);
}
?> 
