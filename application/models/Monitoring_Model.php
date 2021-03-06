<?php

class Monitoring_Model extends CI_Model
{
    /*public function getMonitoringList($profile_id){

        $sql = 'SELECT ref_id,profile_id,visit_count,visit_date,remarks
                FROM `tbl_lswdo_monitoring`
                WHERE profile_id = '.$profile_id.';';
        $query = $this->db->query($sql);
        return $query->result_array();
    }*/
    public function getMonitoringListByRefID($profile_id){
        /* $this->db->select('ref_id,profile_id,visit_count,visit_date,remarks');
         $this->db->order_by('visit_date','ASC');
         $query = $this->db->get_where('tbl_lswdo_monitoring', array('profile_id' => '9'));*/

        $sql = 'SELECT ref_id,ref_cert_id,profile_id,visit_count,visit_date,remarks,visit_status
                FROM `tbl_lswdo_monitoring`
                WHERE profile_id = "'.$profile_id.'";';
        $query = $this->db->query($sql);
        return $query->result_array();
    }


    public function getDataByProfileID($profile_id){
        $sql = 'SELECT profile_id,application_type_id,lgu_type_id,swdo_name
                FROM `tbl_lswdo`
                WHERE profile_id = "'.$profile_id.'";';
        $query = $this->db->query($sql);
        //$this->db->select('profile_id,application_type_id,lgu_type_id,swdo_name');
        //$this->db->order_by('profile_id','ASC');
        //$query = $this->db->get_where('tbl_lswdo', array('profile_id' => $profile_id));
        return $query->result_array();
    }

    /*public function getVisitCount(){
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
    }*/

    /*public function getValidity(){
        $sql = 'SELECT validity_id, validity_inyears, validity_title
                FROM `lib_validity`;';
        $query = $this->db->query($sql);
        //return  $query->result();
        //return  $query->row();
        return $query->result_array();
    }*/

    /*public function getValidityByID($validity_id){
        $sql = 'SELECT validity_id, validity_inyears, validity_title
                FROM `lib_validity`
                where validity_id = '.$validity_id.';';
        $query = $this->db->query($sql);
        //return  $query->result();
        //return  $query->row();
        return $query->result_array();
    }*/



    public function insertLswdoMonitoring($profile_id,$ref_cert_id, $visit_count, $visit_date,$visit_status,$remarks,$created_by,$date_created,$modified_by,$date_modified,$deleted){
        $this->db->trans_begin();
        $this->db->query('Insert into tbl_lswdo_monitoring(profile_id,ref_cert_id, visit_count, visit_date,visit_status,remarks,created_by,date_created,modified_by,date_modified,deleted)
                          VALUES(
                          "'.$profile_id.'",
                          "'.$ref_cert_id.'",
                          "'.$visit_count.'",
                          "'.$visit_date.'",
                          '.$visit_status.',
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

       {   $insert_id = $this->db->insert_id();
           $this->db->trans_commit();

           //return TRUE;
           return $insert_id;
       }
        $this->db->close();
    }

    public function updateLswdoMonitoring($ref_id,$profile_id, $visit_count, $visit_date,$visit_status,$remarks,$modified_by,$deleted){

        $this->db->trans_begin();

        $this->db->query('Update tbl_lswdo_monitoring SET
					visit_count = "'.$visit_count.'",
					visit_date = "'.$visit_date.'",
					visit_status = "'.$visit_status.'",
					remarks = "'.$remarks.'",
					modified_by = "'.$modified_by.'",
					date_modified = now(),
					deleted = "'.$deleted.'"
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
//Lerrie Boy !!!!
    public function getStatus(){

        $sql = 'SELECT status_id, status_name
                FROM `lib_status`;';
        $query = $this->db->query($sql);
        return $query->result_array();
    }
    public function getStatusName($statID){
        /* $this->db->select('ref_id,profile_id,visit_count,visit_date,remarks');
         $this->db->order_by('visit_date','ASC');
         $query = $this->db->get_where('tbl_lswdo_monitoring', array('profile_id' => '9'));*/

        $sql = 'SELECT status_name
                FROM `lib_status`
                WHERE status_id = "'.$statID.'";';
        $query = $this->db->query($sql);
        return $query->row();
    }

    public function getMonitoringList($profile_id,$ref_id){
        /* $this->db->select('ref_id,profile_id,visit_count,visit_date,remarks');
         $this->db->order_by('visit_date','ASC');
         $query = $this->db->get_where('tbl_lswdo_monitoring', array('profile_id' => '9'));*/

        $sql = 'SELECT ref_id,ref_cert_id,profile_id,visit_count,visit_date,remarks,visit_status
                FROM `tbl_lswdo_monitoring`
                WHERE profile_id = "'.$profile_id.'" and ref_id = '.$ref_id.';';
        $query = $this->db->query($sql);
        return $query->row();
    }
    public function countVisits($profile_id){
        /* $this->db->select('ref_id,profile_id,visit_count,visit_date,remarks');
         $this->db->order_by('visit_date','ASC');
         $query = $this->db->get_where('tbl_lswdo_monitoring', array('profile_id' => '9'));*/

        $sql = 'select count(visit_count) as countVisit from tbl_lswdo_monitoring
                WHERE profile_id = "'.$profile_id.'";';
        $query = $this->db->query($sql);
        return $query->row();
    }

//End Lerrie

}