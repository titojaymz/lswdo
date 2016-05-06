<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Created by JOSEF FRIEDRICH S. BALDO
 * Date Time: 10/17/15 10:57 PMasdasdas
 */
class users extends CI_Controller {

    /***
     * methods added:
     * date added: May 3, 2016
     * added by: jfsbaldo
     * description: added this method to optimize the code for email credentials
     */
    protected function email_credentials()
    {
        return array(
            'host' => '',
            'username' => '',
            'password' => '',
            'mail_sender' => ''
        );
    }
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
        if (!$this->form_validation->run()) {
            $form_message = '';
            $this->load->view('header');
            $this->load->view('register', array('rpmb' => $rpmb, 'form_message' => $form_message));
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
            $superkey = $this->encrypt->sha1($userkey . $password);
            $captcha = $this->input->post('g-recaptcha-response');
            if (!$captcha) {
                $form_message = '<div class="kode-alert kode-alert kode-alert-icon kode-alert-click alert6"><i class="fa fa-lock"></i>Please check the captcha form!.<a href="#" class="closed">&times;</a></div>';
                $this->load->view('header');
                $this->load->view('register', array($rpmb, 'form_message' => $form_message));
                $this->load->view('footer');
            } else {
                $secretKey = "6LcMzRwTAAAAAMj1ENuYhur5H67mc8dXSfa_cFIy";
                $ip = $_SERVER['REMOTE_ADDR'];
                $response = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=" . $secretKey . "&response=" . $captcha . "&remoteip=" . $ip);
                $responseKeys = json_decode($response, true);
                if (intval($responseKeys["success"]) !== 1) {
                    echo '<h2></h2>';
                } else {
                    echo '<h2></h2>';
                }
                $Model_user = new Model_user($username, $superkey, $email, $firstname, $middlename, $surname, $extensionname, $regionlist);
                //username,`password`, email, firstname, middlename,surname,extensionname,region_code
                $regResult = $Model_user->registerUser();
                if ($regResult == 1) {
                    $registerSendResult = $this->registration_sendmail($username, $password, $email, $firstname, $middlename, $surname, $extensionname, $regionlist);
                    $form_message = '<div class="kode-alert kode-alert kode-alert-icon kode-alert-click alert3"><i class="fa fa-lock"></i> Registration Successful! <a href="#" class="closed">&times;</a></div>';
                    $this->load->view('header');
                    $this->load->view('login', array($rpmb, 'form_message' => $form_message));
                    $this->load->view('footer');
                    $this->redirectIndexLogin();
                } else {
                    $form_message = '<div class="kode-alert kode-alert kode-alert-icon kode-alert-click alert6"><i class="fa fa-lock"></i>Registration Failed!<a href="#" class="closed">&times;</a></div>';
                    $this->load->view('header');
                    $this->load->view('register', array($rpmb, 'form_message' => $form_message));
                    $this->load->view('footer');
                }
            }
        }
    }

    public function registration_sendmail($email,$username,$firstname,$middlename,$surname,$extensionname,$regionlist) {

        $email_credentials = $this->email_credentials();
        $mail = new PHPMailer;

//$mail->SMTPDebug = 3;                               // Enable verbose debug output

        $mail->isSMTP();                                      // Set mailer to use SMTP
        $mail->Host = $email_credentials['host'];  // Specify main and backup SMTP servers
        $mail->SMTPAuth = true;                               // Enable SMTP authentication
        $mail->Username = $email_credentials['username'];                 // SMTP username
        $mail->Password = $email_credentials['password'];                           // SMTP password
        $mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
        $mail->Port = 465;                                    // TCP port to connect to

        $mail->setFrom($email_credentials['mail_sender'], $email_credentials['mail_sender']);
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
            $captcha = $this->input->post('g-recaptcha-response');
            if(!$captcha) {
                $form_message = '<div class="kode-alert kode-alert kode-alert-icon kode-alert-click alert6"><i class="fa fa-lock"></i>Please check the captcha form!.<a href="#" class="closed">&times;</a></div>';
                $this->load->view('header');
                $this->load->view('login', array('form_message' => $form_message));
                $this->load->view('footer');
            } else {
                $secretKey = "6LcMzRwTAAAAAMj1ENuYhur5H67mc8dXSfa_cFIy";
                $ip = $_SERVER['REMOTE_ADDR'];
                $response = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=" . $secretKey . "&response=" . $captcha . "&remoteip=" . $ip);
                $responseKeys = json_decode($response, true);
                if (intval($responseKeys["success"]) !== 1) {
                    echo '<h2></h2>';
                } else {
                    echo '<h2></h2>';
                }
            $newkey = $this->encrypt->sha1($userkey.$password);
            $Model_user = new Model_user($username,$newkey);
            $ifUserExist = $Model_user->ifUserExist($newkey);
            if ($ifUserExist === true) {
                $this->session->set_userdata('user_id',$Model_user->retrieveUserData()->uid);
                $this->session->set_userdata('uregion_code',$Model_user->retrieveUserData()->region_code);
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
    }

    public function logout()
    {
        $this->session->unset_userdata('user_id');
        $this->session->sess_destroy();
        $this->load->view('logout');
    }
    public function change_password($uid =0)
    {
        if ($uid > 0)
        {
            $Model_user = new Model_user();
            $this->validateChangePassword();
            $userkey = $this->superKey();

            if (!$this->form_validation->run()){
                $this->load->view('header');
                $this->load->view('nav');
                $this->load->view('sidebar');
                $this->load->view('change_password',array('passworddetails' => $Model_user->getuserpass($uid)));
                $this->load->view('footer');
            } else {
                $id = $this->input->post('id');
                $password = $this->input->post('password');
                $newkey = $this->encrypt->sha1($userkey.$password);
                $updateResult = $Model_user->changePassword($id, $newkey);
                if ($updateResult){
                    $form_message = '<div class="kode-alert kode-alert kode-alert-icon kode-alert-click alert3"><i class="fa fa-lock"></i>Update Success!<a href="#" class="closed">&times;</a></div>';
                    $this->load->view('header');
                    $this->load->view('nav');
                    $this->load->view('sidebar');
                    $this->load->view('change_password',array('passworddetails' => $Model_user->getuserpass($uid),'form_message'=>$form_message));
                    $this->load->view('footer');
                } else {
                    $form_message = '<div class="kode-alert kode-alert kode-alert-icon kode-alert-click alert6"><i class="fa fa-lock"></i>Fail!<a href="#" class="closed">&times;</a></div>';
                    $this->load->view('header');
                    $this->load->view('nav');
                    $this->load->view('sidebar');
                    $this->load->view('change_password',array('passworddetails' => $Model_user->getuserpass($uid),'form_message'=>$form_message));
                    $this->load->view('footer');
                }
            }
        } else {
            echo "1234";
        }
    }

    protected function validateChangePassword()
    {
        $config = array(
            array(
                'field'   => 'id',
                'label'   => 'id',
                'rules'   => 'required'
            ),
            array(
                'field'   => 'password2',
                'label'   => 'Confirm Password',
                'rules'   => 'trim|required|matches[password]'
            ),array(
                'field'   => 'oldpassword',
                'label'   => 'Old Password',
                'rules'   => 'trim|required|callback_oldpassword_check'
            ),
            array(
                'field'   => 'password',
                'label'   => 'Password',
                'rules'   => 'trim|required'
            )
        );

        return $this->form_validation->set_rules($config);
    }

    public function oldpassword_check($oldpassword){
        $Model_user = new Model_user();
        $userkey = $this->superKey();
        $myid = $this->session->userdata('uid');
        $old_password_hash = sha1($userkey.$oldpassword);
        $old_password_db_hash = $Model_user->getuserpass($myid);
        $error = '<div class="kode-alert kode-alert kode-alert-icon kode-alert-click alert6"><i class="fa fa-lock"></i>Old password not match!<a href="#" class="closed">&times;</a></div>';
        if($old_password_hash != $old_password_db_hash->password)
        {
            $this->form_validation->set_message('oldpassword_check', ''.$error.'');
            return FALSE;
        }
        return TRUE;
    }
    public function forgot_password()
    {
        $Model_user = new Model_user();
        $this->customvalidateForgotForm();

        $userkey = $this->superKey();

        if (!$this->form_validation->run()){
            $this->load->view('header');
            $this->load->view('forgot_password');
            $this->load->view('footer');


        } else {
            $email = $this->input->post('email');
            $password = random_string('alnum', 16);
            $superkey = $this->encrypt->sha1($userkey.$password);
            $ifUserActivated = $Model_user->userActivated($email);
            $captcha = $this->input->post('g-recaptcha-response');
            if(!$captcha) {
                $form_message = '<div class="kode-alert kode-alert kode-alert-icon kode-alert-click alert6"><i class="fa fa-lock"></i>Please check the captcha form!.<a href="#" class="closed">&times;</a></div>';
                $this->load->view('header');
                $this->load->view('forgot_password', array('form_message' => $form_message));
                $this->load->view('footer');
            } else {
                $secretKey = "6LcMzRwTAAAAAMj1ENuYhur5H67mc8dXSfa_cFIy";
                $ip = $_SERVER['REMOTE_ADDR'];
                $response = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=" . $secretKey . "&response=" . $captcha . "&remoteip=" . $ip);
                $responseKeys = json_decode($response, true);
                if (intval($responseKeys["success"]) !== 1) {
                    echo '<h2></h2>';
                } else {
                    echo '<h2></h2>';
                }
                if ($ifUserActivated > 0) {
                    $regResult = $Model_user->forgotPassword($email, $superkey);
                    if ($regResult == 1) {
                        $resultSend = $this->forgotpassword_sendmail($email, $password);
                        $form_message = ' <div class="kode-alert kode-alert kode-alert-icon kode-alert-click alert3"><i class="fa fa-lock"></i>' . $resultSend . '<a href="#" class="closed">&times;</a></div>';
                        $this->load->view('header');
                        $this->load->view('forgot_password', array('form_message' => $form_message));
                        $this->load->view('footer');
                    } else {
                        $form_message = '<div class="kode-alert kode-alert kode-alert-icon kode-alert-click alert6"><i class="fa fa-lock"></i>Fail!<a href="#" class="closed">&times;</a></div>';
                        $this->load->view('header');
                        $this->load->view('forgot_password', array('form_message' => $form_message));
                        $this->load->view('footer');
                    }
                } else {
                    $form_message = '<div class="kode-alert kode-alert kode-alert-icon kode-alert-click alert6"><i class="fa fa-lock"></i>Invalid Account/The account is not yet activated.!<a href="#" class="closed">&times;</a></div>';
                    $this->load->view('header');
                    $this->load->view('forgot_password', array('form_message' => $form_message));
                    $this->load->view('footer');
                }
            }
        }

    }
    public function forgotpassword_sendmail($email,$password)
    {
        $email_creds = $this->email_credentials();
        $this->load->library('My_PHPMailer');
        $mail = new PHPMailer;

//$mail->SMTPDebug = 3;                               // Enable verbose debug output

        $mail->isSMTP();                                      // Set mailer to use SMTP
        $mail->Host = $email_creds['host'];  // Specify main and backup SMTP servers
        $mail->SMTPAuth = true;                               // Enable SMTP authentication
        $mail->Username = $email_creds['username'];                 // SMTP username
        $mail->Password = $email_creds['password'];                           // SMTP password
        $mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
        $mail->Port = 465;                                    // TCP port to connect to

        $mail->setFrom($email_creds['mail_sender'], $email_creds['mail_sender']);
        $mail->addAddress($email);     // Add a recipient
        $mail->isHTML(true);                                  // Set email format to HTML

        $mail->Subject = 'Password Reset';
        $mail->Body = 'Dear Sir/Madam, <br><br>
                   Please see below for the requested information: <br><br>
                   Email Address: ' . $email . '<br>
                   Password: ' . $password . '<br><br>
                   Please feel free to contact us in case of further queries.
                   <br>
                   Best Regards,
                   Support';
        $mail->AltBody = 'Forgot Password';

        if (!$mail->send()) {
            $sendMessage = 'Error Sending';
        } else {
            $sendMessage = 'Succeeded. An email has been sent to your email address.!';
        }
        return $sendMessage;
    }
    protected function customvalidateForgotForm()
    {
        $config = array(
            array(
                'field'   => 'email',
                'label'   => 'email',
                'rules'   => 'required'
            )
        );

        return $this->form_validation->set_rules($config);
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