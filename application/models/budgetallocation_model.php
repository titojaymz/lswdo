<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Created by PhpStorm.
 * User: mglveniegas
 * Date: 3/30/2016
 * Time: 4:17 PM
 */
class budgetallocation_model extends CI_Model {


    public function record_count() { //pagination query
        return $this->db->count_all("tbl_lswdo_budget");
    }

    public function getBudgetAllocation()
    {
        $query = $this->db->get_where('tbl_lswdo_budget',array('DELETED' => 0));
        if ($query->num_rows() > 0){
            return $query->result();
        } else {
            return FALSE;
        }
        $this->db->close();
    }


    public function getBudgetAllocationByID($id = 0)
    {
        $query = $this->db->get_where('tbl_lswdo_budget',array('profile_id'=>$id,'DELETED'=>0));
        if ($query->num_rows() > 0){
            return $query->row();
        } else {
            return FALSE;
        }
        $this->db->close();
    }

    public function insertBudgetAllocation($profile_id,$sector_id,$year_indicated,$budget_present_year,$utilization,$no_bene_served,$no_target_bene)
    {
        $this->db->trans_begin();

        $this->db->query('INSERT INTO tbl_lswdo_budget(profile_id,sector_id,year_indicated,budget_present_year,utilization,no_bene_served,no_target_bene,date_created)
                          VALUES
                          (
                          1,
                          "'.$sector_id.'",
                          "'.$year_indicated.'",
                          "'.$budget_present_year.'",
                          "'.$utilization.'",
                          "'.$no_bene_served.'",
                          "'.$no_target_bene.'",
                          Now()
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

    public function getLSWDOprofile($id){
        $this->db->select('profile_id');
        $query = $this->db->get_where('tbl_lswdo', array('profile_id' => $id));
        return $query->row();
    }

    public function updateBudgetAllocation($id,$sector_id,$year_indicated,$budget_present_year,$utilization,$no_bene_served,$no_target_bene)
    {
        $this->db->trans_begin();

        $this->db->query('UPDATE tbl_lswdo SET
                          sector_id="'.$sector_id.'",
                          year_indicated="'.$year_indicated.'",
                          budget_present_year="'.$budget_present_year.'",
                          utilization="'.$utilization.'",
                          no_bene_served="'.$no_bene_served.'",
                          no_target_bene="'.$no_target_bene.'",
                          date_modified=Now()
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

    public function deleteBudgetAllocation($id = 0)
    {
        $this->db->trans_begin();

        $this->db->query('UPDATE tbl_lswdo_budget SET
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

    public function get_sector(){
        $get_Sector = "
        SELECT
          sector_id,
          sector_name
        FROM
          lib_sector
        WHERE
          sector_id > '0'
        ORDER BY
          sector_id
        ";

        return $this->db->query($get_Sector)->result();
    }


}