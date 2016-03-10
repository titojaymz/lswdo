<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Created by JOSEF FRIEDRICH S. BALDO
 * Date Time: 10/18/15 12:33 AM
 */
if (!$this->session->userdata('user_data')){
    redirect('/users/login','location');
}
?>
<body>

<?php if ($form_message <> '') { ?>
    <div class="alert alert-success">
        <strong><?php echo $form_message ?></strong>
    </div>
<?php } ?>
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
                <form method="post" class="form-horizontal">
<div class="col-md-12">
    <div class="col-md-1"></div>
    <div class="col-md-10">
        <table class="table table-bordered table-striped">
            <thead>
            <tr>
                <th>Profile ID</th>
                <th>Status of Application</th>
                <th>Region</th>
                <th>Province</th>
                <th>City</th>
                <th>Brgy</th>
                <th>Street Address</th>
                <th>SWDO Name</th>
                <th>Contact No</th>
                <th>Email</th>
                <th>Website</th>
                <th>Total IRA</th>
                <th>Total Budget LSWDO</th>

            </tr>
            </thead>
            <tbody>
            <?php foreach($assessmentinfo_data as $assessmentinfoData): ?>
                <tr>
                    <td><?php echo $assessmentinfoData->profile_id ?></td>
                    <td><?php echo $assessmentinfoData->application_type_id ?></td>
                    <td><?php echo $assessmentinfoData->lgu_type_id ?></td>
                    <td><?php echo $assessmentinfoData->region_code ?></td>
                    <td><?php echo $assessmentinfoData->prov_code ?></td>
                    <td><?php echo $assessmentinfoData->city_code ?></td>
                    <td><?php echo $assessmentinfoData->brgy_code ?></td>
                    <td><?php echo $assessmentinfoData->street_address ?></td>
                    <td><?php echo $assessmentinfoData->swdo_name ?></td>
                    <td><?php echo $assessmentinfoData->contact_no ?></td>
                    <td><?php echo $assessmentinfoData->email ?></td>
                    <td><?php echo $assessmentinfoData->website ?></td>
                    <td><?php echo $assessmentinfoData->total_ira ?></td>
                    <td><?php echo $assessmentinfoData->total_budget_lswdo ?></td>
                    <td><a class="btn btn-xs btn-success" href="<?php echo base_url('assessmentinfo/assessmentinfo_masterview/' . $assessmentinfoData->profile_id . '.html') ?>"><i class="fa fa-list"></i> View Details </a></td>
                    <td>
                        <div class="btn-group">
                            <a class="btn btn-sm btn-primary" href="<?php echo base_url('assessmentinfo/editAssessmentinfo/' . $assessmentinfoData->profile_id . '.html') ?>"><i class="fa fa-edit"></i> </a>
                            <a onclick="return confirm('are you sure?')" class="btn btn-sm btn-danger" href="<?php echo base_url('assessmentinfo/delete_student/' . $assessmentinfoData->profile_id . '.html') ?>"><i class="fa fa-trash"></i> </a>
                        </div>

                    </td>
                </tr>
            <?php endforeach ?>
            </tbody>
        </table>
    </div>
    <div class="col-md-1"></div>
</div>

                </form>
            </div>
            <div class="col-md-3"></div>
</body>