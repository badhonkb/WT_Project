<?php
include "config.php";


function getAllStaff() {
    global $conn;
    $sql = "SELECT * FROM staff ORDER BY id DESC";
    return $conn->query($sql);
}



function addStaff($name, $email, $role, $password) {
    global $conn;

   
    $hashPass = password_hash($password, PASSWORD_DEFAULT);

   
    $check = $conn->query("SELECT * FROM staff WHERE email='$email'");
    if ($check->num_rows > 0) {
        return false; 
    }
    

    $sql = "INSERT INTO staff (name,email,role,password) 
            VALUES ('$name','$email','$role','$hashPass')";

    return $conn->query($sql);
}


function deleteStaff($id) {
    global $conn;
    $sql = "DELETE FROM staff WHERE id=$id";
    return $conn->query($sql);
}




function getStaffCount() {
    global $conn;
    $sql = "SELECT COUNT(*) AS total FROM staff";
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();
    return $row['total'];
}
?>




