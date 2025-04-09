<?php
$password = "MC2300587"; // Replace with the desired password
$hashed_password = password_hash($password, PASSWORD_DEFAULT);
echo "Hashed Password: " . $hashed_password;
?>