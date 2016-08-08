<?php
/**
 * Created by PhpStorm.
 * User: ljesaclayan
 * Date: 7/29/2016
 * Time: 9:46 AM
 */
?>


<div class="content">
    <div class="page-header">
        <h1 class="title">Visit Status List</h1>
    </div>
    <div class="container-padding">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-title">

                    </div>
                    <?php $noti = $this->session->userdata('notification') ?>
                    <?php
                    if($noti == 0 ){
                        $formMessage = "";
                    } else if($noti == 1) {
                        $formMessage = "<div class=\"kode-alert kode-alert-icon kode-alert-click alert3\">
                                            <i class=\"fa fa-check\"></i> Save Succeeded!
                                            </div>";
                        $this->session->set_userdata('notification',0);
                    }else if($noti == 2) {
                        $formMessage = "<div class=\"kode-alert kode-alert-icon kode-alert-click alert4\">
                                            <i class=\"fa fa-check\"></i> Edit Succeeded!
                                            </div>";
                        $this->session->set_userdata('notification',0);
                    }
                    ?>
                    <?php echo $formMessage; ?>
                    <a class="btn btn-sm btn-primary"  href="<?php echo base_url('lib_visitStatus/statadd/') ?>"><i class="fa fa-plus"></i>Add New Visit Status</a><br><br>
                    <div class="panel-body table-responsive">

                        <table class="table display table-bordered table-striped table-hover" id="example0">
                            <thead>
                            <tr>
                                <!-- <th><input id="checkbox101" type="checkbox"></th> -->
                                <th></th>
                                <th>Visit Count</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php foreach($statList as $row): ?>
                                <tr>
                                    <td><a href="<?php echo base_url('lib_visitStatus/statedit/'.$row->status_id.'') ?>" class = 'btn btn-sm btn-success'>Edit</a> </td>
<!--                                    <td></td>-->
                                    <td><?php echo $row->status_name ?></td>
                                </tr>
                            <?php endforeach ?>
                            </tbody>
                        </table>
                    </div>


                </div>
            </div>
        </div>
    </div>
</div>

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

