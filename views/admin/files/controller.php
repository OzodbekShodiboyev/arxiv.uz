<?php
require '../../../helpers/auth_helper.php';
requireAdmin(); 

$conn = new mysqli('localhost', 'root', '', 'arxivuz');
if ($conn->connect_error) {
    die('Database error: ' . $conn->connect_error);
}

$subjects = $conn->query('SELECT * FROM subjects'); 
$categories = $conn->query('SELECT * FROM categories'); 

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['file'])) {
    $upload_dir = realpath('../../../uploads/') . '/'; 
    $file_name = basename($_FILES['file']['name']);
    $file_target = $upload_dir . $file_name;

    if (move_uploaded_file($_FILES['file']['tmp_name'], $file_target)) {
        $relative_path = 'uploads/' . $file_name; 

        $stmt = $conn->prepare("INSERT INTO files (name, path, category_id, subject_id) VALUES (?, ?, ?, ?)");
        $stmt->bind_param('ssii', $file_name, $relative_path, $_POST['category_id'], $_POST['subject_id']);
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

        $stmt = $conn->prepare('SELECT path FROM files WHERE id = ?');
        $stmt->bind_param('i', $id);
        $stmt->execute();
        $stmt->store_result();
        $stmt->bind_result($file_path);
        $stmt->fetch();
        $stmt->close();

        if ($file_path && file_exists($file_path)) {
            unlink($file_path);
        }

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