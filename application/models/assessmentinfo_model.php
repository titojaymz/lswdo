<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Created by JOSEF FRIEDRICH S. BALDO
 * Date Time: 10/17/15 11:56 PM
 */
class assessmentinfo_model extends CI_Model {

    public function getAssessmentinfo()
    {
        $query = $this->db->get_where('tbl_lswdo',array('DELETED' => 0));
        if ($query->num_rows() > 0){
            return $query->result();
        } else {
            return FALSE;
        }
        $this->db->close();
    }

    public function getAssessmentinfoByID($id = 0)
    {
        $query = $this->db->get_where('tbl_lswdo',array('profile_id'=>$id,'DELETED'=>0));
        if ($query->num_rows() > 0){
            return $query->row();
        } else {
            return FALSE;
        }
        $this->db->close();
    }

    public function insertAssessmentinfo($application_type_id,$lgu_type_id,$region_code,$prov_code,$city_code,$brgy_code,$street_address,$swdo_name,$contact_no,$email,$website,$total_ira,$total_budget_lswdo)
    {
        $this->db->trans_begin();

        $this->db->query('INSERT INTO tbl_lswdo(application_type_id,lgu_type_id,region_code,prov_code,city_code,brgy_code,street_address,swdo_name,contact_no,email,website,total_ira,total_budget_lswdo)
                          VALUES
                          (
                          "'.$application_type_id.'",
                          "'.$lgu_type_id.'",
                          "'.$region_code.'",
                          "'.$prov_code.'",
                          "'.$city_code.'",
                          "'.$brgy_code.'",
                          "'.$street_address.'",
                          "'.$swdo_name.'",
                          "'.$contact_no.'",
                          "'.$email.'",
                          "'.$website.'",
                          "'.$total_ira.'",
                          "'.$total_budget_lswdo.'"
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
    /*
    // get application type
    public function getApplicationtype($id = 0)
    {
        $query = $this->db->get_where('lib_application_type',array('application_type_id'=>$id,'DELETED'=>0));
        if ($query->num_rows() > 0){
            return $query->row();
          } else {
            return FALSE;
        }
        $this->db->close();
    }

    public function get_application_type(){
        $get_application_type = "
        SELECT
          application_type_id,
          application_type_name
        FROM
          lib_application_type
        WHERE
          application_type_id > '0'
        ORDER BY
          application_type_id
        ";

        return $this->db->query($get_application_type)->result();
    }
*/
    public function updateAssessmentinfo($id,$application_type_id,$lgu_type_id,$region_code,$prov_code,$city_code,$brgy_code,$street_address,$swdo_name,$contact_no,$email,$website,$total_ira,$total_budget_lswdo)
    {
        $this->db->trans_begin();

        $this->db->query('UPDATE tbl_lswdo SET
                          application_type_id="'.$application_type_id.'",
                          lgu_type_id="'.$lgu_type_id.'",
                          region_code="'.$region_code.'",
                          prov_code="'.$prov_code.'",
                          city_code="'.$city_code.'",
                          brgy_code="'.$brgy_code.'",
                          street_address="'.$street_address.'",
                          swdo_name="'.$swdo_name.'",
                          contact_no="'.$contact_no.'",
                          email="'.$email.'",
                          website="'.$website.'",
                          total_ira="'.$total_ira.'",
                          total_budget_lswdo="'.$total_budget_lswdo.'"

                          WHERE
                          profile_id = "'.$id.'"
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

    public function deleteAssessmentinfo($id = 0)
    {
        $this->db->trans_begin();

        $this->db->query('UPDATE tbl_lswdo SET
                          DELETED="1"
                          WHERE
                          profile_id = "'.$id.'"
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
/*
    public function getStudentSubjects($id = 0)
    {
        $query = $this->db->get_where('tbl_student_subjects',array('student_id'=>$id,'DELETED' => 0));
        if ($query->num_rows() > 0){
            return $query->result();
        } else {
            return FALSE;
        }
        $this->db->close();
    }

    public function getOneStudentSubjects($id = 0)
    {
        $query = $this->db->get_where('tbl_student_subjects',array('student_subject_id'=>$id,'DELETED' => 0));
        $result = $query->row();
        return array(
            'student_subject_id' => $result->student_subject_id,
            'student_id'=> $result->student_id,
            'subject_id'=> $result->subject_id,
            'grade'=> $result->grade,
            'remarks'=> $result->remarks
        );
    }

    public function getStudentName($id = 0)
    {
        $query = $this->db->get_where('tbl_students',array('student_id'=>$id,'DELETED'=>0));
        if ($query->num_rows() > 0){
            $rowDetails = $query->row();
            return $rowDetails->lastname . ', ' . $rowDetails->firstname . ' ' . $rowDetails->middlename . ' ' . $rowDetails->extname;
        } else {
            return FALSE;
        }
        $this->db->close();
    }

    public function getSubjectName($id = 0)
    {
        $query = $this->db->get_where('lib_subjects',array('subject_id'=>$id,'DELETED'=>0));
        if ($query->num_rows() > 0){
            $rowDetails = $query->row();
            return $rowDetails->subject_name;
        } else {
            return FALSE;
        }
        $this->db->close();
    }

    public function Lib_getAllSubjects($course = NULL, $year = 0, $sem = 0)
    {
        $query = $this->db->get_where('lib_subjects',array(
            'DELETED'   =>  0,
            'course'    =>  $course,
            'year'      =>  $year,
            'sem'       =>  $sem
        ));
        if ($query->num_rows() > 0){
            return $query->result();
        } else {
            return FALSE;
        }
        $this->db->close();
    }

    public function addStudSubjects($student_id = NULL, $subject_id = 0)
    {
        $this->db->trans_begin();

        $this->db->query('INSERT INTO tbl_student_subjects(student_id,subject_id)
                           VALUES
                           ("'.$student_id.'","'.$subject_id.'")
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

    public function editStudSubjects($student_subject_id = 0,$grade,$remarks)
    {
        $this->db->trans_begin();

        $this->db->query('UPDATE tbl_student_subjects SET
                          grade='.$grade.',
                          remarks="'.$remarks.'"
                          WHERE
                          student_subject_id='.$student_subject_id.'
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

    public function deleteStudentSubject($id)
    {
        $this->db->trans_begin();

        $this->db->query('UPDATE tbl_student_subjects SET
                          DELETED=1
                          WHERE
                          student_subject_id='.$id.'
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
    }*/

}