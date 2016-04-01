<?php

class indicator_model extends CI_Model
{
    public function getLSWDOdata($profID,$ref_id){
        $this->db->select('profile_id, indicator_id, compliance_indicator_id, findings_recom');
        $query = $this->db->get_where('tbl_lswdo_standard_indicators', array('profile_id' => $profID , 'DELETED' => 0, 'ref_id' => $ref_id));
        return $query->result();
    }
    public function getScorePerProf($profID,$ref_id){
        $sql = 'select  b.lgu_type_id, SUM(IF(a.compliance_indicator_id = 1, 1, 0)) as TotalScore,
                case b.lgu_type_id
                when 1 then (SUM(IF(a.compliance_indicator_id = 1, 1, 0)) / 78) * 100
                when 2 then (SUM(IF(a.compliance_indicator_id = 1, 1, 0)) / 91) * 100
                when 3 then (SUM(IF(a.compliance_indicator_id = 1, 1, 0)) / 91) * 100
                end as FinalScore
                FROM tbl_lswdo_standard_indicators a
                INNER JOIN tbl_lswdo b
                ON a.profile_id = b.profile_id
                where a.deleted = 0 and a.indicator_id LIKE "%-1%"  and b.profile_id ='.$profID.' and a.ref_id = '.$ref_id.';';
        $query = $this->db->query($sql);
        return  $query->row();



    }
    public function getCheckPart1($profID,$ref_id){
        $this->db->select('profile_id, indicator_id, compliance_indicator_id, findings_recom');
        $query = $this->db->get_where('tbl_lswdo_standard_indicators', array('profile_id' => $profID, 'indicator_id' => 'IA1-1', 'DELETED' => 0, 'ref_id' => $ref_id));
        return $query->row();
    }
    public function getCheckPart2($profID,$ref_id){
        $this->db->select('profile_id, indicator_id, compliance_indicator_id, findings_recom');
        $query = $this->db->get_where('tbl_lswdo_standard_indicators', array('profile_id' => $profID, 'indicator_id' => 'IIA1-1', 'DELETED' => 0, 'ref_id' => $ref_id));
        return $query->row();
    }
    public function getCheckPart3($profID,$ref_id){
        $this->db->select('profile_id, indicator_id, compliance_indicator_id, findings_recom');
        $query = $this->db->get_where('tbl_lswdo_standard_indicators', array('profile_id' => $profID, 'indicator_id' => 'IIIA11-1', 'DELETED' => 0, 'ref_id' => $ref_id));
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

    public function insertFirstIndicator($profileID,$indicator_id, $compliance, $findings,$refID){
        $this->db->trans_begin();
        $this->db->query('Insert into tbl_lswdo_standard_indicators(profile_id, indicator_id, compliance_indicator_id,findings_recom,ref_id,DELETED)
                          VALUES(
                          "'.$profileID.'",
                          "'.$indicator_id.'",
                          "'.$compliance.'",
                          "'.$findings.'",
                          "'.$refID.'",
                          "0"
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
    public function updateIndicator($profileID,$indicator_id, $compliance, $findings,$refID){
        $this->db->trans_begin();
        $this->db->query('update tbl_lswdo_standard_indicators SET
                            compliance_indicator_id = '.$compliance.' ,
                            findings_recom = "'.$findings.'"
                            where profile_id = '.$profileID.' and indicator_id = "'.$indicator_id.'" and ref_id = '.$refID.' ;');
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
    public function deleteIndicator($profileID,$ref_id){

        $unformat1 = "";
        foreach($this->getdeleteCategoriesFromFI() as $secondCat):
            $unformat1 .= "'".$secondCat->indicator_id."',";
        endforeach;
        $format1 = substr($unformat1,0,-1);

        $unformat = "";
        foreach($this->getdeleteSecondCategoriesFromFI() as $secondCat):
            $unformat .= "'".$secondCat->indicator_id."',";
        endforeach;
        $format = substr($unformat,0,-1);

        $this->db->trans_begin();
        $this->db->query('update tbl_lswdo_standard_indicators SET
                            DELETED = 1
                            where profile_id = '.$profileID.' and ref_id = '.$ref_id.' and indicator_id  IN ('.$format1.','.$format.');');
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

    public function getdeleteCategoriesFromFI(){
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
    public function getdeleteSecondCategoriesFromFI(){
        $unformat = "";
        foreach($this->getdeleteCategoriesFromFI() as $secondCat):
            $unformat .= "'".$secondCat->indicator_id."',";
        endforeach;
        $format = substr($unformat,0,-1);

        $sql = 'SELECT `indicator_id`, `mother_indicator_id`, `indicator_name`, indicator_checklist_id
                FROM (`lib_indicator_codes`)
                WHERE `mother_indicator_id` IN ('.$format.')';
        $query = $this->db->query($sql);
        return  $query->result();
    }


    public function deleteIndicatorpart2($profileID,$ref_id){

        $unformat1 = "";
        foreach($this->getdeleteCategoriesFromSI() as $secondCat):
            $unformat1 .= "'".$secondCat->indicator_id."',";
        endforeach;
        $format1 = substr($unformat1,0,-1);

        $unformat = "";
        foreach($this->getdeleteSecondCategoriesFromSI() as $secondCat):
            $unformat .= "'".$secondCat->indicator_id."',";
        endforeach;
        $format = substr($unformat,0,-1);

        $unformat2 = "";
        foreach($this->getdeleteSecondCategoriesLowerFromSI() as $secondCat):
            $unformat2 .= "'".$secondCat->indicator_id."',";
        endforeach;
        $format2 = substr($unformat2,0,-1);

        $unformat3 = "";
        foreach($this->getdeleteSecondCategoriesLowerLowerFromSI() as $secondCat):
            $unformat3 .= "'".$secondCat->indicator_id."',";
        endforeach;
        $format3 = substr($unformat3,0,-1);

        $this->db->trans_begin();
        $this->db->query('update tbl_lswdo_standard_indicators SET
                            DELETED = 1
                            where profile_id = '.$profileID.' and ref_id = '.$ref_id.' and indicator_id  IN ('.$format1.','.$format.','.$format2.','.$format3.');');
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
    public function getdeleteCategoriesFromSI(){
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

    public function getdeleteSecondCategoriesFromSI(){
        $unformat = "";
        foreach($this->getdeleteCategoriesFromSI() as $secondCat):
            $unformat .= "'".$secondCat->indicator_id."',";
        endforeach;
        $format = substr($unformat,0,-1);

        $sql = 'SELECT `indicator_id`, `mother_indicator_id`, `indicator_name`, indicator_checklist_id
                FROM (`lib_indicator_codes`)
                WHERE `mother_indicator_id` IN ('.$format.')';
        $query = $this->db->query($sql);
        return  $query->result();
    }
    public function getdeleteSecondCategoriesLowerFromSI(){
        $unformat = "";
        foreach($this->getdeleteSecondCategoriesFromSI() as $secondCat):
            $unformat .= "'".$secondCat->indicator_id."',";
        endforeach;
        $format = substr($unformat,0,-1);

        $sql = 'SELECT `indicator_id`, `mother_indicator_id`, `indicator_name`, indicator_checklist_id
                FROM (`lib_indicator_codes`)
                WHERE `mother_indicator_id` IN ('.$format.')';
        $query = $this->db->query($sql);
        return  $query->result();
    }
    public function getdeleteSecondCategoriesLowerLowerFromSI(){
        $unformat = "";
        foreach($this->getdeleteSecondCategoriesLowerFromSI() as $secondCat):
            $unformat .= "'".$secondCat->indicator_id."',";
        endforeach;
        $format = substr($unformat,0,-1);

        $sql = 'SELECT `indicator_id`, `mother_indicator_id`, `indicator_name`, indicator_checklist_id
                FROM (`lib_indicator_codes`)
                WHERE `mother_indicator_id` IN ('.$format.')';
        $query = $this->db->query($sql);
        return  $query->result();
    }

    public function deleteIndicatorpart3($profileID,$ref_id){

        $unformat1 = "";
        foreach($this->getdeleteCategoriesFromTI() as $secondCat):
            $unformat1 .= "'".$secondCat->indicator_id."',";
        endforeach;
        $format1 = substr($unformat1,0,-1);

        $unformat = "";
        foreach($this->getdeleteSecondCategoriesFromTI() as $secondCat):
            $unformat .= "'".$secondCat->indicator_id."',";
        endforeach;
        $format = substr($unformat,0,-1);

        $this->db->trans_begin();
        $this->db->query('update tbl_lswdo_standard_indicators SET
                            DELETED = 1
                            where profile_id = '.$profileID.' and ref_id = '.$ref_id.' and indicator_id  IN ('.$format1.','.$format.');');
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

    public function getdeleteCategoriesFromTI(){
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
    public function getdeleteSecondCategoriesFromTI(){
        $unformat = "";
        foreach($this->getdeleteCategoriesFromTI() as $secondCat):
            $unformat .= "'".$secondCat->indicator_id."',";
        endforeach;
        $format = substr($unformat,0,-1);

        $sql = 'SELECT `indicator_id`, `mother_indicator_id`, `indicator_name`, indicator_checklist_id
                FROM (`lib_indicator_codes`)
                WHERE `mother_indicator_id` IN ('.$format.')';
        $query = $this->db->query($sql);
        return  $query->result();
    }

}