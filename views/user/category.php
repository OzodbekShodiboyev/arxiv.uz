<?php
include_once 'database.php';


$sql = "SELECT * FROM categories";
$result = $conn->query($sql);

?>

<div class="container pt-5 pb-3">
    <div class="text-center mb-5">
        <h5 class="text-primary text-uppercase mb-3" style="letter-spacing: 5px;">O'zingizga kerakli kategoriyani tanlang!</h5>
        <h1>Kategoriyalar</h1>
    </div>
    <div class="row">
        <?php
        
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo '<div class="col-lg-3 col-md-6 mb-4">';
                echo '<div class="cat-item position-relative overflow-hidden rounded mb-2">';
                echo '<img class="img-fluid" src="assets/img/cat-1.jpg" alt="">';  
                echo '<a class="cat-overlay text-white text-decoration-none" href="/views/user/fan.php?cat=' . $row['id'] . '">';
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