<?php
require '../../../helpers/auth_helper.php';
requireAdmin(); 


$conn = new mysqli('localhost', 'root', '', 'arxivuz');
if ($conn->connect_error) {
    die('Database error: ' . $conn->connect_error);
}

$sql = "SELECT id, name, email, balance FROM users WHERE role = 'admin'";
$result = $conn->query($sql);

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add_admin'])) {
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); 
    $checkEmailSql = "SELECT * FROM users WHERE email = '$email' LIMIT 1";
    $emailResult = $conn->query($checkEmailSql);

    if ($emailResult->num_rows > 0) {
        $error_message = "Bunday admin mavjud.";
    } else {
        $insertSql = "INSERT INTO users (name, email, password, role) VALUES ('$name', '$email', '$password', 'admin')";
        
        if ($conn->query($insertSql) === TRUE) {
            echo "<script>alert('New admin added successfully'); window.location.href = 'index.php';</script>";
        } else {
            echo "Error: " . $conn->error;
        }
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['edit_admin'])) {
    $id = $_POST['admin_id'];
    $name = mysqli_real_escape_string($conn, $_POST['edit_name']);
    $email = mysqli_real_escape_string($conn, $_POST['edit_email']);
    
    $updateSql = "UPDATE users SET name = '$name', email = '$email' WHERE id = $id";
    if ($conn->query($updateSql) === TRUE) {
        echo "<script>alert('Admin updated successfully'); window.location.href = 'index.php';</script>";
    } else {
        echo "Error: " . $conn->error;
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['delete_admin'])) {
    $id = $_POST['admin_id'];
    $deleteSql = "DELETE FROM users WHERE id = $id";
    if ($conn->query($deleteSql) === TRUE) {
        echo "<script>alert('Admin deleted successfully'); window.location.href = 'index.php';</script>";
    } else {
        echo "Error: " . $conn->error;
    }
}
?>
