<?php
session_start();
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);

    // Ma'lumotlar bazasiga ulanish
    $conn = new mysqli('localhost', 'root', '', 'arxivuz');
    if ($conn->connect_error) {
        die('Database error: ' . $conn->connect_error);
    }

    // Foydalanuvchini qo'shish
    $stmt = $conn->prepare('INSERT INTO users (name, email, password) VALUES (?, ?, ?)');
    $stmt->bind_param('sss', $name, $email, $password);
    if ($stmt->execute()) {
        // Foydalanuvchini avtomatik tizimga kiritish
        $user_id = $stmt->insert_id; // Yangi foydalanuvchi ID sini olish
        $_SESSION['user_id'] = $user_id;
        $_SESSION['user_name'] = $name;
        $_SESSION['role'] = 'user'; // Yangi foydalanuvchi uchun odatda "user" roli bo'ladi
        $_SESSION['balance'] = 0; // Default balans

        // Asosiy sahifaga yo'naltirish
        header('Location: index.php');
        exit;
    } else {
        echo 'Ro‘yxatdan o‘tishda xatolik: ' . $stmt->error;
    }
    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>ECOURSES - Online Courses HTML Template</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="Free HTML Templates" name="keywords">
    <meta content="Free HTML Templates" name="description">
    <?php require_once 'components/layouts/header.php'; ?>
    <?php require_once 'components/layouts/topbar.php'; ?>
</head>
<body class="bg-login">
<form class="login" method="post">
    <h2>Ro'yxatdan o'tish</h2>
    <p>Marhamat, ma'lumotlarni kiriting!</p>
    <input type="text" name="name" required placeholder="Ismingizni kiriting" />
    <input type="email" name="email" required placeholder="Email kiriting" />
    <input type="password" name="password" required placeholder="Parol kiring" />
    <input type="submit" value="Ro'yxatdan o'tish" />
    <div class="links">
        <a href="login.php">Kirish uchun bosing</a>
    </div>
</form>  
</body>
