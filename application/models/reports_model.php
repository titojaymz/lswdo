<?php
//a
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class reports_model extends CI_Model
{

public function get_pswdoscore()
{
    $sql = 'SELECT  c.region_name,d.prov_name,a.baseline_score,a.level_function_baseline
FROM tbl_functionality a
INNER JOIN tbl_lswdo b
on a.prof_id = b.profile_id
inner join lib_regions c
on b.region_code = c.region_code
inner join lib_provinces d
on b.prov_code = d.prov_code
where b.deleted = 0 and b.lgu_type_id = 1
order	by a.baseline_score desc;
' ;
    $query = $this->db->query($sql);
    $result = $query->result();
    return $result;
}
    public function get_cmswdoscore()
    {
        $sql = 'SELECT  c.region_name,d.prov_name,a.baseline_score,e.city_name,a.level_function_baseline
FROM tbl_functionality a
INNER JOIN tbl_lswdo b
on a.prof_id = b.profile_id
inner join lib_regions c
on b.region_code = c.region_code
inner join lib_provinces d
on b.prov_code = d.prov_code
inner join lib_cities E
on b.city_code = e.city_code
where b.deleted = 0 and b.lgu_type_id in (\'2\',\'3\')' ;
        $query = $this->db->query($sql);
        $result = $query->result();
        return $result;
    }
}