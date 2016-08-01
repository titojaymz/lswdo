<?php
//a
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class reports_model extends CI_Model
{
    public function get_max_visit()
    {
        $sql = 'SELECT visit_count FROM `tbl_lswdo_monitoring` ORDER BY visit_count desc limit 1;
    ' ;
        $query = $this->db->query($sql);
        $result = $query->row();
        return $result;
    }
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
    public function get_distributionofPSWDOFunctionalityregion()
    {
        $sql = 'SELECT e.region_name,
            sum(if(a.level_function_baseline = "Functional",1,0)) as "Functional",
            sum(if(a.level_function_baseline = "Fully Functional",1,0)) as "FullyFunctional",
            sum(if(a.level_function_baseline = "Partially Functional",1,0)) as "PartiallyFunctional"
            FROM `tbl_functionality` a
            inner join tbl_lswdo b
            on a.prof_id = b.profile_id
			inner join lib_regions e
			on b.region_code = e.region_code
            where b.deleted = 0 and b.lgu_type_id = 1
            group by e.region_name;
    ' ;
        $query = $this->db->query($sql);
        $result = $query->result();
        return $result;
    }
    public function get_distributionofCSWDOFunctionalityregion()
    {
        $sql = 'SELECT e.region_name,
            sum(if(a.level_function_baseline = "Functional",1,0)) as "Functional",
            sum(if(a.level_function_baseline = "Fully Functional",1,0)) as "FullyFunctional",
            sum(if(a.level_function_baseline = "Partially Functional",1,0)) as "PartiallyFunctional"
            FROM `tbl_functionality` a
            inner join tbl_lswdo b
            on a.prof_id = b.profile_id
			inner join lib_regions e
			on b.region_code = e.region_code
            where b.deleted = 0 and b.lgu_type_id = 2
            group by e.region_name;
    ' ;
        $query = $this->db->query($sql);
        $result = $query->result();
        return $result;
    }

    public function get_avePSWDObudgetprevyearbyregion()
    {
        $sql = 'select
                c.region_name,
                sum(if(sector_id = 1,a.budget_previous_year,0)) / sum(if(sector_id = 1,1,0)) as Children,
                sum(if(sector_id = 2,a.budget_previous_year,0)) / sum(if(sector_id = 2,1,0)) as Youth,
                sum(if(sector_id = 3,a.budget_previous_year,0)) / sum(if(sector_id = 3,1,0)) as Women,
                sum(if(sector_id = 4,a.budget_previous_year,0)) / sum(if(sector_id = 4,1,0)) as FamilyandCommunity,
                sum(if(sector_id = 5,a.budget_previous_year,0)) / sum(if(sector_id = 5,1,0))as SeniorCitizen,
                sum(if(sector_id = 6,a.budget_previous_year,0)) / sum(if(sector_id = 6,1,0))as PWD,
                sum(if(sector_id = 7,a.budget_previous_year,0)) / sum(if(sector_id = 7,1,0))as IDP
                from tbl_lswdo_budget a
                inner join tbl_lswdo b
                on a.profile_id = b.profile_id
                INNER JOIN lib_regions c
                on b.region_code = c.region_code
                where b.lgu_type_id = 1 and b.deleted = 0
                group by b.region_code;
    ' ;
        $query = $this->db->query($sql);
        $result = $query->result();
        return $result;
    }
    public function get_aveCSWDObudgetprevyearbyregion()
    {
        $sql = 'select
                c.region_name,
                sum(if(sector_id = 1,a.budget_previous_year,0)) / sum(if(sector_id = 1,1,0)) as Children,
                sum(if(sector_id = 2,a.budget_previous_year,0)) / sum(if(sector_id = 2,1,0)) as Youth,
                sum(if(sector_id = 3,a.budget_previous_year,0)) / sum(if(sector_id = 3,1,0)) as Women,
                sum(if(sector_id = 4,a.budget_previous_year,0)) / sum(if(sector_id = 4,1,0)) as FamilyandCommunity,
                sum(if(sector_id = 5,a.budget_previous_year,0)) / sum(if(sector_id = 5,1,0))as SeniorCitizen,
                sum(if(sector_id = 6,a.budget_previous_year,0)) / sum(if(sector_id = 6,1,0))as PWD,
                sum(if(sector_id = 7,a.budget_previous_year,0)) / sum(if(sector_id = 7,1,0))as IDP
                from tbl_lswdo_budget a
                inner join tbl_lswdo b
                on a.profile_id = b.profile_id
                INNER JOIN lib_regions c
                on b.region_code = c.region_code
                where b.lgu_type_id = 2 and b.deleted = 0
                group by b.region_code;
    ' ;
        $query = $this->db->query($sql);
        $result = $query->result();
        return $result;
    }
    public function get_aveMSWDObudgetprevyearbyregion()
    {
        $sql = 'select
                c.region_name,
                sum(if(sector_id = 1,a.budget_previous_year,0)) / sum(if(sector_id = 1,1,0)) as Children,
                sum(if(sector_id = 2,a.budget_previous_year,0)) / sum(if(sector_id = 2,1,0)) as Youth,
                sum(if(sector_id = 3,a.budget_previous_year,0)) / sum(if(sector_id = 3,1,0)) as Women,
                sum(if(sector_id = 4,a.budget_previous_year,0)) / sum(if(sector_id = 4,1,0)) as FamilyandCommunity,
                sum(if(sector_id = 5,a.budget_previous_year,0)) / sum(if(sector_id = 5,1,0))as SeniorCitizen,
                sum(if(sector_id = 6,a.budget_previous_year,0)) / sum(if(sector_id = 6,1,0))as PWD,
                sum(if(sector_id = 7,a.budget_previous_year,0)) / sum(if(sector_id = 7,1,0))as IDP
                from tbl_lswdo_budget a
                inner join tbl_lswdo b
                on a.profile_id = b.profile_id
                INNER JOIN lib_regions c
                on b.region_code = c.region_code
                where b.lgu_type_id = 3 and b.deleted = 0
                group by b.region_code;
    ' ;
        $query = $this->db->query($sql);
        $result = $query->result();
        return $result;
    }

    public function get_LSWDObudgetprevyearbyregionpersector($sector)
    {
        $sql = 'SELECT region_name,PSWDO,CSWDO,MSWDO,(PSWDO+CSWDO+MSWDO) as Total
              FROM (select b.region_name,
              sum(if(a.lgu_type_id = 1,if(d.budget_previous_year <> 0,1,0),0)) as PSWDO,
              sum(if(a.lgu_type_id = 2,if(d.budget_previous_year <> 0,1,0),0)) as CSWDO,
              sum(if(a.lgu_type_id = 3,if(d.budget_previous_year <> 0,1,0),0)) as MSWDO
              from tbl_lswdo a
              inner join lib_regions b
              on a.region_code = b.region_code
              inner join tbl_lswdo_budget d
              on d.profile_id = a.profile_id
              where a.deleted = 0 and d.sector_id = '.$sector.'
              group by a.region_code
              ) as c;
    ' ;
        $query = $this->db->query($sql);
        $result = $query->result();
        return $result;
    }

    public function get_avePSWDObudgetpresentyearbyregion()
    {
        $sql = 'select
                c.region_name,
                sum(if(sector_id = 1,a.budget_present_year,0)) / sum(if(sector_id = 1,1,0)) as Children,
                sum(if(sector_id = 2,a.budget_present_year,0)) / sum(if(sector_id = 2,1,0)) as Youth,
                sum(if(sector_id = 3,a.budget_present_year,0)) / sum(if(sector_id = 3,1,0)) as Women,
                sum(if(sector_id = 4,a.budget_present_year,0)) / sum(if(sector_id = 4,1,0)) as FamilyandCommunity,
                sum(if(sector_id = 5,a.budget_present_year,0)) / sum(if(sector_id = 5,1,0))as SeniorCitizen,
                sum(if(sector_id = 6,a.budget_present_year,0)) / sum(if(sector_id = 6,1,0))as PWD,
                sum(if(sector_id = 7,a.budget_present_year,0)) / sum(if(sector_id = 7,1,0))as IDP
                from tbl_lswdo_budget a
                inner join tbl_lswdo b
                on a.profile_id = b.profile_id
                INNER JOIN lib_regions c
                on b.region_code = c.region_code
                where b.lgu_type_id = 1 and b.deleted = 0
                group by b.region_code;
    ' ;
        $query = $this->db->query($sql);
        $result = $query->result();
        return $result;
    }
    public function get_aveCSWDObudgetpresentyearbyregion()
    {
        $sql = 'select
                c.region_name,
                sum(if(sector_id = 1,a.budget_present_year,0)) / sum(if(sector_id = 1,1,0)) as Children,
                sum(if(sector_id = 2,a.budget_present_year,0)) / sum(if(sector_id = 2,1,0)) as Youth,
                sum(if(sector_id = 3,a.budget_present_year,0)) / sum(if(sector_id = 3,1,0)) as Women,
                sum(if(sector_id = 4,a.budget_present_year,0)) / sum(if(sector_id = 4,1,0)) as FamilyandCommunity,
                sum(if(sector_id = 5,a.budget_present_year,0)) / sum(if(sector_id = 5,1,0))as SeniorCitizen,
                sum(if(sector_id = 6,a.budget_present_year,0)) / sum(if(sector_id = 6,1,0))as PWD,
                sum(if(sector_id = 7,a.budget_present_year,0)) / sum(if(sector_id = 7,1,0))as IDP
                from tbl_lswdo_budget a
                inner join tbl_lswdo b
                on a.profile_id = b.profile_id
                INNER JOIN lib_regions c
                on b.region_code = c.region_code
                where b.lgu_type_id = 2 and b.deleted = 0
                group by b.region_code;
    ' ;
        $query = $this->db->query($sql);
        $result = $query->result();
        return $result;
    }
    public function get_aveMSWDObudgetpresentyearbyregion()
    {
        $sql = 'select
                c.region_name,
                sum(if(sector_id = 1,a.budget_present_year,0)) / sum(if(sector_id = 1,1,0)) as Children,
                sum(if(sector_id = 2,a.budget_present_year,0)) / sum(if(sector_id = 2,1,0)) as Youth,
                sum(if(sector_id = 3,a.budget_present_year,0)) / sum(if(sector_id = 3,1,0)) as Women,
                sum(if(sector_id = 4,a.budget_present_year,0)) / sum(if(sector_id = 4,1,0)) as FamilyandCommunity,
                sum(if(sector_id = 5,a.budget_present_year,0)) / sum(if(sector_id = 5,1,0))as SeniorCitizen,
                sum(if(sector_id = 6,a.budget_present_year,0)) / sum(if(sector_id = 6,1,0))as PWD,
                sum(if(sector_id = 7,a.budget_present_year,0)) / sum(if(sector_id = 7,1,0))as IDP
                from tbl_lswdo_budget a
                inner join tbl_lswdo b
                on a.profile_id = b.profile_id
                INNER JOIN lib_regions c
                on b.region_code = c.region_code
                where b.lgu_type_id = 3 and b.deleted = 0
                group by b.region_code;
    ' ;
        $query = $this->db->query($sql);
        $result = $query->result();
        return $result;
    }

    public function get_LSWDObudgetpresentyearbyregionpersector($sector)
    {
        $sql = 'SELECT region_name,PSWDO,CSWDO,MSWDO,(PSWDO+CSWDO+MSWDO) as Total
              FROM (select b.region_name,
              sum(if(a.lgu_type_id = 1,if(d.budget_present_year <> 0,1,0),0)) as PSWDO,
              sum(if(a.lgu_type_id = 2,if(d.budget_present_year <> 0,1,0),0)) as CSWDO,
              sum(if(a.lgu_type_id = 3,if(d.budget_present_year <> 0,1,0),0)) as MSWDO
              from tbl_lswdo a
              inner join lib_regions b
              on a.region_code = b.region_code
              inner join tbl_lswdo_budget d
              on d.profile_id = a.profile_id
              where a.deleted = 0 and d.sector_id = '.$sector.'
              group by a.region_code
              ) as c;;
    ' ;
        $query = $this->db->query($sql);
        $result = $query->result();
        return $result;
    }

    public function get_distributionofMSWDOFunctionalityregion()
    {
        $sql = 'SELECT e.region_name,
            sum(if(a.level_function_baseline = "Functional",1,0)) as "Functional",
            sum(if(a.level_function_baseline = "Fully Functional",1,0)) as "FullyFunctional",
            sum(if(a.level_function_baseline = "Partially Functional",1,0)) as "PartiallyFunctional"
            FROM `tbl_functionality` a
            inner join tbl_lswdo b
            on a.prof_id = b.profile_id
			inner join lib_regions e
			on b.region_code = e.region_code
            where b.deleted = 0 and b.lgu_type_id = 3
            group by e.region_name;
    ' ;
        $query = $this->db->query($sql);
        $result = $query->result();
        return $result;
    }

    public function get_distributionofCMSWDOFunctionalityprovince($regionlist,$provlist)
    {
        $sql = 'SELECT c.prov_name,
            sum(if(a.level_function_baseline = "Functional",1,0)) as "Functional",
            sum(if(a.level_function_baseline = "Fully Functional",1,0)) as "FullyFunctional",
            sum(if(a.level_function_baseline = "Partially Functional",1,0)) as "PartiallyFunctional"
            FROM `tbl_functionality` a
            inner join tbl_lswdo b
            on a.prof_id = b.profile_id
			inner join lib_provinces c
			on b.prov_code = c.prov_code
			inner join lib_regions e
			on b.region_code = e.region_code
            where b.deleted = 0 and b.lgu_type_id in (2,3)
			and b.region_code = '.$regionlist.'
			and b.prov_code = '.$provlist.'
            group by e.region_name;
    ' ;
        $query = $this->db->query($sql);
        $result = $query->result();
        return $result;
    }
//ranking pswdo score = baseline ; new score = updated
    public function get_pswdoscore($regionlist)
    {
        if($regionlist == 0)
        {
            $where = 'where b.deleted = 0 and b.lgu_type_id = 1';
        }
        else
        {
            $where = 'where b.deleted = 0 and b.lgu_type_id = 1 and b.region_code = "'.$regionlist.'"';
        }
        $sql = 'SELECT  c.region_name,d.prov_name,a.baseline_score,a.level_function_baseline
                FROM tbl_functionality a
                INNER JOIN tbl_lswdo b
                on a.prof_id = b.profile_id
                inner join lib_regions c
                on b.region_code = c.region_code
                inner join lib_provinces d
                on b.prov_code = d.prov_code
                '.$where.'
                order	by a.baseline_score desc;
                ' ;
        $query = $this->db->query($sql);
        $result = $query->result();
        return $result;
    }
    public function get_pswdonewscore($regionlist)
    {
        if($regionlist == 0)
        {
            $where = 'where b.deleted = 0 and b.lgu_type_id = 1';
        }
        else
        {
            $where = 'where b.deleted = 0 and b.lgu_type_id = 1 and b.region_code = "'.$regionlist.'"';
        }

        $sql = 'SELECT  c.region_name,d.prov_name,a.new_score,a.level_function_new
                FROM tbl_functionality a
                INNER JOIN tbl_lswdo b
                on a.prof_id = b.profile_id
                inner join lib_regions c
                on b.region_code = c.region_code
                inner join lib_provinces d
                on b.prov_code = d.prov_code
                '.$where.'
                order	by a.new_score desc;
    ' ;
        $query = $this->db->query($sql);
        $result = $query->result();
        return $result;
    }
    public function get_pswdoscoreLadder($regionlist)
    {
        if($regionlist == 0)
        {
            $where = 'where a.deleted = 0 and b.lgu_type_id = 1';
        }
        else
        {
            $where = 'where a.deleted = 0 and b.lgu_type_id = 1 and b.region_code = "'.$regionlist.'"';
        }
        $sql = 'SELECT c.region_name,d.prov_name,
                Sum(if(indicator_id LIKE "%-1%",1,0)) as Bronze,
                Sum(if(indicator_id LIKE "%-2%",1,0)) as Silver,
                Sum(if(indicator_id LIKE "%-3%",1,0)) as Gold
                FROM `tbl_lswdo_standard_indicators` a
                INNER JOIN tbl_lswdo b
                ON a.profile_id = b.profile_id
                inner join lib_regions c
                on b.region_code = c.region_code
                inner join lib_provinces d
                on b.prov_code = d.prov_code
                '.$where.'
                group by d.prov_name;' ;
        $query = $this->db->query($sql);
        $result = $query->result();
        return $result;
        //where a.deleted = 0 and b.region_code = '.$regionlist.' and b.lgu_type_id = 1
    }
    public function get_cswdoscoreLadder($regionlist,$provlist)
    {
        if($regionlist == 0)
        {
            $where = 'where a.deleted = 0 and b.lgu_type_id = 2';
        }
        else
        {
            $where = 'where a.deleted = 0 and b.region_code = "'.$regionlist.'" and b.prov_code = "'.$provlist.'" and b.lgu_type_id = 2';
        }
        $sql = 'SELECT d.prov_name, e.city_name,
                Sum(if(indicator_id LIKE "%-1%",1,0)) as Bronze,
                Sum(if(indicator_id LIKE "%-2%",1,0)) as Silver,
                Sum(if(indicator_id LIKE "%-3%",1,0)) as Gold
                FROM `tbl_lswdo_standard_indicators` a
                INNER JOIN tbl_lswdo b
                ON a.profile_id = b.profile_id
                inner join lib_regions c
                on b.region_code = c.region_code
                inner join lib_provinces d
                on b.prov_code = d.prov_code
				inner join lib_cities e
				on b.city_code = e.city_code
                '.$where.'
                group by e.city_name;' ;
        $query = $this->db->query($sql);
        $result = $query->result();
        return $result;
        // where a.deleted = 0 and b.region_code = '.$regionlist.' and b.prov_code = '.$provlist.' and b.lgu_type_id = 2
    }
    public function get_mswdoscoreLadder($regionlist,$provlist)
    {
        if($regionlist == 0)
        {
            $where = 'where a.deleted = 0 and b.lgu_type_id = 3';
        }
        else
        {
            $where = 'where a.deleted = 0 and b.region_code = "'.$regionlist.'" and b.prov_code = "'.$provlist.'" and b.lgu_type_id = 3';
        }
        $sql = 'SELECT d.prov_name, e.city_name,
                Sum(if(indicator_id LIKE "%-1%",1,0)) as Bronze,
                Sum(if(indicator_id LIKE "%-2%",1,0)) as Silver,
                Sum(if(indicator_id LIKE "%-3%",1,0)) as Gold
                FROM `tbl_lswdo_standard_indicators` a
                INNER JOIN tbl_lswdo b
                ON a.profile_id = b.profile_id
                inner join lib_regions c
                on b.region_code = c.region_code
                inner join lib_provinces d
                on b.prov_code = d.prov_code
				inner join lib_cities e
				on b.city_code = e.city_code
                '.$where.'
                group by e.city_name;' ;
        $query = $this->db->query($sql);
        $result = $query->result();
        return $result;
    }
//ranking cmswdo score = baseline ; new score = updated
    public function get_cmswdoscore($regionlist,$provlist)
    {
        if($regionlist == 0)
        {
            $where = 'where b.deleted = 0 and b.lgu_type_id in (2,3)';
        }
        else
        {
            if($provlist == 0)
            {
                $where = 'where b.deleted = 0 and b.lgu_type_id in (2,3)
        and b.region_code = "'.$regionlist.'"';
            }
            else
            {
                $where = 'where b.deleted = 0 and b.lgu_type_id in (2,3)
        and b.region_code = "'.$regionlist.'"
        and b.prov_code = "'.$provlist.'"';
            }

        }
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
        '.$where.'
        order by a.baseline_score desc;' ;
        $query = $this->db->query($sql);
        $result = $query->result();
        return $result;
//        where b.deleted = 0 and b.lgu_type_id in (2,3)
//    and b.region_code = '.$regionlist.'
//    and b.prov_code = '.$provlist.'
    }
    public function get_lswdoscore($regionlist,$provlist)
    {

        if($regionlist == 0)
        {
            $where = 'where b.deleted = 0 ';
        }
        else
        {
            if($provlist == 0)
            {
                $where = 'where b.deleted = 0
        and b.region_code = "'.$regionlist.'"';
            }
            else
            {
                $where = 'where b.deleted = 0
        and b.region_code = "'.$regionlist.'"
        and b.prov_code = "'.$provlist.'"';
            }

        }
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
        '.$where.'
        order by a.baseline_score desc;' ;
        $query = $this->db->query($sql);
        $result = $query->result();
        return $result;
    }

    public function get_lswdonewscore($regionlist,$provlist)
    {

        if($regionlist == 0)
        {
            $where = 'where b.deleted = 0 ';
        }
        else
        {
            if($provlist == 0)
            {
                $where = 'where b.deleted = 0
        and b.region_code = "'.$regionlist.'"';
            }
            else
            {
                $where = 'where b.deleted = 0
        and b.region_code = "'.$regionlist.'"
        and b.prov_code = "'.$provlist.'"';
            }

        }
        $sql = 'SELECT  c.region_name,d.prov_name,a.new_score,e.city_name,a.level_function_new
                FROM tbl_functionality a
                INNER JOIN tbl_lswdo b
                on a.prof_id = b.profile_id
                inner join lib_regions c
                on b.region_code = c.region_code
                inner join lib_provinces d
                on b.prov_code = d.prov_code
                left join lib_cities E
                on b.city_code = e.city_code
                '.$where.'
                order by a.new_score desc;' ;
        $query = $this->db->query($sql);
        $result = $query->result();
        return $result;
    }
    public function get_cmswdonewscore($regionlist,$provlist)
    {
        if($regionlist == 0)
        {
            $where = 'where b.deleted = 0 and b.lgu_type_id in (2,3)';
        }
        else
        {
            if($provlist == 0)
            {
                $where = 'where b.deleted = 0 and b.lgu_type_id in (2,3)
                and b.region_code = "'.$regionlist.'""';
            }
            else
            {
                $where = ' where b.deleted = 0 and b.lgu_type_id in (2,3)
                and b.region_code = "'.$regionlist.'"
                and b.prov_code = "'.$provlist.'"';
            }

        }
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
                '.$where.'
                order by a.new_score desc;' ;
        $query = $this->db->query($sql);
        $result = $query->result();
        return $result;
    }
//ranking cswdo score = baseline ; new score = updated
    public function get_cswdoscore($regionlist,$provlist)
    {
        if($regionlist == 0)
        {
            $where = 'where b.deleted = 0
                and b.lgu_type_id = 2
                and e.city_class <> ""';
        }
        else
        {
            if($provlist == 0)
            {
                $where = 'where b.deleted = 0
                and b.lgu_type_id = 2
                and e.city_class <> ""
                and b.region_code = "'.$regionlist.'"';
            }
            else
            {
                $where = 'where b.deleted = 0
                and b.lgu_type_id = 2
                and e.city_class <> ""
                and b.region_code = "'.$regionlist.'"
                and b.prov_code = "'.$provlist.'"';
            }

        }
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
                '.$where.'
                order by a.baseline_score desc;' ;
        $query = $this->db->query($sql);
        $result = $query->result();
        return $result;
    }
    public function get_cswdonewscore($regionlist,$provlist)
    {
        if($regionlist == 0)
        {
            $where = 'where b.deleted = 0
                and b.lgu_type_id = 2
                and e.city_class <> ""';
        }
        else
        {
            if($provlist == 0)
            {
                $where = 'where b.deleted = 0
                and b.lgu_type_id = 2
                and e.city_class <> ""
                and b.region_code = "'.$regionlist.'"';
            }
            else
            {
                $where = 'where b.deleted = 0
                and b.lgu_type_id = 2
                and e.city_class <> ""
                and b.region_code = "'.$regionlist.'"
                and b.prov_code = "'.$provlist.'"';
            }

        }
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
                '.$where.'
                order by a.new_score desc;' ;
        $query = $this->db->query($sql);
        $result = $query->result();
        return $result;
    }
//ranking mswdo score = baseline ; new score = updated
    public function get_mswdoscore($regionlist,$provlist)
    {
        if($regionlist == 0)
        {
            $where = 'where b.deleted = 0
                and b.lgu_type_id = 2
                and e.city_class = ""';
        }
        else
        {
            if($provlist == 0)
            {
                $where = 'where b.deleted = 0
                and b.lgu_type_id = 2
                and e.city_class = ""
                and b.region_code = "'.$regionlist.'"';
            }
            else
            {
                $where = 'where b.deleted = 0
                and b.lgu_type_id = 2
                and e.city_class = ""
                and b.region_code = "'.$regionlist.'"
                and b.prov_code = "'.$provlist.'"';

            }
        }
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
                '.$where.'
                order by a.baseline_score desc;' ;
        $query = $this->db->query($sql);
        $result = $query->result();
        return $result;
    }
    public function get_mswdonewscore($regionlist,$provlist)
    {
        if($regionlist == 0)
        {
            $where = 'where b.deleted = 0
                and b.lgu_type_id = 2
                and e.city_class = ""';
        }
        else
        {
            if($provlist == 0)
            {
                $where = 'where b.deleted = 0
                and b.lgu_type_id = 2
                and e.city_class = ""
                and b.region_code = "'.$regionlist.'"';
            }
            else
            {
                $where = 'where b.deleted = 0
                and b.lgu_type_id = 2
                and e.city_class = ""
                and b.region_code = "'.$regionlist.'"
                and b.prov_code = "'.$provlist.'"';

            }
        }
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
                '.$where.'
                order by a.new_score desc;' ;
        $query = $this->db->query($sql);
        $result = $query->result();
        return $result;
    }

    public function get_distributionCMSWDOall()
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
    public function get_distributionCSWDOall()
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
            where b.deleted = 0 and b.lgu_type_id = 2
            group by c.prov_name;';
        $query = $this->db->query($sql);
        $result = $query->result();
        return $result;
    }
    public function get_distributionMSWDOall()
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
            where b.deleted = 0 and b.lgu_type_id = 3
            group by c.prov_name;';
        $query = $this->db->query($sql);
        $result = $query->result();
        return $result;
    }


    //cmalvarez

    public function getPSBMainCategory(){

        $sql = 'SELECT
                psbrider_main_category_id,
                psbrider_main_category_title
                FROM `lib_psbrider_main_category`
                ;';
        $query = $this->db->query($sql);
        return $query->result_array();
        //return $query->result();
    }

    public function getPSBSubCategory($psbrider_main_category_id){
        /* $this->db->select('ref_id,profile_id,visit_count,visit_date,remarks');
         $this->db->order_by('visit_date','ASC');
         $query = $this->db->get_where('tbl_lswdo_monitoring', array('profile_id' => '9'));*/

        $sql = 'SELECT
                psbrider_sub_category_id,
                psbrider_main_category_id,
                psbrider_sub_category_title
                FROM `lib_psbrider_sub_category`
                WHERE psbrider_main_category_id = '.$psbrider_main_category_id.';';
        $query = $this->db->query($sql);
        return $query->result_array();
    }



    public function getPSBAnswer($regionlist,$psbrider_main_category_id,$psbrider_sub_category_id){
        if($regionlist == 0)
        {
            $where = 'where psbrider_main_category_id = "'.$psbrider_main_category_id.'"
                and psbrider_sub_category_id = "'.$psbrider_sub_category_id.'"
                and psbrider_answer = 1';
        }
        else
        {
            $where = 'where b.region_code = "'.$regionlist.'"
                and psbrider_main_category_id = "'.$psbrider_main_category_id.'"
                and psbrider_sub_category_id = "'.$psbrider_sub_category_id.'"
                and psbrider_answer = 1';
        }
        $sql = "SELECT count(a.psbrider_answer_id) as psbrider_answer_id, b.region_code, a.psbrider_main_category_title, a.psbrider_sub_category_title,a.psbrider_answer
                FROM `tbl_psbrider_answers` a
                LEFT OUTER JOIN tbl_lswdo b
                ON a.profile_id = b.profile_id ".$where."
                ;";
        $query = $this->db->query($sql);
        return $query->result_array();
        //return $query->result();
    }

   /* public function getP()
    {
        $sql = 'SELECT region_name,PSWDO,CSWDO,MSWDO,(PSWDO+CSWDO+MSWDO) as Total
                FROM (select b.region_name,
                sum(if(a.lgu_type_id = 1,1,0)) as PSWDO,
                sum(if(a.lgu_type_id = 2,1,0)) as CSWDO,
                sum(if(a.lgu_type_id = 3,1,0)) as MSWDO
                from tbl_lswdo a
                inner join lib_regions b
                on a.region_code = b.region_code
                where a.deleted = 0
                group by a.region_code
                ) as c;';
        $query = $this->db->query($sql);
        $result = $query->result();
        return $result;
    }*/

    //cmalvarez
    public function get_distributionPSWDObyregion()
    {
        $sql = 'SELECT region_name,PSWDO
                FROM (select b.region_name,
                sum(if(a.lgu_type_id = 1,1,0)) as PSWDO
                from tbl_lswdo a
                inner join lib_regions b
                on a.region_code = b.region_code
                where a.deleted = 0
                group by a.region_code
                ) as c
                ;';
        $query = $this->db->query($sql);
        $result = $query->result();
        return $result;
    }
    public function get_distributionCSWDObyregion()
    {
        $sql = 'SELECT region_name,CSWDO
                FROM (select b.region_name,
                 sum(if(a.lgu_type_id = 2,1,0)) as CSWDO
                from tbl_lswdo a
                inner join lib_regions b
                on a.region_code = b.region_code
                where a.deleted = 0
                group by a.region_code
                ) as c
                ;';
        $query = $this->db->query($sql);
        $result = $query->result();
        return $result;
    }
    public function get_distributionMSWDObyregion()
    {
        $sql = 'SELECT region_name,MSWDO
                FROM (select b.region_name,
                 sum(if(a.lgu_type_id = 3,1,0)) as MSWDO
                from tbl_lswdo a
                inner join lib_regions b
                on a.region_code = b.region_code
                where a.deleted = 0
                group by a.region_code
                ) as c
                ;';
        $query = $this->db->query($sql);
        $result = $query->result();
        return $result;
    }

    public function getBudgetUtil($sectorID)
    {
        $sql = 'select
                c.region_name,
                sum(if(b.lgu_type_id = 1,utilization,0)) / sum(if(b.lgu_type_id = 1,1,0))  as AverageUtilizationP,
                sum(if(b.lgu_type_id = 1,no_bene_served,0)) / sum(if(b.lgu_type_id = 1,1,0))  as BeneServedP,
                sum(if(b.lgu_type_id = 2,utilization,0)) / sum(if(b.lgu_type_id = 2,1,0)) as AverageUtilizationC,
                sum(if(b.lgu_type_id = 2,no_bene_served,0)) / sum(if(b.lgu_type_id = 2,1,0)) as BeneServedC,
                sum(if(b.lgu_type_id = 3,utilization,0)) / sum(if(b.lgu_type_id = 3,1,0)) as AverageUtilizationM,
                sum(if(b.lgu_type_id = 3,no_bene_served,0)) / sum(if(b.lgu_type_id = 3,1,0)) as BeneServedM
                from tbl_lswdo_budget a
                inner join tbl_lswdo b
                on a.profile_id = b.profile_id
                INNER JOIN lib_regions c
                on b.region_code = c.region_code
                where a.sector_id = '.$sectorID.'
                group by b.region_code;';
        $query = $this->db->query($sql);
        $result = $query->result();
        return $result;
    }
    public function getBudgetAlloc($sectorID)
    {
        $sql = 'select
                c.region_name,
                sum(if(b.lgu_type_id = 1,budget_present_year,0)) / sum(if(b.lgu_type_id = 1,1,0))  as BudgetPresentP,
                sum(if(b.lgu_type_id = 1,no_target_bene,0)) / sum(if(b.lgu_type_id = 1,1,0))  as BeneTargetP,
                sum(if(b.lgu_type_id = 2,budget_present_year,0)) / sum(if(b.lgu_type_id = 2,1,0)) as BudgetPresentC,
                sum(if(b.lgu_type_id = 2,no_target_bene,0)) / sum(if(b.lgu_type_id = 2,1,0)) as BeneTargetC,
                sum(if(b.lgu_type_id = 3,budget_present_year,0)) / sum(if(b.lgu_type_id = 3,1,0)) as BudgetPresentM,
                sum(if(b.lgu_type_id = 3,no_target_bene,0)) / sum(if(b.lgu_type_id = 3,1,0)) as BeneTargetM
                from tbl_lswdo_budget a
                inner join tbl_lswdo b
                on a.profile_id = b.profile_id
                INNER JOIN lib_regions c
                on b.region_code = c.region_code
                where a.sector_id = '.$sectorID.'
                group by b.region_code;';
        $query = $this->db->query($sql);
        $result = $query->result();
        return $result;
    }
    public function getLCPC($regCode,$provCode,$lguType)
    {
            if($lguType == 1){
                $sql = 'select c.prov_name,
                    SUM(IF(a.compliance_indicator_id = 1,1,0)) as ScoreIndicator
                    from tbl_lswdo_standard_indicators a
                    INNER JOIN tbl_lswdo b
                    ON a.profile_id = b.profile_id
                    INNER JOIN lib_provinces c
                    ON b.prov_code = c.prov_code
                    where indicator_id LIKE "%IIE%"
                    AND indicator_id LIKE "%-1%"
                    AND b.region_code = '.$regCode.'
                    AND b.lgu_type_id = 1
                    Group by b.prov_code;';
            } elseif($lguType == 2){
                $sql = 'select d.city_name,
                    SUM(IF(a.compliance_indicator_id = 1,1,0)) as ScoreIndicator
                    from tbl_lswdo_standard_indicators a
                    INNER JOIN tbl_lswdo b
                    ON a.profile_id = b.profile_id
                    INNER JOIN lib_provinces c
                    ON b.prov_code = c.prov_code
                    INNER JOIN lib_cities d
                    ON b.city_code = d.city_code
                    where indicator_id LIKE "%IIE%"
                    AND indicator_id LIKE "%-1%"
                    AND b.region_code = '.$regCode.'
                    AND b.prov_code = '.$provCode.'
                    AND d.city_class <> ""
                    AND b.lgu_type_id = 1
                    Group by b.prov_code;';
            } elseif($lguType == 3){
                $sql = 'select d.city_name,
                    SUM(IF(a.compliance_indicator_id = 1,1,0)) as ScoreIndicator
                    from tbl_lswdo_standard_indicators a
                    INNER JOIN tbl_lswdo b
                    ON a.profile_id = b.profile_id
                    INNER JOIN lib_provinces c
                    ON b.prov_code = c.prov_code
                    INNER JOIN lib_cities d
                    ON b.city_code = d.city_code
                    where indicator_id LIKE "%IIE%"
                    AND indicator_id LIKE "%-1%"
                    AND b.region_code = '.$regCode.'
                    AND b.prov_code = '.$provCode.'
                    AND d.city_class = ""
                    AND b.lgu_type_id = 1
                    Group by b.prov_code;';
            }
        $query = $this->db->query($sql);
        $result = $query->result();
        return $result;
    }
    public function getDRRMC($regCode,$provCode,$lguType)
    {
        if($lguType == 1){
            $sql = 'select c.prov_name,
                    SUM(IF(a.compliance_indicator_id = 1,1,0)) as ScoreIndicator
                    from tbl_lswdo_standard_indicators a
                    INNER JOIN tbl_lswdo b
                    ON a.profile_id = b.profile_id
                    INNER JOIN lib_provinces c
                    ON b.prov_code = c.prov_code
                    where indicator_id LIKE "%IIF%"
                    AND indicator_id LIKE "%-1%"
                    AND b.region_code = '.$regCode.'
                    AND b.lgu_type_id = 1
                    Group by b.prov_code;';
        } elseif($lguType == 2){
            $sql = 'select d.city_name,
                    SUM(IF(a.compliance_indicator_id = 1,1,0)) as ScoreIndicator
                    from tbl_lswdo_standard_indicators a
                    INNER JOIN tbl_lswdo b
                    ON a.profile_id = b.profile_id
                    INNER JOIN lib_provinces c
                    ON b.prov_code = c.prov_code
                    INNER JOIN lib_cities d
                    ON b.city_code = d.city_code
                    where indicator_id LIKE "%IIF%"
                    AND indicator_id LIKE "%-1%"
                    AND b.region_code = '.$regCode.'
                    AND b.prov_code = '.$provCode.'
                    AND d.city_class <> ""
                    AND b.lgu_type_id = 1
                    Group by b.prov_code;';
        } elseif($lguType == 3){
            $sql = 'select d.city_name,
                    SUM(IF(a.compliance_indicator_id = 1,1,0)) as ScoreIndicator
                    from tbl_lswdo_standard_indicators a
                    INNER JOIN tbl_lswdo b
                    ON a.profile_id = b.profile_id
                    INNER JOIN lib_provinces c
                    ON b.prov_code = c.prov_code
                    INNER JOIN lib_cities d
                    ON b.city_code = d.city_code
                    where indicator_id LIKE "%IIF%"
                    AND indicator_id LIKE "%-1%"
                    AND b.region_code = '.$regCode.'
                    AND b.prov_code = '.$provCode.'
                    AND d.city_class = ""
                    AND b.lgu_type_id = 1
                    Group by b.prov_code;';
        }
        $query = $this->db->query($sql);
        $result = $query->result();
        return $result;
    }
    //get total of assessed by region or province
    public function get_totalAssess($regCode,$provCode,$lguType)
    {
        if($regCode != 0){
            if($provCode != 0){
                if($lguType != 0){
                    $where2 = 'where
                    deleted = 0
                    and lgu_type_id = '.$lguType.'
                    and region_code = "'.$regCode.'"
                    and prov_code = "'.$provCode.'"';
                }
            } else {
                $where2 = 'where deleted = 0
                    and region_code = "'.$regCode.'"';
            }
        } else {
            $where2 = 'where deleted = 0
            and region_code = "'.$regCode.'"';
        }
        $sql = 'select count(*) as totalAssess from tbl_lswdo '.$where2;
        $query = $this->db->query($sql);
        $result = $query->row();
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
    //get All Regions
    public function get_AllRegion()
    {
        $sql = 'select region_code, region_name,region_nick from lib_regions';
        $query = $this->db->query($sql);
        $result = $query->result();
        return $result;
    }

    public function getRegionByCode($region_code)
    {
        $sql = "select region_code, region_name,region_nick
            from lib_regions where region_code = '".$region_code."';";
        $query = $this->db->query($sql);
        $result = $query->result_array();
        return $result;
    }

    //get All Prov by Reg
    public function get_AllProvByReg($regCode)
    {
        $sql = 'select prov_code, prov_name from lib_provinces where region_code = "'.$regCode.'"';
        $query = $this->db->query($sql);
        $result = $query->result();
        return $result;
    }
    //get All Prov by Reg
    public function get_AllCityByProv($provCode)
    {
        $sql = 'select city_code, city_name from lib_cities where city_class <> "" and prov_code = "'.$provCode.'"';
        $query = $this->db->query($sql);
        $result = $query->result();
        return $result;
    }
    //get All Prov by Reg
    public function get_AllMuniByProv($provCode)
    {
        $sql = 'select city_code, city_name from lib_cities where city_class = "" and prov_code = "'.$provCode.'"';
        $query = $this->db->query($sql);
        $result = $query->result();
        return $result;
    }


    public function getAllRegion()
    {
        $sql = 'select b.region_code,b.region_name from  lib_regions b where b.region_code <> 000000000';
        $query = $this->db->query($sql);
        $result = $query->result();
        return $result;
    }

    public function getUniverse($regionCode)
    {
        $sql = 'select
                sum(if(a.lgu_type_id = 1,1,0)) as PSWDO,
                sum(if(a.lgu_type_id = 2,1,0)) as CSWDO,
                sum(if(a.lgu_type_id = 3,1,0)) as MSWDO
                from tbl_lswdo a
                where a.deleted = 0 and a.region_code = '.$regionCode;
        $query = $this->db->query($sql);
        $result = $query->row();
        return $result;
    }
    public function countProv($regionCode)
    {
        $sql = 'select COUNT(a.prov_name) as total_prov
                from lib_provinces  a where a.region_code ='.$regionCode;
        $query = $this->db->query($sql);
        $result = $query->row();
        return $result;
    }
    public function getAllProv($regionCode)
    {
        $sql = 'select prov_code,prov_name from lib_provinces where region_code = '.$regionCode;
        $query = $this->db->query($sql);
        $result = $query->result();
        return $result;
    }
    public function getAllCity($provCode)
    {
        $sql = 'select COUNT(city_name)as total_city
          from lib_cities where prov_code = '.$provCode.' AND city_class <> "";';
        $query = $this->db->query($sql);
        $result = $query->row();
        return $result;
    }

    public function getAllMuni($provCode)
    {
        $sql = 'select COUNT(city_name)as total_city
          from lib_cities where prov_code = '.$provCode.' AND city_class = "";';
        $query = $this->db->query($sql);
        $result = $query->row();
        return $result;
    }
    public function getMaxVisit()
    {
        $sql = 'select visit_count from tbl_lswdo_monitoring ORDER BY visit_count desc limit 1;';
        $query = $this->db->query($sql);
        $result = $query->row();
        return $result;
    }
    public function getVisitScore($regionCode,$visitCount,$lguType)
    {
        $sql = 'select
                sum(if(a.visit_count = '.$visitCount.',1,0)) as scoreVisit ,b.region_code
                from tbl_lswdo_monitoring a
                inner join tbl_lswdo b
                on a.profile_id = b.profile_id
                where b.lgu_type_id = '.$lguType.' and b.region_code='.$regionCode;
        $query = $this->db->query($sql);
        $result = $query->row();
        return $result;
    }
    public function getVisitStatusDate($regionCode,$visitCount,$lguType)
{
    $sql = 'select
                sum(if(a.visit_count = '.$visitCount.',1,0)) as scoreVisit ,b.region_code
                from tbl_lswdo_monitoring a
                inner join tbl_lswdo b
                on a.profile_id = b.profile_id
                where b.lgu_type_id = '.$lguType.' and b.region_code='.$regionCode;
    $query = $this->db->query($sql);
    $result = $query->row();
    return $result;
}

}