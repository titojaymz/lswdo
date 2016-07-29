<?php
/**
 * Created by PhpStorm.
 * User: ljesaclayan
 * Date: 7/29/2016
 * Time: 9:55 AM
 */


class lib_visitStatus extends CI_Controller
{
    public function statlist()
    {
        $status = new lib_visit_model();
        $this->load->view('header');
        $this->load->view('nav');
        $this->load->view('sidebar');
        $this->load->view('lib_statuslist',array(
            'statList'=>$status->getVisitStat(),
        ));
        $this->load->view('footer');
    }
    public function statadd()
    {
        $status = new lib_visit_model();
        $this->validateVisitStatAdd();
        if (!$this->form_validation->run()) {
            $this->load->view('header');
            $this->load->view('nav');
            $this->load->view('sidebar');
            $this->load->view('lib_statusadd', array(
                'statList' => $status->getVisitStat(),
            ));
            $this->load->view('footer');
        } else {
            $vStat = $this->input->post('visitStat');
            $addResult = $status->insertVisitStatus($vStat);
            if($addResult){
                $this->session->set_userdata('notification',1);
                $this->redirectIndex();
            }
        }
    }

    public function statedit($sid)
    {
        $status = new lib_visit_model();
        $this->validateVisitStatAdd();
        if (!$this->form_validation->run()) {
            $this->load->view('header');
            $this->load->view('nav');
            $this->load->view('sidebar');
            $this->load->view('lib_statusedit', array(
                'countList' => $status->getVisitStatbyID($sid),
            ));
            $this->load->view('footer');
        } else {
            $vStat = $this->input->post('visitStat');
            $addResult = $status->updateVisitStatus($vStat,$sid);
            if($addResult){
                $this->session->set_userdata('notification',2);
                $this->redirectIndex();
            }
        }
    }

    protected function validateVisitStatAdd()
    {
        $config = array(

            array(
                'field'   => 'visitStat',
                'label'   => 'visitStat',
                'rules'   => 'required'
            )
        );

        return $this->form_validation->set_rules($config);

    }
    public function redirectIndex()
    {
        $page = base_url('lib_visitStatus/statlist/');
//        $sec = "1";
        header("Location: $page");
    }
}
