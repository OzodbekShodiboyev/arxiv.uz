<?php require_once 'controller.php'; ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Admins</title>
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
                <h1>Administratorlar</h1>

                <button type="button" class="btn btn-primary mb-4" data-toggle="modal" data-target="#addAdminModal">
                    Yangi Admin Qo'shish
                </button>

                <?php if (isset($error_message)): ?>
                    <div class="alert alert-danger" role="alert">
                        <?= $error_message ?>
                    </div>
                <?php endif; ?>

                <table class="table">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Balance</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if ($result->num_rows > 0): ?>
                            <?php while ($admin = $result->fetch_assoc()): ?>
                                <tr>
                                    <td><?= htmlspecialchars($admin['id']) ?></td>
                                    <td><?= htmlspecialchars($admin['name']) ?></td>
                                    <td><?= htmlspecialchars($admin['email']) ?></td>
                                    <td><?= htmlspecialchars($admin['balance']) ?> UZS</td>
                                    <td>
                                        <!-- Delete button triggers delete modal -->
                                        <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#deleteAdminModal" data-id="<?= $admin['id'] ?>">
                                            Delete
                                        </button>
                                    </td>
                                </tr>
                            <?php endwhile; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="5">Hech qanday administrator topilmadi.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>

                <!-- Modal for adding new admin -->
                <div class="modal fade" id="addAdminModal" tabindex="-1" role="dialog" aria-labelledby="addAdminModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="addAdminModalLabel">Yangi Administrator Qo'shish</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <form method="POST" action="">
                                    <div class="form-group">
                                        <label for="name">Ism</label>
                                        <input type="text" class="form-control" id="name" name="name" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="email">Email</label>
                                        <input type="email" class="form-control" id="email" name="email" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="password">Parol</label>
                                        <input type="password" class="form-control" id="password" name="password" required>
                                    </div>
                                    <button type="submit" name="add_admin" class="btn btn-primary">Qo'shish</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

               

                <!-- Modal for deleting admin -->
                <div class="modal fade" id="deleteAdminModal" tabindex="-1" role="dialog" aria-labelledby="deleteAdminModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="deleteAdminModalLabel">Administratorni O'chirish</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <p>Ushbu administratorni o'chirmoqchimisiz?</p>
                            </div>
                            <div class="modal-footer">
                                <form method="POST" action="">
                                    <input type="hidden" name="admin_id" id="delete_admin_id">
                                    <button type="submit" name="delete_admin" class="btn btn-danger">O'chirish</button>
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Bekor qilish</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

<script src="../../../assets/admin/vendor/jquery/jquery.min.js"></script>
<script src="../../../assets/admin/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="../../../assets/admin/js/sb-admin-2.min.js"></script>

<!-- Modal trigger scripts -->
<script>
   
    // Enable delete modal functionality
    $('#deleteAdminModal').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget);
        var adminId = button.data('id');
        
        var modal = $(this);
        modal.find('#delete_admin_id').val(adminId);
    });
</script>
</body>

</html>
