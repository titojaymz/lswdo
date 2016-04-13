<?php
/**
 * Created by PhpStorm.
 * User: mblejano
 * Date: 4/13/2016
 * Time: 1:36 PM
 */
?>

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
                            <a class="btn btn-sm btn-success" href="<?php echo base_url('reports/pswdo_score') ?>"><i class="fa fa-plus-circle"></i>PSWDO Baseline Reports</a>
                            <a class="btn btn-sm btn-success" href="<?php echo base_url('reports/pswdo_newscore') ?>"><i class="fa fa-plus-circle"></i>PSWDO Updated Reports</a>
                            <a class="btn btn-sm btn-success" href="<?php echo base_url('reports/cmswdo_score') ?>"><i class="fa fa-plus-circle"></i>C/MSWDO Baseline Reports</a>
                            <a class="btn btn-sm btn-success" href="<?php echo base_url('reports/cmswdo_newscore') ?>"><i class="fa fa-plus-circle"></i>C/MSWDO Updated Reports</a>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
