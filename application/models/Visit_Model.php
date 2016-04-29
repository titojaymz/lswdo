<?php

class Visit_model extends CI_Model
{

    public function getVisitCount(){
        $sql = 'SELECT visit_id, visit_count
                FROM `lib_visit_count`;';
        $query = $this->db->query($sql);
        //return  $query->result();
        //return  $query->row();
        return $query->result_array();
    }

    public function getVisitCountByID($visit_id)
    {
        $sql = 'SELECT visit_id, visit_count
                FROM `lib_visit_count`
                WHERE visit_id = ' . $visit_id . ';';
        $query = $this->db->query($sql);
        //return  $query->result();
        //return  $query->row();
        return $query->result_array();
    }


}