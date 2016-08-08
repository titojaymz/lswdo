<?php
/**
 * Created by PhpStorm.
 * User: ljesaclayan
 * Date: 7/22/2016
 * Time: 1:53 PM
 */

class lib_psbriders_model extends CI_Model
{

    public function getPSBmain()
    {
        $sql = 'SELECT psbrider_main_category_id, psbrider_main_category_title FROM lib_psbrider_main_category';
        $query = $this->db->query($sql);
        return $query->result();
    }

    public function getPSBmainSub()
    {
        $sql = 'SELECT psbrider_sub_category_id, psbrider_main_category_id, psbrider_sub_category_title FROM lib_psbrider_sub_category';
        $query = $this->db->query($sql);
        return $query->result();
    }
    public function getPSBmainSubEdit($psbrider_sub_category_id)
    {
        $sql = 'SELECT psbrider_main_category_id, psbrider_sub_category_title FROM lib_psbrider_sub_category where psbrider_sub_category_id ='.$psbrider_sub_category_id.'';
        $query = $this->db->query($sql);
        return $query->row();
    }
    public function getPSBsubByMain($main)
    {
        $sql = 'select psbrider_sub_category_id, psbrider_sub_category_title from lib_psbrider_sub_category where psbrider_main_category_id = "'.$main.'";';
        $query = $this->db->query($sql);
        return $query->result();
    }
    public function getPSBmainTitle($main)
    {
        $sql = 'SELECT psbrider_main_category_id, psbrider_main_category_title FROM lib_psbrider_main_category where psbrider_main_category_id = "'.$main.'"';
        $query = $this->db->query($sql);
        return $query->row();
    }
    public function insertPSBRiders($main, $sub){
        $this->db->trans_begin();
        $this->db->query('insert into lib_psbrider_sub_category (psbrider_main_category_id, psbrider_sub_category_title)
                          VALUES (
                          "'.$main.'",
                          "'.$sub.'"
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

    public function updatePSBRiders($main, $sub,$subID){
        $this->db->trans_begin();
        $this->db->query('UPDATE lib_psbrider_sub_category SET
                          psbrider_main_category_id = '.$main.',
                          psbrider_sub_category_title = "'.$sub.'" where
                          psbrider_sub_category_id = '.$subID.';');
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