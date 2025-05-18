<?php
session_start();
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../model/super_admin.php';

$database = new Database();
$pdo = $database->connect();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $fname = ($_POST['fname']);
    $mname = ($_POST['mname']);
    $lname = ($_POST['lname']);
    $contact_num = ($_POST['contact_num']);
    $password = ($_POST['password']);
    $confirm_password = ($_POST['confirm_password']);
    $role = ($_POST['role']);
    $volunteerType = ($_POST['volunteerType']);

    if ($password !== $confirm_password) {
        echo "<script>alert('Passwords do not match!'); window.history.back();</script>";
        exit;
    }


    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    $employee = new Employee($pdo);

    try {
        $last_inserted_id = $employee->createEmployee($hashed_password, $role, $fname, 
        $mname, $lname,$contact_num, $volunteerType);
            session_destroy();
            echo "<script>alert('Registration Successful!'); window.location.href = '../views/admin/super_admin.php';</script>";
            
    } catch (Exception $e) {
        echo "<script>alert('Error: " . $e->getMessage() . "'); window.history.back();</script>";
        exit();
    }
  
}


?>