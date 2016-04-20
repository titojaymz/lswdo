<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Created by PhpStorm
 * User: mglveniegas
 *
 */
class assessmentinfo_model extends CI_Model
{


    public function record_count()
    { //pagination query
        return $this->db->count_all("tbl_lswdo");
    }

    public function getAssessmentinfo()
    {
        $sql = 'SELECT a.profile_id,a.swdo_name,c.application_type_name,b.lgu_type_name,total_ira,total_budget_lswdo
                FROM tbl_lswdo a
                INNER join lib_lgu_type b on a.lgu_type_id = b.lgu_type_id
                INNER join lib_application_type c on a.application_type_id = c.application_type_id
                WHERE a.deleted = 0';
        $query = $this->db->query($sql);
        $result = $query->result();
        return $result;
    }


    public function getAssessmentinfoByID($id = 0)
    {

        $sql = 'SELECT * FROM
tbl_lswdo AS a
Inner Join lib_lgu_type AS b ON a.lgu_type_id = b.lgu_type_id
Inner Join lib_application_type AS c ON a.application_type_id = c.application_type_id
Inner Join lib_regions ON a.region_code = lib_regions.region_code
Inner Join lib_provinces ON a.prov_code = lib_provinces.prov_code
Inner Join lib_cities ON a.city_code = lib_cities.city_code
Inner Join tbl_lswdo_budget ON a.profile_id = tbl_lswdo_budget.profile_id
Inner Join lib_sector ON tbl_lswdo_budget.sector_id = lib_sector.sector_id
WHERE a.deleted = 0 and a.profile_id="' . $id . '"';
        $query = $this->db->query($sql);
        $result = $query->row();
        return $result;


    }


    public function insertAssessmentinfo($application_type_id, $lgu_type_id, $regionlist, $provlist, $citylist, $office_address, $swdo_name, $designation, $contact_no, $email, $website, $total_ira, $total_budget_lswdo, $created_by, $date_created)
    {
        if ($provlist == 0) {
            $provlist = null;
        }
        if ($citylist == 0) {
            $citylist = null;
        }
        $this->db->trans_begin();

        $this->db->query('INSERT INTO tbl_lswdo(application_type_id,lgu_type_id,region_code,prov_code,city_code,office_address,swdo_name,designation,contact_no,email,website,total_ira,total_budget_lswdo,created_by,date_created)
                          VALUES
                          (
                          "' . $application_type_id . '",
                          "' . $lgu_type_id . '",
                          "' . $regionlist . '",
                          "' . $provlist . '",
                          "' . $citylist . '",
                          "' . $office_address . '",
                          "' . $swdo_name . '",
                          "' . $designation . '",
                          "' . $contact_no . '",
                          "' . $email . '",
                          "' . $website . '",
                          "' . $total_ira . '",
                          "' . $total_budget_lswdo . '",
                          "' . $created_by . '",
                          Now()
                          )');

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            return FALSE;
        } else {
            $insert_id = $this->db->insert_id();
            $this->db->trans_commit();

            //return TRUE;
            return $insert_id;
        }
        $this->db->close();
    }


