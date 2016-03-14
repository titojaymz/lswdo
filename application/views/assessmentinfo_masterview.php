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
    <br><br>
    <table class="table table-bordered">
        <tr>
            <th>Profile ID:</th><td><?php echo $profile_id ?></td>
        </tr>
        <tr>
            <th>Status of Application:</th><td><?php echo $application_type_id ?></td>
        </tr>
        <tr>
            <th>Region:</th><td><?php echo $lgu_type_id ?></td>
        </tr>

    </table>
    <br><br><br>
    <a href="<?php echo base_url()?>assessmentinfo/addAssessmentinfo/<?php echo $profile_id ?>/<?php echo $application_type_id ?>/<?php echo $lgu_type_id ?>.html" class="btn btn-sm btn-success"><i class="fa fa-plus-circle"></i> Add Assessment Info</a>
    <br><br>
    <?php if ($student_subjects){ ?>
        <table class="table table-bordered table-striped">
            <thead>
            <tr>
                <th>Profile ID</th>
                <th>Status of Application</th>
                <th>Region</th>

            </tr>
            </thead>
            <tbody>
            <?php foreach($student_subjects as $subjectDetails): ?>
                <tr>
                    <?php
                    $subname = new Assessmentinfo_Model();
                    ?>
                    <td><?php echo $subname->getSubjectName($subjectDetails->subject_id) ?></td>
                    <td><?php echo $subjectDetails->grade ?></td>
                    <td><?php echo $subjectDetails->remarks ?></td>
                    <td>
                        <div class="btn-group">
                            <a class="btn btn-sm btn-primary" href="<?php echo base_url('students/editstudentsubject/'.$subjectDetails->student_subject_id.'.html') ?>"><i class="fa fa-edit"></i> </a>
                            <a onclick="return confirm('are you sure?')" class="btn btn-sm btn-danger" href="<?php echo base_url('students/deletesubject/'.$student_id.'/'.$subjectDetails->student_subject_id.'.html') ?>"><i class="fa fa-trash"></i> </a>
                        </div>
                    </td>
                </tr>
            <?php endforeach ?>
            </tbody>
        </table>
    <?php } else { ?>
        No Records Found!
    <?php } ?>
</div>
<div class="col-md-2"></div>