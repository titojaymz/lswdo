<?php
/**
 * Created by PhpStorm.
 * User: ljesaclayan
 * Date: 4/14/2016
 * Time: 11:04 AM
 */
?>

<div class="content">
    <div class="page-header">
        <h1 class="title">Reports Table View</h1>
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
                            <tr>
                                <td>Areas</td>
                                <td>Indicators</td>
                                <td>Compliance</td>
                                <td>Non-compliance</td>
                            </tr>
<!--                            Start First Part-->
                            <?php foreach($getPart1 as $firstMotherIndicator): ?>

                                <?php if($firstMotherIndicator->indicator_checklist_id == 1){ ?>
                                    <?php
                                        $arr = explode("-",$firstMotherIndicator->indicator_id);
                                        $indicatorID = $arr[0];
                                    ?>
                                    <?php foreach($getScorePart1 as $scorePart1):?>
                                        <?php
                                            $total = $scorePart1->TotalCompliance + $scorePart1->TotalNonCompliance;
                                            $expected = $total / 2;

                                            $complianceFit = pow($scorePart1->TotalCompliance - $expected,2)/$expected;
                                            $nonComplianceFit = pow($scorePart1->TotalNonCompliance - $expected,2)/$expected;
                                            $goodnessofFit = $complianceFit + $nonComplianceFit;
                                        ?>
                                        <?php if($scorePart1->indicator_id == $firstMotherIndicator->indicator_id){ ?>
                                    <tr>
                                        <td><?php echo $getFirstMotherIndicator->indicator_name ?></td>
                                        <td><?php echo $indicatorID.'.'.$firstMotherIndicator->indicator_name ?></td>
                                        <td><?php echo $scorePart1->TotalCompliance ?></td>
                                        <td><?php echo $scorePart1->TotalNonCompliance ?></td>
                                    </tr>
                                        <?php } ?>
                                    <?php endforeach ?>
                                <?php } ?>
                            <?php endforeach ?>
                            <!--End First Part-->
                            <!-- Start Second Part-->
                            <?php foreach($getPart2 as $secondMotherIndicator): ?>

                                <?php if($secondMotherIndicator->indicator_checklist_id == 1){ ?>
                                    <?php
                                        $arr = explode("-",$secondMotherIndicator->indicator_id);
                                        $indicatorID = $arr[0];
                                    ?>
                                    <?php foreach($getScorePart1 as $scorePart1):?>
                                        <?php
                                            $total = $scorePart1->TotalCompliance + $scorePart1->TotalNonCompliance;
                                            $expected = $total / 2;

                                            $complianceFit = pow($scorePart1->TotalCompliance - $expected,2)/$expected;
                                            $nonComplianceFit = pow($scorePart1->TotalNonCompliance - $expected,2)/$expected;
                                            $goodnessofFit = $complianceFit + $nonComplianceFit;
                                        ?>
                                        <?php if($scorePart1->indicator_id == $secondMotherIndicator->indicator_id){ ?>
                                    <tr>
                                        <td><?php echo $getSecondMotherIndicator->indicator_name ?></td>
                                        <td><?php echo $indicatorID.'.'.$secondMotherIndicator->indicator_name ?></td>
                                        <td><?php echo $scorePart1->TotalCompliance ?></td>
                                        <td><?php echo $scorePart1->TotalNonCompliance ?></td>
                                    </tr>
                                        <?php } ?>
                                    <?php endforeach ?>
                                <?php } ?>
                            <?php endforeach ?>
                            <!--End Second Part-->
                            <!-- Start Third Part-->
                            <?php foreach($getPart3 as $thirdMotherIndicator): ?>

                                <?php if($thirdMotherIndicator->indicator_checklist_id == 1){ ?>
                                    <?php
                                        $arr = explode("-",$thirdMotherIndicator->indicator_id);
                                        $indicatorID = $arr[0];
                                    ?>
                                    <?php foreach($getScorePart1 as $scorePart1):?>
                                        <?php
                                            $total = $scorePart1->TotalCompliance + $scorePart1->TotalNonCompliance;
                                            $expected = $total / 2;

                                            $complianceFit = pow($scorePart1->TotalCompliance - $expected,2)/$expected;
                                            $nonComplianceFit = pow($scorePart1->TotalNonCompliance - $expected,2)/$expected;
                                            $goodnessofFit = $complianceFit + $nonComplianceFit;
                                        ?>
                                        <?php if($scorePart1->indicator_id == $thirdMotherIndicator->indicator_id){ ?>
                                    <tr>
                                        <td><?php echo $getThirdMotherIndicator->indicator_name ?></td>
                                        <td><?php echo $indicatorID.'.'.$thirdMotherIndicator->indicator_name ?></td>
                                        <td><?php echo $scorePart1->TotalCompliance ?></td>
                                        <td><?php echo $scorePart1->TotalNonCompliance ?></td>
                                    </tr>
                                        <?php } ?>
                                    <?php endforeach ?>
                                <?php } ?>
                            <?php endforeach ?>
                            <!--End Third Part-->
                            <!-- Start Fourth Part-->
                            <?php foreach($getPart4 as $fourthMotherIndicator): ?>

                                <?php if($fourthMotherIndicator->indicator_checklist_id == 1){ ?>
                                    <?php
                                        $arr = explode("-",$fourthMotherIndicator->indicator_id);
                                        $indicatorID = $arr[0];
                                    ?>
                                    <?php foreach($getScorePart1 as $scorePart1):?>
                                        <?php
                                            $total = $scorePart1->TotalCompliance + $scorePart1->TotalNonCompliance;
                                            $expected = $total / 2;

                                            $complianceFit = pow($scorePart1->TotalCompliance - $expected,2)/$expected;
                                            $nonComplianceFit = pow($scorePart1->TotalNonCompliance - $expected,2)/$expected;
                                            $goodnessofFit = $complianceFit + $nonComplianceFit;
                                        ?>
                                        <?php if($scorePart1->indicator_id == $fourthMotherIndicator->indicator_id){ ?>
                                    <tr>
                                        <td><?php echo $getFourthMotherIndicator->indicator_name ?></td>
                                        <td><?php echo $indicatorID.'.'.$fourthMotherIndicator->indicator_name ?></td>
                                        <td><?php echo $scorePart1->TotalCompliance ?></td>
                                        <td><?php echo $scorePart1->TotalNonCompliance ?></td>
                                    </tr>
                                        <?php } ?>
                                    <?php endforeach ?>
                                <?php } ?>
                            <?php endforeach ?>
                            <!--End Fourth Part-->
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

