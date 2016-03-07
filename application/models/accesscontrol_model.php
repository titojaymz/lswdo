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


    public function get_users_list($user_region)
    {
        if ($user_region != 0) {
            $sql = 'select t1.uid, t1.full_name, t1.username, t1.email, t2.region_name, t1.activated, t3.userlevelname from users t1 inner join userlevels t3 on t1.access_level = t3.userlevelid inner join lib_region t2 on t1.region_code = t2.region_code where t2.region_code = "'.$user_region.'"';
        } else {
            $sql = 'select t1.uid, t1.full_name, t1.username, t1.email, t2.region_name, t1.activated, t3.userlevelname from users t1 inner join userlevels t3 on t1.access_level = t3.userlevelid inner join lib_region t2 on t1.region_code = t2.region_code';

        }
        $query = $this->db->query($sql);
        $result = $query->result();
        return $result;

    }

    public function insertUserinfo($full_name,$email, $username,$pword,$userlevelid,$status,$regionlist)
    {
        //from familyinfo/addfamilyinfo else
        $this->db->trans_begin();
        //insert the form data into database
//            $this->db->insert('tbl_family_information');
        $this->db->query('INSERT INTO users(full_name,username,email,passwd,region_code,activated,access_level,date_created)
                          VALUES
                          (
                          "'.$full_name.'",
						  "'.$username.'",
						  "'.$email.'",
						  "'.$pword.'",
						  "'.$regionlist.'",
						  "'.$status.'",
						  "'.$userlevelid.'",
						  now()
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
        $query = $this->db->get_where('users',array('uid'=>$uid));
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

    public function updateUserinfo($uid,$full_name,$email, $username,$pword,$userlevelid,$status,$regionlist,$myid)
    {
        $this->db->trans_begin();
        $this->db->query('UPDATE users SET
                              full_name="'.$full_name.'",
							  username="'.$username.'",
							  email="'.$email.'",
							  passwd="'.$pword.'",
                              region_code="'.$regionlist.'",
                              activated="'.$status.'",
                              access_level="'.$userlevelid.'",
                              last_modified=now(),
                              last_modified_by="'.$myid.'"

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
          lib_region
        WHERE
          region_code <> '000000000'
        ORDER BY
          region_code
        ";

        return $this->db->query($get_regions)->result();
    }

    public function deleteUserinfo($uid = 0)
    {
        $this->db->trans_begin();

        $this->db->query('UPDATE users SET
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


}