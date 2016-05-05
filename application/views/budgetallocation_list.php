<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Created by PhpStorm
 * User: mglveniegas
 *
 */

?>
<body>
<div class="content">

    <div class = "row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-title">
                    <div class="form-group">
                        <label for="list_info" class="control-label">Budget Allocation List</label>
                    </div>
                    <a class="btn btn-sm btn-warning" href="<?php echo base_url('assessmentinfo/index') ?>"><i class="fa fa-arrow-left"></i> Back to list</a>
                    <a class="btn btn-sm btn-success" href="<?php echo base_url('budgetallocation/addBudgetAllocation/'.$profID) ?>"><i class="fa fa-plus-circle"></i> Add Budget Allocation</a>

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
                            <th>Sector ID</th>
                            <th>Year Indicated</th>
                            <th>Budget for the Previous Year</th>
                            <th>Utilization</th>
                            <th>Budget for the Present Year</th>
                            <th>Number of Beneficiaries Served</th>
                            <th>Number of Target Beneficiaries</th>
                            <th> </th>


                        </tr>
                        </thead>
                        <tbody>
                        <?php foreach($budgetallocation_data as $budgetallocationData): ?>
                            <tr>
                                <td><?php echo $budgetallocationData->sector_name ?></td>
                                <td><?php echo $budgetallocationData->year_indicated ?></td>
                                <td><?php echo $budgetallocationData->budget_previous_year ?></td>
                                <td><?php echo $budgetallocationData->utilization ?></td>
                                <td><?php echo $budgetallocationData->budget_present_year ?></td>
                                <td><?php echo $budgetallocationData->no_bene_served ?></td>
                                <td><?php echo $budgetallocationData->no_target_bene ?></td>

                              <!--                    <td><a class="btn btn-xs btn-success" href="--><?php //echo base_url('indicator/indicatorViewpart2/' . $assessmentinfoData->profile_id) ?><!--"><i class="fa fa-list"></i> Add Indicator part 2 </a></td>-->
                                <!--                    <td><a class="btn btn-xs btn-success" href="--><?php //echo base_url('indicator/indicatorViewpart3/' . $assessmentinfoData->profile_id) ?><!--"><i class="fa fa-list"></i> Add Indicator part 3 </a></td>-->
                                <td>
                                    <div class="btn-group">
                                        <a class="btn btn-sm btn-primary" href="<?php echo base_url('budgetallocation/editBudgetAllocation/' . $budgetallocationData->profile_id . '/'.$budgetallocationData->sector_id) ?>"><i class="fa fa-edit"></i> </a>
                                    </div>
                                    <div class="btn-group">
                                        <a class="btn btn-xs btn-info" href="<?php echo base_url('budgetallocation/budgetallocation_masterview/' . $budgetallocationData->profile_id) ?>"><i class="fa fa-plus"></i> View </a>
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