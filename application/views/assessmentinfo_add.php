<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Created by JOSEF FRIEDRICH S. BALDO
 * Date Time: 10/18/15 12:57 AM
 */
if (!$this->session->userdata('user_data')){
    redirect('/users/login','location');
}
//echo validation_errors();
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

        <div class="form-group">
            <div class="form-group">
                <label for="application_type_id">Status of Application:</label>
                <input class="form-control" type="text" name="application_type_id" value="<?php echo set_value('application_type_id') ?>" placeholder="application_type_id">
            </div>
        </div>

        <div class="btn-group">
            <button class="btn btn-success" type="submit" name="submit" value="submit"><i class="fa fa-save"></i> Save</button>
            <a class="btn btn-warning btn-group" href="/lswdo/assessmentinfo/index.html"><i class="fa fa-refresh"></i> Cancel</a>
        </div>
    </form>
</div>
<div class="col-md-3"></div>
</body>