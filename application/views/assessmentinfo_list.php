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
<?php if ($form_message <> ''){ ?>
    <div class="alert alert-success">
        <?php echo $form_message ?>
    </div>
<?php } ?>
<div class="col-md-12">
    <div class="col-md-1"></div>
    <div class="col-md-10">
        <table class="table table-bordered table-striped">
            <thead>
            <tr>
                <th>Profile ID</th>
                <th>Application type</th>

            </tr>
            </thead>
            <tbody>
            <?php foreach($assessmentinfo_data as $assessmentinfoData): ?>
                <tr>
                    <td><?php echo $assessmentinfoData->profile_id ?></td>
                    <><?php echo $assessmentinfoData->application_type_id ?></td>
                    <td><a class="btn btn-xs btn-success" href="<?php echo base_url('assessmentinfo/assessmentinfo_masterview/' . $assessmentinfoData->profile_id . '.html') ?>"><i class="fa fa-list"></i> View Details </a></td>
                    <td>
                        <div class="btn-group">
                            <a class="btn btn-sm btn-primary" href="<?php echo base_url('assessmentinfo/editassessmentinfo/' . $assessmentinfoData->profile_id . '.html') ?>"><i class="fa fa-edit"></i> </a>
                            <a onclick="return confirm('are you sure?')" class="btn btn-sm btn-danger" href="<?php echo base_url('assessmentinfo/delete_assessmentinfo/' . $studentData->student_id . '.html') ?>"><i class="fa fa-trash"></i> </a>
                        </div>

                    </td>
                </tr>
            <?php endforeach ?>
            </tbody>
        </table>
    </div>
    <div class="col-md-1"></div>
</div>
</body>