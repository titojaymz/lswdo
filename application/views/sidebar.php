<!--    <li><a href="--><?php //echo base_url('budgetallocation/index'); ?><!--"><span class="icon color6"><i class="fa fa-users"></i></span>Budget Allocation</a></li>-->
<!--    <li><a href="--><?php //echo base_url('indicator/indicatorView') ?><!--"><span class="icon color8"><i class="fa fa-bar-chart"></i></span>Indicators</a></li>-->
<!--<li><a href="<?php /*echo base_url('monitoring/monitoring_list') */?>"><span class="icon color8"><i class="fa fa-bar-chart"></i></span>Monitoring</a></li><!--carla for monitoring! -->
<!--<li><a href="<?php echo base_url('certificate_issuance/certificate_issuance_list'); ?>"><span class="icon color8"><i class="fa fa-file-text"></i></span>Certification Details</a></li>carla for Certification Details! -->
<!--
      <ul>
        <li><a href="<?php echo base_url('libraries/indicator/index') ?>">Standards and Indicators</a></li>
      </ul>
        -->
<?php
$uid = $this->session->userdata('uid');
$access = $this->session->userdata('accessLevel');
$region = $this->session->userdata('lswdo_regioncode');

?>
<div class="sidebar clearfix">
  <ul class="sidebar-panel nav">
    <li class="sidetitle">MAIN</li>
<!--    <li><a href="--><?php //echo base_url('dashboardc/dashboard/'.$region.''); ?><!--"><span class="icon color5"><i class="fa fa-dashboard"></i></span>Dashboard</a></li> <!--edited link! -->-->
    <?php if($access == -1 || $access == 3 || $access == 4 || $access == 5){ ?>
      <li><a href="<?php echo base_url('assessmentinfo/index/0'); ?>"><span class="icon color6"><i class="fa fa-users"></i></span>Assessment Information</a></li>
      <li><a href="<?php echo base_url('reports/index'); ?>"><span class="icon color8"><i class="fa fa-bar-chart"></i></span>Reports</a></li><!--michael for Reports -->
      <li><a href="#"><span class="icon color9"><i class="fa fa-book"></i></span>Libraries<span class="caret"></span></a> <!--removed link to index -->
           <!-- ibinalik ko na libraries  cxvxc  -->
            <ul>
                <li><a href="<?php echo base_url('lib_regionc/index') ?>">Regions</a></li>
                <li><a href="<?php echo base_url('lib_provc/index') ?>">Provinces</a></li>
                <li><a href="<?php echo base_url('lib_cityc/index') ?>">Cities</a></li>
                <!--     <li><a href="<?php echo base_url('lib_brgyc/index') ?>">Barangay</a></li>-->
            </ul>
      </li>
    <?php } ?>

    <li><a href="#"><span class="icon color9"><i class="fa fa-user-plus"></i></span>Access Control<span class="caret"></span></a> <!--added module -->
      <ul>
        <li><a href="<?php echo base_url('access_control/users') ?>">Users</a></li>
<?php if($access == -1){?>
        <li><a href="<?php echo base_url('userlevel/userlevel_list') ?>">User Levels</a></li>
<?php } ?>
      </ul>
    </li>

  </ul>

  <ul class="sidebar-panel nav">
    <li><a href="<?php echo base_url('users/change_password/' . $uid) ?>"><span class="icon color8"><i class="fa fa-lock"></i></span>Change Password</a></li>
    <li><a id="button2" href=""  data-toggle="modal" data-target="#myModal"><span class="icon color5"><i class="fa fa-sign-out"></i></span>Log-out</a></li>
    <script>

      document.querySelector('#button2').onclick = function(){
        swal({
              title: "Hey <?php if ($this->session->userdata('fullName') <>'') echo $this->session->userdata('fullName') ?>!",
              text: "Goodbye!",
              type: "success"
            },
            function(){
              window.location.href = '<?php echo base_url('users/logout') ?>'; <!--edited link -->
            })};
    </script>
  </ul>
</div>