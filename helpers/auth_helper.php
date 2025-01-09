<?php

function requireAdmin() {
    session_start();
    if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
        header('Location: index.php');
        exit;
    }
}
function checkDailyBalanceDeduction() {
    
    
    // Foydalanuvchi autentifikatsiyadan o'tganligini tekshirish
    if (!isset($_SESSION['user_id'])) {
        // Foydalanuvchi tizimga kirmagan, funksiyani bajarishni to'xtatish
        return;
    }

    $conn = new mysqli('localhost', 'root', '', 'arxivuz');
    if ($conn->connect_error) {
        die('Database error: ' . $conn->connect_error);
    }

    $userId = $_SESSION['user_id']; // Foydalanuvchi ID'sini oling
    $userQuery = $conn->prepare("SELECT balance, last_deduction FROM users WHERE id = ?");
    $userQuery->bind_param('i', $userId);
    $userQuery->execute();
    $userResult = $userQuery->get_result();
    $user = $userResult->fetch_assoc();

    // Bugungi sana
    $today = date('Y-m-d');

    // Foydalanuvchi balansidan pul yechish
    if ($user && $user['last_deduction'] !== $today) {
        $daysSinceLastDeduction = (new DateTime($today))->diff(new DateTime($user['last_deduction'] ?? $today))->days;

        if ($user['balance'] >= $daysSinceLastDeduction * 1000) {
            $newBalance = $user['balance'] - ($daysSinceLastDeduction * 1000);
            $updateQuery = $conn->prepare("UPDATE users SET balance = ?, last_deduction = ? WHERE id = ?");
            $updateQuery->bind_param('isi', $newBalance, $today, $userId);
            $updateQuery->execute();
            $updateQuery->close();
        }
    }

    $userQuery->close();
    $conn->close();
}



?>
