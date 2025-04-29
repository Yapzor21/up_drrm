<?php
$first_name = "Mark";
$middle_name = "Luis";
$last_name = "Cruz";
$role = "super_admin";

// Generate initials
$initials = strtoupper($first_name[0] . $middle_name[0] . $last_name[0]);

// Generate random number
$random = rand(1000, 9999);

// Generate admin_id
$admin_id = strtoupper(substr($role, 0, 3)) . "-" . $initials . "-" . $random; // e.g., SUP-MLC-2745

// Generate raw password
$raw_password = strtolower($first_name . $role . $random); // e.g., marksuper_admin2745

// Hash password
$hashed_password = password_hash($raw_password, PASSWORD_DEFAULT);

// Insert into DB using PDO
try {
    $pdo = new PDO("mysql:host=localhost;dbname=s2300587_drrm", "root", "");
    $stmt = $pdo->prepare("INSERT INTO employee (admin_id, password, role, first_name, middle_name, last_name) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->execute([$admin_id, $hashed_password, $role, $first_name, $middle_name, $last_name]);

    echo "Super admin created successfully.<br>";
    echo "Admin ID: $admin_id<br>";
    echo "Raw Password: $raw_password (Save this before closing!)";
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
