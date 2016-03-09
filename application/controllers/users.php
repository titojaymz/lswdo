<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Created by JOSEF FRIEDRICH S. BALDO
 * Date Time: 10/17/15 10:57 PM
 */
class users extends CI_Controller {

    public function index()
    {
        redirect('/users/login','location');
    }

    public function register()
    {
        $this->load->model('Model_user');
        $this->customvalidateRegForm();
        $this->init_rpmb_session();
        $rpmb['regionlist'] = $this->Model_form->get_regions();

        if (!$this->form_validation->run()){
            $this->load->view('header');
            $this->load->view('register',$rpmb);
            $this->load->view('footer');
        } else {
            $username = $this->input->post('username');
            $password = $this->input->post('password');
            $firstname = $this->input->post('firstname');
            $middlename = $this->input->post('middlename');
            $surname = $this->input->post('surname');
            $extensionname = $this->input->post('extensionname');
            $position = $this->input->post('position');
            $designation = $this->input->post('designation');
            $email = $this->input->post('email');
            $regionlist = $this->input->post('regionlist');
            $contactno = $this->input->post('contactno');
            $User_Model = new User_Model($username,$password,$firstname,$middlename,$surname,$extensionname,$position,$designation,$email,$regionlist,$contactno);
            $regResult = $User_Model->registerUser();
            if ($regResult == 1){
                $this->load->view('registration_success');
                $this->redirectIndex();
            } else {
                $this->load->view('registration_fail');
            }
        }
    }

    public function login()
    {
        $this->load->model('Model_user');
        $this->validateLoginForm();

        if (!$this->form_validation->run()){
            $this->load->view('header');
            $this->load->view('login');
            $this->load->view('footer');
        } else {
            $username = $this->input->post('username');
            $password = $this->input->post('password');
            $Model_user = new Model_user($username,$password);
            $ifUserExist = $Model_user->ifUserExist();
            if ($ifUserExist > 0){
                $this->session->set_userdata('user_id',$Model_user->retrieveUserData()->uid);
                $this->load->view('header');
				$this->load->view('nav');
                $this->load->view('login');
                $this->load->view('footer');
            } else {
                $this->load->view('error_login',array('redirectIndex'=>$this->redirectIndex()));
            }
        }
    }

    public function logout()
    {
        $this->session->sess_destroy();
        $this->load->view('logout');
    }

    protected function customvalidateRegForm()
    {
        $config = array(
            array(
                'field'   => 'username',
                'label'   => 'username',
                'rules'   => 'required'
            ),
            array(
                'field'   => 'password',
                'label'   => 'password',
                'rules'   => 'required'
            ),
            array(
                'field'   => 'firstname',
                'label'   => 'firstname',
                'rules'   => 'required'
            ),
            array(
                'field'   => 'middlename',
                'label'   => 'middlename',
                'rules'   => 'required'
            ),
            array(
                'field'   => 'surname',
                'label'   => 'surname',
                'rules'   => 'required'
            ),
            array(
                'field'   => 'extensionname',
                'label'   => 'extensionname',
                'rules'   => 'required'
            ),
            array(
                'field'   => 'position',
                'label'   => 'position',
                'rules'   => 'required'
            ),
            array(
                'field'   => 'designation',
                'label'   => 'designation',
                'rules'   => 'required'
            ),
            array(
                'field'   => 'email',
                'label'   => 'email',
                'rules'   => 'required'
            ),
            array(
                'field'   => 'regionlist',
                'label'   => 'regionlist',
                'rules'   => 'required'
            ),
            array(
                'field'   => 'contactno',
                'label'   => 'contactno',
                'rules'   => 'required'
            )
        );

        return $this->form_validation->set_rules($config);
    }

    protected function validateLoginForm()
    {
        $config = array(
            array(
                'field'   => 'username',
                'label'   => 'username',
                'rules'   => 'required'
            ),
            array(
                'field'   => 'password',
                'label'   => 'password',
                'rules'   => 'required'
            )
        );

        return $this->form_validation->set_rules($config);
    }

    public function redirectIndex()
    {
        $page = base_url();
        $sec = "1";
        header("Refresh: $sec; url=$page");
    }

}