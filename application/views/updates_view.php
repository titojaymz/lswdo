<?php
/**
 * Created by PhpStorm.
 * User: ljesaclayan
 * Date: 4/13/2016
 * Time: 9:19 AM
 */
?>
<div class="content">
    <div class="page-header">
        <h1 class="title">Updates List</h1>
    </div>
    <div class="container-padding">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-title">
                        Updates
                    </div>
                    <a class="btn btn-sm btn-primary"  href="<?php echo base_url('updates/updateAdd/'.$profID.'/'.$refID) ?>"><i class="fa fa-plus"></i>Add New Update</a><br><br>
                    <div class="panel-body table-responsive">
                        <table class="table display table-bordered table-striped table-hover" width="100%">
                            <tr>
                                <td width = "50%">Indicator Name</td>
                                <td width = "25%">Compliance</td>
                                <td width = "25%">Date Updated</td>
                            </tr>
                            <?php foreach($getIndicatorList as $row): ?>
                            <?php
                                if($row->newValue == 1){
                                    $compliance = 'Compliant';
                                } else {
                                    $compliance = 'Not Compliant';
                                }
                             ?>
                                <tr>
                                    <td width = "50%"><?php echo $row->indicator_name ?></td>
                                    <td width = "25%"><?php echo $compliance ?></td>
                                    <td width = "25%"><?php echo $row->date_updated ?></td>
                                </tr>
                            <?php endforeach ?>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
