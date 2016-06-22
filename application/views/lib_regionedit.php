<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Created by PhpStorm
 * User: mglveniegas
 *
 */
if (!$this->session->userdata('user_id')){
    redirect('/users/login','location');
}

//echo validation_errors();
//echo $form_message;
?>
<body>

<div class="content">
    <!-- Start Page Header -->
    <div class="page-header">
        <!-- <h1 class="title">Tool for the Assessment of FUNCTIONALITY of LSWDOs</h1>-->
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url('dashboardc/dashboard'); ?>">Home</a></li>
            <li class="active"> Libraries </li>
            <li class="active"> Region </li>
            <li class="active"> Edit </li>
        </ol>
    </div>
    <!-- End Page Header -->
    <div class = "row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-title">
                    <form method="post" class="form-horizontal">
                        <div class="form-group">
                            <label for="geo_info" class="control-label">Geographic Information: Identifying Information</label>
                        </div>
                    <div class="form-group">
                        <label for="region_code">Region Code:</label>
                        <input class="form-control" type="text" name="region_code" value="<?php echo $region_details->region_code ?>" placeholder="Region Code" readonly>
                    </div>
                    <div class="form-group">
                        <label for="region_name">Region Name:</label>
                        <input class="form-control" type="text" name="region_name" value="<?php echo $region_details->region_name ?>" placeholder="Region Name">
                    </div>

                    <div class="form-group">
                        <label for="region_nick">Region Nickname:</label>
                        <input class="form-control" type="text" name="region_nick" value="<?php echo $region_details->region_nick ?>" placeholder="Region Nickname">
                    </div>

                        <div class="form-group">
                            <div class="btn-group">
                                <button class="btn btn-success" type="submit" name="submit" value="submit"><i class="fa fa-save"></i> Save</button>
                                <a class="btn btn-warning btn-group" href="<?php echo base_url('assessmentinfo/index') ?>"><i class="fa fa-refresh"></i> Cancel</a>
                            </div>
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