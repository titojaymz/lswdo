<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>
<!DOCTYPE HTML>
<html>
<?php error_reporting(0) ?>
<body>
<?php
//if(count($checkPart1) > 0 && count($checkPart2) > 0 && count($checkPart3) > 0){
//    redirect('indicator/indicatorViewAll/'.$profileID.'/'.$refID,'location');
//}

?>
<div class="content">

    <div class = "row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-title">
                    I. Administration and Organization
                    <ul class="panel-tools">
                        <li><a class="icon minimise-tool"><i class="fa fa-minus"></i></a></li>
                        <li><a class="icon closed-tool"><i class="fa fa-times"></i></a></li>
                    </ul>
                </div>
                <div class = "panel-body" style="display: block;">

                    <?php $countLS = count($checkPart1) ?>
                    <?php if($countLS > 0){ ?>
                    <a class="btn btn-m btn-option5" href="<?php echo base_url('indicator/indicatorViewpart2/'.$profileID.'/'.$refID) ?>"><i class="fa fa-caret-square-o-down"></i>Proceed to <b>II. PROGRAM MANAGEMENT</b></a><br><br>
<!--                        <a class="btn btn-m btn-option3" href="--><?php //echo base_url('indicator/indicatorEdit/'.$profileID.'/'.$refID) ?><!--"><i class="fa fa-check-square"></i> Edit</a>-->
                        <a class="btn btn-m btn-option2" href="<?php echo base_url('indicator/indicatorDelete/'.$profileID.'/'.$refID) ?>"><i class="fa fa-check-square"></i> Delete</a><br><br>
                    <?php echo form_open('',array('class'=>'form-horizontal')) ?>
                    <?php $unformat = ""; ?>
                    <table class="table table-bordered table-striped">
                        <tr>
                            <td colspan = "2" align = "center"><b>BRONZE LEVEL <BR> (MUST)</b></td>
                            <td align = "center"><b>Compliance</b></td>
                            <td colspan = "1" align = "center"><b>SILVER LEVEL <BR> (DESIRED)</b></td>
                            <td align = "center"><b>Compliance</b></td>
                            <td colspan = "1" align = "center"><b>GOLD LEVEL <BR> (EXEMPLARY)</b></td>
                            <td align = "center"><b>Compliance</b></td>
                            <td colspan = "1" align = "center"><b>Specific Findings and Recommendation</b></td>
                        </tr>
                        <tr>
                            <td align="center" colspan = "8">
                                <!-- Mother Indicator eg. I. Administration and Organization-->
                                <b><?php echo $firstMotherIndicator->indicator_name; ?></b>
                            </td>
                        </tr>
                        <!-- foreach for Child Indicators eg. A. B. CL. D. E. F. G. and so on.... -->
                        <?php foreach($firstIndicators as $first_indicators): ?>
                            <tr>
                                <!-- Title for the Child Indicators!!!  -->
                                <td colspan = "8" align="center"><b><?php echo $first_indicators->indicator_name; ?></b></td>
                            </tr>
                            <!--
                            newArray is a new Array for this version..
                            Pinag sanib-sanib ang mga column na may kaparehas na indiciator ID like IA1, IA2, IB1 and so on.
                            -->t
                                <?php
                                $newArray = array();
                                foreach($getFirstCategory as $item):
                                    $arr = explode("-", $item->indicator_id, 2); //kinukuha lahat ng indicator id tpos tatanggalin ung -1 example sa una IA1-1 magiging IA1
                                    $first = $arr[0]; // yung IA1 eto ung mggng number ng mga array, eg. IA1, IA2
                                    $newArray[$first][] = $item->indicator_checklist_id; //eto naman yung mga mggng value sa loob ng arrays.
                                    $newArray[$first][] = $item->indicator_name;
                                endforeach
                                ?>
                                <!--<pre>
                                    <?php /*print_r($getLSWDO); */?>
                                </pre>-->
                                <?php
                                $secondNewArray = array();
                                foreach($getSecondCategory as $secondItem):
                                    $arrSec = explode("-", $secondItem->indicator_id, 2);
                                    $second = $arrSec[0];
                                    $secondNewArray[$second][] = $secondItem->indicator_checklist_id;
                                    $secondNewArray[$second][] = $secondItem->indicator_name;
                                endforeach;
                                ?>
                            <tr>
                                <?php  $number = 1; ?> <!-- ung $number para makuha ung laman nung array na newArray at secondNewArray, yung indicator_name ung kinukuha neto -->
                                <?php  $number2 = 1; ?>
                                <?php  $checklist = 0; ?><!-- ung $checklist para makuha ung laman nung array na newArray at secondNewArray, yung indicator_checklist_id ung kinukuha neto -->
                                <?php  $checklist2 = 0; ?>
                                <?php foreach($newArray as $a => $iteem): ?> <!-- array for NewArray for child lower indicator -->
                                    <?php foreach($getFirstCategory as $firstCategory):?>
                                        <?php if($firstCategory->mother_indicator_id == $first_indicators->indicator_id) { ?> <!-- if mother_indicator of first Category is equal to first_indicators indicator_id -->
                                        <?php $arr = explode("-", $firstCategory->indicator_id, 2);?>
                                        <?php $firsts = $arr[0];?>
                                        <?php if ($a == $firsts) { ?><!-- $a is IA1, IA2  tapos ung $firsts eto dn ung IA1, etc pero kinukuha to sa indicator_id-->
                                            <?php if($iteem[$checklist] == 0){?> <!-- so ung checklist dito ay para kunin ung value ng indicator checklist sa newArray ang value nian is $iteem[0] which is ung $iteem[0] sa newArray ay ung indicator_checklist_id sa db  -->
                                                        <td colspan = "8"><b><?php echo $iteem[$number]; ?></b></td> <!-- title ng isang indicator sa ilalim ng Child Indicator -->
                                                    </tr>
                                                    <tr>
                                                    <?php foreach($secondNewArray as $b => $secondItems): ?> <!-- array for secondNewArray for child lower lower indicator -->
                                                        <?php foreach($getSecondCategory as $secondCategory):?>
                                                        <?php if($secondCategory->mother_indicator_id == $firstCategory->indicator_id) { ?>
                                                        <?php $arrays = explode("-", $secondCategory->indicator_id, 2);?>
                                                        <?php $seconds = $arrays[0];?>
                                                        <?php if ($b == $seconds) { ?>
                                                            <?php $counting2 = count($secondItems); ?> <!-- eto naman bnblang kung ilan ung nsa loob ng secondNewArray/newArray -->
                                                            <?php $int2 = intval(preg_replace('/[^0-9]+/', '', $b), 10); ?>
                                                            <td><?php echo $int2 ?></td>
                                                            <?php $bronze2 = $b.'-'.$secondItems[$checklist2]; ?>
                                                            <?php $silver2 = $b.'-'.$secondItems[$checklist2+2]; ?>
                                                            <?php $gold2 = $b.'-'.$secondItems[$checklist2+4]; ?>
                                                               <?php if($counting2 > 1){ ?> <!-- kung ma detect nia sa counting2 is greater than 1 ibig sbhn ay meron Bronze medal. -->
                                                                   <td><?php echo $secondItems[$number2]; ?></td> <!-- ung $secondItems[$number2] ung kinukuha ntn na value sa secondNewArray. so ung ibig sbhn neto is $secondItems[1] since ung checklist is 0 so ung kasunod na number nia sa loob ng array is 1 which is indicator Name -->
                                                                   <?php foreach($getLSWDO as $key=>$row): ?>
                                                                        <?php if($bronze2 == $row->indicator_id){ ?>
                                                                            <?php if($row->compliance_indicator_id == 1){ ?>
                                                                                <td align="center"><b>Compliant</b></td>
                                                                            <?php } elseif($row->compliance_indicator_id == 2){?>
                                                                                <td align="center"><b>Not Compliant</b></td>
                                                                            <?php } elseif($row->compliance_indicator_id == 3){?>
                                                                                <td align="center"><b>N/A</b></td>
                                                                            <?php } ?>
                                                                        <?php } ?>
                                                                    <?php endforeach ?>
                                                                       <?php if($counting2 > 3){ ?> <!-- kung ma detect nia sa counting2 is greater than 3 ibig sbhn ay meron Silver medal. -->
                                                                       <td><?php echo $secondItems[$number2 + 2]; ?></td> <!-- bkt may plus 2 ung sa $number2 inassume ko na lahat ng even number is indicator name-->
                                                                     <?php foreach($getLSWDO as $key=>$row): ?>
                                                                        <?php if($silver2 == $row->indicator_id){ ?>
                                                                            <?php if($row->compliance_indicator_id == 1){ ?>
                                                                                <td align="center"><b>Compliant</b></td>
                                                                            <?php } elseif($row->compliance_indicator_id == 2){?>
                                                                                <td align="center"><b>Not Compliant</b></td>
                                                                            <?php } elseif($row->compliance_indicator_id == 3){?>
                                                                                <td align="center"><b>N/A</b></td>
                                                                            <?php } ?>
                                                                        <?php } ?>
                                                                    <?php endforeach ?>
                                                                     <?php if($counting2 > 5){ ?> <!-- kung ma detect nia sa counting2 is greater than 5 ibig sbhn ay meron Gold medal. -->
                                                                           <td><?php echo $secondItems[$number2 + 4]; ?></td>
                                                                           <?php foreach($getLSWDO as $key=>$row): ?>
                                                                        <?php if($gold2 == $row->indicator_id){ ?>
                                                                            <?php if($row->compliance_indicator_id == 1){ ?>
                                                                                <td align="center"><b>Compliant</b></td>
                                                                            <?php } elseif($row->compliance_indicator_id == 2){?>
                                                                                <td align="center"><b>Not Compliant</b></td>
                                                                            <?php } elseif($row->compliance_indicator_id == 3){?>
                                                                                <td align="center"><b>N/A</b></td>
                                                                            <?php } ?>
                                                                        <?php } ?>
                                                                    <?php endforeach ?>
                                                                    <?php foreach($getLSWDO as $key=>$row): ?>
                                                                <?php if($bronze2 == $row->indicator_id){ ?>
                                                                    <td><?php echo $row->findings_recom; ?></td>
                                                                <?php } ?>
                                                            <?php endforeach ?>
                                                                       <?php } else {  ?>
                                                            <td></td>
                                                            <td></td>
                                                            <?php foreach($getLSWDO as $key=>$row): ?>
                                                                <?php if($bronze2 == $row->indicator_id){ ?>
                                                                    <td><?php echo $row->findings_recom; ?></td>
                                                                <?php } ?>
                                                            <?php endforeach ?>
                                                            <?php }?>
                                                        <?php } else {  ?>
                                                        <td></td>
                                                        <td></td>
                                                        <td></td>
                                                        <td></td>
                                                       <?php foreach($getLSWDO as $key=>$row): ?>
                                                                <?php if($bronze2 == $row->indicator_id){ ?>
                                                                    <td><?php echo $row->findings_recom; ?></td>
                                                                <?php } ?>
                                                            <?php endforeach ?>
                                                        <?php }?>
                                                               <?php } ?>
                                                               <?php break; ?>
                                                        <?php }  else { ?>
                                                        </tr>
                                                        <?php } ?>
                                                        <?php } ?>
                                                       <?php   endforeach;?>
                                                    <?php  endforeach;?>
                                                    </tr>
                                                <?php } else { ?>
                                                    <?php $counting = count($iteem); ?>
                                                    <?php $int1 = intval(preg_replace('/[^0-9]+/', '', $a), 10); ?>
                                                    <?php $bronze = $a.'-'.$iteem[$checklist]; ?>
                                                    <?php $silver = $a.'-'.$iteem[$checklist+2]; ?>
                                                    <?php $gold = $a.'-'.$iteem[$checklist+4]; ?>
                                                    <td><?php echo $int1 ?></td>
                                                    <?php if($counting > 1){ ?>
                                                        <td><?php echo $iteem[$number]; ?></td>
                                                            <?php foreach($getLSWDO as $key=>$row): ?>
                                                                <?php if($bronze == $row->indicator_id){ ?>
                                                                    <?php if($row->compliance_indicator_id == 1){ ?>
                                                                        <td align="center"><b>Compliant</b></td>
                                                                    <?php } elseif($row->compliance_indicator_id == 2){?>
                                                                        <td align="center"><b>Not Compliant</b></td>
                                                                    <?php } elseif($row->compliance_indicator_id == 3){?>
                                                                        <td align="center"><b>N/A</b></td>
                                                                    <?php } ?>
                                                                <?php } ?>
                                                            <?php endforeach ?>
                                                       <?php if($counting > 3){?>
                                                            <td><?php echo $iteem[$number + 2]; ?></td>
                                                            <?php foreach($getLSWDO as $key=>$row): ?>
                                                                <?php if($silver == $row->indicator_id){ ?>
                                                                   <?php if($row->compliance_indicator_id == 1){ ?>
                                                                        <td align="center"><b>Compliant</b></td>
                                                                    <?php } elseif($row->compliance_indicator_id == 2){?>
                                                                        <td align="center"><b>Not Compliant</b></td>
                                                                    <?php } elseif($row->compliance_indicator_id == 3){?>
                                                                        <td align="center"><b>N/A</b></td>
                                                                    <?php } ?>
                                                                <?php } ?>
                                                            <?php endforeach ?>
                                                            <?php if($counting > 5){ ?>
                                                                <td><?php echo $iteem[$number + 4]; ?></td>
                                                                <?php foreach($getLSWDO as $key=>$row): ?>
                                                                <?php if($gold == $row->indicator_id){ ?>
                                                                  <?php if($row->compliance_indicator_id == 1){ ?>
                                                                        <td align="center"><b>Compliant</b></td>
                                                                    <?php } elseif($row->compliance_indicator_id == 2){?>
                                                                        <td align="center"><b>Not Compliant</b></td>
                                                                    <?php } elseif($row->compliance_indicator_id == 3){?>
                                                                        <td align="center"><b>N/A</b></td>
                                                                    <?php } ?>
                                                                <?php } ?>
                                                            <?php endforeach ?>
                                                              <?php foreach($getLSWDO as $key=>$row): ?>
                                                                <?php if($bronze == $row->indicator_id){ ?>
                                                                    <td><?php echo $row->findings_recom; ?></td>
                                                                <?php } ?>
                                                            <?php endforeach ?>

                                                            <?php } else {  ?>
                                                            <td></td>
                                                            <td></td>
                                                            <?php foreach($getLSWDO as $key=>$row): ?>
                                                                <?php if($bronze == $row->indicator_id){ ?>
                                                                    <td><?php echo $row->findings_recom; ?></td>
                                                                <?php } ?>
                                                            <?php endforeach ?>
                                                            <?php }?>
                                                        <?php } else {  ?>
                                                        <td></td>
                                                        <td></td>
                                                        <td></td>
                                                        <td></td>
                                                        <?php foreach($getLSWDO as $key=>$row): ?>
                                                                <?php if($bronze == $row->indicator_id){ ?>
                                                                    <td><?php echo $row->findings_recom; ?></td>
                                                                <?php } ?>
                                                            <?php endforeach ?>
                                                        <?php }?>
                                                    <?php }?>
                                                    <?php break; ?>
                                            <?php }  ?>
                                                <?php } else { ?>
                                                </tr>
                                                <?php } ?>
                                        <?php }?>
                                    <?php   endforeach;?>
                                <?php  endforeach;?>
                            </tr>
                    <?php endforeach ?>
                    </table>
                    <?php echo form_close() ?>
                    <?php } else { ?>
                        <a class="btn btn-m btn-option2" href="<?php echo base_url('indicator/indicatorAdd/'.$profileID.'/'.$refID) ?>"><i class="fa fa-list"></i> Add</a><br><br>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>
