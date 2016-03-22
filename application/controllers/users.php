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

    public function superKey()
    {
        return $this->config->item('encryption_key');

        $this->load->library('encrypt');
    }

    public function register()
    {
        $this->load->model('Model_user');
        $this->customvalidateRegForm();
        $this->init_rpmb_session();
        $rpmb['regionlist'] = $this->Model_form->get_regions();
        $userkey = $this->superKey();

        if (!$this->form_validation->run()){
            $form_message = '';
            $this->load->view('header');
            $this->load->view('register',array('rpmb'=>$rpmb,'form_message'=>$form_message));
            $this->load->view('footer');

        } else {
            $username = $this->input->post('username');
            $password = $this->input->post('password');
            $firstname = $this->input->post('firstname');
            $middlename = $this->input->post('middlename');
            $surname = $this->input->post('surname');
            $extensionname = $this->input->post('extensionname');
            $email = $this->input->post('email');
            $regionlist = $this->input->post('regionlist');
            $superkey = $this->encrypt->sha1($userkey.$password);


            $Model_user = new Model_user($username,$superkey,$firstname,$middlename,$surname,$extensionname,$email,$regionlist);
            $regResult = $Model_user->registerUser();
            if ($regResult == 1){
                $form_message = '<div class="kode-alert kode-alert kode-alert-icon kode-alert-click alert3"><i class="fa fa-lock"></i>Registration Completed!<a href="#" class="closed">&times;</a></div>';
                $this->load->view('header');
                $this->load->view('login',array($rpmb,'form_message'=>$form_message));
                $this->load->view('footer');
            } else {
                $form_message = '<div class="kode-alert kode-alert kode-alert-icon kode-alert-click alert6"><i class="fa fa-lock"></i>Registration Failed!<a href="#" class="closed">&times;</a></div>';
                $this->load->view('header');
                $this->load->view('register',array($rpmb,'form_message'=>$form_message));
                $this->load->view('footer');
            }
        }
    }

    public function login()
    {
        $this->load->model('Model_user');
        $this->validateLoginForm();
        $userkey = $this->superKey();
        if (!$this->form_validation->run()){
            $form_message = '';
            $this->load->view('header');
            $this->load->view('login',array('form_message'=>$form_message));
            $this->load->view('footer');
        } else {
            $username = $this->input->post('username');
            $password = $this->input->post('password');
            $newkey = $this->encrypt->sha1($userkey.$password);
            $Model_user = new Model_user($username,$newkey);
            $ifUserExist = $Model_user->ifUserExist();
            if ($ifUserExist > 0){
                $this->session->set_userdata('user_id',$Model_user->retrieveUserData()->uid);
                $this->load->view('header');
				$this->load->view('nav');
                $this->load->view('login');
                $this->load->view('footer');
            } else {
                $form_message = '<div class="kode-alert kode-alert kode-alert-icon kode-alert-click alert6"><i class="fa fa-lock"></i>Incorrect Username/Password<a href="#" class="closed">&times;</a></div>';
                $this->load->view('header');
                $this->load->view('login',array('form_message'=>$form_message));
                $this->load->view('footer');
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
                'field'   => 'email',
                'label'   => 'email',
                'rules'   => 'required'
            ),
            array(
                'field'   => 'regionlist',
                'label'   => 'regionlist',
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
    public function init_rpmb_session() {
        if(isset($_POST['regionlist']) and $_POST['regionlist'] > 0) {
            $_SESSION['region'] = $_POST['regionlist'];
        }
    }

}