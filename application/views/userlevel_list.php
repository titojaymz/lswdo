<!DOCTYPE html>
<div class="content">

    <!-- Start Page Header -->
    <div class="page-header">
        <!-- <h1 class="title">Tool for the Assessment of FUNCTIONALITY of LSWDOs</h1>-->
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url('dashboardc/dashboard'); ?>">Home</a></li>
            <li class="active">Access Control </li>
            <li class="active">User Level </li>
        </ol>
    </div>
    <!-- End Page Header -->

    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-title">
                    Users List
                </div>
                <a class="btn btn-sm btn-primary"  href="<?php echo base_url('userlevel/userlevelAdd') ?>"><i class="fa fa-plus"></i>Add New User Level</a><br><br>
                <div class="panel-body table-responsive">
                    <table id="example0" class="table display table-bordered table-striped table-hover">
                        <tr>
                            <td colspan="1">Actions</td>
                            <td>User Level ID</td>
                            <td>User Level Name</td>
                            <td>Description</td>
                        </tr>
                        <?php foreach($getUserLevel as $userlevel):?>
                            <tr>
                                <td><a class="btn btn-sm btn-primary"  href="<?php echo base_url('userlevel/userlevelEdit/'.$userlevel->userlevel_id) ?>"><i class="fa fa-cubes"></i>Edit</a></td>
<!--                                <td><a class="btn btn-sm btn-danger"  href="--><?php //echo base_url('userlevel/userLevelDelete/'.$userlevel->userlevel_id) ?><!--"><i class="fa fa-cloud"></i>Delete</a></td>-->
                                <td><?php echo $userlevel->userlevel_id; ?></td>
                                <td><?php echo $userlevel->userlevel_name; ?></td>
                                <td><?php echo $userlevel->userlevel_desc; ?></td>
                            </tr>
                        <?php endforeach ?>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
</div>