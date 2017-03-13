<?php
session_start();
require_once ('common/functions.php');

unset($_SESSION['logged_in']);
unset($_SESSION['user']);

redirect('login.php');
