<?php
$uid = $this->session->userdata('uid');
$access = $this->session->userdata('access');
$region = $this->session->userdata('uregion');

?><div class="sidebar clearfix">

  <ul class="sidebar-panel nav">
    <li class="sidetitle">MAIN</li>
    <li><a href="<?php echo base_url('dashboardc/dashboard/'); ?>"><span class="icon color5"><i class="fa fa-dashboard"></i></span>Dashboard</a></li> <!--edited link! -->
    <li><a href="<?php echo base_url('assessmentinfo/index'); ?>"><span class="icon color6"><i class="fa fa-users"></i></span>Assessment Information</a></li>
    <li><a href="<?php echo base_url('budgetallocation/index'); ?>"><span class="icon color6"><i class="fa fa-users"></i></span>Budget Allocation</a></li>
<!--    <li><a href="--><?php //echo base_url('indicator/indicatorView') ?><!--"><span class="icon color8"><i class="fa fa-bar-chart"></i></span>Indicators</a></li>-->
    <!--<li><a href="<?php /*echo base_url('monitoring/monitoring_list') */?>"><span class="icon color8"><i class="fa fa-bar-chart"></i></span>Monitoring</a></li><!--carla for monitoring! -->
    <li><a href="<?php echo base_url('certificate_issuance/certificate_issuance_list') ?>"><span class="icon color8"><i class="fa fa-bar-chart"></i></span>Certification Details</a></li><!--carla for Certification Details! -->

    <li><a href="#"><span class="icon color9"><i class="fa fa-book"></i></span>Libraries<span class="caret"></span></a> <!--removed link to index -->
     <!--
      <ul>
        <li><a href="<?php echo base_url('libraries/indicator/index') ?>">Standards and Indicators</a></li>
      </ul>
        -->
    </li>
    <li><a href="#"><span class="icon color9"><i class="fa fa-user-plus"></i></span>Access Control<span class="caret"></span></a> <!--added module -->
      <ul>
        <li><a href="<?php echo base_url('access_control/users') ?>">Users</a></li>
        <li><a href="<?php echo base_url('ac_userlevels/user_levels') ?>">User Levels</a></li>
        <li><a href="#">User Permissions</a></li>
      </ul>
    </li>

  </ul>

  <ul class="sidebar-panel nav">
    <li><a href="<?php echo base_url('users/change_password/' . $uid) ?>"><span class="icon color8"><i class="fa fa-lock"></i></span>Change Password</a></li>
    <li><a id="button2" href=""  data-toggle="modal" data-target="#myModal"><span class="icon color5"><i class="fa fa-sign-out"></i></span>Log-out</a></li>
    <script>

      document.querySelector('#button2').onclick = function(){
        swal({
              title: "Hey <?php if ($this->session->userdata('user_data') <>'') echo $this->session->userdata('user_data') ?>!",
              text: "Goodbye!",
              type: "success"
            },
            function(){
              window.location.href = '<?php echo base_url('users/logout') ?>'; <!--edited link -->
            })};
    </script>
  </ul>
</div>