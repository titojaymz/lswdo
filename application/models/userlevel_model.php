<?php
/**
 * Created by PhpStorm.
 * User: ljesaclayan
 * Date: 5/18/2016
 * Time: 9:36 AM
 */

class userlevel_model extends CI_Model
{
    public function getUserLevel(){
        $this->db->select('userlevel_id,userlevel_name,userlevel_desc');
        $query = $this->db->get_where('tbl_userlevel', array('DELETED' => 0));
        $this->db->close();
        return $query->result();
    }
    public function getUserLevelperID($id){
        $this->db->select('userlevel_id,userlevel_name,userlevel_desc');
        $query = $this->db->get_where('tbl_userlevel', array('userlevel_id' => $id,'DELETED' => 0));
        $this->db->close();
        return $query->row();
    }
    public function insertUserLevel($userlevel_id,$userlevel_name,$userlevel_desc,$userID){
        $this->db->trans_begin();
        $this->db->query('insert into tbl_userlevel (userlevel_id,userlevel_name, userlevel_desc,created_by,created_date,deleted)
                          VALUES (
                          "'.$userlevel_id.'",
                          "'.$userlevel_name.'",
                          "'.$userlevel_desc.'",
                          "'.$userID.'",
                          NOW(),
                          0
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
    public function updateUserLevel($userlevel_id,$userlevel_name,$userlevel_desc,$userID,$currentuserlevel_ID){
        $this->db->trans_begin();
        $this->db->query('UPDATE tbl_userlevel SET
                          userlevel_id = "'.$userlevel_id.'",
                          userlevel_name = "'.$userlevel_name.'",
                          userlevel_desc = "'.$userlevel_desc.'",
                          modified_by = "'.$userID.'",
                          modified_date = NOW()
                          WHERE
                          userlevel_id = "'.$currentuserlevel_ID.'"
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

    public function deleteUserLevel($userlevel_id){
        $this->db->trans_begin();
        $this->db->query('UPDATE tbl_userlevel SET
                          deleted = 1
                          WHERE
                          userlevel_id = "'.$userlevel_id.'"
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