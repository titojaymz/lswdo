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
            <li class="active">Cities</li>
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
                            <label for="geo_info" class="control-label"> Libraries: City </label>
                        </div>

                        <div class="form-group">
                            <label for="city_code">City Code:</label>
                            <input class="form-control" type="text" name="city_code" value="<?php echo set_value('city_code') ?>" placeholder="City Code" required>
                        </div>

                        <div class="form-group">
                            <label for="city_name">City Name:</label>
                            <input class="form-control" type="text" name="city_name" value="<?php echo set_value('city_name') ?>" placeholder="City Name" required>
                        </div>


                        <div class="form-group">
                            <label for="prov_code">Province Code:</label>
                            <select class="form-control" name="prov_code" id="prov_code">
                                <option select value="">Please select</option>
                                <?php foreach($prov as $provs): ?>
                                    <option value="<?php echo $provs->prov_code ?>"><?php echo $provs->prov_name ?></option>
                                <?php endforeach ?>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="district">District:</label>
                            <input class="form-control" type="text" name="district" value="<?php echo set_value('district') ?>" placeholder="District" required>
                        </div>

                        <div class="form-group">
                            <label for="city_class">City Class:</label>
                            <input class="form-control" type="text" name="city_class" value="<?php echo set_value('city_class') ?>" placeholder="City Class" required>
                        </div>

                        <div class="form-group">
                            <label for="income_class">Income Class:</label>
                            <input class="form-control" type="text" name="income_class" value="<?php echo set_value('income_class') ?>" placeholder="Income Class" required>
                        </div>

                        <div class="form-group">
                            <div class="btn-group">
                                <button class="btn btn-success" type="submit" name="submit" value="submit"><i class="fa fa-save"></i> Save</button>
                                <a class="btn btn-warning btn-group" href="<?php echo base_url('lib_cityc/index'); ?>"><i class="fa fa-refresh"></i> Cancel</a>
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