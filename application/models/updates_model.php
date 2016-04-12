<?php
class updates_model extends CI_Model
{
    public function getDetails($profID, $refID)
    {
        $sql = 'select d.lgu_type_name, e.region_name, f.visit_count, c.visit_date
                FROM tbl_lswdo_standard_indicators a
                INNER JOIN tbl_lswdo b
                ON a.profile_id = b.profile_id
                INNER JOIN tbl_lswdo_monitoring c
                ON a.ref_id = c.ref_id
                INNER JOIN lib_lgu_type d
                ON b.lgu_type_id = d.lgu_type_id
                INNER JOIN lib_regions e
                ON b.region_code = e.region_code
                INNER JOIN lib_visit_count f
                ON c.visit_count = f.visit_id
                WHERE a.profile_id = '.$profID.' and a.ref_id = '.$refID.'
                Group by a.profile_id;';
        $query = $this->db->query($sql);
        return $query->row();
    }
    public function getMotherIndicator()
    {
        $sql = 'SELECT indicator_id, indicator_name FROM lib_indicator_codes where mother_indicator_id = "0"';
        $query = $this->db->query($sql);
        return $query->result();
    }

    public function geChildIndicator($motherIndicator)
    {
        $sql = 'select indicator_id, indicator_name from lib_indicator_codes where mother_indicator_id = "'.$motherIndicator.'";';
        $query = $this->db->query($sql);
        return $query->result();
    }

    public function getLibCodes($motherIndicator)
    {
        $sql = 'select indicator_id, indicator_name from lib_indicator_codes where indicator_id = "'.$motherIndicator.'";';
        $query = $this->db->query($sql);
        return $query->row();
    }

    public function getIndicatorUpdate($motherIndicator)
    {
        $sql = 'select indicator_id, profile_id,ref_id, oldValue, newValue from tbl_updates where indicator_id = "'.$motherIndicator.'";';
        $query = $this->db->query($sql);
        return $query->row();
    }

    public function insertUpdates($indicatorID, $profID, $refID, $oldValue, $newValue,$date_updated){
        $this->db->trans_begin();
        $this->db->query('insert into tbl_updates (indicator_id, profile_id, ref_id, oldValue, newValue, date_updated)
                          VALUES (
                          "'.$indicatorID.'",
                          "'.$profID.'",
                          "'.$refID.'",
                          "'.$oldValue.'",
                          "'.$newValue.'",
                          "'.$date_updated.'"
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
}