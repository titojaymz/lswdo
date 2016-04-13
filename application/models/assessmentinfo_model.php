<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Created by JOSEF FRIEDRICH S. BALDO
 * Date Time: 10/17/15 11:56 PM
 */
class assessmentinfo_model extends CI_Model {


    public function record_count() { //pagination query
        return $this->db->count_all("tbl_lswdo");
    }

    public function getAssessmentinfo()
    {
        $sql = 'select a.profile_id,a.swdo_name,c.application_type_name,b.lgu_type_name,total_ira,total_budget_lswdo
                from tbl_lswdo a
                inner join lib_lgu_type b on a.lgu_type_id = b.lgu_type_id
                inner join lib_application_type c on a.application_type_id = c.application_type_id
                where a.deleted = 0';
        $query = $this->db->query($sql);
        $result = $query->result();
        return $result;
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


    public function insertAssessmentinfo($application_type_id,$lgu_type_id,$regionlist,$provlist,$citylist,$office_address,$swdo_name,$designation,$contact_no,$email,$website,$total_ira,$total_budget_lswdo,$created_by,$date_created,$modified_by,$date_modified)
    {
        $this->db->trans_begin();

        $this->db->query('INSERT INTO tbl_lswdo(application_type_id,lgu_type_id,region_code,prov_code,city_code,office_address,swdo_name,designation,contact_no,email,website,total_ira,total_budget_lswdo,created_by,date_created, modified_by, date_modified)
                          VALUES
                          (
                          "'.$application_type_id.'",
                          "'.$lgu_type_id.'",
                          "'.$regionlist.'",
                          "'.$provlist.'",
                          "'.$citylist.'",
                          "'.$office_address.'",
                          "'.$swdo_name.'",
                          "'.$designation.'",
                          "'.$contact_no.'",
                          "'.$email.'",
                          "'.$website.'",
                          "'.$total_ira.'",
                          "'.$total_budget_lswdo.'",
                           "'.$created_by.'",
                          '.$date_created.',
                          "'.$modified_by.'",
                          "'.$date_modified.'"
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

    public function insertBudgetAllocation($sector_id,$year_indicated,$budget_present_year,$utilization,$no_bene_served,$no_target_bene)
    {
        $this->db->trans_begin();

        $this->db->query('INSERT INTO tbl_lswdo_budget(sector_id,year_indicated,budget_present_year,utilization,no_bene_served,no_target_bene,date_created)
                          VALUES
                          (
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

    public function updateAssessmentinfo($id,$application_type_id,$lgu_type_id,$regionlist,$provlist,$citylist,$office_address,$swdo_name,$designation,$contact_no,$email,$website,$total_ira,$total_budget_lswdo,$modified_by,$date_modified)
    {
        $this->db->trans_begin();

        $this->db->query('UPDATE tbl_lswdo SET
                          application_type_id="'.$application_type_id.'",
                          lgu_type_id="'.$lgu_type_id.'",
                          region_code="'.$regionlist.'",
                          prov_code="'.$provlist.'",
                          city_code="'.$citylist.'",
                          office_address="'.$office_address.'",
                          swdo_name="'.$swdo_name.'",
                          designation="'.$designation.'",
                          contact_no="'.$contact_no.'",
                          email="'.$email.'",
                          website="'.$website.'",
                          total_ira="'.$total_ira.'",
                          total_budget_lswdo="'.$total_budget_lswdo.'"
                          modified_by="'.$modified_by.'"
                          date_modified="'.$date_modified.'"
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
    public function Lib_getAllApplicationtype()
    {
        $query = $this->db->get_where('lib_application_type',array('DELETED' => 0));
        if ($query->num_rows() > 0){
            return $query->result();
        } else {
            return FALSE;
        }
        $this->db->close();
    }

    public function Lib_getLGUtype()
    {
        $query = $this->db->get_where('lib_lgu_type',array('DELETED' => 0));
        if ($query->num_rows() > 0){
            return $query->result();
        } else {
            return FALSE;
        }
        $this->db->close();
    }

    /*
        public function fetch_assessmentinfo($user_region) { //pagination query $limit, $offset,
            $region_access = $user_region;
            $this->db->select('t1.profile_id, t2.application_type_id, t1.street_address, t1.swdo_name, t1.contact_no, t1.email, t1.website, t1.total_ira, t1.total_budget_lswdo');
            $this->db->from('tbl_lswdo AS t1');
            $this->db->join('lib_application_type t2','t1.application_type_id = t2.application_type_id','inner');
            if ($user_region != 0) {
                $this->db->where('t1.DELETED ="0" and t1.region ="' . $region_access . '"');
            } else {
                $this->db->where('t1.DELETED ="0"');
            }
            $query = $this->db->get();

            if ($query->num_rows() > 0) {
                return $query->result();
            }else{
                return $query->result();
            }
        }
    */
    public function get_lgutype() {
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

    public function get_regions() {
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

    public function get_provinces($region_code) {
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

        return $this->db->query($get_prov,$region_code)->result();
    }

    public function get_cities($prov_code) {
        $get_cities = "
        SELECT
         city_code,
         city_name
        FROM
          lib_cities
        WHERE
          prov_code = ?
        ORDER BY
          city_name
        ";

        return $this->db->query($get_cities,$prov_code)->result();
    }

    public function get_brgy($city_code) {
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

        return $this->db->query($get_brgy,$city_code)->result();
    }

    public function get_count_city($prov_code) {
        $get_countcity = "
        SELECT
         city_name,
          count(city_code) AS value_sum,
          income_class
        FROM
          lib_cities
        WHERE
          prov_code = ?
        ";

        return $this->db->query($get_countcity,$prov_code)->row();
    }

    public function get_count_brgy($city_code) {
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

        return $this->db->query($get_countbrgy,$city_code)->row();
    }
/*
    public function get_incomeclass($prov_code){
        $get_incomeclass = "
        SELECT
         lib_cities.income_class as income_class,
        lib_provinces.prov_code as prov_code
        FROM
          lib_cities
        INNER JOIN
        lib_provinces
        ON lib_cities.prov_code = lib_provinces.prov_code
        WHERE
          lib_provinces.prov_code = ?
        ORDER BY
          lib_cities.city_code
        ";
        return $this->db->query($get_incomeclass,$prov_code)->row();
    }
*/
    public function getExistingRecords($lgu_type) {
        $get_records = "
        SELECT
        lib_application_type.application_type_name,
        lib_lgu_type.lgu_type_name,
        tbl_lswdo.region_code,
        tbl_lswdo.prov_code,
        tbl_lswdo.city_code,
        tbl_lswdo.office_address,
        tbl_lswdo.swdo_name,
        tbl_lswdo.designation,
        tbl_lswdo.contact_no,
        tbl_lswdo.email,
        tbl_lswdo.website,
        tbl_lswdo.total_ira,
        tbl_lswdo.total_budget_lswdo
        FROM
        tbl_lswdo
        Inner Join lib_application_type ON tbl_lswdo.application_type_id = lib_application_type.application_type_id
        Inner Join lib_lgu_type ON tbl_lswdo.lgu_type_id = lib_lgu_type.lgu_type_id
        WHERE
        lib_lgu_type.lgu_type_id = ?
        ORDER BY
        lib_lgu_type.lgu_type_name
        ";

        return $this->db->query($get_records,$lgu_type)->result();
    }

}