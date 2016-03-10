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
                <th>Student ID</th>
                <th>Name</th>
                <th>Course</th>
                <th>Year</th>
                <th>Semester</th>
                <th>Subjects</th>
                <th>Options</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach($student_data as $studentData): ?>
                <tr>
                    <td><?php echo $studentData->student_id ?></td>
                    <td><?php echo $studentData->lastname . ', ' . $studentData->firstname . ' ' . $studentData->middlename . ' ' . $studentData->extname ?></td>
                    <td><?php echo $studentData->course ?></td>
                    <td><?php echo $studentData->year ?></td>
                    <td><?php echo $studentData->sem ?></td>
                    <td><a class="btn btn-xs btn-success" href="<?php echo base_url('assessmentinfo/assessmentinfo_masterview/' . $studentData->student_id . '.html') ?>"><i class="fa fa-list"></i> View Details </a></td>
                    <td>
                        <div class="btn-group">
                            <a class="btn btn-sm btn-primary" href="<?php echo base_url('assessmentinfo/editAssessmentinfo/' . $studentData->student_id . '.html') ?>"><i class="fa fa-edit"></i> </a>
                            <a onclick="return confirm('are you sure?')" class="btn btn-sm btn-danger" href="<?php echo base_url('students/delete_student/' . $studentData->student_id . '.html') ?>"><i class="fa fa-trash"></i> </a>
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