<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: /login.php");
    exit;
}

$user_id = $_SESSION['user_id'];

include_once 'database.php';


$sql_balance = "SELECT balance FROM users WHERE id = ?";
$stmt_balance = $conn->prepare($sql_balance);
$stmt_balance->bind_param("i", $user_id);
$stmt_balance->execute();
$stmt_balance->bind_result($balance);
$stmt_balance->fetch();
$stmt_balance->close();

// Balansni tekshirish
if ($balance < 1000) {
    header("Location:payment.php");
    exit;
}
$cat_id = isset($_GET['cat']) ? $_GET['cat'] : null;
$subject_id = isset($_GET['subject']) ? $_GET['subject'] : null;

$sql = "SELECT * FROM files WHERE category_id = ? AND subject_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ii", $cat_id, $subject_id);
$stmt->execute();
$result = $stmt->get_result();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>ECOURSES - Online Courses HTML Template</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="Free HTML Templates" name="keywords">
    <meta content="Free HTML Templates" name="description">
    <link href="assets/img/favicon.ico" rel="icon">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link href="../../assets/css/style.css" rel="stylesheet">
</head>

<body>
    <?php require_once '../../components/layouts/topbar.php' ?>
    <?php require_once '../../components/layouts/navbar.php' ?>

   

    <div class="container pt-5 pb-3">
        <div class="text-center mb-5">
            <h5 class="text-primary text-uppercase mb-3" style="letter-spacing: 5px;">O'zingizga kerakli fayllarni tanlang!</h5>
            <h1>Fayllar</h1>
        </div>
        <div class="row">
            <?php
            // Agar fayllar mavjud bo'lsa, ularni chiqarish
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo '<div class="col-lg-3 col-md-6 mb-4">';
                    echo '<div class="cat-item position-relative overflow-hidden rounded mb-4">';
                    echo '<div class="file-container">';
                    echo '<h4 class="text-center">' . htmlspecialchars($row['name']) . '</h4>';
                    echo '<a class="btn btn-outline-primary w-100 mt-3" href="/' . htmlspecialchars($row['path']) . '" download>Yuklab olish</a>';

                    echo '</div>';
                    echo '</div>';
                    echo '</div>';
                }
            } else {
                echo '<p class="text-danger text-center w-100">Hech qanday fayl mavjud emas.</p>';
            }

            // MySQL ulanishini yopish
            $conn->close();
            ?>
        </div>
    </div>


    
    <?php require_once '../../components/layouts/footer.php' ?>
</body>

</html>