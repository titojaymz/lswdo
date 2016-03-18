<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>
<!DOCTYPE HTML>
<html>

<body>
<div class="content">

    <div class = "row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-title">
                    Indicator
                    <ul class="panel-tools">
                        <li><a class="icon minimise-tool"><i class="fa fa-minus"></i></a></li>
                        <li><a class="icon closed-tool"><i class="fa fa-times"></i></a></li>
                    </ul>
                </div>
                <div class = "panel-body" style="display: block;">
                    <?php echo form_open('',array('class'=>'form-horizontal')) ?>
                    <table class="table table-bordered table-striped">
                        <tr>
                            <td colspan = "6"><b>Indicators</b></td>
                            <td colspan = "3"><b>Compliance</b></td>
                            <td colspan = "1"><b>Specific Findings and Recommendation</b></td>
                        </tr>
                        <tr>
                            <td align="center" colspan = "10">
                                <!--                                mother indicator  II-->
                                <b><?php echo $secondMotherIndicator->indicator_name; ?></b>

                            </td>


                            <!--                        Loop start for child indicators TITLE (A) -->
                            <?php foreach($secondIndicators as $second_indicators): ?>
                        <tr>
                            <td colspan = "10" align="center"><b><?php echo $second_indicators->indicator_name; ?></b></td>
                        </tr>
                        <!--                        Loop start for child indicators TITLE of indicators sample(Planning) -->
                        <?php foreach($getFirstCategory as $firstCategory): ?>
                            <?php if($firstCategory->mother_indicator_id == $second_indicators->indicator_id){ ?>
                                <?php if($firstCategory->indicator_checklist_id == "0"){ ?>

                                    <tr>
                                        <td colspan = "10"><b><?php echo $firstCategory->indicator_name; ?></b></td>
                                    </tr>

                                    <!--                        Loop start for child indicators lower Bronze Silver Gold -->
                                    <?php foreach($getSecondCategory as $secondCategory): ?>
                                        <?php $int = intval(preg_replace('/[^0-9]+/', '', $secondCategory->indicator_id), 10); ?>
                                        <?php $format1 = substr($int,0,-1); ?>
                                        <?php if($secondCategory->mother_indicator_id == $firstCategory->indicator_id){ ?>


                                            <?php if($secondCategory->indicator_checklist_id == "0"){ ?>
                                                <tr>
                                                    <td colspan = "10"><b><?php echo $secondCategory->indicator_name; ?></b></td>
                                                </tr>


                                                <!--                                                    foreach dito lunch time na-->
                                                <?php foreach ($getSecondCategoryLower as $secondCategoryLower):?>
                                                    <?php if($secondCategoryLower->mother_indicator_id == $secondCategory->indicator_id){ ?>
                                                        <?php if($secondCategoryLower->indicator_checklist_id == "0"){ ?>
                                                            <?php foreach ($getSecondCategoryLowerLower as $SecondCategoryLowerLower):?>
                                                            <tr>
                                                                <td colspan = "10"><b><?php echo $SecondCategoryLowerLower->indicator_name; ?></b></td>
                                                            </tr>
                                                            <?php endforeach?>

                                                        <?php } else { ?>
                        <tr>
                                                        <td><?php echo $format1; ?></td> <!-- ROW NUMBER-->

                                                        <?php if($secondCategoryLower->indicator_checklist_id == '1'){ ?>
                                                            <td colspan = "6"><b>BRONZE LEVEL ( MUST )</b><bR><?php echo $secondCategoryLower->indicator_name ?></td>
                                                            <td><input type="radio" id = "compliance<?php echo $secondCategoryLower->indicator_id ?>" name = "compliance<?php echo $secondCategoryLower->indicator_id ?>" value = "1"/> Compliance</td>
                                                            <td><input type="radio" id = "compliance<?php echo $secondCategoryLower->indicator_id ?>" name = "compliance<?php echo $secondCategoryLower->indicator_id ?>" value = "2"/> Not Compliance</td>
                                                            <td><input type="radio" id = "compliance<?php echo $secondCategoryLower->indicator_id ?>" name = "compliance<?php echo $secondCategoryLower->indicator_id ?>" value = "3"/> N/A</td>
                                                        <?php } ?>
                                                        <?php if($secondCategoryLower->indicator_checklist_id == '2'){ ?>
                                                            <td colspan = "6"><b>SILVER LEVEL ( DESIRED )</b><bR><?php echo $secondCategoryLower->indicator_name ?></td>
                                                            <td><input type="radio" id = "compliance<?php echo $secondCategoryLower->indicator_id ?>" name = "compliance<?php echo $secondCategoryLower->indicator_id ?>" value = "1"/> Compliance</td>
                                                            <td><input type="radio" id = "compliance<?php echo $secondCategoryLower->indicator_id ?>" name = "compliance<?php echo $secondCategoryLower->indicator_id ?>" value = "2"/> Not Compliance</td>
                                                            <td><input type="radio" id = "compliance<?php echo $secondCategoryLower->indicator_id ?>" name = "compliance<?php echo $secondCategoryLower->indicator_id ?>" value = "3"/> N/A</td>
                                                        <?php } ?>
                                                        <?php if($secondCategoryLower->indicator_checklist_id == '3'){ ?>
                                                            <td colspan = "6"><b>GOLD LEVEL ( EXEMPLARY )</b><bR><?php echo $secondCategoryLower->indicator_name ?></td>
                                                            <td><input type="radio" id = "compliance<?php echo $secondCategoryLower->indicator_id ?>" name = "compliance<?php echo $secondCategoryLower->indicator_id ?>" value = "1"/> Compliance</td>
                                                            <td><input type="radio" id = "compliance<?php echo $secondCategoryLower->indicator_id ?>" name = "compliance<?php echo $secondCategoryLower->indicator_id ?>" value = "2"/> Not Compliance</td>
                                                            <td><input type="radio" id = "compliance<?php echo $secondCategoryLower->indicator_id ?>" name = "compliance<?php echo $secondCategoryLower->indicator_id ?>" value = "3"/> N/A</td>
                                                        <?php } ?>

                        </tr>
                                                    <?php } ?>
                                                    <?php } ?>

                                                <?php endforeach?>
                                            <?php } else { ?>


                        <tr>
                                                <td><?php echo $format1; ?></td> <!-- ROW NUMBER-->

                                                <?php if($secondCategory->indicator_checklist_id == '1'){ ?>
                                                    <td colspan = "6"><b>BRONZE LEVEL ( MUST )</b><bR><?php echo $secondCategory->indicator_name ?></td>
                                                    <td><input type="radio" id = "compliance<?php echo $secondCategory->indicator_id ?>" name = "compliance<?php echo $secondCategory->indicator_id ?>" value = "1"/> Compliance</td>
                                                    <td><input type="radio" id = "compliance<?php echo $secondCategory->indicator_id ?>" name = "compliance<?php echo $secondCategory->indicator_id ?>" value = "2"/> Not Compliance</td>
                                                    <td><input type="radio" id = "compliance<?php echo $secondCategory->indicator_id ?>" name = "compliance<?php echo $secondCategory->indicator_id ?>" value = "3"/> N/A</td>
                                                <?php } ?>
                                                <?php if($secondCategory->indicator_checklist_id == '2'){ ?>
                                                    <td colspan = "6"><b>SILVER LEVEL ( DESIRED )</b><bR><?php echo $secondCategory->indicator_name ?></td>
                                                    <td><input type="radio" id = "compliance<?php echo $secondCategory->indicator_id ?>" name = "compliance<?php echo $secondCategory->indicator_id ?>" value = "1"/> Compliance</td>
                                                    <td><input type="radio" id = "compliance<?php echo $secondCategory->indicator_id ?>" name = "compliance<?php echo $secondCategory->indicator_id ?>" value = "2"/> Not Compliance</td>
                                                    <td><input type="radio" id = "compliance<?php echo $secondCategory->indicator_id ?>" name = "compliance<?php echo $secondCategory->indicator_id ?>" value = "3"/> N/A</td>
                                                <?php } ?>
                                                <?php if($secondCategory->indicator_checklist_id == '3'){ ?>
                                                    <td colspan = "6"><b>GOLD LEVEL ( EXEMPLARY )</b><bR><?php echo $secondCategory->indicator_name ?></td>
                                                    <td><input type="radio" id = "compliance<?php echo $secondCategory->indicator_id ?>" name = "compliance<?php echo $secondCategory->indicator_id ?>" value = "1"/> Compliance</td>
                                                    <td><input type="radio" id = "compliance<?php echo $secondCategory->indicator_id ?>" name = "compliance<?php echo $secondCategory->indicator_id ?>" value = "2"/> Not Compliance</td>
                                                    <td><input type="radio" id = "compliance<?php echo $secondCategory->indicator_id ?>" name = "compliance<?php echo $secondCategory->indicator_id ?>" value = "3"/> N/A</td>
                                                <?php } ?>
                        </tr>
                                            <?php } ?>
                                        <?php } ?>
                                    <?php endforeach ?>
                                <?php } else { ?>
                                    <?php $int1 = intval(preg_replace('/[^0-9]+/', '', $firstCategory->indicator_id), 10); ?>
                                    <?php $format = substr($int1,0,-1); ?>
                        <tr>
                            <td><?php echo $format;?></td>
                                    <?php if($firstCategory->indicator_checklist_id == '1'){ ?>
                                        <td colspan = "6"><b>BRONZE LEVEL ( MUST )</b><bR><?php echo $firstCategory->indicator_name ?></td>
                                        <td><input type="radio" id = "compliance<?php echo $firstCategory->indicator_id ?>" name = "compliance<?php echo $firstCategory->indicator_id ?>" value = "1"/> Compliance</td>
                                        <td><input type="radio" id = "compliance<?php echo $firstCategory->indicator_id ?>" name = "compliance<?php echo $firstCategory->indicator_id ?>" value = "2"/> Not Compliance</td>
                                        <td><input type="radio" id = "compliance<?php echo $firstCategory->indicator_id ?>" name = "compliance<?php echo $firstCategory->indicator_id ?>" value = "3"/> N/A</td>
                                    <?php } ?>
                                    <?php if($firstCategory->indicator_checklist_id == '2'){ ?>
                                        <td colspan = "6"><b>SILVER LEVEL ( DESIRED )</b><bR><?php echo $firstCategory->indicator_name ?></td>
                                        <td><input type="radio" id = "compliance<?php echo $firstCategory->indicator_id ?>" name = "compliance<?php echo $firstCategory->indicator_id ?>" value = "1"/> Compliance</td>
                                        <td><input type="radio" id = "compliance<?php echo $firstCategory->indicator_id ?>" name = "compliance<?php echo $firstCategory->indicator_id ?>" value = "2"/> Not Compliance</td>
                                        <td><input type="radio" id = "compliance<?php echo $firstCategory->indicator_id ?>" name = "compliance<?php echo $firstCategory->indicator_id ?>" value = "3"/> N/A</td>
                                    <?php } ?>
                                    <?php if($firstCategory->indicator_checklist_id == '3'){ ?>
                                        <td colspan = "6"><b>GOLD LEVEL ( EXEMPLARY )</b><bR><?php echo $firstCategory->indicator_name ?></td>
                                        <td><input type="radio" id = "compliance<?php echo $firstCategory->indicator_id ?>" name = "compliance<?php echo $firstCategory->indicator_id ?>" value = "1"/> Compliance</td>
                                        <td><input type="radio" id = "compliance<?php echo $firstCategory->indicator_id ?>" name = "compliance<?php echo $firstCategory->indicator_id ?>" value = "2"/> Not Compliance</td>
                                        <td><input type="radio" id = "compliance<?php echo $firstCategory->indicator_id ?>" name = "compliance<?php echo $firstCategory->indicator_id ?>" value = "3"/> N/A</td>
                                    <?php } ?>
                        </tr>
                                <?php } ?>
                            <?php } ?>
                        <?php endforeach ?>
                        <?php endforeach ?>
                    </table>

                    <hr>
                    <div class="btn-group">
                        <button type="submit" id = "submit" name="submit" value="submit" class="btn btn-lg btn-rounded btn-success" class="modalicon" data-toggle="modal"><i class="fa fa-check"></i> Save</button>
                    </div>
                    <?php echo form_close() ?>
                    <pre>
                      <?php print_r($getSecondCategoryLowerLower); ?>
                    </pre>

                </div>
            </div>
        </div>
    </div>

</div>
</body>
</html>
