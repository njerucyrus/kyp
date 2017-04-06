<?php
/**
 * Created by PhpStorm.
 * User: hudutech
 * Date: 3/18/17
 * Time: 1:03 AM
 */

?>

<div class="container-fluid">
    <div class="navbar-header">
        <button type="button" class="navbar-toggle" data-toggle="collapse"
                data-target=".navbar-responsive-collapse">
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
        </button>
        <a class="navbar-brand" href="../base.php">PremierPesa</a>
    </div>
    <div class="navbar-collapse collapse navbar-responsive-collapse">
        <ul class="nav navbar-nav">
            <?php
            if(isset($_SESSION['admin_username'])){
                ?>

                <li><a href="index.php">Users</a></li>
                <li><a href="transactions_list.php">Transactions</a></li>
                <li><a href="admin_rates.php">Rates & Limits</a></li>
                <li><a href="manage_merchant_emails.php">Merchant Emails</a></li>
                <li><a href="admin_reviews.php">Reviews</a></li>
                <li><a href="manage_subscription.php">Subscriptions</a></li>
                <li><a href="https://uhchat.net/admin/">Live Chat</a></li>
            <?php
            }
            else{
                ?>
                <li><a href="admin_login.php">Login</a></li>
            <?php
            }
            ?>




<!--            <li class="dropdown">-->
<!--                <a href="#" data-target="#" class="dropdown-toggle" data-toggle="dropdown">Farm Records-->
<!---->
<!--                    <b class="caret"></b></a>-->
<!--                <ul class="dropdown-menu">-->
<!---->
<!--                    <li><a href="#">Animal Treatment</a></li>-->
<!--                    <li><a href="#">Expenses</a></li>-->
<!---->
<!--                </ul>-->
<!--            </li>-->

<!--            <li class="dropdown">-->
<!--                <a href="bootstrap-elements.html" data-target="#" class="dropdown-toggle" data-toggle="dropdown">-->
<!---->
<!--                    <b class="caret"></b></a>-->
<!--                <ul class="dropdown-menu">-->
<!---->
<!--<!--                    <li><a href="#">some link</a></li>-->
<!--                    -->
<!--                </ul>-->
<!--            </li>-->

        </ul>

        <ul class="nav navbar-nav navbar-right">
            <li class="dropdown">
                <a href="#" data-target="#" class="dropdown-toggle" data-toggle="dropdown">Account
                    <b class="caret"></b></a>
                <ul class="dropdown-menu">
                    <?php
                    if(isset($_SESSION['admin_username'])){
                        ?>
                    <li><a href="admin_logout.php"><i class="fa fa-user-circle" style="font-size: 16px;">&nbsp;Logout</i></a></li>
                    <?php
                    }
                    else{
                        ?>
                    <li><a href="admin_login.php"><i class="fa fa-user-circle" style="font-size: 16px;">&nbsp;Login</i></a></li>
                    <?php
                    }
                    ?>
                </ul>
            </li>
        </ul>
    </div>
</div>
