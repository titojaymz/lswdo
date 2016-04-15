<?php
/**
 * Created by PhpStorm.
 * User: mblejano
 * Date: 4/13/2016
 * Time: 1:36 PM
 */
?>
<script type="text/javascript">
    function get_provinces() {
        var region_code = $('#regionlist').val();
        $('#citylist option:gt(0)').remove().end();
        $('#brgylist option:gt(0)').remove().end();
        if(region_code > 0) {
            $.ajax({
                url: "<?php echo base_url('assessmentinfo/populate_prov'); ?>",
                async: false,
                type: "POST",
                data: "region_code="+region_code,
                dataType: "html",
                success: function(data) {
                    $('#div_provlist').html(data);
                }
            });
        } else {
            $('#provlist option:gt(0)').remove().end();
        }
    }

    function get_cities() {
        var prov_code = $('#provlist').val();
        $('#brgylist option:gt(0)').remove().end();
        if(prov_code > 0) {
            $.ajax({
                url: "<?php echo base_url('assessmentinfo/populate_cities'); ?>",
                async: false,
                type: "POST",
                data: "prov_code="+prov_code,
                dataType: "html",
                success: function(data) {
                    $('#div_citylist').html(data);
                    $('#prov_pass').val(prov_code);
                }
            });

        } else {
            $('#citylist option:gt(0)').remove().end();
        }
    }

</script>
<div class="content">
    <div class="page-header">
        <h1 class="title">Reports List</h1>
    </div>
    <div class="container-padding">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-title">
                        Reports
                    </div>
                    <div class="panel-body table-responsive">
                        <table class="table display table-bordered table-striped table-hover" width="100%">

                            <?php echo form_open('reports/viewTable',array('class'=>'form-horizontal')) ?>
                            <div id="groupLGUregion">
                                <div class="form-group form-group-sm">
                                    <label for="regionlist" class="col-lg-2 control-label">Region</label>
                                    <div id="div_regionlist" class="col-lg-8">
                                        <fieldset>
                                            <div class="control-group">
                                                <div class="controls">
                                                    <select name="regionlist" id="regionlist" class="form-control" onChange="get_provinces();">
                                                        <option value="0">Choose Region</option>
                                                        <?php foreach($regionlist as $regionselect): ?>
                                                            <option value="<?php echo $regionselect->region_code; ?>"
                                                                <?php if(isset($_SESSION['region'])) {
                                                                    if($regionselect->region_code == $_SESSION['region']) {
                                                                        echo " selected";
                                                                    }
                                                                } ?>
                                                            >
                                                                <?php echo $regionselect->region_name; ?>
                                                            </option>
                                                        <?php endforeach; ?>
                                                    </select>
                                                </div>
                                            </div>
                                    </div>
                                </div>
                            </div>
                            <!--END Region-->

                            <!--Province-->
                            <div id="groupLGUProvince">
                                <div class="form-group form-group-sm">
                                    <label for="provlist" class="col-lg-2 control-label">Province</label>
                                    <div id="div_provlist" class="col-lg-8">
                                        <select id="provlist" name="provlist" class="form-control" onChange="get_cities();">
                                            <?php if(isset($_SESSION['province']) or isset($_SESSION['region'])) {
                                                ?>
                                                <option value="0">Choose Province</option>
                                                <?php
                                                foreach ($provlist as $provselect) { ?>
                                                    <option value="<?php echo $provselect->prov_code; ?>"
                                                        <?php
                                                        if (isset($_SESSION['province']) and $provselect->prov_code== $_SESSION['province']) {
                                                            echo " selected";
                                                        } ?>
                                                    >
                                                        <?php echo $provselect->prov_name; ?></option>
                                                    <?php
                                                }
                                            } else {
                                                ?>
                                                <option>Select Region First</option>
                                                <?php
                                            } ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <!--End Province-->
                            <!--City-->
                            <div id="groupLGUCity">
                                <div class="form-group form-group-sm">
                                    <label for="citylist" class="col-lg-2 control-label">City</label>
                                    <div id="div_citylist" class="col-lg-8">
                                        <select id="citylist" name="citylist" class="form-control">
                                            <?php if(isset($_SESSION['city']) or isset($_SESSION['province'])) {
                                                ?>
                                                <option value="0">Choose City</option>
                                                <?php
                                                foreach ($citylist as $cityselect) { ?>
                                                    <option value="<?php echo $cityselect->city_code; ?>"
                                                        <?php
                                                        if (isset($_SESSION['city']) and $cityselect->city_code== $_SESSION['city']) {
                                                            echo " selected";
                                                        } ?>
                                                    >
                                                        <?php echo $cityselect->city_name; ?></option>
                                                    <?php
                                                }
                                            } else {
                                                ?>
                                                <option>Select Province First</option>
                                                <?php
                                            } ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <input type = 'hidden' id ='prov_pass' name = 'prov_pass' class="form-control">
                            <div class="btn-group">
                                <button type="submit" name="submit" value="submit" class="btn btn-sm btn-success">Generate</button>
                            </div>

                            <?php echo form_close() ?>
