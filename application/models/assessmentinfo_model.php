<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Created by JOSEF FRIEDRICH S. BALDO
 * Date Time: 10/17/15 11:56 PM
 */
class assessmentinfo_model extends CI_Model {

    public function getAssessmentinfo()
    {
        $query = $this->db->get_where('tbl_lswdo',array('DELETED' => 0));
        if ($query->num_rows() > 0){
            return $query->result();
        } else {
            return FALSE;
        }
        $this->db->close();
    }

    public function getAssessmentinfoByID($id = 0)
    {
        $query = $this->db->get_where('tbl_lswdo',array('profile_id'=>$id,'DELETED'=>0));
        if ($query->num_rows() > 0){
            return $query->row();
        } else {
            return FALSE;
        }
        $this->db->close();
    }

    public function insertAssessmentinfo($application_type_id,$lgu_type_id,$region_code,$prov_code,$city_code,$brgy_code,$street_address,$swdo_name,$contact_no,$email,$website,$total_ira,$total_budget_lswdo)
    {
        $this->db->trans_begin();

        $this->db->query('INSERT INTO tbl_lswdo(application_type_id,lgu_type_id,region_code,prov_code,city_code,brgy_code,street_address,swdo_name,contact_no,email,website,total_ira,total_budget_lswdo)
                          VALUES
                          (
                          "'.$application_type_id.'",
                          "'.$lgu_type_id.'",
                          "'.$region_code.'",
                          "'.$prov_code.'",
                          "'.$city_code.'",
                          "'.$brgy_code.'",
                          "'.$street_address.'",
                          "'.$swdo_name.'",
                          "'.$contact_no.'",
                          "'.$email.'",
                          "'.$website.'",
                          "'.$total_ira.'",
                          "'.$total_budget_lswdo.'"
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
    /*
     get application type
    public function getApplicationtype($id = 0)
    {
        $query = $this->db->get_where('lib_application_type',array('application_type_id'=>$id,'DELETED'=>0));
        if ($query->num_rows() > 0){
            return $query->row();
          } else {
            return FALSE;
        }
        $this->db->close();
    }

    public function get_application_type(){
        $get_application_type = "
        SELECT
          application_type_id,
          application_type_name
        FROM
          lib_application_type
        WHERE
          application_type_id > '0'
        ORDER BY
          application_type_id
        ";

        return $this->db->query($get_application_type)->result();
    }
*/
    public function updateAssessmentinfo($id,$application_type_id,$lgu_type_id,$region_code,$prov_code,$city_code,$brgy_code,$street_address,$swdo_name,$contact_no,$email,$website,$total_ira,$total_budget_lswdo)
    {
        $this->db->trans_begin();

        $this->db->query('UPDATE tbl_lswdo SET
                          application_type_id="'.$application_type_id.'",
                          lgu_type_id="'.$lgu_type_id.'",
                          region_code="'.$region_code.'",
                          prov_code="'.$prov_code.'",
                          city_code="'.$city_code.'",
                          brgy_code="'.$brgy_code.'",
                          street_address="'.$street_address.'",
                          swdo_name="'.$swdo_name.'",
                          contact_no="'.$contact_no.'",
                          email="'.$email.'",
                          website="'.$website.'",
                          total_ira="'.$total_ira.'",
                          total_budget_lswdo="'.$total_budget_lswdo.'"

                          WHERE
                          profile_id = "'.$id.'"
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

    public function deleteAssessmentinfo($id = 0)
    {
        $this->db->trans_begin();

        $this->db->query('UPDATE tbl_lswdo SET
                          DELETED="1"
                          WHERE
                          profile_id = "'.$id.'"
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
//select
    public function Lib_getAllApplicationtype($id = 0)
    {
        $query = $this->db->get_where('lib_application_type',array('application_type_id'=>$id,'DELETED' => 0));
        if ($query->num_rows() > 0){
            return $query->result();
        } else {
            return FALSE;
        }
        $this->db->close();
    }

    public function addAssessmentinfoApplicationtype($application_type_id = NULL)
    {
        $this->db->trans_begin();

        $this->db->query('INSERT INTO tbl_lswdo(application_type_id)
                           VALUES
                           ("'.$application_type_id.'")
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

    public function getSubjectName($id = 0)
    {
        $query = $this->db->get_where('lib_application_type',array('application_type_id'=>$id,'DELETED'=>0));
        if ($query->num_rows() > 0){
            $rowDetails = $query->row();
            return $rowDetails->application_type_name;
        } else {
            return FALSE;
        }
        $this->db->close();
    }


}