<?php
session_start();
require_once 'common/functions.php';
require_once 'common/db.php';

if (!isLoggedInAdmin()) {
    redirect('login.php');
}


$id = isset($_GET['id']) ? $_GET['id'] : '';

if ((int)$id <= 0) {
    redirect('administratorsListing.php');
}

$user = getUserById($id, $conn);

if (empty($user)) {
    redirect('administratorsListing.php');
}


deleteUserById($id, $conn);

redirect('administratorsListing.php');




