<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Created by PhpStorm.
 * User: mglveniegas
 * Date: 4/19/2016
 * Time: 2:18 PM
 */
if (!$this->session->userdata('user_id')){
    redirect('/users/login','location');
}
?>
<body>
<div class="content">

    <!-- Start Page Header -->
    <div class="page-header">
        <!-- <h1 class="title">Tool for the Assessment of FUNCTIONALITY of LSWDOs</h1>-->
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url('dashboardc/dashboard'); ?>">Home</a></li>
            <li class="active">Assessment Information</li>
            <li class="active">Budget Allocation</li>
            <li class="active">View</li>
        </ol>
    </div>
    <!-- End Page Header -->

    <div class = "row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-title">

                    <div class="form-group">
                        <label for="geo_info" class="control-label"> View: Budget Allocation </label>
                    </div>
                    <a class="btn btn-sm btn-warning" href="<?php echo base_url('assessmentinfo/index') ?>"><i class="fa fa-arrow-left"></i> Back to list</a>
                    <!-- <a href="<?php echo base_url()?>budgetallocation/addbudgetallocation/<?php echo $profile_id ?>/<?php echo $sector_id ?>.html" class="btn btn-sm btn-success"><i class="fa fa-plus-circle"></i> Add Budget Allocation</a>-->
                    <br><br>
                    <table class="table table-bordered">
                        <tr>
                            <th>Profile ID:</th><td><?php echo $profile_id ?></td>
                        </tr>
                        <tr>
                            <th>Sector:</th><td><?php echo $sector_name ?></td>
                        </tr>
                        <tr>
                            <th>Year Indicated:</th><td><?php echo $year_indicated ?></td>
                        </tr>
                        <tr>
                            <th>Budget for Previous Year:</th><td><?php echo $budget_previous_year ?></td>
                        </tr>
                        <tr>
                            <th>Budget for the Present Year:</th><td><?php echo $budget_present_year ?></td>
                        </tr>
                        <tr>
                            <th>Utilization:</th><td><?php echo $utilization ?></td>
                        </tr>
                        <tr>
                            <th>Number of Beneficiaries Served:</th><td><?php echo $no_bene_served ?></td>
                        </tr>
                        <tr>
                            <th>Number of Target Beneficiaries:</th><td><?php echo $no_target_bene ?></td>
                        </tr>


                    </table>

                </div>
                <div class="col-md-2"></div>
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