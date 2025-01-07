<?php
session_start();
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Bazaga ulanish
    $conn = new mysqli('localhost', 'root', '', 'arxivuz');
    if ($conn->connect_error) {
        die('Database error: ' . $conn->connect_error);
    }

    // Foydalanuvchini tekshirish
    $stmt = $conn->prepare('SELECT id, name, password, role, balance FROM users WHERE email = ?');
    $stmt->bind_param('s', $email);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows === 1) {
        $user = $result->fetch_assoc();
        if (password_verify($password, $user['password'])) {
            // Sessiyaga ma'lumotlarni saqlash
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_name'] = $user['name'];
            $_SESSION['role'] = $user['role'];
            $_SESSION['balance'] = $user['balance'];

            // Foydalanuvchini yo‘naltirish
            if ($user['role'] === 'admin') {
                header('Location: views/admin/index.php');
            } else {
                header('Location: index.php');
            }
            exit;
        } else {
            echo '<p style="color:red;">Noto‘g‘ri parol.</p>';
        }
    } else {
        echo '<p style="color:red;">Foydalanuvchi topilmadi.</p>';
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
    <form class="login" method="POST" action="">
        <h2>KIRISH</h2>
        <p>Marhamat, ma'lumotlarni kiriting!</p>
        <input type="email" name="email" placeholder="Email kiriting" required />
        <input type="password" name="password" placeholder="Parol kiring" required />
        <input type="submit" value="Kirish" />
        <div class="links">
            <a href="register.php">Akkountingiz yo'qmi unda Ro'yxatdan o'ting</a>
        </div>
    </form>  
</body>
</html>
