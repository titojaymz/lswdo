<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>
<!DOCTYPE HTML>
<html>

<script src="//code.jquery.com/jquery-1.10.2.js"></script>
<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
<link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
<script>
    $(function() {
        $( "#visit_date" ).datepicker();
    });
    $(function() {
        $( "#date_issued" ).datepicker();
    });
</script><!--CARLA-->

<style type="text/css">
    body{background: #F5F5F5;}

</style>

<body>
<div class="content">

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
                <div class = "panel-body" style="display: block;">

                    <?php
                        $profile_id = $this->uri->segment('3');
                        $ref_id = $this->uri->segment('4');

                    ?>

                    <a class="btn btn-m btn-option5" href="<?php echo base_url('indicator/indicatorViewpart4/'.$profile_id.'/'.$ref_id) ?>"><i class="fa fa-caret-square-o-down"></i>Back to <b>IV. Physical Structures and Safety</b></a>
                    <br/><br/>
                    <a class="btn btn-m btn-option5" href="<?php echo base_url('indicator/indicatorViewAll/'.$profile_id.'/'.$ref_id) ?>"><i class="fa fa-caret-square-o-down"></i><b>View All</b></a><br><br>

                    <?php

                        $attributes = array("class" => "form-horizontal", "id" => "psbRiderQs", "name" => "psbRiderQs");
                        //echo form_open("indicator/indicatorView/$profile_id", $attributes);
                        echo form_open("", $attributes);

                        echo "<input type=\"hidden\" id=\"profile_id\" name=\"profile_id\" class=\"form-control\" value ='".$profile_id."'/>";
                        echo "<input type=\"hidden\" id=\"ref_id\" name=\"ref_id\" class=\"form-control\" value ='".$ref_id."'/>";

                    ?>


                    <table class="table table-bordered table-striped">
                        <tr>
                            <td colspan = '4'>Please choose either <b>YES</b> if you are implementing and <b>NO</b> if you are not implementing the identified programs and services under each vulnerable sector</b></td>
                        </tr>
                        <tr>

                            <?php

                                $getPSBMainCategory = $PSBRider_Model->getPSBMainCategory();
                               // print_r($getPSBMainCategory);
                                foreach($getPSBMainCategory as $key => $val)
                                {
                                    $psbrider_main_category_title = $val['psbrider_main_category_title'];
                                    echo "<td colspan='2'><center><b>";
                                    echo $psbrider_main_category_title;
                                    echo "</b></center></td>";

                                    echo "<td><b>";
                                    echo "YES/NO";
                                    echo "</b></td>";

                                    echo "<td><b>";
                                    echo "If No Please give indicative reason";
                                    echo "</b></td>";

                                    $psbrider_main_category_id = $val['psbrider_main_category_id'];

                                    $getPSBSubCategory = $PSBRider_Model->getPSBSubCategory($psbrider_main_category_id);

                                    $counter = 1;
                                    foreach($getPSBSubCategory as $keySub => $valSub)
                                    {
                                        $psbrider_sub_category_id = $valSub['psbrider_sub_category_id'];
                                        $psbrider_sub_category_title = $valSub['psbrider_sub_category_title'];
                                        if(!in_array($psbrider_sub_category_id, array('16','17','26','27','39','40','48','49','66','67','75','76'), true )){
                                        $arrOfAnswer = array("No", "Yes");
//                                        $psbrider_sub_category_id = $valSub['psbrider_sub_category_id'];
//                                        $psbrider_sub_category_title = $valSub['psbrider_sub_category_title'];

                                        echo " </tr>";

                                        echo " <tr>";
                                        echo "<td>";
                                        echo $counter;
                                        echo "</td>";

                                        echo "<td>";
                                        echo $psbrider_sub_category_title;
                                        echo "</td>";



                                       // print_r($arrOfAnswer);
                                        echo "<td>";
                                        echo "<input type = 'radio' id='arrOfAns-".$psbrider_sub_category_id."' name='arrOfAns-".$psbrider_sub_category_id."' value = '0' checked='checked'> No<br>";
                                        echo "<input type = 'radio' id='arrOfAns-".$psbrider_sub_category_id."' name='arrOfAns-".$psbrider_sub_category_id."' value = '1' > Yes";
                                        echo "</select>";
                                        echo "</td>";

                                        echo "<td>";
                                        echo "<textarea id = 'textAreaReason-".$psbrider_sub_category_id."' name = 'textAreaReason-".$psbrider_sub_category_id."'>";
                                       // echo "<textarea id='txtareaReason-".$psbrider_sub_category_id."' name='txtareaReason-".$psbrider_sub_category_id."' rows='4' cols='50' placeholder='Enter text here'>";
                                        echo "</textarea>";
                                        echo "</td>";
                                        echo " </tr>";
                                        $counter++;

                                        }
                                    }
                                    foreach($getPSBSubCategory as $keySub => $valSub)
                                    {
                                        $psbrider_sub_category_id = $valSub['psbrider_sub_category_id'];
                                        $psbrider_sub_category_title = $valSub['psbrider_sub_category_title'];
                                        if(in_array($psbrider_sub_category_id, array('16','17','26','27','39','40','48','49','66','67','75','76'), true )){
                                            $arrOfAnswer = array("No", "Yes");
//                                        $psbrider_sub_category_id = $valSub['psbrider_sub_category_id'];
//                                        $psbrider_sub_category_title = $valSub['psbrider_sub_category_title'];

                                            echo " </tr>";

                                            echo " <tr>";
                                            echo "<td>";
                                            echo $counter;
                                            echo "</td>";

                                            echo "<td>";
                                            echo $psbrider_sub_category_title;
                                            echo "</td>";



                                            // print_r($arrOfAnswer);
                                            echo "<td>";
                                            echo "<input type = 'radio' id='arrOfAns-".$psbrider_sub_category_id."' name='arrOfAns-".$psbrider_sub_category_id."' value = '0' checked='checked'> No<br>";
                                            echo "<input type = 'radio' id='arrOfAns-".$psbrider_sub_category_id."' name='arrOfAns-".$psbrider_sub_category_id."' value = '1' > Yes";
                                            echo "</select>";
                                            echo "</td>";

                                            echo "<td>";
                                            echo "<textarea id = 'textAreaReason-".$psbrider_sub_category_id."' name = 'textAreaReason-".$psbrider_sub_category_id."'>";
                                            // echo "<textarea id='txtareaReason-".$psbrider_sub_category_id."' name='txtareaReason-".$psbrider_sub_category_id."' rows='4' cols='50' placeholder='Enter text here'>";
                                            echo "</textarea>";
                                            echo "</td>";
                                            echo " </tr>";
                                            $counter++;

                                        }
                                    }
                                }
                            ?>



                    </table>
                    <?php

                    ?>

                    <hr>
                    <div class="btn-group">
                        <input id="btn_add" name="btn_add" type="submit" class="btn btn-primary" value="Insert" />
                    </div>

                    </div>
                    <?php echo form_close() ?>
                    <!--              <pre>-->
                    <!--                    --><?php //print_r($getSecondCategory); ?>
                    <!--                </pre>-->
                    <?php //print_r($getSecondCategory); ?>
                </div>
            </div>
        </div>
    </div>

</div>
</body>
</html>
