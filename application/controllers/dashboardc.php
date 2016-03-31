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
        $dashboard_model = new dashboard_model();
        $this->load->view('header');
        $this->load->view('nav');
        $this->load->view('sidebar');
        $this->load->view('dashboard',array('getIndicator'=>$dashboard_model->getFunctionalityScore(),
            'getRegionName'=>$dashboard_model->getRegions(),
            'countRegion'=>$dashboard_model->countRegions()
        ));
        $this->load->view('footer');
    }
}
