<!DOCTYPE html>
<script>
    function load_childIndi(str)
    {
        document.getElementById("motherIndicator").value = str;
        if (str=="")
        {
            document.getElementById("div_childIndi").innerHTML="";
            return;
        }
        if (window.XMLHttpRequest)
        {// code for IE7+, Firefox, Chrome, Opera, Safari
            xmlhttp=new XMLHttpRequest();
        }
        else
        {// code for IE6, IE5
            xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
        }
        xmlhttp.onreadystatechange=function()
        {
            if (xmlhttp.readyState==4 && xmlhttp.status==200)
            {
                document.getElementById("div_childIndi").innerHTML=xmlhttp.responseText;
            }
        }
        xmlhttp.open("GET","<?php echo base_url('updates/clientsubcategorylist') ?>/"+str,true);
        xmlhttp.send();
    }


    function load_lowerIndi(str)
    {
        document.getElementById("childIndicator").value = str;
        if (str=="")
        {
            document.getElementById("div_lowerIndi").innerHTML="";
            return;
        }
        if (window.XMLHttpRequest)
        {// code for IE7+, Firefox, Chrome, Opera, Safari
            xmlhttp=new XMLHttpRequest();
        }
        else
        {// code for IE6, IE5
            xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
        }
        xmlhttp.onreadystatechange=function()
        {
            if (xmlhttp.readyState==4 && xmlhttp.status==200)
            {
                document.getElementById("div_lowerIndi").innerHTML=xmlhttp.responseText;
            }
        }
        xmlhttp.open("GET","<?php echo base_url('updates/lowerIndicatorList') ?>/"+str,true);
        xmlhttp.send();
    }
    function load_others(str)
    {
        var n = str.indexOf('-');
        if( n === -1) {
            document.getElementById("lowerIndicator").value = str;
            if (str=="")
            {
                document.getElementById("div_others").innerHTML="";
                return;
            }
            if (window.XMLHttpRequest)
            {// code for IE7+, Firefox, Chrome, Opera, Safari
                xmlhttp=new XMLHttpRequest();
            }
            else
            {// code for IE6, IE5
                xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
            }
            xmlhttp.onreadystatechange=function()
            {
                if (xmlhttp.readyState==4 && xmlhttp.status==200)
                {
                    document.getElementById("div_others").innerHTML=xmlhttp.responseText;
                }
            }
            xmlhttp.open("GET","<?php echo base_url('updates/otherIndicatorList') ?>/"+str,true);
            xmlhttp.send();
        } else {
            document.getElementById("lowerIndicator").value = str;
            if (str=="")
            {
                document.getElementById("showIndicators").innerHTML="";
                return;
            }
            if (window.XMLHttpRequest)
            {// code for IE7+, Firefox, Chrome, Opera, Safari
                xmlhttp=new XMLHttpRequest();
            }
            else
            {// code for IE6, IE5
                xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
            }
            xmlhttp.onreadystatechange=function()
            {
                if (xmlhttp.readyState==4 && xmlhttp.status==200)
                {
                    document.getElementById("showIndicators").innerHTML=xmlhttp.responseText;
                }
            }
            xmlhttp.open("GET","<?php echo base_url('updates/showIndicator') ?>/"+str,true);
            xmlhttp.send();
        }

    }

    function load_lower2(str)
    {
        var n = str.indexOf('-');
        if( n === -1) {
            document.getElementById("otherIndicator").value = str;
            if (str=="")
            {
                document.getElementById("div_lower2Indi").innerHTML="";
                return;
            }
            if (window.XMLHttpRequest)
            {// code for IE7+, Firefox, Chrome, Opera, Safari
                xmlhttp=new XMLHttpRequest();
            }
            else
            {// code for IE6, IE5
                xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
            }
            xmlhttp.onreadystatechange=function()
            {
                if (xmlhttp.readyState==4 && xmlhttp.status==200)
                {
                    document.getElementById("div_lower2Indi").innerHTML=xmlhttp.responseText;
                }
            }
            xmlhttp.open("GET","<?php echo base_url('updates/lower2IndicatorList') ?>/"+str,true);
            xmlhttp.send();
        } else {
            document.getElementById("otherIndicator").value = str;
            if (str=="")
            {
                document.getElementById("showIndicators").innerHTML="";
                return;
            }
            if (window.XMLHttpRequest)
            {// code for IE7+, Firefox, Chrome, Opera, Safari
                xmlhttp=new XMLHttpRequest();
            }
            else
            {// code for IE6, IE5
                xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
            }
            xmlhttp.onreadystatechange=function()
            {
                if (xmlhttp.readyState==4 && xmlhttp.status==200)
                {
                    document.getElementById("showIndicators").innerHTML=xmlhttp.responseText;
                }
            }
            xmlhttp.open("GET","<?php echo base_url('updates/showIndicator') ?>/"+str,true);
            xmlhttp.send();
        }

    }
    function load_lower3(str)
    {
        var n = str.indexOf('-');
        if( n === -1) {
//            document.getElementById("otherIndicator").value = str;
//            if (str=="")
//            {
//                document.getElementById("div_lower2Indi").innerHTML="";
//                return;
//            }
//            if (window.XMLHttpRequest)
//            {// code for IE7+, Firefox, Chrome, Opera, Safari
//                xmlhttp=new XMLHttpRequest();
//            }
//            else
//            {// code for IE6, IE5
//                xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
//            }
//            xmlhttp.onreadystatechange=function()
//            {
//                if (xmlhttp.readyState==4 && xmlhttp.status==200)
//                {
//                    document.getElementById("div_lower2Indi").innerHTML=xmlhttp.responseText;
//                }
//            }
//            xmlhttp.open("GET","<?php //echo base_url('updates/lower2IndicatorList') ?>///"+str,true);
//            xmlhttp.send();
        } else {
            document.getElementById("lower2Indicator").value = str;
            if (str=="")
            {
                document.getElementById("showIndicators").innerHTML="";
                return;
            }
            if (window.XMLHttpRequest)
            {// code for IE7+, Firefox, Chrome, Opera, Safari
                xmlhttp=new XMLHttpRequest();
            }
            else
            {// code for IE6, IE5
                xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
            }
            xmlhttp.onreadystatechange=function()
            {
                if (xmlhttp.readyState==4 && xmlhttp.status==200)
                {
                    document.getElementById("showIndicators").innerHTML=xmlhttp.responseText;
                }
            }
            xmlhttp.open("GET","<?php echo base_url('updates/showIndicator') ?>/"+str,true);
            xmlhttp.send();
        }

    }
