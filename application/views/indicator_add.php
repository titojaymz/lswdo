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
                                <b><?php echo $firstMotherIndicator->indicator_name; ?></b>
                            </td>
                        </tr>
                        <?php foreach($firstIndicators as $first_indicators): ?>
                            <tr>
                                <td colspan = "14" align="center"><b><?php echo $first_indicators->indicator_name; ?></b></td>
                            </tr>
                                <?php
                                $newArray = array();
                                foreach($getFirstCategory as $item):
                                    $arr = explode("-", $item->indicator_id, 2);
                                    $first = $arr[0];
                                    $newArray[$first][] = $item->indicator_checklist_id;
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
                            <tr>
                                <?php  $number = 1; ?>
                                <?php  $number2 = 1; ?>
                                <?php  $checklist = 0; ?>
                                <?php  $checklist2 = 0; ?>
                                <?php foreach($newArray as $a => $iteem): ?>
                                    <?php foreach($getFirstCategory as $firstCategory):?>
                                        <?php if($firstCategory->mother_indicator_id == $first_indicators->indicator_id) { ?>
                                        <?php $arr = explode("-", $firstCategory->indicator_id, 2);?>
                                        <?php $firsts = $arr[0];?>
                                        <?php if ($a == $firsts) { ?>
                                            <?php if($iteem[$checklist] == 0){?>
                                                        <td colspan = "11"><b><?php echo $iteem[$number]; ?></b></td>
                                                    </tr>
                                                    <tr>
                                                    <?php foreach($secondNewArray as $b => $secondItems): ?>
                                                       <?php foreach($getSecondCategory as $secondCategory):?>
                                                        <?php if($secondCategory->mother_indicator_id == $firstCategory->indicator_id) { ?>
                                                        <?php $arrays = explode("-", $secondCategory->indicator_id, 2);?>
                                                        <?php $seconds = $arrays[0];?>
                                                        <?php if ($b == $seconds) { ?>
                                                            <?php $counting2 = count($secondItems); ?>
                                                               <?php if($counting2 > 1){ ?>
                                                                   <td><?php echo $secondItems[$number2]; ?></td>
                                                                   <td><input type="radio" id = "compliance<?php echo $b.'-'.$secondItems[$checklist2] ?>Bronze" name = "compliance<?php echo $b.'-'.$secondItems[$checklist2] ?>Bronze" value = "1" required/> Compliance</td>
                                                                   <td><input type="radio" id = "compliance<?php echo $b.'-'.$secondItems[$checklist2] ?>Bronze" name = "compliance<?php echo $b.'-'.$secondItems[$checklist2] ?>Bronze" value = "2"/> Not Compliance</td>
                                                                   <td><input type="radio" id = "compliance<?php echo $b.'-'.$secondItems[$checklist2] ?>Bronze" name = "compliance<?php echo $b.'-'.$secondItems[$checklist2] ?>Bronze" value = "3"/> N/A</td>
                                                                       <?php if($counting2 > 3){ ?>
                                                                       <td><?php echo $secondItems[$number2 + 2]; ?></td>
                                                                       <td><input type="radio" id = "compliance<?php echo $b.'-'.$secondItems[$checklist2+2] ?>Silver" name = "compliance<?php echo $b.'-'.$secondItems[$checklist2+2] ?>Silver" value = "1" required/> Compliance</td>
                                                                       <td><input type="radio" id = "compliance<?php echo $b.'-'.$secondItems[$checklist2+2] ?>Silver" name = "compliance<?php echo $b.'-'.$secondItems[$checklist2+2] ?>Silver" value = "2"/> Not Compliance</td>
                                                                       <td><input type="radio" id = "compliance<?php echo $b.'-'.$secondItems[$checklist2+2] ?>Silver" name = "compliance<?php echo $b.'-'.$secondItems[$checklist2+2] ?>Silver" value = "3"/> N/A</td>
                                                                       <?php if($counting2 > 5){ ?>
                                                                           <td><?php echo $secondItems[$number2 + 4]; ?></td>
                                                                           <td><input type="radio" id = "compliance<?php echo $b.'-'.$secondItems[$checklist2+4] ?>Gold" name = "compliance<?php echo $b.'-'.$secondItems[$checklist2+4] ?>Gold" value = "1" required/> Compliance</td>
                                                                           <td><input type="radio" id = "compliance<?php echo $b.'-'.$secondItems[$checklist2+4] ?>Gold" name = "compliance<?php echo $b.'-'.$secondItems[$checklist2+4] ?>Gold" value = "2"/> Not Compliance</td>
                                                                           <td><input type="radio" id = "compliance<?php echo $b.'-'.$secondItems[$checklist2+4] ?>Gold" name = "compliance<?php echo $b.'-'.$secondItems[$checklist2+4] ?>Gold" value = "3"/> N/A</td>
                                                                           <td><textarea id = "textArea<?php echo $secondCategory->indicator_id ?>" name = "textArea<?php echo $secondCategory->indicator_id ?>"></textarea></td>
                                                                       <?php } ?>
                                                                   <?php } ?>
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
                                                    <td><?php echo $int1 ?></td>
                                                    <?php if($counting > 1){ ?>
                                                        <td><?php echo $iteem[$number]; ?></td>
                                                        <td><input type="radio" id = "compliance<?php echo $a.'-'.$iteem[$checklist] ?>Bronze" name = "compliance<?php echo $a.'-'.$iteem[$checklist] ?>Bronze" value = "1" required/> Compliance</td>
                                                        <td><input type="radio" id = "compliance<?php echo $a.'-'.$iteem[$checklist] ?>Bronze" name = "compliance<?php echo $a.'-'.$iteem[$checklist] ?>Bronze" value = "2"/> Not Compliance</td>
                                                        <td><input type="radio" id = "compliance<?php echo $a.'-'.$iteem[$checklist] ?>Bronze" name = "compliance<?php echo $a.'-'.$iteem[$checklist] ?>Bronze" value = "3"/> N/A</td>
                                                        <?php if($counting > 3){?>
                                                            <td><?php echo $iteem[$number + 2]; ?></td>
                                                            <td><input type="radio" id = "compliance<?php echo $a.'-'.$iteem[$checklist+2] ?>Silver" name = "compliance<?php echo $a.'-'.$iteem[$checklist+2] ?>Silver" value = "1" required/> Compliance</td>
                                                            <td><input type="radio" id = "compliance<?php echo $a.'-'.$iteem[$checklist+2] ?>Silver" name = "compliance<?php echo $a.'-'.$iteem[$checklist+2] ?>Silver" value = "2" required/> Not Compliance</td>
                                                            <td><input type="radio" id = "compliance<?php echo $a.'-'.$iteem[$checklist+2] ?>Silver" name = "compliance<?php echo $a.'-'.$iteem[$checklist+2] ?>Silver" value = "3"/> N/A</td>
                                                            <?php if($counting > 5){ ?>
                                                                <td><?php echo $iteem[$number + 4]; ?></td>
                                                                <td><input type="radio" id = "compliance<?php echo $a.'-'.$iteem[$checklist+4] ?>Gold" name = "compliance<?php echo $a.'-'.$iteem[$checklist+4] ?>Gold" value = "1" required/> Compliance</td>
                                                                <td><input type="radio" id = "compliance<?php echo $a.'-'.$iteem[$checklist+4] ?>Gold" name = "compliance<?php echo $a.'-'.$iteem[$checklist+4] ?>Gold" value = "2"/> Not Compliance</td>
                                                                <td width = "25%"><input type="radio" id = "compliance<?php echo $a.'-'.$iteem[$checklist+4] ?>Gold" name = "compliance<?php echo $a.'-'.$iteem[$checklist+4] ?>Gold" value = "3"/> N/A</td>
                                                                <td><textarea id = "textArea<?php echo $firstCategory->indicator_id ?>" name = "textArea<?php echo $firstCategory->indicator_id ?>"></textarea></td>

                                                            <?php }  ?>
                                                        <?php }  ?>
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
