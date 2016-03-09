<?php

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class assessmentinfo_model extends CI_Model
{
    //modified query,
    public function get_assessmentinfo_list()
    {
        $sql = 'select t1.profile_id, t2.application_type_id, t7.lgu_type_id, t3.region_name,  t4.prov_name, t5.city_name, t6.brgy_name, t1.street_address, t1.swdo_name, t1.contact_no, t1.email, t1.website, t1.total_ira, t1.total_budget_lswdo
FROM
tbl_lswdo AS t1
Inner Join lib_application_type AS t2 ON t1.application_type_id=t2.application_type_id
Inner Join lib_regions AS t3 ON t1.region_code = t3.region_code
Inner Join lib_provinces AS t4 ON t1.prov_code = t4.prov_code
Inner Join lib_cities AS t5 ON t1.city_code = t5.city_code
Inner Join lib_brgy AS t6 ON t1.brgy_code = t6.brgy_code
Inner Join lib_lgu_type AS t7 ON t1.lgu_type_id = t7.lgu_type_id ';
        $query = $this->db->query($sql);
        $result = $query->result();
        return $result;

    }
    public function insertAssessmentinfo($application_type_id,$lgu_type_id,$region_code,$prov_code,$city_code,$brgy_code,$street_address,$swdo_name,$contactno,$email,$website,$total_ira,$total_budget_lswdo)
    {
        //from familyinfo/addfamilyinfo else
        $this->db->trans_begin();
        //insert the form data into database
//            $this->db->insert('tbl_family_information');
        //$date= date('Y-m-d', strtotime($since_when));
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
						  "'.$contactno.'",
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

    public function record_count() { //pagination query
        return $this->db->count_all("tbl_lswdo");
    }

    public function fetch_assessmentinfo($user_region) { //pagination query $limit, $offset,
        $region_access = $user_region;
        $this->db->select('t1.profile_id, t2.application_type_id, t7.lgu_type_id, t3.region_name,  t4.prov_name, t5.city_name, t6.brgy_name, t1.street_address, t1.swdo_name, t1.contact_no, t1.email, t1.website, t1.total_ira, t1.total_budget_lswdo');
        $this->db->from('tbl_lswdo t1');
        $this->db->join('lib_application_type t2','t1.application_type_id = t2.application_type_id','inner');
        if ($user_region != 0) {
            $this->db->where('t1.region_code ="' . $region_access . '"');
        }
        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            return $query->result();
        }else{
            return $query->result();
        }
    }

    public function getprofileid($profile_id = 0)
    {
        $query = $this->db->get_where('tbl_lswdo',array('profile_id'=>$profile_id));
        if ($query->num_rows() > 0)
        {
            return $query->row();
        }
        else
        {
            return FALSE;
        }
        $this->db->close();
    }

    //family position
    public function get_application_type(){
        $get_applicationtype = "
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

        return $this->db->query($get_applicationtype)->result();
    }

    //edit
    public function updateAssessmentinfo($profile_id, $application_type_id,$lgu_type_id,$region_code,$prov_code,$city_code,$brgy_code,$street_address,$swdo_name,$contact_no,$email,$website,$total_ira,$total_budget_lswdo)
    {
        $this->db->trans_begin();
       // $date= date('Y-m-d', strtotime($since_when));
        $this->db->query('UPDATE tbl_family_information SET
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

    public function deleteAssessmentinfo($profile_id = 0)
    {
        $this->db->trans_begin();

        $this->db->query('UPDATE tbl_lswdo SET
                              DELETED="1"
                              WHERE
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

    public function get_city($prov_code) {
        $get_city = "
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

        return $this->db->query($get_city,$prov_code)->result();
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

    public function get_lgu_type() {
        $get_lgu_type = "
        SELECT
          lgu_type_id,
          lgu_type_name
        FROM
          lib_lgu_type
        ORDER BY
          lgu_type_id
        ";

        return $this->db->query($get_lgu_type)->result();
    }


}
?>