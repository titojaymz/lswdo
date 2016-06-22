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

?>

<body>
<div class="content">

    <!-- Start Page Header -->
    <div class="page-header">
        <!-- <h1 class="title">Tool for the Assessment of FUNCTIONALITY of LSWDOs</h1>-->
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url('dashboardc/dashboard'); ?>">Home</a></li>
            <li class="active">Libraries</li>
            <li class="active">Provinces</li>
            <li class="active">Add</li>
        </ol>
    </div>
    <!-- End Page Header -->

    <div class = "row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-title">
                    <form method="post" class="form-horizontal">
                        <div class="form-group">
                            <label for="geo_info" class="control-label"> Libraries: Provinces </label>
                        </div>

                        <div class="form-group">
                            <label for="prov_code">Province Code:</label>
                            <input class="form-control" type="text" name="prov_code" value="<?php echo set_value('prov_code') ?>" placeholder="Province Code" required>
                        </div>

                        <div class="form-group">
                            <label for="prov_name">Province Name:</label>
                            <input class="form-control" type="text" name="prov_name" value="<?php echo set_value('prov_name') ?>" placeholder="Province Name" required>
                        </div>

                        <div class="form-group">
                            <label for="region_code">Region Code:</label>
                            <input class="form-control" type="text" name="region_code" value="<?php echo set_value('region_code') ?>" placeholder="Region Code" required>
                        </div>

                        <div class="form-group">
                            <label for="income_class">Income Class:</label>
                            <input class="form-control" type="text" name="income_class" value="<?php echo set_value('income_class') ?>" placeholder="Income Class" required>
                        </div>

                        <div class="form-group">
                            <div class="btn-group">
                                <button class="btn btn-success" type="submit" name="submit" value="submit"><i class="fa fa-save"></i> Save</button>
                                <a class="btn btn-warning btn-group" href="<?php echo base_url('lib_provc/index'); ?>"><i class="fa fa-refresh"></i> Cancel</a>
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