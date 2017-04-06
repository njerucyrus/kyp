<?php
session_start();
/**
 * Created by PhpStorm.
 * User: hudutech
 * Date: 3/22/17
 * Time: 11:25 PM
 */
require_once __DIR__ . '/../models/user.php';
$error_message = '';
if(isset($_POST['username']) and isset($_POST['password'])){
    $username = $_POST['username'];
    $password = $_POST['password'];

    $auth = new Auth();

    $authenticated = $auth->authenticate($username, $password);
    if ($authenticated) {
        //check if the user is admin
        $userObject = User::getById($username);
        $user = $userObject->fetch(PDO::FETCH_ASSOC);

        if($user['is_admin'] == 1){
            $_SESSION['admin_username'] = $username;
            header('Location: index.php');
        }
        else{
            header('Location: admin_login.php');
        }

    } else {
        session_destroy();
        $error_message .= "invalid username/password";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <?php include 'css.php'?>
</head>
<body>
<div class="navbar navbar-inverse">
    <?php include 'navbar.php' ?>
</div>
<div class=" container container-fluid">
    <div class="row">
        <div class="col-sm-6 col-md-4 col-md-offset-4">
            <?php
            if ($error_message !=''){
                echo "<div class='alert alert-danger'>".$error_message."</div>";
            }
            ?>
            <h1 class="text-center login-title form-signin-heading">Sign in to continue to PremierPesa Admin Panel</h1>

            <div class="account-wall">
                <img class="avartar" src="../public/assets/img/logo2.png" alt="Admin Login">
                <form class="form-signin" action="admin_login.php" method="POST">
                    <input type="text" name="username" class="form-control" style="margin-bottom: 5px;"
                           placeholder="Username/email" required autofocus>

                    <input type="password" name="password" class="form-control" style="margin-bottom: 5px;"
                           placeholder="Password" required>
                    <input class="btn btn-lg btn-danger btn-block btn-raised" type="submit" value="login">

                </form>
            </div>

        </div>
    </div>
</div>
<?php include 'js.php'?>
</body>
</html>