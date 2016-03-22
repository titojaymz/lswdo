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
<script type="text/javascript">
    function askLGU() {
        var e = document.getElementById("lgu_type_id").value;
        if (e == 1)
        {
            document.getElementById("groupLGUregion").style.display = "block";
            document.getElementById("groupLGUregion").style.visibility = "visible";
            document.getElementById("groupLGUProvince").style.display = "block";
            document.getElementById("groupLGUProvince").style.visibility = "visible";
            document.getElementById("groupLGUCity").style.display = "none";
            document.getElementById("groupLGUCity").style.visibility = "hidden";
            document.getElementById("groupLGUBrgy").style.display = "none";
            document.getElementById("groupLGUBrgy").style.visibility = "hidden";
        }
        else
        {
            document.getElementById("groupLGUregion").style.display = "block";
            document.getElementById("groupLGUregion").style.visibility = "visible";
            document.getElementById("groupLGUProvince").style.display = "block";
            document.getElementById("groupLGUProvince").style.visibility = "visible";
            document.getElementById("groupLGUCity").style.display = "block";
            document.getElementById("groupLGUCity").style.visibility = "visible";
            document.getElementById("groupLGUBrgy").style.display = "block";
            document.getElementById("groupLGUBrgy").style.visibility = "visible";
        }
    }

    function get_provinces() {
        var region_code = $('#regionlist').val();
        $('#citylist option:gt(0)').remove().end();
        $('#brgylist option:gt(0)').remove().end();
            if(region_code > 0) {
            $.ajax({
            url: "<?php echo base_url('assessmentinfo/populate_prov'); ?>",
            async: false,
            type: "POST",
            data: "region_code="+region_code,
                dataType: "html",
                success: function(data) {
                $('#div_provlist').html(data);
                    }
        });
            } else {
        $('#provlist option:gt(0)').remove().end();
                    }
        }
    function get_cities() {
        var prov_code = $('#provlist').val();
        $('#brgylist option:gt(0)').remove().end();
        if(prov_code > 0) {
        $.ajax({
        url: "<?php echo base_url('assessmentinfo/populate_cities'); ?>",
        async: false,
        type: "POST",
        data: "prov_code="+prov_code,
        dataType: "html",
        success: function(data) {
        $('#div_citylist').html(data);
        }
        });
        } else {
        $('#citylist option:gt(0)').remove().end();
        }
        }
    function get_brgy() {
        var city_code = $('#citylist').val();
        if(city_code > 0) {
        $.ajax({
        url: "<?php echo base_url('assessmentinfo/populate_brgy'); ?>",
        async: false,
        type: "POST",
        data: "city_code="+city_code,
        dataType: "html",
        success: function(data) {
        $('#div_brgylist').html(data);
        }
        });
        } else {
        $('#brgylist option:gt(0)').remove().end();
        }
        }
