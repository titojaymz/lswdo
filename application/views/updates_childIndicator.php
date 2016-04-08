<?php
/**
 * Created by PhpStorm.
 * User: ljesaclayan
 * Date: 4/8/2016
 * Time: 9:22 AM
 */
?>


<td>Child Indicator</td>
<td>
    <select id="childIndicator" name = "childIndicator" class = "form-control-radius" style="width: 500px">
        <option selected>Select Category</option>
        <?php foreach($getChildIndicator as $childIndicator): ?>
            <option value = "<?php echo $childIndicator->indicator_id; ?>"><?php echo $childIndicator->indicator_name ?></option>
        <?php endforeach ?>
    </select>
</td>
