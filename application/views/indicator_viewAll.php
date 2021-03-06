<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>
<!DOCTYPE HTML>
<html>
<?php error_reporting(0) ?>
<body>

<div class="content">
<!--//Part1-->
    <!-- Start Page Header -->
    <div class="page-header">
        <!-- <h1 class="title">Tool for the Assessment of FUNCTIONALITY of LSWDOs</h1>-->
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url('dashboardc/dashboard'); ?>">Home</a></li>
            <li class="active">Assessment Information</li>
            <li class="active">Indicators</li>
        </ol>
    </div>
    <!-- End Page Header -->

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
                <div class = "panel-body" style="display: none;">

                    <?php $countLS = count($checkPart1) ?>
                    <?php if($countLS > 0){ ?>
<!--                        <a class="btn btn-m btn-option3" href="--><?php //echo base_url('indicator/indicatorEdit/'.$profileID.'/'.$refID) ?><!--"><i class="fa fa-check-square"></i> Edit</a><br><br>-->
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
                            -->
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
                        <a class="btn btn-m btn-option2" href="<?php echo base_url('indicator/indicatorAdd/'.$profileID) ?>"><i class="fa fa-list"></i> Add</a><br><br>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
<!--  Part 2  -->
    <div class = "row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-title">
                    II. Program Management
                    <ul class="panel-tools">
                        <li><a class="icon minimise-tool"><i class="fa fa-minus"></i></a></li>
                        <li><a class="icon closed-tool"><i class="fa fa-times"></i></a></li>
                    </ul>
                </div>
                <div class = "panel-body" style="display: none;">

                    <?php $countLS = count($checkPart2) ?>
                    <?php if($countLS > 0){ ?>
<!--                        <a class="btn btn-m btn-option3" href="--><?php //echo base_url('indicator/indicatorEdit/'.$profileID.'/'.$refID) ?><!--"><i class="fa fa-check-square"></i> Edit</a><br><br>-->
                        <?php echo form_open('',array('class'=>'form-horizontal')) ?>
                        <?php $unformat = ""; ?>
                        <table class="table table-bordered table-striped">
                            <tr>
                                <td colspan = "2" align = "center"><b>BRONZE LEVEL <BR> (MUST)</b></td>
                                <td align = "center"><b>Compliance</b></td>
                                <td colspan = "1" align = "center"><b>SILVER LEVEL <BR> (DESIRED)</b></td>`
                                <td align = "center"><b>Compliance</b></td>
                                <td colspan = "1" align = "center"><b>GOLD LEVEL <BR> (EXEMPLARY)</b></td>
                                <td align = "center"><b>Compliance</b></td>
                                <td colspan = "1" align = "center"><b>Specific Findings and Recommendation</b></td>
                            </tr>
                            <tr>
                                <td align="center" colspan = "8">
                                    <!-- Mother Indicator eg. I. Administration and Organization-->
                                    <b><?php echo $secondMotherIndicator->indicator_name; ?></b>
                                </td>
                            </tr>
                            <!-- foreach for Child Indicators eg. A. B. CL. D. E. F. G. and so on.... -->
                            <?php foreach($secondIndicators as $second_indicators): ?>
                            <tr>
                                <!-- Title for the Child Indicators!!!  -->
                                <td colspan = "8" align="center"><b><?php echo $second_indicators->indicator_name; ?></b></td>
                            </tr>
                            <!--
                            newArray is a new Array for this version..
                            Pinag sanib-sanib ang mga column na may kaparehas na indiciator ID like IA1, IA2, IB1 and so on.
                            -->
                                <?php
                                $newArray = array();
                                foreach($getThirdCategory as $item):
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
                                foreach($getFourthCategory as $secondItem):
                                    $arrSec = explode("-", $secondItem->indicator_id, 2);
                                    $second = $arrSec[0];
                                    $secondNewArray[$second][] = $secondItem->indicator_checklist_id;
                                    $secondNewArray[$second][] = $secondItem->indicator_name;
                                endforeach;
                                ?>
                                 <?php
                                $thirdNewArray = array();
                                foreach($getSecondCategoryLower as $thirdItem):
                                    $arrSec = explode("-", $thirdItem->indicator_id, 2);
                                    $third = $arrSec[0];
                                    $thirdNewArray[$third][] = $thirdItem->indicator_checklist_id;
                                    $thirdNewArray[$third][] = $thirdItem->indicator_name;
                                endforeach;
                                ?>

                                <?php
                                $fourthNewArray = array();
                                foreach($getSecondCategoryLowerLower as $fourthItem):
                                    $arrSec = explode("-", $fourthItem->indicator_id, 2);
                                    $fourth = $arrSec[0];
                                    $fourthNewArray[$fourth][] = $fourthItem->indicator_checklist_id;
                                    $fourthNewArray[$fourth][] = $fourthItem->indicator_name;
                                endforeach;
                                ?>
                            <tr>
                                 <?php  $number = 1; ?> <!-- ung $number para makuha ung laman nung array na newArray at secondNewArray, yung indicator_name ung kinukuha neto -->
                                <?php  $number2 = 1; ?>
                                <?php  $number3 = 1; ?>
                                <?php  $number4 = 1; ?>
                                <?php  $checklist = 0; ?><!-- ung $checklist para makuha ung laman nung array na newArray at secondNewArray, yung indicator_checklist_id ung kinukuha neto -->
                                <?php  $checklist2 = 0; ?>
                                <?php  $checklist3 = 0; ?>
                                <?php  $checklist4 = 0; ?>
                                <?php foreach($newArray as $a => $iteem): ?> <!-- array for NewArray for child lower indicator -->
                                    <?php foreach($getThirdCategory as $firstCategory):?>
                                        <?php if($firstCategory->mother_indicator_id == $second_indicators->indicator_id) { ?> <!-- if mother_indicator of first Category is equal to first_indicators indicator_id -->
                                        <?php $arr = explode("-", $firstCategory->indicator_id, 2);?>
                                        <?php $firsts = $arr[0];?>
                                        <?php if ($a == $firsts) { ?><!-- $a is IA1, IA2  tapos ung $firsts eto dn ung IA1, etc pero kinukuha to sa indicator_id-->
                                            <?php if($iteem[$checklist] == 0){?> <!-- so ung checklist dito ay para kunin ung value ng indicator checklist sa newArray ang value nian is $iteem[0] which is ung $iteem[0] sa newArray ay ung indicator_checklist_id sa db  -->
                                                        <td colspan = "8"><b><?php echo $iteem[$number]; ?></b></td> <!-- title ng isang indicator sa ilalim ng Child Indicator -->
                                                    </tr>
                                                    <tr>
                                                    <?php foreach($secondNewArray as $b => $secondItems): ?> <!-- array for secondNewArray for child lower lower indicator -->
                                                        <?php foreach($getFourthCategory as $secondCategory):?>
                                                        <?php if($secondCategory->mother_indicator_id == $firstCategory->indicator_id) { ?>
                                                        <?php $arrays = explode("-", $secondCategory->indicator_id, 2);?>
                                                        <?php $seconds = $arrays[0];?>
                                                        <?php if ($b == $seconds) { ?>
                                                        <?php if($secondItems[$checklist2] == 0){?>

                                                        <?php foreach($thirdNewArray as $c => $iteeem): ?>
                                                            <?php foreach ($getSecondCategoryLower as $secondCategoryLower):?>
                                                                <?php if($secondCategoryLower->mother_indicator_id == $secondCategory->indicator_id){ ?>
                                                                    <?php $arrss = explode("-", $secondCategoryLower->indicator_id, 2);?>
                                                                        <?php $thirds = $arrss[0];?>
                                                                        </tr>
                                                                            <?php if ($c == $thirds) { ?>
                                                                                 <?php if($iteeem[$checklist3] == 0){?>

                                                                                    <td colspan = "11"><b><?php echo $iteeem[$number3]; ?></b></td>

                                                                                         <?php foreach($fourthNewArray as $d => $fourthItem): ?>
                                                                                            <?php foreach ($getSecondCategoryLowerLower as $secondCategoryLowerLower):?>
                                                                                                 <?php if($secondCategoryLowerLower->mother_indicator_id == $secondCategoryLower->indicator_id){ ?>
                                                                                                    <?php $arrss = explode("-", $secondCategoryLowerLower->indicator_id, 2);?>
                                                                                                        <?php $fourths = $arrss[0];?>
                                                                                                        </tr>
                                                                                                             <?php if ($d == $fourths) { ?>
                                                                                                                <?php if($fourthItem[$checklist4] == 0){?>
                                                                                                                      <td colspan = "11"><b><?php echo $fourthItem[$number4]; ?></b></td>

                                                                                                             <?php } else { ?>
                                                                                                                     <?php $counting4 = count($fourthItem); ?> <!-- eto naman bnblang kung ilan ung nsa loob ng secondNewArray/newArray -->
                                                                                                                         <?php $bronze4 = $b.'-'.$fourthItem[$checklist4]; ?>
                                                                                                                         <?php $silver4 = $b.'-'.$fourthItem[$checklist4+2]; ?>
                                                                                                                         <?php $gold4 = $b.'-'.$fourthItem[$checklist4+4]; ?>
                                                                                                                           <?php if($counting4 > 1){ ?> <!-- kung ma detect nia sa counting2 is greater than 1 ibig sbhn ay meron Bronze medal. -->
                                                                                                                           <td><?php echo $fourthItem[$number4]; ?></td> <!-- ung $secondItems[$number2] ung kinukuha ntn na value sa secondNewArray. so ung ibig sbhn neto is $secondItems[1] since ung checklist is 0 so ung kasunod na number nia sa loob ng array is 1 which is indicator Name -->
                                                                                                                                 <?php foreach($getLSWDO as $key=>$row): ?>
                                                                                                                                    <?php if($bronze4 == $row->indicator_id){ ?>
                                                                                                                                        <?php if($row->compliance_indicator_id == 1){ ?>
                                                                                                                                            <td align="center"><b>Compliant</b></td>
                                                                                                                                        <?php } elseif($row->compliance_indicator_id == 2){?>
                                                                                                                                            <td align="center"><b>Not Compliant</b></td>
                                                                                                                                        <?php } elseif($row->compliance_indicator_id == 3){?>
                                                                                                                                            <td align="center"><b>N/A</b></td>
                                                                                                                                        <?php } ?>
                                                                                                                                        <?php } ?>
                                                                                                                                  <?php endforeach ?>
                                                                                                                               <?php if($counting4 > 3){ ?> <!-- kung ma detect nia sa counting2 is greater than 3 ibig sbhn ay meron Silver medal. -->
                                                                                                                               <td><?php echo $fourthItem[$number4 + 2]; ?></td> <!-- bkt may plus 2 ung sa $number2 inassume ko na lahat ng even number is indicator name-->
                                                                                                                               <?php foreach($getLSWDO as $key=>$row): ?>
                                                                                                                                    <?php if($bronze4 == $row->indicator_id){ ?>
                                                                                                                                        <?php if($row->compliance_indicator_id == 1){ ?>
                                                                                                                                            <td align="center"><b>Compliant</b></td>
                                                                                                                                        <?php } elseif($row->compliance_indicator_id == 2){?>
                                                                                                                                            <td align="center"><b>Not Compliant</b></td>
                                                                                                                                        <?php } elseif($row->compliance_indicator_id == 3){?>
                                                                                                                                            <td align="center"><b>N/A</b></td>
                                                                                                                                        <?php } ?>
                                                                                                                                        <?php } ?>
                                                                                                                                  <?php endforeach ?> <?php if($counting4 > 5){ ?> <!-- kung ma detect nia sa counting2 is greater than 5 ibig sbhn ay meron Gold medal. -->
                                                                                                                                   <td><?php echo $fourthItem[$number4 + 4]; ?></td>
                                                                                                                                   <?php foreach($getLSWDO as $key=>$row): ?>
                                                                                                                                    <?php if($bronze4 == $row->indicator_id){ ?>
                                                                                                                                        <?php if($row->compliance_indicator_id == 1){ ?>
                                                                                                                                            <td align="center"><b>Compliant</b></td>
                                                                                                                                        <?php } elseif($row->compliance_indicator_id == 2){?>
                                                                                                                                            <td align="center"><b>Not Compliant</b></td>
                                                                                                                                        <?php } elseif($row->compliance_indicator_id == 3){?>
                                                                                                                                            <td align="center"><b>N/A</b></td>
                                                                                                                                        <?php } ?>
                                                                                                                                        <?php } ?>
                                                                                                                                  <?php endforeach ?>
                                                                                                                                   <?php } ?>
                                                                                                                           <?php } ?>
                                                                                                                       <?php } ?>
                                                                                                                       <?php break; ?>
                                                                                                             <?php } ?>
                                                                                                             <?php } ?>
                                                                                                 <?php } ?>
                                                                                            <?php  endforeach;?>
                                                                                         <?php  endforeach;?>
                                                                                 <?php } else {?>
                                                              <?php $counting3 = count($iteeem); ?> <!-- eto naman bnblang kung ilan ung nsa loob ng secondNewArray/newArray -->
                                                                <?php $bronze3 = $b.'-'.$iteeem[$checklist3]; ?>
                                                                <?php $silver3 = $b.'-'.$iteeem[$checklist3+2]; ?>
                                                                <?php $gold3 = $b.'-'.$iteeem[$checklist3+4]; ?>
                                                               <?php if($counting3 > 1){ ?> <!-- kung ma detect nia sa counting2 is greater than 1 ibig sbhn ay meron Bronze medal. -->
                                                                   <td><?php echo $iteeem[$number3]; ?></td> <!-- ung $secondItems[$number2] ung kinukuha ntn na value sa secondNewArray. so ung ibig sbhn neto is $secondItems[1] since ung checklist is 0 so ung kasunod na number nia sa loob ng array is 1 which is indicator Name -->
                                                                   <?php foreach($getLSWDO as $key=>$row): ?>
                                                                        <?php if($bronze3 == $row->indicator_id){ ?>
                                                                            <?php if($row->compliance_indicator_id == 1){ ?>
                                                                                <td align="center"><b>Compliant</b></td>
                                                                            <?php } elseif($row->compliance_indicator_id == 2){?>
                                                                                <td align="center"><b>Not Compliant</b></td>
                                                                            <?php } elseif($row->compliance_indicator_id == 3){?>
                                                                                <td align="center"><b>N/A</b></td>
                                                                            <?php } ?>
                                                                        <?php } ?>
                                                                    <?php endforeach ?>
                                                                     <?php if($counting3 > 3){ ?> <!-- kung ma detect nia sa counting2 is greater than 3 ibig sbhn ay meron Silver medal. -->
                                                                       <td><?php echo $iteeem[$number3 + 2]; ?></td> <!-- bkt may plus 2 ung sa $number2 inassume ko na lahat ng even number is indicator name-->
                                                                        <?php foreach($getLSWDO as $key=>$row): ?>
                                                                        <?php if($bronze3 == $row->indicator_id){ ?>
                                                                            <?php if($row->compliance_indicator_id == 1){ ?>
                                                                                <td align="center"><b>Compliant</b></td>
                                                                            <?php } elseif($row->compliance_indicator_id == 2){?>
                                                                                <td align="center"><b>Not Compliant</b></td>
                                                                            <?php } elseif($row->compliance_indicator_id == 3){?>
                                                                                <td align="center"><b>N/A</b></td>
                                                                            <?php } ?>
                                                                        <?php } ?>
                                                                    <?php endforeach ?>
                                                                     <?php if($counting3 > 5){ ?> <!-- kung ma detect nia sa counting2 is greater than 5 ibig sbhn ay meron Gold medal. -->
                                                                           <td><?php echo $iteeem[$number3 + 4]; ?></td>
                                                                            <?php foreach($getLSWDO as $key=>$row): ?>
                                                                        <?php if($bronze3 == $row->indicator_id){ ?>
                                                                            <?php if($row->compliance_indicator_id == 1){ ?>
                                                                                <td align="center"><b>Compliant</b></td>
                                                                            <?php } elseif($row->compliance_indicator_id == 2){?>
                                                                                <td align="center"><b>Not Compliant</b></td>
                                                                            <?php } elseif($row->compliance_indicator_id == 3){?>
                                                                                <td align="center"><b>N/A</b></td>
                                                                            <?php } ?>
                                                                        <?php } ?>
                                                                    <?php endforeach ?>

                                                                       <?php } ?>
                                                                   <?php } ?>
                                                               <?php } ?>
                                                               <?php break; ?>
                                                                       <?php }?>
                                                                         <?php }?>
                                                                <?php }?>

                                                            <?php  endforeach;?>
                                                        <?php  endforeach;?>




                                                             <?php } else {?>
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
                                                             <?php } ?>
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
                        <a class="btn btn-m btn-option2" href="<?php echo base_url('indicator/indicatorAddpart2/'.$profileID) ?>"><i class="fa fa-list"></i> Add</a><br><br>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
    <!--  Part 3  -->
    <div class = "row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-title">
                    III. Case Management
                    <ul class="panel-tools">
                        <li><a class="icon minimise-tool"><i class="fa fa-minus"></i></a></li>
                        <li><a class="icon closed-tool"><i class="fa fa-times"></i></a></li>
                    </ul>
                </div>
                <div class = "panel-body" style="display: none;">

                    <?php $countLS = count($checkPart3) ?>
                    <?php if($countLS > 0){ ?>
<!--                        <a class="btn btn-m btn-option3" href="--><?php //echo base_url('indicator/indicatorEditpart3/'.$profileID.'/'.$refID) ?><!--"><i class="fa fa-check-square"></i> Edit</a><br><br>-->
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
                                    <b><?php echo $thirdMotherIndicator->indicator_name; ?></b>
                                </td>
                            </tr>
                            <!-- foreach for Child Indicators eg. A. B. CL. D. E. F. G. and so on.... -->
                            <?php foreach($thirdIndicators as $third_indicators): ?>
                            <tr>
                                <!-- Title for the Child Indicators!!!  -->
                                <td colspan = "8" align="center"><b><?php echo $third_indicators->indicator_name; ?></b></td>
                            </tr>
                            <!--
                            newArray is a new Array for this version..
                            Pinag sanib-sanib ang mga column na may kaparehas na indiciator ID like IA1, IA2, IB1 and so on.
                            -->
                                <?php
                                $newArray = array();
                                foreach($getFifthCategory as $item):
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
                                foreach($getSixCategory as $secondItem):
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
                                    <?php foreach($getFifthCategory as $firstCategory):?>
                                        <?php if($firstCategory->mother_indicator_id == $third_indicators->indicator_id) { ?> <!-- if mother_indicator of first Category is equal to first_indicators indicator_id -->
                                        <?php $arr = explode("-", $firstCategory->indicator_id, 2);?>
                                        <?php $firsts = $arr[0];?>
                                        <?php if ($a == $firsts) { ?><!-- $a is IA1, IA2  tapos ung $firsts eto dn ung IA1, etc pero kinukuha to sa indicator_id-->
                                            <?php if($iteem[$checklist] == 0){?> <!-- so ung checklist dito ay para kunin ung value ng indicator checklist sa newArray ang value nian is $iteem[0] which is ung $iteem[0] sa newArray ay ung indicator_checklist_id sa db  -->
                                                        <td colspan = "12"><b><?php echo $iteem[$number]; ?></b></td> <!-- title ng isang indicator sa ilalim ng Child Indicator -->
                                                    </tr>
                                                    <tr>
                                                    <?php foreach($secondNewArray as $b => $secondItems): ?> <!-- array for secondNewArray for child lower lower indicator -->
                                                        <?php foreach($getSixCategory as $secondCategory):?>
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
                        <a class="btn btn-m btn-option2" href="<?php echo base_url('indicator/indicatorAddpart3/'.$profileID) ?>"><i class="fa fa-list"></i> Add</a><br><br>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
<!-- Part 4 -->
    <div class = "row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-title">
                    IV. Physical Structures and Safety
                    <ul class="panel-tools">
                        <li><a class="icon minimise-tool"><i class="fa fa-minus"></i></a></li>
                        <li><a class="icon closed-tool"><i class="fa fa-times"></i></a></li>
                    </ul>
                </div>
                <div class = "panel-body" style="display: none;">
                    <?php $countLS = count($checkPart4) ?>
                    <?php if($countLS > 0){ ?>
<!--                        <a class="btn btn-m btn-option5" href="--><?php //echo base_url('indicator/indicatorViewpart3/'.$profileID.'/'.$refID) ?><!--"><i class="fa fa-caret-square-o-down"></i>Back to <b>III. CASE MANAGEMENT</b></a>-->
<!--                        <a class="btn btn-m btn-option5" href="--><?php //echo base_url('indicator/indicatorViewAll/'.$profileID.'/'.$refID) ?><!--"><i class="fa fa-caret-square-o-down"></i><b>View All</b></a><br><br>-->
                        <!--                        <a class="btn btn-m btn-option3" href="--><?php //echo base_url('indicator/indicatorEditpart4/'.$profileID.'/'.$refID) ?><!--"><i class="fa fa-check-square"></i> Edit</a>-->
<!--                        <a class="btn btn-m btn-option4" href="--><?php //echo base_url('indicator/indicatordeletepart4/'.$profileID.'/'.$refID) ?><!--"><i class="fa fa-check-square"></i> Delete</a><br><br>-->
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
                                    <b><?php echo $fourthMotherIndicator->indicator_name; ?></b>
                                </td>
                            </tr>
                            <!-- foreach for Child Indicators eg. A. B. CL. D. E. F. G. and so on.... -->
                            <?php
                            $newArray = array();
                            foreach($fourthIndicators as $item):
                                $arr = explode("-", $item->indicator_id, 2); //kinukuha lahat ng indicator id tpos tatanggalin ung -1 example sa una IA1-1 magiging IA1
                                $first = $arr[0]; // yung IA1 eto ung mggng number ng mga array, eg. IA1, IA2
                                $newArray[$first][] = $item->indicator_checklist_id; //eto naman yung mga mggng value sa loob ng arrays.
                                $newArray[$first][] = $item->indicator_name;
                            endforeach
                            ?>
                            <?php
                            $secondArray = array();
                            foreach($fourthCategory as $item2):
                                $arr = explode("-", $item2->indicator_id, 2); //kinukuha lahat ng indicator id tpos tatanggalin ung -1 example sa una IA1-1 magiging IA1
                                $second = $arr[0]; // yung IA1 eto ung mggng number ng mga array, eg. IA1, IA2
                                $secondArray[$second][] = $item2->indicator_checklist_id; //eto naman yung mga mggng value sa loob ng arrays.
                                $secondArray[$second][] = $item2->indicator_name;
                            endforeach
                            ?>
                            <tr>
                                <?php $number = 1; ?>
                                <?php $checklist = 0; ?>
                                <?php $number2 = 1; ?>
                                <?php $checklist2 = 0; ?>
                                <?php foreach($newArray as $a => $iteem): ?>
                                <?php foreach($fourthIndicators as $fourthIndi): ?>
                                <?php $arr = explode("-", $fourthIndi->indicator_id, 2);?>
                                <?php $firsts = $arr[0];?>
                                <?php if($a == $firsts){ ?>
                                <?php if($iteem[$checklist] == 0){?>
                                <td colspan = "8"><b><?php echo $iteem[$number]; ?></b></td>
                            </tr>
                            <tr>
                                <?php foreach($secondArray as $b => $secondItems): ?>
                                <?php foreach($fourthCategory as $fourthCat):?>
                                <?php if($fourthCat->mother_indicator_id == $fourthIndi->indicator_id) { ?>
                                <?php $arrs = explode("-", $fourthCat->indicator_id, 2);?>
                                <?php $seconds = $arrs[0];?>
                                <?php if($b == $seconds){ ?>
                                    <?php $counting2 = count($secondItems); ?>
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
                            <?php endforeach; ?>
                            <?php endforeach; ?>
                            </tr>
                            <?php } else { ?>
                            <?php $counting = count($iteem); ?>
                            <?php $bronze = $a.'-'.$iteem[$checklist]; ?>
                            <?php $silver = $a.'-'.$iteem[$checklist+2]; ?>
                            <?php $gold = $a.'-'.$iteem[$checklist+4]; ?>
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
                            <?php } ?>
                            <?php } else { ?>
                            </tr>
                            <?php } ?>
                            <?php endforeach; ?>
                            <?php endforeach ?>
                        </table>
                        <?php echo form_close() ?>
                    <?php } else { ?>
                        <a class="btn btn-m btn-option2" href="<?php echo base_url('indicator/indicatorAddpart4/'.$profileID.'/'.$refID) ?>"><i class="fa fa-list"></i> Add</a><br><br>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>

    <!--carla psbriders-->

    <div class = "row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-title">
                    PSB Rider Questions
                    <ul class="panel-tools">
                        <li><a class="icon minimise-tool"><i class="fa fa-minus"></i></a></li>
                        <li><a class="icon closed-tool"><i class="fa fa-times"></i></a></li>
                    </ul>
                </div>
                <div class = "panel-body" style="display: none;">
                    <?php
                    //carla
                    $profile_id = $this->uri->segment('3');
                    $ref_id = $this->uri->segment('4');

                    $getPSBRiderAnswer = $PSBRider_Model->getPSBRiderAnswer($profile_id,$ref_id);

                    $getPSBMainCategory = $PSBRider_Model->getPSBMainCategory();

                       // print_r($getPSBRiderAnswer);
                    ?>

                    <table class = "table table-hover">
                        <tr>
                            <?php
                                foreach($getPSBMainCategory as $key => $val)
                                {
                                    echo "<td colspan = 3>";
                                    echo "<center><b>";
                                    echo $val["psbrider_main_category_title"];
                                    echo "</b></center>";
                                    echo "</td>";
                                    echo "</tr>";

                                    $answer = "";
                                    foreach($getPSBRiderAnswer as $keyAns => $valAns) {

                                        if ($val["psbrider_main_category_id"] == $valAns["psbrider_main_category_id"]) {
                                            echo "<tr>";

                                            echo "<td>";
                                            echo $valAns["psbrider_sub_category_title"];
                                            echo "</td>";

                                            echo "<td>";
                                            if($valAns["psbrider_answer"] == 1)
                                            {
                                                $answer = "YES";
                                                echo $answer;
                                            }else
                                            {
                                                $answer = "NO";
                                                echo $answer;

                                            }

                                            echo "<td>";
                                            echo $valAns["psbrider_indicative_reason"];
                                            echo "</td>";


                                            echo "</td>";


                                            echo "</tr>";
                                        }
                                    }
                                }
                            ?>

                        </table>

                </div>
            </div>
        </div>
    </div>

    <!--carla psbriders-->
    <?php
        $getPerc = number_format($scoreProf->FinalScore,2);
        if($getPerc == 100){
            $level = 'Fully Functional';
        } elseif($getPerc > 50 && $getPerc < 100){
            $level = 'Functional';
        } elseif($getPerc < 51) {
            $level = 'Partially Functional';
        }

    ?>
    <div class = "row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-title">
                    Score
                    <ul class="panel-tools">
                        <li><a class="icon minimise-tool"><i class="fa fa-minus"></i></a></li>
                        <li><a class="icon closed-tool"><i class="fa fa-times"></i></a></li>
                    </ul>
                </div>
                <div class = "panel-body" style="display: block;">
        <table class="table table-bordered table-striped" width = "100%">
        <tr>
            <td width ="25%" colspan = "2" rowspan = "2"><b>Indicators</b></td>
            <td width ="25%" colspan = "2"><b>Bronze</b></td>
            <td width ="25%" colspan = "2"><b>Silver</b></td>
            <td width ="25%" colspan = "2"><b>Gold</b></td>

        </tr>
        <tr>
            <td>Total # of Indicators</td>
            <td>Score of Compliance</td>
            <td>Total # of Indicators</td>
            <td>Score of Compliance</td>
            <td>Total # of Indicators</td>
            <td>Score of Compliance</td>
        </tr>
            <!-- Part 1 -->
            <tr>
                <td colspan="2">I. Administration and Organization</td>
                <td align="center"><?php echo $getTotalIndicatorsPart1->Bronze; ?></td>
                <td align="center"><?php echo $getBaselineTotalScoreIndicatorsPart1->BronzeScoreCompliant; ?></td>
                <td align="center"><?php echo $getTotalIndicatorsPart1->Silver; ?></td>
                <td align="center"><?php echo $getBaselineTotalScoreIndicatorsPart1->SilverScoreCompliant; ?></td>
                <td align="center"><?php echo $getTotalIndicatorsPart1->Gold; ?></td>
                <td align="center"><?php echo $getBaselineTotalScoreIndicatorsPart1->GoldScoreCompliant; ?></td>
            </tr>
            <!-- Part 2 -->
            <tr>
                <td colspan="2">II. Program Management</td>
                <td align="center"><?php echo $getTotalIndicatorsPart2->Bronze; ?></td>
                <td align="center"><?php echo $getBaselineTotalScoreIndicatorsPart2->BronzeScoreCompliant; ?></td>
                <td align="center"><?php echo $getTotalIndicatorsPart2->Silver; ?></td>
                <td align="center"><?php echo $getBaselineTotalScoreIndicatorsPart2->SilverScoreCompliant; ?></td>
                <td align="center"><?php echo $getTotalIndicatorsPart2->Gold; ?></td>
                <td align="center"><?php echo $getBaselineTotalScoreIndicatorsPart2->GoldScoreCompliant; ?></td>
            </tr>
            <!-- Part 3 -->
            <tr>
                <td colspan="2">III. Case Management</td>
                <td align="center"><?php echo $getTotalIndicatorsPart3->Bronze; ?></td>
                <td align="center"><?php echo $getBaselineTotalScoreIndicatorsPart3->BronzeScoreCompliant; ?></td>
                <td align="center"><?php echo $getTotalIndicatorsPart3->Silver; ?></td>
                <td align="center"><?php echo $getBaselineTotalScoreIndicatorsPart3->SilverScoreCompliant; ?></td>
                <td align="center"><?php echo $getTotalIndicatorsPart3->Gold; ?></td>
                <td align="center"><?php echo $getBaselineTotalScoreIndicatorsPart3->GoldScoreCompliant; ?></td>
            </tr>
            <!-- Part 4 -->
            <tr>
                <td colspan="2">IV. Physical Structures and Safety</td>
                <td align="center"><?php echo $getTotalIndicatorsPart4->Bronze; ?></td>
                <td align="center"><?php echo $getBaselineTotalScoreIndicatorsPart4->BronzeScoreCompliant; ?></td>
                <td align="center"><?php echo $getTotalIndicatorsPart4->Silver; ?></td>
                <td align="center"><?php echo $getBaselineTotalScoreIndicatorsPart4->SilverScoreCompliant; ?></td>
                <td align="center"><?php echo $getTotalIndicatorsPart4->Gold; ?></td>
                <td align="center"><?php echo $getBaselineTotalScoreIndicatorsPart4->GoldScoreCompliant; ?></td>
            </tr>
            <?php

//            echo $getBaselineTotalScoreIndicatorsPart2;
            $bronzeIndiTotal =  $getTotalIndicatorsPart1->Bronze +  $getTotalIndicatorsPart2->Bronze +  $getTotalIndicatorsPart3->Bronze +  $getTotalIndicatorsPart4->Bronze;
            $silverIndiTotal =  $getTotalIndicatorsPart1->Silver +  $getTotalIndicatorsPart2->Silver +  $getTotalIndicatorsPart3->Silver +  $getTotalIndicatorsPart4->Silver;
            $goldIndiTotal =  $getTotalIndicatorsPart1->Gold +  $getTotalIndicatorsPart2->Gold +  $getTotalIndicatorsPart3->Gold +  $getTotalIndicatorsPart4->Gold;
            $bronzeTotal = $getBaselineTotalScoreIndicatorsPart1->BronzeScoreCompliant + $getBaselineTotalScoreIndicatorsPart2->BronzeScoreCompliant + $getBaselineTotalScoreIndicatorsPart3->BronzeScoreCompliant + $getBaselineTotalScoreIndicatorsPart4->BronzeScoreCompliant;
            $silverTotal = $getBaselineTotalScoreIndicatorsPart1->SilverScoreCompliant + $getBaselineTotalScoreIndicatorsPart2->SilverScoreCompliant + $getBaselineTotalScoreIndicatorsPart3->SilverScoreCompliant + $getBaselineTotalScoreIndicatorsPart4->SilverScoreCompliant;
            $goldTotal = $getBaselineTotalScoreIndicatorsPart1->GoldScoreCompliant + $getBaselineTotalScoreIndicatorsPart2->GoldScoreCompliant + $getBaselineTotalScoreIndicatorsPart3->GoldScoreCompliant + $getBaselineTotalScoreIndicatorsPart4->GoldScoreCompliant;
            $getPercBronze = $scoreProf->FinalScore;
            $getPercSilver = $scoreProfSilver->FinalScore;
            $getPercGold = $scoreProfGold->FinalScore;

            if($getPercBronze == 100){
                $levelBronze = 'Fully Functional - Bronze';
            } elseif($getPercBronze > 50 && $getPercBronze < 100){
                $levelBronze = 'Functional - Bronze';
            } elseif($getPercBronze < 51 && $getPercBronze > 0 ) {
                $levelBronze = 'Partially Functional - Bronze';
            } else {
                $levelBronze = '';
            }

            if($getPercSilver == 100){
                $levelBronze = 'Fully Functional - Silver';
            }

            if($getPercGold == 100){
                $levelBronze = 'Fully Functional - Gold';
            }
            ?>
            <tr>
                <td colspan = "2">Total</td>
                <td colspan = "" align="center"><b><?php echo $bronzeIndiTotal; ?></b></td>
                <td colspan = "" align="center"><b><?php echo $bronzeTotal; ?></b></td>
                <td colspan = "" align="center"><b><?php echo $silverIndiTotal; ?></b></td>
                <td colspan = "" align="center"><b><?php echo $silverTotal; ?></b></td>
                <td colspan = "" align="center"><b><?php echo $goldIndiTotal; ?></b></td>
                <td colspan = "" align="center"><b><?php echo $goldTotal; ?></b></td>
            </tr>
            <tr>
                <td colspan = "2">Level of Functionality</td>
                <td colspan = "6" align="center"><b><?php echo $levelBronze; ?></b></td>
            </tr>
    </table>
                </div>
            </div>
        </div>
    <a class="btn btn-m btn-option2" href="<?php echo base_url('assessmentinfo/index/0') ?>"><i class="fa fa-check-circle-o"></i> Finish</a><br><br>
</div>
</body>
</html>
