<script type="text/javascript">
   /* function askCol() {
        var e = document.getElementById("pantawid_hh_id").value;
        if (e == 1) {
            document.getElementById("groupHHID").style.display = "block";
            document.getElementById("groupHHID").style.visibility = "visible";
        } else {
            document.getElementById("groupHHID").style.display = "none";
            document.getElementById("groupHHID").style.visibility = "hidden";
            document.getElementById("pantawid_hh_id_text").value = "";
        }
    }*/
    function get_prov() {
        var region_code = $('#regionlist').val();
        echo $region_code;
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
    function get_city() {
        var prov_code = $('#provlist').val();
        $('#brgylist option:gt(0)').remove().end();
        if(prov_code > 0) {
            $.ajax({
                url: "<?php echo base_url('assessmentinfo/populate_city'); ?>",
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
    function get_type() {
        var type_code = $('#typelist').val();
        $('#citylist option:gt(0)').remove().end();
        $('#brgylist option:gt(0)').remove().end();
        if(type_code > 0) {
            $.ajax({
                url: "<?php echo base_url('assessmentinfo/populate_type'); ?>",
                async: false,
                type: "POST",
                data: "type_code="+type_code,
                dataType: "html",
                success: function(data) {
                    $('#div_typelist').html(data);
                }
            });
        } else {
            $('#typelist option:gt(0)').remove().end();
        }
    }

</script>
<br>
<div class="modal-body">
    <div class="container">
        <div class="row">
            <div class="col-lg-6 col-sm-6 "> <!--edited form -->
                <h1>Add Assessment of Functionality </h1>

                <?php
                $attributes = array("class" => "form-horizontal", "id" => "assessmentinfoform", "name" => "assessmentinfoform");
                //input here the next location when click insert
                echo form_open("assessmentinfo/addAssessmentinfo", $attributes);?>
                <fieldset>
                    <?php /*-------------------------------------------------SAC-------------------------------------------------------------------- */  ?>
                    <!--
                    <div class="form-group form-group-sm">
                        <div class="col-lg-6 col-sm-6 ">
                               <h5> Encoder's Information </h5>
                            </div>

                    </div>
                    <div class="form-group form-group-sm">
                                         <div class="col-lg-4 col-sm-4">
                                      <label for="f_name" class="control-label">First Name*: </label>
                                       </div>
                                       <div class="col-lg-6 col-sm-6">
                                           <input id="f_name" name="f_name" placeholder="First Name" type="text" class="form-control"  value="<?php //echo set_value('f_name'); ?>" required autofocus/>
                                          <span class="text-danger"><?php //echo form_error('f_name'); ?></span>
                                          </div>

                                      <div class="col-lg-4 col-sm-4">
                                        <label for="f_name" class="control-label">Last Name*:</label>
                                     </div>
                                     <div class="col-lg-6 col-sm-6">
                                      <input id="f_name" name="f_name" placeholder="Last Name" type="text" class="form-control"  value="<?php //echo set_value('f_name'); ?>" required autofocus/>
                                       <span class="text-danger"><?php //echo form_error('l_name'); ?></span>
                                      </div>
                    </div>-->
                    <div class="form-group form-group-sm">
                        <div class="col-lg-6 col-sm-6 ">
                            <h5> Geographic Information </h5>
                        </div>
                    </div>
                    <div class="form-group form-group-sm">
                        <div class="col-lg-6 col-sm-6 ">
                            <label for="stat_app" class="control-label"> Status of Application: </label>
                        </div>
                        <div class="col-lg-6 col-sm-6">
                            <select class="selectpicker" name="stat_app">
                                <option data-icon="fa fa-check" value="1">New</option>
                                <option data-icon="fa fa-close" value="0">Renewal</option>
                            </select>
                        </div>
                        <div class="col-lg-6 col-sm-6">
                            <label for="cert_no" class="control-label">Certificate Number:</label>
                        </div>
                        <div class="col-lg-6 col-sm-6">
                            <input id="cert_no" name="cert_no" placeholder="Certificate Number" type="text" class="form-control"  value="<?php echo set_value('cert_no'); ?>"/>
                            <span class="text-danger"><?php echo form_error('cert_no'); ?></span>
                        </div>
                        <div class="col-lg-4 col-sm-4">
                            <label for="dt_issued" class="control-label">Date Issued:</label>
                        </div>
                        <div class="col-lg-6 col-sm-6">
                            <div class="control-group">
                                <div class="controls">

                                    <div class="input-prepend input-group">
                                        <span class="add-on input-group-addon"><i class="fa fa-calendar"></i></span>
                                        <input type="date" value="2011-01-13" id="date-picker" name="dt_issued" class="form-control" placeholder="MM/DD/YYYY"/>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-sm-4">
                            <label for="validity" class="control-label">Validity:</label>
                        </div>
                        <div class="col-lg-6 col-sm-6">
                            <input id="validity" name="f_name" placeholder="Validity" type="text" class="form-control"  value="<?php echo set_value('validity'); ?>" required autofocus/>
                            <span class="text-danger"><?php echo form_error('validity'); ?></span>
                        </div>
                    </div>
                    <?php /*-------------------------------------------------SAM-------------------------------------------------------------------- */  ?>
                    <div class="form-group form-group-sm">
                        <div class="col-lg-6 col-sm-6">
                            <label for="stat_mon" class="control-label">Status of Monitoring/Date:</label>
                        </div>
                    </div>

                    <div class="form-group form-group-sm">
                        <div class="col-lg-4 col-sm-4">
                            <label for="first_visit" class="control-label">Count of Visit: </label>
                        </div>
                        <div class="col-lg-6 col-sm-6">
                            <div class="control-group">
                                <div class="controls">
                                    <input id="visit_count" name="f_name" placeholder="Count of Visit" type="text" class="form-control"  value="<?php echo set_value('visit_count'); ?>" required autofocus/>
                                    <span class="text-danger"><?php echo form_error('visit_count'); ?></span>
                                    <div class="input-prepend input-group">
                                        <span class="add-on input-group-addon"><i class="fa fa-calendar"></i></span>
                                        <input type="date" value="2011-01-13" id="date-picker" name="first_visit" class="form-control" placeholder="MM/DD/YYYY"/>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--
                            <div class="col-lg-4 col-sm-4">
                                <label for="second_visit" class="control-label">2nd Visit:</label>
                            </div>
                            <div class="col-lg-6 col-sm-6">
                                <div class="control-group">
                                    <div class="controls">

                                        <div class="input-prepend input-group">
                                            <span class="add-on input-group-addon"><i class="fa fa-calendar"></i></span>
                                            <input type="date" value="2011-01-13" id="date-picker" name="second_visit" class="form-control" placeholder="MM/DD/YYYY"/>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4 col-sm-4">
                                <label for="third_visit" class="control-label">3rd Visit:</label>
                            </div>
                            <div class="col-lg-6 col-sm-6">
                                <div class="control-group">
                                    <div class="controls">

                                        <div class="input-prepend input-group">
                                            <span class="add-on input-group-addon"><i class="fa fa-calendar"></i></span>
                                            <input type="date" value="2011-01-13" id="date-picker" name="third_visit" class="form-control" placeholder="MM/DD/YYYY"/>
                                        </div>
                                    </div>
                                </div>
                            </div> -->
                    </div>

                    <?php /*-------------------------------------------------II-------------------------------------------------------------------- */  ?>
                    <div class="form-group form-group-sm">
                        <div class="col-lg-6 col-sm-6">
                            <label for="identify_info" class="control-label">Identifying Information:</label>
                        </div>
                    </div>
                    <div class="form-group form-group-sm">
                        <div class="col-lg-4 col-sm-4">
                            <label for="typelist" class="col-lg-2 control-label">Type of LSWDO:</label>
                        </div>
                        <div class="col-lg-8 col-sm-6">
                            <select name="typelist" id="type" class="form-control" onchange="get_type();">
                                <option value="0"> Choose Type of LSWDO </option>
                                <!-- <?php //foreach($typelist as $typeselect): ?>
                                    <option value="<?php //echo $typeselect->type; ?>"
                                        <?php //if(isset($_SESSION['type'])) {
                                // if($typeselect->type_code == $_SESSION['type']) {
                                // echo " selected";
                                //  }
                                //   } ?>
                                        >
                                        <?php //echo $typeselect->type_name; ?>
                                    </option>
                                <?php //endforeach; ?> -->
                            </select>
                        </div>
                    </div>
                    <!--
                    <div class="form-group form-group-sm">
                        <div class="col-lg-4 col-sm-4">
                        <label for="regionlist" class="col-lg-2 control-label">Region:</label>
                            </div>
                        <div class="col-lg-8 col-sm-6">
                                <select name="regionlist" id="regionlist" class="form-control" onchange="get_regions();">
                                    <option value="0"> Choose Region </option>
                                    <?php //foreach($regionlist as $regionselect): ?>
                                        <option value="<?php //echo $regionselect->region_code; ?>"
                                            <?php //if(isset($_SESSION['region'])) {
                    //if($regionselect->region_code == $_SESSION['region']) {
                    //     echo " selected";
                    //  }
                    //   } ?>
                                            >
                                            <?php// echo $regionselect->region_name; ?>
                                        </option>
                                    <?php //endforeach; ?>
                                </select>
                            </div>
                            </div>-->
                    <div class="form-group form-group-sm">
                        <div class="col-lg-4 col-sm-4">
                            <label for="lgu_typelist" class="col-lg-6 control-label">LGU Type:</label>
                        </div>
                        <div class="col-lg-10 col-sm-8">
                            <select name="lgu_typelist" id="lgu_typelist" class="form-control"">
                            <option value="0">-Please select-</option>
                            <?php foreach($lgu_typelist as $lgu_typeselect): ?>
                                <option value="<?php echo $lgu_typeselect->lgu_type_id; ?>"
                                    <?php if(isset($_SESSION['lgu_type'])) {
                                        if($lgu_typeselect->lgu_type_id == $lgu_typeselect->lgu_type_id) {
                                            echo " selected";
                                        }
                                    } ?>
                                    >
                                    <?php echo $lgu_typeselect->lgu_type_name; ?>
                                </option>
                            <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group form-group-sm">
                        <div class="col-lg-4 col-sm-4">
                            <label for="regionlist" class="col-lg-6 control-label">Region:</label>
                        </div>
                        <div class="col-lg-10 col-sm-8">
                            <select id="regionlist" name="regionlist" class="form-control" onChange="get_regions();">
                                <?php if(isset($_SESSION['region']) or isset($_SESSION['region'])) {
                                    ?>
                                    <option value="0">Choose Region</option>
                                    <?php
                                    foreach ($regionlist as $regionselect) { ?>
                                        <option value="<?php echo $regionselect->region_code; ?>"
                                            <?php
                                            if (isset($_SESSION['region']) and $regionselect->region_code== $_SESSION['region']) {
                                                echo " selected";
                                            } ?>
                                            >
                                            <?php echo $regionselect->region_name; ?></option>
                                        <?php
                                    }
                                } else {
                                    ?>
                                    <option>Select Type First</option>
                                    <?php
                                } ?>
                            </select>
                        </div>
                    </div>

                    <div class="form-group form-group-sm">
                        <div class="col-lg-4 col-sm-4">
                            <label for="provlist" class="col-lg-6 control-label">Province:</label>
                        </div>
                        <div class="col-lg-10 col-sm-8">
                            <select id="provlist" name="provlist" class="form-control" onChange="get_prov();">
                                <?php if(isset($_SESSION['province']) or isset($_SESSION['region'])) {
                                    ?>
                                    <option value="0">Choose Province</option>
                                    <?php
                                    foreach ($provlist as $provselect) { ?>
                                        <option value="<?php echo $provselect->id_province; ?>"
                                            <?php
                                            if (isset($_SESSION['province']) and $provselect->id_province== $_SESSION['province']) {
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

                    <div class="form-group form-group-sm">
                        <label for="citylist" class="col-lg-2 control-label">City/Municipality:</label>
                        <div id="div_citylist" class="col-lg-8">
                            <select id="citylist" name="citylist" onchange="get_brgy();" class="form-control">
                                <?php if(isset($_SESSION['city']) or isset($_SESSION['muni']) or isset($_SESSION['province'])) {
                                    ?>
                                    <option value="0">Choose the City</option>
                                    <?php
                                    foreach (citylist as $cityselect) { ?>
                                        <option value="<?php echo $cityselect->id_city; ?>"
                                            <?php
                                            if (isset($_SESSION['city']) and $cityselect->id_city== $_SESSION['city']) {
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
                    <div class="form-group form-group-sm">
                        <div class="col-lg-6 col-sm-6">
                            <label for="no_city" class="control-label">Number of Cities:</label>
                        </div>
                        <div class="col-lg-6 col-sm-6">
                            <input id="no_city" name="no_city" placeholder="Number of Cities" type="text" class="form-control"  value="<?php echo set_value('no_city'); ?>" required autofocus readonly=""true" />
                            <span class="text-danger"><?php echo form_error('no_city'); ?></span>
                        </div>
                        <div class="col-lg-6 col-sm-6">
                            <label for="no_muni" class="control-label">Number of Municipalities:</label>
                        </div>
                        <div class="col-lg-6 col-sm-6">
                            <input id="no_muni" name="no_muni" placeholder="Number of Municipalities" type="text" class="form-control"  value="<?php echo set_value('no_muni'); ?>" required autofocus readonly=""true"/>
                            <span class="text-danger"><?php echo form_error('no_muni'); ?></span>
                        </div>
                        <div class="col-lg-6 col-sm-6">
                            <label for="no_brgy" class="control-label">Number of Barangays:</label>
                        </div>
                        <div class="col-lg-6 col-sm-6">
                            <input id="no_brgy" name="no_brgy" placeholder="Number of Barangays" type="text" class="form-control"  value="<?php echo set_value('no_brgy'); ?>" required autofocus readonly=""true"/>
                            <span class="text-danger"><?php echo form_error('no_brgy'); ?></span>
                        </div>
                    </div>

                    <div class="form-group form-group-sm">
                        <div class="col-lg-4 col-sm-4">
                            <label for="income_class" class="control-label"> Income Class: </label>
                        </div>
                        <div class="col-lg-4 col-sm-4">
                            <select class="selectpicker" name="income_class">
                                <option data-icon="fa fa-check" value="0">-</option>
                                <option data-icon="fa fa-close" value="1">1st Class</option>
                                <option data-icon="fa fa-close" value="2">2nd Class</option>
                                <option data-icon="fa fa-close" value="3">3rd Class</option>
                                <option data-icon="fa fa-close" value="4">4th Class</option>
                                <option data-icon="fa fa-close" value="5">5th Class</option>
                                <option data-icon="fa fa-close" value="5">6th Class</option>
                            </select>
                        </div>
                        <div class="col-lg-6 col-sm-6">
                            <label for="tot_pop" class="control-label">Total Population:</label>
                        </div>
                        <div class="col-lg-6 col-sm-6">
                            <input id="tot_pop" name="tot_pop" placeholder="Total Population" type="text" class="form-control"  value="<?php echo set_value('tot_pop'); ?>" required autofocus/>
                            <span class="text-danger"><?php echo form_error('tot_pop'); ?></span>
                        </div>
                        <div class="col-lg-6 col-sm-6">
                            <label for="tot_poor" class="control-label">Total No. of Poor Families:</label>
                        </div>
                        <div class="col-lg-6 col-sm-6">
                            <input id="tot_poor" name="tot_poor" placeholder="Total No. of Poor Families" type="text" class="form-control"  value="<?php echo set_value('tot_poor'); ?>" required autofocus/>
                            <span class="text-danger"><?php echo form_error('tot_poor'); ?></span>
                        </div>
                    </div>

                    <?php /*-------------------------------------------------Below-------------------------------------------------------------------- */  ?>
                    <div class="form-group form-group-sm">
                        <div class="col-lg-6 col-sm-6">
                            <label for="pcmswdo_name" class="control-label">Name of P/C/MSWDO Head:</label>
                        </div>
                        <div class="col-lg-6 col-sm-6">
                            <input id="pcmswdo_name" name="pcmswdo_name" placeholder="Name of P/C/MSWDO Head" type="text" class="form-control"  value="<?php echo set_value('pcmswdo_name'); ?>" required autofocus/>
                            <span class="text-danger"><?php echo form_error('pcmswdo_name'); ?></span>
                        </div>
                        <div class="col-lg-6 col-sm-6">
                            <label for="designation" class="control-label">Designation:</label>
                        </div>
                        <div class="col-lg-6 col-sm-6">
                            <input id="designation" name="designation" placeholder="Designation" type="text" class="form-control"  value="<?php echo set_value('designation'); ?>" required autofocus/>
                            <span class="text-danger"><?php echo form_error('designation'); ?></span>
                        </div>

                        <div class="col-lg-6 col-sm-6">
                            <label for="office_addr" class="control-label">Office Address:</label>
                        </div>
                        <div class="col-lg-6 col-sm-6">
                            <input id="office_addr" name="office_addr" placeholder="Office Address" type="text-area" class="form-control"  value="<?php echo set_value('office_addr'); ?>" required autofocus/>
                            <span class="text-danger"><?php echo form_error('office_addr'); ?></span>
                        </div>

                        <div class="col-lg-6 col-sm-6">
                            <label for="tel_no" class="control-label">Telephone/Mobile/Fax No/s:</label>
                        </div>
                        <div class="col-lg-6 col-sm-6">
                            <input id="tel_no" name="tel_no" placeholder="Telephone/Mobile/Fax No/s" type="text" class="form-control"  value="<?php echo set_value('tel_no'); ?>" required autofocus/>
                            <span class="text-danger"><?php echo form_error('tel_no'); ?></span>
                        </div>

                        <div class="col-lg-6 col-sm-6">
                            <label for="email" class="control-label">E-mail Address:</label>
                        </div>
                        <div class="col-lg-6 col-sm-6">
                            <input id="email" name="email" placeholder="E-mail Address" type="text" class="form-control"  value="<?php echo set_value('email'); ?>" required autofocus/>
                            <span class="text-danger"><?php echo form_error('email'); ?></span>
                        </div>
                        <div class="col-lg-6 col-sm-6">
                            <label for="website" class="control-label">Website:</label>
                        </div>
                        <div class="col-lg-6 col-sm-6">
                            <input id="website" name="website" placeholder="Website" type="text" class="form-control"  value="<?php echo set_value('website'); ?>" required autofocus/>
                            <span class="text-danger"><?php echo form_error('website'); ?></span>
                        </div>
                    </div>
                    <?php /*-------------------------------------------------Budget Allocation and Utilization-------------------------------------------------------------------- */  ?>
                    <div class="form-group form-group-sm">
                        <div class="col-lg-8 col-sm-8">
                            <label for="budget_allocation" class="control-label">Budget Allocation and Utilization</label>
                        </div>
                    </div>

                    <div class="form-group form-group-sm">
                        <div class="col-lg-4 col-sm-6">
                            <label for="tot_ira" class="control-label">Total IRA of the Province/Municipality/City: </label>
                        </div>
                        <div class="col-lg-6 col-sm-6">
                            <input type="date" value="2014" id="date-picker" name="Total IRA" class="form-control" placeholder="YYYY" required autofocus/>
                            <span class="text-danger"><?php echo form_error('tot_ira'); ?></span>
                        </div>
                    </div>
                    <div class="form-group form-group-sm">
                        <div class="col-lg-4 col-sm-6">
                            <label for="tot_budget" class="control-label">Total Approved Budget Allocated for the LSWDO for the Year:</label>
                        </div>
                        <div class="col-lg-6 col-sm-6">
                            <input id="tot_budget" name="tot_budget" placeholder="Total Approved Budget" type="text" class="form-control"  value="<?php echo set_value('tot_budget'); ?>" required autofocus/>
                            <span class="text-danger"><?php echo form_error('tot_budget'); ?></span>
                        </div>
                    </div>
                    <?php /*-------------------------------------------------Total Budget Allocated to Programs and Services per Sector-------------------------------------------------------------------- */  ?>
                    <div class="form-group form-group-sm">
                        <div class="col-lg-12 col-sm-12">
                            <label for="tot_budget_programs" class="control-label">Total Budget Allocated to Programs and Services per Sector</label>
                        </div>
                    </div>
                    <div class="form-group form-group-sm">
                        <div class="col-lg-4 col-sm-4">
                            <label for="children" class="control-label">Children</label>
                        </div>
                    </div>
                    <div class="form-group form-group-sm">
                        <div class="col-lg-4 col-sm-6">
                            <label for="child_budget_prev" class="control-label">Budget from the Previous Year (Children)</label>
                        </div>
                        <div class="col-lg-6 col-sm-6">
                            <input id="child_budget_prev" name="child_budget_prev" placeholder="Budget from the Previous Year" type="text" class="form-control"  value="<?php echo set_value('child_budget_prev'); ?>" required autofocus/>
                            <span class="text-danger"><?php echo form_error('child_budget_prev'); ?></span>
                        </div>
                    </div>
                    <div class="form-group form-group-sm">
                        <div class="col-lg-6 col-sm-6">
                            <label for="child_util" class="control-label">Utilization (Children)</label>
                        </div>
                        <div class="col-lg-6 col-sm-6">
                            <input id="child_util" name="child_util" placeholder="Utilization" type="text" class="form-control"  value="<?php echo set_value('child_util'); ?>" required autofocus/>
                            <span class="text-danger"><?php echo form_error('child_util'); ?></span>
                        </div>
                    </div>
                    <div class="form-group form-group-sm">
                        <div class="col-lg-6 col-sm-6">
                            <label for="child_ben_served" class="control-label">Number of beneficiaries served (Children)</label>
                        </div>
                        <div class="col-lg-6 col-sm-6">
                            <input id="child_ben_served" name="child_ben_served" placeholder="Number of beneficiaries served" type="text" class="form-control"  value="<?php echo set_value('child_ben_served'); ?>" required autofocus/>
                            <span class="text-danger"><?php echo form_error('child_ben_served'); ?></span>
                        </div>
                    </div>
                    <div class="form-group form-group-sm">
                        <div class="col-lg-6 col-sm-6">
                            <label for="child_budget_pres" class="control-label">Budget for the Present Year (Children)</label>
                        </div>
                        <div class="col-lg-6 col-sm-6">
                            <input id="child_budget_pres" name="child_budget_pres" placeholder="Budget for the Present Year" type="text" class="form-control"  value="<?php echo set_value('child_budget_pres'); ?>" required autofocus/>
                            <span class="text-danger"><?php echo form_error('child_budget_pres'); ?></span>
                        </div>
                    </div>
                    <div class="form-group form-group-sm">
                        <div class="col-lg-6 col-sm-6">
                            <label for="child_trgt_ben" class="control-label">Number of Target Beneficiaries (Children)</label>
                        </div>
                        <div class="col-lg-6 col-sm-6">
                            <input id="child_trgt_ben" name="child_trgt_ben" placeholder="Number of Target Beneficiaries" type="text" class="form-control"  value="<?php echo set_value('child_trgt_ben'); ?>" required autofocus/>
                            <span class="text-danger"><?php echo form_error('child_trgt_ben'); ?></span>
                        </div>
                    </div>
                    <?php /*----------------------Youth-------------------------------- */  ?>
                    <div class="form-group form-group-sm">
                        <div class="col-lg-4 col-sm-4">
                            <label for="youth" class="control-label">Youth</label>
                        </div>
                    </div>
                    <div class="form-group form-group-sm">
                        <div class="col-lg-4 col-sm-6">
                            <label for="youth_budget_prev" class="control-label">Budget from the Previous Year (Youth)</label>
                        </div>
                        <div class="col-lg-6 col-sm-6">
                            <input id="youth_budget_prev" name="youth_budget_prev" placeholder="Budget from the Previous Year" type="text" class="form-control"  value="<?php echo set_value('youth_budget_prev'); ?>" required autofocus/>
                            <span class="text-danger"><?php echo form_error('youth_budget_prev'); ?></span>
                        </div>
                    </div>
                    <div class="form-group form-group-sm">
                        <div class="col-lg-6 col-sm-6">
                            <label for="youth_util" class="control-label">Utilization (Youth)</label>
                        </div>
                        <div class="col-lg-6 col-sm-6">
                            <input id="youth_util" name="youth_util" placeholder="Utilization" type="text" class="form-control"  value="<?php echo set_value('youth_util'); ?>" required autofocus/>
                            <span class="text-danger"><?php echo form_error('youth_util'); ?></span>
                        </div>
                    </div>
                    <div class="form-group form-group-sm">
                        <div class="col-lg-6 col-sm-6">
                            <label for="youth_ben_served" class="control-label">Number of beneficiaries served (Youth)</label>
                        </div>
                        <div class="col-lg-6 col-sm-6">
                            <input id="youth_ben_served" name="youth_ben_served" placeholder="Number of beneficiaries served" type="text" class="form-control"  value="<?php echo set_value('youth_ben_served'); ?>" required autofocus/>
                            <span class="text-danger"><?php echo form_error('youth_ben_served'); ?></span>
                        </div>
                    </div>
                    <div class="form-group form-group-sm">
                        <div class="col-lg-6 col-sm-6">
                            <label for="youth_budget_pres" class="control-label">Budget for the Present Year (Youth)</label>
                        </div>
                        <div class="col-lg-6 col-sm-6">
                            <input id="youth_budget_pres" name="youth_budget_pres" placeholder="Budget for the Present Year" type="text" class="form-control"  value="<?php echo set_value('youth_budget_pres'); ?>" required autofocus/>
                            <span class="text-danger"><?php echo form_error('youth_budget_pres'); ?></span>
                        </div>
                    </div>
                    <div class="form-group form-group-sm">
                        <div class="col-lg-6 col-sm-6">
                            <label for="youth_trgt_ben" class="control-label">Number of Target Beneficiaries (Youth)</label>
                        </div>
                        <div class="col-lg-6 col-sm-6">
                            <input id="youth_trgt_ben" name="youth_trgt_ben" placeholder="Number of Target Beneficiaries" type="text" class="form-control"  value="<?php echo set_value('youth_trgt_ben'); ?>" required autofocus/>
                            <span class="text-danger"><?php echo form_error('youth_trgt_ben'); ?></span>
                        </div>
                    </div>

                    <?php /*----------------------Women-------------------------------- */  ?>
                    <div class="form-group form-group-sm">
                        <div class="col-lg-4 col-sm-4">
                            <label for="women" class="control-label">Women</label>
                        </div>
                    </div>
                    <div class="form-group form-group-sm">
                        <div class="col-lg-4 col-sm-6">
                            <label for="women_budget_prev" class="control-label">Budget from the Previous Year (Women)</label>
                        </div>
                        <div class="col-lg-6 col-sm-6">
                            <input id="women_budget_prev" name="women_budget_prev" placeholder="Budget from the Previous Year" type="text" class="form-control"  value="<?php echo set_value('women_budget_prev'); ?>" required autofocus/>
                            <span class="text-danger"><?php echo form_error('women_budget_prev'); ?></span>
                        </div>
                    </div>
                    <div class="form-group form-group-sm">
                        <div class="col-lg-6 col-sm-6">
                            <label for="women_util" class="control-label">Utilization (Women)</label>
                        </div>
                        <div class="col-lg-6 col-sm-6">
                            <input id="women_util" name="women_util" placeholder="Utilization" type="text" class="form-control"  value="<?php echo set_value('women_util'); ?>" required autofocus/>
                            <span class="text-danger"><?php echo form_error('women_util'); ?></span>
                        </div>
                    </div>
                    <div class="form-group form-group-sm">
                        <div class="col-lg-6 col-sm-6">
                            <label for="women_ben_served" class="control-label">Number of beneficiaries served (Women)</label>
                        </div>
                        <div class="col-lg-6 col-sm-6">
                            <input id="women_ben_served" name="women_ben_served" placeholder="Number of beneficiaries served" type="text" class="form-control"  value="<?php echo set_value('women_ben_served'); ?>" required autofocus/>
                            <span class="text-danger"><?php echo form_error('women_ben_served'); ?></span>
                        </div>
                    </div>
                    <div class="form-group form-group-sm">
                        <div class="col-lg-6 col-sm-6">
                            <label for="women_budget_pres" class="control-label">Budget for the Present Year (Women)</label>
                        </div>
                        <div class="col-lg-6 col-sm-6">
                            <input id="women_budget_pres" name="women_budget_pres" placeholder="Budget for the Present Year" type="text" class="form-control"  value="<?php echo set_value('women_budget_pres'); ?>" required autofocus/>
                            <span class="text-danger"><?php echo form_error('women_budget_pres'); ?></span>
                        </div>
                    </div>
                    <div class="form-group form-group-sm">
                        <div class="col-lg-6 col-sm-6">
                            <label for="women_trgt_ben" class="control-label">Number of Target Beneficiaries (Women)</label>
                        </div>
                        <div class="col-lg-6 col-sm-6">
                            <input id="women_trgt_ben" name="women_trgt_ben" placeholder="Number of Target Beneficiaries" type="text" class="form-control"  value="<?php echo set_value('women_trgt_ben'); ?>" required autofocus/>
                            <span class="text-danger"><?php echo form_error('women_trgt_ben'); ?></span>
                        </div>
                    </div>

                    <?php /*----------------------Family and Community-------------------------------- */  ?>
                    <div class="form-group form-group-sm">
                        <div class="col-lg-4 col-sm-4">
                            <label for="family_com" class="control-label">Family and Community</label>
                        </div>
                    </div>
                    <div class="form-group form-group-sm">
                        <div class="col-lg-4 col-sm-6">
                            <label for="family_budget_prev" class="control-label">Budget from the Previous Year (Family and Community)</label>
                        </div>
                        <div class="col-lg-6 col-sm-6">
                            <input id="family_budget_prev" name="family_budget_prev" placeholder="Budget from the Previous Year" type="text" class="form-control"  value="<?php echo set_value('family_budget_prev'); ?>" required autofocus/>
                            <span class="text-danger"><?php echo form_error('family_budget_prev'); ?></span>
                        </div>
                    </div>
                    <div class="form-group form-group-sm">
                        <div class="col-lg-6 col-sm-6">
                            <label for="family_util" class="control-label">Utilization (Family and Community)</label>
                        </div>
                        <div class="col-lg-6 col-sm-6">
                            <input id="family_util" name="family_util" placeholder="Utilization" type="text" class="form-control"  value="<?php echo set_value('family_util'); ?>" required autofocus/>
                            <span class="text-danger"><?php echo form_error('family_util'); ?></span>
                        </div>
                    </div>
                    <div class="form-group form-group-sm">
                        <div class="col-lg-6 col-sm-6">
                            <label for="women_ben_served" class="control-label">Number of beneficiaries served (Family and Community)</label>
                        </div>
                        <div class="col-lg-6 col-sm-6">
                            <input id="women_ben_served" name="women_ben_served" placeholder="Number of beneficiaries served" type="text" class="form-control"  value="<?php echo set_value('women_ben_served'); ?>" required autofocus/>
                            <span class="text-danger"><?php echo form_error('women_ben_served'); ?></span>
                        </div>
                    </div>
                    <div class="form-group form-group-sm">
                        <div class="col-lg-6 col-sm-6">
                            <label for="women_budget_pres" class="control-label">Budget for the Present Year (Family and Community)</label>
                        </div>
                        <div class="col-lg-6 col-sm-6">
                            <input id="women_budget_pres" name="women_budget_pres" placeholder="Budget for the Present Year" type="text" class="form-control"  value="<?php echo set_value('women_budget_pres'); ?>" required autofocus/>
                            <span class="text-danger"><?php echo form_error('women_budget_pres'); ?></span>
                        </div>
                    </div>
                    <div class="form-group form-group-sm">
                        <div class="col-lg-6 col-sm-6">
                            <label for="women_trgt_ben" class="control-label">Number of Target Beneficiaries (Family and Community)</label>
                        </div>
                        <div class="col-lg-6 col-sm-6">
                            <input id="women_trgt_ben" name="women_trgt_ben" placeholder="Number of Target Beneficiaries" type="text" class="form-control"  value="<?php echo set_value('women_trgt_ben'); ?>" required autofocus/>
                            <span class="text-danger"><?php echo form_error('women_trgt_ben'); ?></span>
                        </div>
                    </div>

                    <?php /*----------------------Senior Citizens-------------------------------- */  ?>
                    <div class="form-group form-group-sm">
                        <div class="col-lg-4 col-sm-4">
                            <label for="senior_citizens" class="control-label">Senior Citizens</label>
                        </div>
                    </div>
                    <div class="form-group form-group-sm">
                        <div class="col-lg-4 col-sm-6">
                            <label for="senior_budget_prev" class="control-label">Budget from the Previous Year (Senior Citizens)</label>
                        </div>
                        <div class="col-lg-6 col-sm-6">
                            <input id="senior_budget_prev" name="senior_budget_prev" placeholder="Budget from the Previous Year" type="text" class="form-control"  value="<?php echo set_value('senior_budget_prev'); ?>" required autofocus/>
                            <span class="text-danger"><?php echo form_error('senior_budget_prev'); ?></span>
                        </div>
                    </div>
                    <div class="form-group form-group-sm">
                        <div class="col-lg-6 col-sm-6">
                            <label for="senior_util" class="control-label">Utilization (Senior Citizens)</label>
                        </div>
                        <div class="col-lg-6 col-sm-6">
                            <input id="senior_util" name="senior_util" placeholder="Utilization" type="text" class="form-control"  value="<?php echo set_value('senior_util'); ?>" required autofocus/>
                            <span class="text-danger"><?php echo form_error('senior_util'); ?></span>
                        </div>
                    </div>
                    <div class="form-group form-group-sm">
                        <div class="col-lg-6 col-sm-6">
                            <label for="senior_ben_served" class="control-label">Number of beneficiaries served (Senior Citizens)</label>
                        </div>
                        <div class="col-lg-6 col-sm-6">
                            <input id="senior_ben_served" name="senior_ben_served" placeholder="Number of beneficiaries served" type="text" class="form-control"  value="<?php echo set_value('senior_ben_served'); ?>" required autofocus/>
                            <span class="text-danger"><?php echo form_error('senior_ben_served'); ?></span>
                        </div>
                    </div>
                    <div class="form-group form-group-sm">
                        <div class="col-lg-6 col-sm-6">
                            <label for="senior_budget_pres" class="control-label">Budget for the Present Year (Senior Citizens)</label>
                        </div>
                        <div class="col-lg-6 col-sm-6">
                            <input id="senior_budget_pres" name="senior_budget_pres" placeholder="Budget for the Present Year" type="text" class="form-control"  value="<?php echo set_value('senior_budget_pres'); ?>" required autofocus/>
                            <span class="text-danger"><?php echo form_error('senior_budget_pres'); ?></span>
                        </div>
                    </div>
                    <div class="form-group form-group-sm">
                        <div class="col-lg-6 col-sm-6">
                            <label for="senior_trgt_ben" class="control-label">Number of Target Beneficiaries (Senior Citizens)</label>
                        </div>
                        <div class="col-lg-6 col-sm-6">
                            <input id="senior_trgt_ben" name="senior_trgt_ben" placeholder="Number of Target Beneficiaries" type="text" class="form-control"  value="<?php echo set_value('senior_trgt_ben'); ?>" required autofocus/>
                            <span class="text-danger"><?php echo form_error('senior_trgt_ben'); ?></span>
                        </div>
                    </div>

                    <?php /*----------------------Persons with Disability-------------------------------- */  ?>
                    <div class="form-group form-group-sm">
                        <div class="col-lg-4 col-sm-4">
                            <label for="pwd" class="control-label">Persons with Disability</label>
                        </div>
                    </div>
                    <div class="form-group form-group-sm">
                        <div class="col-lg-4 col-sm-6">
                            <label for="pwd_budget_prev" class="control-label">Budget from the Previous Year (PWD)</label>
                        </div>
                        <div class="col-lg-6 col-sm-6">
                            <input id="pwd_budget_prev" name="pwd_budget_prev" placeholder="Budget from the Previous Year" type="text" class="form-control"  value="<?php echo set_value('pwd_budget_prev'); ?>" required autofocus/>
                            <span class="text-danger"><?php echo form_error('pwd_budget_prev'); ?></span>
                        </div>
                    </div>
                    <div class="form-group form-group-sm">
                        <div class="col-lg-6 col-sm-6">
                            <label for="pwd_util" class="control-label">Utilization (PWD)</label>
                        </div>
                        <div class="col-lg-6 col-sm-6">
                            <input id="pwd_util" name="pwd_util" placeholder="Utilization" type="text" class="form-control"  value="<?php echo set_value('pwd_util'); ?>" required autofocus/>
                            <span class="text-danger"><?php echo form_error('pwd_util'); ?></span>
                        </div>
                    </div>
                    <div class="form-group form-group-sm">
                        <div class="col-lg-6 col-sm-6">
                            <label for="pwd_ben_served" class="control-label">Number of beneficiaries served (PWD)</label>
                        </div>
                        <div class="col-lg-6 col-sm-6">
                            <input id="pwd_ben_served" name="pwd_ben_served" placeholder="Number of beneficiaries served" type="text" class="form-control"  value="<?php echo set_value('pwd_ben_served'); ?>" required autofocus/>
                            <span class="text-danger"><?php echo form_error('pwd_ben_served'); ?></span>
                        </div>
                    </div>
                    <div class="form-group form-group-sm">
                        <div class="col-lg-6 col-sm-6">
                            <label for="pwd_budget_pres" class="control-label">Budget for the Present Year (PWD)</label>
                        </div>
                        <div class="col-lg-6 col-sm-6">
                            <input id="pwd_budget_pres" name="pwd_budget_pres" placeholder="Budget for the Present Year" type="text" class="form-control"  value="<?php echo set_value('pwd_budget_pres'); ?>" required autofocus/>
                            <span class="text-danger"><?php echo form_error('pwd_budget_pres'); ?></span>
                        </div>
                    </div>
                    <div class="form-group form-group-sm">
                        <div class="col-lg-6 col-sm-6">
                            <label for="pwd_trgt_ben" class="control-label">Number of Target Beneficiaries (PWD)</label>
                        </div>
                        <div class="col-lg-6 col-sm-6">
                            <input id="pwd_trgt_ben" name="pwd_trgt_ben" placeholder="Number of Target Beneficiaries" type="text" class="form-control"  value="<?php echo set_value('pwd_trgt_ben'); ?>" required autofocus/>
                            <span class="text-danger"><?php echo form_error('pwd_trgt_ben'); ?></span>
                        </div>
                    </div>

                    <?php /*----------------------Internally Displaced Persons/ Family-------------------------------- */  ?>
                    <div class="form-group form-group-sm">
                        <div class="col-lg-4 col-sm-4">
                            <label for="idps" class="control-label">Internally Displaced Persons/ Family</label>
                        </div>
                    </div>
                    <div class="form-group form-group-sm">
                        <div class="col-lg-4 col-sm-6">
                            <label for="idps_budget_prev" class="control-label">Budget from the Previous Year (IDPs)</label>
                        </div>
                        <div class="col-lg-6 col-sm-6">
                            <input id="idps_budget_prev" name="idps_budget_prev" placeholder="Budget from the Previous Year" type="text" class="form-control"  value="<?php echo set_value('idps_budget_prev'); ?>" required autofocus/>
                            <span class="text-danger"><?php echo form_error('idps_budget_prev'); ?></span>
                        </div>
                    </div>
                    <div class="form-group form-group-sm">
                        <div class="col-lg-6 col-sm-6">
                            <label for="idps_util" class="control-label">Utilization (IDPs)</label>
                        </div>
                        <div class="col-lg-6 col-sm-6">
                            <input id="idps_util" name="idps_util" placeholder="Utilization" type="text" class="form-control"  value="<?php echo set_value('idps_util'); ?>" required autofocus/>
                            <span class="text-danger"><?php echo form_error('idps_util'); ?></span>
                        </div>
                    </div>
                    <div class="form-group form-group-sm">
                        <div class="col-lg-6 col-sm-6">
                            <label for="idps_ben_served" class="control-label">Number of beneficiaries served (IDPs)</label>
                        </div>
                        <div class="col-lg-6 col-sm-6">
                            <input id="idps_ben_served" name="idps_ben_served" placeholder="Number of beneficiaries served" type="text" class="form-control"  value="<?php echo set_value('idps_ben_served'); ?>" required autofocus/>
                            <span class="text-danger"><?php echo form_error('idps_ben_served'); ?></span>
                        </div>
                    </div>
                    <div class="form-group form-group-sm">
                        <div class="col-lg-6 col-sm-6">
                            <label for="idps_budget_pres" class="control-label">Budget for the Present Year (IDPs)</label>
                        </div>
                        <div class="col-lg-6 col-sm-6">
                            <input id="idps_budget_pres" name="idps_budget_pres" placeholder="Budget for the Present Year" type="text" class="form-control"  value="<?php echo set_value('idps_budget_pres'); ?>" required autofocus/>
                            <span class="text-danger"><?php echo form_error('idps_budget_pres'); ?></span>
                        </div>
                    </div>
                    <div class="form-group form-group-sm">
                        <div class="col-lg-6 col-sm-6">
                            <label for="idps_trgt_ben" class="control-label">Number of Target Beneficiaries (IDPs)</label>
                        </div>
                        <div class="col-lg-6 col-sm-6">
                            <input id="idps_trgt_ben" name="idps_trgt_ben" placeholder="Number of Target Beneficiaries" type="text" class="form-control"  value="<?php echo set_value('idps_trgt_ben'); ?>" required autofocus/>
                            <span class="text-danger"><?php echo form_error('idps_trgt_ben'); ?></span>
                        </div>
                    </div>
