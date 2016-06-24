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
            <li class="active"> Cities </li>
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
                            <label for="geo_info" class="control-label">Libraries: Cities</label>
                        </div>
                        <div class="form-group">
                            <label for="city_code">City Code:</label>
                            <input class="form-control" type="text" name="city_code" value="<?php echo $city_details->city_code ?>" placeholder="City Code" readonly>
                        </div>
                        <div class="form-group">
                            <label for="city_name">City Name:</label>
                            <input class="form-control" type="text" name="city_name" value="<?php echo $city_details->city_name ?>" placeholder="City Name">
                        </div>

                        <div class="form-group">
                            <label for="prov_code">Province Code:</label>
                            <select name="prov_code" id="prov_code" class="form-control"">
                            <option value="0">-Please select-</option>
                            <?php foreach($prov as $provs): ?>
                                <option value="<?php echo $provs->prov_code; ?>"
                                    <?php if(isset($city_details->prov_code)) {
                                        if($provs->prov_code == $city_details->prov_code) {
                                            echo " selected";
                                        }
                                    } ?>
                                    >
                                    <?php echo $provs->prov_name; ?>
                                </option>
                            <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="district">District:</label>
                            <input class="form-control" type="text" name="district" value="<?php echo $city_details->district ?>" placeholder="District">
                        </div>
                        <div class="form-group">
                            <label for="city_class">City Class:</label>
                            <input class="form-control" type="text" name="city_class" value="<?php echo $city_details->city_class ?>" placeholder="City Class">
                        </div>
                        <div class="form-group">
                            <label for="income_class">Income Class:</label>
                            <input class="form-control" type="text" name="income_class" value="<?php echo $city_details->income_class ?>" placeholder="Income Class">
                        </div>

                        <div class="form-group">
                            <div class="btn-group">
                                <button class="btn btn-success" type="submit" name="submit" value="submit"><i class="fa fa-save"></i> Save</button>
                                <a class="btn btn-warning btn-group" href="<?php echo base_url('lib_cityc/index') ?>"><i class="fa fa-refresh"></i> Cancel</a>
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