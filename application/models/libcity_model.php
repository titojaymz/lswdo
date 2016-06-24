<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Created by PhpStorm.
 * User: mglveniegas
 * Date: 5/20/2016
 * Time: 4:07 PM
 */

class libcity_model extends CI_Model
{

    public function listAllcity()
    {

        $sql = 'select city_code,city_name,prov_code,district, city_class, income_class,created_by,date_created,modified_by,date_modified from lib_cities
               WHERE DELETED = 0
               ORDER BY city_code';
        $query = $this->db->query($sql);
        $result = $query->result();
        return $result;
    }


    public function getCityDetails($id=0)
    {
        $sql = 'select city_code,city_name,prov_code,district, city_class,income_class,created_by,date_created,modified_by,date_modified from lib_cities
                WHERE DELETED = 0 AND city_code="' . $id . '"';
        $query = $this->db->query($sql);
        $result = $query->row();
        return $result;
    }


    public function addCity($city_code,$city_name,$prov_code,$district,$city_class,$income_class,$created_by,$date_created)
    {
        $this->db->trans_begin();

        $this->db->query('INSERT INTO lib_cities(city_code,city_name,prov_code,district,city_class,income_class,created_by,date_created)
                          VALUES
                          (
                          "'.$city_code.'",
                          "'.$city_name.'",
                          "'.$prov_code.'",
                          "'.$district.'",
                          "'.$city_class.'",
                          "'.$income_class.'",
                          "'.$created_by.'",
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

    public function updateCity($id, $city_name,$prov_code,$district,$city_class,$income_class, $modified_by, $date_modified)
    {
        $this->db->trans_begin();

        $this->db->query('UPDATE lib_cities SET
                          city_name="'.$city_name.'",
                          prov_code="'.$prov_code.'",
                          district="'.$district.'",
                          city_class="'.$city_class.'",
                          income_class="'.$income_class.'",
                          modified_by="'.$modified_by.'",
                          date_modified=Now()
                          WHERE
                          city_code = "'.$id.'"
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

    public function deleteCity($id = 0)
    {
        $this->db->trans_begin();
        $this->db->query('UPDATE lib_cities T1
                          SET T1.DELETED="1"
                          WHERE T1.city_code = "' . $id . '"
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

    public function get_prov(){
        $get_Prov = "
        SELECT
          prov_code,
          prov_name
        FROM
          lib_provinces
        WHERE
          prov_code > '0'
        ORDER BY
          prov_code
        ";
        return $this->db->query($get_Prov)->result();
    }
}