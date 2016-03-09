<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Created by JOSEF FRIEDRICH S. BALDO
 * Date Time: 10/18/15 12:57 AM
 */
if (!$this->session->userdata('user_data')){
    redirect('/users/login','location');
}
echo validation_errors();
echo $form_message;
?>
<div class="modal-body">
    <div class="container">
        <div class="row">
            <div class="col-lg-6 col-sm-6 "> <!--edited form -->
                <h1>Add Assessment of Functionality </h1>
<div class="col-md-3"></div>
<div class="col-md-6">
    <form method="post" class="form-horizontal">
        <div class="form-group">
            <label for="profile_id">profile_id:</label>
            <span class="h4"><?php echo $assessmentinfo_details->profile_id ?></span>
            <input class="form-control" type="hidden" name="profile_id" value="<?php echo $assessmentinfo_details->profile_id ?>">
        </div>
        <div class="form-group">
            <label for="application_type_id">application_type_id</label>
            <input class="form-control" type="text" name="application_type_id" value="<?php echo $assessmentinfo_details->application_type_id ?>" placeholder="application_type_id">
        </div>
        <div class="btn-group">
            <button class="btn btn-success" type="submit" name="submit" value="submit"><i class="fa fa-save"></i> Save</button>
            <a class="btn btn-warning btn-group" href="/lswdo/assessmentinfo/index.html"><i class="fa fa-refresh"></i> Cancel</a>
        </div>
    </form>
</div>
<div class="col-md-3"></div>