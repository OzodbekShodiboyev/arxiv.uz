<?php require_once 'controller.php';?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Subjects</title>
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
                <h1>Fanlar</h1>
                <button class="btn btn-primary mb-3" data-toggle="modal" data-target="#addSubjectModal">Fan qo'shish</button>

                <table class="table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($subject = $subjects->fetch_assoc()): ?>
                            <tr>
                                <td><?= $subject['id'] ?></td>
                                <td><?= htmlspecialchars($subject['name']) ?></td>
                                <td>
                                    <button class="btn btn-warning btn-sm" data-toggle="modal" data-target="#editSubjectModal<?= $subject['id'] ?>">Tahrirlash</button>
                                    <button class="btn btn-danger btn-sm" data-toggle="modal" data-target="#deleteSubjectModal<?= $subject['id'] ?>">O'chirish</button>
                                </td>
                            </tr>

                            <!-- Edit Modal -->
                            <div class="modal fade" id="editSubjectModal<?= $subject['id'] ?>" tabindex="-1" role="dialog">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Edit Subject</h5>
                                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                                        </div>
                                        <form method="POST" action="">
                                            <div class="modal-body">
                                                <input type="hidden" name="id" value="<?= $subject['id'] ?>">
                                                <div class="form-group">
                                                    <label for="name">Name</label>
                                                    <input type="text" class="form-control" name="name" value="<?= htmlspecialchars($subject['name']) ?>" required>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="submit" name="edit_subject" class="btn btn-primary">Save</button>
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>

                            <!-- Delete Modal -->
                            <div class="modal fade" id="deleteSubjectModal<?= $subject['id'] ?>" tabindex="-1" role="dialog">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Delete Subject</h5>
                                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                                        </div>
                                        <form method="POST" action="">
                                            <div class="modal-body">
                                                <p>Are you sure you want to delete this subject?</p>
                                                <input type="hidden" name="id" value="<?= $subject['id'] ?>">
                                            </div>
                                            <div class="modal-footer">
                                                <button type="submit" name="delete_subject" class="btn btn-danger">Delete</button>
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Add Subject Modal -->
<div class="modal fade" id="addSubjectModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add Subject</h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <form method="POST" action="">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="name">Name</label>
                        <input type="text" class="form-control" name="name" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" name="add_subject" class="btn btn-primary">Save</button>
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
