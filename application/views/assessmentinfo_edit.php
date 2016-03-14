<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Created by JOSEF FRIEDRICH S. BALDO
 * Date Time: 10/18/15 12:57 AM
 */
if (!$this->session->userdata('user_id')){
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
            <input class="form-control" type="text" name="application_type_id" value="<?php echo $assessmentinfo_details->application_type_id ?>" placeholder="application_type_id" readonly>
        </div>
        <div class="form-group">
            <label for="lgu_type_id">lgu_type_id</label>
            <input class="form-control" type="text" name="lgu_type_id" value="<?php echo $assessmentinfo_details->lgu_type_id ?>" placeholder="lgu_type_id">
        </div>
        <div class="form-group">
            <label for="region_code">region_code</label>
            <input class="form-control" type="text" name="region_code" value="<?php echo $assessmentinfo_details->region_code ?>" placeholder="region_code">
        </div>
        <div class="form-group">
            <label for="prov_code">prov_code</label>
            <input class="form-control" type="text" name="prov_code" value="<?php echo $assessmentinfo_details->prov_code ?>" placeholder="prov_code">
        </div>
        <div class="form-group">
            <label for="city_code">city_code</label>
            <input class="form-control" type="text" name="city_code" value="<?php echo $assessmentinfo_details->city_code ?>" placeholder="city_code">
        </div>
        <div class="form-group">
            <label for="brgy_code">brgy_code</label>
            <input class="form-control" type="text" name="brgy_code" value="<?php echo $assessmentinfo_details->brgy_code ?>" placeholder="brgy_code">
        </div>
        <div class="form-group">
            <label for="street_address">street_address</label>
            <input class="form-control" type="text" name="street_address" value="<?php echo $assessmentinfo_details->street_address ?>" placeholder="street_address">
        </div>
        <div class="form-group">
            <label for="swdo_name">swdo_name</label>
            <input class="form-control" type="text" name="swdo_name" value="<?php echo $assessmentinfo_details->swdo_name ?>" placeholder="swdo_name">
        </div>
        <div class="form-group">
            <label for="contact_no">contact_no</label>
            <input class="form-control" type="text" name="contact_no" value="<?php echo $assessmentinfo_details->contact_no ?>" placeholder="contact_no">
        </div>
        <div class="form-group">
            <label for="email">email</label>
            <input class="form-control" type="text" name="email" value="<?php echo $assessmentinfo_details->email ?>" placeholder="email">
        </div>
        <div class="form-group">
            <label for="website">website</label>
            <input class="form-control" type="text" name="website" value="<?php echo $assessmentinfo_details->website ?>" placeholder="website">
        </div>
        <div class="form-group">
            <label for="total_ira">total_ira</label>
            <input class="form-control" type="text" name="total_ira" value="<?php echo $assessmentinfo_details->total_ira ?>" placeholder="total_ira">
        </div>
        <div class="form-group">
            <label for="total_budget_lswdo">total_budget_lswdo</label>
            <input class="form-control" type="text" name="total_budget_lswdo" value="<?php echo $assessmentinfo_details->total_budget_lswdo ?>" placeholder="total_budget_lswdo">
        </div>
        <div class="btn-group">
            <button class="btn btn-success" type="submit" name="submit" value="submit"><i class="fa fa-save"></i> Save</button>
            <a class="btn btn-warning btn-group" href="/lswdo/assessmentinfo/index.html"><i class="fa fa-refresh"></i> Cancel</a>
        </div>
    </form>
</div>
<div class="col-md-3"></div>