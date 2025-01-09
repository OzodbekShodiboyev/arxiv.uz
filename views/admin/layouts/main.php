<?php
// Database connection
try {
    $pdo = new PDO('mysql:host=localhost;dbname=arxivuz', 'root', '');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}

// Fetch the counts
try {
    // Count categories
    $categoriesStmt = $pdo->query("SELECT COUNT(*) AS total_categories FROM categories");
    $categoriesCount = $categoriesStmt->fetch(PDO::FETCH_ASSOC)['total_categories'];

    // Count files
    $filesStmt = $pdo->query("SELECT COUNT(*) AS total_files FROM files");
    $filesCount = $filesStmt->fetch(PDO::FETCH_ASSOC)['total_files'];

    // Count subjects
    $subjectsStmt = $pdo->query("SELECT COUNT(*) AS total_subjects FROM subjects");
    $subjectsCount = $subjectsStmt->fetch(PDO::FETCH_ASSOC)['total_subjects'];
} catch (PDOException $e) {
    die("Error fetching data: " . $e->getMessage());
}
?>

<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
    </div>

    <!-- Content Row -->
    <div class="row">

        <!-- Categories Count -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Kategoriyalar Soni</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $categoriesCount ?></div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-folder fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Files Count -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                Fayllar Soni</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $filesCount ?></div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-file-alt fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Subjects Count -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                Fanlar Soni</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $subjectsCount ?></div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-book fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
<!-- /.container-fluid -->
