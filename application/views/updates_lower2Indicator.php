<?php
/**
 * Created by PhpStorm.
 * User: ljesaclayan
 * Date: 4/12/2016
 * Time: 1:31 PM
 */
?>

<td>Lower2</td>
<td>
    <select id="lower2Indicator" name = "lower2Indicator" class = "form-control-radius" style="width: 500px" onchange="load_lower3(this.value)">
<!--            <select id="lower2Indicator" name = "lower2Indicator" class = "form-control-radius" style="width: 500px">-->
        <option selected>Select Indicators</option>
        <?php foreach($getLower2Indicator as $lower2Indicator): ?>
            <option value = "<?php echo $lower2Indicator->indicator_id; ?>"><?php echo $lower2Indicator->indicator_name ?></option>
        <?php endforeach ?>
    </select>
</td>
