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
            <li class="active">Barangay</li>
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
                            <label for="geo_info" class="control-label"> Libraries: Barangay </label>
                        </div>

                        <div class="form-group">
                            <label for="brgy_code">Barangay Code:</label>
                            <input class="form-control" type="text" name="brgy_code" value="<?php echo set_value('brgy_code') ?>" placeholder="Barangay Code" required>
                        </div>

                        <div class="form-group">
                            <label for="brgy_name">Barangay Name:</label>
                            <input class="form-control" type="text" name="brgy_name" value="<?php echo set_value('brgy_name') ?>" placeholder="Barangay Name" required>
                        </div>


                        <div class="form-group">
                            <label for="city_code">City Code:</label>
                            <select class="form-control" name="city_code" id="city_code">
                                <option select value="">Please select</option>
                                <?php foreach($city as $cities): ?>
                                    <option value="<?php echo $cities->city_code ?>"><?php echo $cities->city_name ?></option>
                                <?php endforeach ?>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="rural_urban">Rural Urban:</label>
                            <input class="form-control" type="text" name="rural_urban" value="<?php echo set_value('rural_urban') ?>" placeholder="Rural Urban" required>
                        </div>
                        <div class="form-group">
                            <label for="old_brgy_psgc">Old Barangay PSGC:</label>
                            <input class="form-control" type="text" name="old_brgy_psgc" value="<?php echo set_value('old_brgy_psgc') ?>" placeholder="Old Barangay PSGC" required>
                        </div>
                        <div class="form-group">
                            <label for="total_pop">Total Population:</label>
                            <input class="form-control" type="text" name="total_pop" value="<?php echo set_value('total_pop') ?>" placeholder="Total Population" required>
                        </div>
                        <div class="form-group">
                            <label for="Total_Poor_HHs">Total Poor HHs:</label>
                            <input class="form-control" type="text" name="Total_Poor_HHs" value="<?php echo set_value('Total_Poor_HHs') ?>" placeholder="Total Poor HHs" required>
                        </div>
                        <div class="form-group">
                            <label for="Total_Poor_Families">Total Poor Families:</label>
                            <input class="form-control" type="text" name="Total_Poor_Families" value="<?php echo set_value('Total_Poor_Families') ?>" placeholder="Total Poor Families" required>
                        </div>

                        <div class="form-group">
                            <div class="btn-group">
                                <button class="btn btn-success" type="submit" name="submit" value="submit"><i class="fa fa-save"></i> Save</button>
                                <a class="btn btn-warning btn-group" href="<?php echo base_url('lib_brgyc/index'); ?>"><i class="fa fa-refresh"></i> Cancel</a>
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