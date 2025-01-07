<?php
require '../../../helpers/auth_helper.php';
requireAdmin(); // Admin kirishini tekshirish

$conn = new mysqli('localhost', 'root', '', 'arxivuz');
if ($conn->connect_error) {
    die('Database error: ' . $conn->connect_error);
}

// Kategoriyani qo'shish
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name']);
    if (!empty($name)) {
        $stmt = $conn->prepare('INSERT INTO categories (name) VALUES (?)');
        $stmt->bind_param('s', $name);
        $stmt->execute();
        $stmt->close();
        header('Location: index.php');
        exit;
    } else {
        $error = 'Kategoriya nomi kiritilishi shart';
    }
}

// Kategoriyalarni olish
$categories = $conn->query('SELECT * FROM categories');
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Kategoriyalar</title>

    <!-- Custom fonts for this template-->
    <link href="../../../assets/admin/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="../../../assets/admin/css/sb-admin-2.min.css" rel="stylesheet">
</head>

<body id="page-top">
    <div id="wrapper">
        <?php require_once '../layouts/sidebar.php'; ?>
        <div id="content-wrapper" class="d-flex flex-column">
            <div id="content">
                <?php require_once '../layouts/topbar.php'; ?>

                <div class="container-fluid">
                    <h1>Kategoriyalar</h1>
                    <button class="btn btn-primary mb-3" data-toggle="modal" data-target="#addCategoryModal">Yangi kategoriya qo‘shish</button>

                    <table class="table">
                        <tr>
                            <th scope="col">ID</th>
                            <th scope="col">Nomi</th>
                            <th scope="col">Amallar</th>
                        </tr>
                        <?php while ($category = $categories->fetch_assoc()): ?>
                            <tr>
                                <td><?= $category['id'] ?></td>
                                <td><?= htmlspecialchars($category['name']) ?></td>
                                <td>
                                    <a class="btn btn-sm btn-warning" href="edit.php?id=<?= $category['id'] ?>">Tahrirlash</a>
                                    <a class="btn btn-sm btn-danger" href="delete.php?id=<?= $category['id'] ?>" onclick="return confirm('Haqiqatan o‘chirishni xohlaysizmi?')">O‘chirish</a>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    </table>
                </div>
            </div>
            <?php require_once '../layouts/footer.php'; ?>
        </div>
    </div>

    <!-- Add Category Modal -->
    <div class="modal fade" id="addCategoryModal" tabindex="-1" role="dialog" aria-labelledby="addCategoryModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addCategoryModalLabel">Yangi kategoriya qo‘shish</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form method="POST" action="">
                    <div class="modal-body">
                        <?php if (isset($error)): ?>
                            <div class="alert alert-danger"> <?= $error ?> </div>
                        <?php endif; ?>
                        <div class="form-group">
                            <label for="name">Kategoriya nomi</label>
                            <input type="text" class="form-control" id="name" name="name" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Bekor qilish</button>
                        <button type="submit" class="btn btn-primary">Saqlash</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Bootstrap core JavaScript-->
    <script src="../../../assets/admin/vendor/jquery/jquery.min.js"></script>
    <script src="../../../assets/admin/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="../../../assets/admin/vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="../../../assets/admin/js/sb-admin-2.min.js"></script>

    <!-- Page level plugins -->
    <script src="../../../assets/admin/vendor/chart.js/Chart.min.js"></script>

    <!-- Page level custom scripts -->
    <script src="../../../assets/admin/js/demo/chart-area-demo.js"></script>
    <script src="../../../assets/admin/js/demo/chart-pie-demo.js"></script>
</body>

</html>