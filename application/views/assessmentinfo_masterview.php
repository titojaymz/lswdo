<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Created by PhpStorm
 * User: mglveniegas
 *
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
            <li><a href="<?php echo base_url('assessmentinfo/index/0'); ?>">Assessment Information</a></li>
            <li class="active">View</li>
        </ol>
    </div>
    <!-- End Page Header -->

    <div class = "row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-title">

    <div class="form-group">
        <label for="geo_info" class="control-label"> View: Identifying Information </label>
    </div>
    <a class="btn btn-sm btn-warning" href="<?php echo base_url('assessmentinfo/index/0') ?>"><i class="fa fa-arrow-left"></i> Back to list</a>
   <!-- <a class="btn btn-sm btn-success" href="<?php echo base_url('budgetallocation/index')?>"><i class="fa fa-plus-circle"></i> View Budget Allocation </a>-->
    <br><br>
    <table class="table table-bordered">
        <tr>
            <th>Profile ID:</th><td><?php echo $profile_id ?></td>
        </tr>
        <tr>
            <th>Status of Application:</th><td><?php echo $application_type_name ?></td>
        </tr>
        <tr>
            <th>LGU Type:</th><td><?php echo $lgu_type_name ?></td>
        </tr>
        <tr>
            <th>Region:</th><td><?php echo $region_name ?></td>
        </tr>
        <tr>
            <th>Province</th><td><?php echo $prov_name ?></td>
        </tr>
        <tr>
            <th>City/Municipality:</th><td><?php echo $city_name ?></td>
        </tr>
        <tr>
            <th>Name of SWDO Officer/Head:</th><td><?php echo $swdo_name ?></td>
        </tr>
        <tr>
            <th>Designation:</th><td><?php echo $designation ?></td>
        </tr>
        <tr>
            <th>Office Address:</th><td><?php echo $office_address ?></td>
        </tr>
        <tr>
            <th>Contact Number:</th><td><?php echo $contact_no ?></td>
        </tr>
        <tr>
            <th>Email Address:</th><td><?php echo $email ?></td>
        </tr>
        <tr>
            <th>Website:</th><td><?php echo $website ?></td>
        </tr>
        <tr>
            <th>Total Internal Revenue Allotment:</th><td><?php echo $total_ira ?></td>
        </tr>
        <tr>
            <th>Total Budget LSWDO:</th><td><?php echo $total_budget_lswdo ?></td>
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