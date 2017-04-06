<?php
session_start();
if (!isset($_SESSION['admin_username'])){
    header("Location: admin_login.php");
}

/**
 * Created by PhpStorm.
 * User: hudutech
 * Date: 3/22/17
 * Time: 4:14 PM
 */
require_once __DIR__.'/../models/class.merchant.php';


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

<div class="container container-fluid">
    <div class="row">
        <div class="col col-md-10 col-md-offset-1">
            <div>
                <button class="btn btn-warning pull-right" style="margin-bottom: 10px;" onclick="createNewEmail()">Add New Merchant Email</button>
            </div>
            <div class="table table-responsive">
                <table class="table table-bordered">
                    <thead>
                    <tr class="bg-primary">
                        <th>Merchant Email</th>
                        <th>PhoneNumber</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                    </thead>

                    <?php

                    $merchants = Merchant::all();
                    if (!is_null($merchants)) {
                        while ($merchant = $merchants->fetch(PDO::FETCH_ASSOC)) {
                            ?>
                            <tr>
                                <td><?php echo $merchant['merchant_email']; ?></td>
                                <td><?php echo $merchant['phone_number']; ?></td>
                                <td>
                                    <?php
                                    if ($merchant['status'] == 0) {
                                        ?>
                                        <span style="color: red; font-size: 1.2em;"><i class="fa fa-remove"></i></span>

                                    <?php } else {
                                        ?>
                                        <span style="color: green; font-size: 1.2em;"><i
                                                    class="fa fa-check-circle-o"></i></span>

                                        <?php
                                    }
                                    ?>
                                </td>
                                <td colspan="3">
                                    <?php
                                    if ($merchant['status'] == 0) {
                                        ?>
                                        <button id="btn-activate" onclick="activate('<?php echo $merchant['id']?>')" class="btn btn-xs btn-success" style="font-size: 1.0em;"><span><i class="fa fa-check-circle-o"></i></span>&nbsp;Activate</button>
                                        <button id="btn-update" onclick="editEmail('<?php echo $merchant['id']?>','<?php echo $merchant['merchant_email']?>','<?php echo $merchant['phone_number']?>')" class="btn btn-xs btn-primary" style="font-size: 1.0em;"><span><i class="fa fa-edit"></i></span>&nbsp;Update</button>
                                        <button id="btn-delete" onclick="deleteEmail('<?php echo $merchant['id']?>')" class="btn btn-xs btn-danger" style="font-size: 1.0em;"><span><i class="fa fa-trash-o"></i></span>&nbsp;Delete</button>

                                    <?php } else {
                                        ?>
                                        <button id="btn-deactivate" onclick="deactivate('<?php echo $merchant['id']?>')" class="btn btn-xs btn-warning" style="font-size: 1.0em;"><span><i class="fa fa-remove"></i></span>&nbsp;Deactivate</button>

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
<!---end of confirm modal-->

<div id="MerchantModal" class="modal fade" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title"><p id="merchant_modal_title">Edit Merchant Email</p></h4>
            </div>
            <div class="modal-body">
                <div id="feedback"></div>
                <form>
                    <div class="form-group">
                        <label for="email">Merchant Email Address</label>
                        <input type="email" class="form-control" id="email" required>
                    </div>

                    <div class="form-group">
                        <label for="phone_number">PhoneNumber</label>
                        <input type="text" class="form-control" id="phone_number" placeholder="07XXX XXX" maxlength="13" required>
                    </div>

                </form>
            </div>
            <div class="modal-footer">
                <button id="btn_save" type="button" class="btn btn-primary">
                    Submit
                </button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
            </div>
        </div>

    </div>
</div>




<?php include 'js.php'?>

<script>
    var url = 'manage_merchant_email_endpoint.php';
    function activate(id) {
        $('#ConfirmModal').modal('show');
        $('#confirm_action_title').text('Activate Merchant Email');
        $('#confirm_message').text(
            'Are you sure you want to activate this email as your ' +
            'merchant email? Confirming this action will make this email' +
            'to start receiving money from paypal'
        );
        $('#btn_action').on('click', function () {

            $.ajax(
                {
                    type: 'POST',
                    url: url,
                    data: {'option': 'activate', 'id': id},
                    dataType: 'json',
                    success: function (response) {
                        if(response.statusCode == 200) {
                            $('#confirm_feedback')
                                .removeClass('alert alert-danger')
                                .addClass('alert alert-success')
                                .text(response.message);
                            setTimeout(function () {
                                $('#ConfirmModal').modal('hide');
                                window.location.reload();
                            }, 1000)
                        }

                    },
                    error: function (error) {
                        console.log(error);
                    }
                }
            );
        })
    }


    function deactivate(id) {
        $('#ConfirmModal').modal('show');
        $('#confirm_action_title').text('Deactivate Merchant Email');
        $('#confirm_message').text(
            'Are you sure you want to deactivate this email' +
            ' Deactivating email will make this email to stop receiving money' +
            'from paypal');
        $('#btn_action').on('click', function () {
            $.ajax(
                {
                    type: 'POST',
                    url: url,
                    data: {'option': 'deactivate', 'id': id},
                    dataType: 'json',
                    success: function (response) {
                        if(response.statusCode == 200) {
                            $('#confirm_feedback')
                                .removeClass('alert alert-danger')
                                .addClass('alert alert-success')
                                .text(response.message);
                            setTimeout(function () {
                                $('#ConfirmModal').modal('hide');
                                window.location.reload();
                            }, 1000)
                        }

                    },
                    error: function (error) {
                        console.log(error);
                    }
                }
            );
        })
    }





    function deleteEmail(id) {
        $('#ConfirmModal').modal('show');
        $('#confirm_action_title').text('Delete Merchant Email');
        $('#confirm_message').text("Are you sure you want to" +
            "delete this email. This will permanently remove the " +
            "email from PremierPesa.");
        $('#btn_action').on('click', function () {

            $.ajax(
                {
                    type: 'POST',
                    url: url,
                    data: {'option': 'delete', 'id': id},
                    dataType: 'json',
                    success: function (response) {
                        if(response.statusCode == 200) {
                            $('#confirm_feedback')
                                .removeClass('alert alert-danger')
                                .addClass('alert alert-success')
                                .text(response.message);
                            setTimeout(function () {
                                $('#ConfirmModal').modal('hide');
                                window.location.reload();
                            }, 1000)
                        }

                    },
                    error: function (error) {
                        console.log(error);
                    }
                }
            );
        })
    }

function editEmail(id, email, phone_number) {

    $('#MerchantModal').modal('show');
    $('#email').val(email);
    $('#phone_number').val(phone_number);

    $('#btn_save').on('click', function () {

        var editedEmail = $('#email').val();
        var phoneNumber = $('#phone_number').val();

        $.ajax(
            {
                type: 'POST',
                url: url,
                data: {'option': 'update', 'email': editedEmail, 'phone_number':phoneNumber, 'id':id },
                dataType: 'json',
                success: function (response) {
                    if(response.statusCode == 200) {
                        $('#feedback')
                            .removeClass('alert alert-danger')
                            .addClass('alert alert-success')
                            .text(response.message);
                        setTimeout(function () {
                            $('#MerchantModal').modal('hide');
                            window.location.reload();
                        }, 1000)
                    }
                    else{
                        console.log(response);
                    }

                },
                error: function (error) {
                    console.log(error);
                }
            }
        )

    })

}

function createNewEmail() {
    $('#MerchantModal').modal('show');
    $('#merchant_modal_title').text('Add New Merchant Email');
    $('#btn_save').on('click', function () {

        var editedEmail = $('#email').val();
        var phoneNumber = $('#phone_number').val();

        $.ajax(
            {
                type: 'POST',
                url: url,
                data: {'option': 'create', 'email': editedEmail, 'phone_number':phoneNumber },
                dataType: 'json',
                success: function (response) {
                    if(response.statusCode == 200) {
                        $('#feedback')
                            .removeClass('alert alert-danger')
                            .addClass('alert alert-success')
                            .text(response.message);
                        setTimeout(function () {
                            $('#MerchantModal').modal('hide');
                            window.location.reload();
                        }, 1000)
                    }
                    else{
                        console.log(response);
                    }

                },
                error: function (error) {
                    console.log(error);
                }
            }
        )

    })
}

</script>

</body>
</html>

