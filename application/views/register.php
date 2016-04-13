<?php
/**
 * Created by JOSEF FRIEDRICH S. BALDO
 * Date Time: 10/17/15 11:16 PM
 */
error_reporting(0);
?><script type="text/javascript">

    /* client-side validation test
     function submit_rpmb() {
     var brgy = $('#brgylist').val();

     if(brgy > 0) {
     $('#rpmb_form').submit();
     } else {
     alert("Please select barangay");
     }
     } */


</script>
<div class="login-form">
    <form method="post">
        <div class="top">
            <h1>Register</h1>
        </div>

        <div class="form-area"><?php echo $form_message;?><?php echo validation_errors() ?>
            <div class="group">
                <input type="text" class="form-control"  maxlength="30"  value="<?php echo htmlspecialchars($_POST['username']); ?>" placeholder="Username" name="username" required>
                <i class="fa fa-user-secret"></i>
            </div>
            <div class="group">
                <input type="password" class="form-control" placeholder="Password" name="password"  maxlength="30"   required>
                <i class="fa fa-key"></i>
            </div>
            <div class="group">
                <input type="password" class="form-control" placeholder="Confirm Password" name="password2" required>
                <i class="fa fa-key"></i>
            </div>
            <div class="group">
                <input type="text" class="form-control" placeholder="First Name" name="firstname"  value="<?php echo htmlspecialchars($_POST['firstname']); ?>" required>
                <i class="fa fa-user"></i>
            </div>
            <div class="group">
                <input type="text" class="form-control" placeholder="Middle Name" name="middlename" value="<?php echo htmlspecialchars($_POST['middlename']); ?>" required>
                <i class="fa fa-user"></i>
            </div>
            <div class="group">
                <input type="text" class="form-control" placeholder="Sur Name" name="surname" value="<?php echo htmlspecialchars($_POST['surname']); ?>" required>
                <i class="fa fa-user"></i>
            </div>
            <div class="group">
                <input type="text" class="form-control" placeholder="Extension Name" name="extensionname" value="<?php echo htmlspecialchars($_POST['extensionname']); ?>">
                <i class="fa fa-user"></i>
            </div>
            <div class="group">
                <input type="email" class="form-control" placeholder="E-mail" name="email" value="<?php echo htmlspecialchars($_POST['email']); ?>" required>
                <i class="fa fa-envelope-o"></i>
            </div>

            <div class="group">
                <select name="regionlist" id="regionlist" class="form-control" onchange="get_prov();">
                    <option value="0">Choose Region</option>
                    <?php foreach($rpmb['regionlist'] as $regionselect): ?>
                        <option value="<?php echo $regionselect->region_code; ?>"
                            <?php if(isset($_SESSION['region'])) {
                                if($regionselect->region_code == $_SESSION['region']) {
                                    echo " selected";
                                }
                            } ?>
                        >
                            <?php echo $regionselect->region_name; ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="group">
                <div class="g-recaptcha" data-sitekey="6LcMzRwTAAAAADzg5oggwcUaZGdPWZ4keM-bP7Fn"></div>
            </div>
            <button type="submit" class="btn btn-default btn-block">REGISTER</button>
        </div>
    </form>
    <div class="footer-links row">
        <div class="col-xs-6"><a href="<?php echo base_url('users/login') ?>"><i class="fa fa-sign-in"></i> Login</a></div>
        <div class="col-xs-6 text-right"><a href="#"><i class="fa fa-lock"></i> Forgot password</a></div>
    </div>
</div>

