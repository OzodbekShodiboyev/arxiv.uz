<?php
require '../../../helpers/auth_helper.php';
requireAdmin();

$conn = new mysqli('localhost', 'root', '', 'arxivuz');
if ($conn->connect_error) {
    die('Database error: ' . $conn->connect_error);
}

$id = $_GET['id'];
$stmt = $conn->prepare('DELETE FROM categories WHERE id = ?');
$stmt->bind_param('i', $id);
$stmt->execute();
$stmt->close();
header('Location: index.php');
exit;
?>
