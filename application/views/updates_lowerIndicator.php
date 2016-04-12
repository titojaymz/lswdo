<?php
/**
 * Created by PhpStorm.
 * User: ljesaclayan
 * Date: 4/12/2016
 * Time: 8:52 AM
 */
?>

<td>Lower</td>
<td>
    <select id="lowerIndicator" name = "lowerIndicator" class = "form-control-radius" style="width: 500px" onchange="load_others(this.value)">
<!--    <select id="lowerIndicator" name = "lowerIndicator" class = "form-control-radius" style="width: 500px">-->
        <option selected>Select Indicators</option>
        <?php foreach($getLowerIndicator as $lowerIndicator): ?>
            <option value = "<?php echo $lowerIndicator->indicator_id; ?>"><?php echo $lowerIndicator->indicator_name ?></option>
        <?php endforeach ?>
    </select>
</td>
