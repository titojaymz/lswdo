<?php

class Validity_model extends CI_Model
{
    public function getValidity(){
        $sql = 'SELECT validity_id, validity_inyears, validity_title
                FROM `lib_validity`;';
        $query = $this->db->query($sql);
        //return  $query->result();
        //return  $query->row();
        return $query->result_array();
    }




}