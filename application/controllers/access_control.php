<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Created by JOSEF FRIEDRICH S. BALDO
 * Date Time: 10/17/15 10:57 PM
 */
class access_control extends CI_Controller {

    public function users(){
        $user_control = new accesscontrol_model();
        $user_region = $this->session->userdata('uregion');
        $form_message = '';
        $this->load->view('header');
        $this->load->view('nav');
        $this->load->view('sidebar');
        $this->load->view('userslistview', array(
            'userslist' => $user_control->get_users_list($user_region)));
        $this->load->view('footer');

    }

    public function addUser()
    {

        $this->validateAddForm();
        $user_region = $this->session->userdata('uregion');

        if ($this->form_validation->run() == FALSE)
        {
            //fail validation
            $this->load->view('header');
            $rpmb['regionlist'] = $this->accesscontrol_model->get_regions();
            $rpmb['userlist'] = $this->accesscontrol_model->get_fposition();

            $this->load->view('user_add',$rpmb);
        }
        else
        {
            $accesscontrol_model = new accesscontrol_model();
            //pass validation
            $full_name = $this->input->post('full_name');
            $username = $this->input->post('username');
            $email = $this->input->post('e_add');
            $regionlist = $this->input->post('regionlist');
            $pword = $this->input->post('pword');
            $userlevelid = $this->input->post('userlevelid');
            $status = $this->input->post('status');
//                $region = $this->input->post('region');


            $addResult = $accesscontrol_model->insertUserinfo($full_name, $email, $username, $pword, $userlevelid, $status,$regionlist);
            if ($addResult){
                $this->load->view('header');
                $this->load->view('nav');
                $this->load->view('sidebar');
                $this->load->view('userslistview', array(
                    'userslist' => $accesscontrol_model->get_users_list($user_region)));
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

    public function editUser($uid = 0)
    {
        if ($uid > 0){
            $accesscontrol_model = new accesscontrol_model();
            $user_region = $this->session->userdata('uregion');
            $this->validateEditForm();

            if (!$this->form_validation->run()){
                $form_message = '';
                $this->load->view('header');
                $this->load->view('nav');
                $this->load->view('sidebar');
                $rpmb['regionlist'] = $this->accesscontrol_model->get_regions();
                $rpmb['levellist'] = $this->accesscontrol_model->get_fposition();
                $rpmb['user_details'] = $this->accesscontrol_model->getuserid($uid);
                $this->load->view('user_edit',$rpmb);
                $this->load->view('footer');
            } else {
                $uid = $this->input->post('uid');
                $myid = $this->input->post('myid');
                $full_name = $this->input->post('full_name');
                $email = $this->input->post('email');
                $username = $this->input->post('username');
                $pword = $this->input->post('password');
                $userlevelid = $this->input->post('access_level');
                $status = $this->input->post('status');
                $regionlist = $this->input->post('regionlist');

                $updateResult = $accesscontrol_model->updateUserinfo($uid, $full_name, $email, $username, $pword, $userlevelid, $status,$regionlist, $myid);
                if ($updateResult){
                    $this->load->view('header');
                    $this->load->view('nav');
                    $this->load->view('sidebar');
                    $this->load->view('userslistview', array(
                        'userslist' => $accesscontrol_model->get_users_list($user_region)));
                    $this->load->view('footer');
                }
            }
        } else {
            $this->load->view('no_id',array('redirectIndex'=>$this->redirectIndex()));
        }

    }

    public function delete_Userinfo($uid = 0)
    {
        $accesscontrol_model = new accesscontrol_model();
        if ($uid > 0){
            $deleteResult = $accesscontrol_model->deleteUserinfo($uid);
            if ($deleteResult){
                $this->load->view('header');
                $this->load->view('nav');
                $this->load->view('sidebar');
                $this->load->view('userslistview', array(
                    'userslist' => $accesscontrol_model->get_users_list()));
                $this->load->view('footer');
            }
        }
    }

    protected function validateAddForm()
    {
        $config = array(
            array(
                'field' => 'full_name',
                'label' => 'full_name',
                'rules' => 'required'
            )

        );
        return $this->form_validation->set_rules($config);

    }

    protected function validateEditForm()
    {
        $config = array(
            array(
                'field' => 'full_name',
                'label' => 'full_name',
                'rules' => 'required'
            )

        );
        return $this->form_validation->set_rules($config);
    }

}