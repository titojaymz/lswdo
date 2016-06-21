<?php $accessLevel = $this->session->userdata('accessLevel'); ?>
<!DOCTYPE html>
<div class="content">

    <!-- Start Page Header -->
    <div class="page-header">
        <!-- <h1 class="title">Tool for the Assessment of FUNCTIONALITY of LSWDOs</h1>-->
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url('dashboardc/dashboard'); ?>">Home</a></li>
            <li class="active">Access Control </li>
            <li class="active">Users </li>
        </ol>
    </div>
    <!-- End Page Header -->
<!--<pre>-->
<?php //print_r($userslist);?>
<!--</pre>-->
    <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-title">
                        Users List
                    </div>
                    <?php if($accessLevel == -1 || $accessLevel == 5){ ?>
                    <a class="btn btn-sm btn-primary"  href="<?php echo base_url('access_control/addUser') ?>"><i class="fa fa-plus"></i>Add New User</a><br><br>
                    <?php } ?>
                    <div class="panel-body table-responsive">
                        <table id="example0" class="table display table-bordered table-striped table-hover">
                            <tr>
                                <?php if($accessLevel == -1 || $accessLevel == 2){ ?>
                                <td colspan = "2">Actions</td>
                                <?php } else { ?>
                                    <td>Actions</td>
                                <?php } ?>

                                <td>Username</td>
                                <td>Email</td>
                                <td>Full Name</td>
                                <td>Region Name</td>
                                <td>Activated</td>
                                <td>User Level</td>
                            </tr>
                            <?php foreach($userslist as $user):?>
                                <tr>
                                    <td><a class="btn btn-sm btn-primary"  href="<?php echo base_url('access_control/editUser'.'/'. $user->uid) ?>"><i class="fa fa-apple"></i>Edit</a></td>
                                    <?php if($accessLevel == -1 || $accessLevel == 2){ ?>
                                    <?php if($user->activated == 1){ ?>
                                    <td><a onclick="return confirm('Are you sure ?')" class="btn btn-sm btn-primary"  href="<?php echo base_url('access_control/delete_Userinfo'.'/'.$user->uid) ?>"><i class="fa fa-android"></i>Deactivate</a></td>
                                    <?php } else { ?>
                                        <td><a onclick="return confirm('Are you sure ?')" class="btn btn-sm btn-primary"  href="<?php echo base_url('access_control/activate_Userinfo'.'/'.$user->uid) ?>"><i class="fa fa-android"></i>Activate</a></td>
                                    <?php } ?>
                                    <?php } ?>
                                    <td><?php echo $user->username; ?></td>
                                    <td><?php echo $user->email; ?></td>
                                    <td><?php echo $user->firstname.' '.$user->middlename.' '.$user->surname.' '.$user->extensionname; ?></td>
                                    <td><?php echo $user->region_name; ?></td>
                                    <td><?php if($user->activated == 1){ echo 'Yes'; } else { echo 'No'; }; ?></td>
                                    <td><?php echo $user->userlevel_name;?></td>
                                </tr>
                            <?php endforeach ?>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>