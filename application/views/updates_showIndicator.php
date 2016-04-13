<?php
/**
 * Created by PhpStorm.
 * User: ljesaclayan
 * Date: 4/12/2016
 * Time: 9:19 AM
 */
?>

<?php $countIndi = count($getIndicatorUpdate); ?>
<br><br>
<table width = "100%">
    <tr>
        <td align = "center" width ="50%"><b>Indicators</b></td>
        <td align = "center" colspan = "2" width ="50%"><b>Compliance</b></td>
    </tr>
    <tr>
        <td width ="50%"><?php echo $getLibCodes->indicator_name; ?></td>
        <input type = "hidden" id = "indicatorID" name = "indicatorID" value = "<?php echo $getLibCodes->indicator_id; ?>"/>
        <?php if($countIndi != 0){ ?>
        <td width ="25%"><input type="radio" id = "compliance" name = "compliance" value = "1" <?php if($getIndicatorUpdate->newValue == 1){ echo "checked"; } ?>/>Compliant</td>
        <td width ="25%"><input type="radio" id = "compliance" name = "compliance" value = "2" <?php if($getIndicatorUpdate->newValue == 2){ echo "checked"; } ?>/>Not Compliant</td>
        <?php } else { ?>
            <td width ="25%"><input type="radio" id = "compliance" name = "compliance" value = "1" />Compliant</td>
            <td width ="25%"><input type="radio" id = "compliance" name = "compliance" value = "2" />Not Compliant</td>
        <?php }  ?>
    </tr>
</table>
