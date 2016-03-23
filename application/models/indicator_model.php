<?php

class indicator_model extends CI_Model
{
    public function getLSWDOdata($profID){
        $this->db->select('profile_id, indicator_id, compliance_indicator_id, findings_recom');
        $query = $this->db->get_where('tbl_lswdo_standard_indicators', array('profile_id' => $profID));
        return $query->result();
    }
    public function getCheckPart1($profID){
        $this->db->select('profile_id, indicator_id, compliance_indicator_id, findings_recom');
        $query = $this->db->get_where('tbl_lswdo_standard_indicators', array('profile_id' => $profID, 'indicator_id' => 'IA1-1'));
        return $query->row();
    }
    public function getCheckPart2($profID){
        $this->db->select('profile_id, indicator_id, compliance_indicator_id, findings_recom');
        $query = $this->db->get_where('tbl_lswdo_standard_indicators', array('profile_id' => $profID, 'indicator_id' => 'IIA1-1'));
        return $query->row();
    }
    public function getCheckPart3($profID){
        $this->db->select('profile_id, indicator_id, compliance_indicator_id, findings_recom');
        $query = $this->db->get_where('tbl_lswdo_standard_indicators', array('profile_id' => $profID, 'indicator_id' => 'IIIA11-1'));
        return $query->row();
    }
    public function getLGUtype($profID){
        $this->db->select('lgu_type_id');
        $query = $this->db->get_where('tbl_lswdo', array('profile_id' => $profID));
        return $query->row();
    }
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
    public function getCategoriesFromFI($lguType){
        $unformat = "";
        foreach($this->getFirstIndicators() as $firstIndicators):
            $unformat .= "'".$firstIndicators->indicator_id."',";
        endforeach;
        $format = substr($unformat,0,-1);

        if($lguType == 1){
            $where2 = 'lgu_type_id IN (0,1)';
        } else {
            $where2 = 'lgu_type_id IN (0,2)';
        }

        $sql = 'SELECT `indicator_id`, `mother_indicator_id`, `indicator_name`, indicator_checklist_id
                FROM (`lib_indicator_codes`)
                WHERE `mother_indicator_id` IN ('.$format.') and '.$where2;
        $query = $this->db->query($sql);
        return  $query->result();
    }

