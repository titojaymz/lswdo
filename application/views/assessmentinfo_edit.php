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

    document.onreadystatechange=function(){
        get_prov();
        get_cities();
        get_brgy();
        askLGU();
        GroupStatus();

    }

    function get_prov() {
        var region_code = $('#regionlist').val();
        var provCode = $('#prov_pass').val();

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
        var lgu_type = document.getElementById("lgu_type_id").value;
        var prov_code = $('#provlist').val();
        var cityCode = $('#city_pass').val();

        $('#brgylist option:gt(0)').remove().end();

        if(lgu_type == 1 && prov_code > 0) {

            $('#citylist option:gt(0)').remove().end();

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
        var lgu_type = document.getElementById("lgu_type_id").value;
        var city_code = $('#citylist').val();

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

    function validtxt(){
        var txt = document.getElementById("swdo_name").value ;
        var len =txt.trim().length;

        if (len < 1)
        {
            alert("Invalid Text!");
        }

    }

    function validtxt2(){
        var txt2 = document.getElementById("designation").value ;
        var len =txt2.trim().length;

        if (len < 1)
        {
            alert("Invalid Text!");
        }

    }

    function validtxt3(){
        var txt3 = document.getElementById("office_address").value ;
        var len =txt3.trim().length;

        if (len < 1)
        {
            alert("Invalid Text!");
        }

    }
</script>
<body>
<div class="content">
    <!-- Start Page Header -->
    <div class="page-header">

        <ol class="breadcrumb">
            <li><a href="<?php echo base_url('dashboardc/dashboard'); ?>">Home</a></li>
            <li><a href="<?php echo base_url('assessmentinfo/index/0'); ?>">Assessment Information</a></li>
            <li class="active">Edit</li>
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
                    <form method="post" action="" class="form-horizontal">
                        <div class="form-group">
                            <label for="geo_info" class="control-label">Geographic Information: Identifying Information</label>
                        </div>
                        <div class="form-group">

                            <input class="form-control" type="hidden" name="profile_id" value="<?php echo $assessmentinfo_details->profile_id ?>">
                        </div>
          <table style="width:100%">
              <tr>
                    <td width="50%">
                        <div class="form-group">
                            <label for="application_type_id">Status of Application:</label>
                            <div id="application_type_id">
                                <div class="control-group">
                                    <div class="controls">
                                        <input class="form-control" type="hidden" id="application_type_id" name="application_type_id" style="width:90%;" value="<?php echo $assessmentinfo_details->application_type_id ?>" placeholder="Status of Application">
                                        <input class="form-control" type="text" id="application_type_name" name="application_type_name" style="width:90%;" value="<?php echo $assessmentinfo_details->application_type_name ?>" placeholder="Status of Application" readonly>
                                    </div>
                                </div>
                            </div>
                        </div>
                     </td>

                  <!--2nd column-->
                     <td width="50%">
                         <div class="form-group">
                             <label for="budget" class="control-label">Budget Allocation and Utilization</label>
                             </br></br></br>
                         </div>
                    </td>
             </tr>

              <tr>
                   <td width="50%">
                        <div class="form-group">
                            <label class="control-label">Type of LSWDO: </label><font color="red">*</font>

                            <select name="lgu_type_id" id="lgu_type_id" class="form-control" style="width:90%;" onchange="askLGU();" tabindex="1" required autofocus>
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
                  </td>

                  <!--2nd column-->
                     <td width="50%">
                            <div class="form-group">
                                <label for="total_ira">Total Internal Revenue Allotment:</label>
                                <input class="form-control" type="text" name="total_ira" id="total_ira" tabindex="11" maxlength="16" style="width:90%;" value="<?php echo $assessmentinfo_details->total_ira ?>" placeholder="Total Internal Revenue Allotment">
                            </div>
                     </td>
              </tr>

              <tr>
                 <td width="50%">
                            <div id="groupLGUregion">
                                <div class="form-group form-group-sm">
                                    <label for="regionlist" class="control-label">Region: </label><font color="red">*</font>

                                        <fieldset>
                                            <div class="control-group">
                                                <div class="controls">
                                                    <select name="regionlist" id="regionlist" class="form-control" style="width:90%;" onchange="get_prov();" tabindex="2" required>

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
                     </td>

                  <!--2nd column-->
                       <td width="50%">
                           <div class="form-group">
                               <label for="total_budget_lswdo">Total Budget LSWDO:</label>
                               <input class="form-control" type="text" name="total_budget_lswdo" id="total_budget_lswdo" maxlength="16" tabindex="12" style="width:90%;" value="<?php echo $assessmentinfo_details->total_budget_lswdo ?>" placeholder="Total Budget LSWDO">
                            </div>
                       </td>
                  </tr>

                     <tr>
                         <td width="50%">
                            <div id="groupLGUProvince">
                                <div class="form-group form-group-sm">
                                    <label for="provlist" class="control-label">Province:</label><font color="red">*</font>
                                    <div id="div_provlist">
                                        <select id="provlist" name="provlist" class="form-control" style="width:90%;" onChange="get_cities();" tabindex="3" required>
                                            <?php if(isset($assessmentinfo_details->prov_code) or isset($assessmentinfo_details->region_code)) {
                                                ?>
                                                <option value="0">Choose Province</option>
                                                <?php
                                                foreach($provlist as $provselect) { ?>
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
                          </td>

                   <!--2nd column-->
                               <td width="50%">
                                    <div class="form-group">
                                        <label for="no_cities">No. of Cities:</label>
                                        <div id="groupCity">
                                            <div class="control-group">
                                                <div class="controls">
                                                    <input class="form-control" type="text" id="no_cities" name="no_cities" style="width:90%;" value="" placeholder="No. of Cities" readonly>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                              </td>
                       </tr>


                            <input class="form-control" type="hidden" id = "prov_pass" name="prov_pass" style="width:90%;" value ="<?php echo $assessmentinfo_details->prov_code ?>" >
                            <input class="form-control" type="hidden" id = "city_pass" name="city_pass" style="width:90%;" value ="<?php echo $assessmentinfo_details->city_code ?>" >
                    <tr>
                       <td width="50%">
                            <div id="groupLGUCity">
                                <div class="form-group form-group-sm">
                                    <label for="citylist" class="control-label">City/Municipality:</label>
                                    <div id="div_citylist">
                                        <select id="citylist" name="citylist" class="form-control" style="width:90%;" onChange="get_brgy();" tabindex="4">
                                            <?php if(isset($assessmentinfo_details->city_code) or isset($assessmentinfo_details->prov_code)) {
                                                ?>
                                                <option value="0">Choose City/Municipality</option>
                                                <?php
                                                foreach($citylist as $cityselect) { ?>
                                                    <option value="<?php echo $cityselect->city_code; ?>"
                                                        <?php
                                                        if ($cityselect->city_code == $assessmentinfo_details->city_code) {
                                                            echo " selected";
                                                        } ?>
                                                        >
                                                        <?php echo $cityselect->city_code; ?></option>
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

                        </div><!--end of lgu type-->
                </td>

                <!--2nd column-->
                <td width="50%">
                    <div class="form-group">
                        <label for="no_municipalities">No. of Municipalities:</label>
                        <div id="groupmuni">
                            <div class="control-group">
                                <div class="controls">
                                    <input class="form-control" type="text" id="no_muni" name="no_muni" style="width:90%;" value="" placeholder="No. of Municipalities" readonly>
                                </div>
                            </div>
                        </div>
                    </div>
                </td>
                </tr>

                <tr>
                    <td width="50%">
                        <div class="form-group"> <!--^[A-Za-z\s]{1,}[\.]{0,1}[A-Za-z\s]{0,}$--> <!--[a-zA-Z][a-zA-Z0-9\s]*-->
                            <label for="swdo_name">Name of SWDO Officer/Head:</label><font color="red">*</font>
                            <input class="form-control" type="text" name="swdo_name" id="swdo_name" tabindex="5" pattern="^[a-zA-Z][a-zA-Z0-9\s\.]*$" title="Firstname Middlename Lastname" style="width:90%;" value="<?php echo $assessmentinfo_details->swdo_name ?>" placeholder="Name of SWDO Officer/Head" required>
                        </div>
                    </td>

                    <!--2nd column-->
                    <td width="50%">
                        <div class="form-group">
                            <label for="no_brgy">No. of Barangays:</label>
                            <div id="groupbrgy">
                                <div class="control-group">
                                    <div class="controls">
                                        <input class="form-control" type="text" id="no_brgy" name="no_brgy" style="width:90%;" value="" placeholder="No. of Barangays" readonly>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </td>
                </tr>

                <tr>
                    <td width="50%">
                        <div class="form-group">
                            <label for="designation">Designation:</label><font color="red">*</font>
                            <input class="form-control" type="text" name="designation" id="designation" tabindex="6" pattern="^[a-zA-Z][a-zA-Z0-9\s\.]*$" style="width:90%;" value="<?php echo $assessmentinfo_details->designation ?>" placeholder="Designation" required>
                        </div>
                    </td>

                    <!--2nd column-->
                    <td width="50%">
                        <div class="form-group">
                            <label for="income_class">Income Class:</label>
                            <div id="income_class">
                                <div class="control-group">
                                    <div class="controls">
                                        <input class="form-control" type="text" id="income_class" name="income_class" style="width:90%;" value="" placeholder="Income Class" readonly>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </td>
                </tr>

                <tr>
                    <td width="50%">
                        <div class="form-group">
                            <label for="office_address">Office Address:</label><font color="red">*</font>
                            <input class="form-control" type="text" name="office_address" tabindex="7" id="office_address" pattern="^[a-zA-Z0-9\.][a-zA-Z0-9\s\.\,]*$" style="width:90%;" value="<?php echo $assessmentinfo_details->office_address ?>" placeholder="Office Address" required>
                        </div>
                    </td>

                    <!--2nd column-->
                    <td width="50%">
                        <div class="form-group">
                            <label for="total_pop">Total Population:</label>
                            <div id="total_pop">
                                <div class="control-group">
                                    <div class="controls">
                                        <input class="form-control" type="text" id="total_pop" name="total_pop" style="width:90%;" value="" placeholder="Total Population" readonly>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </td>
                </tr>

                <tr>
                    <td width="50%">
                        <div class="form-group">
                            <label for="contact_no">Contact No:</label><font color="red">*</font>
                            <input class="form-control" type="tel" minlength="7" maxlength="19" tabindex="8" name="contact_no" pattern="^(\(?\+?[0-9]*\)?)?[0-9_\- \(\)]*$" id="contact_no" style="width:90%;" value="<?php echo $assessmentinfo_details->contact_no ?>" placeholder="Contact Number" required>
                        </div>
                    </td>

                    <!--2nd column -->
                    <td width="50%">
                        <div class="form-group">
                            <label for="total_poor">Total No. of Poor Families:</label>
                            <div id="total_poor">
                                <div class="control-group">
                                    <div class="controls">
                                        <input class="form-control" type="text" id="total_poor" name="total_poor" style="width:90%;" value="" placeholder="Total No. of Poor Families" readonly>
                                    </div>
                                </div>
                            </div>
                    </td>
                </tr>

                <tr>
                    <td width="50%">
                    <!--grace -nilagay ko ung type nya is "tel" accepted na nya ung dash pero hindi siya automatic naglalgay ng dash, minlength nya 7 at maxlength 19 kasi merong dalawang contact number na nilalagay sila-->
                        <div class="form-group">
                            <label for="email">Email Address:</label>
                            <input class="form-control" type="email" name="email" id="email" tabindex="9" style="width:90%;" value="<?php echo $assessmentinfo_details->email ?>" placeholder="Email">
                        </div>
                    </td>

                    <!--2nd column-->
                    <td width="50%">
                        <div class="form-group">
                            <label for="legend">Legend:<font color="red"><br/> *</font> - required field/s</label>
                        </div>
                    </td>
                </tr>

                <tr>
                    <td width="50%">
                        <div class="form-group">
                            <label for="website">Website:</label>
                            <input class="form-control" type="text" name="website" id="website" tabindex="10" pattern="www.+.com" title="www.sample.com" style="width:90%;" value="<?php echo $assessmentinfo_details->website ?>" placeholder="Website">
                        </div>
                    </td>
                </tr>
     </table>
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