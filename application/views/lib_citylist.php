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
        <!-- <h1 class="title">Tool for the Assessment of FUNCTIONALITY of LSWDOs</h1>-->
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url('dashboardc/dashboard/'); ?>">Home</a></li>
            <li class="active"> Libraries </li>
            <li class="active"> Cities </li>
        </ol>
    </div>
    <!-- End Page Header -->

    <div class = "row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-title">
                    <div class="form-group">
                        <label for="list_info" class="control-label">City List</label>
                    </div>
                    <?php if($accessLevel == -1 || $accessLevel == 5){ ?>
                        <a class="btn btn-sm btn-success" href="<?php echo base_url('lib_cityc/addCity') ?>"><i class="fa fa-plus-circle"></i> Add City</a>
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
                            <th>City Code</th>
                            <th>City Name</th>
                            <th>Province Code</th>
                            <th>District</th>
                            <th>City Class</th>
                            <th>Income Class</th>


                        </tr>
                        </thead>
                        <tbody>
                        <?php foreach($city_data as $cityData): ?>
                            <tr>
                                <td>
                                    <div class="btn-group">
                                        <a class="btn btn-xs btn-info" href="<?php echo base_url('lib_cityc/lib_cityview/' . $cityData->city_code) ?>"><i class="fa fa-plus"></i> View </a>
                                    </div>
                                    <!--      <?php if($accessLevel == -1 || $accessLevel == 5){ ?>-->
                                    <div class="btn-group">
                                        <a class="btn btn-xs btn-primary" href="<?php echo base_url('lib_cityc/editCity/' . $cityData->city_code . '.html') ?>"><i class="fa fa-edit"></i>Edit </a>
                                    </div>

                                    <div class="btn-group">
                                        <a class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete selected record?')"  href="<?php echo base_url('lib_cityc/delete_city/' . $cityData->city_code) ?>"><i class="fa fa-trash"> </i> </a>
                                    </div>
                                    <!--   <?php } ?>-->
                                </td>

                                <td><?php echo $cityData->city_code ?></td>
                                <td><?php echo $cityData->city_name ?></td>
                                <td><?php echo $cityData->prov_code ?></td>
                                <td><?php echo $cityData->district ?></td>
                                <td><?php echo $cityData->city_class ?></td>
                                <td><?php echo $cityData->income_class ?></td>

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