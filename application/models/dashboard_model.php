<?php
class dashboard_model extends CI_Model
{
    /**
     * Created by PhpStorm.
     * User: mblejano
     * Date: 3/31/2016
     * Time: 9:50 AM
     *
     */
    public function getFunctionalityScore()
    {
        $sql = 'select c.region_name,b.profile_id,
                case b.lgu_type_id
                when 1 then (SUM(IF(a.compliance_indicator_id = 1, 1, 0)) / 78) * 100
                when 2 then (SUM(IF(a.compliance_indicator_id = 1, 1, 0)) / 91) * 100
                when 3 then (SUM(IF(a.compliance_indicator_id = 1, 1, 0)) / 91) * 100
                end as FinalScore
                FROM tbl_lswdo_standard_indicators a
                INNER JOIN tbl_lswdo b
                ON a.profile_id = b.profile_id
                INNER JOIN lib_regions c
                ON b.region_code = c.region_code

                where a.deleted = 0 and a.indicator_id LIKE "%-1%" GROUP BY b.profile_id;';
        $query = $this->db->query($sql);
        return $query->result();


    }

    public function getRegions()
    {
        $sql = 'select region_name from lib_regions where region_name != "Central Office";';
        $query = $this->db->query($sql);
        return $query->result();


    }
    public function countRegions()
    {
        $sql = 'SELECT COUNT(region_name) countReg FROM lib_regions where region_name != "Central Office";';
        $query = $this->db->query($sql);
        return $query->row();


    }
}