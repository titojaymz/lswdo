<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class indicator extends CI_Controller
{
    public function indicatorView($profID,$ref_id)
    {
        if (!$this->session->userdata('user_id'))
        {
            redirect('/users/login','location');
        }

        $indicator_model = new indicator_model();
        $lguTypes = $indicator_model->getLGUtype($profID);


        $this->load->view('header');
        $this->load->view('nav');
        $this->load->view('sidebar');
        $this->load->view('indicator_view', array(
            'firstMotherIndicator' => $indicator_model->getFirstMotherIndicator(),
            'firstIndicators' => $indicator_model->getFirstIndicators(),
            'getFirstCategory' => $indicator_model->getCategoriesFromFI($lguTypes->lgu_type_id),
            'getSecondCategory' => $indicator_model->getSecondCategoriesFromFI($lguTypes->lgu_type_id),
            'getLSWDO' => $indicator_model->getLSWDOdata($profID,$ref_id),
            'checkPart1' => $indicator_model->getCheckPart1($profID,$ref_id),
            'checkPart2' => $indicator_model->getCheckPart2($profID,$ref_id),
            'checkPart3' => $indicator_model->getCheckPart3($profID,$ref_id),
            'profileID' => $profID,
            'refID' => $ref_id,
        ));
        $this->load->view('footer');

    }
    public function indicatorViewpart2($profID,$ref_id)
    {
        if (!$this->session->userdata('user_id'))
        {
            redirect('/users/login','location');
        }
        $indicator_model = new indicator_model();
        $lguTypes = $indicator_model->getLGUtype($profID);
        $this->load->view('header');
        $this->load->view('nav');
        $this->load->view('sidebar');
        $this->load->view('indicator_viewpart2', array(
            'secondMotherIndicator' => $indicator_model->getSecondMotherIndicator(),
            'secondIndicators' => $indicator_model->getSecondIndicators(),
            'getFirstCategory' => $indicator_model->getCategoriesFromSI($lguTypes->lgu_type_id),
            'getSecondCategory' => $indicator_model->getSecondCategoriesFromSI($lguTypes->lgu_type_id),
            'getSecondCategoryLower' => $indicator_model->getSecondCategoriesLowerFromSI($lguTypes->lgu_type_id),
            'getSecondCategoryLowerLower' => $indicator_model->getSecondCategoriesLowerLowerFromSI($lguTypes->lgu_type_id),
            'getLSWDO' => $indicator_model->getLSWDOdata($profID,$ref_id),
            'checkPart2' => $indicator_model->getCheckPart2($profID,$ref_id),
            'profileID' => $profID,
            'refID' => $ref_id,
        ));
        $this->load->view('footer');
    }
    public function indicatorViewpart3($profID,$ref_id)
    {
        if (!$this->session->userdata('user_id'))
        {
            redirect('/users/login','location');
        }
        $indicator_model = new indicator_model();
        $lguTypes = $indicator_model->getLGUtype($profID);
        $this->load->view('header');
        $this->load->view('nav');
        $this->load->view('sidebar');
        $this->load->view('indicator_viewpart3', array(
            'thirdMotherIndicator' => $indicator_model->getThirdMotherIndicator(),
            'thirdIndicators' => $indicator_model->getThirdIndicators(),
            'getFirstCategory' => $indicator_model->getCategoriesFromTI($lguTypes->lgu_type_id),
            'getSecondCategory' => $indicator_model->getSecondCategoriesFromTI($lguTypes->lgu_type_id),
            'getLSWDO' => $indicator_model->getLSWDOdata($profID,$ref_id),
            'checkPart3' => $indicator_model->getCheckPart3($profID,$ref_id),
            'profileID' => $profID,
            'refID' => $ref_id,
        ));
        $this->load->view('footer');
    }
    public function indicatorViewpart4($profID,$ref_id)
    {
        if (!$this->session->userdata('user_id'))
        {
            redirect('/users/login','location');
        }

        $indicator_model = new indicator_model();
        $lguTypes = $indicator_model->getLGUtype($profID);


        $this->load->view('header');
        $this->load->view('nav');
        $this->load->view('sidebar');
        $this->load->view('indicator_viewpart4', array(
            'fourthMotherIndicator' => $indicator_model->getFourthMotherIndicator(),
            'fourthIndicators' => $indicator_model->getFourthIndicators(),
            'fourthCategory' => $indicator_model->getCategoriesFromFourthI(),
            'getLSWDO' => $indicator_model->getLSWDOdata($profID,$ref_id),
            'checkPart1' => $indicator_model->getCheckPart1($profID,$ref_id),
            'checkPart2' => $indicator_model->getCheckPart2($profID,$ref_id),
            'checkPart3' => $indicator_model->getCheckPart3($profID,$ref_id),
            'checkPart4' => $indicator_model->getCheckPart4($profID,$ref_id),
            'profileID' => $profID,
            'refID' => $ref_id,
        ));
        $this->load->view('footer');

    }

    public function indicatorViewAll($profID,$ref_id)
    {
        if (!$this->session->userdata('user_id'))
        {
            redirect('/users/login','location');
        }
        $indicator_model = new indicator_model();
        $PSBRider_Model = new PSBRider_Model();


        $lguTypes = $indicator_model->getLGUtype($profID);
        $this->load->view('header');
        $this->load->view('nav');
        $this->load->view('sidebar');
        $this->load->view('indicator_viewAll', array(
            'firstMotherIndicator' => $indicator_model->getFirstMotherIndicator(),
            'firstIndicators' => $indicator_model->getFirstIndicators(),
            'getFirstCategory' => $indicator_model->getCategoriesFromFI($lguTypes->lgu_type_id),
            'getSecondCategory' => $indicator_model->getSecondCategoriesFromFI($lguTypes->lgu_type_id),
            'secondMotherIndicator' => $indicator_model->getSecondMotherIndicator(),
            'secondIndicators' => $indicator_model->getSecondIndicators(),
            'getThirdCategory' => $indicator_model->getCategoriesFromSI($lguTypes->lgu_type_id),
            'getFourthCategory' => $indicator_model->getSecondCategoriesFromSI($lguTypes->lgu_type_id),
            'getSecondCategoryLower' => $indicator_model->getSecondCategoriesLowerFromSI($lguTypes->lgu_type_id),
            'getSecondCategoryLowerLower' => $indicator_model->getSecondCategoriesLowerLowerFromSI($lguTypes->lgu_type_id),
            'thirdMotherIndicator' => $indicator_model->getThirdMotherIndicator(),
            'thirdIndicators' => $indicator_model->getThirdIndicators(),
            'getFifthCategory' => $indicator_model->getCategoriesFromTI($lguTypes->lgu_type_id),
            'getSixCategory' => $indicator_model->getSecondCategoriesFromTI($lguTypes->lgu_type_id),
            'fourthMotherIndicator' => $indicator_model->getFourthMotherIndicator(),
            'fourthIndicators' => $indicator_model->getFourthIndicators(),
            'fourthCategory' => $indicator_model->getCategoriesFromFourthI(),
            'getLSWDO' => $indicator_model->getLSWDOdata($profID,$ref_id),
            'checkPart1' => $indicator_model->getCheckPart1($profID,$ref_id),
            'checkPart2' => $indicator_model->getCheckPart2($profID,$ref_id),
            'checkPart3' => $indicator_model->getCheckPart3($profID,$ref_id),
            'checkPart4' => $indicator_model->getCheckPart4($profID,$ref_id),
            'scoreProf' => $indicator_model->getBaselineScorePerProf($profID,$ref_id),
            'getTotalIndicatorsPart1'=>$indicator_model->getTotalIndicatorsPart1($lguTypes->lgu_type_id),
            'getTotalIndicatorsPart2'=>$indicator_model->getTotalIndicatorsPart2($lguTypes->lgu_type_id),
            'getTotalIndicatorsPart3'=>$indicator_model->getTotalIndicatorsPart3($lguTypes->lgu_type_id),
            'getTotalIndicatorsPart4'=>$indicator_model->getTotalIndicatorsPart4($lguTypes->lgu_type_id),
            'getBaselineTotalScoreIndicatorsPart1' => $indicator_model->getBaselineTotalScoreIndicatorsPart1($lguTypes->lgu_type_id,$profID,$ref_id),
            'getBaselineTotalScoreIndicatorsPart2' => $indicator_model->getBaselineTotalScoreIndicatorsPart2($lguTypes->lgu_type_id,$profID,$ref_id),
            'getBaselineTotalScoreIndicatorsPart3' => $indicator_model->getBaselineTotalScoreIndicatorsPart3($lguTypes->lgu_type_id,$profID,$ref_id),
            'getBaselineTotalScoreIndicatorsPart4' => $indicator_model->getBaselineTotalScoreIndicatorsPart4($lguTypes->lgu_type_id,$profID,$ref_id),
            'profileID' => $profID,
            'refID' => $ref_id,
            'PSBRider_Model' => $PSBRider_Model,
        ));
        $this->load->view('footer');
    }

    public function indicatorAdd($profID,$ref_id)
    {
        if (!$this->session->userdata('user_id'))
        {
            redirect('/users/login','location');
        }
        $date_today = date('Y-m-d');
        $indicator_model = new indicator_model();
        $updates_model = new updates_model();
        $this->validateAddIndicator();
        $lguTypes = $indicator_model->getLGUtype($profID);
        if (!$this->form_validation->run()){
            $form_message = '';
            $this->load->view('header');
            $this->load->view('nav');
            $this->load->view('sidebar');
            $this->load->view('indicator_add', array(
                'firstMotherIndicator' => $indicator_model->getFirstMotherIndicator(),
                'firstIndicators' => $indicator_model->getFirstIndicators(),
                'getFirstCategory' => $indicator_model->getCategoriesFromFI($lguTypes->lgu_type_id),
                'getSecondCategory' => $indicator_model->getSecondCategoriesFromFI($lguTypes->lgu_type_id),
                'LGUType' => $indicator_model->getLGUtype($profID),
                'profileID' => $profID,
                'refID' => $ref_id,
            ));
            $this->load->view('footer');
        } else {
                foreach($indicator_model->getCategoriesFromFI($lguTypes->lgu_type_id) as $firstCatBronze):
                    if($firstCatBronze->indicator_checklist_id != '0') {
                        $complianceBronze = $this->input->post('compliance' . $firstCatBronze->indicator_id . 'Bronze');
                        $complianceSilver = $this->input->post('compliance' . $firstCatBronze->indicator_id . 'Silver');
                        $complianceGold = $this->input->post('compliance' . $firstCatBronze->indicator_id . 'Gold');
                        $profile = $this->input->post('profID');
                        $indicator = $firstCatBronze->indicator_id;
                        $findings =  $this->input->post('textArea'. $firstCatBronze->indicator_id);
                        if($complianceBronze != ""){
                            $addResultBronze = $indicator_model->insertFirstIndicator($profile, $indicator, $complianceBronze, $findings,$ref_id);
                            $updatesResultBronze = $updates_model->insertUpdates($indicator,$profile,$ref_id , $complianceBronze, $complianceBronze,$date_today,0);
                        }
                        if($complianceSilver != ""){
                            $addResultSilver = $indicator_model->insertFirstIndicator($profile, $indicator, $complianceSilver, $findings,$ref_id);
                            $updatesResultSilver = $updates_model->insertUpdates($indicator,$profile,$ref_id , $complianceSilver, $complianceSilver,$date_today,0);
                        }if($complianceGold != ""){
                            $addResultGold = $indicator_model->insertFirstIndicator($profile, $indicator, $complianceGold, $findings,$ref_id);
                            $updatesResultGold = $updates_model->insertUpdates($indicator,$profile,$ref_id , $complianceGold, $complianceGold,$date_today,0);
                        }
                    } else {
                        continue;
                    }
                endforeach;
                foreach($indicator_model->getSecondCategoriesFromFI($lguTypes->lgu_type_id) as $secondCat):
                    if($secondCat->indicator_checklist_id != '0') {
                    $complianceBronze = $this->input->post('compliance' . $secondCat->indicator_id . 'Bronze');
                    $complianceSilver = $this->input->post('compliance' . $secondCat->indicator_id . 'Silver');
                    $complianceGold = $this->input->post('compliance' . $secondCat->indicator_id . 'Gold');
                    $profile = $this->input->post('profID');
                    $indicator = $secondCat->indicator_id;
                    $findings = $this->input->post('textArea'. $secondCat->indicator_id);
                    if($complianceBronze != ""){
                        $addResultBronze = $indicator_model->insertFirstIndicator($profile, $indicator, $complianceBronze, $findings,$ref_id);
                        $updatesResultBronze = $updates_model->insertUpdates($indicator,$profile,$ref_id , $complianceBronze, $complianceBronze,$date_today,0);
                    }
                    if($complianceSilver != ""){
                        $addResultSilver = $indicator_model->insertFirstIndicator($profile, $indicator, $complianceSilver, $findings,$ref_id);
                        $updatesResultSilver = $updates_model->insertUpdates($indicator,$profile,$ref_id , $complianceSilver, $complianceSilver,$date_today,0);
                    } if($complianceGold != ""){
                            $addResultGold = $indicator_model->insertFirstIndicator($profile, $indicator, $complianceGold, $findings,$ref_id);
                            $updatesResultGold = $updates_model->insertUpdates($indicator,$profile,$ref_id , $complianceGold, $complianceGold,$date_today,0);
                    }
                    } else {
                        continue;
                    }
                endforeach;
            if($addResultBronze || $addResultSilver || $addResultGold){
                $form_message = 'Add Success!';
                $this->load->view('header');
                $this->load->view('nav');
                $this->load->view('sidebar');
                $this->load->view('indicator_view', array(
                    'firstMotherIndicator' => $indicator_model->getFirstMotherIndicator(),
                    'firstIndicators' => $indicator_model->getFirstIndicators(),
                    'getFirstCategory' => $indicator_model->getCategoriesFromFI($lguTypes->lgu_type_id),
                    'getSecondCategory' => $indicator_model->getSecondCategoriesFromFI($lguTypes->lgu_type_id),
                ));
                $this->load->view('footer');
                $this->redirectIndex($profID,$ref_id);
            }


        }
    }
    public function indicatorAddpart2($profID,$ref_id)
    {
        if (!$this->session->userdata('user_id'))
        {
            redirect('/users/login','location');
        }

        $date_today = date('Y-m-d');
        $indicator_model = new indicator_model();
        $updates_model = new updates_model();
        $this->validateAddIndicatorpart2();
        $lguTypes = $indicator_model->getLGUtype($profID);
        if (!$this->form_validation->run()){
            $form_message = '';
            $this->load->view('header');
            $this->load->view('nav');
            $this->load->view('sidebar');
            $this->load->view('indicator_addpart2', array(
                'secondMotherIndicator' => $indicator_model->getSecondMotherIndicator(),
                'secondIndicators' => $indicator_model->getSecondIndicators(),
                'getFirstCategory' => $indicator_model->getCategoriesFromSI($lguTypes->lgu_type_id),
                'getSecondCategory' => $indicator_model->getSecondCategoriesFromSI($lguTypes->lgu_type_id),
                'getSecondCategoryLower' => $indicator_model->getSecondCategoriesLowerFromSI($lguTypes->lgu_type_id),
                'getSecondCategoryLowerLower' => $indicator_model->getSecondCategoriesLowerLowerFromSI($lguTypes->lgu_type_id),
                'profileID' => $profID,
                'refID' => $ref_id,

            ));
            $this->load->view('footer');
        } else {
            foreach($indicator_model->getCategoriesFromSI($lguTypes->lgu_type_id) as $firstCatBronze):
                if($firstCatBronze->indicator_checklist_id != '0') {
                    $complianceBronze = $this->input->post('compliance' . $firstCatBronze->indicator_id . 'Bronze');
                    $complianceSilver = $this->input->post('compliance' . $firstCatBronze->indicator_id . 'Silver');
                    $complianceGold = $this->input->post('compliance' . $firstCatBronze->indicator_id . 'Gold');
                    $profile = $this->input->post('profID');
                    $indicator = $firstCatBronze->indicator_id;
                    $findings =  $this->input->post('textArea'. $firstCatBronze->indicator_id);
                    if($complianceBronze != ""){
                        $addResultBronze = $indicator_model->insertFirstIndicator($profile, $indicator, $complianceBronze, $findings,$ref_id);
                        $updatesResultBronze = $updates_model->insertUpdates($indicator,$profile,$ref_id , $complianceBronze, $complianceBronze,$date_today,0);
                    }
                    if($complianceSilver != ""){
                        $addResultSilver = $indicator_model->insertFirstIndicator($profile, $indicator, $complianceSilver, $findings,$ref_id);
                        $updatesResultSilver = $updates_model->insertUpdates($indicator,$profile,$ref_id , $complianceSilver, $complianceSilver,$date_today,0);
                    }if($complianceGold != ""){
                        $addResultGold = $indicator_model->insertFirstIndicator($profile, $indicator, $complianceGold, $findings,$ref_id);
                        $updatesResultGold = $updates_model->insertUpdates($indicator,$profile,$ref_id , $complianceGold, $complianceGold,$date_today,0);
                    }


                } else {
                    continue;
                }
            endforeach;
            foreach($indicator_model->getSecondCategoriesFromSI($lguTypes->lgu_type_id) as $secondCat):
                if($secondCat->indicator_checklist_id != '0') {
                    $complianceBronze = $this->input->post('compliance' . $secondCat->indicator_id . 'Bronze');
                    $complianceSilver = $this->input->post('compliance' . $secondCat->indicator_id . 'Silver');
                    $complianceGold = $this->input->post('compliance' . $secondCat->indicator_id . 'Gold');
                    $profile = $this->input->post('profID');
                    $indicator = $secondCat->indicator_id;
                    $findings = $this->input->post('textArea'. $secondCat->indicator_id);
                    if($complianceBronze != ""){
                        $addResultBronze = $indicator_model->insertFirstIndicator($profile, $indicator, $complianceBronze, $findings,$ref_id);
                        $updatesResultBronze = $updates_model->insertUpdates($indicator,$profile,$ref_id , $complianceBronze, $complianceBronze,$date_today,0);
                    }
                    if($complianceSilver != ""){
                        $addResultSilver = $indicator_model->insertFirstIndicator($profile, $indicator, $complianceSilver, $findings,$ref_id);
                        $updatesResultSilver = $updates_model->insertUpdates($indicator,$profile,$ref_id , $complianceSilver, $complianceSilver,$date_today,0);
                    }if($complianceGold != ""){
                        $addResultGold = $indicator_model->insertFirstIndicator($profile, $indicator, $complianceGold, $findings,$ref_id);
                        $updatesResultGold = $updates_model->insertUpdates($indicator,$profile,$ref_id , $complianceGold, $complianceGold,$date_today,0);
                    }

                } else {
                    continue;
                }
            endforeach;
            foreach($indicator_model->getSecondCategoriesLowerFromSI($lguTypes->lgu_type_id) as $secondCatLower):
                if($secondCatLower->indicator_checklist_id != '0') {
                    $complianceBronze = $this->input->post('compliance' . $secondCatLower->indicator_id . 'Bronze');
                    $complianceSilver = $this->input->post('compliance' . $secondCatLower->indicator_id . 'Silver');
                    $complianceGold = $this->input->post('compliance' . $secondCatLower->indicator_id . 'Gold');
                    $profile = $this->input->post('profID');
                    $indicator = $secondCatLower->indicator_id;
                    $findings = $this->input->post('textArea'. $secondCatLower->indicator_id);
                    if($complianceBronze != ""){
                        $addResultBronze = $indicator_model->insertFirstIndicator($profile, $indicator, $complianceBronze, $findings,$ref_id);
                        $updatesResultBronze = $updates_model->insertUpdates($indicator,$profile,$ref_id , $complianceBronze, $complianceBronze,$date_today,0);
                    }
                    if($complianceSilver != ""){
                        $addResultSilver = $indicator_model->insertFirstIndicator($profile, $indicator, $complianceSilver, $findings,$ref_id);
                        $updatesResultSilver = $updates_model->insertUpdates($indicator,$profile,$ref_id , $complianceSilver, $complianceSilver,$date_today,0);
                    }if($complianceGold != ""){
                        $addResultGold = $indicator_model->insertFirstIndicator($profile, $indicator, $complianceGold, $findings,$ref_id);
                        $updatesResultGold = $updates_model->insertUpdates($indicator,$profile,$ref_id , $complianceGold, $complianceGold,$date_today,0);
                    }
                } else {
                    continue;
                }
            endforeach;
            foreach($indicator_model->getSecondCategoriesLowerLowerFromSI($lguTypes->lgu_type_id) as $secondCatLowerLower):
                if($secondCatLowerLower->indicator_checklist_id != '0') {
                    $complianceBronze = $this->input->post('compliance' . $secondCatLowerLower->indicator_id . 'Bronze');
                    $complianceSilver = $this->input->post('compliance' . $secondCatLowerLower->indicator_id . 'Silver');
                    $complianceGold = $this->input->post('compliance' . $secondCatLowerLower->indicator_id . 'Gold');
                    $profile = $this->input->post('profID');
                    $indicator = $secondCatLowerLower->indicator_id;
                    $findings = $this->input->post('textArea'. $secondCatLowerLower->indicator_id);
                    if($complianceBronze != ""){
                        $addResultBronze = $indicator_model->insertFirstIndicator($profile, $indicator, $complianceBronze, $findings,$ref_id);
                        $updatesResultBronze = $updates_model->insertUpdates($indicator,$profile,$ref_id , $complianceBronze, $complianceBronze,$date_today,0);
                    }
                    if($complianceSilver != ""){
                        $addResultSilver = $indicator_model->insertFirstIndicator($profile, $indicator, $complianceSilver, $findings,$ref_id);
                        $updatesResultSilver = $updates_model->insertUpdates($indicator,$profile,$ref_id , $complianceSilver, $complianceSilver,$date_today,0);
                    }if($complianceGold != ""){
                        $addResultGold = $indicator_model->insertFirstIndicator($profile, $indicator, $complianceGold, $findings,$ref_id);
                        $updatesResultGold = $updates_model->insertUpdates($indicator,$profile,$ref_id , $complianceGold, $complianceGold,$date_today,0);
                    }
                } else {
                    continue;
                }
            endforeach;
            if($addResultBronze || $addResultSilver || $addResultGold){
                $form_message = 'Add Success!';
                $this->load->view('header');
                $this->load->view('nav');
                $this->load->view('sidebar');
                $this->load->view('indicator_viewpart2', array(
                    'secondMotherIndicator' => $indicator_model->getSecondMotherIndicator(),
                    'secondIndicators' => $indicator_model->getSecondIndicators(),
                    'getFirstCategory' => $indicator_model->getCategoriesFromSI($lguTypes->lgu_type_id),
                    'getSecondCategory' => $indicator_model->getSecondCategoriesFromSI($lguTypes->lgu_type_id),
                    'getSecondCategoryLower' => $indicator_model->getSecondCategoriesLowerFromSI($lguTypes->lgu_type_id),
                    'getSecondCategoryLowerLower' => $indicator_model->getSecondCategoriesLowerLowerFromSI($lguTypes->lgu_type_id),
                    'profileID' => $profID,));
                     $this->load->view('footer');
                $this->redirectIndexAdd($profID,$ref_id);
            }


        }
    }
    public function indicatorAddpart3($profID,$ref_id)
    {
        if (!$this->session->userdata('user_id'))
        {
            redirect('/users/login','location');
        }

        $date_today = date('Y-m-d');
        $indicator_model = new indicator_model();
        $updates_model = new updates_model();
        $this->validateAddIndicatorpart3();
        $lguTypes = $indicator_model->getLGUtype($profID);
        if (!$this->form_validation->run()){
            $form_message = '';
            $this->load->view('header');
            $this->load->view('nav');
            $this->load->view('sidebar');
            $this->load->view('indicator_addpart3', array(
                'thirdMotherIndicator' => $indicator_model->getThirdMotherIndicator(),
                'thirdIndicators' => $indicator_model->getThirdIndicators(),
                'getFirstCategory' => $indicator_model->getCategoriesFromTI($lguTypes->lgu_type_id),
                'getSecondCategory' => $indicator_model->getSecondCategoriesFromTI($lguTypes->lgu_type_id),
                'getLSWDO' => $indicator_model->getLSWDOdata($profID,$ref_id),
                'profileID' => $profID,
                'refID' => $ref_id,
            ));
            $this->load->view('footer');

        } else {
            foreach($indicator_model->getCategoriesFromTI($lguTypes->lgu_type_id) as $firstCatBronze):
                if($firstCatBronze->indicator_checklist_id != '0') {
                    $complianceBronze = $this->input->post('compliance' . $firstCatBronze->indicator_id . 'Bronze');
                    $complianceSilver = $this->input->post('compliance' . $firstCatBronze->indicator_id . 'Silver');
                    $complianceGold = $this->input->post('compliance' . $firstCatBronze->indicator_id . 'Gold');
                    $profile = $this->input->post('profID');
                    $indicator = $firstCatBronze->indicator_id;
                    $findings = $this->input->post('textArea'. $firstCatBronze->indicator_id);
                    if($complianceBronze != ""){
                        $addResultBronze = $indicator_model->insertFirstIndicator($profile, $indicator, $complianceBronze, $findings,$ref_id);
                        $updatesResultBronze = $updates_model->insertUpdates($indicator,$profile,$ref_id , $complianceBronze, $complianceBronze,$date_today,0);
                    }
                    if($complianceSilver != ""){
                        $addResultSilver = $indicator_model->insertFirstIndicator($profile, $indicator, $complianceSilver, $findings,$ref_id);
                        $updatesResultSilver = $updates_model->insertUpdates($indicator,$profile,$ref_id , $complianceSilver, $complianceSilver,$date_today,0);
                    }if($complianceGold != ""){
                        $addResultGold = $indicator_model->insertFirstIndicator($profile, $indicator, $complianceGold, $findings,$ref_id);
                        $updatesResultGold = $updates_model->insertUpdates($indicator,$profile,$ref_id , $complianceGold, $complianceGold,$date_today,0);
                    }


                } else {
                    continue;
                }
            endforeach;
            foreach($indicator_model->getSecondCategoriesFromTI($lguTypes->lgu_type_id) as $secondCat):
                if($secondCat->indicator_checklist_id != '0') {
                    $complianceBronze = $this->input->post('compliance' . $secondCat->indicator_id . 'Bronze');
                    $complianceSilver = $this->input->post('compliance' . $secondCat->indicator_id . 'Silver');
                    $complianceGold = $this->input->post('compliance' . $secondCat->indicator_id . 'Gold');
                    $profile = $this->input->post('profID');
                    $indicator = $secondCat->indicator_id;
                    $findings = $this->input->post('textArea'. $secondCat->indicator_id);
                    if($complianceBronze != ""){
                        $addResultBronze = $indicator_model->insertFirstIndicator($profile, $indicator, $complianceBronze, $findings,$ref_id);
                        $updatesResultBronze = $updates_model->insertUpdates($indicator,$profile,$ref_id , $complianceBronze, $complianceBronze,$date_today,0);
                    }
                    if($complianceSilver != ""){
                        $addResultSilver = $indicator_model->insertFirstIndicator($profile, $indicator, $complianceSilver, $findings,$ref_id);
                        $updatesResultSilver = $updates_model->insertUpdates($indicator,$profile,$ref_id , $complianceSilver, $complianceSilver,$date_today,0);
                    }if($complianceGold != ""){
                        $addResultGold = $indicator_model->insertFirstIndicator($profile, $indicator, $complianceGold, $findings,$ref_id);
                        $updatesResultGold = $updates_model->insertUpdates($indicator,$profile,$ref_id , $complianceGold, $complianceGold,$date_today,0);
                    }
                } else {
                    continue;
                }
            endforeach;

            if($addResultBronze || $addResultSilver || $addResultGold){
                $form_message = 'Add Success!';
                $this->load->view('header');
                $this->load->view('nav');
                $this->load->view('sidebar');
                $this->load->view('indicator_viewpart3', array(
                    'thirdMotherIndicator' => $indicator_model->getThirdMotherIndicator(),
                    'thirdIndicators' => $indicator_model->getThirdIndicators(),
                    'getFirstCategory' => $indicator_model->getCategoriesFromTI($lguTypes->lgu_type_id),
                    'getSecondCategory' => $indicator_model->getSecondCategoriesFromTI($lguTypes->lgu_type_id),
                ));
                $this->load->view('footer');
                $this->redirectIndexAddPart2($profID,$ref_id);

            }


        }
    }
    public function indicatorAddpart4($profID,$ref_id)
    {
        if (!$this->session->userdata('user_id'))
        {
            redirect('/users/login','location');
        }

        $date_today = date('Y-m-d');
        $indicator_model = new indicator_model();
        $updates_model = new updates_model();
        $this->validateAddIndicatorpart4();
        $lguTypes = $indicator_model->getLGUtype($profID);
        if (!$this->form_validation->run()){
            $form_message = '';
            $this->load->view('header');
            $this->load->view('nav');
            $this->load->view('sidebar');
            $this->load->view('indicator_addpart4', array(
                'fourthMotherIndicator' => $indicator_model->getFourthMotherIndicator(),
                'fourthIndicators' => $indicator_model->getFourthIndicators(),
                'fourthCategory' => $indicator_model->getCategoriesFromFourthI(),
                'LGUType' => $indicator_model->getLGUtype($profID),
                'profileID' => $profID,
                'refID' => $ref_id,
            ));
            $this->load->view('footer');
        } else {
            foreach($indicator_model->getFourthIndicators() as $firstCatBronze):
                if($firstCatBronze->indicator_checklist_id != '0') {
                    $complianceBronze = $this->input->post('compliance' . $firstCatBronze->indicator_id . 'Bronze');
                    $complianceSilver = $this->input->post('compliance' . $firstCatBronze->indicator_id . 'Silver');
                    $complianceGold = $this->input->post('compliance' . $firstCatBronze->indicator_id . 'Gold');
//                    $profile = $this->input->post('profID');
                    $indicator = $firstCatBronze->indicator_id;
                    $findings =  $this->input->post('textArea'. $firstCatBronze->indicator_id);

                    if($complianceBronze != ""){
                        $addResultBronze = $indicator_model->insertFirstIndicator($profID, $indicator, $complianceBronze, $findings,$ref_id);
                        $updatesResultBronze = $updates_model->insertUpdates($indicator,$profID,$ref_id , $complianceBronze, $complianceBronze,$date_today,0);
                    }
                    if($complianceSilver != ""){
                        $addResultSilver = $indicator_model->insertFirstIndicator($profID, $indicator, $complianceSilver, $findings,$ref_id);
                        $updatesResultSilver = $updates_model->insertUpdates($indicator,$profID,$ref_id , $complianceSilver, $complianceSilver,$date_today,0);
                    } else {
                        continue;
                    }
                    if($complianceGold != ""){
                        $addResultGold = $indicator_model->insertFirstIndicator($profID, $indicator, $complianceGold, $findings,$ref_id);
                        $updatesResultGold = $updates_model->insertUpdates($indicator,$profID,$ref_id , $complianceGold, $complianceGold,$date_today,0);
                    } else {
                        continue;
                    }

                } else {
                    continue;
                }
            endforeach;
            foreach($indicator_model->getCategoriesFromFourthI() as $secondCat):
                if($secondCat->indicator_checklist_id != '0') {
                    $complianceBronze = $this->input->post('compliance' . $secondCat->indicator_id . 'Bronze');
                    $complianceSilver = $this->input->post('compliance' . $secondCat->indicator_id . 'Silver');
                    $complianceGold = $this->input->post('compliance' . $secondCat->indicator_id . 'Gold');
//                    $profile =$profile = $this->input->post('profID');
                    $indicator = $secondCat->indicator_id;
                    $findings = $this->input->post('textArea'. $secondCat->indicator_id);
                    if($complianceBronze != ""){
                        $addResultBronze = $indicator_model->insertFirstIndicator($profID, $indicator, $complianceBronze, $findings,$ref_id);
                        $updatesResultBronze = $updates_model->insertUpdates($indicator,$profID,$ref_id , $complianceBronze, $complianceBronze,$date_today,0);
                    }
                    if($complianceSilver != ""){
                        $addResultSilver = $indicator_model->insertFirstIndicator($profID, $indicator, $complianceSilver, $findings,$ref_id);
                        $updatesResultSilver = $updates_model->insertUpdates($indicator,$profID,$ref_id , $complianceSilver, $complianceSilver,$date_today,0);
                    }if($complianceGold != ""){
                        $addResultGold = $indicator_model->insertFirstIndicator($profID, $indicator, $complianceGold, $findings,$ref_id);
                        $updatesResultGold = $updates_model->insertUpdates($indicator,$profID,$ref_id , $complianceGold, $complianceGold,$date_today,0);
                    }
                } else {
                    continue;
                }
            endforeach;
            if($addResultBronze || $addResultSilver || $addResultGold){
                $form_message = 'Add Success!';
                $this->load->view('header');
                $this->load->view('nav');
                $this->load->view('sidebar');
                $this->load->view('indicator_view', array(
                    'fourthMotherIndicator' => $indicator_model->getFirstMotherIndicator(),
                    'fourthIndicators' => $indicator_model->getFirstIndicators(),
                    'fourthCategory' => $indicator_model->getCategoriesFromFourthI(),
                    'getFirstCategory' => $indicator_model->getCategoriesFromFI($lguTypes->lgu_type_id),
                    'getSecondCategory' => $indicator_model->getSecondCategoriesFromFI($lguTypes->lgu_type_id),
                ));
                $this->load->view('footer');


                $scoreProf = $indicator_model->getScorePerProf($profID, $ref_id);
                $getPerc = $scoreProf->FinalScore;
                $totalScore = $scoreProf->TotalScore;
                if($getPerc == 100){
                    $level = 'Fully Functional';
                } elseif($getPerc > 50 && $getPerc < 100){
                    $level = 'Functional';
                } elseif($getPerc < 51) {
                    $level = 'Partially Functional';
                }
                $addFunction = $indicator_model->insertFunctionality($profID, $ref_id,$level,$totalScore);
                $this->redirectIndexAddPart4($profID,$ref_id);
//                $this->redirectIndexViewAll($profID,$ref_id);

            }


        }
    }
    //Edit First Part :)))
    public function indicatorEdit($profID,$ref_id)
    {
        if (!$this->session->userdata('user_id'))
        {
            redirect('/users/login','location');
        }

        $indicator_model = new indicator_model();
        $this->validateAddIndicator();
        $lguTypes = $indicator_model->getLGUtype($profID);
        if (!$this->form_validation->run()){
            $form_message = '';
            $this->load->view('header');
            $this->load->view('nav');
            $this->load->view('sidebar');
            $this->load->view('indicator_edit', array(
                'firstMotherIndicator' => $indicator_model->getFirstMotherIndicator(),
                'firstIndicators' => $indicator_model->getFirstIndicators(),
                'getFirstCategory' => $indicator_model->getCategoriesFromFI($lguTypes->lgu_type_id),
                'getSecondCategory' => $indicator_model->getSecondCategoriesFromFI($lguTypes->lgu_type_id),
                'getLSWDO' => $indicator_model->getLSWDOdata($profID,$ref_id),
                'profileID' => $profID,
                'refID' => $ref_id,
            ));
            $this->load->view('footer');
        } else {
            foreach($indicator_model->getCategoriesFromFI($lguTypes->lgu_type_id) as $firstCatBronze):
                if($firstCatBronze->indicator_checklist_id != '0') {
                    $complianceBronze = $this->input->post('compliance' . $firstCatBronze->indicator_id . 'Bronze');
                    $complianceSilver = $this->input->post('compliance' . $firstCatBronze->indicator_id . 'Silver');
                    $complianceGold = $this->input->post('compliance' . $firstCatBronze->indicator_id . 'Gold');
                    $profile = $this->input->post('profID');
                    $indicator = $firstCatBronze->indicator_id;
                    $findings =  $this->input->post('textArea'. $firstCatBronze->indicator_id);
                    if($complianceBronze != ""){
                        $updateResultBronze = $indicator_model->updateIndicator($profile, $indicator, $complianceBronze, $findings,$ref_id);
                    }
                    if($complianceSilver != ""){
                        $updateResultSilver = $indicator_model->updateIndicator($profile, $indicator, $complianceSilver, $findings,$ref_id);
                    }if($complianceGold != ""){
                        $updateResultGold = $indicator_model->updateIndicator($profile, $indicator, $complianceGold, $findings,$ref_id);
                    }


                } else {
                    continue;
                }
            endforeach;
            foreach($indicator_model->getSecondCategoriesFromFI($lguTypes->lgu_type_id) as $secondCat):
                if($secondCat->indicator_checklist_id != '0') {
                    $complianceBronze = $this->input->post('compliance' . $secondCat->indicator_id . 'Bronze');
                    $complianceSilver = $this->input->post('compliance' . $secondCat->indicator_id . 'Silver');
                    $complianceGold = $this->input->post('compliance' . $secondCat->indicator_id . 'Gold');
                    $profile =$profile = $this->input->post('profID');
                    $indicator = $secondCat->indicator_id;
                    $findings = $this->input->post('textArea'. $secondCat->indicator_id);
                    if($complianceBronze != ""){
                        $updateResultBronze = $indicator_model->updateIndicator($profile, $indicator, $complianceBronze, $findings,$ref_id);
                    }
                    if($complianceSilver != ""){
                        $updateResultSilver = $indicator_model->updateIndicator($profile, $indicator, $complianceSilver, $findings,$ref_id);
                    } if($complianceGold != ""){
                        $updateResultGold = $indicator_model->updateIndicator($profile, $indicator, $complianceGold, $findings,$ref_id);
                    }
                } else {
                    continue;
                }
            endforeach;
            if($updateResultBronze || $updateResultSilver || $updateResultGold){
                $form_message = 'Add Success!';
                $this->load->view('header');
                $this->load->view('nav');
                $this->load->view('sidebar');
                $this->load->view('indicator_view', array(
                    'firstMotherIndicator' => $indicator_model->getFirstMotherIndicator(),
                    'firstIndicators' => $indicator_model->getFirstIndicators(),
                    'getFirstCategory' => $indicator_model->getCategoriesFromFI($lguTypes->lgu_type_id),
                    'getSecondCategory' => $indicator_model->getSecondCategoriesFromFI($lguTypes->lgu_type_id),
                ));
                $this->load->view('footer');
                $this->redirectIndex($profID,$ref_id);
            }


        }
    }
    public function indicatorEditpart2($profID,$ref_id)
    {
        if (!$this->session->userdata('user_id'))
        {
            redirect('/users/login','location');
        }

        $indicator_model = new indicator_model();
        $this->validateAddIndicatorpart2();
        $lguTypes = $indicator_model->getLGUtype($profID);
        if (!$this->form_validation->run()){
            $form_message = '';
            $this->load->view('header');
            $this->load->view('nav');
            $this->load->view('sidebar');
            $this->load->view('indicator_editpart2', array(
                'secondMotherIndicator' => $indicator_model->getSecondMotherIndicator(),
                'secondIndicators' => $indicator_model->getSecondIndicators(),
                'getFirstCategory' => $indicator_model->getCategoriesFromSI($lguTypes->lgu_type_id),
                'getSecondCategory' => $indicator_model->getSecondCategoriesFromSI($lguTypes->lgu_type_id),
                'getSecondCategoryLower' => $indicator_model->getSecondCategoriesLowerFromSI($lguTypes->lgu_type_id),
                'getSecondCategoryLowerLower' => $indicator_model->getSecondCategoriesLowerLowerFromSI($lguTypes->lgu_type_id),
                'getLSWDO' => $indicator_model->getLSWDOdata($profID,$ref_id),
                'profileID' => $profID,
                'refID' => $ref_id,

            ));
            $this->load->view('footer');
        } else {
            foreach($indicator_model->getCategoriesFromSI($lguTypes->lgu_type_id) as $firstCatBronze):
                if($firstCatBronze->indicator_checklist_id != '0') {
                    $complianceBronze = $this->input->post('compliance' . $firstCatBronze->indicator_id . 'Bronze');
                    $complianceSilver = $this->input->post('compliance' . $firstCatBronze->indicator_id . 'Silver');
                    $complianceGold = $this->input->post('compliance' . $firstCatBronze->indicator_id . 'Gold');
                    $profile = $this->input->post('profID');
                    $indicator = $firstCatBronze->indicator_id;
                    $findings =  $this->input->post('textArea'. $firstCatBronze->indicator_id);
                    if($complianceBronze != ""){
                        $updateResultBronze = $indicator_model->updateIndicator($profile, $indicator, $complianceBronze, $findings,$ref_id);
                    }
                    if($complianceSilver != ""){
                        $updateResultSilver = $indicator_model->updateIndicator($profile, $indicator, $complianceSilver, $findings,$ref_id);
                    }if($complianceGold != ""){
                        $updateResultGold = $indicator_model->updateIndicator($profile, $indicator, $complianceGold, $findings,$ref_id);
                    }


                } else {
                    continue;
                }
            endforeach;
            foreach($indicator_model->getSecondCategoriesFromSI($lguTypes->lgu_type_id) as $secondCat):
                if($secondCat->indicator_checklist_id != '0') {
                    $complianceBronze = $this->input->post('compliance' . $secondCat->indicator_id . 'Bronze');
                    $complianceSilver = $this->input->post('compliance' . $secondCat->indicator_id . 'Silver');
                    $complianceGold = $this->input->post('compliance' . $secondCat->indicator_id . 'Gold');
                    $profile =$profile = $this->input->post('profID');
                    $indicator = $secondCat->indicator_id;
                    $findings = $this->input->post('textArea'. $secondCat->indicator_id);
                    if($complianceBronze != ""){
                        $updateResultBronze = $indicator_model->updateIndicator($profile, $indicator, $complianceBronze, $findings,$ref_id);
                    }
                    if($complianceSilver != ""){
                        $updateResultSilver = $indicator_model->updateIndicator($profile, $indicator, $complianceSilver, $findings,$ref_id);
                    } if($complianceGold != ""){
                        $updateResultGold = $indicator_model->updateIndicator($profile, $indicator, $complianceGold, $findings,$ref_id);
                    }
                } else {
                    continue;
                }
            endforeach;
            foreach($indicator_model->getSecondCategoriesLowerFromSI($lguTypes->lgu_type_id) as $secondCatLower):
                if($secondCatLower->indicator_checklist_id != '0') {
                    $complianceBronze = $this->input->post('compliance' . $secondCatLower->indicator_id . 'Bronze');
                    $complianceSilver = $this->input->post('compliance' . $secondCatLower->indicator_id . 'Silver');
                    $complianceGold = $this->input->post('compliance' . $secondCatLower->indicator_id . 'Gold');
                    $profile = $this->input->post('profID');
                    $indicator = $secondCatLower->indicator_id;
                    $findings = $this->input->post('textArea'. $secondCatLower->indicator_id);
                    if($complianceBronze != ""){
                        $updateResultBronze = $indicator_model->updateIndicator($profile, $indicator, $complianceBronze, $findings,$ref_id);
                    }
                    if($complianceSilver != ""){
                        $updateResultSilver = $indicator_model->updateIndicator($profile, $indicator, $complianceSilver, $findings,$ref_id);
                    } if($complianceGold != ""){
                        $updateResultGold = $indicator_model->updateIndicator($profile, $indicator, $complianceGold, $findings,$ref_id);
                    }
                } else {
                    continue;
                }
            endforeach;
            foreach($indicator_model->getSecondCategoriesLowerLowerFromSI($lguTypes->lgu_type_id) as $secondCatLowerLower):
                if($secondCatLowerLower->indicator_checklist_id != '0') {
                    $complianceBronze = $this->input->post('compliance' . $secondCatLowerLower->indicator_id . 'Bronze');
                    $complianceSilver = $this->input->post('compliance' . $secondCatLowerLower->indicator_id . 'Silver');
                    $complianceGold = $this->input->post('compliance' . $secondCatLowerLower->indicator_id . 'Gold');
                    $profile = $this->input->post('profID');
                    $indicator = $secondCatLowerLower->indicator_id;
                    $findings = $this->input->post('textArea'. $secondCatLowerLower->indicator_id);
                    if($complianceBronze != ""){
                        $updateResultBronze = $indicator_model->updateIndicator($profile, $indicator, $complianceBronze, $findings,$ref_id);
                    }
                    if($complianceSilver != ""){
                        $updateResultSilver = $indicator_model->updateIndicator($profile, $indicator, $complianceSilver, $findings,$ref_id);
                    } if($complianceGold != ""){
                        $updateResultGold = $indicator_model->updateIndicator($profile, $indicator, $complianceGold, $findings,$ref_id);
                    }
                } else {
                    continue;
                }
            endforeach;
            if($updateResultBronze || $updateResultSilver || $updateResultGold){
                $form_message = 'Add Success!';
                $this->load->view('header');
                $this->load->view('nav');
                $this->load->view('sidebar');
                $this->load->view('indicator_viewpart2', array(
                    'secondMotherIndicator' => $indicator_model->getSecondMotherIndicator(),
                    'secondIndicators' => $indicator_model->getSecondIndicators(),
                    'getFirstCategory' => $indicator_model->getCategoriesFromSI($lguTypes->lgu_type_id),
                    'getSecondCategory' => $indicator_model->getSecondCategoriesFromSI($lguTypes->lgu_type_id),
                    'getSecondCategoryLower' => $indicator_model->getSecondCategoriesLowerFromSI($lguTypes->lgu_type_id),
                    'getSecondCategoryLowerLower' => $indicator_model->getSecondCategoriesLowerLowerFromSI($lguTypes->lgu_type_id),
                    'profileID' => $profID,));
                $this->load->view('footer');
                $this->redirectIndexAdd($profID,$ref_id);
            }


        }
    }
    public function indicatorEditpart3($profID,$ref_id)
    {
        if (!$this->session->userdata('user_id'))
        {
            redirect('/users/login','location');
        }

        $indicator_model = new indicator_model();
        $this->validateAddIndicatorpart3();
        $lguTypes = $indicator_model->getLGUtype($profID);
        if (!$this->form_validation->run()){
            $form_message = '';
            $this->load->view('header');
            $this->load->view('nav');
            $this->load->view('sidebar');
            $this->load->view('indicator_editpart3', array(
                'thirdMotherIndicator' => $indicator_model->getThirdMotherIndicator(),
                'thirdIndicators' => $indicator_model->getThirdIndicators(),
                'getFirstCategory' => $indicator_model->getCategoriesFromTI($lguTypes->lgu_type_id),
                'getSecondCategory' => $indicator_model->getSecondCategoriesFromTI($lguTypes->lgu_type_id),
                'getLSWDO' => $indicator_model->getLSWDOdata($profID,$ref_id),
                'profileID' => $profID,
                'refID' => $ref_id,
            ));
            $this->load->view('footer');
        } else {
            foreach($indicator_model->getCategoriesFromTI($lguTypes->lgu_type_id) as $firstCatBronze):
                if($firstCatBronze->indicator_checklist_id != '0') {
                    $complianceBronze = $this->input->post('compliance' . $firstCatBronze->indicator_id . 'Bronze');
                    $complianceSilver = $this->input->post('compliance' . $firstCatBronze->indicator_id . 'Silver');
                    $complianceGold = $this->input->post('compliance' . $firstCatBronze->indicator_id . 'Gold');
                    $profile = $this->input->post('profID');
                    $indicator = $firstCatBronze->indicator_id;
                    $findings =  $this->input->post('textArea'. $firstCatBronze->indicator_id);
                    if($complianceBronze != ""){
                        $updateResultBronze = $indicator_model->updateIndicator($profile, $indicator, $complianceBronze, $findings,$ref_id);
                    }
                    if($complianceSilver != ""){
                        $updateResultSilver = $indicator_model->updateIndicator($profile, $indicator, $complianceSilver, $findings,$ref_id);
                    }if($complianceGold != ""){
                        $updateResultGold = $indicator_model->updateIndicator($profile, $indicator, $complianceGold, $findings,$ref_id);
                    }


                } else {
                    continue;
                }
            endforeach;
            foreach($indicator_model->getSecondCategoriesFromTI($lguTypes->lgu_type_id) as $secondCat):
                if($secondCat->indicator_checklist_id != '0') {
                    $complianceBronze = $this->input->post('compliance' . $secondCat->indicator_id . 'Bronze');
                    $complianceSilver = $this->input->post('compliance' . $secondCat->indicator_id . 'Silver');
                    $complianceGold = $this->input->post('compliance' . $secondCat->indicator_id . 'Gold');
                   $profile = $this->input->post('profID');
                    $indicator = $secondCat->indicator_id;
                    $findings = $this->input->post('textArea'. $secondCat->indicator_id);
                    if($complianceBronze != ""){
                        $updateResultBronze = $indicator_model->updateIndicator($profile, $indicator, $complianceBronze, $findings,$ref_id);
                    }
                    if($complianceSilver != ""){
                        $updateResultSilver = $indicator_model->updateIndicator($profile, $indicator, $complianceSilver, $findings,$ref_id);
                    } if($complianceGold != ""){
                        $updateResultGold = $indicator_model->updateIndicator($profile, $indicator, $complianceGold, $findings,$ref_id);
                    }
                } else {
                    continue;
                }
            endforeach;
            if($updateResultBronze || $updateResultSilver || $updateResultGold){
                $form_message = 'Add Success!';
                $this->load->view('header');
                $this->load->view('nav');
                $this->load->view('sidebar');
                $this->load->view('indicator_view', array(
                    'thirdMotherIndicator' => $indicator_model->getThirdMotherIndicator(),
                    'thirdIndicators' => $indicator_model->getThirdIndicators(),
                    'getFirstCategory' => $indicator_model->getCategoriesFromTI($lguTypes->lgu_type_id),
                    'getSecondCategory' => $indicator_model->getSecondCategoriesFromTI($lguTypes->lgu_type_id),
                ));
                $this->load->view('footer');
                $this->redirectIndexAddPart2($profID,$ref_id);
            }


        }
    }
    public function indicatorEditpart4($profID,$ref_id)
    {
        if (!$this->session->userdata('user_id'))
        {
            redirect('/users/login','location');
        }

        $indicator_model = new indicator_model();
        $this->validateAddIndicatorpart3();
        $lguTypes = $indicator_model->getLGUtype($profID);
        if (!$this->form_validation->run()){
            $form_message = '';
            $this->load->view('header');
            $this->load->view('nav');
            $this->load->view('sidebar');
            $this->load->view('indicator_editpart4', array(
                'fourthMotherIndicator' => $indicator_model->getFourthMotherIndicator(),
                'fourthIndicators' => $indicator_model->getFourthIndicators(),
                'fourthCategory' => $indicator_model->getCategoriesFromFourthI(),
                'getLSWDO' => $indicator_model->getLSWDOdata($profID,$ref_id),
                'profileID' => $profID,
                'refID' => $ref_id,
            ));
            $this->load->view('footer');
        } else {
            foreach($indicator_model->getCategoriesFromTI($lguTypes->lgu_type_id) as $firstCatBronze):
                if($firstCatBronze->indicator_checklist_id != '0') {
                    $complianceBronze = $this->input->post('compliance' . $firstCatBronze->indicator_id . 'Bronze');
                    $complianceSilver = $this->input->post('compliance' . $firstCatBronze->indicator_id . 'Silver');
                    $complianceGold = $this->input->post('compliance' . $firstCatBronze->indicator_id . 'Gold');
                    $profile = $this->input->post('profID');
                    $indicator = $firstCatBronze->indicator_id;
                    $findings =  $this->input->post('textArea'. $firstCatBronze->indicator_id);
                    if($complianceBronze != ""){
                        $updateResultBronze = $indicator_model->updateIndicator($profile, $indicator, $complianceBronze, $findings,$ref_id);
                    }
                    if($complianceSilver != ""){
                        $updateResultSilver = $indicator_model->updateIndicator($profile, $indicator, $complianceSilver, $findings,$ref_id);
                    }if($complianceGold != ""){
                        $updateResultGold = $indicator_model->updateIndicator($profile, $indicator, $complianceGold, $findings,$ref_id);
                    }


                } else {
                    continue;
                }
            endforeach;
            foreach($indicator_model->getSecondCategoriesFromTI($lguTypes->lgu_type_id) as $secondCat):
                if($secondCat->indicator_checklist_id != '0') {
                    $complianceBronze = $this->input->post('compliance' . $secondCat->indicator_id . 'Bronze');
                    $complianceSilver = $this->input->post('compliance' . $secondCat->indicator_id . 'Silver');
                    $complianceGold = $this->input->post('compliance' . $secondCat->indicator_id . 'Gold');
                    $profile = $this->input->post('profID');
                    $indicator = $secondCat->indicator_id;
                    $findings = $this->input->post('textArea'. $secondCat->indicator_id);
                    if($complianceBronze != ""){
                        $updateResultBronze = $indicator_model->updateIndicator($profile, $indicator, $complianceBronze, $findings,$ref_id);
                    }
                    if($complianceSilver != ""){
                        $updateResultSilver = $indicator_model->updateIndicator($profile, $indicator, $complianceSilver, $findings,$ref_id);
                    } if($complianceGold != ""){
                        $updateResultGold = $indicator_model->updateIndicator($profile, $indicator, $complianceGold, $findings,$ref_id);
                    }
                } else {
                    continue;
                }
            endforeach;
            if($updateResultBronze || $updateResultSilver || $updateResultGold){
                $form_message = 'Add Success!';
                $this->load->view('header');
                $this->load->view('nav');
                $this->load->view('sidebar');
                $this->load->view('indicator_view', array(
                    'thirdMotherIndicator' => $indicator_model->getThirdMotherIndicator(),
                    'thirdIndicators' => $indicator_model->getThirdIndicators(),
                    'getFirstCategory' => $indicator_model->getCategoriesFromTI($lguTypes->lgu_type_id),
                    'getSecondCategory' => $indicator_model->getSecondCategoriesFromTI($lguTypes->lgu_type_id),
                ));
                $this->load->view('footer');
                $this->redirectIndexAddPart2($profID,$ref_id);
            }


        }
    }

    public function indicatorDelete($profID,$ref_id)
    {
        if (!$this->session->userdata('user_id'))
        {
            redirect('/users/login','location');
        }

        $indicator_model = new indicator_model();
            $updateResult = $indicator_model->deleteIndicator($profID,$ref_id);
            if($updateResult){
                $form_message = 'Add Success!';
                $this->load->view('header');
                $this->load->view('nav');
                $this->load->view('sidebar');
                $this->load->view('indicator_view');
                $this->load->view('footer');
                $this->redirectIndex($profID,$ref_id);
            }


        }
    public function indicatorDeletepart2($profID,$ref_id)
    {
        if (!$this->session->userdata('user_id'))
        {
            redirect('/users/login','location');
        }

        $indicator_model = new indicator_model();
        $lguTypes = $indicator_model->getLGUtype($profID);
        $updateResult = $indicator_model->deleteIndicatorpart2($profID,$ref_id);
        if($updateResult){
            $form_message = 'Add Success!';
            $this->load->view('header');
            $this->load->view('nav');
            $this->load->view('sidebar');
            $this->load->view('indicator_viewpart2');
            $this->load->view('footer');
            $this->redirectIndexAdd($profID,$ref_id);
        }


    }
    public function indicatorDeletepart3($profID,$ref_id)
    {
        if (!$this->session->userdata('user_id'))
        {
            redirect('/users/login','location');
        }

        $indicator_model = new indicator_model();
        $lguTypes = $indicator_model->getLGUtype($profID);
        $updateResult = $indicator_model->deleteIndicatorpart3($profID,$ref_id);
        if($updateResult){
            $form_message = 'Add Success!';
            $this->load->view('header');
            $this->load->view('nav');
            $this->load->view('sidebar');
            $this->load->view('indicator_viewpart3');
            $this->load->view('footer');
            $this->redirectIndexAddPart2($profID,$ref_id);
        }
    }

    protected function validateAddIndicator()
    {
        $config = array(

            array(
                'field'   => 'complianceIA1-1Bronze',
                'rules'   => 'required|integer'
            )
        );

        return $this->form_validation->set_rules($config);

    }
    protected function validateAddIndicatorpart2()
{
    $config = array(

        array(
            'field'   => 'complianceIIA1-1Bronze',
            'rules'   => 'required|integer'
        )
    );

    return $this->form_validation->set_rules($config);

}
    protected function validateAddIndicatorpart3()
    {
        $config = array(

            array(
                'field'   => 'complianceIIIA11-1Bronze',
                'rules'   => 'required|integer'
            )
        );

        return $this->form_validation->set_rules($config);

    }
    protected function validateAddIndicatorpart4()
    {
        $config = array(

            array(
                'field'   => 'complianceIV1-1Bronze',
                'rules'   => 'required|integer'
            )
        );

        return $this->form_validation->set_rules($config);

    }
    public function redirectIndex($profID,$ref_id)
    {
        $page = base_url('indicator/indicatorView/'.$profID.'/'.$ref_id);
//        $sec = "1";
        header("Location: $page");
    }

    public function redirectIndexAdd($profID,$ref_id)
    {
        $page = base_url('indicator/indicatorViewpart2/'.$profID.'/'.$ref_id);
//        $sec = "1";
        header("Location: $page");
    }
    public function redirectIndexAddPart2($profID,$ref_id)
    {
        $page = base_url('indicator/indicatorViewpart3/'.$profID.'/'.$ref_id);
//        $sec = "1";
        header("Location: $page");
    }
    public function redirectIndexAddPart4($profID,$ref_id)
    {
        $page = base_url('indicator/indicatorViewpart4/'.$profID.'/'.$ref_id);
//        $sec = "1";
        header("Location: $page");
    }
    public function redirectIndexViewAll($profID,$ref_id)
    {
        $page = base_url('indicator/indicatorViewAll/'.$profID.'/'.$ref_id);
//        $sec = "1";
        header("Location: $page");
    }

}