<?php
/**
 * Created by PhpStorm.
 * User: hudutech
 * Date: 3/14/17
 * Time: 11:11 PM
 */


$databaseName = 'kenyapesa';
$password = '';
$databaseHost = 'localhost';
$databaseUser = 'root';

try {
    $conn = new PDO(
        "mysql:host={$databaseHost};
                dbname={$databaseName}",
        $databaseUser,
        $password
    );

    // set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}