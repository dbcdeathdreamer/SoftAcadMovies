<?php require_once 'common/header.php'; ?>
<!-- Content Row -->
<div class="row">
    <!-- Sidebar Column -->
    <div class="col-md-3">
        <?php require_once 'common/nav.php'; ?>
    </div>
    <!-- Content Column -->
    <div class="col-md-9">
        <?php
            $data =[
                'username' => '',
                'password' => '',
                'email'    => '',
            ];

            $errors = [
                'username' => [],
                'password' => [],
                'email'    => [],
            ];
        ?>
        <div class="row">
            <div class="col-md-4"></div>
            <div class="col-md-4">
                <form action="" method="post">
                    <div class="form-group  <?php echo (!empty($errors['username']))? 'has-error': ''; ?>">
                        <label for="username">Username</label>
                        <input type="text" value="<?php echo $data['username']; ?>" class="form-control" name="username" placeholder="Username" id="username" />
                        <?php
                        //Когато имаме foreach() не се прави проверка дали масива е празен
                        //if(!empty($errors['username'])) { ?>
                        <?php foreach($errors['username'] as $errorUsername) { ?>
                            <div class="alert alert-danger" role="alert" style="margin-top:10px;">
                                <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
                                <span class="sr-only">Error: </span>
                                <?php echo $errorUsername; ?>
                            </div>
                        <?php } ?>
                        <?php //} ?>
                    </div>
                    <div class="form-group  <?php echo (!empty($errors['password']))? 'has-error' : '' ?> ">
                        <label for="password">Password</label>
                        <input type="password" class="form-control" name="password" id="password" placeholder="password" />
                        <?php foreach ($errors['password'] as $errorPassword) { ?>
                            <div class="alert alert-danger" role="alert" style="margin-top:10px;">
                                <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
                                <span class="sr-only">Error: </span>
                                <?php echo $errorPassword; ?>
                            </div>
                        <?php } ?>
                    </div>
                    <div class="form-group <?php echo (!empty($errors['email']))? 'has-error' : '' ?> ">
                        <label for="email">Email</label>
                        <input type="email" value="<?php echo $data['email']; ?>" class="form-control" name="email" placeholder="email" id="email" />
                        <?php foreach ($errors['email'] as $errorPassword) { ?>
                            <div class="alert alert-danger" role="alert" style="margin-top:10px;">
                                <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
                                <span class="sr-only">Error: </span>
                                <?php echo $errors['email']; ?>
                            </div>
                        <?php } ?>
                    </div>


                    <input type="submit" class="btn btn-primary" name="register" value="Register">
                </form>
            </div>
            <div class="col-md-4"></div>
        </div>

    </div>
</div>
<!-- /.row -->

<?php require_once 'common/footer.php'; ?>