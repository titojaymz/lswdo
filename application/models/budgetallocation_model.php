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

    public function getBudgetAllocation($profID)
    {

        $sql = 'SELECT a.profile_id,c.sector_id,c.sector_name,b.year_indicated,b.budget_present_year,b.budget_previous_year,b.utilization,b.no_bene_served,b.no_target_bene,d.prov_name,e.city_name FROM
                tbl_lswdo AS a
                Left Join tbl_lswdo_budget AS b ON a.profile_id = b.profile_id
                Left Join lib_sector AS c ON b.sector_id = c.sector_id
                Left Join lib_provinces AS d ON a.prov_code = d.prov_code
                Left Join lib_cities AS e ON a.city_code = e.city_code
                WHERE b.DELETED = 0 AND a.profile_id = '.$profID.';';
        $query = $this->db->query($sql);
        $result = $query->result();
        return $result;
    }

    public function getBudgetAllocationByID($id,$sectorID)
    {
        $sql = 'SELECT a.profile_id,c.sector_id,c.sector_name,b.year_indicated,b.budget_present_year,b.budget_previous_year,b.utilization,b.no_bene_served,b.no_target_bene FROM tbl_lswdo a
                LEFT JOIN tbl_lswdo_budget b ON a.profile_id=b.profile_id
                LEFT JOIN lib_sector c ON b.sector_id = c.sector_id
                WHERE b.DELETED = 0 AND a.profile_id = '.$id.' AND c.sector_id = '.$sectorID.';';
        $query = $this->db->query($sql);
        $result = $query->row();
        return $result;
    }

    public function insertBudgetAllocation($profID, $sector_id, $year_indicated, $budget_previous_year, $budget_present_year, $utilization, $no_bene_served, $no_target_bene, $created_by, $date_created)
    {

        $this->db->trans_begin();

        $this->db->query('INSERT INTO tbl_lswdo_budget(profile_id, sector_id, year_indicated, budget_previous_year,budget_present_year, utilization, no_bene_served, no_target_bene, created_by, date_created)
                          VALUES
                          (
                          "' . $profID . '",
                          "' . $sector_id . '",
                          "' . $year_indicated . '",
                          "'.$budget_previous_year.'",
                          "' . $budget_present_year . '",
                          "' . $utilization . '",
                          "' . $no_bene_served . '",
                          "' . $no_target_bene . '",
                          "' . $created_by . '",
                          Now()
                          )');

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            return FALSE;
        } else {
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

    public function updateBudgetAllocation($id,$sector_id,$year_indicated,$budget_previous_year,$budget_present_year,$utilization,$no_bene_served,$no_target_bene,$prevSectorID,$modified_by, $date_modified)
    {
        $this->db->trans_begin();

        $this->db->query('UPDATE tbl_lswdo_budget SET
                          sector_id="'.$sector_id.'",
                          year_indicated="'.$year_indicated.'",
                          budget_previous_year="'.$budget_previous_year.'",
                          budget_present_year="'.$budget_present_year.'",
                          utilization="'.$utilization.'",
                          no_bene_served="'.$no_bene_served.'",
                          no_target_bene="'.$no_target_bene.'",
                          date_modified=Now()
                          WHERE
                          profile_id = "'.$id.'"
                          AND sector_id = '.$prevSectorID.'
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
    public function checkDuplicate($profID,$sectorID)
    {
        $sql = 'select count(profile_id) as countProf
                From tbl_lswdo_budget
                where profile_id = '.$profID.'
                and sector_id = '.$sectorID;
        $query = $this->db->query($sql);
        $result = $query->row();
        return $result;
    }
    public function sectorName($sectorID)
    {
        $sql = 'select sector_name
                From lib_sector
                where sector_id = '.$sectorID;
        $query = $this->db->query($sql);
        $result = $query->row();
        return $result;
    }

}