<?php
//a
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class reports_model extends CI_Model
{
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

    public function get_cities($prov_code) {
        $get_cities = "
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

        return $this->db->query($get_cities,$prov_code)->result();
    }

//ranking pswdo score = baseline ; new score = updated
    public function get_pswdoscore($regionlist)
    {
        $sql = 'SELECT  c.region_name,d.prov_name,a.baseline_score,a.level_function_baseline
    FROM tbl_functionality a
    INNER JOIN tbl_lswdo b
    on a.prof_id = b.profile_id
    inner join lib_regions c
    on b.region_code = c.region_code
    inner join lib_provinces d
    on b.prov_code = d.prov_code
    where b.deleted = 0 and b.lgu_type_id = 1 and b.region_code = '.$regionlist.'
    order	by a.baseline_score desc;
    ' ;
        $query = $this->db->query($sql);
        $result = $query->result();
        return $result;
    }
    public function get_pswdonewscore($regionlist)
    {
        $sql = 'SELECT  c.region_name,d.prov_name,a.new_score,a.level_function_new
FROM tbl_functionality a
INNER JOIN tbl_lswdo b
on a.prof_id = b.profile_id
inner join lib_regions c
on b.region_code = c.region_code
inner join lib_provinces d
on b.prov_code = d.prov_code
where b.deleted = 0 and b.lgu_type_id = 1 and b.region_code = '.$regionlist.'
order	by a.new_score desc;
    ' ;
        $query = $this->db->query($sql);
        $result = $query->result();
        return $result;
    }
//ranking cmswdo score = baseline ; new score = updated
    public function get_cmswdoscore($regionlist,$provlist)
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
        where b.deleted = 0 and b.lgu_type_id in (2,3)
        and b.region_code = '.$regionlist.'
        and b.prov_code = '.$provlist.'
        order by a.baseline_score desc;' ;
        $query = $this->db->query($sql);
        $result = $query->result();
        return $result;
    }
    public function get_cmswdonewscore($regionlist,$provlist)
    {
        $sql = 'SELECT  c.region_name,d.prov_name,a.new_score,e.city_name,a.level_function_new
                FROM tbl_functionality a
                INNER JOIN tbl_lswdo b
                on a.prof_id = b.profile_id
                inner join lib_regions c
                on b.region_code = c.region_code
                inner join lib_provinces d
                on b.prov_code = d.prov_code
                inner join lib_cities E
                on b.city_code = e.city_code
                where b.deleted = 0 and b.lgu_type_id in (2,3)
                and b.region_code = '.$regionlist.'
                and b.prov_code = '.$provlist.'
                order by a.new_score desc;' ;
        $query = $this->db->query($sql);
        $result = $query->result();
        return $result;
    }
//ranking cswdo score = baseline ; new score = updated
    public function get_cswdoscore($regionlist,$provlist)
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
                where b.deleted = 0
                and b.lgu_type_id = 2
                and e.city_class = "CC"
                and b.region_code = '.$regionlist.'
                and b.prov_code = '.$provlist.'
                order by a.baseline_score desc;' ;
        $query = $this->db->query($sql);
        $result = $query->result();
        return $result;
    }
    public function get_cswdonewscore($regionlist,$provlist)
    {
        $sql = 'SELECT  c.region_name,d.prov_name,a.new_score,e.city_name,a.level_function_new
                FROM tbl_functionality a
                INNER JOIN tbl_lswdo b
                on a.prof_id = b.profile_id
                inner join lib_regions c
                on b.region_code = c.region_code
                inner join lib_provinces d
                on b.prov_code = d.prov_code
                inner join lib_cities E
                on b.city_code = e.city_code
                where b.deleted = 0
                and b.lgu_type_id = 2
                and e.city_class = "CC"
                and b.region_code = '.$regionlist.'
                and b.prov_code = '.$provlist.'
                order by a.new_score desc;' ;
        $query = $this->db->query($sql);
        $result = $query->result();
        return $result;
    }
//ranking mswdo score = baseline ; new score = updated
    public function get_mswdoscore($regionlist,$provlist)
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
                where b.deleted = 0
                and b.lgu_type_id = 2
                and e.city_class != "CC"
                and b.region_code = '.$regionlist.'
                and b.prov_code = '.$provlist.'
                order by a.baseline_score desc;' ;
        $query = $this->db->query($sql);
        $result = $query->result();
        return $result;
    }
    public function get_mswdonewscore($regionlist,$provlist)
    {
        $sql = 'SELECT  c.region_name,d.prov_name,a.new_score,e.city_name,a.level_function_new
                FROM tbl_functionality a
                INNER JOIN tbl_lswdo b
                on a.prof_id = b.profile_id
                inner join lib_regions c
                on b.region_code = c.region_code
                inner join lib_provinces d
                on b.prov_code = d.prov_code
                inner join lib_cities E
                on b.city_code = e.city_code
                where b.deleted = 0
                and b.lgu_type_id = 2
                and e.city_class != "CC"
                and b.region_code = '.$regionlist.'
                and b.prov_code = '.$provlist.'
                order by a.new_score desc;' ;
        $query = $this->db->query($sql);
        $result = $query->result();
        return $result;
    }

    public function get_noofCities($regionlist)
    {
        $sql = 'select count(a.prov_code) as numProv,a.prov_name,count(b.city_code) as numCity
                from lib_provinces a
                inner join lib_cities b
                on a.prov_code = b.prov_code
                where a.region_code = '.$regionlist.'
                GROUP BY a.prov_code
                ORDER BY a.prov_code;
' ;

        $query = $this->db->query($sql);
        $result = $query->result();
        return $result;
    }
    public function get_noofProvince($regionlist)
    {
        $sql = 'select count(prov_code) as numProv from lib_provinces
                where region_code = '.$regionlist.';
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