</script>
<div class="content">
    <div class="page-header">
        <h1 class="title">Updates Add</h1>
    </div>
    <div class="container-padding">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-title">
                        Updates
                    </div>
<!--                    <a class="btn btn-sm btn-primary"  href="--><?php //echo base_url('access_control/addUser') ?><!--"><i class="fa fa-plus"></i>Add New User</a><br><br>-->
                    <div class="panel-body table-responsive">
                        <table class="table table-hover" border = "1">
                            <tr>
                                <td>LGU Type:</td>
                                <td><?php echo $getDetail->lgu_type_name; ?></td>
                            </tr>
                            <tr>
                                <td>Region:</td>
                                <td><?php echo $getDetail->region_name; ?></td>
                            </tr>
                            <tr>
                                <td>Number of Visit:</td>
                                <td><?php echo $getDetail->visit_count; ?></td>
                            </tr>
                            <tr>
                                <td>Visit Date:</td>
                                <td><?php echo $getDetail->visit_date; ?></td>
                            </tr>
                        </table>
                        <hr>
                        <?php echo form_open('',array('class'=>'form-horizontal')) ?>
                        <table class="table display table-bordered table-striped table-hover">
                            <tr>
                                <td>Category</td>
                                <td>
                                    <select id="motherIndicator" name = "motherIndicator" class = "form-control-radius" style="width: 500px" onchange="load_childIndi(this.value)">
                                        <option selected>Select Category</option>
                                        <?php foreach($getMotherIndicator as $motherIndicator): ?>
                                            <option value = "<?php echo $motherIndicator->indicator_id; ?>"><?php echo $motherIndicator->indicator_name ?></option>
                                        <?php endforeach ?>
                                    </select>
                                </td>
                            </tr>
                            <tr id="div_childIndi"></tr>
                            <tr id="div_lowerIndi"></tr>
                            <tr id="div_others"></tr>
                            <tr id="div_lower2Indi"></tr>
                        </table>

                        <div id="showIndicators"></div>

                        <hr>
                        <div class="btn-group">
                            <button type="submit" id = "submit" name="submit" value="submit" class="btn btn-lg btn-rounded btn-success" ><i class="fa fa-check"></i> Update</button>
                        </div>
                        <?php echo form_close() ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>