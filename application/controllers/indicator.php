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
                'field'   => 'selectIA1B',
                'rules'   => 'required|integer'
            )
        );

        return $this->form_validation->set_rules($config);
    }

}