<?php
session_start();
/**
 * Created by PhpStorm.
 * User: hudutech
 * Date: 3/17/17
 * Time: 4:52 PM
 */


session_destroy();
unset($_SESSION['username']);
unset($_SESSION['admin_username']);


header("Location: login.php");
