<?php
/**
 * Created by PhpStorm.
 * User: ljesaclayan
 * Date: 7/28/2016
 * Time: 2:34 PM
 */
?>

<div class="content">
    <div class="page-header">
        <h1 class="title">Visit Count Add</h1>
    </div>
    <div class="container-padding">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-title">

                    </div>
                    <!--<a class="btn btn-sm btn-primary"  href="--><?php //echo base_url('access_control/addUser') ?><!--"><i class="fa fa-plus"></i>Add New User</a><br><br>-->
                    <div class="panel-body table-responsive">
                        <?php echo form_open('',array('class'=>'form-horizontal')) ?>
                        <table class="table display table-bordered table-striped table-hover">
                            <tr>
                                <td>Visit Count</td>
                                <td>
                                    <input type = "text" id="visitCount" name = "visitCount" class = "form-control-radius" style="width: 500px">
                                </td>
                            </tr>
                        </table>

                        <hr>
                        <div class="btn-group">
                            <button type="submit" id = "submit" name="submit" value="submit" class="btn btn-lg btn-rounded btn-success" ><i class="fa fa-check"></i>Add</button>
                        </div>
                        <?php echo form_close() ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

