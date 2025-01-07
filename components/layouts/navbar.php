<?php session_start(); ?>

<div class="container-fluid">
    <div class="row border px-xl-5">
        <div class="col-lg-3 d-none d-lg-block">
            <a class="d-flex align-items-center justify-content-between bg-primary  w-100 text-decoration-none" data-toggle="collapse" href="#navbar-vertical" style="height: 67px; padding: 0 30px;">
                <h5 class="text-light m-0"><i class="fa fa-book-open mr-2"></i>Kategoriyalar</h5>
                <i class="fa fa-angle-down text-light"></i>
            </a>
            <nav class="collapse position-absolute navbar navbar-vertical navbar-light align-items-start p-0 border border-top-0 border-bottom-0 bg-light" id="navbar-vertical" style="width: calc(100% - 30px); z-index: 9;">
                <div class="navbar-nav w-100">
                    <div class="nav-item dropdown">

                    </div>
                    <a href="" class="nav-item nav-link">Apps Design</a>
                    <a href="" class="nav-item nav-link">Marketing</a>
                    <a href="" class="nav-item nav-link">Research</a>
                    <a href="" class="nav-item nav-link">SEO</a>
                </div>
            </nav>
        </div>
        <div class="col-lg-9">
            <nav class="navbar navbar-expand-lg bg-light navbar-light py-3 py-lg-0 px-0">
                <a href="" class="text-decoration-none d-block d-lg-none">
                    <h1 class="m-0"><span class="text-primary">ARXIV</span>.UZ</h1>
                </a>
                <button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#navbarCollapse">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse justify-content-between" id="navbarCollapse">
                    <div class="navbar-nav py-0">
                        <a href="index.html" class="nav-item nav-link active">Bosh sahifa</a>
                        <a href="about.html" class="nav-item nav-link">Biz haqimizda</a>
                        <a href="contact.html" class="nav-item nav-link">Bog'lanish</a>
                    </div>

                    <div class="ml-auto d-lg-block">
    <?php 
        if (!isset($_SESSION['user_id'])) {
            echo '<a href="login.php" class="btn btn-primary me-2">Kirish</a> 
                  <a href="register.php" class="btn btn-outline-primary">Ro‘yxatdan o‘tish</a>';
        } else {
            echo '
            <div style="position: relative; display: inline-block;">
                <button class="btn btn-primary btn-outline-secondary" onclick="toggleDropdown()" style="border-radius: 20px; padding: 10px 20px; font-weight: bold; display: flex; align-items: center;">
                    <i class="fas fa-user-circle" style="margin-right: 8px;"></i> Profil
                </button>
                <div id="dropdown" style="display: none; position: absolute; top: 100%; right: 0; background-color: white; box-shadow: 0 4px 10px rgba(0, 0, 0, 0.15); border-radius: 10px; min-width: 220px; z-index: 1000;">
                    <div style="padding: 15px; border-bottom: 1px solid #f1f1f1;">
                        <p style="margin: 0; font-weight: bold; color: #333;">Ism: ' . htmlspecialchars($_SESSION['user_name']) . '</p>
                        <p style="margin: 5px 0 0 0; color: #666;">Balans: <span style="font-weight: bold; color: #007bff;">' . htmlspecialchars($_SESSION['balance']) . ' UZS</span></p>
                    </div>
                    <a href="logout.php" style="display: block; padding: 10px 15px; text-decoration: none; color: #007bff; font-weight: bold; text-align: center;">Chiqish</a>
                </div>
            </div>
            <script>
                function toggleDropdown() {
                    var dropdown = document.getElementById("dropdown");
                    dropdown.style.display = dropdown.style.display === "none" ? "block" : "none";
                }
                // Dropdownni tashqariga bosganda yopish uchun
                window.addEventListener("click", function(e) {
                    var dropdown = document.getElementById("dropdown");
                    if (!e.target.closest("button") && !e.target.closest("#dropdown")) {
                        dropdown.style.display = "none";
                    }
                });
            </script>';
        }
    ?>
</div>
                </div>
            </nav>
        </div>
    </div>
</div>