<?php
if (!isset($_SESSION['admin_username'])){
    header("Location: admin_login.php");
}
/**
 * Created by PhpStorm.
 * User: hudutech
 * Date: 3/18/17
 * Time: 12:34 AM
 */
require_once __DIR__ . '/../models/user.php';
?>



<!DOCTYPE html>
<html>
<head>
    <?php include 'css.php'; ?>

</head>
<body>
<div class="navbar navbar-inverse">
    <?php include "navbar.php"; ?>
</div>
<div class="container">
    <div class="row">
        <div class="col col-md-12">
            <div class="table-responsive">

                </div>
                <table class="table" id="users-table">

                    <h5 style="font-size: 1.2em;">Manage Registered Users</h5>
                    <div class="pull-right" style="margin: 15px; font-size: 1.2em;">
                        <?php
                        $user_stats = User::getUserStats();
                        for ($i=0; $i<sizeof($user_stats); $i++){
                            foreach ($user_stats[$i] as $key=>$value){
                                echo $key."\t<span class='badge' style='font-size: 1.2em;'> ".$value." </span> \t";
                            }

                        }

                        ?>
                    </div>
                    <thead>
                    <tr class="bg-primary">
                        <th>FullName</th>
                        <th>Phone</th>
                        <th>ID NO</th>
                        <th>Paypal Email</th>
                        <th>Count Limit</th>
                        <th>Amount Limit</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <?php
                    $users = User::all();
                    if (!is_null($users)) {
                        while ($user = $users->fetch(PDO::FETCH_ASSOC)) {
                            ?>

                            <tr>
                                <td><?php echo $user['first_name']; ?> &nbsp;<?php echo $user['last_name']; ?></td>

                                <td><?php echo $user['phone_number']; ?></td>
                                <td><?php echo $user['id_no']; ?></td>
                                <td><?php echo $user['paypal_email']; ?></td>
                                <td><?php echo $user['transaction_limit']; ?> Per day</td>
                                <td><?php echo $user['amount_limit']; ?> $</td>

                                <td><?php echo $user['status']; ?></td>
                                <td colspan="3">
                                    <?php
                                    if ($user['status'] == 'pending') {
                                        ?>
                                        <a href="#" class="btn btn-xs btn-primary"
                                           onclick="approveAccount('<?php echo $user['id'] ?>')">Approve</a>
                                    <?php } ?>

                                    <?php
                                    if ($user['status'] != 'blocked' and $user['status'] != 'pending') {
                                        ?>

                                        <a href="#" class="btn btn-xs btn-info" onclick="promoteDemote('<?php echo $user['id'];?>', '<?php echo $user['is_admin'];?>')">
                                            <?php

                                            if ($user['is_admin'] == 1)
                                                echo "Remove Admin";

                                            elseif ($user['is_admin'] == 0) {

                                                echo "Make Admin";
                                            }
                                            ?>
                                        </a>

                                        <a href="#" class="btn btn-xs btn-warning"
                                           onclick="updateLimit('<?php echo $user['id'] ?>', '<?php echo $user['amount_limit']; ?>', '<?php echo $user['transaction_limit'] ?>')">Update
                                            Limit
                                        </a>
                                        <?php
                                    }

                                    if ($user['status'] == 'blocked' or $user['status'] == 'approved') {
                                        ?>

                                        <a href="#" class="btn btn-xs btn-danger"
                                           onclick="blockUnblockUser('<?php echo $user['id'] ?>', '<?php echo $user['status']; ?>')">
                                            <?php
                                            if ($user['status'] == 'blocked') {
                                                echo 'Unblock';
                                            } else {
                                                echo "Block";
                                            }
                                            ?>
                                        </a>

                                        <?php
                                    }
                                    ?>


                                </td>
                            </tr>
                            <?php

                        }
                    }
                    ?>

                </table>
            </div>
        </div>

    </div>
</div>

<!--update limit modal -->
<div id="LimitsModal" class="modal fade" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Update Limits <code id="cow-name-confirm"></code></h4>
            </div>
            <div class="modal-body">
                <div id="limits_feedback"></div>
                <form>
                    <div class="form-group">

                        <label for="amount_limit">Amount Limit($)</label>
                        <input type="hidden" id="user_id_limit">
                        <input type="number" class="form-control" id="amount_limit"
                               placeholder="set the amount the user can convert">
                    </div>
                    <div class="form-group">
                        <label for="transaction_limit">Number of Transaction per day</label>
                        <input type="number" class="form-control" id="transaction_limit"
                               placeholder="the transaction limit count for user">
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button id='Update' type="button" class="btn btn-danger" onclick="submitLimit()">
                    Update
                </button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>

    </div>
</div>


<!--Confirm Action Modal-->
<div id="ConfirmModal" class="modal fade" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title"><code id="confirm_action_title"></code></h4>
            </div>
            <div class="modal-body">
                <div id="confirm_feedback"></div>
                <div class="alert alert-info">
                    <p id="confirm_message"></p>
                </div>
            </div>
            <div class="modal-footer">
                <button id="btn_action" type="button" class="btn btn-danger">
                    Submit
                </button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
            </div>
        </div>

    </div>
</div>

<?php include 'js.php' ?>

