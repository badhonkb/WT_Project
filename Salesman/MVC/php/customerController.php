<?php
session_start();
include "../db/customerModel.php";


function validateCustomer($name, $email, $phone, $id = null) {
    $errors = [];

   
    if(empty($name)) {
        $errors[] = "Full Name is required";
    } elseif(!preg_match("/^[a-zA-Z ]+$/", $name)) {
        $errors[] = "Full Name can only contain letters and spaces";
    } elseif(strlen($name) < 2) {
        $errors[] = "Full Name must be at least 2 characters";
    }

    
    if(empty($email)) {
        $errors[] = "Email is required";
    } elseif(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Invalid email format";
    }

    
    if(empty($phone)) {
        $errors[] = "Phone Number is required";
    } elseif(!preg_match('/^[0-9]{7,11}$/', $phone)) {
        $errors[] = "Phone Number must be numeric and 11 digits";
    }

  
    global $conn;
    if($id) {
        $sql = "SELECT id FROM customers WHERE (email='$email' OR phone='$phone') AND id != $id";
    } else {
        $sql = "SELECT id FROM customers WHERE email='$email' OR phone='$phone'";
    }
    $result = $conn->query($sql);
    if($result->num_rows > 0) {
        $errors[] = "Email or Phone already exists";
    }

    return $errors;
}


if(isset($_POST['addCustomer'])) {
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $phone = trim($_POST['phone']);

    $errors = validateCustomer($name, $email, $phone);

    if(!empty($errors)) {
        
        $_SESSION['error'] = implode("<br>", $errors);
        header("Location: ../html/customers.php");
        exit();
    }

    if(addCustomer($name, $email, $phone)) {
        $_SESSION['success'] = "Customer added successfully";
    } else {
        $_SESSION['error'] = "Failed to add customer";
    }

    header("Location: ../html/customers.php");
    exit();
}


if(isset($_POST['updateCustomer'])) {
    $id = $_POST['id'];
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $phone = trim($_POST['phone']);

    $errors = validateCustomer($name, $email, $phone, $id);

    if(!empty($errors)) {
        $_SESSION['error'] = implode("<br>", $errors);
        header("Location: ../html/customers.php?update_id=$id");
        exit();
    }

    if(updateCustomer($id, $name, $email, $phone)) {
        $_SESSION['success'] = " Customer updated successfully";
    } else {
        $_SESSION['error'] = " Failed to update customer";
    }

    header("Location: ../html/customers.php");
    exit();
}


if(isset($_GET['delete_id'])) {
    $id = $_GET['delete_id'];
    if(deleteCustomer($id)) {
        $_SESSION['success'] = " Customer deleted successfully";
    } else {
        $_SESSION['error'] = " Failed to delete customer";
    }

    header("Location: ../html/customers.php");
    exit();
}
?>
