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
    public function get_pswdonewscore()
    {
        $sql = 'SELECT  c.region_name,d.prov_name,a.new_score,a.level_function_new
FROM tbl_functionality a
INNER JOIN tbl_lswdo b
on a.prof_id = b.profile_id
inner join lib_regions c
on b.region_code = c.region_code
inner join lib_provinces d
on b.prov_code = d.prov_code
where b.deleted = 0 and b.lgu_type_id = 1
order	by a.new_score desc;
    ' ;
        $query = $this->db->query($sql);
        $result = $query->result();
        return $result;
    }
    public function get_cmswdonewscore()
    {
        $sql = 'SELECT  c.region_name,d.prov_name,a.new_score,a.level_function_new
FROM tbl_functionality a
INNER JOIN tbl_lswdo b
on a.prof_id = b.profile_id
inner join lib_regions c
on b.region_code = c.region_code
inner join lib_provinces d
on b.prov_code = d.prov_code
where b.deleted = 0 and b.lgu_type_id in (\'2\',\'3\')
order	by a.new_score desc;
    ' ;
        $query = $this->db->query($sql);
        $result = $query->result();
        return $result;
    }
    public function get_noofCities()
    {
        $sql = 'select count(a.prov_code) as numProv,a.prov_name,count(b.city_code) as numCity from lib_provinces a
inner join lib_cities b
on a.prov_code = b.prov_code
where a.region_code = 010000000
GROUP BY a.prov_code
ORDER BY a.prov_code;
' ;

   /*     select a.prov_name,count(b.city_code) as numCity from lib_provinces a
inner join lib_cities b
on a.prov_code = b.prov_code
inner join tbl_lswdo c
on c.prov_code = a.prov_code
inner join tbl_functionality d
on d.prof_id = c.profile_id
where a.region_code = 010000000 and c.DELETED = 0
GROUP BY a.prov_code
ORDER BY a.prov_code*/
        $query = $this->db->query($sql);
        $result = $query->result();
        return $result;
    }
    public function get_noofProvince()
    {
        $sql = 'select count(prov_code) as numProv from lib_provinces
                where region_code = 010000000;
' ;

        $query = $this->db->query($sql);
        $result = $query->row();
        return $result;
    }
public function get_noofFunctional()
{
    $sql = 'SELECT c.prov_name,d.city_name,c.prov_code,
sum(if(a.level_function_baseline = "Functional",1,0)) as "Functional",
sum(if(a.level_function_baseline = "Fully Functional",1,0)) as "FullyFunctional",
sum(if(a.level_function_baseline = "Partially Functional",1,0)) as "PartiallyFunctional"
FROM `tbl_functionality` a
inner join tbl_lswdo b
on a.prof_id = b.profile_id
inner join lib_provinces c
on b.prov_code = c.prov_code
inner join lib_cities d
on b.city_code = d.city_code
where b.deleted = 0 and b.lgu_type_id in (\'2\',\'3\')
group by c.prov_name;
' ;
    $query = $this->db->query($sql);
    $result = $query->result();
    return $result;
}

}