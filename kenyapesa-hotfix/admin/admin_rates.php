<?php
session_start();
if(!isset($_SESSION['admin_username'])){
    header('Location: admin_login.php');
}

/**
 * Created by PhpStorm.
 * User: hudutech
 * Date: 3/17/17
 * Time: 10:41 PM
 */
require_once __DIR__ . '/../models/class.rate.php';
require_once __DIR__ . '/../models/class.limits.php';


?>
<!DOCTYPE html>
<html>
<head>
    <?php include('css.php') ?>
</head>
<body>
<div class="navbar navbar-inverse">
    <?php include "navbar.php"; ?>
</div>
<div class="container container-fluid">
    <div class="row">
        <div class="col col-md-8 col-md-offset-2">
            <div class="table-responsive">
                <p style="font-size: 1.2em; color:#ff7200">Limits</p>
                <table class="table">
                    <thead>
                    <tr>
                        <td>Minimum Dollar Limit</td>
                        <td>Maximum Dollar Limit</td>
                        <td>Dollar Exchange Rate</td>
                    </tr>
                    </thead>
                    <tbody>
                    <?php

                    $limits = Limit::all();
                    if (!is_null($limits)) {
                        while ($limit = $limits->fetch(PDO::FETCH_ASSOC)) {
                            ?>
                            <tr>
                                <td><?php echo $limit['min_limit'] ?> $</td>
                                <td><?php echo $limit['max_limit'] ?> $</td>
                                <td style="font-weight: bold;">1 $ @ KSH <?php echo $limit['exchange_rate'] ?></td>
                                <td>
                                    <button class="btn btn-xs btn-primary"
                                            onclick="updateLimits(
                                                    '<?php echo $limit['id'];?>',
                                                    '<?php echo $limit['min_limit'];?>',
                                                    '<?php echo $limit['max_limit'];?>',
                                                    '<?php echo $limit['exchange_rate'];?>')">Edit
                                    </button>
                                </td>

                            </tr>
                            <?php
                        }
                    }
                    else{
                        ?>
                        <button class="btn btn-warning pull-right" style="margin-right: 25px;" onclick="createNewLimit()">
                            Set Limits & Dollar Exchange Rate
                        </button>
                        <?php
                    }

                    ?>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="col col-md-8 col-md-offset-2">

            <div class="table-responsive" style="margin-top: 10px;">
                <div class="col-md-12" style="margin-bottom: 10px;">
                    <p style="font-size: 1.2em; color:#ff7200;">Charges Rate</p>
                    <button class="btn btn-warning pull-right" onclick="showCreateModal()">Add New Rate</button>
                </div>
                <table class="table">
                    <thead>
                    <tr class="bg-primary">
                        <td>From</td>
                        <td>To</td>
                        <td>Fixed Dollar Charges</td>
                        <td>Rate Charges(%)</td>
                        <td>Action</td>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    $rates = Rate::all();
                    if (!is_null($rates)) {
                        while ($rate = $rates->fetch(PDO::FETCH_ASSOC)) {
                            ?>
                            <tr>
                                <td><?php echo $rate['min_value'] ?> $</td>
                                <td><?php echo $rate['max_value'] ?> $</td>
                                <td><?php echo $rate['fixed_dollar'] ?> $</td>
                                <td><?php echo $rate['percentage'] ?> %</td>
                                <td colspan="2"><a href="#" class="btn btn-xs btn-primary"
                                                   onclick="showEditRatesModal(
                                                           '<?php echo $rate['id'] ?>',
                                                           '<?php echo $rate['min_value'] ?>',
                                                           '<?php echo $rate['max_value'] ?>',
                                                           '<?php echo $rate['fixed_dollar'] ?>',
                                                           '<?php echo $rate['percentage'] ?>'
                                                           )">
                                        Edit
                                    </a>
                                    <a href="#" class="btn btn-xs btn-danger"
                                       onclick="confirmDeleteRate('<?php echo $rate['id'] ?>')">Delete</a></td>
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

<!--Rates Modal -->

<div id="RatesModal" class="modal fade" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title"><h6 id="charges_rates_title"></h6></h4>
            </div>
            <div class="modal-body">
                <div id="rates_feedback"></div>
                <form>
                    <div class="form-group">

                        <label for="from_dollar_edit">From($)</label>
                        <input type="number" class="form-control" id="from_dollar_edit">
                    </div>

                    <div class="form-group">

                        <label for="to_dollar_edit">To($)</label>
                        <input type="number" class="form-control" id="to_dollar_edit">
                    </div>

                    <div class="form-group">
                        <label for="fixed_dollar_edit">Fixed($)</label>
                        <input type="number" class="form-control" id="fixed_dollar_edit">
                    </div>

                    <div class="form-group">
                        <label for="percentage_edit">Percentage Rate (%)</label>
                        <input type="number" class="form-control" id="percentage_edit">
                        <input type="hidden" id="rate_id">
                        <input type="hidden" id="option">
                    </div>

                </form>
            </div>
            <div class="modal-footer">
                <button id='btn_charges' type="button" class="btn btn-danger">

                </button>
                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
            </div>
        </div>

    </div>
</div>

<!--end of --rates modal-->

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
                <button id="btn_delete" type="button" class="btn btn-danger">
                    Confirm Delete
                </button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
            </div>
        </div>

    </div>
</div>

<!--Edit Limits -->

<!--Limits Modal-->
<div id="LimitsModal" class="modal fade" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Edit Limits & Exchange Rate</h4>
            </div>
            <div class="modal-body">
                <div id="limit_feedback"></div>
                <form>
                    <div class="form-group">
                        <label for="min_limit">Minimum Dollar Limit</label>
                        <input type="number" class="form-control" id="min_limit" required>
                    </div>

                    <div class="form-group">
                        <label for="max_limit">Maximum Dollar Limit</label>
                        <input type="number" class="form-control" id="max_limit" required>
                    </div>

                    <div class="form-group">
                        <label for="exchange_rate">Dollar Exchange rate</label>
                        <input type="number" class="form-control" id="exchange_rate" required>
                    </div>

                </form>
            </div>
            <div class="modal-footer">
                <button id="btn-save" type="button" class="btn btn-primary">
                    Save Changes
                </button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
            </div>
        </div>

    </div>
</div>


<?php include 'js.php'; ?>

<script>
    $(document).ready(function (e) {
        e.preventDefault;
        $('#btn_charges').on('click', function () {
            var option = $('#option').val();
            if (option == 'addNew') {
                saveNewRate();
            }
            else if (option == 'update') {
                editChargesRate();
            }

        })
    })
</script>


<script>

    var url = "manage_rates_endpoint.php";

    function showCreateModal() {
        $('#RatesModal').modal('show');
        $('#option').val('addNew');
        $('#btn_charges')
            .removeClass('btn btn-danger')
            .addClass('btn btn-primary')
            .text('Add new');
        $('#charges_rates_title').text('Add New Rate');

    }

    function showEditRatesModal(id, min, max, fixed, percentage) {
        console.log("id:" + id, min, max, fixed, percentage);
        $('#RatesModal').modal('show');
        $('#option').val('update');
        $('#rate_id').val(id);
        $('#from_dollar_edit').val(min);
        $('#to_dollar_edit').val(max);
        $('#fixed_dollar_edit').val(fixed);
        $('#percentage_edit').val(percentage);
        $('#btn_charges')
            .removeClass('btn btn-danger')
            .addClass('btn btn-success')
            .text('Save Changes');
        $('#charges_rates_title').text('Update Charges Rates');

    }


    function saveNewRate() {

        var min = $('#from_dollar_edit').val();
        var max = $('#to_dollar_edit').val();
        var fixed = $('#fixed_dollar_edit').val();
        var percentage = $('#percentage_edit').val();
        var rate_id = $('#rate_id').val();

        $.ajax(
            {
                type: 'POST',
                url: url,
                data: {
                    'option': 'create_rates',
                    'min': min,
                    'max': max,
                    'fixed': fixed,
                    'percentage': percentage
                },
                dataType: 'json',
                success: function (response) {

                    console.log(response);

                    if (response.statusCode == 200) {
                        $('#rates_feedback')
                            .removeClass('alert alert-danger')
                            .addClass('alert alert-success')
                            .text(response.message);
                        setTimeout(function () {
                            $('#RatesModal').modal('hide');
                            window.location.reload()

                        }, 1000)
                    }
                    else if (response.statusCode == 500) {
                        $('#rates_feedback')
                            .removeClass('alert alert-success')
                            .addClass('alert alert-danger')
                            .text("Error failed add new rate try again later");
                        setTimeout(function () {
                            $('#RatesModal').modal('hide');
                            window.location.reload()

                        }, 1000);
                    }

                },
                error:function (error) {
                    console.log(error);
                }
            }
        )

    }
    function editChargesRate() {

        var min = $('#from_dollar_edit').val();
        var max = $('#to_dollar_edit').val();
        var fixed = $('#fixed_dollar_edit').val();
        var percentage = $('#percentage_edit').val();
        var rate_id = $('#rate_id').val();

        $.ajax(
            {
                type: 'POST',
                url: url,
                data: {
                    'option': 'update_rates',
                    'id': rate_id,
                    'min': min,
                    'max': max,
                    'fixed': fixed,
                    'percentage': percentage
                },
                dataType: 'json',
                success: function (response) {

                    console.log(response);

                    if (response.statusCode == 200) {
                        $('#rates_feedback')
                            .removeClass('alert alert-danger')
                            .addClass('alert alert-success')
                            .text(response.message);
                        setTimeout(function () {
                            $('#RatesModal').modal('hide');
                            window.location.reload()

                        }, 1000)
                    }
                    else if (response.statusCode == 500) {
                        $('#rates_feedback')
                            .removeClass('alert alert-success')
                            .addClass('alert alert-danger')
                            .text("Update failed try again later");
                        setTimeout(function () {
                            $('#RatesModal').modal('hide');
                            window.location.reload()

                        }, 1000);
                    }

                },
                error:function (error) {
                    console.log(error);
                }
            }
        )
    }

    function confirmDeleteRate(id) {
        $('#ConfirmModal').modal('show');
        $('#confirm_action_title').text("DELETE RATE");

        $('#confirm_message').text("Are you sure you want to delete this rate" +
            "\n Deleting the rate will make the rate not to apply in user transactions " +
            "click confirm delete button to continue or cancel to cancel this operation"
        );
        $('#delete_rate_id').val(id);

        $('#btn_delete').on('click', function () {
            $.ajax(
                {
                    type: 'POST',
                    url: url,
                    data: {'option': 'delete_rates', 'id': id},
                    dataType: 'json',
                    success: function (response) {
                        console.log(response);
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
                                .text("Error occurred rate not deleted try again later");
                            setTimeout(function () {
                                $('#ConfirmModal').modal('hide');
                                window.location.reload()

                            }, 1000);
                        }

                    },
                    error:function (error) {
                        console.log(error);
                    }
                }
            )
        })
    }

    function getLimitModalData() {
        return {

            min_limit: $('#min_limit').val(),
            max_limit: $('#max_limit').val(),
            exchange_rate: $('#exchange_rate').val()
        };

    }
    function updateLimits(id, min, max, exchangeRate) {
        $('#LimitsModal').modal('show');
        $('#min_limit').val(min);
        $('#max_limit').val(max);
        $('#exchange_rate').val(exchangeRate);


        $('#btn-save').on('click', function () {
            var data = getLimitModalData();
            data['id'] = id;
            data['option'] = 'update_limits';

            $.ajax(
            {
                type: 'POST',
                url: url,
                data: data,
                dataType: 'json',
                success: function (response) {
                    console.log(response);
                    if (response.statusCode == 200) {
                        $('#limit_feedback')
                            .removeClass('alert alert-danger')
                            .addClass('alert alert-success')
                            .text(response.message);
                        setTimeout(function () {
                            $('#LimitsModal').modal('hide');
                            window.location.reload()

                        }, 1000)
                    }
                    else if (response.statusCode == 500) {
                        $('#limit_feedback')
                            .removeClass('alert alert-success')
                            .addClass('alert alert-danger')
                            .text("Error occurred rate not updated");
                        setTimeout(function () {
                            $('#LimitsModal').modal('hide');
                            window.location.reload()

                        }, 1000);
                    }

                },
                error: function (error) {
                    console.log(error)
                }

            }
        );
        })
    }


    function createNewLimit() {
        $('#LimitsModal').modal('show');


        $('#btn-save').on('click', function () {
            var data = getLimitModalData();
            data['option'] = 'create_limit';
            console.log("data create", data);
        $.ajax(
            {
                type: 'POST',
                url: url,
                data: data,
                dataType: 'json',
                success: function (response) {
                    console.log(response);
                    if (response.statusCode == 200) {
                        $('#limit_feedback')
                            .removeClass('alert alert-danger')
                            .addClass('alert alert-success')
                            .text(response.message);
                        setTimeout(function () {
                            $('#LimitsModal').modal('hide');
                            window.location.reload()

                        }, 1000)
                    }
                    else if (response.statusCode == 500) {
                        $('#limit_feedback')
                            .removeClass('alert alert-success')
                            .addClass('alert alert-danger')
                            .text("Error occurred rate not updated");
                        setTimeout(function () {
                            $('#LimitsModal').modal('hide');
                            window.location.reload()

                        }, 1000);
                    }

                },
                error: function (error) {
                    console.log(error)
                }

            }
        )
        });
    }



</script>

</body>
</html>
