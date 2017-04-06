<?php
/**
 * Created by PhpStorm.
 * User: New LAptop
 * Date: 16/03/2017
 * Time: 00:04
 */


?>

<section id="footer" class="footer_widget">
    <div class="video_overlay">
        <div class="container">
            <div class="row">
                <div class="col-sm-12">
                    <div class="row">
                        <div class="main_widget">
                            <div class="col-sm-3 col-xs-12">
                                <div class="single_widget wow fadeIn" data-wow-duration="800ms">
                                    <div class="footer_logo">
                                        <img src="public/assets/images/logo.png" alt="" />
                                    </div>
                                    <p>Primierpesa are provides of money transaction services that include transfering money from paypal to mpesa and also tran
                                    transfering money from Mpesa to your Paypal account.
                                    </p>

                                </div>
                            </div>

                            <div class="col-sm-3  col-xs-12">
                                <div class="single_widget wow fadeIn" data-wow-duration="800ms">

                                    <div class="footer_title">
                                        <h4>SITEMAP</h4>
                                        <div class="separator"></div>
                                    </div>
                                    <ul>
                                        <li><a href="#home">Home</a></li>
                                        <li><a href="#service">Services</a></li>
                                        <li><a href="#rates">Rates</a></li>
                                        <li><a href="#about">About</a></li>
                                        <li><a href="#testimonial">Testimonials</a></li>
                                        <li><a href="#signup">Join</a></li>
                                        <li><a href="#contact">Contact</a></li>

                                    </ul>
                                </div>
                            </div>

                            <div class="col-sm-3  col-xs-12">
                                <div class="single_widget wow fadeIn" data-wow-duration="800ms">

                                    <div class="footer_title">
                                        <h4>Services</h4>
                                        <div class="separator"></div>
                                    </div>
                                    <ul>
                                        <li><a href="views/convert.php">Paypal to Mpesa</a></li>
                                        <li><a href="#">Mpesa to Paypal</a></li>
                                    </ul>
                                </div>
                            </div>

                            <div class="col-sm-3 col-xs-12">
                                <div class="single_widget wow fadeIn" data-wow-duration="800ms">

                                    <div class="footer_title">
                                        <h4>Updates and offers</h4>
                                        <div class="separator"></div>
                                    </div>

                                    <div class="footer_subcribs_area">
                                        <?php include_once('views/subscribe.php');?>
                                        <p>Sign up for our mailing list to get latest updates and offers.</p>
                                        <p><?php echo $message; ?></p>
                                        <form class="navbar-form navbar-left" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"])."#footers"?>" method="POST">
                                            <div class="form-group">
                                                <input type="text" class="form-control" placeholder="Name" name="name">
                                                <input type="email" class="form-control" placeholder="Email" name="email" style="margin-top: 5px;" required>
                                                <input type="submit" value="Subscribe" class="btn btn-primary" style="background-color:#0099e5;border-color:#0099e5;margin-top: 10px;">
                                            </div>

                                        </form>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</section>


<section class="footer">
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <div class="main_footer">
                    <div class="row">

                        <div class="col-sm-6 col-xs-12">
                            <div class="copyright_text">
                                <p class=" wow fadeInRight" data-wow-duration="1s">Made with <i class="fa fa-heart"></i> by <a href="http://hudutech.com">Hudutech Solutions</a><?php echo date("Y");?> All Rights Reserved</p>
                            </div>
                        </div>

                        <div class="col-sm-6 col-xs-12">
                            <div class="flowus">
                                <a href="#"><i class="fa fa-facebook"></i></a>
                                <a href="#"><i class="fa fa-twitter"></i></a>
                                <a href="#"><i class="fa fa-google-plus"></i></a>

<!--                            </div>-->
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-96280789-1', 'auto');
  ga('send', 'pageview');

</script>