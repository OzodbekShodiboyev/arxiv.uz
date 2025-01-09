<?php
require '../../helpers/auth_helper.php';
requireAdmin();
?>
<!DOCTYPE html>
<html lang="en">

<?php require_once './layouts/header.php';?>

<body id="page-top">

    
    <div id="wrapper">

       <?php require_once './layouts/sidebar.php'; ?>

        
        <div id="content-wrapper" class="d-flex flex-column">

            <div id="content">

               <?php require_once './layouts/topbar.php'; ?>
                

               <?php require_once './layouts/main.php'; ?>

            </div>

            <?php require_once './layouts/footer.php';?>

        </div>

    </div>

    <!-- Logout Modal-->
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                    <a class="btn btn-primary" href="http://localhost:8000/logout.php">Logout</a>
                </div>
            </div>
        </div>
    </div>

    <?php require_once './layouts/scripts.php';?>

</body>

</html>