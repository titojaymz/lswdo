<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>
<!DOCTYPE HTML>
<html>
<script type="text/javascript">

    function resetButton(indicator,checklist){
        var bronze = parseInt(checklist);
        var silver = parseInt(checklist) + 1;
        var gold = parseInt(checklist) + 2;

        var indicatorBronze = indicator+'-'+bronze;
        var indicatorSilver = indicator+'-'+silver;
        var indicatorGold = indicator+'-'+gold;

        var bronzeIndi = document.getElementsByName('compliance'+indicatorBronze+'Bronze');
        for (var a = 0; a < bronzeIndi.length; a++) {
            if(bronzeIndi[a].checked) bronzeIndi[a].checked = false;
        }
        var silverIndi = document.getElementsByName('compliance'+indicatorSilver+'Silver');
        for (var b = 0; b < silverIndi.length; b++) {
            if(silverIndi[b].checked) silverIndi[b].checked = false;
        }
        var goldIndi = document.getElementsByName('compliance'+indicatorGold+'Gold');
        for (var c = 0; c < goldIndi.length; c++) {
            if(goldIndi[c].checked) goldIndi[c].checked = false;
        }


//        alert(checklist);
        return false;
    }

</script>
<body>
<?php
//if(count($checkPart1) > 0 && count($checkPart2) > 0 && count($checkPart3) > 0){
//    redirect('indicator/indicatorViewAll/'.$profileID.'/'.$refID,'location');
//}

?>
<div class="content">

    <!-- Start Page Header -->
    <div class="page-header">
        <!-- <h1 class="title">Tool for the Assessment of FUNCTIONALITY of LSWDOs</h1>-->
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url('dashboardc/dashboard'); ?>">Home</a></li>
            <li class="active">Assessment Information</li>
            <li class="active">Indicators</li>
            <li class="active">Administration and Organization</li>
            <li class="active">Program Management</li>
            <li class="active">Case Management</li>
            <li class="active">Physical structures</li>
        </ol>
    </div>
    <!-- End Page Header -->


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
                <div class = "panel-body" style="display: block;">
                    <!--                    --><?php //$countLS = count($checkPart4) ?>
                    <!--                    --><?php //if($countLS > 0){ ?>
                    <?php echo form_open('',array('class'=>'form-horizontal')) ?>

                    <input type = "hidden" id="profID" name ="profID" value ="<?php echo $profileID ?>"/>
                    <?php $unformat = ""; ?>
                    <table class="table table-bordered table-striped">
                        <tr>
                            <td colspan = "1" align = "center"><b></td>
                            <td colspan = "1" align = "center"><b>BRONZE LEVEL <BR> (MUST)</b></td>
                            <td colspan = "2" align = "center"><b>Compliance</b></td>
                            <td colspan = "1" align = "center"><b>SILVER LEVEL <BR> (DESIRED)</b></td>
                            <td colspan = "2" align = "center"><b>Compliance</b></td>
                            <td colspan = "1" align = "center"><b>GOLD LEVEL <BR> (EXEMPLARY)</b></td>
                            <td colspan = "2" align = "center"><b>Compliance</b></td>
                            <td colspan = "1" align = "center"><b>Specific Findings and Recommendation</b></td>
                        </tr>
                        <tr>
                            <td align="center" colspan = "11">
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

                                <td>
