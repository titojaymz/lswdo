<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Created by JOSEF FRIEDRICH S. BALDO
 * Date Time: 10/18/15 12:33 AM
 */

?>
<body>
<div class="content">

    <div class = "row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-title">
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
                <th>Profile ID</th>
                <th>Status of Application</th>
                <th>LGU Type</th>
                <th>SWDO Name</th>
                <th>Total IRA</th>
                <th>Total Budget LSWDO</th>


            </tr>
            </thead>
            <tbody>
            <?php foreach($assessmentinfo_data as $assessmentinfoData): ?>
                <tr>
                    <td><?php echo $assessmentinfoData->profile_id ?></td>
                    <td><?php echo $assessmentinfoData->application_type_id ?></td>
                    <td><?php echo $assessmentinfoData->lgu_type_id ?></td>
                    <td><?php echo $assessmentinfoData->swdo_name ?></td>
                    <td><?php echo $assessmentinfoData->total_ira ?></td>
                    <td><?php echo $assessmentinfoData->total_budget_lswdo ?></td>

                    <td><a class="btn btn-xs btn-success" href="<?php echo base_url('assessmentinfo/assessmentinfo_masterview/' . $assessmentinfoData->profile_id . '.html') ?>"><i class="fa fa-list"></i> View </a></td>
                    <td><a class="btn btn-xs btn-success" href="<?php echo base_url('indicator/indicatorView/' . $assessmentinfoData->profile_id) ?>"><i class="fa fa-list"></i> Add Indicator </a></td>
                    <td><a class="btn btn-xs btn-success" href="<?php echo base_url('indicator/indicatorViewpart2/' . $assessmentinfoData->profile_id) ?>"><i class="fa fa-list"></i> Add Indicator part 2 </a></td>
                    <td><a class="btn btn-xs btn-success" href="<?php echo base_url('indicator/indicatorViewpart3/' . $assessmentinfoData->profile_id) ?>"><i class="fa fa-list"></i> Add Indicator part 3 </a></td>
                    <td>
                        <div class="btn-group">
                            <a class="btn btn-sm btn-primary" href="<?php echo base_url('assessmentinfo/editAssessmentinfo/' . $assessmentinfoData->profile_id . '.html') ?>"><i class="fa fa-edit"></i> </a>

                        </div>

                    </td>
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