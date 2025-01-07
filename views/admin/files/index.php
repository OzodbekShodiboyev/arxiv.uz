<?php
require '../../../helpers/auth_helper.php';
requireAdmin(); // Admin kirishini tekshirish

$conn = new mysqli('localhost', 'root', '', 'arxivuz');
if ($conn->connect_error) {
    die('Database error: ' . $conn->connect_error);
}

// Fetch data for dropdowns
$subjects = $conn->query('SELECT * FROM subjects'); // Fetch all subjects
$categories = $conn->query('SELECT * FROM categories'); // Fetch all categories

// CRUD Operations for Files
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['file'])) {
        $upload_dir = realpath('../../../uploads/') . '/'; // Fayl saqlanadigan joy
        $file_name = basename($_FILES['file']['name']);
        $file_target = $upload_dir . $file_name;

        if (move_uploaded_file($_FILES['file']['tmp_name'], $file_target)) {
            echo "Fayl muvaffaqiyatli yuklandi.";
            // Fayl haqida ma'lumotni bazaga yozish
            $stmt = $conn->prepare("INSERT INTO files (name, path, category_id, subject_id) VALUES (?, ?, ?, ?)");
            $stmt->bind_param('ssii', $file_name, $file_target, $_POST['category_id'], $_POST['subject_id']);
            $stmt->execute();
            $stmt->close();
        } else {
            echo "Faylni yuklashda xatolik yuz berdi.";
        }
    }

    if (isset($_POST['edit_file'])) {
        $id = $_POST['id'];
        $name = trim($_POST['name']);
        $category_id = $_POST['category_id'];
        $subject_id = $_POST['subject_id'];

        if (!empty($name)) {
            $stmt = $conn->prepare('UPDATE files SET name = ?, category_id = ?, subject_id = ? WHERE id = ?');
            $stmt->bind_param('siis', $name, $category_id, $subject_id, $id);
            $stmt->execute();
            $stmt->close();
        }
    }

    if (isset($_POST['delete_file'])) {
        $id = $_POST['id'];

        // Fayl ma'lumotlarini olish
        $stmt = $conn->prepare('SELECT path FROM files WHERE id = ?');
        $stmt->bind_param('i', $id);
        $stmt->execute();
        $stmt->store_result();
        $stmt->bind_result($file_path);
        $stmt->fetch();
        $stmt->close();

        if ($file_path && file_exists($file_path)) {
            // Faylni tizimdan o'chirish
            unlink($file_path);
        }

        // Faylni bazadan o'chirish
        $stmt = $conn->prepare('DELETE FROM files WHERE id = ?');
        $stmt->bind_param('i', $id);
        $stmt->execute();
        $stmt->close();

        header('Location: index.php');
        exit;
    }
}

$sql = "
    SELECT f.id, f.name, f.path, s.name AS subject_name, c.name AS category_name 
    FROM files f
    LEFT JOIN subjects s ON f.subject_id = s.id
    LEFT JOIN categories c ON f.category_id = c.id
";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Files</title>
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
                    <h1>Fayllar</h1>
                    <button class="btn btn-primary mb-3" data-toggle="modal" data-target="#addFileModal">Fayl qo'shish</button>

                    <table class="table">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Nomi</th>
                                <th>Kategoriya</th>
                                <th>Fan</th>
                                <th>Yuklab olish</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if ($result->num_rows > 0): ?>
                                <?php while ($file = $result->fetch_assoc()): ?>
                                    <tr>
                                        <td><?= htmlspecialchars($file['id']) ?></td>
                                        <td><?= htmlspecialchars($file['name']) ?></td>
                                        <td><?= htmlspecialchars($file['category_name']) ?></td>
                                        <td><?= htmlspecialchars($file['subject_name']) ?></td>
                                        <?php
                                        $file_extension = pathinfo($file['name'], PATHINFO_EXTENSION);
                                        ?>
                                        <td>
                                            <?php
                                            if (in_array(strtolower($file_extension), ['jpg', 'jpeg', 'png', 'gif'])) {
                                                echo '<img src="/uploads/' . htmlspecialchars($file['name']) . '" width="100" height="auto">';
                                            } elseif (in_array(strtolower($file_extension), ['pdf', 'html', 'txt', 'doc', 'docx', 'xls', 'xlsx', 'ppt', 'pptx'])) {
                                                echo '<a href="/uploads/' . htmlspecialchars($file['name']) . '" target="_blank" class="btn btn-info">Ko\'rish</a>';
                                            } else {
                                                echo '<span class="text-muted">Ko\'rish mumkin emas</span>';
                                            }
                                            ?>
                                        </td>

                                        <td>
                                            <a href="/uploads/<?= htmlspecialchars($file['name']) ?>" download class="btn btn-primary">
                                                Yuklab olish
                                            </a>
                                        </td>
                                        <td>
                                            <form action="" method="POST" onsubmit="return confirm('Faylni o\'chirmoqchimisiz?');">
                                                <input type="hidden" name="id" value="<?= htmlspecialchars($file['id']) ?>">
                                                <button type="submit" name="delete_file" class="btn btn-danger">O'chirish</button>
                                            </form>
                                        </td>
                                    </tr>
                                <?php endwhile; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="5">Fayllar topilmadi.</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>

                </div>
            </div>
        </div>
    </div>

    <!-- Add File Modal -->
    <div class="modal fade" id="addFileModal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add File</h5>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <form method="POST" action="" enctype="multipart/form-data">
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="name">Name</label>
                            <input type="text" class="form-control" name="name" required>
                        </div>
                        <div class="form-group">
                            <label for="category_id">Category</label>
                            <select name="category_id" id="category_id" class="form-control" required>
                                <option value="">Kategoriyani tanlang</option>
                                <?php
                                $categories->data_seek(0); // Kategoriyalar kursorini boshiga qaytarish
                                while ($category = $categories->fetch_assoc()): ?>
                                    <option value="<?= $category['id'] ?>" <?= isset($_POST['category_id']) && $_POST['category_id'] == $category['id'] ? 'selected' : '' ?>>
                                        <?= htmlspecialchars($category['name']) ?>
                                    </option>
                                <?php endwhile; ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="subject_id">Subject</label>
                            <select name="subject_id" id="subject_id" class="form-control" required>
                                <option value="">Fanni tanlang</option>
                                <?php
                                $subjects->data_seek(0); // Fanlar kursorini boshiga qaytarish
                                while ($subject = $subjects->fetch_assoc()): ?>
                                    <option value="<?= $subject['id'] ?>" <?= isset($_POST['subject_id']) && $_POST['subject_id'] == $subject['id'] ? 'selected' : '' ?>>
                                        <?= htmlspecialchars($subject['name']) ?>
                                    </option>
                                <?php endwhile; ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="file">File</label>
                            <input type="file" class="form-control" name="file" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" name="add_file" class="btn btn-primary">Save</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="../../../assets/admin/vendor/jquery/jquery.min.js"></script>
    <script src="../../../assets/admin/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="../../../assets/admin/js/sb-admin-2.min.js"></script>
</body>

</html>