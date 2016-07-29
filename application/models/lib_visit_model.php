<?php
/**
 * Created by PhpStorm.
 * User: ljesaclayan
 * Date: 7/28/2016
 * Time: 1:56 PM
 */

class lib_visit_model extends CI_Model
{
    //Visit Count Start
    public function getVisitCount()
    {
        $sql = 'SELECT visit_id, visit_count FROM lib_visit_count';
        $query = $this->db->query($sql);
        return $query->result();
    }
    public function insertVisitCount($vcount){
        $this->db->trans_begin();
        $this->db->query('insert into lib_visit_count (visit_count) VALUES ("'.$vcount.'")');
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
    public function getVisitCountbyID($vid)
    {
        $sql = 'SELECT visit_id, visit_count FROM lib_visit_count where visit_id = '.$vid.'';
        $query = $this->db->query($sql);
        return $query->row();
    }
    public function updateVisitCount($vcount,$vid){
        $this->db->trans_begin();
        $this->db->query('UPDATE lib_visit_count SET visit_count = "'.$vcount.'" where visit_id = '.$vid.'');
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
    //Visit Count End

    //Visit Status Start
    public function getVisitStat()
    {
        $sql = 'SELECT status_id, status_name FROM lib_status';
        $query = $this->db->query($sql);
        return $query->result();
    }

    public function insertVisitStatus($vstat){
        $this->db->trans_begin();
        $this->db->query('insert into lib_status (status_name) VALUES ("'.$vstat.'")');
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
    public function getVisitStatbyID($sid)
    {
        $sql = 'SELECT status_id, status_name FROM lib_status where status_id = '.$sid.'';
        $query = $this->db->query($sql);
        return $query->row();
    }
    public function updateVisitStatus($vstat,$sid){
        $this->db->trans_begin();
        $this->db->query('UPDATE lib_status SET status_name = "'.$vstat.'" where status_id = '.$sid.'');
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
    //Visit Status End
}