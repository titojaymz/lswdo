<?php
/**
 * Created by PhpStorm.
 * User: ljesaclayan
 * Date: 7/28/2016
 * Time: 2:12 PM
 */
class lib_visitCount extends CI_Controller
{

    public function vclist()
    {
        $visitCount = new lib_visit_model();
        $this->load->view('header');
        $this->load->view('nav');
        $this->load->view('sidebar');
        $this->load->view('lib_visitlist',array(
            'countList'=>$visitCount->getVisitCount(),
        ));
        $this->load->view('footer');
    }
    public function vcadd()
    {
        $visitCount = new lib_visit_model();
        $this->validateVisitCountAdd();
        if (!$this->form_validation->run()) {
            $this->load->view('header');
            $this->load->view('nav');
            $this->load->view('sidebar');
            $this->load->view('lib_visitadd', array(
                'countList' => $visitCount->getVisitCount(),
            ));
            $this->load->view('footer');
        } else {
            $vCount = $this->input->post('visitCount');
            $addResult = $visitCount->insertVisitCount($vCount);
            if($addResult){
                $this->session->set_userdata('notification',1);
                $this->redirectIndex();
            }
        }
    }
    public function vcedit($vid)
    {
        $visitCount = new lib_visit_model();
        $this->validateVisitCountAdd();
        if (!$this->form_validation->run()) {
            $this->load->view('header');
            $this->load->view('nav');
            $this->load->view('sidebar');
            $this->load->view('lib_visitedit', array(
                'countList' => $visitCount->getVisitCountbyID($vid),
            ));
            $this->load->view('footer');
        } else {
            $vCount = $this->input->post('visitCount');
            $addResult = $visitCount->updateVisitCount($vCount,$vid);
            if($addResult){
                $this->session->set_userdata('notification',2);
                $this->redirectIndex();
            }
        }
    }
    protected function validateVisitCountAdd()
    {
        $config = array(

            array(
                'field'   => 'visitCount',
                'label'   => 'visitCount',
                'rules'   => 'required'
            )
        );

        return $this->form_validation->set_rules($config);

    }
    public function redirectIndex()
    {
        $page = base_url('lib_visitCount/vclist/');
//        $sec = "1";
        header("Location: $page");
    }

}