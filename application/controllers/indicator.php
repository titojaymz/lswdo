<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class indicator extends CI_Controller
{
    public function indicatorView()
    {
        if (!$this->session->userdata('user_id'))
        {
            redirect('/users/login','location');
        }
        $indicator_model = new indicator_model();
        $this->load->view('header');
        $this->load->view('nav');
        $this->load->view('sidebar');
        $this->load->view('indicator_view', array(
            'firstMotherIndicator' => $indicator_model->getFirstMotherIndicator(),
            'firstIndicators' => $indicator_model->getFirstIndicators(),
            'getFirstCategory' => $indicator_model->getCategoriesFromFI(),
            'getSecondCategory' => $indicator_model->getSecondCategoriesFromFI(),
        ));
        $this->load->view('footer');
    }

    public function indicatorAdd()
    {
        if (!$this->session->userdata('user_id'))
        {
            redirect('/users/login','location');
        }

        $indicator_model = new indicator_model();
        $this->validateAddIndicator();

        if (!$this->form_validation->run()){
            $form_message = '';
            $this->load->view('header');
            $this->load->view('nav');
            $this->load->view('sidebar');
            $this->load->view('indicator_add', array(
                'firstMotherIndicator' => $indicator_model->getFirstMotherIndicator(),
                'firstIndicators' => $indicator_model->getFirstIndicators(),
                'getFirstCategory' => $indicator_model->getCategoriesFromFI(),
                'getSecondCategory' => $indicator_model->getSecondCategoriesFromFI(),
            ));
            $this->load->view('footer');
        } else {
                foreach($indicator_model->getCategoriesFromFI() as $firstCatBronze):
                    if($firstCatBronze->indicator_checklist_id != '0') {
                        $complianceBronze = $this->input->post('compliance' . $firstCatBronze->indicator_id . 'Bronze');
                        $complianceSilver = $this->input->post('compliance' . $firstCatBronze->indicator_id . 'Silver');
                        $complianceGold = $this->input->post('compliance' . $firstCatBronze->indicator_id . 'Gold');
                        $profile = '9';
                        $indicator = $firstCatBronze->indicator_id;
                        $findings =  'hahahaha';
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
                foreach($indicator_model->getSecondCategoriesFromFI() as $secondCat):
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
                $this->load->view('indicator_view', array(
                    'firstMotherIndicator' => $indicator_model->getFirstMotherIndicator(),
                    'firstIndicators' => $indicator_model->getFirstIndicators(),
                    'getFirstCategory' => $indicator_model->getCategoriesFromFI(),
                    'getSecondCategory' => $indicator_model->getSecondCategoriesFromFI(),
                ));
                $this->load->view('footer');
            }


        }
    }
    public function indicatorAddpart2()
    {
        if (!$this->session->userdata('user_id'))
        {
            redirect('/users/login','location');
        }

        $indicator_model = new indicator_model();
        $this->validateAddIndicator();

        if (!$this->form_validation->run()){
            $form_message = '';
            $this->load->view('header');
            $this->load->view('nav');
            $this->load->view('sidebar');
            $this->load->view('indicator_addpart2', array(
                'secondMotherIndicator' => $indicator_model->getSecondMotherIndicator(),
                'secondIndicators' => $indicator_model->getSecondIndicators(),
                'getFirstCategory' => $indicator_model->getCategoriesFromSI(),
                'getSecondCategory' => $indicator_model->getSecondCategoriesFromSI(),
                'getSecondCategoryLower' => $indicator_model->getSecondCategoriesLowerFromSI(),
                'getSecondCategoryLowerLower' => $indicator_model->getSecondCategoriesLowerLowerFromSI()
            ));
            $this->load->view('footer');
        } else {
            foreach($indicator_model->getCategoriesFromFI() as $firstCatBronze):
                $compliance = $this->input->post('select'.$firstCatBronze->indicator_id);
                $profile = '9';
                $indicator = $firstCatBronze->indicator_id;
                $findings = "hehe";
                $addResult = $indicator_model->insertFirstIndicator($profile,$indicator,$compliance,$findings);
            endforeach;
            if($addResult){
                $form_message = 'Add Success!';
                $this->load->view('header');
                $this->load->view('nav');
                $this->load->view('sidebar');
                $this->load->view('indicator_view', array(
                    'firstMotherIndicator' => $indicator_model->getFirstMotherIndicator(),
                    'firstIndicators' => $indicator_model->getFirstIndicators(),
                    'getFirstCategory' => $indicator_model->getCategoriesFromFI(),
                    'getSecondCategory' => $indicator_model->getSecondCategoriesFromFI(),
                ));
                $this->load->view('footer');
            }


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

}