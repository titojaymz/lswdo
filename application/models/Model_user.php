<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Created by JOSEF FRIEDRICH S. BALDO
 * Date Time: 10/17/15 10:27 PM
 */
class Model_user extends CI_Model
{
    private $username;

    private $password;

    private $firstname;

    private $middlename;

    private $surname;

    private $extensionname;

    private $email;

    private $regionlist;


    protected function getUsername()
    {
        return $this->username;
    }


    protected function getPassword()
    {
        return $this->password;
    }


    protected function getFirstname()
    {
        return $this->firstname;
    }


    protected function getMiddlename()
    {
        return $this->middlename;
    }


    protected function getSurname()
    {
        return $this->surname;
    }


    protected function getExtensionname()
    {
        return $this->extensionname;
    }


    protected function getEmail()
    {
        return $this->email;
    }


    protected function getRegion()
    {
        return $this->regionlist;
    }


    public function __construct($username = NULL, $password = NULL, $firstname = NULL, $middlename = NULL, $surname = NULL, $extensionname = NULL,$email = NULL, $regionlist = NULL)
    {
        $this->username = $username;
        $this->password = $password;
        $this->firstname = $firstname;
        $this->middlename = $middlename;
        $this->surname = $surname;
        $this->extensionname = $extensionname;
        $this->email = $email;
        $this->regionlist = $regionlist;
        $this -> account_locked = 'locked';
        $this -> locked = 'Yes';
        $this -> logged = "Yes";
    }

    /**
     * registerUser
     * validated: YES
     * errors found: none
     * validated by: JFSBALDO
     * date and time validated: May 13, 2016 10:41
     */
    public function registerUser()
    {
        $this->db->trans_begin();
        $this->db->query('Insert into tbl_user (username,password,email,firstname,middlename,surname,extensionname,user_level,region_code)
                          Values
                          ("'.$this->getUsername().'",
                          "'.$this->getPassword().'",
                            "'.$this->getEmail().'",
                           "'.$this->getFirstname().'",
                           "'.$this->getMiddlename().'",
                            "'.$this->getSurname().'",
                            "'.$this->getExtensionname().'",
                            "0",
                            "'.$this->getRegion().'")');
        if ($this->db->trans_status() === FALSE)
        {
            $this->db->trans_rollback();
            $queryResult = 0;
        }
        else
        {
            $this->db->trans_commit();
            $queryResult = 1;
        }
        $this->db->close();
        return $queryResult;
    }

    /**
     * @param $email
     * @return mixed
     * userActivated
     * validated: YES
     * errors found: none
     * validated by: JFSBALDO
     * date and time validated: May 13, 2016 10:42
     */
    public function userActivated($email)
    {
//        $email = $this->getEmail();
        $query = $this->db->get_where('tbl_user', array('email' => $email,'activated' => 1));
        return $query->num_rows();
    }


    public function forgotPassword($email,$superkey)
    {
        $this->db->trans_begin();

        $this->db->query('UPDATE tbl_user SET
                          password="'.$superkey.'"
                          WHERE
                          email = "'.$email.'"
                          ');

        if ($this->db->trans_status() === FALSE)
        {
            $this->db->trans_rollback();
            return FALSE;
        }
        else
        {
            $this->db->trans_commit();
            return TRUE;
        }
        $this->db->close();
    }


    public function getuserpass($uid = 0)
    {
        $query = $this->db->query('SELECT password from tbl_user where uid = "'.$uid.'"');
        if ($query->num_rows() > 0)
        {
            return $query->row();
        }
        else
        {
            return FALSE;
        }
        $this->db->close();
    }


    public function changePassword($id,$password)
    {
        $this->db->trans_begin();
        $this->db->query('UPDATE tbl_user SET
                          password="'.$password.'"
                          WHERE
                          uid = "'.$id.'"
                          ');
        if ($this->db->trans_status() === FALSE)
        {
            $this->db->trans_rollback();
            return FALSE;
        }
        else
        {
            $this->db->trans_commit();
            return TRUE;
        }
        $this->db->close();
    }


    public function ifUserExist($newkey)
    {
        // fetch the username record from the databse users.sdfsdfsdfsd
        $query = $this -> db -> get_where('tbl_user', array('username' => $this->getUsername(),'activated' => 1));
        // check if we have a record in the db
        if ($query -> num_rows() > 0) {
            //get the result as an array
            $query = $query -> row_array();
            // retrieve the userid, username , password, account status
            $account_status = $query['locked_status'];
            // check the account status
            if ($account_status === 'Yes') {
                return $this -> account_locked;
            }
            // fetch the user_id, username and password
            $uid = $query['uid'];

            if (!$this -> session -> userdata('uid')) {
                $this -> session -> set_userdata('uid', $uid);
            }
            $user_name = $query['username'];
            $user_password = $query['password'];
            //hash the password
//            $password = sha1($password);
            // if passwords do not match insert a new record in the db sessions.
            if ($newkey != $user_password) {
                //return ($this -> create_session($session_id, $user_id));
                $session_id = $this -> session -> userdata('session_id');
                return ($this -> update_ci_session($session_id, $uid));
            }
            // check if passwords do match, then set session and log the user.
            else if (($newkey === $user_password)) {
                $userdata = array('uid' => $uid, 'user_name' => $user_name);
                $this -> session -> set_userdata($userdata);
                $this -> update_users_activity($uid, $this -> logged);
//                $this->update_session_start($uid,$session_id);
                return true;
            }
        } else {
            return false;
        }
    }


    function update_ci_session($session_id, $user_id) {
        $attempt = $this->session->userdata['login_attempt'];
        if ($attempt == 0) {
            // update the current session login attempt
            $this->session->set_userdata('login_attempt',1);
            return false;
        } else if ($attempt > 0) {
            $attempt = $this->session->userdata['login_attempt'] + 1;
            $this->session->set_userdata('login_attempt',$attempt);

        }
        // check the number of attempts , if 3 return account locked, if not return false, 3 is the max attempts
        if ($attempt === 3) {
            $this -> lock_user_account($user_id);
            return $this -> account_locked;
        } else {
            return false;
        }
    }


    function lock_user_account($user_id) {
        // update the users account status to locked === yes
        $this -> db -> where('uid', $user_id);
        $this -> db -> update('tbl_user', array('locked_status' => $this -> locked));
        $this -> session -> sess_destroy();
    }


    function update_users_activity($user_id, $logged) {
        $this -> db -> where('uid', $user_id);
        $this -> db -> update('tbl_user', array('logged_in' => $logged));
    }


    function update_session_start($user_id, $session_id) {
        $session_start = time();
        $this -> db -> where('session_id', $session_id);
        $this -> db -> update('ci_sessions', array('session_start' => $session_start, 'user_id' => $user_id));
    }


    function update_session_end($user_id, $session_id) {
        $session_end = time();
        $this -> db -> where('session_id', $session_id);
        $this -> db -> update('ci_sessions', array('session_end' => $session_end, 'user_id' => $user_id));
    }


    public function retrieveUserData()
    {
        $query = $this->db->get_where('tbl_user', array('username' => $this->getUsername(),'password' => $this->getPassword()));
        return $query->row();
    }


}