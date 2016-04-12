<?php
/**
 * Created by PhpStorm.
 * User: mblejano
 * Date: 3/8/2016
 * Time: 4:30 PM
 */
class updates extends CI_Controller {

    public function update_add($profID,$refID)
    {
        $updates_model = new updates_model();
        $this->load->view('header');
        $this->load->view('nav');
        $this->load->view('sidebar');
        $this->load->view('updates_add',array(
            'getDetail'=>$updates_model->getDetails($profID,$refID),
            'getMotherIndicator'=>$updates_model->getMotherIndicator(),
        ));
        $this->load->view('footer');
    }

    public function clientsubcategorylist($mother_category)
    {
        $updates_model = new updates_model();
        $this->load->view('updates_childIndicator', array('getChildIndicator' => $updates_model->geChildIndicator($mother_category)));
    }
    public function lowerIndicatorList($mother_category)
    {
        $updates_model = new updates_model();
        $this->load->view('updates_lowerIndicator', array('getLowerIndicator' => $updates_model->geChildIndicator($mother_category)));
    }
    public function otherIndicatorList($mother_category)
    {
        $updates_model = new updates_model();
        $this->load->view('updates_otherIndicator', array('getOtherIndicator' => $updates_model->geChildIndicator($mother_category)));
    }
    public function lower2IndicatorList($mother_category)
    {
        $updates_model = new updates_model();
        $this->load->view('updates_lower2Indicator', array('getLower2Indicator' => $updates_model->geChildIndicator($mother_category)));
    }
    public function showIndicator($mother_category)
    {
        $updates_model = new updates_model();
        $this->load->view('updates_showIndicator', array(
            'getLibCodes' => $updates_model->getLibCodes($mother_category),
            'getIndicatorUpdate' => $updates_model->getIndicatorUpdate($mother_category),
        ));
    }
}
