<?php
session_start();
if(!isset($_SESSION['admin_username'])){
    header('Location: admin_login.php');
}

/**
 * Created by PhpStorm.
 * User: hudutech
 * Date: 3/18/17
 * Time: 12:34 AM
 */
require_once __DIR__ . '/../models/user.php';
?>

<?php
include 'manage_users.php';
?>