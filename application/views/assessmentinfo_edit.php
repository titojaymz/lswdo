<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Created by PhpStorm
 * User: mglveniegas
 *
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
            //    document.getElementById("groupLGUBrgy").style.display = "none";
            //     document.getElementById("groupLGUBrgy").style.visibility = "hidden";
        }
        else
        {
            document.getElementById("groupLGUregion").style.display = "block";
            document.getElementById("groupLGUregion").style.visibility = "visible";
            document.getElementById("groupLGUProvince").style.display = "block";
            document.getElementById("groupLGUProvince").style.visibility = "visible";
            document.getElementById("groupLGUCity").style.display = "block";
            document.getElementById("groupLGUCity").style.visibility = "visible";
            //    document.getElementById("groupLGUBrgy").style.display = "block";
            //    document.getElementById("groupLGUBrgy").style.visibility = "visible";
        }
    }

    document.onreadystatechange=function(){
        get_prov();
        get_cities();
        get_brgy();

    }

    function get_prov() {
        var region_code = $('#regionlist').val();
        var provCode =  $('#prov_pass').val();

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
                    $('#provlist').val(provCode);
                }
            });
        } else {
            $('#provlist option:gt(0)').remove().end();
        }

    }

    function get_cities() {
        var prov_code = $('#provlist').val();
        var cityCode = $('#city_pass').val();

        if(prov_code > 0) {
            $.ajax({
                url: "<?php echo base_url('assessmentinfo/populate_cities'); ?>",
                async: false,
                type: "POST",
                data: "prov_code="+prov_code,
                dataType: "html",
                success: function(data) {
                    $('#div_citylist').html(data);
                    $('#citylist').val(cityCode);
                }
            });

            $.ajax({
                url: "<?php echo base_url('assessmentinfo/populate_countcity'); ?>",
                async: false,
                type: "POST",
                data: "prov_code="+prov_code,
                dataType: "html",
                success: function(data) {
                    $('#groupCity').html(data);
                    $('#groupmuni').html(data);
                }

            });
            $.ajax({
                url: "<?php echo base_url('assessmentinfo/populate_incomeclass'); ?>",
                async: false,
                type: "POST",
                data: "prov_code="+prov_code,
                dataType: "html",
                success: function(data) {
                    $('#income_class').html(data);
                }
            });

            $.ajax({
                url: "<?php echo base_url('assessmentinfo/populate_total_pop'); ?>",
                async: false,
                type: "POST",
                data: "prov_code="+prov_code,
                dataType: "html",
                success: function(data) {
                    $('#total_pop').html(data);
                }
            });

            $.ajax({
                url: "<?php echo base_url('assessmentinfo/populate_total_poor'); ?>",
                async: false,
                type: "POST",
                data: "prov_code="+prov_code,
                dataType: "html",
                success: function(data) {
                    $('#total_poor').html(data);
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
                    url: "<?php echo base_url('assessmentinfo/populate_countbrgy'); ?>",
                    async: false,
                    type: "POST",
                    data: "city_code="+city_code,
                    dataType: "html",
                    success: function(data) {
                        $('#groupbrgy').html(data);
                    }
                });

            } else {
                $('#citylist option:gt(0)').remove().end();
            }
        }

</script>

<?php if (validation_errors() <> '') { ?>
    <div class="alert alert-danger">
        <strong><?php echo validation_errors() ?></strong>
    </div>
<?php } ?>
<body>
<div class="content">

    <div class = "row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-title">
                    <form method="post" class="form-horizontal">
                        <div class="form-group">
                            <label for="geo_info" class="control-label">Geographic Information</label>
                        </div>

                        <div class="form-group">
                            <label for="identify_info" class="control-label">Edit record: Identifying Information</label>
                        </div>

                    <div class="form-group">
                        <label for="profile_id">Profile ID:</label>
                        <span class="h4"><?php echo $assessmentinfo_details->profile_id ?></span>
                        <input class="form-control" type="hidden" name="profile_id" value="<?php echo $assessmentinfo_details->profile_id ?>" >
                    </div>

                    <div class="form-group">
                        <label for="application_type_id">Application Type: </label>
                        <select name="application_type_id" id="application_type_id" class="form-control"">
                        <option value="0">-Please select-</option>
                        <?php foreach($application as $applications): ?>
                            <option value="<?php echo $applications->application_type_id; ?>"
                                <?php if(isset($assessmentinfo_details->application_type_id)) {
                                    if($applications->application_type_id == $assessmentinfo_details->application_type_id) {
                                        echo " selected";
                                    }
                                } ?>
                                >
                                <?php echo $applications->application_type_name; ?>
                            </option>
                        <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label class="control-label">LSWDO Type: </label>

                        <select name="lgu_type_id" id="lgu_type_id" class="form-control" onchange="askLGU();">
                            <option select value="0">-Please select-</option>
                            <?php foreach($lgu_type as $lgus): ?>
                                <option value="<?php echo $lgus->lgu_type_id; ?>"
                                    <?php if(isset($assessmentinfo_details->lgu_type_id)) {
                                        if($lgus->lgu_type_id == $assessmentinfo_details->lgu_type_id) {
                                            echo " selected";
                                        }
                                    } ?>
                                    >
                                    <?php echo $lgus->lgu_type_name; ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                        <br>
                        <div id="groupLGUregion">
                            <div class="form-group form-group-sm">
                                <label for="regionlist" class="col-lg-2 control-label">Region: </label>
                                <div id="div_regionlist" class="col-lg-6">
                                    <fieldset>
                                        <div class="control-group">
                                            <div class="controls">
                                                <select name="regionlist" id="regionlist" class="form-control" onchange="get_prov();">
                                                    <option value="0">Choose Region</option>
                                                    <?php foreach($regionlist as $regionselect): ?>
                                                        <option value="<?php echo $regionselect->region_code; ?>"
                                                            <?php if(isset($assessmentinfo_details->region_code )) {
                                                                if($regionselect->region_code == $assessmentinfo_details->region_code) {
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

                        <div id="groupLGUProvince">
                            <div class="form-group form-group-sm">
                                <label for="provlist" class="col-lg-2 control-label">Province: </label>
                                <div id="div_provlist" class="col-lg-8">
                                    <select id="provlist" name="provlist" class="form-control" onChange="get_cities();">
                                        <?php if(isset($assessmentinfo_details->prov_code) or isset($assessmentinfo_details->region_code)) {
                                            ?>
                                            <option value="0">Choose Province</option>
                                            <?php
                                            foreach ($provlist as $provselect) { ?>
                                                <option value="<?php echo $provselect->prov_code; ?>"
                                                    <?php
                                                    if ($provselect->prov_code == $assessmentinfo_details->prov_code) {
                                                        echo " selected";
                                                    } ?>
                                                    >
                                                    <?php echo $provselect->prov_code; ?></option>
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


                        <div id="groupLGUCity">
                            <div class="form-group form-group-sm">
                                <label for="citylist" class="col-lg-2 control-label">City: </label>
                                <div id="div_citylist" class="col-lg-8">
                                    <select id="citylist" name="citylist" class="form-control">
                                        <?php if($assessmentinfo_details->city_code or $assessmentinfo_details->prov_code) {
                                            ?>
                                            <option value="0">Choose City</option>
                                            <?php
                                            foreach ($citylist as $cityselect) { ?>
                                                <option value="<?php echo $cityselect->city_name; ?>"
                                                    <?php
                                                    if ($cityselect->city_code == $assessmentinfo_details->city_code ) {
                                                        echo " selected";
                                                    } ?>
                                                    >
                                                    <?php echo $cityselect->city_code; ?></option>
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

                    </div>

                    <input class="form-control" type="hidden" id = "prov_pass" name="prov_pass" value ="<?php echo $assessmentinfo_details->prov_code ?>" >
                    <input class="form-control" type="hidden" id = "city_pass" name="city_pass" value ="<?php echo $assessmentinfo_details->city_code ?>" >


                    <div class="form-group">
                        <label for="no_cities">No. of Cities:</label>
                        <div id="groupCity">
                            <div class="control-group">
                                <div class="controls">
                        <input class="form-control" type="text" name="no_city_code" value="" placeholder="No. of Cities" readonly>
                    </div>
                    </div>
                    </div>
                    </div>
                    <div class="form-group">
                        <label for="no_municipalities">No. of Municipalities:</label>
                        <div id="groupmuni">
                            <div class="control-group">
                                <div class="controls">
                        <input class="form-control" type="text" name="no_muni_code" value="" placeholder="No. of Municipalities" readonly>
                    </div>
                    </div>
                    </div>
                    </div>
                    <div class="form-group">
                        <label for="no_brgy_code">No. of Barangays:</label>
                        <div id="groupbrgy">
                            <div class="control-group">
                                <div class="controls">
                        <input class="form-control" type="text" name="no_brgy_code" value="" placeholder="No. of Barangays" readonly>
                    </div>
                    </div>
                    </div>
                    </div>

                    <div class="form-group">
                         <label for="income_class">Income Class:</label>
                        <div id="income_class">
                            <div class="control-group">
                                <div class="controls">
                         <input class="form-control" type="text" name="income_class" value="" placeholder="Income Class" readonly>
                    </div>
                    </div>
                    </div>
                    </div>

                    <div class="form-group">
                        <label for="total_pop">Total Population:</label>
                        <div id="total_pop">
                            <div class="control-group">
                                <div class="controls">
                        <input class="form-control" type="text" name="total_pop" value="" placeholder="Total Population" readonly>
                    </div>
                    </div>
                    </div>
                    </div>

                    <div class="form-group">
                        <label for="total_poor">Total No. of Poor Families:</label>
                        <div id="total_poor">
                            <div class="control-group">
                                <div class="controls">
                        <input class="form-control" type="text" name="total_poor" value="" placeholder="Total No. of Poor Families" readonly>
                    </div>
                    </div>
                    </div>
                    </div>

                    <div class="form-group">
                        <label for="swdo_name">Name of SWDO Officer/Head:</label>
                        <input class="form-control" type="text" name="swdo_name" value="<?php echo $assessmentinfo_details->swdo_name ?>" placeholder="Name of SWDO Officer/Head">
                    </div>

                    <div class="form-group">
                        <label for="designation">Designation:</label>
                        <input class="form-control" type="text" name="designation" value="<?php echo $assessmentinfo_details->designation ?>" placeholder="Designation">
                    </div>

                    <div class="form-group">
                        <label for="office_address">Office Address:</label>
                        <input class="form-control" type="text" name="office_address" value="<?php echo $assessmentinfo_details->office_address ?>" placeholder="Office Address">
                    </div>

                    <div class="form-group">
                        <label for="contact_no">Contact No:</label>
                        <input class="form-control" type="text" name="contact_no" value="<?php echo $assessmentinfo_details->contact_no ?>" placeholder="Contact No">
                    </div>

                    <div class="form-group">
                        <label for="email">Email:</label>
                        <input class="form-control" type="text" name="email" value="<?php echo $assessmentinfo_details->email ?>" placeholder="Email">
                    </div>

                    <div class="form-group">
                        <label for="website">Website:</label>
                        <input class="form-control" type="text" name="website" value="<?php echo $assessmentinfo_details->website ?>" placeholder="Website">
                    </div>

                    <div class="form-group">
                        <label for="total_ira">Total Internal Revenue Allotment:</label>
                        <input class="form-control" type="text" name="total_ira" value="<?php echo $assessmentinfo_details->total_ira ?>" placeholder="Total IRA">
                    </div>

                    <div class="form-group">
                        <label for="total_budget_lswdo">Total Budget LSWDO:</label>
                        <input class="form-control" type="text" name="total_budget_lswdo" value="<?php echo $assessmentinfo_details->total_budget_lswdo ?>" placeholder="Total Budget LSWDO" readonly>
                    </div>

                        <div class="form-group">
                            <div class="btn-group">
                                <button class="btn btn-success" type="submit" name="submit" value="submit"><i class="fa fa-save"></i> Save</button>
                                <a class="btn btn-warning btn-group" href="/lswdo/assessmentinfo/index"><i class="fa fa-refresh"></i> Cancel</a>
                            </div>
                        </div>
                </div>
                </form>
            </div>
            <div class="col-md-3"></div>
        </div>
    </div>
</div>
</div>

</div>
</body>