<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>
<!DOCTYPE HTML>
<html>
<?php error_reporting(0) ?>
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
                    <input type = "hidden" id="profID" name ="profID" value ="<?php echo $profileID ?>"/>
                    <?php $unformat = ""; ?>
                    <table class="table table-bordered table-striped">
                        <tr>
                            <td colspan = "2" align = "center"><b>BRONZE LEVEL <BR> (MUST)</b></td>
                            <td colspan = "3" align = "center"><b>Compliance</b></td>
                            <td colspan = "1" align = "center"><b>SILVER LEVEL <BR> (DESIRED)</b></td>
                            <td colspan = "3" align = "center"><b>Compliance</b></td>
                            <td colspan = "1" align = "center"><b>GOLD LEVEL <BR> (EXEMPLARY)</b></td>
                            <td colspan = "3" align = "center"><b>Compliance</b></td>
                            <td colspan = "1" align = "center"><b>Specific Findings and Recommendation</b></td>
                        </tr>
                        <tr>
                            <td align="center" colspan = "14">
                                <!-- Mother Indicator eg. I. Administration and Organization-->
                                <b><?php echo $secondMotherIndicator->indicator_name; ?></b>
                            </td>
                        </tr>
                        <!-- foreach for Child Indicators eg. A. B. CL. D. E. F. G. and so on.... -->
                        <?php foreach($secondIndicators as $second_indicators): ?>
                            <tr>
                                <!-- Title for the Child Indicators!!!  -->
                                <td colspan = "14" align="center"><b><?php echo $second_indicators->indicator_name; ?></b></td>
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
                                    <?php /*print_r($newArray); */?>
                                    <?php /*echo count($newArray['IA1']) / 3; */?>
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
                                    <!--<pre>
                                    <?php /*print_r($getSecondCategoryLower); */?>
                                    <?php /*echo count($getSecondCategoryLower['IA1']) / 3; */?>
                                    </pre>-->
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
                                    <?php foreach($getFirstCategory as $firstCategory):?>
                                        <?php if($firstCategory->mother_indicator_id == $second_indicators->indicator_id) { ?> <!-- if mother_indicator of first Category is equal to first_indicators indicator_id -->
                                        <?php $arr = explode("-", $firstCategory->indicator_id, 2);?>
                                        <?php $firsts = $arr[0];?>
                                        <?php if ($a == $firsts) { ?><!-- $a is IA1, IA2  tapos ung $firsts eto dn ung IA1, etc pero kinukuha to sa indicator_id-->
                                            <?php if($iteem[$checklist] == 0){?> <!-- so ung checklist dito ay para kunin ung value ng indicator checklist sa newArray ang value nian is $iteem[0] which is ung $iteem[0] sa newArray ay ung indicator_checklist_id sa db  -->
                                                        <td colspan = "11"><b><?php echo $iteem[$number]; ?></b></td> <!-- title ng isang indicator sa ilalim ng Child Indicator -->
                                                    </tr>
                                                    <tr>
                                                    <?php foreach($secondNewArray as $b => $secondItems): ?> <!-- array for secondNewArray for child lower lower indicator -->
                                                       <?php foreach($getSecondCategory as $secondCategory):?>
                                                        <?php if($secondCategory->mother_indicator_id == $firstCategory->indicator_id) { ?>

                                                        <?php $arrays = explode("-", $secondCategory->indicator_id, 2);?>
                                                        <?php $seconds = $arrays[0];?>
                                                        <?php if ($b == $seconds) { ?>
                                                        <?php if($secondItems[$checklist2] == 0){?>
                                                            <td colspan = "11"><b><?php echo $secondItems[$number2]; ?></b></td>
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
                                                                                                                       <?php if($counting4 > 1){ ?> <!-- kung ma detect nia sa counting2 is greater than 1 ibig sbhn ay meron Bronze medal. -->

                                                                                                                            <td><?php echo $fourthItem[$number4]; ?></td>
                                                                                                                                <?php foreach($getLSWDO as $key=>$value): ?>
                                                                                                                                <?php if($value->indicator_id == $d.'-'.$fourthItem[$checklist4]){ ?>
                                                                                                                                <td><input type="radio" id = "compliance<?php echo $d.'-'.$fourthItem[$checklist4] ?>Bronze" name = "compliance<?php echo $d.'-'.$fourthItem[$checklist4] ?>Bronze" value = "1" required  <?php if($value->compliance_indicator_id == 1){ echo "checked"; } ?>/> Compliance</td>
                                                                                                                                <td><input type="radio" id = "compliance<?php echo $d.'-'.$fourthItem[$checklist4] ?>Bronze" name = "compliance<?php echo $d.'-'.$fourthItem[$checklist4] ?>Bronze" value = "2" <?php if($value->compliance_indicator_id == 2){ echo "checked"; } ?>/> Not Compliance</td>
                                                                                                                                <td><input type="radio" id = "compliance<?php echo $d.'-'.$fourthItem[$checklist4] ?>Bronze" name = "compliance<?php echo $d.'-'.$fourthItem[$checklist4] ?>Bronze" value = "3" <?php if($value->compliance_indicator_id == 3){ echo "checked"; } ?>/> N/A</td>
                                                                                                                                <?php } ?>
                                                                                                                                <?php endforeach ?>
                                                                                                                                <?php if($counting4 > 3){?>
                                                                                                                                    <td><?php echo $fourthItem[$number4 + 2]; ?></td>
                                                                                                                                   <?php foreach($getLSWDO as $key=>$value): ?>
                                                                                                                                <?php if($value->indicator_id == $d.'-'.$fourthItem[$checklist4+2]){ ?>
                                                                                                                                    <td><input type="radio" id = "compliance<?php echo $d.'-'.$fourthItem[$checklist4+2] ?>Silver" name = "compliance<?php echo $d.'-'.$fourthItem[$checklist4+2] ?>Silver" value = "1" required  <?php if($value->compliance_indicator_id == 1){ echo "checked"; } ?>/> Compliance</td>
                                                                                                                                    <td><input type="radio" id = "compliance<?php echo $d.'-'.$fourthItem[$checklist4+2] ?>Silver" name = "compliance<?php echo $d.'-'.$fourthItem[$checklist4+2] ?>Silver" value = "2" <?php if($value->compliance_indicator_id == 2){ echo "checked"; } ?>/> Not Compliance</td>
                                                                                                                                    <td><input type="radio" id = "compliance<?php echo $d.'-'.$fourthItem[$checklist4+2] ?>Silver" name = "compliance<?php echo $d.'-'.$fourthItem[$checklist4+2] ?>Silver" value = "3" <?php if($value->compliance_indicator_id == 3){ echo "checked"; } ?>/> N/A</td>
                                                                                                                                     <?php } ?>
                                                                                                                                <?php endforeach ?>
                                                                                                                                    <?php if($counting4 > 5){ ?>
                                                                                                                                        <td><?php echo $fourthItem[$number4 + 4]; ?></td>
                                                                                                                                        <?php foreach($getLSWDO as $key=>$value): ?>
                                                                                                                                        <?php if($value->indicator_id == $d.'-'.$fourthItem[$checklist4+4]){ ?>
                                                                                                                                        <td><input type="radio" id = "compliance<?php echo $d.'-'.$fourthItem[$checklist4+4] ?>Gold" name = "compliance<?php echo $d.'-'.$fourthItem[$checklist4+4] ?>Gold" value = "1" required  <?php if($value->compliance_indicator_id == 1){ echo "checked"; } ?>/> Compliance</td>
                                                                                                                                        <td><input type="radio" id = "compliance<?php echo $d.'-'.$fourthItem[$checklist4+4] ?>Gold" name = "compliance<?php echo $d.'-'.$fourthItem[$checklist4+4] ?>Gold" value = "2" <?php if($value->compliance_indicator_id == 2){ echo "checked"; } ?>/> Not Compliance</td>
                                                                                                                                        <td><input type="radio" id = "compliance<?php echo $d.'-'.$fourthItem[$checklist4+4] ?>Gold" name = "compliance<?php echo $d.'-'.$fourthItem[$checklist4+4] ?>Gold" value = "3" <?php if($value->compliance_indicator_id == 3){ echo "checked"; } ?>/> N/A</td>
                                                                                                                                        <?php } ?>
                                                                                                                                        <?php endforeach ?>
                                                                                                                                        <?php foreach($getLSWDO as $key=>$value): ?>
                                                                                                                                            <?php if($d.'-'.$fourthItem[$checklist] == $value->indicator_id ){ ?> <td><textarea id = "textArea<?php echo $secondCategoryLowerLower->indicator_id ?>" name = "textArea<?php echo $secondCategoryLowerLower->indicator_id ?>"><?php echo $value->findings_recom; ?></textarea>asaD</td> <?php }  ?>
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
                                                               <?php if($counting3 > 1){ ?> <!-- kung ma detect nia sa counting2 is greater than 1 ibig sbhn ay meron Bronze medal. -->
                                                                  <td><?php echo $iteem[$number3]; ?></td>
                                                                  <?php foreach($getLSWDO as $key=>$value): ?>
                                                        <?php if($value->indicator_id == $c.'-'.$iteeem[$checklist3]){ ?>
                                                        <td><input type="radio" id = "compliance<?php echo $c.'-'.$iteeem[$checklist3] ?>Bronze" name = "compliance<?php echo $c.'-'.$iteeem[$checklist3] ?>Bronze" value = "1" required  <?php if($value->compliance_indicator_id == 1){ echo "checked"; } ?>/> Compliance</td>
                                                        <td><input type="radio" id = "compliance<?php echo $c.'-'.$iteeem[$checklist3] ?>Bronze" name = "compliance<?php echo $c.'-'.$iteeem[$checklist3] ?>Bronze" value = "2" <?php if($value->compliance_indicator_id == 2){ echo "checked"; } ?>/> Not Compliance</td>
                                                        <td><input type="radio" id = "compliance<?php echo $c.'-'.$iteeem[$checklist3] ?>Bronze" name = "compliance<?php echo $c.'-'.$iteeem[$checklist3] ?>Bronze" value = "3" <?php if($value->compliance_indicator_id == 3){ echo "checked"; } ?>/> N/A</td>
                                                        <?php } ?>
                                                        <?php endforeach ?>
                                                        <?php if($counting3 > 3){?>
                                                            <td><?php echo $iteeem[$number3 + 2]; ?></td>
                                                           <?php foreach($getLSWDO as $key=>$value): ?>
                                                        <?php if($value->indicator_id == $c.'-'.$iteeem[$checklist+2]){ ?>
                                                            <td><input type="radio" id = "compliance<?php echo $c.'-'.$iteeem[$checklist3+2] ?>Silver" name = "compliance<?php echo $c.'-'.$iteeem[$checklist3+2] ?>Silver" value = "1" required  <?php if($value->compliance_indicator_id == 1){ echo "checked"; } ?>/> Compliance</td>
                                                            <td><input type="radio" id = "compliance<?php echo $c.'-'.$iteeem[$checklist3+2] ?>Silver" name = "compliance<?php echo $c.'-'.$iteeem[$checklist3+2] ?>Silver" value = "2" <?php if($value->compliance_indicator_id == 2){ echo "checked"; } ?>/> Not Compliance</td>
                                                            <td><input type="radio" id = "compliance<?php echo $c.'-'.$iteeem[$checklist3+2] ?>Silver" name = "compliance<?php echo $c.'-'.$iteeem[$checklist3+2] ?>Silver" value = "3" <?php if($value->compliance_indicator_id == 3){ echo "checked"; } ?>/> N/A</td>
                                                             <?php } ?>
                                                        <?php endforeach ?>
                                                            <?php if($counting3 > 5){ ?>
                                                                <td><?php echo $iteeem[$number3 + 4]; ?></td>
                                                                <?php foreach($getLSWDO as $key=>$value): ?>
                                                                <?php if($value->indicator_id == $c.'-'.$iteeem[$checklist+4]){ ?>
                                                                <td><input type="radio" id = "compliance<?php echo $c.'-'.$iteeem[$checklist3+4] ?>Gold" name = "compliance<?php echo $c.'-'.$iteeem[$checklist3+4] ?>Gold" value = "1" required  <?php if($value->compliance_indicator_id == 1){ echo "checked"; } ?>/> Compliance</td>
                                                                <td><input type="radio" id = "compliance<?php echo $c.'-'.$iteeem[$checklist3+4] ?>Gold" name = "compliance<?php echo $c.'-'.$iteeem[$checklist3+4] ?>Gold" value = "2" <?php if($value->compliance_indicator_id == 2){ echo "checked"; } ?>/> Not Compliance</td>
                                                                <td><input type="radio" id = "compliance<?php echo $c.'-'.$iteeem[$checklist3+4] ?>Gold" name = "compliance<?php echo $c.'-'.$iteeem[$checklist3+4] ?>Gold" value = "3" <?php if($value->compliance_indicator_id == 3){ echo "checked"; } ?>/> N/A</td>
                                                                <?php } ?>
                                                                <?php endforeach ?>
                                                                <?php foreach($getLSWDO as $key=>$value): ?>
                                                                    <?php if($c.'-'.$iteeem[$checklist3] == $value->indicator_id ){ ?> <td><textarea id = "textArea<?php echo $secondCategoryLower->indicator_id ?>" name = "textArea<?php echo $secondCategoryLower->indicator_id ?>"><?php echo $value->findings_recom; ?></textarea></td> asaC<?php }  ?>
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
                                                               <?php if($counting2 > 1){ ?> <!-- kung ma detect nia sa counting2 is greater than 1 ibig sbhn ay meron Bronze medal. -->
                                                                  <td><?php echo $secondItems[$number2]; ?></td> <!-- ung $secondItems[$number2] ung kinukuha ntn na value sa secondNewArray. so ung ibig sbhn neto is $secondItems[1] since ung checklist is 0 so ung kasunod na number nia sa loob ng array is 1 which is indicator Name -->
                                                                   <?php foreach($getLSWDO as $key=>$value): ?>
                                                                   <?php if($value->indicator_id == $b.'-'.$secondItems[$checklist2]){ ?>
                                                                   <td><input type="radio" id = "compliance<?php echo $b.'-'.$secondItems[$checklist2] ?>Bronze" name = "compliance<?php echo $b.'-'.$secondItems[$checklist2] ?>Bronze" value = "1" required  <?php if($value->compliance_indicator_id == 1){ echo "checked"; } ?>/> Compliance</td>
                                                                   <td><input type="radio" id = "compliance<?php echo $b.'-'.$secondItems[$checklist2] ?>Bronze" name = "compliance<?php echo $b.'-'.$secondItems[$checklist2] ?>Bronze" value = "2" <?php if($value->compliance_indicator_id == 2){ echo "checked"; } ?>/> Not Compliance</td>
                                                                   <td><input type="radio" id = "compliance<?php echo $b.'-'.$secondItems[$checklist2] ?>Bronze" name = "compliance<?php echo $b.'-'.$secondItems[$checklist2] ?>Bronze" value = "3" <?php if($value->compliance_indicator_id == 3){ echo "checked"; } ?>/> N/A</td>
                                                                   <?php } ?>
                                                                   <?php endforeach ?>
                                                                       <?php if($counting2 > 3){ ?> <!-- kung ma detect nia sa counting2 is greater than 3 ibig sbhn ay meron Silver medal. -->
                                                                       <td><?php echo $secondItems[$number2 + 2]; ?></td> <!-- bkt may plus 2 ung sa $number2 inassume ko na lahat ng even number is indicator name-->
                                                                       <?php foreach($getLSWDO as $key=>$value): ?>
                                                                       <?php if($value->indicator_id == $b.'-'.$secondItems[$checklist2+2]){ ?>
                                                                       <td><input type="radio" id = "compliance<?php echo $b.'-'.$secondItems[$checklist2+2] ?>Silver" name = "compliance<?php echo $b.'-'.$secondItems[$checklist2+2] ?>Silver" value = "1" required  <?php if($value->compliance_indicator_id == 1){ echo "checked"; } ?>/> Compliance</td>
                                                                       <td><input type="radio" id = "compliance<?php echo $b.'-'.$secondItems[$checklist2+2] ?>Silver" name = "compliance<?php echo $b.'-'.$secondItems[$checklist2+2] ?>Silver" value = "2" <?php if($value->compliance_indicator_id == 2){ echo "checked"; } ?>/> Not Compliance</td>
                                                                       <td><input type="radio" id = "compliance<?php echo $b.'-'.$secondItems[$checklist2+2] ?>Silver" name = "compliance<?php echo $b.'-'.$secondItems[$checklist2+2] ?>Silver" value = "3" <?php if($value->compliance_indicator_id == 3){ echo "checked"; } ?>/> N/A</td>
                                                                       <?php } ?>
                                                                   <?php endforeach ?>
                                                                       <?php if($counting2 > 5){ ?> <!-- kung ma detect nia sa counting2 is greater than 5 ibig sbhn ay meron Gold medal. -->
                                                                           <td><?php echo $secondItems[$number2 + 4]; ?></td>
                                                                           <?php foreach($getLSWDO as $key=>$value): ?>
                                                                               <?php if($value->indicator_id == $b.'-'.$secondItems[$checklist2+4]){ ?>
                                                                           <td><input type="radio" id = "compliance<?php echo $b.'-'.$secondItems[$checklist2+4] ?>Gold" name = "compliance<?php echo $b.'-'.$secondItems[$checklist2+4] ?>Gold" value = "1" required  <?php if($value->compliance_indicator_id == 1){ echo "checked"; } ?>/> Compliance</td>
                                                                           <td><input type="radio" id = "compliance<?php echo $b.'-'.$secondItems[$checklist2+4] ?>Gold" name = "compliance<?php echo $b.'-'.$secondItems[$checklist2+4] ?>Gold" value = "2" <?php if($value->compliance_indicator_id == 2){ echo "checked"; } ?>/> Not Compliance</td>
                                                                           <td><input type="radio" id = "compliance<?php echo $b.'-'.$secondItems[$checklist2+4] ?>Gold" name = "compliance<?php echo $b.'-'.$secondItems[$checklist2+4] ?>Gold" value = "3" <?php if($value->compliance_indicator_id == 3){ echo "checked"; } ?>/> N/A</td>
                                                                           <?php } ?>
                                                                   <?php endforeach ?>
                                                                   <?php foreach($getLSWDO as $key=>$value): ?>
                                                                    <?php if($b.'-'.$secondItems[$checklist2] == $value->indicator_id ){ ?> <td><textarea id = "textArea<?php echo $secondCategory->indicator_id ?>" name = "textArea<?php echo $secondCategory->indicator_id ?>"><?php echo $value->findings_recom; ?></textarea>asaB</td> <?php }  ?>
                                                                   <?php endforeach ?>
                                                                       <?php } ?>
                                                                   <?php } ?>
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
<!--                                                    <td>--><?php //echo $int1 ?><!--</td>-->
                                                    <?php if($counting > 1){ ?>
                                                          <td><?php echo $iteem[$number]; ?></td>
                                                        <?php foreach($getLSWDO as $key=>$value): ?>
                                                        <?php if($value->indicator_id == $a.'-'.$iteem[$checklist]){ ?>
                                                        <td><input type="radio" id = "compliance<?php echo $a.'-'.$iteem[$checklist] ?>Bronze" name = "compliance<?php echo $a.'-'.$iteem[$checklist] ?>Bronze" value = "1" required  <?php if($value->compliance_indicator_id == 1){ echo "checked"; } ?>/> Compliance</td>
                                                        <td><input type="radio" id = "compliance<?php echo $a.'-'.$iteem[$checklist] ?>Bronze" name = "compliance<?php echo $a.'-'.$iteem[$checklist] ?>Bronze" value = "2" <?php if($value->compliance_indicator_id == 2){ echo "checked"; } ?>/> Not Compliance</td>
                                                        <td><input type="radio" id = "compliance<?php echo $a.'-'.$iteem[$checklist] ?>Bronze" name = "compliance<?php echo $a.'-'.$iteem[$checklist] ?>Bronze" value = "3" <?php if($value->compliance_indicator_id == 3){ echo "checked"; } ?>/> N/A</td>
                                                        <?php } ?>
                                                        <?php endforeach ?>
                                                        <?php if($counting > 3){?>
                                                            <td><?php echo $iteem[$number + 2]; ?></td>
                                                           <?php foreach($getLSWDO as $key=>$value): ?>
                                                        <?php if($value->indicator_id == $a.'-'.$iteem[$checklist+2]){ ?>
                                                            <td><input type="radio" id = "compliance<?php echo $a.'-'.$iteem[$checklist+2] ?>Silver" name = "compliance<?php echo $a.'-'.$iteem[$checklist+2] ?>Silver" value = "1" required  <?php if($value->compliance_indicator_id == 1){ echo "checked"; } ?>/> Compliance</td>
                                                            <td><input type="radio" id = "compliance<?php echo $a.'-'.$iteem[$checklist+2] ?>Silver" name = "compliance<?php echo $a.'-'.$iteem[$checklist+2] ?>Silver" value = "2" <?php if($value->compliance_indicator_id == 2){ echo "checked"; } ?>/> Not Compliance</td>
                                                            <td><input type="radio" id = "compliance<?php echo $a.'-'.$iteem[$checklist+2] ?>Silver" name = "compliance<?php echo $a.'-'.$iteem[$checklist+2] ?>Silver" value = "3" <?php if($value->compliance_indicator_id == 3){ echo "checked"; } ?>/> N/A</td>
                                                             <?php } ?>
                                                        <?php endforeach ?>
                                                            <?php if($counting > 5){ ?>
                                                                <td><?php echo $iteem[$number + 4]; ?></td>
                                                                <?php foreach($getLSWDO as $key=>$value): ?>
                                                                <?php if($value->indicator_id == $a.'-'.$iteem[$checklist+4]){ ?>
                                                                <td><input type="radio" id = "compliance<?php echo $a.'-'.$iteem[$checklist+4] ?>Gold" name = "compliance<?php echo $a.'-'.$iteem[$checklist+4] ?>Gold" value = "1" required  <?php if($value->compliance_indicator_id == 1){ echo "checked"; } ?>/> Compliance</td>
                                                                <td><input type="radio" id = "compliance<?php echo $a.'-'.$iteem[$checklist+4] ?>Gold" name = "compliance<?php echo $a.'-'.$iteem[$checklist+4] ?>Gold" value = "2" <?php if($value->compliance_indicator_id == 2){ echo "checked"; } ?>/> Not Compliance</td>
                                                                <td><input type="radio" id = "compliance<?php echo $a.'-'.$iteem[$checklist+4] ?>Gold" name = "compliance<?php echo $a.'-'.$iteem[$checklist+4] ?>Gold" value = "3" <?php if($value->compliance_indicator_id == 3){ echo "checked"; } ?>/> N/A</td>
                                                                <?php } ?>
                                                                <?php endforeach ?>
                                                                <?php foreach($getLSWDO as $key=>$value): ?>
                                                                    <?php if($a.'-'.$iteem[$checklist] == $value->indicator_id ){ ?> <td><textarea id = "textArea<?php echo $firstCategory->indicator_id ?>" name = "textArea<?php echo $firstCategory->indicator_id ?>"><?php echo $value->findings_recom; ?></textarea>asaA</td> <?php }  ?>
                                                                   <?php endforeach ?>
                                                             <?php } else {  ?>
                                                            <td></td>
                                                            <td></td>
                                                            <td></td>
                                                            <td></td>
                                                            <?php foreach($getLSWDO as $key=>$value): ?>
                                                                    <?php if($a.'-'.$iteem[$checklist] == $value->indicator_id ){ ?> <td><textarea id = "textArea<?php echo $firstCategory->indicator_id ?>" name = "textArea<?php echo $firstCategory->indicator_id ?>"><?php echo $value->findings_recom; ?></textarea></td> <?php }  ?>
                                                                   <?php endforeach ?>
                                                            <?php }?>
                                                        <?php } else {  ?>
                                                        <td></td>
                                                        <td></td>
                                                        <td></td>
                                                        <td></td>
                                                        <td></td>
                                                        <td></td>
                                                        <td></td>
                                                        <td></td>
                                                       <?php foreach($getLSWDO as $key=>$value): ?>
                                                                    <?php if($a.'-'.$iteem[$checklist] == $value->indicator_id ){ ?> <td><textarea id = "textArea<?php echo $firstCategory->indicator_id ?>" name = "textArea<?php echo $firstCategory->indicator_id ?>"><?php echo $value->findings_recom; ?></textarea></td> <?php }  ?>
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
                    <hr>
                    <div class="btn-group">
                        <button type="submit" id = "submit" name="submit" value="submit" class="btn btn-lg btn-rounded btn-success" class="modalicon" data-toggle="modal"><i class="fa fa-check"></i> Save</button>
                    </div>
                    <?php echo form_close() ?>
                </div>
            </div>
        </div>
    </div>

</div>
</body>
</html>
