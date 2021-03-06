<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Created by PhpStorm
 * User: mglveniegas
 *
 */
$accessLevel = $this->session->userdata('accessLevel');
?>
<body>
<div class="content">

    <!-- Start Page Header -->
    <div class="page-header">
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url('dashboardc/dashboard/'); ?>">Home</a></li>
            <li><a href="<?php echo base_url('assessmentinfo/index/0'); ?>">Assessment Information</a></li>
            <li class="active">List</li>
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
                        <label for="list_info" class="control-label">Assessment Information List</label>
                    </div>
            <?php if($accessLevel == -1 || $accessLevel == 5){ ?>
                    <a class="btn btn-sm btn-success" href="<?php echo base_url('assessmentinfo/addAssessmentinfo') ?>"><i class="fa fa-plus-circle"></i> Add Baseline </a>
            <?php } ?>
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

                        <table id="example0" class="table display table-bordered table-striped table-hover"">
                        <thead>
                        <tr>
                            <th>&nbsp;</th>
                           <!-- <th>&nbsp;</th>-->
                            <th>LSWDO Type</th>
                            <th>Region</th>
                            <th>Province</th>
                            <th>City/Municipality</th>
                            <th>Visit Count</th>
                            <th>Date</th>
                            <th>Baseline Score</th>
                            <th>Updated Score</th>
                            <th>Level of Functionality</th>


                        </tr>
                        </thead>
                        <tbody>
                        <?php foreach($assessmentinfo_data as $assessmentinfoData): ?>
                            <tr>
                                <td>
                                    <div class="btn-group">
                                        <a class="btn btn-xs btn-info" href="<?php echo base_url('assessmentinfo/assessmentinfo_masterview/' . $assessmentinfoData->profile_id) ?>"><i class="fa fa-plus"></i> View </a>
                                    </div>
                                    <?php if($accessLevel == -1 || $accessLevel == 5){ ?>

                                        <div class="btn-group">
                                            <a class="btn btn-xs btn-primary" href="<?php echo base_url('assessmentinfo/editAssessmentinfo/' . $assessmentinfoData->profile_id . '.html') ?>"><i class="fa fa-edit"></i>Edit </a>
                                        </div>
                                        <div class="btn-group">
                                            <a class="btn btn-xs btn-warning" href="<?php echo base_url('budgetallocation/index/' . $assessmentinfoData->profile_id . '/0') ?>"><i class="fa fa-money"></i> Budget Allocation </a>
                                        </div>
                                        <div class="btn-group">
                                            <a class="btn btn-xs btn-success" href="<?php echo base_url('monitoring/monitoring_list/' . $assessmentinfoData->profile_id) ?>"><i class="fa fa-tasks"></i> Indicators </a>
                                        </div>
                                        <div class="btn-group">
                                            <a class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete selected record?')"  href="<?php echo base_url('/assessmentinfo/delete_assessmentinfo/' . $assessmentinfoData->profile_id) ?>"><i class="fa fa-trash"> </i> </a>
                                        </div>
                                    <?php } ?>
                                </td>
                                <!---->
                                <!--<td><a class="btn btn-xs btn-success" href=sss"<?php /*echo base_url('indicator/indicatorView/' . $assessmentinfoData->profile_id) */?>"><i class="fa fa-list"></i> Indicators </a></td>-->

                                <!-- <td> <a onclick="return confirm('are you sure?')" class="btn btn-sm btn-danger" href="<?php echo base_url('assessmentinfo/delete_assessmentinfo/' . $assessmentinfoData->profile_id . '.html') ?>"><i class="fa fa-trash"></i> </a></td>-->

                                <td><?php echo $assessmentinfoData->lgu_type_name ?></td>
                                <td><?php echo $assessmentinfoData->region_name ?></td>
                                <td><?php echo $assessmentinfoData->prov_name ?></td>
                                <td><?php echo $assessmentinfoData->city_name ?></td>
                                <td><?php echo $assessmentinfoData->visit_count ?></td>

                                <td><?php echo $assessmentinfoData->visit_date ?></td>

                                <td><?php echo $assessmentinfoData->baseline_score ?></td>
                                <td><?php echo $assessmentinfoData->new_score ?></td>
                                <td><?php echo $assessmentinfoData->level_function_baseline ?></td>


                                <!--                    <td><a class="btn btn-xs btn-success" href="--><?php //echo base_url('indicator/indicatorViewpart2/' . $assessmentinfoData->profile_id) ?><!--"><i class="fa fa-list"></i> Add Indicator part 2 </a></td>-->
                                <!--                    <td><a class="btn btn-xs btnasdasdasdas-success" href="--><?php //echo base_url('indicator/indicatorViewpart3/' . $assessmentinfoData->profile_id) ?><!--"><i class="fa fa-list"></i> Add Indicator part 3 </a></td>-->

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