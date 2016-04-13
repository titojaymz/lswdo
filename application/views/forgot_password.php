<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
error_reporting(0);

?><br><br>
<div class="login-form">
    <form class="form-signin" method="post" action="">
        <div class="top">

            <h1>MSFLSWDO</h1>
            <h4>Forgot Password</h4>
        </div><?php echo $form_message; ?>
        <div class="form-area">
            <div class="group">
                <input type="email" id="email" name="email" class="form-control" placeholder="Email Address" required autofocus>
                <i class="fa fa-envelope-o"></i>
            </div>
            <div class="g-recaptcha" data-sitekey="6LcMzRwTAAAAADzg5oggwcUaZGdPWZ4keM-bP7Fn"></div>
            <button type="submit" type="submit" class="btn btn-default btn-block">Send</button>
        </div>
    </form>
    <div class="footer-links row">
        <div class="col-xs-6"><a href="<?php echo base_url('users/register') ?>"><i class="fa fa-external-link"></i> Register Now</a></div> <!--edited link! -->
        <div class="col-xs-6 text-right"><a href="<?php echo base_url('users/login') ?>"><i class="fa fa-mail-reply"></i> Back to Login</a></div>
    </div>
</div>