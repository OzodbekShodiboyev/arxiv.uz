<?php
require '../../../helpers/auth_helper.php';
requireAdmin(); // Admin kirishini tekshirish

// Database connection
$conn = new mysqli('localhost', 'root', '', 'arxivuz');
if ($conn->connect_error) {
    die('Database error: ' . $conn->connect_error);
}

// Fetch users data
$sql = "SELECT id, name, email, role, balance FROM users";
$result = $conn->query($sql);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Users</title>
    <link href="../../../assets/admin/vendor/fontawesome-free/css/all.min.css" rel="stylesheet">
    <link href="../../../assets/admin/css/sb-admin-2.min.css" rel="stylesheet">
</head>

<body id="page-top">
<div id="wrapper">
    <?php require_once '../layouts/sidebar.php'; ?>
    <div id="content-wrapper">
        <div id="content">
            <?php require_once '../layouts/topbar.php'; ?>
            <div class="container-fluid">
                <h1>Foydalanuvchilar</h1>

                <!-- Table for displaying users -->
                <table class="table">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Role</th>
                            <th>Balance</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if ($result->num_rows > 0): ?>
                            <?php while ($user = $result->fetch_assoc()): ?>
                                <tr>
                                    <td><?= htmlspecialchars($user['id']) ?></td>
                                    <td><?= htmlspecialchars($user['name']) ?></td>
                                    <td><?= htmlspecialchars($user['email']) ?></td>
                                    <td><?= htmlspecialchars($user['role']) ?></td>
                                    <td><?= htmlspecialchars($user['balance']) ?> UZS</td>
                                </tr>
                            <?php endwhile; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="5">Foydalanuvchilar topilmadi.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>

            </div>
        </div>
    </div>
</div>

<script src="../../../assets/admin/vendor/jquery/jquery.min.js"></script>
<script src="../../../assets/admin/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="../../../assets/admin/js/sb-admin-2.min.js"></script>
</body>
</html>
