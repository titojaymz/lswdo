<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Created by JOSEF FRIEDRICH S. BALDO
 * Date Time: 10/17/15 10:57 PMasdasdas
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
                $registerSendResult = $this->registration_sendmail($email,$username,$firstname,$middlename,$surname,$extensionname,$regionlist,$password);
                $form_message = '<div class="kode-alert kode-alert kode-alert-icon kode-alert-click alert3"><i class="fa fa-lock"></i>'.$registerSendResult.'<a href="#" class="closed">&times;</a></div>';
                $this->load->view('header');
                $this->load->view('login',array($rpmb,'form_message'=>$form_message));
                $this->load->view('footer');
                $this->redirectIndexLogin();
            } else {
                $form_message = '<div class="kode-alert kode-alert kode-alert-icon kode-alert-click alert6"><i class="fa fa-lock"></i>Registration Failed!<a href="#" class="closed">&times;</a></div>';
                $this->load->view('header');
                $this->load->view('register',array($rpmb,'form_message'=>$form_message));
                $this->load->view('footer');
            }
        }
    }
    public function registration_sendmail($email,$username,$firstname,$middlename,$surname,$extensionname,$regionlist) {
        $mail = new PHPMailer;

//$mail->SMTPDebug = 3;                               // Enable verbose debug output

        $mail->isSMTP();                                      // Set mailer to use SMTP
        $mail->Host = 'ssl://smtp.gmail.com';  // Specify main and backup SMTP servers
        $mail->SMTPAuth = true;                               // Enable SMTP authentication
        $mail->Username = 'itsm-desk@dswd.gov.ph';                 // SMTP username
        $mail->Password = 'm21l3rm0d3r@t0r123';                           // SMTP password
        $mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
        $mail->Port = 465;                                    // TCP port to connect to

        $mail->setFrom('pspis-noreply@dswd.gov.ph', 'msflswdo-noreply@dswd.gov.ph');
        $mail->addAddress($email);     // Add a recipient
        $mail->isHTML(true);                                  // Set email format to HTML

        $mail->Subject = 'Registration Information';
        $mail->Body    = 'Dear Sir/Madam, <br><br>
                          Thank you for registering with us. Your registration details with us is as follow: <br><br>
                          Full Name: '.$firstname.' '.$middlename.' '.$surname.' '.$extensionname.'<br>
                          Email Address: '.$email.'<br>
                          Username: '.$username.'<br>
                          Region: '.$regionlist.'<br><br>
                          Please feel free to contact us in case of further queries.
                          <br>
                          Best Regards,
                          Support';
        $mail->AltBody = 'Registration';
        if(!$mail->send()) {
            $sendMessage = 'Error Sending Email, but the Registration is complete';
        } else {
            $sendMessage = 'Registration succeeded. An email has been sent to your email address.!';
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
            $ifUserExist = $Model_user->ifUserExist($newkey);
            if ($ifUserExist === true) {
                $this->session->set_userdata('user_id',$Model_user->retrieveUserData()->uid);
                $this->session->set_userdata('fullName',$Model_user->retrieveUserData()->firstname.' '.$Model_user->retrieveUserData()->middlename.' '.$Model_user->retrieveUserData()->lastname);
                $this->load->view('header');
                $this->load->view('nav');
                $this->load->view('login');
                $this->load->view('footer');
            } else {
                if ($ifUserExist === false) {
                    $data['form_message'] = '<div class="kode-alert kode-alert kode-alert-icon kode-alert-click alert6"><i class="fa fa-lock"></i>Incorrect Username/Password<a href="#" class="closed">&times;</a></div>';
                    $data['error_message'] = "The username or password you entered is incorrect";
                    $data['title'] = "Login Page";
                    $this->load->view('header', $data);
                    $this->load->view('login', $data);
                    $this->load->view('footer');
                }   else if ($ifUserExist === 'locked') {
                    $data['error_message'] = "Your account has been locked <a href=" . base_url() . 'unlock_account' . "> Unlock your account</a>";
                    $data['disabled'] = "disabled";
                    $data['signin'] = anchor('logout', 'Sign in with a different name');
                    $data['title'] = "Login Page";
                    $form_message = '<div class="kode-alert kode-alert kode-alert-icon kode-alert-click alert6"><i class="fa fa-lock"></i>Locked Status! Please Contact Us<a href="#" class="closed">&times;</a></div>';
                    $this->load->view('header');
                    $this->load->view('login', array('form_message' => $form_message));
                    $this->load->view('footer');
                    //$this->load->view('error_login',array('redirectIndex'=>$this->redirectIndex()));
                }
            }
        }
    }
    public function logout()
    {
        $this->session->unset_userdata('user_id');
        $this->session->sess_destroy();
        $this->load->view('logout');
    }
    protected function customvalidateRegForm()
    {
        $config = array(
            array(
                'field'   => 'username',
                'label'   => 'username|is_unique[tbl_user.username]',
                'rules'   => 'required'
            ),
            array(
                'field'   => 'password',
                'label'   => 'Password',
                'rules'   => 'required|trim|password'
            ),
            array(
                'field'   => 'password2',
                'label'   => 'Confirm Password',
                'rules'   => 'required|trim|password|matches[password]'
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
                'rules'   => 'required|is_unique[tbl_user.email]'
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
    public function redirectIndexLogin()
    {
        $page = base_url('users/login');
        $sec = "0.5";
        header("Refresh: $sec; url=$page");
    }
    public function init_rpmb_session() {
        if(isset($_POST['regionlist']) and $_POST['regionlist'] > 0) {
            $_SESSION['region'] = $_POST['regionlist'];
        }
    }
}