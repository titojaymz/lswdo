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

    public function getSecondMotherIndicator(){
        $this->db->select('indicator_id,mother_indicator_id,indicator_name');
        $this->db->order_by('indicator_name','ASC');
        $query = $this->db->get_where('lib_indicator_codes', array('indicator_id' => 'II'));
        return $query->row();
    }
    public function getSecondIndicators(){
        $this->db->select('indicator_id,mother_indicator_id,indicator_name');
        $this->db->order_by('indicator_name','ASC');
        $query = $this->db->get_where('lib_indicator_codes', array('mother_indicator_id' => 'II'));
        return $query->result();
    }
    public function getCategoriesFromSI(){
        $unformat = "";
        foreach($this->getSecondIndicators() as $secondIndicators):
            $unformat .= "'".$secondIndicators->indicator_id."',";
        endforeach;
        $format = substr($unformat,0,-1);

        $sql = 'SELECT `indicator_id`, `mother_indicator_id`, `indicator_name`, indicator_checklist_id
                FROM (`lib_indicator_codes`)
                WHERE `mother_indicator_id` IN ('.$format.')';
        $query = $this->db->query($sql);
        return  $query->result();
    }

    public function getSecondCategoriesFromSI(){
        $unformat = "";
        foreach($this->getCategoriesFromSI() as $secondCat):
            $unformat .= "'".$secondCat->indicator_id."',";
        endforeach;
        $format = substr($unformat,0,-1);

        $sql = 'SELECT `indicator_id`, `mother_indicator_id`, `indicator_name`, indicator_checklist_id
                FROM (`lib_indicator_codes`)
                WHERE `mother_indicator_id` IN ('.$format.')';
        $query = $this->db->query($sql);
        return  $query->result();
    }
    public function getSecondCategoriesLowerFromSI(){
        $unformat = "";
        foreach($this->getSecondCategoriesFromSI() as $secondCat):
            $unformat .= "'".$secondCat->indicator_id."',";
        endforeach;
        $format = substr($unformat,0,-1);

        $sql = 'SELECT `indicator_id`, `mother_indicator_id`, `indicator_name`, indicator_checklist_id
                FROM (`lib_indicator_codes`)
                WHERE `mother_indicator_id` IN ('.$format.')';
        $query = $this->db->query($sql);
        return  $query->result();
    }
    public function getSecondCategoriesLowerLowerFromSI(){
        $unformat = "";
        foreach($this->getSecondCategoriesLowerFromSI() as $secondCat):
            $unformat .= "'".$secondCat->indicator_id."',";
        endforeach;
        $format = substr($unformat,0,-1);

        $sql = 'SELECT `indicator_id`, `mother_indicator_id`, `indicator_name`, indicator_checklist_id
                FROM (`lib_indicator_codes`)
                WHERE `mother_indicator_id` IN ('.$format.')';
        $query = $this->db->query($sql);
        return  $query->result();
    }

    public function getThirdMotherIndicator(){
        $this->db->select('indicator_id,mother_indicator_id,indicator_name');
        $this->db->order_by('indicator_name','ASC');
        $query = $this->db->get_where('lib_indicator_codes', array('indicator_id' => 'III'));
        return $query->row();
    }
    public function getThirdIndicators(){
        $this->db->select('indicator_id,mother_indicator_id,indicator_name');
        $this->db->order_by('indicator_name','ASC');
        $query = $this->db->get_where('lib_indicator_codes', array('mother_indicator_id' => 'III'));
        return $query->result();
    }
    public function getCategoriesFromTI(){
        $unformat = "";
        foreach($this->getThirdIndicators() as $firstIndicators):
            $unformat .= "'".$firstIndicators->indicator_id."',";
        endforeach;
        $format = substr($unformat,0,-1);

        $sql = 'SELECT `indicator_id`, `mother_indicator_id`, `indicator_name`, indicator_checklist_id
                FROM (`lib_indicator_codes`)
                WHERE `mother_indicator_id` IN ('.$format.')';
        $query = $this->db->query($sql);
        return  $query->result();
    }

    public function getSecondCategoriesFromTI(){
        $unformat = "";
        foreach($this->getCategoriesFromTI() as $secondCat):
            $unformat .= "'".$secondCat->indicator_id."',";
        endforeach;
        $format = substr($unformat,0,-1);

        $sql = 'SELECT `indicator_id`, `mother_indicator_id`, `indicator_name`, indicator_checklist_id
                FROM (`lib_indicator_codes`)
                WHERE `mother_indicator_id` IN ('.$format.')';
        $query = $this->db->query($sql);
        return  $query->result();
    }

    public function getSecondCategoriesLowerFromTI(){
        $unformat = "";
        foreach($this->getSecondCategoriesFromTI() as $secondCat):
            $unformat .= "'".$secondCat->indicator_id."',";
        endforeach;
        $format = substr($unformat,0,-1);

        $sql = 'SELECT `indicator_id`, `mother_indicator_id`, `indicator_name`, indicator_checklist_id
                FROM (`lib_indicator_codes`)
                WHERE `mother_indicator_id` IN ('.$format.')';
        $query = $this->db->query($sql);
        return  $query->result();
    }
//
//    public function getSecondCategoriesLowerLowerFromTI(){
//        $unformat = "";
//        foreach($this->getSecondCategoriesLowerFromTI() as $secondCat):
//            $unformat .= "'".$secondCat->indicator_id."',";
//        endforeach;
//        $format = substr($unformat,0,-1);
//
//        $sql = 'SELECT `indicator_id`, `mother_indicator_id`, `indicator_name`, indicator_checklist_id
//                FROM (`lib_indicator_codes`)
//                WHERE `mother_indicator_id` IN ('.$format.')';
//        $query = $this->db->query($sql);
//        return  $query->result();
//    }
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