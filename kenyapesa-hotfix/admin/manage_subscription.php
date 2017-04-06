<?php
session_start();
if (!isset($_SESSION['admin_username'])){
    header("Location: admin_login.php");
}
/**
 * Created by PhpStorm.
 * User: New LAptop
 * Date: 19/03/2017
 * Time: 19:06
 */
require_once __DIR__ . '/../models/class.subscription.php';



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

<!--->

<!--tapped pane-->

<ul class="nav nav-pills">
    <li class="active"><a data-toggle="pill" href="#home">Subsribers</a></li>

</ul>

<div class="tab-content">
    <div id="home" class="tab-pane fade in active">

        <div class="container container-fluid">
            <div class="row">
                <div class="col col-md-8 col-md-offset-2" style="margin-top: 100px; margin-bottom: 100px;">
                    <?php
                    $subscription = Subscription::getSubscriberMailingList();
                    if(is_array($subscription)){

                    }
                    ?>
                    <div class="table-responsive"  style="margin-top: 10px;" >

                        <table class="table table-responsive" id="subs-table">
                            <thead>
                            <tr style='font-size: 1.0em; text-align: center;' class="bg-primary">
                                <th>Name</th>
                                <th>Email</th>
                                <th>Actions</th>

                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            $counter=0;
                            $stmt = Subscription::all();
                            if(!is_null($stmt)) {
                                while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                    ?>

                                    <tr style='font-size: 1.0em; '>
                                        <td><?php echo $row['name']; ?></td>
                                        <td><?php echo $row['email']; ?> </td>
                                        <td>
                                            <button onclick="deleteModal('<?php echo $row['id']?>')" class="btn btn-xs btn-danger">Delete</button>
                                        </td>
                                    </tr>
                                    <?php
                                    $counter = $counter + 1;
                                }
                            }
                            ?>
                            </tbody>
                            <?php echo 'Total number of  subscribers is '.$counter;?>


                        </table>
                    </div>


                </div>
            </div>
        </div>

    </div>
    <div id="menu1" class="tab-pane fade">
        <h3>Menu 1</h3>
        <p>Some content in menu 1.</p>
    </div>
    <div id="menu2" class="tab-pane fade">
        <h3>Menu 2</h3>
        <p>Some content in menu 2.</p>
    </div>
</div>

<!--subscriber modal-->

<div id="ConfirmModal" class="modal fade" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title"><code>Delete Email From Mailing List</code></h4>
            </div>
            <div class="modal-body">
                <div id="feedback"></div>
                <div class="alert alert-info">
                    <p>
                        Are you sure you want to delete this email from your
                        mailing list?. Once you delete this subscriber will not
                        be able to get any of your subscription emails you send.
                    </p>

                </div>

            </div>
            <div class="modal-footer">
                <button id="btn_action_edit" type="button" class="btn btn-danger">
                    Delete
                </button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
            </div>
        </div>

    </div>
</div>






<?php include "js.php";?>


<script>
    $(document).ready(function (e) {
        e.preventDefault;

        var prefix = 'paginate';
        $('#subs-table').paginate({
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
    //setting endpoint url
    var url='manage_subscription_endpoint.php';

    function deleteModal(id) {
        //initialize form form inputs
        $('#ConfirmModal').modal('show');

        $('#btn_action_edit').on('click', function () {

          //submit data using ajax
            $.ajax(
                {
                    type: 'POST',
                    url :url,
                    data : {'id': id, 'option': 'delete'},
                    dataType : 'json',
                    success : function (response) {
                       if(response.statusCode==200)
                       {
                           $('#feedback')
                               .removeClass('alert alert-danger')
                               .addClass('alert alert-success')
                               .text(response.message);
                           setTimeout(function () {
                               $('#ConfirmModal').modal('hide');
                               window.location.reload();
                           }, 1000)
                       }

                    },
                    error : function (error) {
                        console.log(error);
                    }
                }
            )

        });




    }
</script>
</body>
</html>


