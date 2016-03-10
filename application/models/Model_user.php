<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Created by JOSEF FRIEDRICH S. BALDO
 * Date Time: 10/17/15 10:27 PM
 */

class Model_user extends CI_Model {

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



    public function __construct($username = NULL,$password = NULL, $firstname = NULL, $middlename = NULL, $surname = NULL, $extensionname = NULL,$email = NULL, $regionlist = NULL)
    {
        $this->username = $username;
        $this->password = $password;
		$this->firstname = $firstname;
		$this->middlename = $middlename;
		$this->surname = $surname;
		$this->extensionname = $extensionname;
		$this->email = $email;
		$this->regionlist = $regionlist;
    }

    public function registerUser()
    {
		
        $this->db->trans_begin();

        $this->db->query('Insert into tbl_user (username,`password`, email, firstname, middlename,surname,extensionname,region_code)
                          Values
                          ("'.$this->getUsername().'","'.
                            $this->getPassword().'","'.
                            $this->getEmail().'","'.
                            $this->getFirstname().'","'.
                            $this->getMiddlename().'","'.
                            $this->getSurname().'","'.
                            $this->getExtensionname().'","'.
                            $this->getRegion().'")');

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
        return $queryResult;
    }
	
	public function changePassword($id,$password)
    {
        $this->db->trans_begin();

        $this->db->query('UPDATE tbl_user SET
                          passwd="'.$password.'"
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

    public function ifUserExist()
    {
        $query = $this->db->get_where('tbl_user', array('username' => $this->getUsername(),'password' => $this->getPassword(), 'activated' => 1));
        return $query->num_rows();
    }

    public function retrieveUserData()
    {
        $query = $this->db->get_where('tbl_user', array('username' => $this->getUsername(),'password' => $this->getPassword()));
        return $query->row();
    }
	
	
}