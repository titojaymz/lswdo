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