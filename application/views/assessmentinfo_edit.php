<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Created by JOSEF FRIEDRICH S. BALDO
 * Date Time: 10/18/15 12:57 AM
 */
if (!$this->session->userdata('user_id')){
    redirect('/users/login','location');
}
echo validation_errors();

?>
<body>
<script type="text/javascript">

    document.onreadystatechange=function(){
        get_prov();
        get_city();
        get_brgy();

    }

    function get_prov() {
        var region_code = $('#regionlist').val();
        var provCode = <?php echo $assessmentinfo_details->prov_code; ?>

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
    function get_city() {
        var prov_code = $('#provlist').val();
        var cityCode = <?php echo $assessmentinfo_details->city_code; ?>

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
                    $('#citylist').val(cityCode);
                }
            });
        } else {
            $('#citylist option:gt(0)').remove().end();
        }

    }
    function get_brgy() {
        var city_code = $('#citylist').val();
        var brgy = <?php echo $assessmentinfo_details->brgy_code; ?>

        if(city_code > 0) {
            $.ajax({
                url: "<?php echo base_url('assessmentinfo/populate_brgy'); ?>",
                async: false,
                type: "POST",
                data: "city_code="+city_code,
                dataType: "html",
                success: function(data) {
                    $('#div_brgylist').html(data);

                    $('#brgylist').val(brgy);
                }
            });
        } else {
            $('#brgylist option:gt(0)').remove().end();
        }


    }



    }
</script>
<div class="content">

    <div class = "row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-title">
                <h1>Edit Assessment of Functionality </h1>
                </div>
                <div class = "panel-body" style="display: block;">
<div class="col-md-3"></div>
<div class="col-md-6">
    <form method="post" class="form-horizontal">

        <div class="form-group">
            <label for="profile_id">profile_id:</label>
            <span class="h4"><?php echo $assessmentinfo_details->profile_id ?></span>
            <input class="form-control" type="hidden" name="profile_id" value="<?php echo $assessmentinfo_details->profile_id ?>" >
        </div>

        <div class="form-group">
            <label for="application_type_id">application_type_id</label>
            <select name="application_type_id" id="application_type_id" class="form-control"">
            <option value="0">-Please select-</option>
            <?php foreach($application_type_id as $applications): ?>
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
            <label for="lgu_type_id">lgu_type_id</label>
            <select name="lgu_type_id" id="lgu_type_id" class="form-control"">
            <option value="0">-Please select-</option>
            <?php foreach($lgu_type_id as $lgus): ?>
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
        </div>
        <div class="form-group">
        <div id="div_regionlist" >
            <label for="lgu_type_id">region</label>
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
        <div class="form-group">

            <label for="provlist">prov_code</label>
            <div id="div_provlist">
                <select id="provlist" name="provlist" class="form-control" onChange="get_city();">
                    <?php if(isset($assessmentinfo_details->prov_code) or isset($assessmentinfo_details->region_code)) {
                        ?>
                        <option value="0">Choose Region First</option>
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
        <pre>
            <?php print_r($provlist)?>
            <?php echo $assessmentinfo_details->region_code ?>
            <?php echo $assessmentinfo_details->prov_code ?>
            <?php echo $assessmentinfo_details->city_code ?>
            <?php echo $assessmentinfo_details->brgy_code ?>
        </pre>
        <div class="form-group">
            <label for="brgy_code">city_code</label>
            <div id="div_citylist">
                <select id="citylist" name="citylist" onchange="get_brgy();" class="form-control">
                    <?php if($assessmentinfo_details->city_code or $assessmentinfo_details->prov_code) {
                        ?>
                        <option value="0">Choose Province First</option>
                        <?php
                        foreach ($citylist as $cityselect) { ?>
                            <option value="<?php echo $cityselect->city_code; ?>"
                                <?php
                                if ($cityselect->city_code== $assessmentinfo_details->city_code) {
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
        <div class="form-group">
            <label for="brgy_code">brgy_code</label>
            <div id="div_brgylist">
                <select id="brgylist" name="brgylist" class="form-control">
                    <?php if($assessmentinfo_details->brgy_code or $assessmentinfo_details->city_code) {
                        ?>
                        <option value="0">Choose Barangay</option>
                        <?php
                        foreach ($brgylist as $brgyselect) { ?>
                            <option value="<?php echo $brgyselect->brgy_code; ?>"
                                <?php
                                if ($brgyselect->brgy_code == $assessmentinfo_details->brgy_code ) {
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
            </div>

        </div>
    </div>
</div>
</div>

</div>
</body>