<?php
/**
 * Created by PhpStorm.
 * User: New LAptop
 * Date: 16/03/2017
 * Time: 00:03
 */

include_once('views/send_email.php');
?>
<div class="container">
    <div class="row">
        <div class="col-sm-12">
            <div class="row">
                <div class="contact_contant sections">
                    <div class="col-sm-6">

                        <div class="main_contact_info">
                            <div class="head_title">
                                <h3>CONTACT INFO</h3>
                                <div class="separator"></div>
                            </div>
                            <div class="row">
                                <div class="contact_info_content">
                                    <div class="col-sm-12">
                                        <div class="single_contact_info">
                                            <div class="single_info_icon">
                                                <i class="fa fa-home"></i>
                                            </div>
                                            <div class="single_info_text">
                                                <h3>VISIT US</h3>
                                                <p>www.premierpesa.co.ke</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-12">
                                        <div class="single_contact_info">
                                            <div class="single_info_icon">
                                                <i class="fa fa-envelope-o"></i>
                                            </div>
                                            <div class="single_info_text">
                                                <h3>MAIL US</h3>
                                                <p>support@premierpesa.com</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-12">
                                        <div class="single_contact_info">
                                            <div class="single_info_icon">
                                                <i class="fa fa-mobile"></i>
                                            </div>
                                            <div class="single_info_text">
                                                <h3>CALL US</h3>
                                                <p>0723013549</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-12">
                                        <div class="single_contact_info">
                                            <div class="single_info_icon">
                                                <i class="fa fa-clock-o"></i>
                                            </div>
                                            <div class="single_info_text">
                                                <h3>WORK HOUR</h3>
                                                <p>Mon - Sun: 08 Am - 10 Pm</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-6">
                        <div class="head_title">
                            <h3>LEAVE MESSAGE</h3>
                            <div class="separator"></div>
                        </div>
                        <div class="single_contant_left">
                            <form method = "post"
                                  action = "<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>"  id="formid">
                                <!--<div class="col-lg-8 col-md-8 col-sm-10 col-lg-offset-2 col-md-offset-2 col-sm-offset-1">-->

                                <div class="row">
                                    <p><?php echo $message;?></p>
                                    <div class="col-sm-6">

                                        <div class="form-group">
                                            <input type="text" class="form-control" name="first_name" placeholder="First Name" required="">
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <input type="text" class="form-control" name="last_name" placeholder="Last Name" required="">
                                        </div>
                                    </div>
                                </div>


                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <input type="email" class="form-control" name="email" placeholder="Email" required="">
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <input type="text" class="form-control" name="subject" placeholder="Subject" required="">
                                        </div>
                                    </div>
                                </div>


                                <div class="form-group">
                                    <textarea class="form-control" name="message" rows="8" placeholder="Message"></textarea>
                                </div>

                                <div class="">
                                    <input type="submit" value="Submit" class="btn btn-primary">
                                </div>
                                <!--</div>-->
                            </form>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

