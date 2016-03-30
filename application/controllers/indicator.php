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
            'getLSWDO' => $indicator_model->getLSWDOdata($profID),
            'checkPart1' => $indicator_model->getCheckPart1($profID),
            'profileID' => $profID,
        ));
        $this->load->view('footer');
    }
    public function indicatorViewpart2($profID)
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
            'getLSWDO' => $indicator_model->getLSWDOdata($profID),
            'checkPart2' => $indicator_model->getCheckPart2($profID),
            'profileID' => $profID,
        ));
        $this->load->view('footer');
    }
    public function indicatorViewpart3($profID)
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
            'getLSWDO' => $indicator_model->getLSWDOdata($profID),
            'checkPart3' => $indicator_model->getCheckPart3($profID),
            'profileID' => $profID,
        ));
        $this->load->view('footer');
    }

    public function indicatorViewAll($profID)
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
            'getLSWDO' => $indicator_model->getLSWDOdata($profID),
            'checkPart1' => $indicator_model->getCheckPart1($profID),
            'checkPart2' => $indicator_model->getCheckPart2($profID),
            'checkPart3' => $indicator_model->getCheckPart3($profID),
            'profileID' => $profID,
        ));
        $this->load->view('footer');
    }

    public function indicatorAdd($profID)
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
            $this->load->view('indicator_add', array(
                'firstMotherIndicator' => $indicator_model->getFirstMotherIndicator(),
                'firstIndicators' => $indicator_model->getFirstIndicators(),
                'getFirstCategory' => $indicator_model->getCategoriesFromFI($lguTypes->lgu_type_id),
                'getSecondCategory' => $indicator_model->getSecondCategoriesFromFI($lguTypes->lgu_type_id),
                'LGUType' => $indicator_model->getLGUtype($profID),
                'profileID' => $profID,
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
                            $addResultBronze = $indicator_model->insertFirstIndicator($profile, $indicator, $complianceBronze, $findings);
                        }
                        if($complianceSilver != ""){
                            $addResultSilver = $indicator_model->insertFirstIndicator($profile, $indicator, $complianceSilver, $findings);
                        }if($complianceGold != ""){
                            $addResultGold = $indicator_model->insertFirstIndicator($profile, $indicator, $complianceGold, $findings);
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
                        $addResultBronze = $indicator_model->insertFirstIndicator($profile, $indicator, $complianceBronze, $findings);
                    }
                    if($complianceSilver != ""){
                        $addResultSilver = $indicator_model->insertFirstIndicator($profile, $indicator, $complianceSilver, $findings);
                    } if($complianceGold != ""){
                    $addResultGold = $indicator_model->insertFirstIndicator($profile, $indicator, $complianceGold, $findings);
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
                $this->redirectIndex($profID);
            }


        }
    }
    public function indicatorAddpart2($profID)
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
            $this->load->view('indicator_addpart2', array(
                'secondMotherIndicator' => $indicator_model->getSecondMotherIndicator(),
                'secondIndicators' => $indicator_model->getSecondIndicators(),
                'getFirstCategory' => $indicator_model->getCategoriesFromSI($lguTypes->lgu_type_id),
                'getSecondCategory' => $indicator_model->getSecondCategoriesFromSI($lguTypes->lgu_type_id),
                'getSecondCategoryLower' => $indicator_model->getSecondCategoriesLowerFromSI($lguTypes->lgu_type_id),
                'getSecondCategoryLowerLower' => $indicator_model->getSecondCategoriesLowerLowerFromSI($lguTypes->lgu_type_id),
                'profileID' => $profID,

            ));
            $this->load->view('footer');
        } else {
            foreach($indicator_model->getCategoriesFromSI($lguTypes->lgu_type_id) as $firstCatBronze):
                if($firstCatBronze->indicator_checklist_id != '0') {
                    $complianceBronze = $this->input->post('compliance' . $firstCatBronze->indicator_id . 'Bronze');
                    $complianceSilver = $this->input->post('compliance' . $firstCatBronze->indicator_id . 'Silver');
                    $complianceGold = $this->input->post('compliance' . $firstCatBronze->indicator_id . 'Gold');
                    $profile = '9';
                    $indicator = $firstCatBronze->indicator_id;
                    $findings =  $this->input->post('textArea'. $firstCatBronze->indicator_id);
                    if($complianceBronze != ""){
                        $addResultBronze = $indicator_model->insertFirstIndicator($profile, $indicator, $complianceBronze, $findings);
                    }
                    if($complianceSilver != ""){
                        $addResultSilver = $indicator_model->insertFirstIndicator($profile, $indicator, $complianceSilver, $findings);
                    }if($complianceGold != ""){
                        $addResultGold = $indicator_model->insertFirstIndicator($profile, $indicator, $complianceGold, $findings);
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
                    $profile = '9';
                    $indicator = $secondCat->indicator_id;
                    $findings = $this->input->post('textArea'. $secondCat->indicator_id);
                    if($complianceBronze != ""){
                        $addResultBronze = $indicator_model->insertFirstIndicator($profile, $indicator, $complianceBronze, $findings);
                    }
                    if($complianceSilver != ""){
                        $addResultSilver = $indicator_model->insertFirstIndicator($profile, $indicator, $complianceSilver, $findings);
                    } if($complianceGold != ""){
                        $addResultGold = $indicator_model->insertFirstIndicator($profile, $indicator, $complianceGold, $findings);
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
                    $profile = '9';
                    $indicator = $secondCatLower->indicator_id;
                    $findings = $this->input->post('textArea'. $secondCatLower->indicator_id);
                    if($complianceBronze != ""){
                        $addResultBronze = $indicator_model->insertFirstIndicator($profile, $indicator, $complianceBronze, $findings);
                    }
                    if($complianceSilver != ""){
                        $addResultSilver = $indicator_model->insertFirstIndicator($profile, $indicator, $complianceSilver, $findings);
                    } if($complianceGold != ""){
                        $addResultGold = $indicator_model->insertFirstIndicator($profile, $indicator, $complianceGold, $findings);
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
                    $profile = '9';
                    $indicator = $secondCatLowerLower->indicator_id;
                    $findings = $this->input->post('textArea'. $secondCatLowerLower->indicator_id);
                    if($complianceBronze != ""){
                        $addResultBronze = $indicator_model->insertFirstIndicator($profile, $indicator, $complianceBronze, $findings);
                    }
                    if($complianceSilver != ""){
                        $addResultSilver = $indicator_model->insertFirstIndicator($profile, $indicator, $complianceSilver, $findings);
                    } if($complianceGold != ""){
                        $addResultGold = $indicator_model->insertFirstIndicator($profile, $indicator, $complianceGold, $findings);
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
                $this->redirectIndexAdd($profID);
            }


        }
    }
    public function indicatorAddpart3($profID)
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
            $this->load->view('indicator_addpart3', array(
                'thirdMotherIndicator' => $indicator_model->getThirdMotherIndicator(),
                'thirdIndicators' => $indicator_model->getThirdIndicators(),
                'getFirstCategory' => $indicator_model->getCategoriesFromTI($lguTypes->lgu_type_id),
                'getSecondCategory' => $indicator_model->getSecondCategoriesFromTI($lguTypes->lgu_type_id),
                'getLSWDO' => $indicator_model->getLSWDOdata($profID),
                'profileID' => $profID,
            ));
            $this->load->view('footer');

        } else {
            foreach($indicator_model->getCategoriesFromTI($lguTypes->lgu_type_id) as $firstCatBronze):
                if($firstCatBronze->indicator_checklist_id != '0') {
                    $complianceBronze = $this->input->post('compliance' . $firstCatBronze->indicator_id . 'Bronze');
                    $complianceSilver = $this->input->post('compliance' . $firstCatBronze->indicator_id . 'Silver');
                    $complianceGold = $this->input->post('compliance' . $firstCatBronze->indicator_id . 'Gold');
                    $profile = '9';
                    $indicator = $firstCatBronze->indicator_id;
                    $findings = $this->input->post('textArea'. $firstCatBronze->indicator_id);
                    if($complianceBronze != ""){
                        $addResultBronze = $indicator_model->insertFirstIndicator($profile, $indicator, $complianceBronze, $findings);
                    }
                    if($complianceSilver != ""){
                        $addResultSilver = $indicator_model->insertFirstIndicator($profile, $indicator, $complianceSilver, $findings);
                    }if($complianceGold != ""){
                        $addResultGold = $indicator_model->insertFirstIndicator($profile, $indicator, $complianceGold, $findings);
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
                    $profile = '9';
                    $indicator = $secondCat->indicator_id;
                    $findings = $this->input->post('textArea'. $secondCat->indicator_id);
                    if($complianceBronze != ""){
                        $addResultBronze = $indicator_model->insertFirstIndicator($profile, $indicator, $complianceBronze, $findings);
                    }
                    if($complianceSilver != ""){
                        $addResultSilver = $indicator_model->insertFirstIndicator($profile, $indicator, $complianceSilver, $findings);
                    } if($complianceGold != ""){
                        $addResultGold = $indicator_model->insertFirstIndicator($profile, $indicator, $complianceGold, $findings);
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
                $this->redirectIndexAddPart2($profID);
            }


        }
    }
    //Edit First Part :)))
    public function indicatorEdit($profID)
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
                'getLSWDO' => $indicator_model->getLSWDOdata($profID),
                'profileID' => $profID,
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
                        $updateResultBronze = $indicator_model->updateIndicator($profile, $indicator, $complianceBronze, $findings);
                    }
                    if($complianceSilver != ""){
                        $updateResultSilver = $indicator_model->updateIndicator($profile, $indicator, $complianceSilver, $findings);
                    }if($complianceGold != ""){
                        $updateResultGold = $indicator_model->updateIndicator($profile, $indicator, $complianceGold, $findings);
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
                        $updateResultBronze = $indicator_model->updateIndicator($profile, $indicator, $complianceBronze, $findings);
                    }
                    if($complianceSilver != ""){
                        $updateResultSilver = $indicator_model->updateIndicator($profile, $indicator, $complianceSilver, $findings);
                    } if($complianceGold != ""){
                        $updateResultGold = $indicator_model->updateIndicator($profile, $indicator, $complianceGold, $findings);
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
                $this->redirectIndex($profID);
            }


        }
    }

    public function indicatorEditpart2($profID)
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
                'getLSWDO' => $indicator_model->getLSWDOdata($profID),
                'profileID' => $profID,

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
                        $updateResultBronze = $indicator_model->updateIndicator($profile, $indicator, $complianceBronze, $findings);
                    }
                    if($complianceSilver != ""){
                        $updateResultSilver = $indicator_model->updateIndicator($profile, $indicator, $complianceSilver, $findings);
                    }if($complianceGold != ""){
                        $updateResultGold = $indicator_model->updateIndicator($profile, $indicator, $complianceGold, $findings);
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
                        $updateResultBronze = $indicator_model->updateIndicator($profile, $indicator, $complianceBronze, $findings);
                    }
                    if($complianceSilver != ""){
                        $updateResultSilver = $indicator_model->updateIndicator($profile, $indicator, $complianceSilver, $findings);
                    } if($complianceGold != ""){
                        $updateResultGold = $indicator_model->updateIndicator($profile, $indicator, $complianceGold, $findings);
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
                        $updateResultBronze = $indicator_model->updateIndicator($profile, $indicator, $complianceBronze, $findings);
                    }
                    if($complianceSilver != ""){
                        $updateResultSilver = $indicator_model->updateIndicator($profile, $indicator, $complianceSilver, $findings);
                    } if($complianceGold != ""){
                        $updateResultGold = $indicator_model->updateIndicator($profile, $indicator, $complianceGold, $findings);
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
                        $updateResultBronze = $indicator_model->updateIndicator($profile, $indicator, $complianceBronze, $findings);
                    }
                    if($complianceSilver != ""){
                        $updateResultSilver = $indicator_model->updateIndicator($profile, $indicator, $complianceSilver, $findings);
                    } if($complianceGold != ""){
                        $updateResultGold = $indicator_model->updateIndicator($profile, $indicator, $complianceGold, $findings);
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
                $this->redirectIndexAdd($profID);
            }


        }
    }
    public function indicatorEditpart3($profID)
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
                'getLSWDO' => $indicator_model->getLSWDOdata($profID),
                'profileID' => $profID,
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
                        $updateResultBronze = $indicator_model->updateIndicator($profile, $indicator, $complianceBronze, $findings);
                    }
                    if($complianceSilver != ""){
                        $updateResultSilver = $indicator_model->updateIndicator($profile, $indicator, $complianceSilver, $findings);
                    }if($complianceGold != ""){
                        $updateResultGold = $indicator_model->updateIndicator($profile, $indicator, $complianceGold, $findings);
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
                        $updateResultBronze = $indicator_model->updateIndicator($profile, $indicator, $complianceBronze, $findings);
                    }
                    if($complianceSilver != ""){
                        $updateResultSilver = $indicator_model->updateIndicator($profile, $indicator, $complianceSilver, $findings);
                    } if($complianceGold != ""){
                        $updateResultGold = $indicator_model->updateIndicator($profile, $indicator, $complianceGold, $findings);
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
                $this->redirectIndexAddPart2($profID);
            }


        }
    }

    public function indicatorDelete($profID)
    {
        if (!$this->session->userdata('user_id'))
        {
            redirect('/users/login','location');
        }

        $indicator_model = new indicator_model();
            $updateResult = $indicator_model->deleteIndicator($profID);
            if($updateResult){
                $form_message = 'Add Success!';
                $this->load->view('header');
                $this->load->view('nav');
                $this->load->view('sidebar');
                $this->load->view('indicator_view');
                $this->load->view('footer');
                $this->redirectIndex($profID);
            }


        }
    public function indicatorDeletepart2($profID)
    {
        if (!$this->session->userdata('user_id'))
        {
            redirect('/users/login','location');
        }

        $indicator_model = new indicator_model();
        $lguTypes = $indicator_model->getLGUtype($profID);
        $updateResult = $indicator_model->deleteIndicatorpart2($profID);
        if($updateResult){
            $form_message = 'Add Success!';
            $this->load->view('header');
            $this->load->view('nav');
            $this->load->view('sidebar');
            $this->load->view('indicator_viewpart2');
            $this->load->view('footer');
            $this->redirectIndexAdd($profID);
        }


    }
    public function indicatorDeletepart3($profID)
    {
        if (!$this->session->userdata('user_id'))
        {
            redirect('/users/login','location');
        }

        $indicator_model = new indicator_model();
        $lguTypes = $indicator_model->getLGUtype($profID);
        $updateResult = $indicator_model->deleteIndicatorpart3($profID);
        if($updateResult){
            $form_message = 'Add Success!';
            $this->load->view('header');
            $this->load->view('nav');
            $this->load->view('sidebar');
            $this->load->view('indicator_viewpart3');
            $this->load->view('footer');
            $this->redirectIndexAddPart2($profID);
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
    public function redirectIndex($profID)
    {
        $page = base_url('indicator/indicatorView/'.$profID);
//        $sec = "1";
        header("Location: $page");
    }

    public function redirectIndexAdd($profID)
    {
        $page = base_url('indicator/indicatorViewpart2/'.$profID);
//        $sec = "1";
        header("Location: $page");
    }
    public function redirectIndexAddPart2($profID)
    {
        $page = base_url('indicator/indicatorViewpart3/'.$profID);
//        $sec = "1";
        header("Location: $page");
    }
    public function redirectIndexViewAll($profID)
    {
        $page = base_url('indicator/indicatorViewAll/'.$profID);
//        $sec = "1";
        header("Location: $page");
    }

}