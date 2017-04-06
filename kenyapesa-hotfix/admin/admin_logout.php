<?php
session_start();
/**
 * Created by PhpStorm.
 * User: hudutech
 * Date: 3/22/17
 * Time: 11:26 PM
 */

session_destroy();
unset($_SESSION['admin_username']);

header('Location: admin_login.php');