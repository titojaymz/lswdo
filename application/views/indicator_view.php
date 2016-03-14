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
                <a href="<?php echo base_url('indicator/indicatorAdd') ?>" class = "btn btn-lg btn-rounded btn-option4">Add Indicator</a>
                <?php echo form_open('',array('class'=>'form-horizontal')) ?>
                <table class="table table-bordered table-striped">
                    <tr>
                        <td><b>Indicators</b></td>
                        <td><b>Compliance</b></td>
                        <td><b>Specific Findings and Recommendation</b></td>
                    </tr>
                    <tr>
                        <td align="center" colspan = "7">
                            <b><?php echo $firstMotherIndicator->indicator_name; ?></b>
                        </td>
                    </tr>
                    <?php foreach($firstIndicators as $first_indicators): ?>
                        <tr>
                            <td colspan = "7" align="center"><b><?php echo $first_indicators->indicator_name; ?></b></td>
                        </tr>
                        <!-- BRONZE !!!!!! -->
                        <?php foreach($getFirstCategory as $firstCatBronze): ?>
                            <?php if($firstCatBronze->mother_indicator_id == $first_indicators->indicator_id){ ?>
                                <?php if($firstCatBronze->indicator_checklist_id == "0"){ ?>
                                    <tr>
                                        <td colspan = "7"><b><?php echo $firstCatBronze->indicator_name; ?></b></td>
                                    </tr>
                                    <?php foreach($getSecondCategory as $second_category): ?>
                                        <?php if($second_category->mother_indicator_id == $firstCatBronze->indicator_id){ ?>
                                            <?php if($second_category->indicator_checklist_id == 'Bronze'){ ?>
                                                <tr>
                                                    <td><b>BRONZE LEVEL ( MUST )</b><bR><?php echo $second_category->indicator_name ?></td>
                                                    <td></td>
                                                    <td></td>
                                                </tr>
                                            <?php } ?>
                                        <?php } ?>
                                    <?php endforeach ?>
                                    <?php foreach($getSecondCategory as $secondcatSilver): ?>
                                        <?php if($secondcatSilver->mother_indicator_id == $firstCatBronze->indicator_id){ ?>
                                            <?php if($secondcatSilver->indicator_checklist_id == 'Silver'){ ?>
                                                <tr>
                                                    <td><b>SILVER LEVEL ( DESIRED )</b><bR><?php echo $secondcatSilver->indicator_name ?></td>
                                                    <td></td>
                                                </tr>
                                            <?php } ?>
                                        <?php } ?>
                                    <?php endforeach ?>
                                    <?php foreach($getSecondCategory as $secondCatGold): ?>
                                        <?php if($secondCatGold->mother_indicator_id == $firstCatBronze->indicator_id){ ?>
                                            <?php if($secondCatGold->indicator_checklist_id == 'Gold'){ ?>
                                                <tr>
                                                    <td><b>GOLD LEVEL ( EXEMPLARY )</b><bR><?php echo $secondCatGold->indicator_name ?></td>
                                                    <td></td>
                                                    <td></td>
                                                </tr>
                                            <?php } ?>
                                        <?php } ?>
                                    <?php endforeach ?>
                                <?php } ?>
                                <?php if($firstCatBronze->indicator_checklist_id == 'Bronze'){ ?>
                                    <tr>
                                        <td><b>BRONZE LEVEL ( MUST )</b><bR><?php echo $firstCatBronze->indicator_name ?></td>
                                        <td></td>
                                        <td></td>
                                    </tr>

                                <?php } ?>
                            <?php } ?>
                        <?php endforeach ?>
                        <!-- SILVER !!!!!! -->
                        <?php foreach($getFirstCategory as $firstCatSilver): ?>
                            <?php if($firstCatSilver->mother_indicator_id == $first_indicators->indicator_id){ ?>
                                <?php if($firstCatSilver->indicator_checklist_id == 'Silver'){ ?>
                                    <tr>
                                        <td><b>SILVER LEVEL ( DESIRED )</b><bR><?php echo $firstCatSilver->indicator_name ?></td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                <?php } ?>

                            <?php } ?>
                        <?php endforeach ?>
                        <!-- GOLD ! !!!!!! -->
                        <?php foreach($getFirstCategory as $firstCatGold): ?>
                            <?php if($firstCatGold->mother_indicator_id == $first_indicators->indicator_id){ ?>
                                <?php if($firstCatGold->indicator_checklist_id == 'Gold'){ ?>
                                    <tr>
                                        <td><b>GOLD LEVEL ( EXEMPLARY )</b><bR><?php echo $firstCatGold->indicator_name ?></td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                <?php } ?>

                            <?php } ?>
                        <?php endforeach ?>
                    <?php endforeach ?>
                </table>
<?php
$compliance = "select123";
$indicator = substr($compliance, strpos($compliance, "t") + 1);
echo $indicator;
?>
                <?php echo form_close() ?>
<!--              <pre>-->
<!--                    --><?php //print_r($getSecondCategory); ?>
<!--                </pre>-->
            </div>
        </div>
    </div>
</div>

</div>
</body>
</html>
