<?php
/**
 * Created by PhpStorm.
 * User: ljesaclayan
 * Date: 4/8/2016
 * Time: 9:22 AM
 */
?>


<td>Indicator</td>
<td>
    <select id="childIndicator" name = "childIndicator" class = "form-control-radius" style="width: 500px" onchange="load_lowerIndi(this.value)">
        <option selected>Select Indicators</option>
        <?php foreach($getChildIndicator as $childIndicator): ?>
            <option value = "<?php echo $childIndicator->indicator_id; ?>"><?php echo $childIndicator->indicator_name ?></option>
        <?php endforeach ?>
    </select>
</td>
