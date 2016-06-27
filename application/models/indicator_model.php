<?php

class indicator_model extends CI_Model
{
    public function getLSWDOdata($profID,$ref_id){
        $this->db->select('profile_id, indicator_id, compliance_indicator_id, findings_recom');
        $query = $this->db->get_where('tbl_lswdo_standard_indicators', array('profile_id' => $profID , 'DELETED' => 0, 'ref_id' => $ref_id));
        return $query->result();
    }
    //Updates
    public function getScorePerProf($profID,$ref_id){
        $sql = 'select  b.lgu_type_id, SUM(IF(a.newValue = 1, 1, 0)) as TotalScore,
                case b.lgu_type_id
                when 1 then (SUM(IF(a.newValue = 1, 1, 0)) / 78) * 100
                when 2 then (SUM(IF(a.newValue = 1, 1, 0)) / 91) * 100
                when 3 then (SUM(IF(a.newValue = 1, 1, 0)) / 91) * 100
                end as FinalScore
                FROM tbl_updates a
                INNER JOIN tbl_lswdo b
                ON a.profile_id = b.profile_id
                where a.indicator_id LIKE "%-1%"  and b.profile_id ='.$profID.' and a.ref_id = '.$ref_id.';';
        $query = $this->db->query($sql);
        return  $query->row();
    }
    //Baseline
    public function getBaselineScorePerProf($profID,$ref_id){
        $sql = 'select  b.lgu_type_id, SUM(IF(a.compliance_indicator_id = 1, 1, 0)) as TotalScore,
                case b.lgu_type_id
                when 1 then (SUM(IF(a.compliance_indicator_id = 1, 1, 0)) / 78) * 100
                when 2 then (SUM(IF(a.compliance_indicator_id = 1, 1, 0)) / 91) * 100
                when 3 then (SUM(IF(a.compliance_indicator_id = 1, 1, 0)) / 91) * 100
                end as FinalScore
                FROM tbl_lswdo_standard_indicators a
                INNER JOIN tbl_lswdo b
                ON a.profile_id = b.profile_id
                where a.deleted =0 and a.indicator_id LIKE "%-1%"  and b.profile_id ='.$profID.' and a.ref_id = '.$ref_id.';';
        $query = $this->db->query($sql);
        return  $query->row();
    }

