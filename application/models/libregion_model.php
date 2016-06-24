<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Created by PhpStorm.
 * User: mglveniegas
 * Date: 5/20/2016
 * Time: 4:07 PM
 */

class libregion_model extends CI_Model
{

    public function listAllregion()
    {

        $sql = 'select region_code,region_name,region_nick,created_by,date_created,modified_by,date_modified from lib_regions
                WHERE DELETED = 0
                ORDER BY region_code';
        $query = $this->db->query($sql);
        $result = $query->result();
        return $result;
    }


    public function getRegionDetails($id=0)
    {
        $sql = 'select region_code,region_name,region_nick,created_by,date_created,modified_by,date_modified from lib_regions
                WHERE DELETED = 0 AND region_code="' . $id . '"';
        $query = $this->db->query($sql);
        $result = $query->row();
        return $result;
    }


    public function addRegion($region_code,$region_name,$region_nick,$created_by,$date_created)
    {
        $this->db->trans_begin();

        $this->db->query('INSERT INTO lib_regions(region_code,region_name,region_nick,created_by,date_created)
                          VALUES
                          (
                          "'.$region_code.'",
                          "'.$region_name.'",
                          "'.$region_nick.'",
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

    public function updateRegion($id, $region_name, $region_nick, $modified_by, $date_modified)
    {
        $this->db->trans_begin();

        $this->db->query('UPDATE lib_regions SET
                          region_name="'.$region_name.'",
                          region_nick="'.$region_nick.'",
                          modified_by="'.$modified_by.'",
                          date_modified=Now()
                          WHERE
                          region_code = "'.$id.'"
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

    public function deleteRegion($id = 0)
    {
        $this->db->trans_begin();
        $this->db->query('UPDATE lib_regions T1
                          SET T1.DELETED="1"
                          WHERE T1.region_code = "' . $id . '"
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
}