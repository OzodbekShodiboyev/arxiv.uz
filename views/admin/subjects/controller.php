<?php
require '../../../helpers/auth_helper.php';
requireAdmin(); 

$conn = new mysqli('localhost', 'root', '', 'arxivuz');
if ($conn->connect_error) {
    die('Database error: ' . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['add_subject'])) {
        $name = trim($_POST['name']);
        if (!empty($name)) {
            $stmt = $conn->prepare('INSERT INTO subjects (name) VALUES (?)');
            $stmt->bind_param('s', $name);
            $stmt->execute();
            $stmt->close();
        }
    }

    if (isset($_POST['edit_subject'])) {
        $id = $_POST['id'];
        $name = trim($_POST['name']);
        if (!empty($name)) {
            $stmt = $conn->prepare('UPDATE subjects SET name = ? WHERE id = ?');
            $stmt->bind_param('si', $name, $id);
            $stmt->execute();
            $stmt->close();
        }
    }

    if (isset($_POST['delete_subject'])) {
        $id = $_POST['id'];
        $stmt = $conn->prepare('DELETE FROM subjects WHERE id = ?');
        $stmt->bind_param('i', $id);
        $stmt->execute();
        $stmt->close();
    }

    header('Location: index.php');
    exit;
}

$subjects = $conn->query('SELECT * FROM subjects');
?>