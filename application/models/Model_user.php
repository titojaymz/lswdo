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
	private $position;
	private $designation;
	private $email;
	private $regionlist;
	private $contactno;

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

    protected function getPosition()
    {
        return $this->position;
    }

    protected function getDesignation()
    {
        return $this->designation;
    }
	
	protected function getEmail()
    {
        return $this->email;
    }
	
	protected function getRegion()
    {
        return $this->regionlist;
    }

    protected function getContactno()
    {
        return $this->contactno;
    }


    public function __construct($username = NULL,$password = NULL, $firstname = NULL, $middlename = NULL, $surname = NULL, $extensionname = NULL, $position = NULL, $designation = NULL, $email = NULL, $regionlist = NULL, $contactno = NULL)
    {
        $this->username = $username;
        $this->password = $password;
		$this->firstname = $firstname;
		$this->middlename = $middlename;
		$this->surname = $surname;
		$this->extensionname = $extensionname;
		$this->position = $position;
		$this->designation = $designation;
		$this->email = $email;
		$this->regionlist = $regionlist;
		$this->contactno = $contactno;
    }

    public function registerUser()
    {
		
        $this->db->trans_begin();

        $this->db->query('INSERT INTO tbl_user(username,password,firstname,middlename,surname,extensionname,email,position,designation,region_code,user_level,contact_no) VALUES("'.$this->getUsername().'","'.$this->getPassword().'","'.$this->getFirstname().'","'.$this->getMiddlename().'","'.$this->getSurname().'","'.$this->getExtensionname().'","'.$this->getEmail().'","'.$this->getPosition().'","'.$this->getDesignation().'","'.$this->getRegion().'",0,"'.$this->getContactno().'")');

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
        $hash = sha1($this->getPassword());
        $query = $this->db->get_where('tbl_user', array('username' => $this->getUsername(),'password' => $hash, 'activated' => 1));
        return $query->num_rows();
    }

    public function retrieveUserData()
    {
        $hash = sha1($this->getPassword());
        $query = $this->db->get_where('tbl_user', array('username' => $this->getUsername(),'password' => $hash));
        return $query->row();
    }
	
	
}