<!--                            <pre>-->
<!--                            --><?php //echo $regionlist2; ?>
<!--                            --><?php //echo $provlist2; ?>
<!--                            </pre>-->
                            <tr>
                                <td>
                                    <a class="btn btn-light" href="<?php echo base_url('reports/pswdo_score/'.$regionlist2.'') ?>"></input>PSWDO Baseline Reports</a>
                                </td>
                                <td>
                                    <a class="btn btn-light" href="<?php echo base_url('reports/pswdo_newscore/'.$regionlist2.'') ?>"></i>PSWDO Updated Reports</a>
                                </td>
                            </tr>

                            <tr>
                                <td>
                                    <a class="btn btn-light" href="<?php echo base_url('reports/cmswdo_score/'.$regionlist2.'/'.$provlist2.'') ?>"></i>C/MSWDO Baseline Reports</a>
                                </td>
                                <td>
                                    <a class="btn btn-light" href="<?php echo base_url('reports/cmswdo_newscore/'.$regionlist2.'/'.$provlist2.'') ?>"></i>C/MSWDO Updated Reports</a>
                                </td>
                            </tr>

                            <tr>
                                <td>
                                <a class="btn btn-light" href="<?php echo base_url('reports/cswdo_score/'.$regionlist2.'/'.$provlist2.'') ?>"></i>CSWDO Baseline Reports</a>
                                </td>
                                <td>
                                    <a class="btn btn-light" href="<?php echo base_url('reports/cswdo_newscore/'.$regionlist2.'/'.$provlist2.'') ?>"></i>CSWDO Updated Reports</a>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <a class="btn btn-light" href="<?php echo base_url('reports/mswdo_score/'.$regionlist2.'/'.$provlist2.'') ?>"></i>MSWDO Baseline Reports</a>
                                </td>
                                <td>
                                    <a class="btn btn-light" href="<?php echo base_url('reports/mswdo_newscore/'.$regionlist2.'/'.$provlist2.'') ?>"></i>MSWDO Updated Reports</a>
                                </td>
                            </tr>

                            <tr>
                                <td>
                                <a class="btn btn-light" href="<?php echo base_url('reports/distributionCMSWDOall/'.$regionlist2.'') ?>">Distribution of CMSWDO ALL(assessed and not assessed)</a>
                                </td>
                                <td>
                                    <a class="btn btn-light" href="<?php echo base_url('reports/distributionCSWDOall/'.$regionlist2.'') ?>">Distribution of CSWDO ALL(assessed and not assessed)</a>
                                </td>
                                <td>
                                    <a class="btn btn-light" href="<?php echo base_url('reports/distributionMSWDOall/'.$regionlist2.'') ?>">Distribution of MSWDO ALL(assessed and not assessed)</a>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <a class="btn btn-light" href="<?php echo base_url('reports/distributionLSWDObyregion/'.$regionlist2.'') ?>"></i>Distribution LSWDO by Region</a>
                                </td>
                                <td>
                                    <a class="btn btn-light" href="<?php echo base_url('reports/distributionPSWDObyregion/'.$regionlist2.'') ?>"></i>Distribution PSWDO by Region</a>
                                </td>
                                <td>
                                    <a class="btn btn-light" href="<?php echo base_url('reports/distributionCSWDObyregion/'.$regionlist2.'') ?>"></i>Distribution CSWDO by Region</a>
                                </td>
                                <td>
                                    <a class="btn btn-light" href="<?php echo base_url('reports/distributionMSWDObyregion/'.$regionlist2.'') ?>"></i>Distribution CSWDO by Region</a>
                                </td>
                            </tr>

                        </table>
                        <table class="table display table-bordered table-striped table-hover" width="100%">
                            <tr>
                                <td><a class="btn btn-sm btn-success" href="<?php echo base_url('reports/tableView/1') ?>"><i class="fa fa-plus-circle"></i>TableView</a></td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