    public function getBaselineScorePerProfSilver($profID,$ref_id){
        $sql = 'select  b.lgu_type_id, SUM(IF(a.compliance_indicator_id = 1, 1, 0)) as TotalScore,
                case b.lgu_type_id
                when 1 then (SUM(IF(a.compliance_indicator_id = 1, 1, 0)) / 78) * 100
                when 2 then (SUM(IF(a.compliance_indicator_id = 1, 1, 0)) / 91) * 100
                when 3 then (SUM(IF(a.compliance_indicator_id = 1, 1, 0)) / 91) * 100
                end as FinalScore
                FROM tbl_lswdo_standard_indicators a
                INNER JOIN tbl_lswdo b
                ON a.profile_id = b.profile_id
                where a.deleted =0 and a.indicator_id LIKE "%-2%"  and b.profile_id ='.$profID.' and a.ref_id = '.$ref_id.';';
        $query = $this->db->query($sql);
        return  $query->row();
    }
    public function getBaselineScorePerProfGold($profID,$ref_id){
        $sql = 'select  b.lgu_type_id, SUM(IF(a.compliance_indicator_id = 1, 1, 0)) as TotalScore,
                case b.lgu_type_id
                when 1 then (SUM(IF(a.compliance_indicator_id = 1, 1, 0)) / 78) * 100
                when 2 then (SUM(IF(a.compliance_indicator_id = 1, 1, 0)) / 91) * 100
                when 3 then (SUM(IF(a.compliance_indicator_id = 1, 1, 0)) / 91) * 100
                end as FinalScore
                FROM tbl_lswdo_standard_indicators a
                INNER JOIN tbl_lswdo b
                ON a.profile_id = b.profile_id
                where a.deleted =0 and a.indicator_id LIKE "%-3%"  and b.profile_id ='.$profID.' and a.ref_id = '.$ref_id.';';
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
    public function getCheckPart4($profID,$ref_id){
        $this->db->select('profile_id, indicator_id, compliance_indicator_id, findings_recom');
        $query = $this->db->get_where('tbl_lswdo_standard_indicators', array('profile_id' => $profID, 'indicator_id' => 'IV1-1', 'DELETED' => 0, 'ref_id' => $ref_id));
        return $query->row();
    }
    public function getLGUtype($profID){
        $this->db->select('lgu_type_id');
        $query = $this->db->get_where('tbl_lswdo', array('profile_id' => $profID));
        return $query->row();
    }

    //Updates
    public function getTotalScoreIndicatorsPart1($lguType,$profID,$ref_id){
        $unformat3 = "";
        foreach($this->getFirstIndicators() as $firstIndicators):
            $unformat3 .= "'".$firstIndicators->indicator_id."',";
        endforeach;
        $format3 = substr($unformat3,0,-1);

        $unformat2 = "";
        foreach($this->getCategoriesFromFI($lguType) as $secondCat):
            $unformat2 .= "'".$secondCat->indicator_id."',";
        endforeach;
        $format2 = substr($unformat2,0,-1);

        $unformat = "";
        foreach($this->getSecondCategoriesFromFI($lguType) as $firstIndicators):
            $unformat .= "'".$firstIndicators->indicator_id."',";
        endforeach;
        $format = substr($unformat,0,-1);


        $sql = 'select
                SUM(IF(indicator_id LIKE "%-1%",IF(newValue = 1,1,0),0)) as BronzeScoreCompliant,
                SUM(IF(indicator_id LIKE "%-2%",IF(newValue = 1,1,0),0)) as SilverScoreCompliant,
                SUM(IF(indicator_id LIKE "%-3%",IF(newValue = 1,1,0),0)) as GoldScoreCompliant
                FROM (`tbl_updates`)
                WHERE `indicator_id` IN ('.$format3.','.$format2.','.$format.') and profile_id = '.$profID.' and ref_id = '.$ref_id.';';
        $query = $this->db->query($sql);
        return  $query->row();
    }
    public function getTotalScoreIndicatorsPart2($lguType,$profID,$ref_id){
        $unformat = "";
        foreach($this->getSecondIndicators() as $secondIndicators):
            $unformat .= "'".$secondIndicators->indicator_id."',";
        endforeach;
        $format = substr($unformat,0,-1);

        $unformat2 = "";
        foreach($this->getCategoriesFromSI($lguType) as $secondCat):
            $unformat2 .= "'".$secondCat->indicator_id."',";
        endforeach;
        $format2 = substr($unformat2,0,-1);

        $unformat3 = "";
        foreach($this->getSecondCategoriesFromSI($lguType) as $secondCat):
            $unformat3 .= "'".$secondCat->indicator_id."',";
        endforeach;
        $format3 = substr($unformat3,0,-1);

        $unformat4 = "";
        foreach($this->getSecondCategoriesLowerFromSI($lguType) as $secondCat):
            $unformat4 .= "'".$secondCat->indicator_id."',";
        endforeach;
        $format4 = substr($unformat4,0,-1);

        if($lguType == 1){
            $where2 = 'lgu_type_id IN (0,1) AND indicator_checklist_id <> 0';
        } else {
            $where2 = 'lgu_type_id IN (0,2) AND indicator_checklist_id <> 0';
        }
        $sql = 'select
                SUM(IF(indicator_id LIKE "%-1%",IF(newValue = 1,1,0),0)) as BronzeScoreCompliant,
                SUM(IF(indicator_id LIKE "%-2%",IF(newValue = 1,1,0),0)) as SilverScoreCompliant,
                SUM(IF(indicator_id LIKE "%-3%",IF(newValue = 1,1,0),0)) as GoldScoreCompliant
                FROM (`tbl_updates`)
                WHERE `indicator_id` IN ('.$format.','.$format2.','.$format3.','.$format4.') and profile_id = '.$profID.' and ref_id = '.$ref_id.';';
        $query = $this->db->query($sql);
        return  $query->row();
    }
    public function getTotalScoreIndicatorsPart3($lguType,$profID,$ref_id){
        $unformat = "";
        foreach($this->getThirdIndicators() as $firstIndicators):
            $unformat .= "'".$firstIndicators->indicator_id."',";
        endforeach;
        $format = substr($unformat,0,-1);
        $unformat2 = "";
        foreach($this->getCategoriesFromTI($lguType) as $secondCat):
            $unformat2 .= "'".$secondCat->indicator_id."',";
        endforeach;
        $format2 = substr($unformat2,0,-1);
        $unformat3 = "";
        foreach($this->getSecondCategoriesFromTI($lguType) as $secondCat):
            $unformat3 .= "'".$secondCat->indicator_id."',";
        endforeach;
        $format3 = substr($unformat3,0,-1);

        if($lguType == 1){
            $where2 = 'lgu_type_id IN (0,1) AND indicator_checklist_id <> 0';
        } else {
            $where2 = 'lgu_type_id IN (0,2) AND indicator_checklist_id <> 0';
        }
        $sql = 'select
                SUM(IF(indicator_id LIKE "%-1%",IF(newValue = 1,1,0),0)) as BronzeScoreCompliant,
                SUM(IF(indicator_id LIKE "%-2%",IF(newValue = 1,1,0),0)) as SilverScoreCompliant,
                SUM(IF(indicator_id LIKE "%-3%",IF(newValue = 1,1,0),0)) as GoldScoreCompliant
                FROM (`tbl_updates`)
                WHERE `indicator_id` IN ('.$format.','.$format2.','.$format3.')and profile_id = '.$profID.' and ref_id = '.$ref_id.';';
        $query = $this->db->query($sql);
        return  $query->row();
    }
    public function getTotalScoreIndicatorsPart4($lguType,$profID,$ref_id){

        $fourth = $this->getFourthMotherIndicator()->indicator_id;
        $unformat = "";
        foreach($this->getFourthIndicators() as $firstIndicators):
            $unformat .= "'".$firstIndicators->indicator_id."',";
        endforeach;
        $format = substr($unformat,0,-1);
        $unformat2 = "";
        foreach($this->getCategoriesFromFourthI() as $firstIndicators):
            $unformat2 .= "'".$firstIndicators->indicator_id."',";
        endforeach;
        $format2 = substr($unformat2,0,-1);


        if($lguType == 1){
            $where2 = 'lgu_type_id IN (0,1) AND indicator_checklist_id <> 0';
        } else {
            $where2 = 'lgu_type_id IN (0,2) AND indicator_checklist_id <> 0';
        }
        $sql = 'select
                SUM(IF(indicator_id LIKE "%-1%",IF(newValue = 1,1,0),0)) as BronzeScoreCompliant,
                SUM(IF(indicator_id LIKE "%-2%",IF(newValue = 1,1,0),0)) as SilverScoreCompliant,
                SUM(IF(indicator_id LIKE "%-3%",IF(newValue = 1,1,0),0)) as GoldScoreCompliant
                FROM (`tbl_updates`)
                WHERE `indicator_id`IN ('.$format.','.$format2.',"'.$fourth.'")and profile_id = '.$profID.' and ref_id = '.$ref_id.';';
        $query = $this->db->query($sql);
        return  $query->row();
//        return  $sql;
    }

    //Baseline
    public function getBaselineTotalScoreIndicatorsPart1($lguType,$profID,$ref_id){
        $unformat3 = "";
        foreach($this->getFirstIndicators() as $firstIndicators):
            $unformat3 .= "'".$firstIndicators->indicator_id."',";
        endforeach;
        $format3 = substr($unformat3,0,-1);

        $unformat2 = "";
        foreach($this->getCategoriesFromFI($lguType) as $secondCat):
            $unformat2 .= "'".$secondCat->indicator_id."',";
        endforeach;
        $format2 = substr($unformat2,0,-1);

        $unformat = "";
        foreach($this->getSecondCategoriesFromFI($lguType) as $firstIndicators):
            $unformat .= "'".$firstIndicators->indicator_id."',";
        endforeach;
        $format = substr($unformat,0,-1);


        $sql = 'select
                SUM(IF(indicator_id LIKE "%-1%",IF(compliance_indicator_id = 1,1,0),0)) as BronzeScoreCompliant,
                SUM(IF(indicator_id LIKE "%-2%",IF(compliance_indicator_id = 1,1,0),0)) as SilverScoreCompliant,
                SUM(IF(indicator_id LIKE "%-3%",IF(compliance_indicator_id = 1,1,0),0)) as GoldScoreCompliant
                FROM (`tbl_lswdo_standard_indicators`)
                WHERE `indicator_id` IN ('.$format3.','.$format2.','.$format.') and profile_id = '.$profID.' and ref_id = '.$ref_id.' and deleted = 0;';
        $query = $this->db->query($sql);
        return  $query->row();
    }
    public function getBaselineTotalScoreIndicatorsPart2($lguType,$profID,$ref_id){
        $unformat = "";
        foreach($this->getSecondIndicators() as $secondIndicators):
            $unformat .= "'".$secondIndicators->indicator_id."',";
        endforeach;
        $format = substr($unformat,0,-1);

        $unformat2 = "";
        foreach($this->getCategoriesFromSI($lguType) as $secondCat):
            $unformat2 .= "'".$secondCat->indicator_id."',";
        endforeach;
        $format2 = substr($unformat2,0,-1);

        $unformat3 = "";
        foreach($this->getSecondCategoriesFromSI($lguType) as $secondCat):
            $unformat3 .= "'".$secondCat->indicator_id."',";
        endforeach;
        $format3 = substr($unformat3,0,-1);

        $unformat4 = "";
        foreach($this->getSecondCategoriesLowerFromSI($lguType) as $secondCat):
            $unformat4 .= "'".$secondCat->indicator_id."',";
        endforeach;
        $format4 = substr($unformat4,0,-1);

        $unformat5 = "";
        foreach($this->getSecondCategoriesLowerLowerFromSI($lguType) as $secondCat):
            $unformat5 .= "'".$secondCat->indicator_id."',";
        endforeach;
        $format5 = substr($unformat5,0,-1);

        if($lguType == 1){
            $where2 = 'lgu_type_id IN (0,1) AND indicator_checklist_id <> 0';
        } else {
            $where2 = 'lgu_type_id IN (0,2) AND indicator_checklist_id <> 0';
        }
        $sql = 'select
                SUM(IF(indicator_id LIKE "%-1%",IF(compliance_indicator_id = 1,1,0),0)) as BronzeScoreCompliant,
                SUM(IF(indicator_id LIKE "%-2%",IF(compliance_indicator_id = 1,1,0),0)) as SilverScoreCompliant,
                SUM(IF(indicator_id LIKE "%-3%",IF(compliance_indicator_id = 1,1,0),0)) as GoldScoreCompliant
                FROM (`tbl_lswdo_standard_indicators`)
                WHERE `indicator_id` IN ('.$format.','.$format2.','.$format3.','.$format4.','.$format5.') and profile_id = '.$profID.' and ref_id = '.$ref_id.' and deleted = 0;';
        $query = $this->db->query($sql);
        return  $query->row();
    }
    public function getBaselineTotalScoreIndicatorsPart3($lguType,$profID,$ref_id){
        $unformat = "";
        foreach($this->getThirdIndicators() as $firstIndicators):
            $unformat .= "'".$firstIndicators->indicator_id."',";
        endforeach;
        $format = substr($unformat,0,-1);
        $unformat2 = "";
        foreach($this->getCategoriesFromTI($lguType) as $secondCat):
            $unformat2 .= "'".$secondCat->indicator_id."',";
        endforeach;
        $format2 = substr($unformat2,0,-1);
        $unformat3 = "";
        foreach($this->getSecondCategoriesFromTI($lguType) as $secondCat):
            $unformat3 .= "'".$secondCat->indicator_id."',";
        endforeach;
        $format3 = substr($unformat3,0,-1);

        if($lguType == 1){
            $where2 = 'lgu_type_id IN (0,1) AND indicator_checklist_id <> 0';
        } else {
            $where2 = 'lgu_type_id IN (0,2) AND indicator_checklist_id <> 0';
        }
        $sql = 'select
                SUM(IF(indicator_id LIKE "%-1%",IF(compliance_indicator_id = 1,1,0),0)) as BronzeScoreCompliant,
                SUM(IF(indicator_id LIKE "%-2%",IF(compliance_indicator_id = 1,1,0),0)) as SilverScoreCompliant,
                SUM(IF(indicator_id LIKE "%-3%",IF(compliance_indicator_id = 1,1,0),0)) as GoldScoreCompliant
                FROM (`tbl_lswdo_standard_indicators`)
                WHERE `indicator_id` IN ('.$format.','.$format2.','.$format3.') and profile_id = '.$profID.' and ref_id = '.$ref_id.' and deleted = 0;';
        $query = $this->db->query($sql);
        return  $query->row();
    }
    public function getBaselineTotalScoreIndicatorsPart4($lguType,$profID,$ref_id){

        $fourth = $this->getFourthMotherIndicator()->indicator_id;
        $unformat = "";
        foreach($this->getFourthIndicators() as $firstIndicators):
            $unformat .= "'".$firstIndicators->indicator_id."',";
        endforeach;
        $format = substr($unformat,0,-1);
        $unformat2 = "";
        foreach($this->getCategoriesFromFourthI() as $firstIndicators):
            $unformat2 .= "'".$firstIndicators->indicator_id."',";
        endforeach;
        $format2 = substr($unformat2,0,-1);


        if($lguType == 1){
            $where2 = 'lgu_type_id IN (0,1) AND indicator_checklist_id <> 0';
        } else {
            $where2 = 'lgu_type_id IN (0,2) AND indicator_checklist_id <> 0';
        }
        $sql = 'select
                SUM(IF(indicator_id LIKE "%-1%",IF(compliance_indicator_id = 1,1,0),0)) as BronzeScoreCompliant,
                SUM(IF(indicator_id LIKE "%-2%",IF(compliance_indicator_id = 1,1,0),0)) as SilverScoreCompliant,
                SUM(IF(indicator_id LIKE "%-3%",IF(compliance_indicator_id = 1,1,0),0)) as GoldScoreCompliant
                FROM (`tbl_lswdo_standard_indicators`)
                WHERE `indicator_id` IN  ('.$format.','.$format2.',"'.$fourth.'")and profile_id = '.$profID.' and ref_id = '.$ref_id.' and deleted = 0;';
        $query = $this->db->query($sql);
        return  $query->row();
//        return  $sql;
    }

    public function getTotalIndicatorsPart1($lguType){
    $unformat3 = "";
    foreach($this->getFirstIndicators() as $firstIndicators):
        $unformat3 .= "'".$firstIndicators->indicator_id."',";
    endforeach;
    $format3 = substr($unformat3,0,-1);

    $unformat2 = "";
    foreach($this->getCategoriesFromFI($lguType) as $secondCat):
        $unformat2 .= "'".$secondCat->indicator_id."',";
    endforeach;
    $format2 = substr($unformat2,0,-1);

    $unformat = "";
    foreach($this->getSecondCategoriesFromFI($lguType) as $firstIndicators):
        $unformat .= "'".$firstIndicators->indicator_id."',";
    endforeach;
    $format = substr($unformat,0,-1);


    if($lguType == 1){
        $where2 = 'lgu_type_id IN (0,1) AND indicator_checklist_id <> 0';
    } else {
        $where2 = 'lgu_type_id IN (0,2) AND indicator_checklist_id <> 0';
    }
    $sql = 'select Sum(if(indicator_checklist_id = 1, 1,0)) as Bronze,
                         Sum(if(indicator_checklist_id = 2, 1,0)) as Silver,
                         Sum(if(indicator_checklist_id = 3, 1,0)) as Gold
                FROM (`lib_indicator_codes`)
                WHERE `mother_indicator_id` IN ('.$format3.','.$format2.') and '.$where2;
    $query = $this->db->query($sql);
    return  $query->row();
}
    public function getTotalIndicatorsPart2($lguType){
        $unformat = "";
        foreach($this->getSecondIndicators() as $secondIndicators):
            $unformat .= "'".$secondIndicators->indicator_id."',";
        endforeach;
        $format = substr($unformat,0,-1);

        $unformat2 = "";
        foreach($this->getCategoriesFromSI($lguType) as $secondCat):
            $unformat2 .= "'".$secondCat->indicator_id."',";
        endforeach;
        $format2 = substr($unformat2,0,-1);

        $unformat3 = "";
        foreach($this->getSecondCategoriesFromSI($lguType) as $secondCat):
            $unformat3 .= "'".$secondCat->indicator_id."',";
        endforeach;
        $format3 = substr($unformat3,0,-1);

        $unformat4 = "";
        foreach($this->getSecondCategoriesLowerFromSI($lguType) as $secondCat):
            $unformat4 .= "'".$secondCat->indicator_id."',";
        endforeach;
        $format4 = substr($unformat4,0,-1);

        if($lguType == 1){
            $where2 = 'lgu_type_id IN (0,1) AND indicator_checklist_id <> 0';
        } else {
            $where2 = 'lgu_type_id IN (0,2) AND indicator_checklist_id <> 0';
        }
        $sql = 'select Sum(if(indicator_checklist_id = 1, 1,0)) as Bronze,
                         Sum(if(indicator_checklist_id = 2, 1,0)) as Silver,
                         Sum(if(indicator_checklist_id = 3, 1,0)) as Gold
                FROM (`lib_indicator_codes`)
                WHERE `mother_indicator_id` IN ('.$format.','.$format2.','.$format3.','.$format4.') and '.$where2;
        $query = $this->db->query($sql);
        return  $query->row();
    }
    public function getTotalIndicatorsPart3($lguType){
        $unformat = "";
        foreach($this->getThirdIndicators() as $firstIndicators):
            $unformat .= "'".$firstIndicators->indicator_id."',";
        endforeach;
        $format = substr($unformat,0,-1);
        $unformat2 = "";
        foreach($this->getCategoriesFromTI($lguType) as $secondCat):
            $unformat2 .= "'".$secondCat->indicator_id."',";
        endforeach;
        $format2 = substr($unformat2,0,-1);

        if($lguType == 1){
            $where2 = 'lgu_type_id IN (0,1) AND indicator_checklist_id <> 0';
        } else {
            $where2 = 'lgu_type_id IN (0,2) AND indicator_checklist_id <> 0';
        }
        $sql = 'select Sum(if(indicator_checklist_id = 1, 1,0)) as Bronze,
                 Sum(if(indicator_checklist_id = 2, 1,0)) as Silver,
                 Sum(if(indicator_checklist_id = 3, 1,0)) as Gold
                FROM (`lib_indicator_codes`)
                WHERE `mother_indicator_id` IN ('.$format.','.$format2.') and '.$where2;
        $query = $this->db->query($sql);
        return  $query->row();
    }
    public function getTotalIndicatorsPart4($lguType){

        $fourth = $this->getFourthMotherIndicator()->indicator_id;
        $unformat = "";
        foreach($this->getFourthIndicators() as $firstIndicators):
            $unformat .= "'".$firstIndicators->indicator_id."',";
        endforeach;
        $format = substr($unformat,0,-1);


        if($lguType == 1){
            $where2 = 'lgu_type_id IN (0,1) AND indicator_checklist_id <> 0';
        } else {
            $where2 = 'lgu_type_id IN (0,2) AND indicator_checklist_id <> 0';
        }
        $sql = 'select Sum(if(indicator_checklist_id = 1, 1,0)) as Bronze,
                         Sum(if(indicator_checklist_id = 2, 1,0)) as Silver,
                         Sum(if(indicator_checklist_id = 3, 1,0)) as Gold
                FROM (`lib_indicator_codes`)
                WHERE `mother_indicator_id` IN ('.$format.',"'.$fourth.'") and '.$where2;
        $query = $this->db->query($sql);
        return  $query->row();
//        return  $sql;
    }
    //PSWDO, CSWDO,MSWDO
    public function getPart1($lguType){
        $unformat3 = "";
        foreach($this->getFirstIndicators() as $firstIndicators):
            $unformat3 .= "'".$firstIndicators->indicator_id."',";
        endforeach;
        $format3 = substr($unformat3,0,-1);

        $unformat2 = "";
        foreach($this->getCategoriesFromFI($lguType) as $secondCat):
            $unformat2 .= "'".$secondCat->indicator_id."',";
        endforeach;
        $format2 = substr($unformat2,0,-1);

        $unformat = "";
        foreach($this->getSecondCategoriesFromFI($lguType) as $firstIndicators):
            $unformat .= "'".$firstIndicators->indicator_id."',";
        endforeach;
        $format = substr($unformat,0,-1);


        if($lguType == 1){
            $where2 = 'lgu_type_id IN (0,1) AND indicator_checklist_id = 1';
        } else {
            $where2 = 'lgu_type_id IN (0,2) AND indicator_checklist_id = 1';
        }
        $sql = 'SELECT `indicator_id`, `mother_indicator_id`, `indicator_name`, indicator_checklist_id
                FROM (`lib_indicator_codes`)
                WHERE `mother_indicator_id` IN ('.$format3.','.$format2.') and '.$where2;
        $query = $this->db->query($sql);
        return  $query->result();
    }
    public function getPart2($lguType){
        $unformat = "";
        foreach($this->getSecondIndicators() as $secondIndicators):
            $unformat .= "'".$secondIndicators->indicator_id."',";
        endforeach;
        $format = substr($unformat,0,-1);

        $unformat2 = "";
        foreach($this->getCategoriesFromSI($lguType) as $secondCat):
            $unformat2 .= "'".$secondCat->indicator_id."',";
        endforeach;
        $format2 = substr($unformat2,0,-1);

        $unformat3 = "";
        foreach($this->getSecondCategoriesFromSI($lguType) as $secondCat):
            $unformat3 .= "'".$secondCat->indicator_id."',";
        endforeach;
        $format3 = substr($unformat3,0,-1);

        $unformat4 = "";
        foreach($this->getSecondCategoriesLowerFromSI($lguType) as $secondCat):
            $unformat4 .= "'".$secondCat->indicator_id."',";
        endforeach;
        $format4 = substr($unformat4,0,-1);

        if($lguType == 1){
            $where2 = 'lgu_type_id IN (0,1) AND indicator_checklist_id = 1';
        } else {
            $where2 = 'lgu_type_id IN (0,2) AND indicator_checklist_id = 1';
        }
        $sql = 'SELECT `indicator_id`, `mother_indicator_id`, `indicator_name`, indicator_checklist_id
                FROM (`lib_indicator_codes`)
                WHERE `mother_indicator_id` IN ('.$format.','.$format2.','.$format3.','.$format4.') and '.$where2;
        $query = $this->db->query($sql);
        return  $query->result();
    }
    public function getPart3($lguType){
        $unformat = "";
        foreach($this->getThirdIndicators() as $firstIndicators):
            $unformat .= "'".$firstIndicators->indicator_id."',";
        endforeach;
        $format = substr($unformat,0,-1);
        $unformat2 = "";
        foreach($this->getCategoriesFromTI($lguType) as $secondCat):
            $unformat2 .= "'".$secondCat->indicator_id."',";
        endforeach;
        $format2 = substr($unformat2,0,-1);

        if($lguType == 1){
            $where2 = 'lgu_type_id IN (0,1) AND indicator_checklist_id = 1';
        } else {
            $where2 = 'lgu_type_id IN (0,2) AND indicator_checklist_id = 1';
        }
        $sql = 'SELECT `indicator_id`, `mother_indicator_id`, `indicator_name`, indicator_checklist_id
                FROM (`lib_indicator_codes`)
                WHERE `mother_indicator_id` IN ('.$format.','.$format2.') and '.$where2;
        $query = $this->db->query($sql);
        return  $query->result();
    }
    public function getPart4($lguType){

        $fourth = $this->getFourthMotherIndicator()->indicator_id;
        $unformat = "";
        foreach($this->getFourthIndicators() as $firstIndicators):
            $unformat .= "'".$firstIndicators->indicator_id."',";
        endforeach;
        $format = substr($unformat,0,-1);


        if($lguType == 1){
            $where2 = 'lgu_type_id IN (0,1) AND indicator_checklist_id = 1';
        } else {
            $where2 = 'lgu_type_id IN (0,2) AND indicator_checklist_id = 1';
        }
        $sql = 'SELECT `indicator_id`, `mother_indicator_id`, `indicator_name`, indicator_checklist_id
                FROM (`lib_indicator_codes`)
                WHERE `mother_indicator_id` IN ('.$format.',"'.$fourth.'") and '.$where2;
        $query = $this->db->query($sql);
        return  $query->result();
//        return  $sql;
    }

    //LSWDO
    public function getPart1LSWDO($lguType){
        $unformat3 = "";
        foreach($this->getFirstIndicators() as $firstIndicators):
            $unformat3 .= "'".$firstIndicators->indicator_id."',";
        endforeach;
        $format3 = substr($unformat3,0,-1);

        $unformat2 = "";
        foreach($this->getCategoriesFromFI($lguType) as $secondCat):
            $unformat2 .= "'".$secondCat->indicator_id."',";
        endforeach;
        $format2 = substr($unformat2,0,-1);

        $unformat = "";
        foreach($this->getSecondCategoriesFromFI($lguType) as $firstIndicators):
            $unformat .= "'".$firstIndicators->indicator_id."',";
        endforeach;
        $format = substr($unformat,0,-1);


        if($lguType == 1){
            $where2 = 'lgu_type_id IN (0,1) AND indicator_checklist_id = 1';
        } else {
            $where2 = 'lgu_type_id IN (0,2) AND indicator_checklist_id = 1';
        }
        $sql = 'SELECT `indicator_id`, `mother_indicator_id`, `indicator_name`, indicator_checklist_id
                FROM (`lib_indicator_codes`)
                WHERE `mother_indicator_id` IN ('.$format3.','.$format2.') and '.$where2;
        $query = $this->db->query($sql);
        return  $query->result();
    }
    public function getPart2LSWDO($lguType){
        $unformat = "";
        foreach($this->getSecondIndicators() as $secondIndicators):
            $unformat .= "'".$secondIndicators->indicator_id."',";
        endforeach;
        $format = substr($unformat,0,-1);

        $unformat2 = "";
        foreach($this->getCategoriesFromSI($lguType) as $secondCat):
            $unformat2 .= "'".$secondCat->indicator_id."',";
        endforeach;
        $format2 = substr($unformat2,0,-1);

        $unformat3 = "";
        foreach($this->getSecondCategoriesFromSI($lguType) as $secondCat):
            $unformat3 .= "'".$secondCat->indicator_id."',";
        endforeach;
        $format3 = substr($unformat3,0,-1);

        $unformat4 = "";
        foreach($this->getSecondCategoriesLowerFromSI($lguType) as $secondCat):
            $unformat4 .= "'".$secondCat->indicator_id."',";
        endforeach;
        $format4 = substr($unformat4,0,-1);

        if($lguType == 1){
            $where2 = 'lgu_type_id IN (0,1) AND indicator_checklist_id = 1';
        } else {
            $where2 = 'lgu_type_id IN (0,2) AND indicator_checklist_id = 1';
        }
        $sql = 'SELECT `indicator_id`, `mother_indicator_id`, `indicator_name`, indicator_checklist_id
                FROM (`lib_indicator_codes`)
                WHERE `mother_indicator_id` IN ('.$format.','.$format2.','.$format3.','.$format4.') and '.$where2;
        $query = $this->db->query($sql);
        return  $query->result();
    }
    public function getPart3LSWDO($lguType){
        $unformat = "";
        foreach($this->getThirdIndicators() as $firstIndicators):
            $unformat .= "'".$firstIndicators->indicator_id."',";
        endforeach;
        $format = substr($unformat,0,-1);
        $unformat2 = "";
        foreach($this->getCategoriesFromTI($lguType) as $secondCat):
            $unformat2 .= "'".$secondCat->indicator_id."',";
        endforeach;
        $format2 = substr($unformat2,0,-1);

        if($lguType == 1){
            $where2 = 'lgu_type_id IN (0,1) AND indicator_checklist_id = 1';
        } else {
            $where2 = 'lgu_type_id IN (0,2) AND indicator_checklist_id = 1';
        }
        $sql = 'SELECT `indicator_id`, `mother_indicator_id`, `indicator_name`, indicator_checklist_id
                FROM (`lib_indicator_codes`)
                WHERE `mother_indicator_id` IN ('.$format.','.$format2.') and '.$where2;
        $query = $this->db->query($sql);
        return  $query->result();
    }
    public function getPart4LSWDO($lguType){

        $fourth = $this->getFourthMotherIndicator()->indicator_id;
        $unformat = "";
        foreach($this->getFourthIndicators() as $firstIndicators):
            $unformat .= "'".$firstIndicators->indicator_id."',";
        endforeach;
        $format = substr($unformat,0,-1);


        if($lguType == 1){
            $where2 = 'lgu_type_id IN (0,1) AND indicator_checklist_id = 1';
        } else {
            $where2 = 'lgu_type_id IN (0,2) AND indicator_checklist_id = 1';
        }
        $sql = 'SELECT `indicator_id`, `mother_indicator_id`, `indicator_name`, indicator_checklist_id
                FROM (`lib_indicator_codes`)
                WHERE `mother_indicator_id` IN ('.$format.',"'.$fourth.'") and '.$where2;
        $query = $this->db->query($sql);
        return  $query->result();
//        return  $sql;
    }

    public function getScorePart1($regCode,$provCode,$lguType){
        if($regCode == 000000000 )
        {
            $where2 = 'where b.deleted = 0';
        }
        else{
            if($lguType != 0) {
                if ($regCode != 0) {
                    if ($provCode != 0) {
                        $where2 = 'where a.indicator_id LIKE "%-1%"
                    and b.deleted = 0
                    and b.lgu_type_id = ' . $lguType . '
                    and b.region_code = "' . $regCode . '"
                    and b.prov_code = "' . $provCode . '"';

                    } else {
                        $where2 = 'where a.indicator_id LIKE "%-1%"
                    and b.deleted = 0
                    and b.lgu_type_id = ' . $lguType . '
                    and b.region_code = "' . $regCode . '"';
                    }
                } else {
                    $where2 = 'where a.indicator_id LIKE "%-1%"
                    and b.deleted = 0
                    and b.lgu_type_id = ' . $lguType . '
                    and b.region_code = "' . $regCode . '"';
                }
            } else {
                if ($regCode != 0) {
                    if ($provCode != 0) {
                        $where2 = 'where a.indicator_id LIKE "%-1%"
                    and b.deleted = 0
                    and b.region_code = "' . $regCode . '"
                    and b.prov_code = "' . $provCode . '"';

                    } else {
                        $where2 = 'where a.indicator_id LIKE "%-1%"
                    and b.deleted = 0
                    and b.region_code = "' . $regCode . '"';
                    }
                } else {
                    $where2 = 'where a.indicator_id LIKE "%-1%"
                    and b.deleted = 0
                    and b.region_code = "' . $regCode . '"';
                }
            }
        }


        $sql = 'select
        a.indicator_id,
        sum(if(a.compliance_indicator_id = 1,1,0)) as TotalCompliance,
        sum(if(a.compliance_indicator_id = 2,1,0)) as TotalNonCompliance
        from
        tbl_lswdo_standard_indicators a
        INNER JOIN tbl_lswdo b
        ON a.profile_id = b.profile_id
        '.$where2.'
        group by a.indicator_id';
        $query = $this->db->query($sql);
        return  $query->result();
    }
    public function getScorePartarray1($regCode,$provCode,$lguType){
        if($regCode == 000000000 )
        {
            $where2 = 'where b.deleted = 0';
        }
        else{
            if($lguType != 0) {
                if ($regCode != 0) {
                    if ($provCode != 0) {
                        $where2 = 'where b.deleted = 0
                    and b.lgu_type_id = ' . $lguType . '
                    and b.region_code = "' . $regCode . '"
                    and b.prov_code = "' . $provCode . '"';

                    } else {
                        $where2 = 'where b.deleted = 0
                    and b.lgu_type_id = ' . $lguType . '
                    and b.region_code = "' . $regCode . '"';
                    }
                } else {
                    $where2 = 'where  b.deleted = 0
                    and b.lgu_type_id = ' . $lguType . '
                    and b.region_code = "' . $regCode . '"';
                }
            } else {
                if ($regCode != 0) {
                    if ($provCode != 0) {
                        $where2 = 'where b.deleted = 0
                    and b.region_code = "' . $regCode . '"
                    and b.prov_code = "' . $provCode . '"';

                    } else {
                        $where2 = 'where b.deleted = 0
                    and b.region_code = "' . $regCode . '"';
                    }
                } else {
                    $where2 = 'where b.deleted = 0
                    and b.region_code = "' . $regCode . '"';
                }
            }
        }


        $sql = 'select a.indicator_id,c.indicator_name,SUM(if(a.compliance_indicator_id = 2,1,0)) TotalNonCompliance
        from tbl_lswdo_standard_indicators a
        INNER JOIN tbl_lswdo b
        ON a.profile_id = b.profile_id
        inner join lib_indicator_codes c
        on a.indicator_id = c.indicator_id
        '.$where2.'
        group by a.indicator_id
        Order by TotalNonCompliance DESC
        LIMIT 10;
        ';
        $query = $this->db->query($sql);
        return  $query->result_array();
    }
    public function getScorePartarray2($regCode,$provCode,$lguType){
        if($regCode == 000000000 )
        {
            $where2 = 'where b.deleted = 0';
        }
        else{
            if($lguType != 0) {
                if ($regCode != 0) {
                    if ($provCode != 0) {
                        $where2 = 'where b.deleted = 0
                    and b.lgu_type_id = ' . $lguType . '
                    and b.region_code = "' . $regCode . '"
                    and b.prov_code = "' . $provCode . '"';

                    } else {
                        $where2 = 'where b.deleted = 0
                    and b.lgu_type_id = ' . $lguType . '
                    and b.region_code = "' . $regCode . '"';
                    }
                } else {
                    $where2 = 'where  b.deleted = 0
                    and b.lgu_type_id = ' . $lguType . '
                    and b.region_code = "' . $regCode . '"';
                }
            } else {
                if ($regCode != 0) {
                    if ($provCode != 0) {
                        $where2 = 'where b.deleted = 0
                    and b.region_code = "' . $regCode . '"
                    and b.prov_code = "' . $provCode . '"';

                    } else {
                        $where2 = 'where b.deleted = 0
                    and b.region_code = "' . $regCode . '"';
                    }
                } else {
                    $where2 = 'where b.deleted = 0
                    and b.region_code = "' . $regCode . '"';
                }
            }
        }


        $sql = 'select a.indicator_id,c.indicator_name,SUM(if(a.compliance_indicator_id = 1,1,0)) TotalCompliance
        from tbl_lswdo_standard_indicators a
        INNER JOIN tbl_lswdo b
        ON a.profile_id = b.profile_id
        inner join lib_indicator_codes c
        on a.indicator_id = c.indicator_id
        '.$where2.'
        group by a.indicator_id
        Order by TotalCompliance DESC
        LIMIT 10;
        ';
        $query = $this->db->query($sql);
        return  $query->result_array();
    }
    public function getNCperLSWDO($regCode,$provCode,$cityCode){

            if ($regCode != 0) {
                if ($provCode != 0) {
                    $where2 = 'where  a.indicator_id LIKE "%-1%"
                    and b.deleted = 0
                    and b.region_code = "' . $regCode . '"
                    and b.prov_code = "' . $provCode . '"
                    and b.city_code = "' . $cityCode . '"
                    and a.compliance_indicator_id = 2';

                } else {
                    $where2 = 'where  a.indicator_id LIKE "%-1%"
                    and b.deleted = 0
                    and b.region_code = "' . $regCode . '"
                    and a.compliance_indicator_id = 2';
                }
            } else {
                $where2 = 'where  a.indicator_id LIKE "%-1%"
                    and b.deleted = 0
                    and b.region_code = "' . $regCode . '"
                    and a.compliance_indicator_id = 2';
            }


        $sql = 'select
        a.profile_id,a.indicator_id,c.indicator_name
        from
        tbl_lswdo_standard_indicators a
        INNER JOIN tbl_lswdo b
        ON a.profile_id = b.profile_id
        INNER JOIN lib_indicator_codes c
        ON a.indicator_id = c.indicator_id
        '.$where2.'
        group by a.indicator_id';
        $query = $this->db->query($sql);
        return  $query->result();
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
        } elseif($lguType == 4){
            $where2 = 'lgu_type_id IN (0,1,2)';
        } else  {
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
        } elseif($lguType == 4){
            $where2 = 'lgu_type_id IN (0,1,2)';
        } else  {
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
        } elseif($lguType == 4){
            $where2 = 'lgu_type_id IN (0,1,2)';
        } else  {
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
        } elseif($lguType == 4){
            $where2 = 'lgu_type_id IN (0,1,2)';
        } else  {
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
        } elseif($lguType == 4){
            $where2 = 'lgu_type_id IN (0,1,2)';
        } else  {
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
        } elseif($lguType == 4){
            $where2 = 'lgu_type_id IN (0,1,2)';
        } else  {
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
        } elseif($lguType == 4){
            $where2 = 'lgu_type_id IN (0,1,2)';
        } else  {
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
        } elseif($lguType == 4){
            $where2 = 'lgu_type_id IN (0,1,2)';
        } else  {
            $where2 = 'lgu_type_id IN (0,2)';
        }
        $sql = 'SELECT `indicator_id`, `mother_indicator_id`, `indicator_name`, indicator_checklist_id
                FROM (`lib_indicator_codes`)
                WHERE `mother_indicator_id` IN ('.$format.') and '.$where2;
        $query = $this->db->query($sql);
        return  $query->result();
    }

