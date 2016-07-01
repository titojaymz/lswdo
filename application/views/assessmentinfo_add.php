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

    /*
     function GroupStatus() {
     var e = document.getElementById("application_type_id").value;
     if (e == 0)
     {
     document.getElementById("group_new").style.display = "none";
     document.getElementById("group_new").style.visibility = "hidden";
     document.getElementById("group_renewal").style.display = "none";
     document.getElementById("group_renewal").style.visibility = "hidden";
     }
     else if (e==1)
     {
     document.getElementById("group_new").style.display = "block";
     document.getElementById("group_new").style.visibility = "visible";
     document.getElementById("group_renewal").style.display = "none";
     document.getElementById("group_renewal").style.visibility = "hidden";
     }
     else {
     document.getElementById("group_new").style.display = "none";
     document.getElementById("group_new").style.visibility = "hidden";
     document.getElementById("group_renewal").style.display = "block";
     document.getElementById("group_renewal").style.visibility = "visible";
     }
     }
     */

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
            $('#citylist option:gt(0)').remove().end();

        }
       else if (e == 2)
        {
            document.getElementById("groupLGUregion").style.display = "block";
            document.getElementById("groupLGUregion").style.visibility = "visible";
            document.getElementById("groupLGUProvince").style.display = "block";
            document.getElementById("groupLGUProvince").style.visibility = "visible";
            document.getElementById("groupLGUCity").style.display = "block";
            document.getElementById("groupLGUCity").style.visibility = "visible";

        }
        else if (e == 3)
        {
            document.getElementById("groupLGUregion").style.display = "block";
            document.getElementById("groupLGUregion").style.visibility = "visible";
            document.getElementById("groupLGUProvince").style.display = "block";
            document.getElementById("groupLGUProvince").style.visibility = "visible";
            document.getElementById("groupLGUCity").style.display = "block";
            document.getElementById("groupLGUCity").style.visibility = "visible";

        }
        else
        {
            document.getElementById("groupLGUregion").style.display = "block";
            document.getElementById("groupLGUregion").style.visibility = "visible";
            document.getElementById("groupLGUProvince").style.display = "block";
            document.getElementById("groupLGUProvince").style.visibility = "visible";
            document.getElementById("groupLGUCity").style.display = "block";
            document.getElementById("groupLGUCity").style.visibility = "visible";
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
        var lgu_type = $('#lgu_type_id').val();
        $('#brgylist option:gt(0)').remove().end();

        if(lgu_type == 1 && prov_code > 0) {

            $.ajax({
                url: "<?php echo base_url('assessmentinfo/populate_countcity'); ?>",
                async: false,
                type: "POST",
                data: "prov_code="+prov_code,
                dataType: "html",
                success: function(data) {
                    $('#groupCity').html(data);
                }
            });

            $.ajax({
                url: "<?php echo base_url('assessmentinfo/populate_countmuni'); ?>",
                async: false,
                type: "POST",
                data: "prov_code="+prov_code,
                dataType: "html",
                success: function(data) {
                    $('#groupmuni').html(data);
                }
            });

            $.ajax({
                url: "<?php echo base_url('assessmentinfo/populate_countbrgy2'); ?>",
                async: false,
                type: "POST",
                data: "prov_code="+prov_code,
                dataType: "html",
                success: function(data) {
                    $('#groupbrgy').html(data);
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
        }

       else if(lgu_type == 2 && prov_code > 0) {

            $.ajax({
                url: "<?php echo base_url('assessmentinfo/populate_cities1'); ?>",
                async: false,
                type: "POST",
                data: "prov_code="+prov_code,
                dataType: "html",
                success: function(data) {
                    $('#div_citylist').html(data);
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
                }
            });

            $.ajax({
                url: "<?php echo base_url('assessmentinfo/populate_countmuni'); ?>",
                async: false,
                type: "POST",
                data: "prov_code="+prov_code,
                dataType: "html",
                success: function(data) {
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

        }
        else if (lgu_type == 3 && prov_code > 0)
        {
            $.ajax({
                url: "<?php echo base_url('assessmentinfo/populate_cities2'); ?>",
                async: false,
                type: "POST",
                data: "prov_code="+prov_code,
                dataType: "html",
                success: function(data) {
                    $('#div_citylist').html(data);
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
                }
            });

            $.ajax({
                url: "<?php echo base_url('assessmentinfo/populate_countmuni'); ?>",
                async: false,
                type: "POST",
                data: "prov_code="+prov_code,
                dataType: "html",
                success: function(data) {
                    $('#groupmuni').html(data);
                }
            });


        }
        else
        {
            $('#citylist option:gt(0)').remove().end();
        }

    }

    function get_brgy() {
        var city_code = $('#citylist').val();
        var lgu_type = $('#lgu_type_id').val();

        if(lgu_type == 2 && city_code > 0) {

            $.ajax({
                url: "<?php echo base_url('assessmentinfo/populate_countbrgy'); ?>",
                async: false,
                type: "POST",
                data: "city_code=" + city_code,
                dataType: "html",
                success: function (data) {
                    $('#groupbrgy').html(data);
                }
            });

            $.ajax({
                url: "<?php echo base_url('assessmentinfo/populate_incomeclass2'); ?>",
                async: false,
                type: "POST",
                data: "city_code="+city_code,
                dataType: "html",
                success: function(data) {
                    $('#income_class').html(data);
                }
            });

            $.ajax({
                url: "<?php echo base_url('assessmentinfo/populate_total_poor2'); ?>",
                async: false,
                type: "POST",
                data: "city_code=" + city_code,
                dataType: "html",
                success: function (data) {
                    $('#total_poor').html(data);
                }
            });

            $.ajax({
                url: "<?php echo base_url('assessmentinfo/populate_total_pop2'); ?>",
                async: false,
                type: "POST",
                data: "city_code="+city_code,
                dataType: "html",
                success: function(data) {
                    $('#total_pop').html(data);
                }
            });

        }
       else if(lgu_type == 3 && city_code > 0) {

            $.ajax({
                url: "<?php echo base_url('assessmentinfo/populate_countbrgy3'); ?>",
                async: false,
                type: "POST",
                data: "city_code=" + city_code,
                dataType: "html",
                success: function (data) {
                    $('#groupbrgy').html(data);
                }
            });

            $.ajax({
                url: "<?php echo base_url('assessmentinfo/populate_incomeclass3'); ?>",
                async: false,
                type: "POST",
                data: "city_code="+city_code,
                dataType: "html",
                success: function(data) {
                    $('#income_class').html(data);
                }
            });

            $.ajax({
                url: "<?php echo base_url('assessmentinfo/populate_total_poor3'); ?>",
                async: false,
                type: "POST",
                data: "city_code=" + city_code,
                dataType: "html",
                success: function (data) {
                    $('#total_poor').html(data);
                }
            });

            $.ajax({
                url: "<?php echo base_url('assessmentinfo/populate_total_pop3'); ?>",
                async: false,
                type: "POST",
                data: "city_code="+city_code,
                dataType: "html",
                success: function(data) {
                    $('#total_pop').html(data);
                }
            });


        }

         else {
            $('#brgylist option:gt(0)').remove().end();
        }
    }
/*
    function mask(f){
        tel='(';
        var val =f.value.split('');
        for(var i=0;i<val.length;i++){
            if(i==2){val[i]=val[i]+')'}
            if(i==5){val[i]=val[i]+'-'}
            tel=tel+val[i]
        }
        f.value=tel;
    }
*/
</script>
<body>
<div class="content">

    <!-- Start Page Header -->
    <div class="page-header">
        <!-- <h1 class="title">Tool for the Assessment of FUNCTIONALITY of LSWDOs</h1>-->
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url('dashboardc/dashboard'); ?>">Home</a></li>
            <li><a href="<?php echo base_url('assessmentinfo/index/0'); ?>">Assessment Information</a></li>
            <li class="active">Add</li>
        </ol>
    </div>
    <!-- End Page Header -->
    <?php if (validation_errors() <> '') { ?>
        <div class="alert alert-danger">
            <strong><?php echo validation_errors() ?></strong>
        </div>
    <?php } ?>
    <?php echo $form_message; ?>
    <div class = "row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-title">
                    <form method="post" class="form-horizontal">
                        <div class="form-group">
                            <label for="geo_info" class="control-label">Geographic Information: Identifying Information</label>
                        </div>

                        <div class="form-group">
                            <label class="control-label">Status of Application:</label>
                            <select class="form-control" name="application_type" id="application_type" style="width:500px;" disabled>
                                <option selected value="1">Please select</option>
                                <?php foreach($application as $applications): ?>
                                    <option <?php if ($applications->application_type_id==1)
                                    {
                                        echo "selected";
                                    }
                                    ?> value="<?php echo $applications->application_type_id ?>"><?php echo $applications->application_type_name ?></option>
                                <?php endforeach ?>
                            </select>

                            <!--  <input name="phone" type="text" onblur="mask(this)">-->
                            <select class="form-control" name="application_type_id" id="application_type_id" style="display:none;">
                                <option selected value="1">Please select</option>
                                <?php foreach($application as $applications): ?>
                                    <option <?php if ($applications->application_type_id==1)
                                    {
                                        echo "selected";
                                    }
                                    ?> value="<?php echo $applications->application_type_id ?>"><?php echo $applications->application_type_name ?></option>
                                <?php endforeach ?>
                            </select>

                                   <label class="control-label">Type of LSWDO:*</label>
                                   <!--Select-->
                                <select id="lgu_type_id" name="lgu_type_id" class="form-control" style="width:500px;" onchange="askLGU();" required>
                                    <option select value="">Please select</option>
                                    <?php foreach($lgu_type as $lgus): ?>
                                        <option value="<?php echo $lgus->lgu_type_id ?>"><?php echo $lgus->lgu_type_name ?></option>
                                    <?php endforeach ?>
                                </select>
                                <!--Region-->
                                <div id="groupLGUregion">
                                    <div class="form-group form-group-sm">
                                        <label for="regionlist" class="col-lg-2 control-label">Region:*</label>
                                        <div id="div_regionlist" class="col-lg-8">
                                            <fieldset>
                                                <div class="control-group">
                                                    <div class="controls">
                                                        <select name="regionlist" id="regionlist" class="form-control" style="width:500px;" onChange="get_provinces();" required>
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
                                        <label for="provlist" class="col-lg-2 control-label">Province:*</label>
                                        <div id="div_provlist" class="col-lg-8">
                                            <select id="provlist" name="provlist" class="form-control" style="width:500px;" onChange="get_cities();" required>
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
                                        <label for="citylist" class="col-lg-2 control-label">City/Municipalities:</label>
                                        <div id="div_citylist" class="col-lg-8">
                                            <select id="citylist" name="citylist" class="form-control" style="width:500px;">
                                                <?php if(isset($_SESSION['city']) or isset($_SESSION['province'])) {
                                                    ?>
                                                    <option value="0">Choose City/Municipality</option>
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
                                                    <option value="0">Select Province First</option>
                                                    <?php
                                                } ?>
                                            </select>
                                        </div>
                                    </div>

                                </div>  <!--End Select-->

                                <label for="nocitylist"> No. of Cities:</label>
                                <div id="groupCity">
                                    <div class="control-group">
                                        <div class="controls">
                                            <input class="form-control" type="text" name="no_cities" style="width:500px;" placeholder="No. of Cities" readonly>
                                        </div>
                                    </div>
                                </div>

                                <label for="no_muni_code">No. of Municipalities:</label>
                                <div id="groupmuni">
                                    <div class="control-group">
                                        <div class="controls">
                                            <input class="form-control" type="text" name="no_muni" style="width:500px;" placeholder="No. of Municipalities" readonly>
                                        </div>
                                    </div>
                                </div>

                                <label for="no_brgy">No. of Barangays:</label>
                                <div id="groupbrgy">
                                    <div class="control-group">
                                        <div class="controls">
                                            <input class="form-control" type="text" name="no_brgy" style="width:500px;" placeholder="No. of Barangays" readonly>
                                        </div>
                                    </div>
                                </div>

                                <label for="income_class">Income Class:</label>
                                <div id="income_class">
                                    <div class="control-group">
                                        <div class="controls">

                                            <input class="form-control" type="text" name="income_class" style="width:500px;" placeholder="Income Class" readonly>
                                        </div>
                                    </div>
                                </div>

                                <label for="total_pop">Total Population:</label>
                                <div id="total_pop">
                                    <div class="control-group">
                                        <div class="controls">
                                            <input class="form-control" type="text" name="total_pop" style="width:500px;" placeholder="Total Population" readonly>
                                        </div>
                                    </div>
                                </div>

                                <label for="total_poor">Total No. of Poor Families:</label>
                                <div id="total_poor">
                                    <div class="control-group">
                                        <div class="controls">
                                            <input class="form-control" type="text" name="total_poor" style="width:500px;" value="" placeholder="Total No. of Poor Families" readonly>
                                        </div>
                                    </div>
                                </div>

                                <label for="swdo_name">Name of SWDO Officer/Head:*</label>
                                <input class="form-control" type="text" name="swdo_name" value="<?php echo set_value('swdo_name') ?>" style="width:500px;" placeholder="Name of SWDO Officer/Head" required>

                                <label for="designation">Designation:*</label>
                                <input class="form-control" type="text" name="designation" value="<?php echo set_value('designation') ?>" style="width:500px;" placeholder="Designation" required>

                                <label for="office_address">Office Address:*</label>
                                <input class="form-control" type="text" name="office_address" value="<?php echo set_value('office_address') ?>" style="width:500px;" placeholder="Office Address" required>

                                <label for="contact_no">Contact No:*</label>
                                <input class="form-control" type="number" min="7" max="11" name="contact_no" value="<?php echo set_value('contact_no') ?>" style="width:500px;" placeholder="Contact No" required>

                                <label for="email">Email Address:*</label>
                                <input class="form-control" type="email" name="email" value="<?php echo set_value('email') ?>" placeholder="Email" style="width:500px;" required>

                                <label for="website">Website:*</label>
                                <input class="form-control" type="url" name="website" value="<?php echo set_value('website') ?>" placeholder="Website" style="width:500px;" required>

                                </br>
                                <?php /*---------------------------Budget Allocation and Utilization -------------------------------------------------*/?>

                                <label for="budget" class="control-label">Budget Allocation and Utilization</label>
                                </br></br>

                                <label for="total_ira">Total Internal Revenue Allotment:</label>
                                <input class="form-control" type="text" name="total_ira" value="<?php echo set_value('total_ira') ?>" data-mask="000,000,000.00" style="width:500px;" placeholder="Total Internal Revenue Allotment">


                                <label for="total_budget_lswdo">Total Budget LSWDO:</label>
                                <input class="form-control" type="text" name="total_budget_lswdo" value="<?php echo set_value('total_budget_lswdo') ?>" style="width:500px;" placeholder="Total Budget LSWDO">

                        </div>
                        <div class="form-group">
                            <div class="btn-group">
                                <button class="btn btn-success" type="submit" name="submit" value="submit"><i class="fa fa-save"></i> Save</button>
                                <a class="btn btn-warning btn-group" href="<?php echo base_url('assessmentinfo/index/0') ?>"><i class="fa fa-refresh"></i> Cancel</a>
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