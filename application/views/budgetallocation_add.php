<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Created by PhpStorm
 * User: mglveniegas
 *
 */
$region_code = $this->session->userdata('lswdo_regioncode');
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
            document.getElementById("groupCity").style.display = "block";
            document.getElementById("groupCity").style.visibility = "visible";
            document.getElementById("groupmuni").style.display = "block";
            document.getElementById("groupmuni").style.visibility = "visible";
            document.getElementById("groupbrgy").style.display = "none";
            document.getElementById("groupbrgy").style.visibility = "hidden";
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
            document.getElementById("groupCity").style.display = "none";
            document.getElementById("groupCity").style.visibility = "hidden";
            document.getElementById("groupmuni").style.display = "none";
            document.getElementById("groupmuni").style.visibility = "hidden";
            document.getElementById("groupbrgy").style.display = "block";
            document.getElementById("groupbrgy").style.visibility = "visible";

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

</script>
<body>
<div class="content">

    <!-- Start Page Header -->
    <div class="page-header">

        <ol class="breadcrumb">
            <li><a href="<?php echo base_url('dashboardc/dashboard/'.$region_code); ?>">Dashboard</a></li>
            <li><a href="<?php echo base_url('assessmentinfo/index/0'); ?>">Assessment Information</a></li>
            <li class="active">Budget Allocation</li>
            <li class="active">Add</li>
        </ol>
    </div>
    <!-- End Page Header -->
    <?php if (validation_errors() <> '') { ?>
        <div class="alert alert-danger">
            <strong><?php echo validation_errors() ?></strong>
        </div>
    <?php } ?>
    <?php echo $form_message ?>

    <div class = "row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-title">
                    <form method="post" class="form-horizontal">
                        <?php /*----------------------------Total Budget Allocated to Programs and Services per Sector -------------------------------------------------*/?>
                        <div class="form-group">
                            <label for="budget" class="control-label">Total Budget Allocated to Programs and Services per Sector</label>
                        </div>
                        <div class="form-group">
                            <label for="sector_id">Sector:</label>
                            <select class="form-control" name="sector_id" id="sector_id" style="width:500px;">
                                <option select value="">Please select</option>
                                <?php foreach($sector_id as $sectors): ?>
                                    <option value="<?php echo $sectors->sector_id ?>"><?php echo $sectors->sector_name ?></option>
                                <?php endforeach ?>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="year_indicated">Year Indicated:</label>
                            <input class="form-control" type="month" name="year_indicated" style="width:500px;" value="<?php echo set_value('year_indicated') ?>" placeholder="Year Indicated">
                        </div>

                        <div class="form-group">
                            <label for="budget_previous_year">Budget for the Previous Year:</label>
                            <input class="form-control" type="text" name="budget_previous_year" id="budget_previous_year" maxlength="16" style="width:500px;" value="<?php echo set_value('budget_previous_year') ?>" placeholder="Budget for the Previous Year">
                        </div>

                        <div class="form-group">
                            <label for="budget_present_year">Budget for the Present Year:</label>
                            <input class="form-control" type="text" name="budget_present_year" id="budget_present_year" maxlength="16" style="width:500px;" value="<?php echo set_value('budget_present_year') ?>" placeholder="Budget for the Present Year">
                        </div>

                        <div class="form-group">
                            <label for="utilization">Utilization:</label>
                            <input class="form-control" type="text" name="utilization" id="utilization" maxlength="16" style="width:500px;" value="<?php echo set_value('utilization') ?>" placeholder="Utilization">
                        </div>

                        <div class="form-group">
                            <label for="no_bene_served">Number of Beneficiaries Served:</label>
                            <input class="form-control" type="number" name="no_bene_served" id="no_bene_served" max="100000" style="width:500px;" value="<?php echo set_value('no_bene_served') ?>" placeholder="Number of Beneficiaries Served">
                        </div>

                        <div class="form-group">
                            <label for="no_target_bene">Number of Target Beneficiaries:</label>
                            <input class="form-control" type="number" name="no_target_bene" id="no_target_bene" max="100000" style="width:500px;" value="<?php echo set_value('no_target_bene') ?>" placeholder="Number of Target Beneficiaries">
                        </div>


                        <div class="form-group">
                            <div class="btn-group">
                                <button class="btn btn-success" type="submit" name="submit" value="submit"><i class="fa fa-save"></i> Save</button>
                                <a class="btn btn-warning btn-group" href="<?php echo base_url('assessmentinfo/index/0'); ?>"><i class="fa fa-refresh"></i> Cancel</a>
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