    public function getSecondCategoriesFromFI($lguType){
        $unformat = "";
        foreach($this->getCategoriesFromFI($lguType) as $secondCat):
            $unformat .= "'".$secondCat->indicator_id."',";
        endforeach;
        $format = substr($unformat,0,-1);

        if($lguType == 1){
            $where2 = 'lgu_type_id IN (0,1)';
        } else {
            $where2 = 'lgu_type_id IN (0,2)';
        }
        $sql = 'SELECT `indicator_id`, `mother_indicator_id`, `indicator_name`, indicator_checklist_id
                FROM (`lib_indicator_codes`)
                WHERE `mother_indicator_id` IN ('.$format.') and '.$where2;
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
    public function getCategoriesFromSI($lguType){
        $unformat = "";
        foreach($this->getSecondIndicators() as $secondIndicators):
            $unformat .= "'".$secondIndicators->indicator_id."',";
        endforeach;
        $format = substr($unformat,0,-1);

        if($lguType == 1){
            $where2 = 'lgu_type_id IN (0,1)';
        } else {
            $where2 = 'lgu_type_id IN (0,2)';
        }

        $sql = 'SELECT `indicator_id`, `mother_indicator_id`, `indicator_name`, indicator_checklist_id
                FROM (`lib_indicator_codes`)
                WHERE `mother_indicator_id` IN ('.$format.') and '.$where2;
        $query = $this->db->query($sql);
        return  $query->result();
    }

    public function getSecondCategoriesFromSI($lguType){
        $unformat = "";
        foreach($this->getCategoriesFromSI($lguType) as $secondCat):
            $unformat .= "'".$secondCat->indicator_id."',";
        endforeach;
        $format = substr($unformat,0,-1);
        if($lguType == 1){
            $where2 = 'lgu_type_id IN (0,1)';
        } else {
            $where2 = 'lgu_type_id IN (0,2)';
        }
        $sql = 'SELECT `indicator_id`, `mother_indicator_id`, `indicator_name`, indicator_checklist_id
                FROM (`lib_indicator_codes`)
                WHERE `mother_indicator_id` IN ('.$format.') and '.$where2;
        $query = $this->db->query($sql);
        return  $query->result();
    }
    public function getSecondCategoriesLowerFromSI($lguType){
        $unformat = "";
        foreach($this->getSecondCategoriesFromSI($lguType) as $secondCat):
            $unformat .= "'".$secondCat->indicator_id."',";
        endforeach;
        $format = substr($unformat,0,-1);
        if($lguType == 1){
            $where2 = 'lgu_type_id IN (0,1)';
        } else {
            $where2 = 'lgu_type_id IN (0,2)';
        }
        $sql = 'SELECT `indicator_id`, `mother_indicator_id`, `indicator_name`, indicator_checklist_id
                FROM (`lib_indicator_codes`)
                WHERE `mother_indicator_id` IN ('.$format.') and '.$where2;
        $query = $this->db->query($sql);
        return  $query->result();
    }
    public function getSecondCategoriesLowerLowerFromSI($lguType){
        $unformat = "";
        foreach($this->getSecondCategoriesLowerFromSI($lguType) as $secondCat):
            $unformat .= "'".$secondCat->indicator_id."',";
        endforeach;
        $format = substr($unformat,0,-1);
        if($lguType == 1){
            $where2 = 'lgu_type_id IN (0,1)';
        } else {
            $where2 = 'lgu_type_id IN (0,2)';
        }
        $sql = 'SELECT `indicator_id`, `mother_indicator_id`, `indicator_name`, indicator_checklist_id
                FROM (`lib_indicator_codes`)
                WHERE `mother_indicator_id` IN ('.$format.') and '.$where2;
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
    public function getCategoriesFromTI($lguType){
        $unformat = "";
        foreach($this->getThirdIndicators() as $firstIndicators):
            $unformat .= "'".$firstIndicators->indicator_id."',";
        endforeach;
        $format = substr($unformat,0,-1);
        if($lguType == 1){
            $where2 = 'lgu_type_id IN (0,1)';
        } else {
            $where2 = 'lgu_type_id IN (0,2)';
        }
        $sql = 'SELECT `indicator_id`, `mother_indicator_id`, `indicator_name`, indicator_checklist_id
                FROM (`lib_indicator_codes`)
                WHERE `mother_indicator_id` IN ('.$format.') and '.$where2;
        $query = $this->db->query($sql);
        return  $query->result();
    }

    public function getSecondCategoriesFromTI($lguType){
        $unformat = "";
        foreach($this->getCategoriesFromTI($lguType) as $secondCat):
            $unformat .= "'".$secondCat->indicator_id."',";
        endforeach;
        $format = substr($unformat,0,-1);
        if($lguType == 1){
            $where2 = 'lgu_type_id IN (0,1)';
        } else {
            $where2 = 'lgu_type_id IN (0,2)';
        }
        $sql = 'SELECT `indicator_id`, `mother_indicator_id`, `indicator_name`, indicator_checklist_id
                FROM (`lib_indicator_codes`)
                WHERE `mother_indicator_id` IN ('.$format.') and '.$where2;
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
    public function updateIndicator($profileID,$indicator_id, $compliance, $findings){
        $this->db->trans_begin();
        $this->db->query('update tbl_lswdo_standard_indicators SET
                            compliance_indicator_id = '.$compliance.' ,
                            findings_recom = "'.$findings.'"
                            where profile_id = '.$profileID.' and indicator_id = "'.$indicator_id.'" ;');
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