<?php

class PSBRider_Model extends CI_Model
{
    public function getPSBMainCategory(){

        $sql = 'SELECT
                psbrider_main_category_id,
                psbrider_main_category_title
                FROM `lib_psbrider_main_category`
                ;';
        $query = $this->db->query($sql);
        return $query->result_array();
    }

    public function getPSBSubCategory($psbrider_main_category_id){
        /* $this->db->select('ref_id,profile_id,visit_count,visit_date,remarks');
         $this->db->order_by('visit_date','ASC');
         $query = $this->db->get_where('tbl_lswdo_monitoring', array('profile_id' => '9'));*/

        $sql = 'SELECT
                psbrider_sub_category_id,
                psbrider_main_category_id,
                psbrider_sub_category_title
                FROM `lib_psbrider_sub_category`
                WHERE psbrider_main_category_id = '.$psbrider_main_category_id.';';
        $query = $this->db->query($sql);
        return $query->result_array();
    }

    public function getPSBSubCategoryEdit($psbrider_sub_category_id){
        /* $this->db->select('ref_id,profile_id,visit_count,visit_date,remarks');
         $this->db->order_by('visit_date','ASC');
         $query = $this->db->get_where('tbl_lswdo_monitoring', array('profile_id' => '9'));*/

        $sql = 'SELECT
                psbrider_sub_category_id,
                psbrider_main_category_id,
                psbrider_sub_category_title
                FROM `lib_psbrider_sub_category`
                WHERE psbrider_sub_category_id = '.$psbrider_sub_category_id.';';
        $query = $this->db->query($sql);
        return $query->result_array();
    }

    public function getPSBRiderAnswer($profile_id,$ref_id){
        /* $this->db->select('ref_id,profile_id,visit_count,visit_date,remarks');
         $this->db->order_by('visit_date','ASC');
         $query = $this->db->get_where('tbl_lswdo_monitoring', array('profile_id' => '9'));*/

        $sql = 'SELECT
                psbrider_answer_id,
                ref_id,
                profile_id,
                psbrider_main_category_id,
                psbrider_main_category_title,
                psbrider_sub_category_id,
                psbrider_sub_category_title,
                psbrider_answer,
                psbrider_indicative_reason
                FROM `tbl_psbrider_answers`
                WHERE profile_id = '.$profile_id . '
                AND ref_id = '.$ref_id.'
                AND psbrider_answer = 1 ;';

        $query = $this->db->query($sql);
        return $query->result_array();
    }




    public function insertPSBRiderQsAns($ref_id,
                                        $profile_id,
                                        $psbrider_main_category_id,
                                        $psbrider_main_category_title,
                                        $psbrider_sub_category_id,
                                        $psbrider_sub_category_title,
                                        $psbrider_indicative_reason,
                                        $psbrider_answer){
        $this->db->trans_begin();
        $this->db->query('INSERT INTO tbl_psbrider_answers(ref_id,
                        profile_id,
                        psbrider_main_category_id,
                        psbrider_main_category_title,
                        psbrider_sub_category_id,
                        psbrider_sub_category_title,
                        psbrider_indicative_reason,
                        psbrider_answer
                        )
                          VALUES(
                          "'.$ref_id.'",
                          "'.$profile_id.'",
                          "'.$psbrider_main_category_id.'",
                          "'.$psbrider_main_category_title.'",
                          "'.$psbrider_sub_category_id.'",
                          "'.$psbrider_sub_category_title.'",
                          "'.$psbrider_indicative_reason.'",
                          "'.$psbrider_answer.'"
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

    /*
    public function updateLswdoMonitoring($ref_id,$profile_id, $visit_count, $visit_date,$remarks,$modified_by,$deleted){

        $this->db->trans_begin();

        $this->db->query('Update tbl_lswdo_monitoring SET
					visit_count = "'.$visit_count.'",
					visit_date = "'.$visit_date.'",
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
    }*/

    function form_insert($data)
    {
        $this->db->insert('tbl_lswdo_monitoring', $data);
    }


}