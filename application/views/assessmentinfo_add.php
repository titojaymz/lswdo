<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Created by JOSEF FRIEDRICH S. BALDO
 * Date Time: 10/18/15 12:57 AM
 */
if (!$this->session->userdata('user_id')){
    redirect('/users/login','location');
}
//echo validation_errors();
?>
<body>

<?php if ($form_message <> '') { ?>
    <div class="alert alert-success">
        <strong><?php echo $form_message ?></strong>
    </div>
<?php } ?>
<?php if (validation_errors() <> '') { ?>
    <div class="alert alert-danger">
        <strong><?php echo validation_errors() ?></strong>
    </div>
<?php } ?>
<div class="modal-body">
    <div class="container">
        <div class="row">
<div class="col-md-3"></div>
<div id="addassessment" class="col-md-6">
    <form method="post" class="form-horizontal">

<?php /*---------------sdf------------- lswdo certificate--------------------------------------------------*/?>
        <div class="form-group">
            <div class="form-group form-group-sm">
                <div class="col-lg-4 col-sm-4">
                    <label for="geo" class="control-label">Geographic Information</label>
                </div>
            </div>

            <div class="form-group">
                <label for="application_type">Status of Application:</label>

                <select class="form-control" name="application_type_id" id="application_type_id">
                    <option select value="">Please select</option>
                    <?php foreach($application as $Applicationtypes): ?>
                        <option value="<?php echo $Applicationtypes->application_type_id ?>"><?php echo $Applicationtypes->application_type_name ?></option>
                    <?php endforeach ?>
                </select>
            </div>

        <div class="form-group">
            <div class="form-group">
                    <label for="identify_info" class="control-label">Identifying Information</label>
                </div>
            <div class="form-group">
                <label for="lgu_type_id">Type of LSWDO:</label>
                <select class="form-control" name="lgu_type_id" id="lgu_type_id">
                    <option select value="">Please select</option>
                    <?php foreach($lgu_type as $lgus): ?>
                        <option value="<?php echo $lgus->lgu_type_id ?>"><?php echo $lgus->lgu_type_name ?></option>
                    <?php endforeach ?>
                </select>
            </div>

            <div class="form-group">
                <label for="region_code">Region:</label>
                <input class="form-control" type="text" name="region_code" value="<?php echo set_value('region_code') ?>" placeholder="region_code">
            </div>
            <div class="form-group">
                <label for="prov_code">Province:</label>
                <input class="form-control" type="text" name="prov_code" value="<?php echo set_value('prov_code') ?>" placeholder="prov_code">
            </div>
             <div class="form-group">
                <label for="city_code">City:</label>
                 <input class="form-control" type="text" name="city_code" value="<?php echo set_value('city_code') ?>" placeholder="city_code">
            </div>
            <div class="form-group">
                <label for="brgy_code">Baranggay:</label>
                <input class="form-control" type="text" name="swdo_name" value="<?php echo set_value('brgy_code') ?>" placeholder="swdo_name">
            </div>
            <div class="form-group">
                <label for="street_address">Street Address:</label>
                <input class="form-control" type="text" name="street_address" value="<?php echo set_value('street_address') ?>" placeholder="street_address">
            </div>
            <div class="form-group">
                <label for="swdo_name">SWDO Name:</label>
                <input class="form-control" type="text" name="swdo_name" value="<?php echo set_value('swdo_name') ?>" placeholder="swdo_name">
            </div>
            <div class="form-group">
                <label for="contact_no">Contact No:</label>
                <input class="form-control" type="text" name="contact_no" value="<?php echo set_value('contact_no') ?>" placeholder="contact_no">
            </div>
            <div class="form-group">
                <label for="email">Email:</label>
                <input class="form-control" type="text" name="email" value="<?php echo set_value('email') ?>" placeholder="email">
            </div>
            <div class="form-group">
                <label for="website">Website:</label>
                <input class="form-control" type="text" name="website" value="<?php echo set_value('website') ?>" placeholder="website">
            </div>

            <?php /*----------------------------Budget Allocation and Utilization -------------------------------------------------*/?>

            <div class="form-group">
                <label for="budget" class="control-label">Budget Allocation and Utilization</label>
            </div>
            <div class="form-group">
                <label for="total_ira">Total IRA:</label>
                <input class="form-control" type="text" name="total_ira" value="<?php echo set_value('total_ira') ?>" placeholder="total_ira">
            </div>
                <div class="form-group">
                <label for="total_budget_lswdo">Total Budget LSWDO:</label>
                <input class="form-control" type="text" name="total_budget_lswdo" value="<?php echo set_value('total_budget_lswdo') ?>" placeholder="total_budget_lswdo">
            </div>


        <div class="form-group">
        <div class="btn-group">
            <button class="btn btn-success" type="submit" name="submit" value="submit"><i class="fa fa-save"></i> Save</button>
            <a class="btn btn-warning btn-group" href="/lswdo/assessmentinfo/index.html"><i class="fa fa-refresh"></i> Cancel</a>
        </div>
        </div>

    </form>
</div>
<div class="col-md-3"></div>
</body>