<!--                                <p>compliance--><?php //echo $b.'-'.$secondItems[$checklist2] ?><!--Bronze</p><br>-->
<!--                                <p>compliance--><?php //echo $b.'-'.$secondItems[$checklist2+2] ?><!--Silver</p><br>-->
<!--                                <p>compliance--><?php //echo $b.'-'.$secondItems[$checklist2+4] ?><!--Gold</p><br>-->
                                    <a href="" id = "sampleReset" name = "sampleReset" onclick="return resetButton('<?php echo $b;?>','<?php echo $secondItems[$checklist2];?>');" class="btn btn-sm btn-rounded btn-default">Reset</a></td>
                                <?php $counting2 = count($secondItems); ?>
                                <?php if($counting2 > 1){ ?> <!-- kung ma detect nia sa counting2 is greater than 1 ibig sbhn ay meron Bronze medal. -->
                                    <td><?php echo $secondItems[$number2]; ?></td> <!-- ung $secondItems[$number2] ung kinukuha ntn na value sa secondNewArray. so ung ibig sbhn neto is $secondItems[1] since ung checklist is 0 so ung kasunod na number nia sa loob ng array is 1 which is indicator Name -->
                                    <td><input type="radio" id = "compliance<?php echo $b.'-'.$secondItems[$checklist2] ?>Bronze" name = "compliance<?php echo $b.'-'.$secondItems[$checklist2] ?>Bronze" value = "1" required/> Compliant</td>
                                    <td><input type="radio" id = "compliance<?php echo $b.'-'.$secondItems[$checklist2] ?>Bronze" name = "compliance<?php echo $b.'-'.$secondItems[$checklist2] ?>Bronze" value = "2"/>Non-Compliant</td>
                                    <?php if($counting2 > 3){ ?> <!-- kung ma detect nia sa counting2 is greater than 3 ibig sbhn ay meron Silver medal. -->
                                        <td><?php echo $secondItems[$number2 + 2]; ?></td> <!-- bkt may plus 2 ung sa $number2 inassume ko na lahat ng even number is indicator name-->
                                        <td><input type="radio" id = "compliance<?php echo $b.'-'.$secondItems[$checklist2+2] ?>Silver" name = "compliance<?php echo $b.'-'.$secondItems[$checklist2+2] ?>Silver" value = "1"/> Compliant</td>
                                        <td><input type="radio" id = "compliance<?php echo $b.'-'.$secondItems[$checklist2+2] ?>Silver" name = "compliance<?php echo $b.'-'.$secondItems[$checklist2+2] ?>Silver" value = "2"/>Non-Compliant</td>
                                        <?php if($counting2 > 5){ ?> <!-- kung ma detect nia sa counting2 is greater than 5 ibig sbhn ay meron Gold medal. -->
                                            <td><?php echo $secondItems[$number2 + 4]; ?></td>
                                            <td><input type="radio" id = "compliance<?php echo $b.'-'.$secondItems[$checklist2+4] ?>Gold" name = "compliance<?php echo $b.'-'.$secondItems[$checklist2+4] ?>Gold" value = "1"/> Compliant</td>
                                            <td><input type="radio" id = "compliance<?php echo $b.'-'.$secondItems[$checklist2+4] ?>Gold" name = "compliance<?php echo $b.'-'.$secondItems[$checklist2+4] ?>Gold" value = "2"/>Non-Compliant</td>
                                            <td><textarea id = "textArea<?php echo $fourthCat->indicator_id ?>" name = "textArea<?php echo $fourthCat->indicator_id ?>"></textarea></td>
                                        <?php } else {  ?>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td><textarea id = "textArea<?php echo $fourthCat->indicator_id ?>" name = "textArea<?php echo $fourthCat->indicator_id ?>"></textarea></td>
                                        <?php }?>
                                    <?php } else {  ?><td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td><textarea id = "textArea<?php echo $fourthCat->indicator_id ?>" name = "textArea<?php echo $fourthCat->indicator_id ?>"></textarea></td>
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
                        <td>
                            <a href="" id = "sampleReset" name = "sampleReset" onclick="return resetButton('<?php echo $a;?>','<?php echo $iteem[$checklist];?>');" class="btn btn-sm btn-rounded btn-default">Reset</a></td>
                        <?php $counting = count($iteem); ?>
                        <?php if($counting > 1){ ?>
                        <td><?php echo $iteem[$number]; ?></td>
                        <td><input type="radio" id = "compliance<?php echo $a.'-'.$iteem[$checklist] ?>Bronze" name = "compliance<?php echo $a.'-'.$iteem[$checklist] ?>Bronze" value = "1" required/> Compliant</td>
                        <td><input type="radio" id = "compliance<?php echo $a.'-'.$iteem[$checklist] ?>Bronze" name = "compliance<?php echo $a.'-'.$iteem[$checklist] ?>Bronze" value = "2"/> Non-Compliant</td>
                        <?php if($counting > 3){?>
                        <td><?php echo $iteem[$number + 2]; ?></td>
                        <td><input type="radio" id = "compliance<?php echo $a.'-'.$iteem[$checklist+2] ?>Silver" name = "compliance<?php echo $a.'-'.$iteem[$checklist+2] ?>Silver" value = "1"/> Compliant</td>
                        <td><input type="radio" id = "compliance<?php echo $a.'-'.$iteem[$checklist+2] ?>Silver" name = "compliance<?php echo $a.'-'.$iteem[$checklist+2] ?>Silver" value = "2"/> Non-Compliant</td>
                        <?php if($counting > 5){ ?>
                        <td><?php echo $iteem[$number + 4]; ?></td>
                        <td><input type="radio" id = "compliance<?php echo $a.'-'.$iteem[$checklist+4] ?>Gold" name = "compliance<?php echo $a.'-'.$iteem[$checklist+4] ?>Gold" value = "1"/> Compliant</td>
                        <td><input type="radio" id = "compliance<?php echo $a.'-'.$iteem[$checklist+4] ?>Gold" name = "compliance<?php echo $a.'-'.$iteem[$checklist+4] ?>Gold" value = "2"/> Non-Compliant</td>
                        <td><textarea id = "textArea<?php echo $fourthIndi->indicator_id ?>" name = "textArea<?php echo $fourthIndi->indicator_id ?>"></textarea></td>

                        <?php } else {  ?>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td><textarea id = "textArea<?php echo $fourthIndi->indicator_id ?>" name = "textArea<?php echo $fourthIndi->indicator_id ?>"></textarea></td>
                        <?php }?>
                        <?php } else {  ?><td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td><textarea id = "textArea<?php echo $fourthIndi->indicator_id ?>" name = "textArea<?php echo $fourthIndi->indicator_id ?>"></textarea></td>
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
                    <hr>
                    <div class="btn-group">
                        <button type="submit" id = "submit" name="submit" value="submit" class="btn btn-lg btn-rounded btn-success" class="modalicon" data-toggle="modal"><i class="fa fa-check"></i> Save</button>
                    </div>
                    <?php echo form_close() ?>
                    <?php /*} else { */?><!--
                        <a class="btn btn-m btn-option2" href="<?php /*echo base_url('indicator/indicatorAddpart4/'.$profileID.'/'.$refID) */?>"><i class="fa fa-list"></i> Add</a><br><br>
                    --><?php /*} */?>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>