</script>
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
    <?php /*---------------sdf------------- lswdo certificate--------------------------------------------------*/?>
    <form method="post" class="form-horizontal">
        <div class="form-group">

            <div class="form-group">
                <label for="geo_info" class="control-label">Geographic Information</label>
            </div>

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
             <div class="form-group">
                <label class="control-label">Type of LSWDO</label>
            <!--Select-->
                      <select id="lgu_type_id" name="lgu_type_id" placeholder="lgu_type_id" type="text" class="form-control" onchange="askLGU();" required>
                            <option select value="">Please select</option>
                            <?php foreach($lgu_type as $lgus): ?>
                                <option value="<?php echo $lgus->lgu_type_id ?>"><?php echo $lgus->lgu_type_name ?></option>
                            <?php endforeach ?>
                        </select>
            <!--Region-->
                        <div id="groupLGUregion">
                            <div class="form-group form-group-sm">
                                <label for="regionlist" class="col-lg-2 control-label">Region</label>
                                <div id="div_regionlist" class="col-lg-8">
                                    <fieldset>
                                        <div class="control-group">
                                            <div class="controls">
                                                <select name="regionlist" id="regionlist" class="form-control" onChange="get_provinces();">
                                                    <option value="0">Choose Region</option>
                                                    <?php foreach($regionlist as $regionselect): ?>
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
                                        </div>
                                </div>
                            </div>
                        </div>
                 <!--END Region-->

                <!--Province-->
                <div id="groupLGUProvince">
                    <div class="form-group form-group-sm">
                        <label for="provlist" class="col-lg-2 control-label">Province</label>
                        <div id="div_provlist" class="col-lg-8">
                            <select id="provlist" name="provlist" class="form-control" onChange="get_cities();">
                                <?php if(isset($_SESSION['province']) or isset($_SESSION['region'])) {
                                    ?>
                                    <option value="0">Choose Province</option>
                                    <?php
                                    foreach ($provlist as $provselect) { ?>
                                        <option value="<?php echo $provselect->prov_code; ?>"
                                            <?php
                                            if (isset($_SESSION['province']) and $provselect->prov_code== $_SESSION['province']) {
                                                echo " selected";
                                            } ?>
                                            >
                                            <?php echo $provselect->prov_name; ?></option>
                                        <?php
                                    }
                                } else {
                                    ?>
                                    <option>Select Region First</option>
                                    <?php
                                } ?>
                            </select>
                        </div>
                    </div>
                </div>
                <!--End Province-->
                <!--City-->
                <div id="groupLGUCity">
                    <div class="form-group form-group-sm">
                        <label for="citylist" class="col-lg-2 control-label">City</label>
                        <div id="div_citylist" class="col-lg-8">
                            <select id="citylist" name="citylist" onchange="get_brgy();" class="form-control">
                                <?php if(isset($_SESSION['city']) or isset($_SESSION['province'])) {
                                    ?>
                                    <option value="0">Choose City</option>
                                    <?php
                                    foreach ($citylist as $cityselect) { ?>
                                        <option value="<?php echo $cityselect->city_code; ?>"
                                            <?php
                                            if (isset($_SESSION['city']) and $cityselect->city_code== $_SESSION['city']) {
                                                echo " selected";
                                            } ?>
                                            >
                                            <?php echo $cityselect->city_name; ?></option>
                                        <?php
                                    }
                                } else {
                                    ?>
                                    <option>Select Province First</option>
                                    <?php
                                } ?>
                            </select>
                        </div>
                    </div>
                </div>
                <!--End City-->

                <!--Brgy-->
                <div id="groupLGUBrgy">
                    <div class="form-group form-group-sm">
                        <label for="brgylist" class="col-lg-2 control-label">Barangay</label>
                        <div id="div_brgylist" class="col-lg-8">
                            <select id="brgylist" name="brgylist" class="form-control">
                                <?php if(isset($_SESSION['brgy']) or isset($_SESSION['city'])) {
                                    ?>
                                    <option value="0">Choose Barangay</option>
                                    <?php
                                    foreach ($brgylist as $brgyselect) { ?>
                                        <option value="<?php echo $brgyselect->brgy_code; ?>"
                                            <?php
                                            if (isset($_SESSION['brgy']) and $brgyselect->brgy_code == $_SESSION['brgy']) {
                                                echo " selected";
                                            } ?>
                                            >
                                            <?php echo $brgyselect->brgy_name; ?></option>
                                        <?php
                                    }
                                } else {
                                    ?>
                                    <option>Select City First</option>
                                    <?php
                                } ?>
                            </select>
                        </div>
                    </div>
                </div>
                <!--End Brgy-->
             </div>  <!--End Select-->

            <div class="form-group">
                <label for="no_city_code">No. of Cities:</label>
                <input class="form-control" type="text" name="no_city_code" value="" placeholder="no_city_code" readonly>
            </div>

            <div class="form-group">
                <label for="no_muni_code">No. of Municipalities:</label>
                <input class="form-control" type="text" name="no_muni_code" value="" placeholder="no_muni_code" readonly>
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

            <div class="form-group">
                <label for="swdo_name">SWDO Name:</label>
                <input class="form-control" type="text" name="swdo_name" value="<?php echo set_value('swdo_name') ?>" placeholder="swdo_name">
            </div>


            <div class="form-group">
                <label for="designation">Designation:</label>
                <input class="form-control" type="text" name="designation" value="" placeholder="designation" readonly>
            </div>


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
        </div>
    </form>
</div>
<div class="col-md-3"></div>
</body>