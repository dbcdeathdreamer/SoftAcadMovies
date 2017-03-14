<?php require_once 'common/header.php'; ?>
<?php
if (isLoggedInAdmin()) {
    redirect('index.php');
}


$data = [
    'username' => '',
    'password' => '',
];
$error = '';

if (isset($_POST['submit'])) {
    $data = [
        'username' => isset($_POST['username']) ? trim(htmlspecialchars($_POST['username'])) : '',
        'password' => isset($_POST['password']) ? trim(htmlspecialchars($_POST['password'])) : '',
    ];


    if (strlen($data['username']) > 4 &&
        strlen($data['username']) <= 255 &&
        strlen($data['password']) > 4 &&
        strlen($data['password']) <= 255
    ) {
        $user = getUserByUsername($data['username'], $conn);
        if (!empty($user)) {
            $pass = sha1($data['password']);
            echo '<pre>';
            var_dump($pass, $user['password']);
            echo '</pre>';
            if ($pass == $user['password']) {
                $_SESSION['logged_in'] = 1;
                unset($user['password']);
                $_SESSION['user']      = $user;

                redirect('index.php');

            } else {
                $error = "Wrong credentials";
            }

        } else {
            $error = "Wrong credentials";
        }

    } else {
        $error = "Wrong credentials";
    }
    
}

echo '<pre>';
var_dump($error);
echo '</pre>';
?>



<!-- Content Row -->
    <div class="row">
        <div class="col-md-4"></div>
        <div class="col-md-4">
            <form action="" method="post">
                <div class="form-group">
                    <label for="exampleInputEmail1">Username</label>
                    <input type="text" name="username" class="form-control" id="exampleInputEmail1" placeholder="Email">
                </div>
                <div class="form-group">
                    <label for="exampleInputPassword1">Password</label>
                    <input type="password" name="password" class="form-control" id="exampleInputPassword1" placeholder="Password">
                </div>

                <input type="submit" name="submit" value="Login" class="btn btn-default"/>
            </form>
        </div>
        <div class="col-md-4"></div>
    </div>

<!-- /.row -->

<?php require_once 'common/footer.php'; ?>