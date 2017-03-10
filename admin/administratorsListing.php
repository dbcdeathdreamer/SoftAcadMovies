<?php require_once 'common/header.php'; ?>
<!-- Content Row -->
<div class="row">
    <!-- Sidebar Column -->
    <div class="col-md-3">
        <?php require_once 'common/nav.php'; ?>
    </div>
    <!-- Content Column -->
    <div class="col-md-9">
        <a href="addAdministrator.php"  class="btn btn-info">Create new Admin</a>
        <?php
            if (isset($_SESSION['flash']) && $_SESSION['flash'] != '') {
                echo $_SESSION['flash'];
                unset($_SESSION['flash']);
            }
        ?>
        
        <?php $users = getUsers($conn); ?>

        <table class="table">
            <tr>
                <th>Username</th>
                <th>Email</th>
                <th>Action</th>
            </tr>
            <?php foreach($users as $user) { ?>
                <tr>
                    <td><?php echo $user['username']; ?></td>
                    <td><?php echo $user['email']; ?></td>
                    <td>
                        <a href="editAdministrator.php?id=<?php echo $user['id']; ?>"  class="btn btn-warning">Create new Admin</a>
                        <a href="deleteAdministrator.php?id=<?php echo $user['id']; ?>"  class="btn btn-danger">Create new Admin</a>
                    </td>
                </tr>

            <?php } ?>

        </table>



    </div>
</div>
<!-- /.row -->

<?php require_once 'common/footer.php'; ?>




