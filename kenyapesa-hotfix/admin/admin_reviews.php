<?php
session_start();

if(!isset($_SESSION['admin_username'])){
    header('Location: admin_login.php');
}

/**
 * Created by PhpStorm.
 * User: hudutech
 * Date: 3/20/17
 * Time: 9:43 AM
 */
require_once __DIR__ . '/../models/class.feedback.php';
require_once __DIR__ . '/../models/user.php';


?>
<!DOCTYPE html>
<html>
<head>
    <?php include 'css.php'; ?>
</head>
<body>
<div class="navbar navbar-inverse">
    <?php include 'navbar.php' ?>
</div>
<div class="container container-fluid">
    <div class="row">
        <div class="col col-md-10 col-md-offset-1">
            <div class="table table-responsive">
                <table class="table" id="reviews-table">
                    <thead>
                    <tr>
                        <th>Fullname | paypal email</th>
                        <th>Review Text</th>
                        <th>Review Status</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    $reviews = UserFeedback::all();
                    if (!is_null($reviews)) {
                        while ($review = $reviews->fetch(PDO::FETCH_ASSOC)) {
                            $userObject = User::getId($review['user_id']);
                            $full_name = 'anonymous';
                            if (!is_null($userObject)) {
                                $user = $userObject->fetch(PDO::FETCH_ASSOC);
                                $full_name = $user['first_name'] . " " . $user['last_name'] . "@" . $user['paypal_email'];
                            }
                            ?>
                            <tr>
                                <td><?php echo $full_name; ?></td>
                                <td><?php echo $review['text']; ?></td>
                                <td>
                                    <?php
                                    if ($review['approved'] == 0) {
                                        echo '<p style="color: rgba(235,69,3,0.91); font-weight: bold;">waiting approval</p>';
                                    } else if ($review['approved'] == 1) {
                                        echo '<p style="color: green; font-weight: bold;">approved &nbsp;<i class="fa fa-check-circle-o" aria-hidden="true"></i></p>';
                                    }
                                    ?>
                                </td>
                                <td colspan="2">

                                    <?php
                                    if ($review['approved'] == 0) {
                                        ?>
                                        <button onclick="approveReview('<?php echo $review['id'] ?>')"
                                                class="btn btn-xs btn-primary"><i class="fa fa-check-square-o"
                                                                                  aria-hidden="true"
                                                                                  style="font-size: 1.2em"></i>&nbsp;Approve
                                        </button>
                                        <button onclick="deleteReview('<?php echo $review['id'] ?>')"
                                                class="btn btn-xs btn-danger"><i class="fa fa-trash" aria-hidden="true"
                                                                                 style="font-size: 1.2em"></i>&nbsp;Delete
                                        </button>
                                        <?php
                                    } else {
                                        ?>
                                        <button onclick="deleteReview('<?php echo $review['id'] ?>')"
                                                class="btn btn-xs btn-danger"><i class="fa fa-trash" aria-hidden="true"
                                                                                 style="font-size: 1.2em"></i>&nbsp;Delete
                                        </button>
                                        <?php
                                    }
                                    ?>


                                </td>
                            </tr>
                            <?php
                        }
                    }else if(is_null($reviews)){
                        ?>
                        <div class="alert alert-info">No reviews made yet!</div>
                    <?php
                    }
                    ?>

                    </tbody>

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


<?php include 'js.php' ?>


<script>
    $(document).ready(function (e) {
        e.preventDefault;

        var prefix = 'paginate';
        $('#reviews-table').paginate({
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
    var url = 'manage_reviews_endpoint.php';
    function approveReview(id) {
        $('#ConfirmModal').modal('show');
        $('#confirm_action_title').text('Approve Review');
        $('#confirm_message').text(
            'Are you sure you want to approve this review. Approving this review' +
            'will make it visible to every user who visits you site. Confirm by clicking' +
            'Submit button Or Cancel to cancel the action'
        );

        $('#btn_action').on('click', function () {

            $.ajax(
                {
                    type: 'POST',
                    url: url,
                    data: {'id': id, 'option': 'approve_review'},
                    dataType: 'json',
                    success: function (response) {
                        if (response.statusCode == 200) {

                            $('#confirm_feedback')
                                .removeClass('alert alert-danger')
                                .addClass('alert alert-success')
                                .text(response.message);

                            setTimeout(function () {
                                $('#ConfirmModal').modal('hide');
                                window.location.reload();
                            }, 1000);

                        }
                        else if (response.statusCode == 500) {
                            $('#confirm_feedback')
                                .removeClass('alert alert-success')
                                .addClass('alert alert-danger')
                                .text(response.message);

                            setTimeout(function () {
                                $('#ConfirmModal').modal('hide');
                                window.location.reload();
                            }, 1000);
                        }
                    },
                    error: function (error) {
                        console.log(error);
                    }
                })
        })
    }

    function deleteReview(id) {
        $('#ConfirmModal').modal('show');
        $('#confirm_action_title').text('Delete Review');
        $('#confirm_message').text(
            'Are you sure you want to delete this review.\n' +
            'Deleting review will permanently remove the review from ' +
            'the website.'
        );

        $('#btn_action').on('click', function () {

            $.ajax(
                {
                    type: 'POST',
                    url: url,
                    data: {'id': id, 'option': 'delete_review'},
                    dataType: 'json',
                    success: function (response) {
                        if (response.statusCode == 200) {

                            $('#confirm_feedback')
                                .removeClass('alert alert-danger')
                                .addClass('alert alert-success')
                                .text(response.message);

                            setTimeout(function () {
                                $('#ConfirmModal').modal('hide');
                                window.location.reload();
                            }, 1000);

                        }
                        else if (response.statusCode == 500) {
                            $('#confirm_feedback')
                                .removeClass('alert alert-success')
                                .addClass('alert alert-danger')
                                .text(response.message);

                            setTimeout(function () {
                                $('#ConfirmModal').modal('hide');
                                window.location.reload();
                            }, 1000);
                        }
                    },
                    error: function (error) {
                        console.log(error);
                    }
                })
        })
    }
</script>

</body>
</html>
