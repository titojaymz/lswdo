<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if (!$this->session->userdata('user_data')){
    redirect('/users/login','location');
//test0000000
}
$user_region = $this->session->userdata('uregion');
?><!DOCTYPE html>
<div class="content">

    <!-- Start Page Header -->
    <div class="page-header">
        <h1 class="title">User List</h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url('dashboardc/dashboard/'.$user_region.''); ?>">Home</a></li>
            <li><a href="<?php echo base_url('access_control/users'); ?>">Users</a></li>
            <li class="active">Edit User</li>
        </ol>


    </div>
    <!-- End Page Header 1-->

    <div class="container-padding">
    <div class="row">

        <!-- Start Panel -->
        <div class="col-md-7">
            <div class="panel panel-default">

            <form name = "edituserinfoForm" method="post" class="form-horizontal">
                <fieldset>
                    <div class="form-group">
                        <input class="form-control"  type="hidden" name="uid" value="<?php echo $user_details->uid ?>">
                        <input class="form-control"  type="hidden" name="myid" value="<?php echo $this->session->userdata('uid')?>">
                    </div>
                    <div id="edit" class="col-lg-6">
                    <div class="form-group">
                        <label for="full_name">Full Name:</label>
                        <input class="form-control" type="text" name="full_name" value="<?php echo $user_details->full_name ?>" placeholder="Full Name">
                    </div>

                    <div class="form-group">
                        <label for="username">Username:</label>
                        <input class="form-control" type="text" name="username" value="<?php echo $user_details->username ?>" placeholder="Username">
                    </div>

                    <div class="form-group">
                        <label for="password">Password:</label>
                        <input class="form-control" type="password" name="password" value="<?php echo $user_details->passwd ?>" placeholder="Password">
                    </div>

                    <div class="form-group">
                        <label for="email">Email:</label>
                        <input class="form-control" type="email" name="email" value="<?php echo $user_details->email ?>" placeholder="Email Address">
                    </div>

                    <div class="form-group form-group-sm">
                        <label for="access_level" class="col-lg-3 control-label">Access Level:</label>
                        <div id="div_access_level" class="col-lg-9">
                            <select name="access_level" id="access_level" class="form-control"">
                                <option value="0">Choose Region</option>
                                <?php foreach($levellist as $levelselect): ?>
                                    <option value="<?php echo $levelselect->userlevelid; ?>"
                                        <?php if(isset($user_details->access_level )) {
                                            if($levelselect->userlevelid == $levelselect->userlevelid) {
                                                echo " selected";
                                            }
                                        } ?>
                                    >
                                        <?php echo $levelselect->userlevelname; ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <label for="regionlist" class="col-lg-3 control-label">Region:</label>
                        <div id="div_regionlist" class="col-lg-9">
                            <select name="regionlist" id="regionlist" class="form-control"">
                                <option value="0">Choose Region</option>
                                <?php foreach($regionlist as $regionselect): ?>
                                    <option value="<?php echo $regionselect->region_code; ?>"
                                        <?php if(isset($user_details->region_code )) {
                                            if($regionselect->region_code == $regionselect->region_code) {
                                                echo " selected";
                                            }
                                        } ?>
                                    >
                                        <?php echo $regionselect->region_name; ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <label for="status" class="col-lg-3 control-label">Activated:</label>
                        <div id="div_status" class="col-lg-9">
                            <select name="status" id="status" class="form-control"">
                                <option value="<?php echo $user_details->activated; ?>"
                                ><?php echo ($user_details->activated ? 'Yes' : 'No') ; ?>
                                </option>
                                <option value="1">Yes</option>
                                <option value="0">No</option>
                            </select>
                        </div>
                    </div>

                    <div class="btn-group">
                        <?php /*  <button class="btn btn-success" type="submit" name="submit" value="submit"><i class="fa fa-save"></i> Save</button>
            <a class="btn btn-warning btn-group" href="familyinfo"><i class="fa fa-refresh"></i> Cancel</a> */?>

                        <input id="btn_succes" name="btn_success" type="submit" class="btn btn-primary" value="Update" />
                        <input id="btn_cancel" name="btn_cancel" type="reset" class="btn btn-danger" value="Cancel" />
                    </div>
                    <div><br>
                        <a class="btn btn-sm btn-warning" href="<?php echo base_url('access_control/users') ?>">Back</a>
                    </div>
                    <fieldset>


                    </div>
            </form>
        </div>
    </div>
</div>
        </div>