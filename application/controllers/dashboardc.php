<?php
/**
 * Created by PhpStorm.
 * User: mblejano
 * Date: 3/8/2016
 * Time: 4:30 PM
 */
class dashboardc extends CI_Controller {

    public function dashboard($regCode)
    {
        $dashboard_model = new dashboard_model();
        $indicator_model = new indicator_model();
        $provCode = 0;
        $lgu_PSWDO = 1;
        $lgu_CSWDO = 2;
        $lgu_MSWDO = 3;
        $this->load->view('header');
        $this->load->view('nav');
        $this->load->view('sidebar');
        $this->load->view('dashboard',array('getIndicator'=>$dashboard_model->getFunctionalityScore(),
            'getRegionName'=>$dashboard_model->getRegions(),
            'countRegion'=>$dashboard_model->countRegions(),
            'pgetScorePart1'=>$indicator_model->getScorePartarray1($regCode,$provCode,$lgu_PSWDO),
            'cgetScorePart1'=>$indicator_model->getScorePartarray1($regCode,$provCode,$lgu_CSWDO),
            'mgetScorePart1'=>$indicator_model->getScorePartarray1($regCode,$provCode,$lgu_MSWDO)

        ));
        $this->load->view('footer');
    }
}