    public function getFourthMotherIndicator(){
        $this->db->select('indicator_id,mother_indicator_id,indicator_name');
        $this->db->order_by('indicator_name','ASC');
        $query = $this->db->get_where('lib_indicator_codes', array('indicator_id' => 'IV'));
        return $query->row();
    }
    public function getFourthIndicators(){
        $this->db->select('indicator_id,mother_indicator_id,indicator_name,indicator_checklist_id,lgu_type_id');
        $this->db->order_by('indicator_id','ASC');
        $query = $this->db->get_where('lib_indicator_codes', array('mother_indicator_id' => 'IV'));
        return $query->result();
    }
    public function getCategoriesFromFourthI(){
        $unformat = "";
        foreach($this->getFourthIndicators() as $firstIndicators):
            $unformat .= "'".$firstIndicators->indicator_id."',";
        endforeach;
        $format = substr($unformat,0,-1);

        $sql = 'SELECT `indicator_id`, `mother_indicator_id`, `indicator_name`, indicator_checklist_id
                FROM (`lib_indicator_codes`)
                WHERE `mother_indicator_id` IN ('.$format.')';
        $query = $this->db->query($sql);
        return  $query->result();
    }

    public function insertFunctionality($profileID,$ref_id, $level_function, $score){
        $this->db->trans_begin();
        $this->db->query('Insert into tbl_functionality(prof_id,ref_id,level_function_baseline,baseline_score,new_score,level_function_new)
                          VALUES(
                          "'.$profileID.'",
                          "'.$ref_id.'",
                          "'.$level_function.'",
                          "'.$score.'",
                          "'.$score.'",
                          "'.$level_function.'"
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
    public function updateFunctionalityProfOnly($profileID, $level_function, $score){
        $this->db->trans_begin();
        $this->db->query('update tbl_functionality SET
                          new_score = '.$score.',
                          level_function_new = "'.$level_function.'"
                          Where
                          prof_id = '.$profileID.'
        ');
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
    public function updateFunctionality($profileID,$ref_id, $level_function, $score){
        $this->db->trans_begin();
        $this->db->query('update tbl_functionality SET
                          new_score = '.$score.',
                          level_function_new = "'.$level_function.'"
                          Where
                          prof_id = '.$profileID.' and ref_id = '.$ref_id.'
        ');
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

    public function getdeleteCategoriesFromFoI(){
    $unformat = "";
    foreach($this->getFourthIndicators() as $firstIndicators):
        $unformat .= "'".$firstIndicators->indicator_id."',";
    endforeach;
    $format = substr($unformat,0,-1);

    $sql = 'SELECT `indicator_id`, `mother_indicator_id`, `indicator_name`, indicator_checklist_id
                FROM (`lib_indicator_codes1`)
                WHERE `mother_indicator_id` IN ('.$format.')';
    $query = $this->db->query($sql);
    return  $query->result();
}
    public function getdeleteSecondCategoriesFromFoI(){
        $unformat = "";
        foreach($this->getCategoriesFromFourthI() as $secondCat):
            $unformat .= "'".$secondCat->indicator_id."',";
        endforeach;
        $format = substr($unformat,0,-1);

        $sql = 'SELECT `indicator_id`, `mother_indicator_id`, `indicator_name`, indicator_checklist_id
                FROM (`lib_indicator_codes`)
                WHERE `mother_indicator_id` IN ('.$format.')';
        $query = $this->db->query($sql);
        return  $query->result();
    }
    public function deleteIndicatorpart4($profileID,$ref_id){

        $unformat1 = "";
        foreach($this->getFourthIndicators() as $secondCat):
            $unformat1 .= "'".$secondCat->indicator_id."',";
        endforeach;
        $format1 = substr($unformat1,0,-1);

        $unformat = "";
        foreach($this->getCategoriesFromFourthI() as $secondCat):
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
}