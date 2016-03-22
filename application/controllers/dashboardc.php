<?php
/**
 * Created by PhpStorm.
 * User: mblejano
 * Date: 3/8/2016
 * Time: 4:30 PM
 */
class dashboardc extends CI_Controller {

    public function dashboard()
    {
        $this->load->view('header');
        $this->load->view('nav');
        $this->load->view('sidebar');
        $this->load->view('dashboard');
        $this->load->view('footer');
    }
}
