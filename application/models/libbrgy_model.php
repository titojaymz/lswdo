<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Created by PhpStorm.
 * User: mglveniegas
 * Date: 5/20/2016
 * Time: 4:07 PM
 */

class libbrgy_model extends CI_Model
{

    public function listAllbrgy()
    {

        $sql = 'select brgy_code,brgy_name,city_code,rural_urban,old_brgy_psgc,total_pop,Total_Poor_HHs,Total_Poor_Families from lib_brgy
                WHERE DELETED = 0
                ORDER BY brgy_code';
        $query = $this->db->query($sql);
        $result = $query->result();
        return $result;
    }


    public function getBrgyDetails($id)
    {
        $sql = 'select brgy_code,brgy_name,city_code,rural_urban,old_brgy_psgc,total_pop,Total_Poor_HHs,Total_Poor_Families from lib_brgy
                WHERE DELETED = 0 AND brgy_code="' . $id . '"';
        $query = $this->db->query($sql);
        $result = $query->row();
        return $result;
    }


    public function addBrgy($brgy_code,$brgy_name,$city_code,$rural_urban,$old_brgy_psgc,$total_pop,$Total_Poor_HHs,$Total_Poor_Families,$created_by,$date_created)
    {
        $this->db->trans_begin();

        $this->db->query('INSERT INTO lib_brgy(brgy_code,brgy_name,city_code,rural_urban,old_brgy_psgc,total_pop,Total_Poor_HHs,Total_Poor_Families,created_by,date_created)
                          VALUES
                          (
                          "'.$brgy_code.'",
                          "'.$brgy_name.'",
                          "'.$city_code.'",
                          "'.$rural_urban.'",
                          "'.$old_brgy_psgc.'",
                          "'.$total_pop.'",
                          "'.$Total_Poor_HHs.'",
                          "'.$Total_Poor_Families.'",
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

    public function updateCity($id, $brgy_name,$city_code,$rural_urban,$old_brgy_psgc,$total_pop,$Total_Poor_HHs,$Total_Poor_Families,$modified_by, $date_modified)
    {
        $this->db->trans_begin();

        $this->db->query('UPDATE lib_brgy SET
                          brgy_name="'.$brgy_name.'",
                          city_code="'.$city_code.'",
                          rural_urban="'.$rural_urban.'",
                          old_brgy_psgc="'.$old_brgy_psgc.'",
                          total_pop="'.$total_pop.'",
                          Total_Poor_HHs="'.$Total_Poor_HHs.'",
                          Total_Poor_Families="'.$Total_Poor_Families.'",
                          modified_by="'.$modified_by.'",
                          date_modified=Now()
                          WHERE
                          brgy_code = "'.$id.'"
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

    public function deleteProv($id = 0)
    {
        $this->db->trans_begin();
        $this->db->query('UPDATE lib_brgy T1
                          SET T1.DELETED="1"
                          WHERE T1.brgy_code = "' . $id . '"
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

    public function get_city(){
        $get_City = "
        SELECT
          city_code,
          city_name
        FROM
          lib_cities
        WHERE
          city_code > '0'
        ORDER BY
          city_code
        ";
        return $this->db->query($get_City)->result();
    }

}