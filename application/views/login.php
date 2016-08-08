<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
error_reporting(0);
$region = $this->session->userdata('lswdo_regioncode');

if (!$this->session->userdata('user_id')){
    echo validation_errors();

    ?><br><br>
    <div class="login-form">
        <form class="form-signin" method="post" action="">
            <div class="top">
                <h1>LSWDOFIRST</h1>
                <h4>Sign-In</h4>
            </div>
            <div class="form-area"><?php echo $form_message; ?>
                <div class="group">
                    <input type="text" id="username" maxlength="30" value="<?php echo htmlspecialchars($_POST['username']); ?>" name="username" class="form-control" placeholder="Username" required autofocus>
                    <i class="fa fa-user"></i>
                </div>
                <div class="group">
                    <input type="password" maxlength="30" name="password" value="" class="form-control" placeholder="Password" required>
                    <i class="fa fa-key"></i>
                </div>
              <!--  <div class="g-recaptcha" data-sitekey="6LcMzRwTAAAAADzg5oggwcUaZGdPWZ4keM-bP7Fn"></div>-->
                <button type="submit" type="submit" class="btn btn-default btn-block">LOGIN</button>
            </div>
        </form>
        <div class="footer-links row">
            <div class="col-xs-6"><a href="<?php echo base_url('users/register') ?>"><i class="fa fa-external-link"></i> Register Now</a></div> <!--edited link! -->
            <div class="col-xs-6 text-right"><a href="<?php echo base_url('users/forgot_password') ?>"><i class="fa fa-lock"></i> Forgot password</a></div>
        </div>
    </div>
<?php } else { ?>
    <?php redirect('/dashboardc/dashboard/','location'); ?>
<?php } ?>