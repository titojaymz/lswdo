<!DOCTYPE html>
<div class="content">
    <div class="page-header">
        <h1 class="title">Users List</h1>
    </div>
    <div class="container-padding">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-title">
                        Users
                    </div>
                    <a class="btn btn-sm btn-primary"  href="<?php echo base_url('access_control/addUser') ?>"><i class="fa fa-plus"></i>Add New User</a><br><br>
                    <div class="panel-body table-responsive">
                        <table id="example0" class="table display table-bordered table-striped table-hover">
                            <tr>
                                <td colspan = "2">Actions</td>
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
                                    <td><a onclick="return confirm('Are you sure ?')" class="btn btn-sm btn-primary"  href="<?php echo base_url('access_control/delete_Userinfo'.'/'.$user->uid) ?>"><i class="fa fa-bullseye"></i>Deactivate</a></td>
                                    <td><?php echo $user->username; ?></td>
                                    <td><?php echo $user->email; ?></td>
                                    <td><?php echo $user->firstname.' '.$user->middlename.' '.$user->surname.' '.$user->extensionname; ?></td>
                                    <td><?php echo $user->region_name; ?></td>
                                    <td><?php if($user->activated == 1){ echo 'Yes'; } else { echo 'No'; }; ?></td>
                                    <td><?php if($user->user_level == -1){ echo 'Administrator'; } else { echo 'Default/Staff'; } ?></td>
                                </tr>
                            <?php endforeach ?>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>