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

                                            <?php /*----------------------------Budget Allocation and UtilizationTotal Budget Allocated to Programs and Services per Sector -------------------------------------------------*/?>

                        <div class="form-group">
                            <label for="budget" class="control-label">Budget Allocation and UtilizationTotal Budget Allocated to Programs and Services per Sector</label>
                        </div>

                        <div class="form-group">
                            <label for="sector_id">Sector:</label>
                            <select class="form-control" name="sector_id" id="sector_id">
                                <option select value="">Please select</option>
                                <?php foreach($sector_id as $sectors): ?>
                                    <option value="<?php echo $sectors->sector_id ?>"><?php echo $sectors->sector_name ?></option>
                                <?php endforeach ?>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="year_indicated">Year Indicated:</label>
                            <input class="form-control" type="text" name="year_indicated" value="<?php echo set_value('year_indicated') ?>" placeholder="Year Indicated">
                        </div>

                        <div class="form-group">
                            <label for="utilization">Utilization:</label>
                            <input class="form-control" type="text" name="utilization" value="<?php echo set_value('utilization') ?>" placeholder="Utilization">
                        </div>

                        <div class="form-group">
                            <label for="budget_present_year">Budget for the Present Year:</label>
                            <input class="form-control" type="text" name="budget_present_year" value="<?php echo set_value('budget_present_year') ?>" placeholder="Budget for the Present Year">
                        </div>

                        <div class="form-group">
                            <label for="no_bene_served">Number of Beneficiaries Served:</label>
                            <input class="form-control" type="text" name="no_bene_served" value="<?php echo set_value('no_bene_served') ?>" placeholder="Number of Beneficiaries Served">
                        </div>

                        <div class="form-group">
                            <label for="no_target_bene">Number of Target Beneficiaries:</label>
                            <input class="form-control" type="text" name="no_target_bene" value="<?php echo set_value('no_target_bene') ?>" placeholder="Number of Target Beneficiaries">
                        </div>


                        <div class="form-group">
                            <div class="btn-group">
                                <button class="btn btn-success" type="submit" name="submit" value="submit"><i class="fa fa-save"></i> Save</button>
                                <a class="btn btn-warning btn-group" href="/lswdo/budgetallocation/index.html"><i class="fa fa-refresh"></i> Cancel</a>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="col-md-3"></div>
</body>