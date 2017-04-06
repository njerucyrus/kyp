<?php
/**
 * Created by PhpStorm.
 * User: New LAptop
 * Date: 22/03/2017
 * Time: 19:29
 */

require_once __DIR__ . '/../models/class.rate.php';
require_once __DIR__ . '/../models/class.limits.php';
require_once __DIR__ . '/../models/user.php';


?>

<div class="video_overlay">
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <div class="main_counter_area text-center">
                    <?php
                    $limit = Limit::getCurrentExchangeRate();
                    if (is_array($limit)) {

                        $exchange = $limit['exchange_rate'];

                    } ?>

                    <?php
                    $usercount=0;
                    $users = User::all();
                    if (!is_null($users)) {
                    while ($user = $users->fetch(PDO::FETCH_ASSOC)) {
                    $usercount=$usercount+1;
                    }
                    $finalcount=$usercount;
                    }
                    ?>

                    <div class="row">
                        <div class="single_counter border_right">
                            <div class="col-sm-3 col-xs-12">
                                <div class="single_counter_item">
                                    <h2 class="statistic-counter">

            <?php
            if($finalcount<=200)
            {
                echo 687;
            }
            else {
                echo $finalcount;
            }?>


                                    </h2>
                                    <i  class="fa fa-smile-o" aria-hidden="true"></i>
                                    <p class="margin-top-20">HAPPY CLIENTS</p>
                                </div>
                            </div>
                        </div>

                        <div class="single_counter">
                            <div class="col-sm-3 col-xs-12">
                                <div class="single_counter_item">
                                    <h2 class="statistic-counter"><?php echo  $exchange;?></h2>
                                    <i class="fa fa-usd" aria-hidden="true"></i>
                                    <p class="margin-top-20">EXCHANGE RATE</p>
                                </div>

                            </div>
                        </div>

                        <div class="single_counter">
                            <?php
                            $min_max = Limit::getLimits();
                            if (!empty($min_max)){
                            ?>

                            <div class="col-sm-3 col-xs-12">
                                <div class="single_counter_item">
                                    <h2 class="statistic-counter"><?php echo $min_max['min'] ?></h2>
                                    <i class="fa fa-window-minimize" aria-hidden="true"></i>
                                    <p class="margin-top-20">Minimum Limit</p>
                                </div>

                            </div>
                        </div>

                        <div class="single_counter">
                            <div class="col-sm-3 col-xs-12">
                                <div class="single_counter_item">
                                    <h2 class="statistic-counter"><?php echo $min_max['max'] ?></h2>
                                    <i class="fa fa-window-maximize" aria-hidden="true"></i>
                                    <p class="margin-top-20">Maximum Limit</p>
                                </div>

                            </div>
                        </div>
                        <?php
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
