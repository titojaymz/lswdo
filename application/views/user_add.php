<!DOCTYPE html>
<div class="content">

    <!-- Start Page Header -->
    <div class="page-header">
        <!--  <h1 class="title">Tool for the Assessment of FUNCTIONALITY of LSWDOs</h1>-->
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url('dashboardc/dashboard'); ?>">Home</a></li>
            <li class="active">Users List </li>
            <li class="active">Add </li>
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
                                    <td><label for="firstname" class="control-label">First Name:</label></td>
                                    <td>
                                        <input id="firstname" name="firstname" placeholder="First name" type="text" class="form-control"  value="<?php echo set_value('firstname'); ?>" required autofocus/>
                                        <span class="text-danger"><?php echo form_error('firstname'); ?></span>
                                    </td>
                                </tr>
                                <tr>
                                    <td><label for="middlename" class="control-label">Middle Name:</label></td>
                                    <td>
                                        <input id="middlename" name="middlename" placeholder="Middle name" type="text" class="form-control"  value="<?php echo set_value('middlename'); ?>" required autofocus/>
                                        <span class="text-danger"><?php echo form_error('middlename'); ?></span>
                                    </td>
                                </tr>
                                <tr>
                                    <td><label for="surname" class="control-label">Last Name:</label></td>
                                    <td>
                                        <input id="surname" name="surname" placeholder="Last name" type="text" class="form-control"  value="<?php echo set_value('surname'); ?>" required autofocus/>
                                        <span class="text-danger"><?php echo form_error('surname'); ?></span>
                                    </td>
                                </tr>
                                <tr>
                                    <td><label for="extensionname" class="control-label">Extension Name:</label></td>
                                    <td>
                                        <input id="extensionname" name="extensionname" placeholder="Extension name" type="text" class="form-control"  value="<?php echo set_value('extensionname'); ?>" required autofocus/>
                                        <span class="text-danger"><?php echo form_error('extensionname'); ?></span>
                                    </td>
                                </tr>
                                <tr>
                                    <td><label for="position" class="control-label">Position:</label></td>
                                    <td>
                                        <input id="position" name="position" placeholder="Position" type="text" class="form-control"  value="<?php echo set_value('position'); ?>" required autofocus/>
                                        <span class="text-danger"><?php echo form_error('position'); ?></span>
                                    </td>
                                </tr>
                                <tr>
                                    <td><label for="designation" class="control-label">Designation:</label></td>
                                    <td>
                                        <input id="designation" name="designation" placeholder="Designation" type="text" class="form-control"  value="<?php echo set_value('designation'); ?>" required autofocus/>
                                        <span class="text-danger"><?php echo form_error('designation'); ?></span>
                                    </td>
                                </tr>
                                <tr>
                                    <td><label for="contactno" class="control-label">Contact No:</label></td>
                                    <td>
                                        <input id="contactno" name="contactno" placeholder="Contact No" type="text" class="form-control"  value="<?php echo set_value('contactno'); ?>" required autofocus/>
                                        <span class="text-danger"><?php echo form_error('contactno'); ?></span>
                                    </td>
                                </tr>
                                <tr>
                                    <td><label for="username" class="control-label">Username:</label></td>
                                    <td>
                                        <input id="username" name="username" placeholder="Username" type="text" class="form-control"  value="<?php echo set_value('username'); ?>" required />
                                        <span class="text-danger"><?php echo form_error('username'); ?></span>
                                    </td>
                                </tr>
                                <tr>
                                    <td> <label for="pword" class="control-label">Password:</label></td>
                                    <td>
                                        <input id="password" name="password" placeholder="Password" type="password" class="form-control"  value="<?php echo set_value('password'); ?>" required/>
                                        <span class="text-danger"><?php echo form_error('password'); ?></span>
                                    </td>
                                </tr>
                                <tr>
                                    <td><label for="e_add" class="control-label">Email Address:</label></td>
                                    <td>
                                        <input id="e_add" name="e_add" placeholder="Email Address" type="text" class="form-control"  value="<?php echo set_value('e_add'); ?>" required/>
                                        <span class="text-danger"><?php echo form_error('e_add'); ?></span>
                                    </td>
                                </tr>
                                <tr>
                                    <td><label for="userlevelid" class="control-label">User Level:</label></td>
                                    <td>
                                        <select name="userlevelid" id="userlevelid" class="form-control"">
                                        <option value="">Please Select</option>
                                        <?php foreach($getUserLevel as $userlevel):?>
                                                <option value="<?php echo $userlevel->userlevel_id; ?>"><?php echo $userlevel->userlevel_name; ?></option>
                                        <?php endforeach; ?>
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <td><label for="regionlist" class="control-label">Region:</label></td>
                                    <td>
                                        <select name="regionlist" id="regionlist" class="form-control">
                                            <option value="0">Choose Region</option>
                                            <?php foreach($regionlist as $regionselect): ?>
                                                <option value="<?php echo $regionselect->region_code; ?>"
                                                    <?php if(isset($_SESSION['region'])) {
                                                        if($regionselect->region_code == $_SESSION['region']) {
                                                            echo " selected";
                                                        }
                                                    } ?>
                                                >
                                                    <?php echo $regionselect->region_name; ?>
                                                </option>
                                            <?php endforeach; ?>
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <td><label for="regionlist" class="control-label">Activated:</label></td>
                                    <td>
                                        <select class="selectpicker" name="status" id = "status">
                                            <option data-icon="fa fa-check" value="1">Yes</option>
                                            <option data-icon="fa fa-close" value="0">No</option>
                                        </select>
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