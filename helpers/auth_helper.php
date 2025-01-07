<?php
function requireAdmin() {
    session_start();
    if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
        header('Location: index.php');
        exit;
    }
}
?>
