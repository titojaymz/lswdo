<?php
/**
 * Created by PhpStorm.
 * User: mblejano
 * Date: 3/8/2016
 * Time: 4:30 PM
 */
class updates extends CI_Controller {

    public function update_view($profID,$refID)
    {
        $updates_model = new updates_model();
        $indicator_model = new indicator_model();
        $lguType = $indicator_model->getLGUtype($profID);
        $this->load->view('header');
        $this->load->view('nav');
        $this->load->view('sidebar');
        $this->load->view('updates_view',array(
            'getDetail'=>$updates_model->getDetails($profID,$refID),
            'getMotherIndicator'=>$updates_model->getMotherIndicator(),
            'getIndicatorList'=>$updates_model->getIndicatorList(),
            'getTotalIndicatorsPart1'=>$indicator_model->getTotalIndicatorsPart1($lguType->lgu_type_id),
            'getTotalIndicatorsPart2'=>$indicator_model->getTotalIndicatorsPart2($lguType->lgu_type_id),
            'getTotalIndicatorsPart3'=>$indicator_model->getTotalIndicatorsPart3($lguType->lgu_type_id),
            'getTotalIndicatorsPart4'=>$indicator_model->getTotalIndicatorsPart4($lguType->lgu_type_id),
            'getTotalScoreIndicatorsPart1'=>$indicator_model->getTotalScoreIndicatorsPart1($lguType->lgu_type_id),
            'getTotalScoreIndicatorsPart2'=>$indicator_model->getTotalScoreIndicatorsPart2($lguType->lgu_type_id),
            'getTotalScoreIndicatorsPart3'=>$indicator_model->getTotalScoreIndicatorsPart3($lguType->lgu_type_id),
            'getTotalScoreIndicatorsPart4'=>$indicator_model->getTotalScoreIndicatorsPart4($lguType->lgu_type_id),
            'getScorePerProf'=>$indicator_model->getScorePerProf($profID,$refID),
            'profID'=>$profID,
            'refID'=>$refID,
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
    public function updateAdd($profID,$refID)
    {
        if (!$this->session->userdata('user_id')) {
            redirect('/users/login', 'location');
        }
        $date_today = date('Y-m-d');
        $updates_model = new updates_model();
        $indicator_model = new indicator_model();
        $this->validateUpdatesIndicator();

        if (!$this->form_validation->run()) {
            $form_message = '';
            $this->load->view('header');
            $this->load->view('nav');
            $this->load->view('sidebar');
            $this->load->view('updates_add', array(
                'getDetail'=>$updates_model->getDetails($profID,$refID),
                'getMotherIndicator'=>$updates_model->getMotherIndicator(),
            ));
            $this->load->view('footer');
        } else {
            $date_today = date('Y-m-d');
            $indicatorID = $this->input->post('indicatorID');
            $compliance = $this->input->post('compliance');

            $getIndicatorUpdate = $updates_model->getIndicatorUpdate($indicatorID);
            $count = count($getIndicatorUpdate);
            if($count > 0) {
                $updatesResultBronze = $updates_model->updateUpdates($indicatorID, $profID, $refID, $compliance, $date_today);
            } else {
                $updatesResultBronze = $updates_model->insertUpdates($indicatorID, $profID, $refID, $compliance, $compliance, $date_today,1);
            }
            if($updatesResultBronze){
                $form_message = 'Add Success!';
                $this->load->view('header');
                $this->load->view('nav');
                $this->load->view('sidebar');
                $this->load->view('updates_add', array(
                    'getDetail'=>$updates_model->getDetails($profID,$refID),
                    'getMotherIndicator'=>$updates_model->getMotherIndicator(),
                ));
                $this->load->view('footer');
                $scoreProf = $indicator_model->getScorePerProf($profID, $refID);
                $getPerc = $scoreProf->FinalScore;
                $totalScore = $scoreProf->TotalScore;
                if($getPerc == 100){
                    $level = 'Fully Functional';
                } elseif($getPerc > 50 && $getPerc < 100){
                    $level = 'Functional';
                } elseif($getPerc < 51) {
                    $level = 'Partially Functional';
                }
                $addFunction = $indicator_model->updateFunctionality($profID, $refID,$level,$totalScore);
                $this->redirectIndex($profID,$refID);
            }
        }
    }

    protected function validateUpdatesIndicator()
    {
        $config = array(

            array(
                'field'   => 'motherIndicator',
                'label'   => 'Sample',
                'rules'   => 'required'
            )
        );

        return $this->form_validation->set_rules($config);

    }
    public function redirectIndex($profID,$refID)
    {
        $page = base_url('updates/update_view/'.$profID.'/'.$refID);
//        $sec = "1";
        header("Location: $page");
    }
}
