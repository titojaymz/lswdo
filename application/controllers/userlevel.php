<?php
/**
 * Created by PhpStorm.
 * User: ljesaclayan
 * Date: 5/18/2016
 * Time: 9:49 AM
 */

class userlevel extends CI_Controller
{
    public function userlevel_list()
    {
        $userlevel_model = new userlevel_model();
        $this->load->view('header');
        $this->load->view('nav');
        $this->load->view('sidebar');
        $this->load->view('userlevel_list',array(
            'getUserLevel'=>$userlevel_model->getUserLevel(),
        ));
        $this->load->view('footer');
    }
    public function userlevelAdd()
    {
        if (!$this->session->userdata('user_id')) {
            redirect('/users/login', 'location');
        }
        $userlevel_model = new userlevel_model();
        $this->validateUserLevelIndicator();

        if (!$this->form_validation->run()) {
            $form_message = '';
            $this->load->view('header');
            $this->load->view('nav');
            $this->load->view('sidebar');
            $this->load->view('userlevel_add', array(
                'getUserLevel'=>$userlevel_model->getUserLevel(),
            ));
            $this->load->view('footer');
        } else {
//            $date_today = date('Y-m-d');
            $userlevel_id = $this->input->post('userlevel_id');
            $userlevel_name = $this->input->post('userlevel_name');
            $userlevel_desc = $this->input->post('userlevel_desc');
            $userID = $this->session->userdata('user_id');

                $updatesResultBronze = $userlevel_model->insertUserLevel($userlevel_id,$userlevel_name,$userlevel_desc,$userID);
            if($updatesResultBronze){
                $form_message = 'Add Success!';
                $this->load->view('header');
                $this->load->view('nav');
                $this->load->view('sidebar');
                $this->load->view('userlevel_add', array(
                    'getUserLevel'=>$userlevel_model->getUserLevel(),
                ));
                $this->load->view('footer');

//                $addFunction = $indicator_model->updateFunctionality($profID, $refID,$level,$totalScore);
                $this->redirectIndex();
            }
        }
    }

    public function userlevelEdit($userlevelid)
    {
        if (!$this->session->userdata('user_id')) {
            redirect('/users/login', 'location');
        }
        $userlevel_model = new userlevel_model();
        $this->validateUserLevelIndicator();

        if (!$this->form_validation->run()) {
            $form_message = '';
            $this->load->view('header');
            $this->load->view('nav');
            $this->load->view('sidebar');
            $this->load->view('userlevel_edit', array(
                'getUserLevelperID'=>$userlevel_model->getUserLevelperID($userlevelid),
            ));
            $this->load->view('footer');
        } else {
//            $date_today = date('Y-m-d');
            $userlevel_id = $this->input->post('userlevel_id');
            $userlevel_name = $this->input->post('userlevel_name');
            $userlevel_desc = $this->input->post('userlevel_desc');
            $userID = $this->session->userdata('user_id');

            $updatesResultBronze = $userlevel_model->updateUserLevel($userlevel_id,$userlevel_name,$userlevel_desc,$userID,$userlevelid);
            if($updatesResultBronze){
                $form_message = 'Add Success!';
                $this->load->view('header');
                $this->load->view('nav');
                $this->load->view('sidebar');
                $this->load->view('userlevel_add', array(
                    'getUserLevel'=>$userlevel_model->getUserLevel(),
                ));
                $this->load->view('footer');

//                $addFunction = $indicator_model->updateFunctionality($profID, $refID,$level,$totalScore);
                $this->redirectIndex();
            }
        }
    }
    public function userLevelDelete($userlevelid)
    {
        $userlevel_model = new userlevel_model();
        if ($userlevelid > 0){
            $deleteResult = $userlevel_model->deleteUserLevel($userlevelid);
            if ($deleteResult){
                $this->load->view('header');
                $this->load->view('nav');
                $this->load->view('sidebar');
                $this->load->view('userlevel_list', array(
                    'userslist' => $userlevel_model->getUserLevel()));
                $this->load->view('footer');
                $this->redirectIndex();
            }
        }
    }
    protected function validateUserLevelIndicator()
    {
        $config = array(

            array(
                'field'   => 'userlevel_name',
                'label'   => 'Sample',
                'rules'   => 'required'
            )
        );

        return $this->form_validation->set_rules($config);

    }
    public function redirectIndex()
    {
        $page = base_url('userlevel/userlevel_list/');
//        $sec = "1";
        header("Location: $page");
    }
}