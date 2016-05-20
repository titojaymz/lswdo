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

    public function getAssessmentinfo($region)
    {
        if($region == '000000000'){
           $where =  'WHERE a.DELETED = 0';
        } else {
            $where =  'WHERE a.DELETED = 0 and a.region_code = '.$region;
        }
        $sql = 'SELECT a.profile_id,c.application_type_name,b.lgu_type_name,d.region_name,e.prov_name,a.swdo_name,a.total_ira,a.total_budget_lswdo
                FROM tbl_lswdo a
                LEFT join lib_lgu_type b on a.lgu_type_id = b.lgu_type_id
                LEFT join lib_application_type c on a.application_type_id = c.application_type_id
                LEFT Join lib_regions d ON a.region_code = d.region_code
                LEFT Join lib_provinces e ON a.prov_code = e.prov_code
                '.$where.'
                ORDER BY a.profile_id';
        $query = $this->db->query($sql);
        $result = $query->result();
        return $result;
    }

/*a.profile_id,c.application_type_name,b.lgu_type_name,d.region_name,e.prov_name,f.city_name,a.swdo_name,a.total_ira,a.total_budget_lswdo,
h.sector_id,h.sector_name,g.year_indicated,g.budget_present_year, g.budget_previous_year,
g.utilization, g.no_bene_served, g.no_target_bene */

    public function getAssessmentinfoByID($id = 0)
    {

        $sql = 'SELECT *
                FROM
                tbl_lswdo AS a
                LEFT Join lib_lgu_type AS b ON a.lgu_type_id = b.lgu_type_id
                LEFT Join lib_application_type AS c ON a.application_type_id = c.application_type_id
                LEFT Join lib_regions as d ON a.region_code = d.region_code
                LEFT Join lib_provinces as e ON a.prov_code = e.prov_code
                LEFT Join lib_cities as f ON a.city_code = f.city_code
                LEFT Join tbl_lswdo_budget as g ON a.profile_id = g.profile_id
                LEFT Join lib_sector as h ON g.sector_id = h.sector_id
                WHERE a.DELETED = 0 and a.profile_id="' . $id . '"';
        $query = $this->db->query($sql);
        $result = $query->row();
        return $result;

    }


    public function insertAssessmentinfo($application_type_id, $lgu_type_id, $regionlist, $provlist, $citylist, $office_address, $swdo_name, $designation, $contact_no, $email, $website, $total_ira, $total_budget_lswdo, $created_by, $date_created)
    {

        $this->db->trans_begin();

        $this->db->query('INSERT INTO tbl_lswdo(application_type_id,lgu_type_id,region_code,prov_code,city_code,office_address,swdo_name,designation,contact_no,email,website,total_ira,total_budget_lswdo,created_by,date_created)
                          VALUES
                          (
                          "' . $application_type_id . '",
                          "' . $lgu_type_id . '",
                          "' . $regionlist . '",
                          "' . $provlist . '",
                           '.$citylist.',
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

            return $insert_id;
        }
        $this->db->close();
    }

    public function updateAssessmentinfo($id, $application_type_id, $lgu_type_id, $regionlist, $provlist, $citylist, $office_address, $swdo_name, $designation, $contact_no, $email, $website, $total_ira, $total_budget_lswdo, $modified_by, $date_modified)
    {
        $this->db->trans_begin();

        $this->db->query('UPDATE tbl_lswdo SET
                          application_type_id="'.$application_type_id.'",
                          lgu_type_id="'.$lgu_type_id.'",
                          region_code="'.$regionlist.'",
                          prov_code="'.$provlist.'",
                          city_code='.$citylist.',
                          office_address="'.$office_address.'",
                          swdo_name="'.$swdo_name.'",
                          designation="'.$designation.'",
                          contact_no="'.$contact_no.'",
                          email="'.$email.'",
                          website="'.$website.'",
                          total_ira="'.$total_ira.'",
                          total_budget_lswdo="'.$total_budget_lswdo.'",
                          modified_by="'.$modified_by.'",
                          date_modified=Now()
                          WHERE
                          profile_id = "'.$id.'"
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
        $this->db->query('UPDATE tbl_lswdo T1
                          SET T1.DELETED="1"
                          WHERE T1.profile_id = "' . $id . '"
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
    public function deleteAssessmentinfoBudget($id = 0)
    {
        $this->db->trans_begin();
        $this->db->query('UPDATE tbl_lswdo_budget T2
                          SET T2.DELETED="1"
                          WHERE T2.profile_id = "' . $id . '"
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

// Populate cities if MSWDO
    public function get_cities2($prov_code)
    {
        $get_cities2 = "
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

        return $this->db->query($get_cities2, $prov_code)->result();
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
        ORDER BY
          city_name
        ";

        return $this->db->query($get_cities, $prov_code)->result();
    }

// Populate Cities if CSWDO
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

// NO. of cities either PSWDO,CSWDO and MSWDO
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

// NO. of municipalities either PSWDO,CSWDO and MSWDO
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
          lib_provinces
        WHERE
          prov_code = ?
        ";

        return $this->db->query($get_incomeclass, $prov_code)->row();
    }

    public function get_incomeclass2($city_code)
    {
        $get_incomeclass2 = "
        SELECT
          income_class
        FROM
          lib_cities
        WHERE
          city_code = ?
          and city_class = 'CC'
        ";

        return $this->db->query($get_incomeclass2, $city_code)->row();
    }

    public function get_incomeclass3($city_code)
    {
        $get_incomeclass3 = "
        SELECT
          income_class
        FROM
          lib_cities
        WHERE
          city_code = ?
          and city_class = ''
        ";

        return $this->db->query($get_incomeclass3, $city_code)->row();
    }

//No of BRGY for CSWDO
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
         and lib_cities.city_class = 'CC'
        ";

        return $this->db->query($get_countbrgy, $city_code)->row();
    }

    //No of BRGY for MSWDO
    public function get_count_brgy3($city_code)
    {
        $get_countbrgy3 = "
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
        and lib_cities.city_class = ''
        ";

        return $this->db->query($get_countbrgy3, $city_code)->row();
    }

//No of BRGY for PSWDO
    public function get_count_brgy2($prov_code)
    {
        $get_countbrgy2 = "
        SELECT
        lib_provinces.prov_name,
        lib_regions.region_name,
        count(lib_brgy.brgy_name) as no_brgy
        FROM
        lib_brgy
        Inner Join lib_cities ON lib_brgy.city_code = lib_cities.city_code
        Inner Join lib_provinces ON lib_cities.prov_code = lib_provinces.prov_code
        Inner Join lib_regions ON lib_provinces.region_code = lib_regions.region_code
        WHERE
         lib_provinces.prov_code = ?
        ";

        return $this->db->query($get_countbrgy2, $prov_code)->row();
    }


    public function get_total_pop($prov_code)
    {
        $get_total_pop = "
         SELECT
          SUM(lib_brgy.total_pop) as total_pop
        FROM
          lib_brgy
           Inner Join lib_cities ON lib_brgy.city_code = lib_cities.city_code
           Inner Join lib_provinces ON lib_cities.prov_code = lib_provinces.prov_code
           Inner Join lib_regions ON lib_provinces.region_code = lib_regions.region_code
        WHERE
          lib_provinces.prov_code = ?
        ORDER BY
          lib_provinces.prov_code
        ";

        return $this->db->query($get_total_pop, $prov_code)->row();
    }

    public function get_total_pop2($city_code)
    {
        $get_total_pop2 = "
           SELECT
               lib_cities.city_code,
               SUM(lib_brgy.total_pop) as total_pop
           FROM
               lib_brgy
           Inner Join lib_cities ON lib_brgy.city_code = lib_cities.city_code
           Inner Join lib_provinces ON lib_cities.prov_code = lib_provinces.prov_code
           Inner Join lib_regions ON lib_provinces.region_code = lib_regions.region_code
           WHERE
               lib_cities.city_code = ?
           ORDER BY
               lib_cities.city_code
                and lib_cities.city_class = 'CC'
        ";

        return $this->db->query($get_total_pop2, $city_code)->row();
    }

    public function get_total_pop3($city_code)
    {
        $get_total_pop3 = "
           SELECT
               lib_cities.city_code,
               SUM(lib_brgy.total_pop) as total_pop
           FROM
               lib_brgy
           Inner Join lib_cities ON lib_brgy.city_code = lib_cities.city_code
           Inner Join lib_provinces ON lib_cities.prov_code = lib_provinces.prov_code
           Inner Join lib_regions ON lib_provinces.region_code = lib_regions.region_code
           WHERE
               lib_cities.city_code = ?
           ORDER BY
               lib_cities.city_code
             ";

        return $this->db->query($get_total_pop3, $city_code)->row();
    }


    public function get_total_poor($prov_code)
    {
        $get_total_poor = "
         SELECT
         sum(lib_brgy.Total_Poor_HHs) as total_poor
        FROM
          lib_regions
        INNER JOIN
          lib_provinces ON lib_provinces.region_code = lib_regions.region_code
          Inner Join lib_cities ON lib_provinces.prov_code = lib_cities.prov_code
          Inner Join lib_brgy ON lib_cities.city_code = lib_brgy.city_code
        WHERE
          lib_provinces.prov_code = ?
        ORDER BY
          lib_provinces.prov_code
        ";

        return $this->db->query($get_total_poor, $prov_code)->row();
    }

    //Total poor for CSWDO and MSWDO
    public function get_total_poor2($city_code)
    {
        $get_total_poor2 = "
           SELECT
           lib_cities.city_code,
           sum(lib_brgy.Total_Poor_HHs) as total_poor
           FROM
           lib_regions
           INNER JOIN
            lib_provinces ON lib_provinces.region_code = lib_regions.region_code
           Inner Join lib_cities ON lib_provinces.prov_code = lib_cities.prov_code
            Inner Join lib_brgy ON lib_cities.city_code = lib_brgy.city_code
           WHERE
           lib_cities.city_code = ?
           ORDER BY
           lib_cities.city_code
            and lib_cities.city_class = 'CC'
        ";

        return $this->db->query($get_total_poor2, $city_code)->row();
    }

    public function get_total_poor3($city_code)
    {
        $get_total_poor3 = "
          SELECT
          sum(lib_brgy.Total_Poor_HHs) as total_poor
          FROM
          lib_regions
          INNER JOIN
          lib_provinces ON lib_provinces.region_code = lib_regions.region_code
          Inner Join lib_cities ON lib_provinces.prov_code = lib_cities.prov_code
          Inner Join lib_brgy ON lib_cities.city_code = lib_brgy.city_code
          WHERE
          lib_cities.city_code = ?
          ORDER BY
          lib_cities.city_code
          and lib_cities.city_class = ''
        ";

        return $this->db->query($get_total_poor3, $city_code)->row();
    }


}