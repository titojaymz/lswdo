<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

?><!DOCTYPE html>
<!--   <header>

   </header>
   <nav class="navbar navbar-inverse navbar-fixed-top">
       <div class="container">
           <div class="navbar-header">
               <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                   <span class="sr-only">Toggle navigation</span>
                   <span class="icon-bar"></span>
                   <span class="icon-bar"></span>
                   <span class="icon-bar"></span>
               </button>
               <a class="navbar-brand" href="#">FAMILY RISK and VA</a>
           </div>

       </div>
   </nav>
<br>
<br>
<br> -->
<!-- Start Page Loading -->
<div class="loading"><img src="<?php echo base_url('assets/bootstrap/img/loading.gif'); ?>" alt="loading-img"></div>
<!-- End Page Loading -->
<!-- //////////////////////////////////////////////////////////////////////////// -->
<!-- START TOP -->
<div id="top" class="clearfix">

    <!-- Start App Logo -->
    <div class="applogo">
        <a href="<?php echo base_url('users/index'); ?>" class="logo">FRVA</a> <!--edited link! -->
    </div>
    <!-- End App Logo -->

    <!-- Start Sidebar Show Hide Button -->
    <a href="#" class="sidebar-open-button"><i class="fa fa-bars"></i></a>
    <a href="#" class="sidebar-open-button-mobile"><i class="fa fa-bars"></i></a>
    <!-- End Sidebar Show Hide Button -->


    <!-- Start Top Menu -->
    <!-- End Top Menu -->

    <!-- Start Sidepanel Show-Hide Button -->
    <a href="#sidepanel" class="sidepanel-open-button"><i class="fa fa-outdent"></i></a>
    <!-- End Sidepanel Show-Hide Button -->

    <!-- Start Top Right -->
    <ul class="top-right">
        <li class="dropdown link">
            <a href="#" data-toggle="dropdown" class="dropdown-toggle profilebox"><b><?php if ($this->session->userdata('user_data') <>'') echo $this->session->userdata('user_data') ?></b><span class="caret"></span></a>
            <ul class="dropdown-menu dropdown-menu-list dropdown-menu-right">
                <li role="presentation" class="dropdown-header">Profile</li>
                <li class="divider"></li>
                <li><a href="<?php echo base_url('access_control/lockscreen') ?>"><i class="fa falist fa-lock"></i> Lockscreen</a></li>
                <li><a id="button3" href=""  data-toggle="modal" data-target="#myModal"><i class="fa falist fa-power-off"></i> Log-out</a></li> <!--edited link -->
                <script>

                    document.querySelector('#button3').onclick = function(){
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
        </li>

    </ul>
    <!-- End Top Right -->

</div>
<!-- END TOP -->
<!-- //////////////////////////////////////////////////////////////////////////// -->