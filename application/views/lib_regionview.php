<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Created by PhpStorm
 * User: mglveniegas
 *
 */
if (!$this->session->userdata('user_id')){
    redirect('/users/login','location');
}
?>
<body>
<div class="content">

    <!-- Start Page Header -->
    <div class="page-header">
        <!-- <h1 class="title">Tool for the Assessment of FUNCTIONALITY of LSWDOs</h1>-->
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url('dashboardc/dashboard'); ?>">Home</a></li>
            <li class="active">Region Libraries</li>
            <li class="active">View</li>
        </ol>
    </div>
    <!-- End Page Header -->

    <div class = "row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-title">

                    <div class="form-group">
                        <label for="geo_info" class="control-label"> View: Region </label>
                    </div>
                    <a class="btn btn-sm btn-warning" href="<?php echo base_url('lib_regionc/index') ?>"><i class="fa fa-arrow-left"></i> Back to list</a>

                    <br><br>
                    <table class="table table-bordered">
                        <tr>
                            <th>Region Code:</th><td><?php echo $region_code ?></td>
                        </tr>
                        <tr>
                            <th>Region Name:</th><td><?php echo $region_name ?></td>
                        </tr>
                        <tr>
                            <th>Region Nickname:</th><td><?php echo $region_nick ?></td>
                        </tr>
                        <tr>
                            <th>Created by:</th><td><?php echo $created_by ?></td>
                        </tr>
                        <tr>
                            <th>Date Created:</th><td><?php echo $date_created ?></td>
                        </tr>
                        <tr>
                            <th>Modified by:</th><td><?php echo $modified_by ?></td>
                        </tr>
                        <tr>
                            <th>Date Modified:</th><td><?php echo $date_modified ?></td>
                        </tr>


                    </table>

                </div>
                <div class="col-md-2"></div>
            </div>
        </div>
        </form>
    </div>
    <div class="col-md-3"></div>
</div>
</div>
</div>
</div>

</div>
</body>