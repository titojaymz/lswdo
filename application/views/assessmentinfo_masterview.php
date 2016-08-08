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
            <th>Visit Count:</th><td><?php echo $visit_count ?></td>
        </tr>
        <tr>
            <th>Visit Date:</th><td><?php echo $visit_date ?></td>
        </tr>
        <tr>
            <th>Baseline Score:</th><td><?php echo $baseline_score ?></td>
        </tr>
        <tr>
            <th>Updated Score:</th><td><?php echo $new_score ?></td>
        </tr>
        <tr>
            <th>Level of Functionality:</th><td><?php echo $level_function_baseline ?></td>
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