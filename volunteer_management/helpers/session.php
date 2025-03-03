<?php
    // Set Flash Message
function setFlash($key, $message) {
    $_SESSION['flash'][$key] = $message;
}
// Get and Remove Flash Message
function getFlash($key) {
    if (isset($_SESSION['flash'][$key])) {
        $message = $_SESSION['flash'][$key];
        unset($_SESSION['flash'][$key]); // Remove after displaying
        return $message;
    }
    return null;
}


?>
