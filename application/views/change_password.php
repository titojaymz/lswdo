<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
if (!$this->session->userdata('user_id')){
  redirect('/users/login','location');


}
$uid = $this->session->userdata('user_id'); //uid
error_reporting(0);

?>
<!DOCTYPE html>
<div class="content">

  <!-- Start Page Header -->
  <div class="page-header">
    <h1 class="title">Change Password</h1>
    <ol class="breadcrumb">
    </ol>
    <!-- Start Page Header Right Div -->
    <div class="right">
      <div class="btn-group" role="group" aria-label="...">
        <a href="#" class="btn btn-light">Change Password</a>
      </div>
    </div>
    <!-- End Page Header Right Div -->

  </div>
  <!-- End Page Header -->

  <!-- //////////////////////////////////////////////////////////////////////////// -->
  <!-- START CONTAINER -->
  <div class="container-widget">


    <div class="row">


      <!-- Start General Stats -->
      <div class="col-md-12 col-lg-4">
        <div class="panel panel-widget" >

          <form method="post">
            <div class="form-area">

              <div class="group"><?php echo validation_errors(); ?><?php echo $form_message; ?><br>
                <span class="label label-primary">Old Password:</span><br>
                <input type="text" name="oldpassword"  maxlength="30" class="form-control" placeholder="Old Password" required>
              </div><br>

              <div class="group">
                <span class="label label-success">Enter New Password:</span><br>
                <input type="hidden" name="id" value="<?php echo $uid; ?>" />
                <input type="password" name="password" maxlength="30" class="form-control" placeholder="Password" required>
              </div>
              <div class="group">
                <span class="label label-default">Confirm New Password:</span><br>
                <input type="password" name="password2" maxlength="30" class="form-control" placeholder="Password" required>
              </div>  <br>

              <button type="submit" name="submit" value="submit" class="btn btn-sm btn-primary"> Save</button>
            </div>
          </form>
        </div>
      </div>
    </div>


  </div>




  <!-- Michael comment for github testing -->