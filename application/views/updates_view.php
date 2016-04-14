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
                                <td width = "12%">Previous Compliance</td>
                                <td width = "13%">Updated Compliance</td>
                                <td width = "25%">Date Updated</td>
                            </tr>
                            <?php foreach($getIndicatorList as $row): ?>
                            <?php
                                if($row->newValue == 1){
                                    $compliance = 'Compliant';
                                } else {
                                    $compliance = 'Not Compliant';
                                }
                                if($row->oldValue == 1){
                                    $complianceOld = 'Compliant';
                                } else {
                                    $complianceOld = 'Not Compliant';
                                }
                             ?>
                                <tr>
                                    <td width = "50%"><?php echo $row->indicator_name ?></td>
                                    <td width = "25%"><?php echo $complianceOld ?></td>
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

    <!--Score-->
    <div class = "row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-title">
                    Score
                    <ul class="panel-tools">
                        <li><a class="icon minimise-tool"><i class="fa fa-minus"></i></a></li>
                    </ul>
                </div>
                <div class = "panel-body" style="display: block;">
                    <table class="table table-bordered table-striped" width = "100%">
                        <tr>
                            <td width ="25%" colspan = "2" rowspan = "2"><b>Indicators</b></td>
                            <td width ="25%" colspan = "2" align="center"><b>Bronze</b></td>
                            <td width ="25%" colspan = "2" align="center"><b>Silver</b></td>
                            <td width ="25%" colspan = "2" align="center"><b>Gold</b></td>

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
                            <td align="center"><?php echo $getTotalScoreIndicatorsPart1->BronzeScoreCompliant; ?></td>
                            <td align="center"><?php echo $getTotalIndicatorsPart1->Silver; ?></td>
                            <td align="center"><?php echo $getTotalScoreIndicatorsPart1->SilverScoreCompliant; ?></td>
                            <td align="center"><?php echo $getTotalIndicatorsPart1->Gold; ?></td>
                            <td align="center"><?php echo $getTotalScoreIndicatorsPart1->GoldScoreCompliant; ?></td>
                        </tr>
                        <!-- Part 2 -->
                        <tr>
                            <td colspan="2">II. Program Management</td>
                            <td align="center"><?php echo $getTotalIndicatorsPart2->Bronze; ?></td>
                            <td align="center"><?php echo $getTotalScoreIndicatorsPart2->BronzeScoreCompliant; ?></td>
                            <td align="center"><?php echo $getTotalIndicatorsPart2->Silver; ?></td>
                            <td align="center"><?php echo $getTotalScoreIndicatorsPart2->SilverScoreCompliant; ?></td>
                            <td align="center"><?php echo $getTotalIndicatorsPart2->Gold; ?></td>
                            <td align="center"><?php echo $getTotalScoreIndicatorsPart2->GoldScoreCompliant; ?></td>
                        </tr>
                        <!-- Part 3 -->
                        <tr>
                            <td colspan="2">III. Case Management</td>
                            <td align="center"><?php echo $getTotalIndicatorsPart3->Bronze; ?></td>
                            <td align="center"><?php echo $getTotalScoreIndicatorsPart3->BronzeScoreCompliant; ?></td>
                            <td align="center"><?php echo $getTotalIndicatorsPart3->Silver; ?></td>
                            <td align="center"><?php echo $getTotalScoreIndicatorsPart3->SilverScoreCompliant; ?></td>
                            <td align="center"><?php echo $getTotalIndicatorsPart3->Gold; ?></td>
                            <td align="center"><?php echo $getTotalScoreIndicatorsPart3->GoldScoreCompliant; ?></td>
                        </tr>
                        <!-- Part 4 -->
                        <tr>
                            <td colspan="2">IV. Physical Structures and Safety</td>
                            <td align="center"><?php echo $getTotalIndicatorsPart4->Bronze; ?></td>
                            <td align="center"><?php echo $getTotalScoreIndicatorsPart4->BronzeScoreCompliant; ?></td>
                            <td align="center"><?php echo $getTotalIndicatorsPart4->Silver; ?></td>
                            <td align="center"><?php echo $getTotalScoreIndicatorsPart4->SilverScoreCompliant; ?></td>
                            <td align="center"><?php echo $getTotalIndicatorsPart4->Gold; ?></td>
                            <td align="center"><?php echo $getTotalScoreIndicatorsPart4->GoldScoreCompliant; ?></td>
                        </tr>
                        <?php
                            $bronzeTotal = $getTotalScoreIndicatorsPart1->BronzeScoreCompliant + $getTotalScoreIndicatorsPart2->BronzeScoreCompliant + $getTotalScoreIndicatorsPart3->BronzeScoreCompliant + $getTotalScoreIndicatorsPart4->BronzeScoreCompliant;
                            $silverTotal = $getTotalScoreIndicatorsPart1->SilverScoreCompliant + $getTotalScoreIndicatorsPart2->SilverScoreCompliant + $getTotalScoreIndicatorsPart3->SilverScoreCompliant + $getTotalScoreIndicatorsPart4->SilverScoreCompliant;
                            $goldTotal = $getTotalScoreIndicatorsPart1->GoldScoreCompliant + $getTotalScoreIndicatorsPart2->GoldScoreCompliant + $getTotalScoreIndicatorsPart3->GoldScoreCompliant + $getTotalScoreIndicatorsPart4->GoldScoreCompliant;
                        $getPercBronze = $getScorePerProf->FinalScore;

                        if($getPercBronze == 100){
                            $levelBronze = 'Fully Functional';
                        } elseif($getPercBronze > 50 && $getPercBronze < 100){
                            $levelBronze = 'Functional';
                        } elseif($getPercBronze < 51) {
                            $levelBronze = 'Partially Functional';
                        }

                        ?>
                        <tr>
                            <td colspan = "2">Total</td>
                            <td colspan = "2" align="center"><b><?php echo $bronzeTotal; ?></b></td>
                            <td colspan = "2" align="center"><b><?php echo $silverTotal; ?></b></td>
                            <td colspan = "2" align="center"><b><?php echo $goldTotal; ?></b></td>
                        </tr>
                        <tr>
                            <td colspan = "2">Level of Functionality</td>
                            <td colspan = "2" align="center"><b><?php echo $levelBronze; ?></b></td>
                            <td colspan = "2" align="center"><b><?php echo ''; ?></b></td>
                            <td colspan = "2" align="center"><b><?php echo ''; ?></b></td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>

    </div>
</div>
