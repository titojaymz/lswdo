<!DOCTYPE html>
<div class="content">

    <!-- Start Page Header -->
    <div class="page-header">
        <!--  <h1 class="title">Tool for the Assessment of FUNCTIONALITY of LSWDOs</h1>-->
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url('dashboardc/dashboard'); ?>">Home</a></li>
            <li class="active">User Level List </li>
            <li class="active">Add User Level</li>
        </ol>
    </div>
    <!-- End Page Header -->

    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-title">
                    Add User
                </div>

                <div class="panel-body">
                    <?php echo form_open('',array('class'=>'form-horizontal')) ?>
                    <table class="table display table-bordered table-striped table-hover">
                        <tr>
                            <td><label for="userlevel_id" class="control-label">User Level ID:</label></td>
                            <td>
                                <input id="userlevel_id" name="userlevel_id" placeholder="User Level ID" type="text" class="form-control"  value="<?php echo $getUserLevelperID->userlevel_id; ?>" required autofocus/>
                                <span class="text-danger"><?php echo form_error('userlevel_id'); ?></span>
                            </td>
                        </tr>
                        <tr>
                            <td><label for="userlevel_name" class="control-label">User Level Name:</label></td>
                            <td>
                                <input id="userlevel_name" name="userlevel_name" placeholder="User Level Name" type="text" class="form-control"  value="<?php echo $getUserLevelperID->userlevel_name; ?>" required autofocus/>
                                <span class="text-danger"><?php echo form_error('userlevel_name'); ?></span>
                            </td>
                        </tr>
                        <tr>
                            <td><label for="userlevel_desc" class="control-label">Middle Name:</label></td>
                            <td>
                                <textarea id="userlevel_desc" name="userlevel_desc" placeholder="Description" class="form-control" autofocus><?php echo $getUserLevelperID->userlevel_desc; ?></textarea>
                                <!--                                <input id="userlevel_desc" name="userlevel_desc" placeholder="Description" type="text" class="form-control"  value="--><?php //echo set_value('userlevel_desc'); ?><!--" required autofocus/>-->
                                <span class="text-danger"><?php echo form_error('userlevel_desc'); ?></span>
                            </td>
                        </tr>
                    </table>
                    <hr>
                    <div class="btn-group">
                        <button type="submit" id = "submit" name="submit" value="submit" class="btn btn-lg btn-rounded btn-success" onclick = "return validation();"><i class="fa fa-check"></i> Save</button>
                    </div>
                    <?php echo form_close() ?>
                </div>
            </div>
        </div>
    </div>
</div>
</div>