<script>
    $(document).ready(function (e) {
        e.preventDefault;

        var prefix = 'paginate';
        $('#users-table').paginate({
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

<script>

    var url = 'manage_users_endpoint.php';
    function updateLimit(id, amtLimit, txnLimit) {
        $('#LimitsModal').modal('show');
        $('#user_id_limit').val(id);
        $('#amount_limit').val(amtLimit);
        $('#transaction_limit').val(txnLimit);


    }

    function submitLimit() {
        var user_id = $('#user_id_limit').val();
        var amtLimit = $('#amount_limit').val();
        var txnLimit = $('#transaction_limit').val();

        $.ajax(
            {
                type: 'POST',
                url: url,
                data: {'option': 'update_limit', 'id': user_id, 'amtLimit': amtLimit, 'txnLimit': txnLimit},
                dataType: 'json',
                success: function (response) {

                    console.log(response)

                    if (response.statusCode == 200) {
                        $('#limits_feedback')
                            .removeClass('alert alert-danger')
                            .addClass('alert alert-success')
                            .text(response.message);
                        setTimeout(function () {
                            $('#LimitsModal').modal('hide');
                            window.location.reload()

                        }, 1000)
                    }
                    else if (response.statusCode == 500) {
                        $('#limits_feedback')
                            .removeClass('alert alert-success')
                            .addClass('alert alert-danger')
                            .text("Update failed try again later");
                        setTimeout(function () {
                            $('#LimitsModal').modal('hide');
                            window.location.reload()

                        }, 1000);
                    }

                }
            }
        );

    }

    function blockUnblockUser(id, status) {

        $('#ConfirmModal').modal('show');

        var title = '';
        var message = '';
        var new_status = '';
        if (status == 'blocked') {
            title = 'Unblock The user account'
            message = 'Are you sure you want to UNBLOCK the user\n' +
                'unblocking the user allows them to access your services' +
                'press submit to CONFIRM this action'
            new_status = 'approved'

        }
        else {
            title = 'Block User';
            message = 'Are you sure you want to block this user?' +
                '\nBlocked users will not be able to access any of your services\n' +
                'Press submit button to CONFIRM this action'
            new_status = 'blocked';
        }

        $('#confirm_action_title').text(title);

        $('#confirm_message').text(message);

        $('#btn_action').on('click', function () {

            console.log('id is', id);

            $.ajax(
                {
                    type: 'POST',
                    url: url,
                    data: {'option': 'block_user', 'id': id, 'status': new_status},
                    dataType: 'json',
                    success: function (response) {

                        if (response.statusCode == 200) {
                            $('#confirm_feedback')
                                .removeClass('alert alert-danger')
                                .addClass('alert alert-success')
                                .text(response.message);
                            setTimeout(function () {
                                $('#ConfirmModal').modal('hide');
                                window.location.reload()

                            }, 1000)
                        }
                        else if (response.statusCode == 500) {
                            $('#confirm_feedback')
                                .removeClass('alert alert-success')
                                .addClass('alert alert-danger')
                                .text("Update failed try again later");
                            setTimeout(function () {
                                $('#ConfirmModal').modal('hide');
                                window.location.reload()

                            }, 1000);
                        }

                    }
                }
            );
        });
    }
    function approveAccount(id) {
        $('#ConfirmModal').modal('show');
        $('#confirm_action_title').text("Approve User Account");
        $('#confirm_message').text("Are you sure you want to approve the Account\n" +
            "Press Submit to Continue or Cancel button to Cancel the action");
        $('#btn_action').on('click', function () {
            $.ajax(
                {
                    type: 'POST',
                    url: url,
                    data: {'option': 'approve', 'id': id},
                    dataType: 'json',
                    success: function (response) {
                        if (response.statusCode == 200) {
                            $('#confirm_feedback')
                                .removeClass('alert alert-danger')
                                .addClass('alert alert-success')
                                .text(response.message);
                            setTimeout(function () {
                                $('#ConfirmModal').modal('hide');
                                window.location.reload()

                            }, 1000)
                        }
                        else if (response.statusCode == 500) {
                            $('#confirm_feedback')
                                .removeClass('alert alert-success')
                                .addClass('alert alert-danger')
                                .text("Error Unable to approve this account try again.");
                            setTimeout(function () {
                                $('#ConfirmModal').modal('hide');
                                window.location.reload()

                            }, 1000);
                        }
                    }

                }
            )

        })
    }

    function promoteDemote(id, status) {
        var new_status = 0;
        var title = '';
        var message = '';

        if(status == 1){
            new_status = 0;
            title = 'Remove Admin Privileges from this user.';
            message = 'Are you sure you want to remove the Admin privileges' +
                'from this user.\n Performing this action will make the user not ' +
                'to have administrative rights. Press Submit to Continue or Cancel to cancel' +
                'this operation'

        }else{
            new_status = 1;
            title = "Make The user Admin";
            message = "Are you sure you want to make this user admin. " +
                "this will make the user to have all the administrative rights"
        }

        $('#ConfirmModal').modal('show');

        $('#confirm_action_title').text(title);

        $('#confirm_message').text(message);

        $('#btn_action').on('click', function () {
            $.ajax(
                {
                    type: 'POST',
                    url: url,
                    data: {'option': 'promote_user', 'id': id, 'status': new_status},
                    dataType: 'json',
                    success: function (response) {

                        if (response.statusCode == 200) {
                            $('#confirm_feedback')
                                .removeClass('alert alert-danger')
                                .addClass('alert alert-success')
                                .text(response.message);
                            setTimeout(function () {
                                $('#ConfirmModal').modal('hide');
                                window.location.reload()

                            }, 1000)
                        }
                        else if (response.statusCode == 500) {
                            $('#confirm_feedback')
                                .removeClass('alert alert-success')
                                .addClass('alert alert-danger')
                                .text("Update failed try again later");
                            setTimeout(function () {
                                $('#ConfirmModal').modal('hide');
                                window.location.reload()

                            }, 1000);
                        }

                    }
                }
            );
        });

    }
</script>
</body>
</html>
