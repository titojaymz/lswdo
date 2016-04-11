<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Created by JOSEF FRIEDRICH S. BALDO
 * Date Time: 10/17/15 10:57 PM
 */
class access_control extends CI_Controller {

    public function users(){
        $user_control = new accesscontrol_model();
        $form_message = '';
        $this->load->view('header');
        $this->load->view('nav');
        $this->load->view('sidebar');
        $this->load->view('users_list', array(
            'userslist' => $user_control->get_users_list()));
        $this->load->view('footer');

    }
    public function superKey()
    {
        return $this->config->item('encryption_key');

        $this->load->library('encrypt');
    }
    public function addUser()
    {
        $accesscontrol_model = new accesscontrol_model();
        $this->validateAddForm();
        $userkey = $this->superKey();

        if ($this->form_validation->run() == FALSE)
        {
            //fail validation
            $this->load->view('header');
            $rpmb['regionlist'] = $accesscontrol_model->get_regions();
            $this->load->view('nav');
            $this->load->view('sidebar');
            $this->load->view('user_add',$rpmb);

            $this->load->view('footer');
        }
        else
        {
            //pass validation
            $firstname = $this->input->post('firstname');
            $middlename = $this->input->post('middlename');
            $surname = $this->input->post('surname');
            $extname = $this->input->post('extensionname');
            $position = $this->input->post('position');
            $designation = $this->input->post('designation');
            $contact = $this->input->post('contactno');
            $username = $this->input->post('username');
            $password = $this->input->post('password');
            $email = $this->input->post('e_add');
            $userlevel = $this->input->post('userlevelid');
            $region = $this->input->post('regionlist');
            $activate = $this->input->post('status');

            $superkey = $this->encrypt->sha1($userkey.$password);


            $addResult = $accesscontrol_model->insertUserinfo($firstname,$middlename,$surname,$extname, $position,$designation,$contact,$username,$superkey,$email,$userlevel,$region,$activate);
            if ($addResult){
                $this->load->view('header');
                $this->load->view('nav');
                $this->load->view('sidebar');
                $this->load->view('users_list', array(
                    'userslist' => $accesscontrol_model->get_users_list()));
                $this->load->view('footer');
            }
        }

    }

    public function lockscreen()
    {
        $this->load->view('header');
        $this->load->view('lockscreen');
        $this->load->view('footer');

    }

    public function editUser($uid)
    {
            $accesscontrol_model = new accesscontrol_model();
            $user_region = $this->session->userdata('uregion');
            $this->validateEditForm();

            if (!$this->form_validation->run()){
                $form_message = '';
                $this->load->view('header');
                $this->load->view('nav');
                $this->load->view('sidebar');
                $rpmb['regionlist'] =$accesscontrol_model->get_regions();
                $rpmb['user_details'] = $accesscontrol_model->getuserid($uid);
                $this->load->view('user_edit',$rpmb);
                $this->load->view('footer');
            } else {
                $firstname = $this->input->post('firstname');
                $middlename = $this->input->post('middlename');
                $surname = $this->input->post('surname');
                $extname = $this->input->post('extensionname');
                $position = $this->input->post('position');
                $designation = $this->input->post('designation');
                $contact = $this->input->post('contactno');
                $username = $this->input->post('username');
                $email = $this->input->post('e_add');
                $userlevel = $this->input->post('userlevelid');
                $region = $this->input->post('regionlist');
                $activate = $this->input->post('status');

                $updateResult = $accesscontrol_model->updateUserinfo($firstname,$middlename,$surname,$extname, $position,$designation,$contact,$username,$email,$userlevel,$region,$activate,$uid);
                if ($updateResult){
                    $this->load->view('header');
                    $this->load->view('nav');
                    $this->load->view('sidebar');
                    $this->load->view('users_list', array(
                        'userslist' => $accesscontrol_model->get_users_list()));
                    $this->load->view('footer');
                }
            }

    }

    public function delete_Userinfo($uid)
    {
        $accesscontrol_model = new accesscontrol_model();
        if ($uid > 0){
            $deleteResult = $accesscontrol_model->deleteUserinfo($uid);
            if ($deleteResult){
                $this->load->view('header');
                $this->load->view('nav');
                $this->load->view('sidebar');
                $this->load->view('users_list', array(
                    'userslist' => $accesscontrol_model->get_users_list()));
                $this->load->view('footer');
            }
        }
    }
    public function activate_Userinfo($uid)
    {
        $accesscontrol_model = new accesscontrol_model();
        if ($uid > 0){
            $deleteResult = $accesscontrol_model->activateUserinfo($uid);
            if ($deleteResult){
                $this->load->view('header');
                $this->load->view('nav');
                $this->load->view('sidebar');
                $this->load->view('users_list', array(
                    'userslist' => $accesscontrol_model->get_users_list()));
                $this->load->view('footer');
            }
        }
    }

    protected function validateAddForm()
    {
        $config = array(
            array(
                'field' => 'firstname',
                'label' => 'firstname',
                'rules' => 'required'
            )

        );
        return $this->form_validation->set_rules($config);

    }

    protected function validateEditForm()
    {
        $config = array(
            array(
                'field' => 'firstname',
                'label' => 'firstname',
                'rules' => 'required'
            )

        );
        return $this->form_validation->set_rules($config);
    }

}