<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Created by PhpStorm
 * User: mglveniegas
 *
 */
if (!$this->session->userdata('user_id')){
    redirect('/users/login','location');
}
echo validation_errors();

?>
<body>
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
        } else {
            $('#citylist option:gt(0)').remove().end();
        }


    }

</script>
<body>
<div class="content">

    <div class = "row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-title">

                    <div class="form-group">
                        <label for="budget" class="control-label">Total Budget Allocated to Programs and Services per Sector</label>
                    </div>
                    <?php echo form_open('',array('class'=>'form-horizontal')) ?>
                    <?php echo $form_message; ?>
                    <div class="form-group">
                        <label for="sector_id">Sector:</label>
                        <select name="sector_id" id="sector_id" class="form-control"">
                        <option value="0">-Please select-</option>
                        <?php foreach($sector_id as $sectors): ?>
                            <option value="<?php echo $sectors->sector_id; ?>"
                                <?php if(isset($budgetallocation_details->sector_id)) {
                                    if($sectors->sector_id == $budgetallocation_details->sector_id) {
                                        echo " selected";
                                    }
                                } ?>
                                >
                                <?php echo $sectors->sector_name; ?>
                            </option>
                        <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="year_indicated">Year Indicated:</label>
                        <input class="form-control" type="text" name="year_indicated" value="<?php echo $budgetallocation_details->year_indicated ?>" placeholder="Year Indicated">
                    </div>
                    <div class="form-group">
                        <label for="budget_present_year">Budget for the Previous Year:</label>
                        <input class="form-control" type="text" name="budget_previous_year" value="<?php echo $budgetallocation_details->budget_previous_year ?>" placeholder="Budget for the Previous Year">
                    </div>
                    <div class="form-group">
                        <label for="utilization">Utilization:</label>
                        <input class="form-control" type="text" name="utilization" value="<?php echo $budgetallocation_details->utilization ?>" placeholder="Utilization">
                    </div>

                    <div class="form-group">
                        <label for="budget_previous_year">Budget for the Previous Year:</label>
                        <input class="form-control" type="text" name="budget_previous_year" value="<?php echo $budgetallocation_details->budget_previous_year ?>" placeholder="Budget for the Previous Year">
                    </div>

                    <div class="form-group">
                        <label for="budget_present_year">Budget for the Present Year:</label>
                        <input class="form-control" type="text" name="budget_present_year" value="<?php echo $budgetallocation_details->budget_present_year ?>" placeholder="Budget for the Present Year">
                    </div>

                    <div class="form-group">
                        <label for="no_bene_served">Number of Beneficiaries Served:</label>
                        <input class="form-control" type="text" name="no_bene_served" value="<?php echo $budgetallocation_details->no_bene_served ?>" placeholder="Number of Beneficiaries Served">
                    </div>

                    <div class="form-group">
                        <label for="no_target_bene">Number of Target Beneficiaries:</label>
                        <input class="form-control" type="text" name="no_target_bene" value="<?php echo $budgetallocation_details->no_target_bene ?>" placeholder="Number of Target Beneficiaries">
                    </div>

                    <div class="form-group">
                        <div class="btn-group">
                            <button class="btn btn-success" type="submit" name="submit" value="submit"><i class="fa fa-save"></i> Save</button>
                            <a class="btn btn-warning btn-group" href="/lswdo/assessmentinfo/index"><i class="fa fa-refresh"></i> Cancel</a>
                        </div>
                    </div>
                    <?php echo form_close() ?>
                </div>
                <div class="col-md-3"></div>
            </div>
        </div>
    </div>
</div>

</div>
</body>