    public function insertBudgetAllocation($sector_id, $year_indicated,$budget_present_year, $utilization, $budget_previous_year, $no_bene_served, $no_target_bene, $created_by, $date_created)
    {
        $this->db->trans_begin();

        $this->db->query('INSERT INTO tbl_lswdo_budget(sector_id,year_indicated,budget_present_year,utilization,budget_previous_year,no_bene_served,no_target_bene,created_by,date_created)
                          VALUES
                          (
                          "' . $sector_id . '",
                          "' . $year_indicated . '",
                          "' . $budget_present_year . '",
                          "' . $utilization . '",
                          "'.$budget_previous_year.'",
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


    public function updateAssessmentinfo($id, $application_type_id, $lgu_type_id, $regionlist, $provlist, $citylist, $office_address, $swdo_name, $designation, $contact_no, $email, $website, $total_ira, $total_budget_lswdo, $modified_by, $date_modified)
    {
        $this->db->trans_begin();

        $this->db->query('UPDATE tbl_lswdo SET
                          application_type_id="' . $application_type_id . '",
                          lgu_type_id="' . $lgu_type_id . '",
                          region_code="' . $regionlist . '",
                          prov_code="' . $provlist . '",
                          city_code="' . $citylist . '",
                          office_address="' . $office_address . '",
                          swdo_name="' . $swdo_name . '",
                          designation="' . $designation . '",
                          contact_no="' . $contact_no . '",
                          email="' . $email . '",
                          website="' . $website . '",
                          total_ira="' . $total_ira . '",
                          total_budget_lswdo="' . $total_budget_lswdo . '",
                          modified_by="' . $modified_by . '",
                          date_modified=Now()
                          WHERE
                          profile_id = "' . $id . '"
                          ');

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            return FALSE;
        } else {
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
                          profile_id = "' . $id . '"
                          ');

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            return FALSE;
        } else {
            $this->db->trans_commit();
            return TRUE;
        }
        $this->db->close();
    }


    public function Lib_getAllApplicationtype()
    {
        $query = $this->db->get_where('lib_application_type', array('DELETED' => 0));
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return FALSE;
        }
        $this->db->close();
    }


    public function Lib_getLGUtype()
    {
        $query = $this->db->get_where('lib_lgu_type', array('DELETED' => 0));
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return FALSE;
        }
        $this->db->close();
    }


    public function get_lgutype()
    {
        $get_lgutype = "
        SELECT
          lgu_type_id,
          lgu_type_name
        FROM
          lib_lgu_type
        WHERE
          DELETED = '0'
        ORDER BY
          lgu_type_id
        ";

        return $this->db->query($get_lgutype)->result();
    }


    public function get_regions()
    {
        $get_regions = "
        SELECT
          region_code,
          region_name
        FROM
          lib_regions
        WHERE
          region_code <> '000000000'
        ORDER BY
          region_code
        ";

        return $this->db->query($get_regions)->result();
    }


    public function get_provinces($region_code)
    {
        $get_prov = "
        SELECT
            prov_code,
            prov_name
        FROM
          lib_provinces
       WHERE
          region_code = ?
        ORDER BY
          prov_name
        ";

        return $this->db->query($get_prov, $region_code)->result();
    }


    public function get_cities($prov_code)
    {
        $get_cities = "
        SELECT
         city_code,
         city_name
        FROM
          lib_cities
        WHERE
          prov_code = ?
          and city_class = ''
        ORDER BY
          city_name
        ";

        return $this->db->query($get_cities, $prov_code)->result();
    }


    public function get_cities1($prov_code)
    {
        $get_cities = "
        SELECT
         city_code,
         city_name
        FROM
          lib_cities
        WHERE
          prov_code = ?
          and city_class = 'CC'
        ORDER BY
          city_name
        ";

        return $this->db->query($get_cities, $prov_code)->result();
    }


    public function get_brgy($city_code)
    {
        $get_brgy = "
        SELECT
            brgy_code,
            brgy_name
        FROM
          lib_brgy
        WHERE
          city_code = ?
        ORDER BY
          brgy_name
        ";

        return $this->db->query($get_brgy, $city_code)->result();
    }


    public function get_count_city($prov_code)
    {
        $get_countcity = "
        SELECT
         city_name,
          count(city_code) AS value_sum
        FROM
          lib_cities
        WHERE
         prov_code = ?
          and city_class = 'CC'
        ";

        return $this->db->query($get_countcity, $prov_code)->row();
    }


    public function get_count_muni($prov_code)
    {
        $get_count_muni = "
        SELECT
         city_name,
          count(city_code) AS value_sum
        FROM
          lib_cities
        WHERE
          prov_code = ?
          and city_class = ''
        ";

        return $this->db->query($get_count_muni, $prov_code)->row();
    }


    public function get_incomeclass($prov_code)
    {
        $get_incomeclass = "
        SELECT
          income_class
        FROM
          lib_cities
        WHERE
          prov_code = ?
        ";

        return $this->db->query($get_incomeclass, $prov_code)->row();
    }


    public function get_count_brgy($city_code)
    {
        $get_countbrgy = "
        SELECT
         lib_cities.city_name,
         lib_brgy.brgy_name,
         count(lib_brgy.brgy_code) AS no_brgy
        FROM
          lib_brgy
        INNER JOIN
         lib_cities on lib_brgy.city_code=lib_cities.city_code
        WHERE
         lib_cities.city_code = ?
        ";

        return $this->db->query($get_countbrgy, $city_code)->row();
    }


    public function get_total_pop($prov_code)
    {
        $get_total_pop = "
         SELECT
         lib_provinces.total_pop as total_pop
        FROM
          lib_provinces
        WHERE
          lib_provinces.prov_code = ?
        ORDER BY
          lib_provinces.prov_code
        ";

        return $this->db->query($get_total_pop, $prov_code)->row();
    }


    public function get_total_poor($prov_code)
    {
        $get_total_poor = "
         SELECT
         lib_provinces.total_poor as total_poor
        FROM
          lib_provinces
        WHERE
          lib_provinces.prov_code = ?
        ORDER BY
          lib_provinces.prov_code
        ";

        return $this->db->query($get_total_poor, $prov_code)->row();
    }


    public function get_AssessmentRecord()
    {
    $query = $this->db->get_where('tbl_lswdo',array('DELETED' => 0));
    if ($query->num_rows() > 0){
        return $query->result();
    } else {
        return FALSE;
    }
    $this->db->close();
    }

}