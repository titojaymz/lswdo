<?php
/**
 * Created by PhpStorm.
 * User: ljesaclayan
 * Date: 4/12/2016
 * Time: 9:10 AM
 */
?>
<td>Other</td>
<td>
        <select id="otherIndicator" name = "otherIndicator" class = "form-control-radius" style="width: 500px" onchange="load_lower2(this.value)">
<!--    <select id="otherIndicator" name = "otherIndicator" class = "form-control-radius" style="width: 500px">-->
        <option selected>Select Indicators</option>
        <?php foreach($getOtherIndicator as $otherIndicator): ?>
            <option value = "<?php echo $otherIndicator->indicator_id; ?>"><?php echo $otherIndicator->indicator_name ?></option>
        <?php endforeach ?>
    </select>
</td>

