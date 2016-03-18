<?php

class Monitoring_model extends CI_Model
{
    public function getMonitoringList(){
       /* $this->db->select('ref_id,profile_id,visit_count,visit_date,remarks');
        $this->db->order_by('visit_date','ASC');
        $query = $this->db->get_where('tbl_lswdo_monitoring', array('profile_id' => '9'));*/

        $sql = 'SELECT ref_id,profile_id,visit_count,visit_date,remarks
                FROM `tbl_lswdo_monitoring`
                WHERE profile_id = 9;';
        $query = $this->db->query($sql);
        return $query->result_array();
    }
    public function getMonitoringListByRefID($ref_cert_id){
        /* $this->db->select('ref_id,profile_id,visit_count,visit_date,remarks');
         $this->db->order_by('visit_date','ASC');
         $query = $this->db->get_where('tbl_lswdo_monitoring', array('profile_id' => '9'));*/

        $sql = 'SELECT ref_id,ref_cert_id,profile_id,visit_count,visit_date,remarks
                FROM `tbl_lswdo_monitoring`
                WHERE ref_cert_id = '.$ref_cert_id.';';
        $query = $this->db->query($sql);
        return $query->result_array();
    }


    public function getDataByProfileID(){
        $this->db->select('profile_id,application_type_id,lgu_type_id,swdo_name');
        $this->db->order_by('profile_id','ASC');
        $query = $this->db->get_where('tbl_lswdo', array('profile_id' => '9'));
        return $query->row();
    }

    public function getVisitCount(){
        $sql = 'SELECT visit_id, visit_count
                FROM `lib_visit_count`;';
        $query = $this->db->query($sql);
        //return  $query->result();
        //return  $query->row();
        return $query->result_array();
    }

    public function getVisitCountByID($visit_id){
        $sql = 'SELECT visit_id, visit_count
                FROM `lib_visit_count`
                WHERE visit_id = '.$visit_id.';';
        $query = $this->db->query($sql);
        //return  $query->result();
        //return  $query->row();
        return $query->result_array();
    }

    public function getValidity(){
        $sql = 'SELECT validity_id, validity_inyears, validity_title
                FROM `lib_validity`;';
        $query = $this->db->query($sql);
        //return  $query->result();
        //return  $query->row();
        return $query->result_array();
    }



    public function insertLswdoMonitoring($profile_id, $visit_count, $visit_date,$remarks,$created_by,$date_created,$modified_by,$date_modified,$deleted){
        $this->db->trans_begin();
        $this->db->query('Insert into tbl_lswdo_monitoring(profile_id, visit_count, visit_date,remarks,created_by,date_created,modified_by,date_modified,deleted)
                          VALUES(
                          "'.$profile_id.'",
                          "'.$visit_count.'",
                          "'.$visit_date.'",
                          "'.$remarks.'",
                          "'.$created_by.'",
                          '.$date_created.',
                          "'.$modified_by.'",
                          "'.$date_modified.'",
                          "'.$deleted.'"
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

    public function updateLswdoMonitoring($ref_id,$profile_id, $visit_count, $visit_date,$remarks,$modified_by,$date_modified,$deleted){

        $this->db->trans_begin();

        $this->db->query('Update tbl_lswdo_monitoring SET
					visit_count = "'.$visit_count.'",
					visit_date = "'.$visit_date.'",
					remarks = "'.$remarks.'",
					modified_by = "'.$modified_by.'",
					date_modified = now()
					WHERE
					ref_id = "'.$ref_id.'"
					AND
					profile_id = "'.$profile_id.'"
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

    function form_insert($data)
    {
        $this->db->insert('tbl_lswdo_monitoring', $data);
    }


}