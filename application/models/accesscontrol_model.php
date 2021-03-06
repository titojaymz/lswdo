<?php
/**
 * Created by PhpStorm.
 * User: ljesaclayan
 * Date: 2/11/2016
 * Time: 3:17 PM
 */

class accesscontrol_model extends CI_Model
{
    public function record_count() { //pagination query1
        return $this->db->count_all("users");
    }


    public function get_users_list($region,$userid,$accesslevel)
    {

        if($accesslevel == -1){
            $where =  '';
        } elseif($accesslevel == 2){
            $where =  'WHERE a.region_code = '.$region;
        } else {
            $where =  'WHERE a.region_code = '.$region. ' and a.uid='.$userid;
        }

        $sql = 'select a.uid,a.username, a.email, a.firstname, a.middlename,a.surname,a.extensionname, b.region_name, a.activated, c.userlevel_name
                from tbl_user a
                INNer join lib_regions b
                ON a.region_code = b.region_code
                INNER JOIN tbl_userlevel c
                ON a.user_level = c.userlevel_id '.$where.'
                ';


        $query = $this->db->query($sql);
        $result = $query->result();
        return $result;

    }

    public function insertUserinfo($firstname,$middlename,$surname,$extname, $position,$designation,$contact,$username,$password,$email,$userlevel,$region,$activate)
    {
        //from familyinfo/addfamilyinfo else
        $this->db->trans_begin();
        //insert the form data into database
//            $this->db->insert('tbl_family_information');
        $this->db->query('INSERT INTO tbl_user(firstname,middlename,surname,extensionname,position,designation,contact_no,username,password,email,user_level,region_code,activated)
                          VALUES
                          (
                          "'.$firstname.'",
						  "'.$middlename.'",
						  "'.$surname.'",
						  "'.$extname.'",
						  "'.$position.'",
						  "'.$designation.'",
						  "'.$contact.'",
						  "'.$username.'",
						  "'.$password.'",
						  "'.$email.'",
						  "'.$userlevel.'",
						  "'.$region.'",
						  "'.$activate.'"
                          )');

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

    public function getuserid($uid = 0)
    {
        $query = $this->db->get_where('tbl_user',array('uid'=>$uid));
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

    public function updateUserinfo($firstname,$middlename,$surname,$extname, $position,$designation,$contact,$username,$email,$userlevel,$region,$activate,$uid,$lock)
    {
        $this->db->trans_begin();
        $this->db->query('UPDATE tbl_user SET
                              firstname="'.$firstname.'",
                              middlename="'.$middlename.'",
                              surname="'.$surname.'",
                              extensionname="'.$extname.'",
                              position="'.$position.'",
                              designation="'.$designation.'",
                              contact_no="'.$contact.'",
                              username="'.$username.'",
                              email="'.$email.'",
                              user_level="'.$userlevel.'",
                              region_code="'.$region.'",
                              activated="'.$activate.'",
                              locked_status="'.$lock.'"

                              WHERE
                              uid = "'.$uid.'"
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


    public function get_fposition(){
        $get_fposition = "
        SELECT
          userlevelid,
          userlevelname
        FROM
          userlevels
        ORDER BY
          userlevelid
        ";

        return $this->db->query($get_fposition)->result();
    }
    public function get_regions() {
        $get_regions = "
        SELECT
          region_code,
          region_name
        FROM
          lib_regions
        ORDER BY
          region_code
        ";

        return $this->db->query($get_regions)->result();
    }

    public function deleteUserinfo($uid)
    {
        $this->db->trans_begin();

        $this->db->query('UPDATE tbl_user SET
                              activated="0"
                              WHERE
                              uid = "'.$uid.'"
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
    public function activateUserinfo($uid)
    {
        $this->db->trans_begin();

        $this->db->query('UPDATE tbl_user SET
                              activated="1"
                              WHERE
                              uid = "'.$uid.'"
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
    public function getUserLevel()
    {
        $sql = 'select userlevel_id, userlevel_name from tbl_userlevel where deleted = 0';
        $query = $this->db->query($sql);
        $result = $query->result();
        $this->db->close();
        return $result;

    }

}