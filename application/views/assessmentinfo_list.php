<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Created by PhpStorm
 * User: mglveniegas
 *
 */

?>
<body>
<?php if ($form_message <> ''){ ?>
    <div class="alert alert-success">
        <?php echo $form_message ?>
    </div>
<?php } ?>
<div class="content">

    <div class = "row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-title">
                    <div class="form-group">
                        <label for="list_info" class="control-label">Assessment Information List</label>
                    </div>

                    <a class="btn btn-sm btn-success" href="<?php echo base_url('assessmentinfo/addAssessmentinfo') ?>"><i class="fa fa-plus-circle"></i> Add Assessment Info</a>

                </div>
                <div class = "panel-body" style="display: block;">
                    <?php if ($form_message <> '') { ?>
                        <div class="alert alert-success">
                            <strong><?php echo $form_message ?></strong>
                        </div>
                    <?php } ?>
                    <?php if (validation_errors() <> '') { ?>
                        <div class="alert alert-danger">
                            <strong><?php echo validation_errors() ?></strong>
                        </div>
                    <?php } ?>

                    <table class="table table-bordered table-striped">
                        <thead>
                        <tr>
                            <th>&nbsp;</th>
                            <th>&nbsp;</th>
                            <th>&nbsp;</th>
                           <!-- <th>&nbsp;</th>-->
                            <th>Name of SWDO Officer/Head</th>
                            <th>Status of Application</th>
                            <th>LSWDO Type</th>

                            <th>Total Internal Revenue Allotment</th>
                            <th>Total Budget LSWDO</th>


                        </tr>
                        </thead>
                        <tbody>
                        <?php foreach($assessmentinfo_data as $assessmentinfoData): ?>
                            <tr>
                                <td>
                                    <div class="btn-group">
                                        <a class="btn btn-sm btn-primary" href="<?php echo base_url('assessmentinfo/editAssessmentinfo/' . $assessmentinfoData->profile_id . '.html') ?>"><i class="fa fa-edit"></i> </a>

                                    </div>

                                </td>
                                <td><a class="btn btn-xs btn-success" href="<?php echo base_url('assessmentinfo/assessmentinfo_masterview/' . $assessmentinfoData->profile_id . '.html') ?>"><i class="fa fa-list"></i> View </a></td>
                                <!--<td><a class="btn btn-xs btn-success" href=sss"<?php /*echo base_url('indicator/indicatorView/' . $assessmentinfoData->profile_id) */?>"><i class="fa fa-list"></i> Indicators </a></td>-->
                                <td><a class="btn btn-xs btn-success" href="<?php echo base_url('monitoring/monitoring_list/' . $assessmentinfoData->profile_id) ?>"><i class="fa fa-list"></i> Indicators </a></td>
                                <!-- <td> <a onclick="return confirm('are you sure?')" class="btn btn-sm btn-danger" href="<?php echo base_url('assessmentinfo/delete_assessmentinfo/' . $assessmentinfoData->profile_id . '.html') ?>"><i class="fa fa-trash"></i> </a></td>-->
                                <td><?php echo $assessmentinfoData->swdo_name ?></td>
                                <td><?php echo $assessmentinfoData->application_type_name ?></td>
                                <td><?php echo $assessmentinfoData->lgu_type_name ?></td>
                                <td><?php echo $assessmentinfoData->total_ira ?></td>
                                <td><?php echo $assessmentinfoData->total_budget_lswdo ?></td>


                                <!--                    <td><a class="btn btn-xs btn-success" href="--><?php //echo base_url('indicator/indicatorViewpart2/' . $assessmentinfoData->profile_id) ?><!--"><i class="fa fa-list"></i> Add Indicator part 2 </a></td>-->
                                <!--                    <td><a class="btn btn-xs btnasdasdasdas-success" href="--><?php //echo base_url('indicator/indicatorViewpart3/' . $assessmentinfoData->profile_id) ?><!--"><i class="fa fa-list"></i> Add Indicator part 3 </a></td>-->

                            </tr>
                        <?php endforeach ?>
                        </tbody>
                    </table>
                </div>
                <div class="col-md-1"></div>
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