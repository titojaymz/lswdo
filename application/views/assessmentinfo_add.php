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
            <div class="form-group">
                    <label for="identify_info" class="control-label">Identifying Information</label>
                </div>

            <div class="form-group">
                <label for="application_type_id">Status of Application:</label>
                <select class="form-control" name="application_type_id" id="application_type_id">
                    <option select value="">Please select</option>
                    <?php foreach($application as $applications): ?>
                        <option value="<?php echo $applications->application_type_id ?>"><?php echo $applications->application_type_name ?></option>
                    <?php endforeach ?>
                </select>
            </div>
<pre>
    <?php echo $applications->application_type_name ?>
    </pre>
            <div class="form-group">
                <label for="lgu_type_id">Type of LSWDO:</label>
                <select class="form-control" name="lgu_type_id" id="lgu_type_id">
                    <option select value="">Please select</option>
                    <?php foreach($lgu_type as $lgus): ?>
                        <option value="<?php echo $lgus->lgu_type_id ?>"><?php echo $lgus->lgu_type_name ?></option>
                    <?php endforeach ?>
                </select>
            </div>
<!--
            <div class="form-group">
                <label for="region_code">Region:</label>
                <select class="form-control" name="lgu_type_id" id="lgu_type_id">
                    <option select value="">Please select</option>
                    <?php //foreach($region as $regions): ?>
                        <option value="<?php //echo $regions->region_code ?>"><?php //echo $regions->region_name ?></option>
                    <?php //endforeach ?>
                </select>
            </div>

            <div class="form-group">
                <label for="prov_code">Province:</label>
                <select class="form-control" name="prov_code" id="prov_code">
                    <option select value="">Please select</option>
                    <?php //foreach($prov as $provs): ?>
                        <option value="<?php //echo $provs->prov_code ?>"><?php //echo $provs->prov_name ?></option>
                    <?php //endforeach ?>
                </select>
            </div>

             <div class="form-group">
                <label for="city_code">City:</label>
                 <select class="form-control" name="city_code" id="city_code">
                     <option select value="">Please select</option>
                     <?php //foreach($city as $cities): ?>
                         <option value="<?php //echo $cities->city_code ?>"><?php //echo $cities->city_name ?></option>
                     <?php //endforeach ?>
                 </select>
            </div>

            <div class="form-group">
                <label for="no_city_code">No. of Cities:</label>
                <input class="form-control" type="text" name="no_city_code" value="" placeholder="no_city_code" readonly>
            </div>

            <div class="form-group">
                <label for="no_muni_code">No. of Municipalities:</label>
                <input class="form-control" type="text" name="no_muni_code" value="" placeholder="no_muni_code" readonly>
            </div>

            <div class="form-group">
                <label for="brgy_code">Barangays:</label>
                <select class="form-control" name="brgy_code" id="brgy_code">
                    <option select value="">Please select</option>
                    <?php //foreach($brgy as $brgys): ?>
                        <option value="<?php //echo $brgys->brgy_code ?>"><?php //echo $brgys->brgy_name ?></option>
                    <?php //endforeach ?>
                </select>
            </div>

            <div class="form-group">
                <label for="no_brgy_code">No. of Barangays:</label>
                <input class="form-control" type="text" name="no_brgy_code" value="" placeholder="no_brgy_code" readonly>
            </div>

            <div class="form-group">
                <label for="income_class">Income Class:</label>
                <input class="form-control" type="text" name="income_class" value="" placeholder="income_class" readonly>
            </div>

            <div class="form-group">
                <label for="total_pop">Total Population:</label>
                <input class="form-control" type="text" name="total_pop" value="" placeholder="total_pop" readonly>
            </div>

            <div class="form-group">
                <label for="total_poor">Total No. of Poor Families:</label>
                <input class="form-control" type="text" name="total_poor" value="" placeholder="total_poor" readonly>
            </div>
-->
            <div class="form-group">
                <label for="swdo_name">SWDO Name:</label>
                <input class="form-control" type="text" name="swdo_name" value="<?php echo set_value('swdo_name') ?>" placeholder="swdo_name">
            </div>

          <!---
            <div class="form-group">
                <label for="designation">Designation:</label>
                <input class="form-control" type="text" name="designation" value="" placeholder="designation" readonly>
            </div>

            -->
            <div class="form-group">
                <label for="street_address">Street Address:</label>
                <input class="form-control" type="text" name="street_address" value="<?php echo set_value('street_address') ?>" placeholder="street_address">
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