<?php
session_start();
/**
 * Created by PhpStorm.
 * User: hudutech
 * Date: 3/18/17
 * Time: 10:09 PM
 */

if (!isset($_SESSION['admin_username'])){
    header("Location: admin_login.php");
}

require_once __DIR__ . '/../models/class.payment.php';
require_once __DIR__ . '/../models/user.php';

?>
<!DOCTYPE html>
<html>
<head>
    <?php include "css.php";?>
</head>

<body>
<div class="navbar navbar-inverse">
    <?php include "navbar.php"; ?>
</div>

<div class="container container-fluid">
    <div class="row">
        <div class="col col-md-12">
            <h5>Transaction Made by users</h5>
            <div class="table-responsive">
                <table class="table" id="txns-table">
                    <thead>
                    <tr class="bg-primary">
                        <th>FullName</th>
                        <th>Paypal Email</th>
                        <th>Dollars Converted</th>
                        <th>Ksh Sent</th>
                        <th>Status</th>
                        <th>Date</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    $payment = Payment::all();
                    if (!is_null($payment)) {

                        while ($txn = $payment->fetch(PDO::FETCH_ASSOC)) {

                            $userObject = User::getById($txn['paypal_email']);
                            if (!is_null($userObject)) {
                                $user = $userObject->fetch(PDO::FETCH_ASSOC);
                                $full_name = $user['first_name'] . " " . $user['last_name'];
                            } else {
                                $full_name = '';
                            }
                            ?>

                            <tr>
                                <td><?php echo $full_name;?></td>
                                <td><?php echo $txn['paypal_email'];?></td>
                                <td><?php echo $txn['dollars'];?> $</td>
                                <td>KSH <?php echo $txn['shillings']?></td>
                                <td><?php echo $txn['status']?></td>
                                <td><?php echo $txn['date']?></td>
                            </tr>


                            <?php

                        }
                    }
                    ?>


                    </tbody>
                </table>


            </div>
        </div>

    </div>
</div>

<?php include('js.php')?>


<script>
    $(document).ready(function (e) {
        e.preventDefault;

        var prefix = 'paginate';
        $('#txns-table').paginate({
            'maxButtons': 10,
            'elemsPerPage': 10,
            'disabledClass': prefix + 'Disabled',
            'activeClass': prefix + 'Active',
            'containerClass': prefix + 'Container',
            'listClass': prefix + 'List',
            'showAllListClass': prefix + 'ShowAllList',
            'previousClass': prefix + 'Previous',
            'nextClass': prefix + 'Next',
            'previousSetClass': prefix + 'PreviousSet',
            'nextSetClass': prefix + 'NextSet',
            'showAllClass': prefix + 'ShowAll',
            'pageClass': prefix + 'Page',
            'anchorClass': prefix + 'Anchor'

        });
    })
</script>
</body>
</html>