<?php

class indicator_model extends CI_Model
{
    public function getFirstMotherIndicator(){
        $this->db->select('indicator_id,mother_indicator_id,indicator_name');
        $this->db->order_by('indicator_name','ASC');
        $query = $this->db->get_where('lib_indicator_codes', array('indicator_id' => 'I'));
        return $query->row();
    }

    public function getFirstIndicators(){
        $this->db->select('indicator_id,mother_indicator_id,indicator_name');
        $this->db->order_by('indicator_name','ASC');
        $query = $this->db->get_where('lib_indicator_codes', array('mother_indicator_id' => 'I'));
        return $query->result();
    }

    public function getCategoriesFromFI(){
        $unformat = "";
        foreach($this->getFirstIndicators() as $firstIndicators):
            $unformat .= "'".$firstIndicators->indicator_id."',";
        endforeach;
        $format = substr($unformat,0,-1);

//        $this->db->select('indicator_id,mother_indicator_id,indicator_name');
//        $this->db->from('lib_indicator_codes');
//        $this->db->where_in('mother_indicator_id',$format);
//        $this->db->order_by('indicator_name','ASC');
//        $query = $this->db->get();
//        return $this->db;.
        $sql = 'SELECT `indicator_id`, `mother_indicator_id`, `indicator_name`, indicator_checklist_id
                FROM (`lib_indicator_codes`)
                WHERE `mother_indicator_id` IN ('.$format.')';
        $query = $this->db->query($sql);
        return  $query->result();
    }

    public function getSecondCategoriesFromFI(){
        $unformat = "";
        foreach($this->getCategoriesFromFI() as $secondCat):
            $unformat .= "'".$secondCat->indicator_id."',";
        endforeach;
        $format = substr($unformat,0,-1);

        $sql = 'SELECT `indicator_id`, `mother_indicator_id`, `indicator_name`, indicator_checklist_id
                FROM (`lib_indicator_codes`)
                WHERE `mother_indicator_id` IN ('.$format.')';
        $query = $this->db->query($sql);
        return  $query->result();
    }

    public function insertFirstIndicator($profileID,$indicator_id, $compliance, $findings){
        $this->db->trans_begin();
        $this->db->query('Insert into tbl_lswdo_standard_indicators(profile_id, indicator_id, compliance_indicator_id,findings_recom)
                          VALUES(
                          "'.$profileID.'",
                          "'.$indicator_id.'",
                          "'.$compliance.'",
                          "'.$findings.'"
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