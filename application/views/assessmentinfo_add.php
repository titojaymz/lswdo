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

</script>

<body>
<div class="content">

    <!-- Start Page Header -->
    <div class="page-header">

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
                    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" class="form-horizontal">
                        <div class="form-group">
                            <label for="geo_info" class="control-label">Geographic Information: Identifying Information</label>
                        </div>
                    <table style="width:100%">
                        <tr>
                            <td width="50%">
                                <div class="form-group">
                                  <label class="control-label">Status of Application:</label>
                                   <select class="form-control" name="application_type" id="application_type" style="width:90%;" disabled>
                                        <option selected value="1">Please select</option>
                                         <?php foreach($application as $applications): ?>
                                         <option <?php if ($applications->application_type_id==1)
                                            {
                                          echo "selected";
                                           }
                                        ?> value="<?php echo $applications->application_type_id ?>"><?php echo $applications->application_type_name ?></option>
                                   <?php endforeach ?>
                            </select>
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

                            <select class="form-control" name="application_type_id" id="application_type_id" style="display:none;width:90%;">
                                <option selected value="1">Please select</option>
                                <?php foreach($application as $applications): ?>
                                    <option <?php if ($applications->application_type_id==1)
                                    {
                                        echo "selected";
                                    }
                                    ?> value="<?php echo $applications->application_type_id ?>"><?php echo $applications->application_type_name ?></option>
                                <?php endforeach ?>
                            </select>

                        <tr>
                            <td width="50%">
                                <div class="form-group">
                                   <label class="control-label">Type of LSWDO:</label><font color="red">*</font>
                                   <!--Select-->
                                <select id="lgu_type_id" name="lgu_type_id" class="form-control" style="width:90%;" onchange="askLGU();" tabindex="1" required autofocus>
                                    <option select value="">Please select</option>
                                    <?php foreach($lgu_type as $lgus): ?>
                                        <option value="<?php echo $lgus->lgu_type_id ?>"><?php echo $lgus->lgu_type_name ?></option>
                                    <?php endforeach ?>
                                </select>
                                 </div>
                            </td>

                            <!--2nd column-->
                            <td width="50%">
                                <div class="form-group">
                                <label for="total_ira">Total Internal Revenue Allotment:</label>
                                <input type="text" name="total_ira" tabindex="11" id="total_ira" maxlength="16" value="<?php echo set_value('total_ira') ?>" style="width:90%;" placeholder="Total Internal Revenue Allotment">
                                </div>
                            </td>
                        </tr>

                        <tr>
                            <td width="50%">
                                <!--Region-->
                                <div id="groupLGUregion">
                                    <div class="form-group form-group-sm">
                                        <label for="regionlist" class="control-label"> Region:</label><font color="red">*</font>
                                                <div class="control-group">
                                                    <div class="controls">
                                                        <select name="regionlist" id="regionlist" class="form-control" style="width:90%;" onChange="get_provinces();" tabindex="2" required>
                                                            <option value="">Choose Region</option>
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
                           </td>

                            <!--2nd column-->
                            <td width="50%">
                                <div class="form-group">
                                <label for="total_budget_lswdo">Total Budget LSWDO:</label>
                                <input class="form-control" type="text" id = "total_budget_lswdo" name="total_budget_lswdo" maxlength="16" tabindex="12" value="<?php echo set_value('total_budget_lswdo') ?>" style="width:90%;" placeholder="Total Budget LSWDO">
                               </div>
                            </td>

                        </tr>
                        <!--END Region-->

                        <tr>
                            <td width="50%">
                                <!--Province-->
                                <div id="groupLGUProvince">
                                    <div class="form-group form-group-sm">
                                        <label for="provlist" class="control-label">Province:</label><font color="red">*</font>
                                        <div id="div_provlist">
                                            <select id="provlist" name="provlist" class="form-control" style="width:90%;" onChange="get_cities();" tabindex="3" required>
                                                <?php if(isset($_SESSION['province']) or isset($_SESSION['region'])) {
                                                    ?>
                                                    <option value="">Choose Province</option>
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
                            </td>

                            <!--2nd column-->
                            <td width="50%">
                                <div class="form-group">
                                <label for="nocitylist"> No. of Cities:</label>
                                <div id="groupCity">
                                    <div class="control-group">
                                        <div class="controls">
                                            <input class="form-control" type="text" name="no_cities" style="width:90%;" placeholder="No. of Cities" readonly>
                                        </div>
                                    </div>
                                </div>
                                    </div>
                            </td>
                        </tr>
                        <!--End Province-->

                        <tr>
                            <td width="50%">
                                <!--City-->
                                <div id="groupLGUCity">
                                    <div class="form-group form-group-sm">
                                        <label for="citylist" class="control-label">City/Municipality:</label>
                                        <div id="div_citylist">
                                            <select id="citylist" name="citylist" class="form-control" style="width:90%;" tabindex="4">
                                                <?php if(isset($_SESSION['city']) or isset($_SESSION['province'])) {
                                                    ?>
                                                    <option value="">Choose City/Municipality</option>
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
                                                    <option value="">Select Province First</option>
                                                    <?php
                                                } ?>
                                            </select>
                                        </div>
                                    </div>

                                </div> <!--End Select-->
                             </td>

                            <!--2nd column-->
                            <td width="50%">
                                <div class="form-group">
                                <label for="no_muni_code">No. of Municipalities:</label>
                                <div id="groupmuni">
                                    <div class="control-group">
                                        <div class="controls">
                                            <input class="form-control" type="text" name="no_muni" style="width:90%;" placeholder="No. of Municipalities" readonly>
                                        </div>
                                    </div>
                                </div>
                                </div>
                            </td>
                        </tr>

                           <tr>
                               <td width="50%">
                                   <div class="form-group">
                                   <label for="swdo_name">Name of SWDO Officer/Head:</label><font color="red">*</font>
                                   <input class="form-control" type="text" name="swdo_name" pattern="^[a-zA-Z][a-zA-Z0-9\s\.]*$" title="Firstname Middlename Lastname" tabindex="5" value="<?php echo set_value('swdo_name') ?>" style="width:90%;" placeholder="Name of SWDO Officer/Head" required>
                                     </div>
                               </td>

                               <!--2nd column-->
                               <td width="50%">
                                   <div class="form-group">
                                   <label for="no_brgy">No. of Barangays:</label>
                                   <div id="groupbrgy">
                                       <div class="control-group">
                                           <div class="controls">
                                               <input class="form-control" type="text" name="no_brgy" style="width:90%;" placeholder="No. of Barangays" readonly>
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
                                <input class="form-control" type="text" name="designation" tabindex="6" pattern="^[a-zA-Z][a-zA-Z0-9\s\.]*$" value="<?php echo set_value('designation') ?>" style="width:90%;" placeholder="Designation" required>
                                 </div>
                            </td>

                            <!--2nd column-->
                            <td width="50%">
                                <div class="form-group">
                                <label for="income_class">Income Class:</label>
                                <div id="income_class">
                                    <div class="control-group">
                                        <div class="controls">

                                            <input class="form-control" type="text" name="income_class" style="width:90%;" placeholder="Income Class" readonly>
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
                                 <input class="form-control" type="text" name="office_address" tabindex="7" pattern="^[a-zA-Z0-9\.][a-zA-Z0-9\s\.\,]*$" title="95 JayLee Street, Sofia Subdivision Del Pilar, San Fernando City 2000 Pampanga" value="<?php echo set_value('office_address') ?>" style="width:90%;" placeholder="Office Address" required>
                                  </div>
                             </td>

                             <!--2nd column-->
                             <td width="50%">
                                 <div class="form-group">
                                 <label for="total_pop">Total Population:</label>
                                 <div id="total_pop">
                                     <div class="control-group">
                                         <div class="controls">
                                             <input class="form-control" type="text" name="total_pop" style="width:90%;" placeholder="Total Population" readonly>
                                         </div>
                                     </div>
                                 </div>
                                 </div>
                             </td>
                          </tr>

                        <tr>
                            <td width="50%">
                                <div class="form-group">
                                <label for="contact_no">Contact No:*</label><font color="red">*</font>
                                <input class="form-control" type="tel" minlength="7" maxlength="19" pattern="^(\(?\+?[0-9]*\)?)?[0-9_\- \(\)]*$" tabindex="8" name="contact_no" value="<?php echo set_value('contact_no') ?>" style="width:90%;" placeholder="Contact Number" required>
                                </div>
                            </td>

                            <!--2nd column -->
                            <td width="50%">
                                <div class="form-group">
                                <label for="total_poor">Total No. of Poor Families:</label>
                                <div id="total_poor">
                                    <div class="control-group">
                                        <div class="controls">
                                            <input class="form-control" type="text" name="total_poor" style="width:90%;" value="" placeholder="Total No. of Poor Families" readonly>
                                        </div>
                                    </div>
                                </div>
                                </div>
                            </td>
                         </tr>

                         <tr>
                             <td width="50%">
                                 <div class="form-group">
                                 <label for="email">Email Address:</label>
                                 <input class="form-control" type="email" name="email" tabindex="9" value="<?php echo set_value('email') ?>" placeholder="Email Address" style="width:90%;">
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
                                 <input class="form-control" type="text" name="website" tabindex="10" pattern="www.+.com" title="www.sample.com" value="<?php echo set_value('website') ?>" placeholder="Website" style="width:90%;">
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