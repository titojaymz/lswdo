<?php

class Certification_Model extends CI_Model
{
    public function getCertList(){
        /*$this->db->select('profile_id,certificate_no,date_issued,validity,month_valid, day_valid, year_valid');
        $this->db->order_by('profile_id','ASC');
        $query = $this->db->get_where('tbl_lswdo_certificate', array('profile_id' => '9'));*/
        /*return $query->result();*/
        $sql = 'SELECT ref_id, profile_id,certificate_no,date_issued,validity,month_valid, day_valid, year_valid
                FROM `tbl_lswdo_certificate`
                WHERE profile_id = 9;';
        $query = $this->db->query($sql);
        return $query->result_array();
    }

    public function getCertListByID($ref_id){
        /*$this->db->select('profile_id,certificate_no,date_issued,validity,month_valid, day_valid, year_valid');
        $this->db->order_by('profile_id','ASC');
        $query = $this->db->get_where('tbl_lswdo_certificate', array('profile_id' => '9'));*/
        /*return $query->result();*/
        $sql = 'SELECT ref_id, profile_id,certificate_no,date_issued,validity,month_valid, day_valid, year_valid
                FROM `tbl_lswdo_certificate`
                WHERE ref_id = '.$ref_id.';';
        $query = $this->db->query($sql);
        return $query->result_array();
    }

    public function getValidityByID($validityID){
        $this->db->select('validity_title');
        $this->db->order_by('validity_inyears','ASC');
        $query = $this->db->get_where('lib_validity', array('validity_id' => $validityID));
        /*return $query->row();*/
        return $query->result_array();
    }
    public function insertLswdoCertificate($profile_id,
                                           $certificate_no,
                                           $current_certificate,
                                           $date_issued,
                                           $validity,
                                           $month_valid,
                                           $day_valid,
                                           $year_valid,
                                           $created_by,
                                           $date_created,
                                           $modified_by,
                                           $date_modified,
                                           $DELETED){
        $this->db->trans_begin();
        $this->db->query('Insert into tbl_lswdo_certificate(profile_id,
                                                            certificate_no,
                                                            current_certificate,
                                                            date_issued,
                                                            validity,
                                                            month_valid,
                                                            day_valid,
                                                            year_valid,
                                                            created_by,
                                                            date_created,
                                                            modified_by,
                                                            date_modified,
                                                            DELETED)
                                                          VALUES(
                                                          "'.$profile_id.'",
                                                          "'.$certificate_no.'",
                                                          "'.$current_certificate.'",
                                                          "'.$date_issued.'",
                                                          "'.$validity.'",
                                                          "'.$month_valid.'",
                                                          "'.$day_valid.'",
                                                          "'.$year_valid.'",
                                                          "'.$created_by.'",
                                                          '.$date_created.',
                                                          "'.$modified_by.'",
                                                          "'.$date_modified.'",
                                                          "'.$DELETED.'"
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

    public function updateLswdoCertificate($ref_id,
                                           $certificate_no,
                                           $current_certificate,
                                           $date_issued,
                                           $validity,
                                           $month_valid,
                                           $day_valid,
                                           $year_valid,
                                           $modified_by,
                                           $DELETED){

        $this->db->trans_begin();

        $this->db->query('Update tbl_lswdo_certificate SET
					certificate_no = "'.$certificate_no.'",
					current_certificate = "'.$current_certificate.'",
					date_issued = "'.$date_issued.'",
					validity = "'.$validity.'",
					month_valid = "'.$month_valid.'",
					day_valid = "'.$day_valid.'",
					year_valid = "'.$year_valid.'",
					modified_by = "'.$modified_by.'",
					date_modified = now(),
					DELETED = "'.$DELETED.'"
					WHERE
					ref_id = "'.$ref_id.'"
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
        $this->db->insert('tbl_lswdo_certificate', $data);
    }


}