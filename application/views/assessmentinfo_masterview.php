<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Created by JOSEF FRIEDRICH S. BALDO
 * Date Time: 10/18/15 1:26 PM
 */
if (!$this->session->userdata('user_data')){
    redirect('/users/login','location');
}
if ($form_message){ ?>
    <div class="alert alert-success">
        <strong><?php echo $form_message ?></strong>
    </div>
<?php } ?>
<div class="col-md-2"></div>
<div class="col-md-8">
    <a class="btn btn-sm btn-warning" href="<?php echo base_url('assessmentinfo/index.html') ?>"><i class="fa fa-arrow-left"></i> Back to list</a>
    <a href="<?php echo base_url()?>assessmentinfo/addAssessmentinfo/<?php echo $profile_id ?>/<?php echo $application_type_id ?>/<?php echo $lgu_type_id ?>.html" class="btn btn-sm btn-success"><i class="fa fa-plus-circle"></i> Add Assessment Info</a>
    <br><br>
    <table class="table table-bordered">
        <tr>
            <th>Profile ID:</th><td><?php echo $profile_id ?></td>
        </tr>
        <tr>
            <th>Status of Application:</th><td><?php echo $application_type_id ?></td>
        </tr>
        <tr>
            <th>LGU Type:</th><td><?php echo $lgu_type_id ?></td>
        </tr>
        <tr>
            <th>SWDO Name:</th><td><?php echo $swdo_name ?></td>
        </tr>
        <tr>
            <th>Street Address:</th><td><?php echo $street_address ?></td>
        </tr>
        <tr>
            <th>Email:</th><td><?php echo $email ?></td>
        </tr>
        <tr>
            <th>Total IRA:</th><td><?php echo $total_ira ?></td>
        </tr>
        <tr>
            <th>Total Budget LSWDO:</th><td><?php echo $total_budget_lswdo ?></td>
        </tr>

    </table>

</div>
<div class="col-md-2"></div>