<?php
require '../../../helpers/auth_helper.php';
requireAdmin(); 


$conn = new mysqli('localhost', 'root', '', 'arxivuz');
if ($conn->connect_error) {
    die('Database error: ' . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['user_id'], $_POST['amount'])) {
    $userId = (int)$_POST['user_id'];
    $amount = (float)$_POST['amount'];

    if ($amount > 0) {
        $stmt = $conn->prepare("UPDATE users SET balance = balance + ? WHERE id = ?");
        $stmt->bind_param('di', $amount, $userId);
        $stmt->execute();
        $stmt->close();

        $message = "Foydalanuvchi balansi muvaffaqiyatli yangilandi.";
    } else {
        $message = "Noto'g'ri summa kiritildi.";
    }

    // Foydalanuvchini qayta yo'naltirish
    header("Location: " . $_SERVER['PHP_SELF']);
    exit();
}


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

                <?php if (!empty($message)): ?>
                    <div class="alert alert-success">
                        <?= htmlspecialchars($message) ?>
                    </div>
                <?php endif; ?>

                <table class="table">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Role</th>
                            <th>Balance</th>
                            <th>Actions</th>
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
                                    <td>
                                        <button class="btn btn-primary" data-toggle="modal" data-target="#topUpModal" 
                                                data-user-id="<?= $user['id'] ?>" 
                                                data-user-name="<?= htmlspecialchars($user['name']) ?>">
                                            Hisob to'ldirish
                                        </button>
                                    </td>
                                </tr>
                            <?php endwhile; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="6">Foydalanuvchilar topilmadi.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="topUpModal" tabindex="-1" role="dialog" aria-labelledby="topUpModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="topUpModalLabel">Hisobni to'ldirish</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="POST">
                <div class="modal-body">
                    <input type="hidden" name="user_id" id="modalUserId">
                    <p>Foydalanuvchi: <span id="modalUserName"></span></p>
                    <div class="form-group">
                        <label for="amount">Summani kiriting (UZS):</label>
                        <input type="number" name="amount" class="form-control" id="amount" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Bekor qilish</button>
                    <button type="submit" class="btn btn-primary">To'ldirish</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="../../../assets/admin/vendor/jquery/jquery.min.js"></script>
<script src="../../../assets/admin/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="../../../assets/admin/js/sb-admin-2.min.js"></script>
<script>
    $('#topUpModal').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget);
        var userId = button.data('user-id');
        var userName = button.data('user-name');

        var modal = $(this);
        modal.find('#modalUserId').val(userId);
        modal.find('#modalUserName').text(userName);
    });
</script>
</body>
</html>