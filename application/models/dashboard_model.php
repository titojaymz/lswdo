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
    public function getFunctionalityScore($regCode)
    {

        if($regCode != '000000000')
        {
            $where = 'where b.region_code = "'.$regCode.'" and b.deleted = 0';
        }
        else
        {
            $where = 'where b.deleted = 0';
        }
        $sql = 'SELECT
SUM(IF(a.level_function_baseline = \'Functional\',1,0)) \'Functional\',
SUM(IF(a.level_function_baseline = \'Fully Functional\',1,0)) \'FullyFunctional\',
SUM(IF(a.level_function_baseline = \'Partially Functional\',1,0)) \'PartiallyFunctional\'
,c.region_name,a.prof_id,ref_id
FROM `tbl_functionality` a
INNER JOIN tbl_lswdo b
ON b.profile_id = a.prof_id
Inner Join lib_regions c
ON b.region_code = c.region_code '.$where.'
GROUP BY c.region_name;';
        /*$sql = 'select c.region_name,b.profile_id,
                case b.lgu_type_id
                when 1 then
								case when (SUM(IF(a.compliance_indicator_id = 1, 1, 0)) / 78) * 100 = 100
								Then \'Fully Functional\'
								when (SUM(IF(a.compliance_indicator_id = 1, 1, 0)) / 78) * 100 > 50 &&  (SUM(IF(a.compliance_indicator_id = 1, 1, 0)) / 78) * 100 < 100
								Then \'Functional\'
								when (SUM(IF(a.compliance_indicator_id = 1, 1, 0)) / 78) * 100 < 51
								Then \'Partially Functional\' end
                when 2 then
								case when (SUM(IF(a.compliance_indicator_id = 1, 1, 0)) / 91) * 100 = 100
								Then \'Fully Functional\'
								when (SUM(IF(a.compliance_indicator_id = 1, 1, 0)) / 91) * 100 > 50 &&  (SUM(IF(a.compliance_indicator_id = 1, 1, 0)) / 91) * 100 < 100
								Then \'Functional\'
								when (SUM(IF(a.compliance_indicator_id = 1, 1, 0)) / 91) * 100 < 51
								Then \'Partially Functional\' end
                when 3 then
								case when (SUM(IF(a.compliance_indicator_id = 1, 1, 0)) / 91) * 100 = 100
								Then \'Fully Functional\'
								when (SUM(IF(a.compliance_indicator_id = 1, 1, 0)) / 91) * 100 > 50 &&  (SUM(IF(a.compliance_indicator_id = 1, 1, 0)) / 91) * 100 < 100
								Then \'Functional\'
								when (SUM(IF(a.compliance_indicator_id = 1, 1, 0)) / 91) * 100 < 51
								Then \'Partially Functional\' end
                end as FinalScore


                FROM tbl_lswdo_standard_indicators a
                INNER JOIN tbl_lswdo b
                ON a.profile_id = b.profile_id
                INNER JOIN lib_regions c
                ON b.region_code = c.region_code

                where a.deleted = 0 and a.indicator_id LIKE "%-1%" GROUP BY b.profile_id';*/
        $query = $this->db->query($sql);
        return $query->result();


    }

    public function getRegions($regCode)
    {
        if($regCode != '000000000')
        {
            $where = 'where region_code = "'.$regCode.'" and region_name != "Central Office";';
        }
        else
        {
            $where = 'where region_name != "Central Office";';
        }
        $sql = 'select region_name from lib_regions '.$where.';';
        $query = $this->db->query($sql);
        return $query->result();


    }
    public function countRegions($regCode)
    {
        if($regCode != '000000000')
        {
            $where = 'where region_code = "'.$regCode.'" and region_name != "Central Office";';
        }
        else
        {
            $where = 'where region_name != "Central Office";';
        }
        $sql = 'SELECT COUNT(region_name) countReg FROM lib_regions '.$where.';';
        $query = $this->db->query($sql);
        return $query->row();


    }
}