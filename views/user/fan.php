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

    <style>
        .cat-item {
            background-color: #f8f9fa;
            border: 1px solid #ddd;
            padding: 15px;
            text-align: center;
        }

        .cat-overlay {
            display: block;
            padding: 10px;
            background-color: rgba(0, 0, 0, 0.5);
        }

        .cat-item h4 {
            font-size: 18px;
            margin: 0;
            color: #fff;
        }
    </style>
    <link href="../../../assets/css/style.css" rel="stylesheet">
</head>

<body>
    <?php require_once '../../components/layouts/topbar.php' ?>
    <?php require_once '../../components/layouts/navbar.php' ?>

    <?php
    include_once 'database.php';


    $sql = "SELECT * FROM subjects";
    $result = $conn->query($sql);

    ?>

    <div class="container pt-5 pb-3">
        <div class="text-center mb-5">
            <h1>Endi fanni tanlang ! </h1>
        </div>
        <div class="row">
            <?php
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo '<div class="col-lg-3 col-md-6 mb-4">';
                    echo '<div class="cat-item position-relative overflow-hidden rounded mb-2">';
                    echo '<img class="img-fluid" src="assets/img/cat-1.jpg" alt="">';  
                    echo '<a class="cat-overlay text-white text-decoration-none" href="' . BASE_URL . '/views/user/files.php?cat=' . $_GET['cat'] . '&subject=' . $row['id'] . '">';
                    echo '<h4 class="text-white font-weight-medium">' . htmlspecialchars($row['name']) . '</h4>';
                    echo '</a>';
                    echo '</div>';
                    echo '</div>';
                }
            } else {
                echo '<p>Hech qanday kategoriya mavjud emas.</p>';
            }

            $conn->close();
            ?>
        </div>
    </div>



    <?php require_once '../../components/layouts/footer.php' ?>
</body>

</html>