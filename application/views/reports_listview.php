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
    function get_nameofCity() {
        var prov_code = $('#provlist').val();
        var city_code = $('#citylist').val();
        if(prov_code > 0) {

                    $('#city_pass').val(city_code);

        } else {
            $('#citylist option:gt(0)').remove().end();
        }
    }


    function get_lguType(lguType){

        if(lguType == 1){
            document.getElementById("groupLGUregion").style.display = "block";
            document.getElementById("groupLGUProvince").style.display = "none";
            document.getElementById("groupLGUCity").style.display = "none";

        } else if(lguType == 2 || lguType == 3){
            document.getElementById("groupLGUregion").style.display = "block";
            document.getElementById("groupLGUProvince").style.display = "block";
            document.getElementById("groupLGUCity").style.display = "none";
        } else if(lguType == 4) {
            document.getElementById("groupLGUregion").style.display = "block";
            document.getElementById("groupLGUProvince").style.display = "block";
            document.getElementById("groupLGUCity").style.display = "block";
        } else {
            document.getElementById("groupLGUregion").style.display = "none";
            document.getElementById("groupLGUProvince").style.display = "none";
            document.getElementById("groupLGUCity").style.display = "none";
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
                            <!--LGU Type-->
                            <div id="groupLGUType">
                                <div class="form-group form-group-sm">
                                    <label for="lgulist" class="col-lg-2 control-label">LGU Type</label>
                                    <div id="div_lgulist" class="col-lg-8">
                                        <select id="LGUtype" name = "LGUtype" class="form-control" onchange = "get_lguType(this.value);">
                                            <option value = "0">Please Select</option>
                                            <option value = "1">PSWDO</option>
                                            <option value = "2">CSWDO</option>
                                            <option value = "3">MSWDO</option>
                                            <option value = "4">LSWDO</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div id="groupLGUregion" style = "display: none;">
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
                            <div id="groupLGUProvince"  style = "display: none;">
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
                                                <option value = "0">Select Region First</option>
                                                <?php
                                            } ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <!--End Province-->
                            <!--City-->
                            <div id="groupLGUCity"  style = "display: none;">
                                <div class="form-group form-group-sm">
                                    <label for="citylist" class="col-lg-2 control-label">City</label>
                                    <div id="div_citylist" class="col-lg-8">
                                        <select id="citylist" name="citylist" class="form-control" onChange="get_nameofCity();">
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
                                                <option value = "0">Select Province First</option>
                                                <?php
                                            } ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <!--End City-->

                            <input type = 'hidden' id ='prov_pass' name = 'prov_pass' class="form-control">
                            <input type = 'hidden' id ='city_pass' name = 'city_pass' class="form-control">
                            <div class="btn-group">
                                <button type="submit" name="submit" value="submit" class="btn btn-sm btn-success">Generate</button>
                            </div>

                            <?php echo form_close() ?>
                            </table>
                        <?php if(isset($submit)){ ?>
                        <table class="table display table-bordered table-striped table-hover" width="100%">
<!--                            <pre>
                            <?php /*echo $regionlist2; */?>
                            <?php /*echo $provlist2; */?>
                            <?php /*echo $citylist2; */?>
                            <?php /*echo $LGUtype2; */?>
                            </pre>-->
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
                                    <a class="btn btn-light" href="<?php echo base_url('reports/distributionLSWDObyregion') ?>"></i>Distribution LSWDO by Region</a>
                                </td>
                                <td>
                                    <a class="btn btn-light" href="<?php echo base_url('reports/distributionPSWDObyregion') ?>"></i>Distribution PSWDO by Region</a>
                                </td>
                                <td>
                                    <a class="btn btn-light" href="<?php echo base_url('reports/distributionCSWDObyregion') ?>"></i>Distribution CSWDO by Region</a>
                                </td>
                                <td>
                                    <a class="btn btn-light" href="<?php echo base_url('reports/distributionMSWDObyregion') ?>"></i>Distribution CSWDO by Region</a>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <a class="btn btn-light" href="<?php echo base_url('reports/distributionofPSWDOFunctionalityregion/') ?>"></i>Distribution PSWDO Functionality by Region</a>
                                </td>
                                <td>
                                    <a class="btn btn-light" href="<?php echo base_url('reports/distributionofCSWDOFunctionalityregion/') ?>"></i>Distribution CSWDO Functionality by Region</a>
                                </td>
                                <td>
                                    <a class="btn btn-light" href="<?php echo base_url('reports/distributionofMSWDOFunctionalityregion/') ?>"></i>Distribution MSWDO Functionality by Region</a>
                                </td>

                            </tr>
                            <tr>
                                <td>
                                    <a class="btn btn-light" href="<?php echo base_url('reports/distributionofCMSWDOFunctionalityprovince/'.$regionlist2.'/'.$provlist2.'') ?>"></i>Distribution C/MSWDO Functionality by Province</a>
                                </td>

                            </tr>
                            <tr>
                                <td>
                                    <a class="btn btn-light" href="<?php echo base_url('reports/pswdo_scoreladderized/'.$regionlist2.'') ?>"></i>Score of PSWDO, by ladderized scaling by Region</a>
                                </td>
                                <td>
                                    <a class="btn btn-light" href="<?php echo base_url('reports/cswdo_scoreladderized/'.$regionlist2.'/'.$provlist2.'') ?>"></i>Score of CSWDO, by ladderized scaling by Region</a>
                                </td>
                                <td>
                                    <a class="btn btn-light" href="<?php echo base_url('reports/mswdo_scoreladderized/'.$regionlist2.'/'.$provlist2.'') ?>"></i>Score of MSWDO, by ladderized scaling by Region</a>
                                </td>
                            </tr>
                        </table>
                        <table class="table display table-bordered table-striped table-hover" width="100%">
                            <tr>
                                <td>
                                    <a class="btn btn-light" href="<?php echo base_url('reports/nonCompliantPSWDO/'.$regionlist2.'/'.$provlist2.'/'.$LGUtype2.'') ?>">PSWDO - Non-Compliant Indicator</a>
                                </td>
                            </tr>

                        </table>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
