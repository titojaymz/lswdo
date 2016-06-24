<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Created by PhpStorm.
 * User: mglveniegas
 * Date: 5/20/2016
 * Time: 4:07 PM
 */

class libprov_model extends CI_Model
{

    public function listAllprov()
    {

        $sql = 'select prov_code,prov_name,region_code,income_class,created_by,date_created,modified_by,date_modified from lib_provinces
               WHERE DELETED = 0
               ORDER BY prov_code';
        $query = $this->db->query($sql);
        $result = $query->result();
        return $result;
    }


    public function getProvDetails($id=0)
    {
        $sql = 'select prov_code,prov_name,region_code,income_class,created_by,date_created,modified_by,date_modified from lib_provinces
                WHERE DELETED = 0 AND prov_code="' . $id . '"';
        $query = $this->db->query($sql);
        $result = $query->row();
        return $result;
    }


    public function addProv($prov_code,$prov_name,$region_code,$income_class,$created_by,$date_created)
    {
        $this->db->trans_begin();

        $this->db->query('INSERT INTO lib_provinces(prov_code,prov_name,region_code,income_class,created_by,date_created)
                          VALUES
                          (
                          "'.$prov_code.'",
                          "'.$prov_name.'",
                          "'.$region_code.'",
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

    public function updateProv($id, $prov_name,$region_code,$income_class, $modified_by, $date_modified)
    {
        $this->db->trans_begin();

        $this->db->query('UPDATE lib_provinces SET
                          prov_name="'.$prov_name.'",
                          region_code="'.$region_code.'",
                          income_class="'.$income_class.'",
                          modified_by="'.$modified_by.'",
                          date_modified=Now()
                          WHERE
                          prov_code = "'.$id.'"
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
        $this->db->query('UPDATE lib_provinces T1
                          SET T1.DELETED="1"
                          WHERE T1.prov_code = "' . $id . '"
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

    public function get_region(){
        $get_Region = "
        SELECT
          region_code,
          region_name
        FROM
          lib_regions
        WHERE
          region_code > '0'
        ORDER BY
          region_code
        ";
        return $this->db->query($get_Region)->result();
    }
}