<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Created by PhpStorm
 * User: mglveniegas
 *
 */

?>
<body>
<div class="content">

    <!-- Start Page Header -->
    <div class="page-header">
        <!-- <h1 class="title">Tool for the Assessment of FUNCTIONALITY of LSWDOs</h1>-->
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url('dashboardc/dashboard/'); ?>">Home</a></li>
            <li><a href="<?php echo base_url('assessmentinfo/index/0'); ?>">Assessment Information</a></li>
            <li class="active">Budget Allocation</li>
        </ol>
    </div>
    <!-- End Page Header -->
    <?php if ($form_message <> ''){ ?>
        <div class="alert alert-success">
            <?php echo $form_message ?>
        </div>
    <?php } ?>
    <div class = "row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-title">
                    <div class="form-group">
                        <label for="list_info" class="control-label">Budget Allocation List</label>
                    </div>

                    <a class="btn btn-sm btn-warning" href="<?php echo base_url('assessmentinfo/index/0') ?>"><i class="fa fa-arrow-left"></i> Back to list</a>
                    <a class="btn btn-sm btn-success" href="<?php echo base_url('budgetallocation/addBudgetAllocation/'.$profID. '/0') ?>"><i class="fa fa-plus-circle"></i> Add Budget Allocation</a>

                </div>
                <div class = "panel-body" style="display: block;">

                    <div class="modal fade" id="myModal2" tabindex="-1" role="dialog" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">

                                <div class="modal-body">

                                </div>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <div class="panel-body table-responsive">

                    <table class="table table-bordered table-striped">
                        <thead>
                        <tr>
                            <th>Province</th>
                            <th>City</th>
                            <th>Sector ID</th>
                            <th>Year Indicated</th>
                            <th>Budget for the Previous Year</th>
                            <th>Budget for the Present Year</th>
                            <th>Utilization</th>
                            <th>Number of Beneficiaries Served</th>
                            <th>Number of Target Beneficiaries</th>
                            <th> </th>

                        </tr>
                        </thead>
                        <tbody>
                        <?php foreach($budgetallocation_data as $budgetallocationData): ?>

                            <tr>
                                <td><?php echo $budgetallocationData->prov_name ?></td>
                                <td><?php echo $budgetallocationData->city_name ?></td>
                                 <td><?php echo $budgetallocationData->sector_name ?></td>
                                <td><?php echo $budgetallocationData->year_indicated ?></td>
                                <td><?php echo $budgetallocationData->budget_previous_year ?></td>
                                <td><?php echo $budgetallocationData->budget_present_year ?></td>
                                <td><?php echo $budgetallocationData->utilization ?></td>
                                <td><?php echo $budgetallocationData->no_bene_served ?></td>
                                <td><?php echo $budgetallocationData->no_target_bene ?></td>

                              <!--                    <td><a class="btn btn-xs btn-success" href="--><?php //echo base_url('indicator/indicatorViewpart2/' . $assessmentinfoData->profile_id) ?><!--"><i class="fa fa-list"></i> Add Indicator part 2 </a></td>-->
                                <!--                    <td><a class="btn btn-xs btn-success" href="--><?php //echo base_url('indicator/indicatorViewpart3/' . $assessmentinfoData->profile_id) ?><!--"><i class="fa fa-list"></i> Add Indicator part 3 </a></td>-->
                                <td>
                                    <div class="btn-group">
                                        <a class="btn btn-xs btn-info" href="<?php echo base_url('budgetallocation/budgetallocation_masterview/' . $budgetallocationData->profile_id. '/' .$budgetallocationData->sector_id. '/0') ?>"><i class="fa fa-plus"></i> View </a>
                                    </div>
                                    <div class="btn-group">
                                        <a class="btn btn-sm btn-primary" href="<?php echo base_url('budgetallocation/editBudgetAllocation/' . $budgetallocationData->profile_id . '/'.$budgetallocationData->sector_id.'') ?>"><i class="fa fa-edit"></i> </a>
                                    </div>

                                    <!--      <div class="btn-group">
                                        <a class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete selected record?')"  href="<?php echo base_url('budgetallocation/delete_budgetallocation/' . $budgetallocationData->profile_id) ?>"><i class="fa fa-trash"> </i> </a>
                                    </div>-->

                                </td>
                            </tr>
                        <?php endforeach ?>
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
        <!-- End Panel -->
    </div>
</div>
<br>


<script>
    $(document).ready(function() {
        $('#example0').DataTable();
    } );
</script>



<script>
    $(document).ready(function() {
        var table = $('#example').DataTable({
            "columnDefs": [
                { "visible": false, "targets": 2 }
            ],
            "order": [[ 2, 'asc' ]],
            "displayLength": 25,
            "drawCallback": function ( settings ) {
                var api = this.api();
                var rows = api.rows( {page:'current'} ).nodes();
                var last=null;

                api.column(2, {page:'current'} ).data().each( function ( group, i ) {
                    if ( last !== group ) {
                        $(rows).eq( i ).before(
                            '<tr class="group"><td colspan="5">'+group+'</td></tr>'
                        );

                        last = group;
                    }
                } );
            }
        } );

        // Order by the grouping
        $('#example tbody').on( 'click', 'tr.group', function () {
            var currentOrder = table.order()[0];
            if ( currentOrder[0] === 2 && currentOrder[1] === 'asc' ) {
                table.order( [ 2, 'desc' ] ).draw();
            }
            else {
                table.order( [ 2, 'asc' ] ).draw();
            }
        } );
    } );
</script>