<?php
/**
 * Created by JOSEF FRIEDRICH S. BALDO
 * Date Time: 10/17/15 11:16 PM
 */
echo validation_errors();
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
        <?php echo $form_message;?>
        <div class="form-area">
            <div class="group">
                <input type="text" class="form-control" placeholder="Username" name="username" required>
                <i class="fa fa-user-secret"></i>
            </div>
            <div class="group">
                <input type="password" class="form-control" placeholder="Password" name="password" required>
                <i class="fa fa-key"></i>
            </div>
            <div class="group">
                <input type="text" class="form-control" placeholder="First Name" name="firstname" required autofocus>
                <i class="fa fa-user"></i>
            </div>
            <div class="group">
                <input type="text" class="form-control" placeholder="Middle Name" name="middlename" required autofocus>
                <i class="fa fa-user"></i>
            </div>
            <div class="group">
                <input type="text" class="form-control" placeholder="Sur Name" name="surname" required autofocus>
                <i class="fa fa-user"></i>
            </div>
            <div class="group">
                <input type="text" class="form-control" placeholder="Extension Name" name="extensionname">
                <i class="fa fa-user"></i>
            </div>
            <div class="group">
                <input type="email" class="form-control" placeholder="E-mail" name="email" required>
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
            <button type="submit" class="btn btn-default btn-block">REGISTER</button>
        </div>
    </form>
    <div class="footer-links row">
        <div class="col-xs-6"><a href="<?php echo base_url('users/login') ?>"><i class="fa fa-sign-in"></i> Login</a></div>
        <div class="col-xs-6 text-right"><a href="#"><i class="fa fa-lock"></i> Forgot password</a></div>
    </div>
</div>

