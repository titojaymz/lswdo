<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Created by JOSEF FRIEDRICH S. BALDO
 * Date Time: 10/18/15 12:31 AM
 */
class assessmentinfo extends CI_Controller {

    public function index()
    {
        $assessmentinfo_model = new assessmentinfo_model();
        $form_message = '';
        $this->load->view('header');
        $this->load->view('nav');
        $this->load->view('assessmentinfo_list',array(
            'assessmentinfo_data'=>$assessmentinfo_model->getAssessmentinfo(),
            'list_fields'=>$this->listFields(),
            'form_message'=>$form_message
        ));
        $this->load->view('footer');
    }

    public function addAssessmentinfo()
    {
        $this->validateAddForm();

        if (!$this->form_validation->run()){
            $form_message = '';
            $this->load->view('header');
            $this->load->view('nav');
            $this->load->view('sidebar');
            $this->load->view('assessmentinfo_add',array('form_message'=>$form_message));
            $this->load->view('footer');
        } else {
            $assessmentinfo_model = new assessmentinfo_model();
             $application_type_id = $this->input->post('application_type_id');
            $lgu_type_id = $this->input->post('lgu_type_id');
            $region_code = $this->input->post('region_code');
            $prov_code = $this->input->post('prov_code');
            $city_code = $this->input->post('city_code');
            $brgy_code = $this->input->post('brgy_code');
            $street_address = $this->input->post('street_address');
            $swdo_name = $this->input->post('swdo_name');
            $contact_no = $this->input->post('contact_no');
            $email = $this->input->post('email');
            $website = $this->input->post('website');
            $total_ira = $this->input->post('total_ira');
            $total_budget_lswdo = $this->input->post('total_budget_lswdo');

            $addResult = $assessmentinfo_model->insertAssessmentinfo($application_type_id,$lgu_type_id,$region_code,$prov_code,$city_code,$brgy_code,$street_address,$swdo_name,$contact_no,$email,$website,$total_ira,$total_budget_lswdo);
            if ($addResult){
                $form_message = 'Add Success!';
                $this->load->view('header');
                $this->load->view('nav');
                $this->load->view('assessmentinfo_list',array(
                    'assessmentinfo_data'=>$assessmentinfo_model->getAssessmentinfo(),
                    'list_fields'=>$this->listFields(),
                    'form_message'=>$form_message,
                    $this->redirectIndex()
                ));
                $this->load->view('footer');
            }
        }
    }

    public function editAssessmentinfo($id = 0)
    {
        if ($id > 0){
            $assessmentinfo_model = new assessmentinfo_model();

            $this->validateEditForm();

            if (!$this->form_validation->run()){
                $form_message = '';
                $this->load->view('header');
                $this->load->view('nav');
                $this->load->view('assessmentinfo_edit',array(
                    'assessmentinfo_details'=>$assessmentinfo_model->getAssessmentinfoByID($id),
                    'listFields'=>$this->listFields(),
                    'form_message'=>$form_message
                ));
                $this->load->view('footer');
            } else {
                $id = $this->input->post('profile_id');
                $application_type_id = $this->input->post('application_type_id');
                $lgu_type_id = $this->input->post('lgu_type_id');
                $region_code = $this->input->post('region_code');
                $prov_code = $this->input->post('prov_code');
                $city_code = $this->input->post('city_code');
                $brgy_code = $this->input->post('brgy_code');
                $street_address = $this->input->post('street_address');
                $swdo_name = $this->input->post('swdo_name');
                $contact_no = $this->input->post('contact_no');
                $email = $this->input->post('email');
                $website = $this->input->post('website');
                $total_ira = $this->input->post('total_ira');
                $total_budget_lswdo = $this->input->post('total_budget_lswdo');

                $updateResult = $assessmentinfo_model->updateAssessmentinfo($id,$application_type_id,$lgu_type_id,$region_code,$prov_code,$city_code,$brgy_code,$street_address,$swdo_name,$contact_no,$email,$website,$total_ira,$total_budget_lswdo);
                if ($updateResult){
                    // $this->load->view('student_update_success',array('redirectIndex'=>$this->redirectIndex()));
                    $form_message = 'Update Success';
                    $this->load->view('header');
                    $this->load->view('nav');
                    $this->load->view('assessmentinfo_list',array(
                        'assessmentinfo_data'=>$assessmentinfo_model->getAssessmentinfo(),
                        'list_fields'=>$this->listFields(),
                        'form_message'=>$form_message,
                        //$this->redirectIndex()
                    ));
                    $this->load->view('footer');
                }
            }
        } else {
            $this->load->view('no_id',array('redirectIndex'=>$this->redirectIndex()));
        }

    }


        public function assessmentinfo_masterview($id = 0,$form_message = '')
        {
            $assessmentinfo_model = new assessmentinfo_model();
            $AssessmentDetails = $assessmentinfo_model->getAssessmentinfoByID($id);
            if ($AssessmentDetails){
                $form_message = $form_message;
                $data = array(
                    'profile_id'                 =>      $AssessmentDetails->profile_id,
                   'application_type_id'      =>      $AssessmentDetails->application_type_id,
                   'lgu_type_id'      =>      $AssessmentDetails->lgu_type_id,
                   'region_code'      =>      $AssessmentDetails->region_code,
                   'prov_code'      =>      $AssessmentDetails->prov_code,
                   'city_code'      =>      $AssessmentDetails->city_code,
                   'brgy_code'      =>      $AssessmentDetails->brgy_code,
                   'street_address'      =>      $AssessmentDetails->street_address,
                   'swdo_name'      =>      $AssessmentDetails->swdo_name,
                   'contact_no'      =>      $AssessmentDetails->contact_no,
                   'email'      =>      $AssessmentDetails->email,
                   'website'      =>      $AssessmentDetails->website,
                   'total_ira'      =>      $AssessmentDetails->total_ira,
                   'total_budget_lswdo'      =>      $AssessmentDetails->total_budget_lswdo

                );
            } else {
                $form_message = 'No records found!';
                $data = array(
                    'form_message'      =>      $form_message
                );
            }
            $this->load->view('header');
            $this->load->view('nav');
            $this->load->view('assessmentinfo_masterview',$data);
            $this->load->view('footer');
        }

        public function delete_student($id = 0)
        {
            $assessmentinfo_model = new assessmentinfo_model();
            if ($id > 0){
                $deleteResult = $assessmentinfo_model->deletestudent($id);
                if ($deleteResult){
                    $form_message = 'Delete Success!';
                    $this->load->view('header');
                    $this->load->view('nav');
                    $this->load->view('student_list',array(
                        'student_data'=>$assessmentinfo_model->getAssessmentinfo(),
                        'list_fields'=>$this->listFields(),
                        'form_message'=>$form_message,
                        $this->redirectIndex()
                    ));
                    $this->load->view('footer');
                }
            }
        }

    protected function validateEditForm()
    {
        $config = array(
            array(
                'field'   => 'profile_id',
                'label'   => 'profile_id',
                'rules'   => 'required'
            ),
            array(
                'field'   => 'application_type_id',
                'label'   => 'application_type_id',
                'rules'   => 'required'
            )
        );

        return $this->form_validation->set_rules($config);
    }

    protected function validateAddForm()
    {
        $config = array(
            array(
                'field'   => 'application_type_id',
                'label'   => 'application_type_id',
                'rules'   => 'required'
            )
        );

        return $this->form_validation->set_rules($config);
    }

    public function listFields()
    {
        $query = $this->db->query('SELECT profile_id,application_type_id,lgu_type_id,region_code,prov_code,city_code,brgy_code,street_address,swdo_name,contact_no,email,website,total_ira,total_budget_lswdo FROM tbl_lswdo');
        return $query->list_fields();
    }

//select

    public function addApplicationtype($application_type_id = 0, $application_type_name = 0)
    {
        $assessmentinfo_model = new assessmentinfo_model();
        $application_type_name = $assessmentinfo_model->Lib_getAllApplicationtype($application_type_id);

        if ($application_type_name){
            $this->validateAddApplicationtype();

            if (!$this->form_validation->run()){

                 $application_type_id_post = $this->input->post('application_type_id');
                //$application_type_id_post = $application_type_id;
                $addResult = $assessmentinfo_model->insertAssessmentinfo($application_type_id_post);
                if ($addResult){
                    $form_message = 'Add Success!';
                    $this->load->view('header');
                    $this->load->view('nav');
                    $this->load->view('assessmentinfo_add',array(
                        'application_type_name'=>$application_type_name,
                        'form_message'=>$form_message,
                        'application_type_id'=>$application_type_id
                    ));
                    $this->load->view('footer');
                    $this->redirectMasterPage($application_type_id);
                }
            }
        } else {
            $application_type_name = '';
            $form_message = 'There are discrepancies on the student details, please recheck before adding subjects';
            $this->load->view('header');
            $this->load->view('nav');
            $this->load->view('assessmentinfo_add',array(
                'application_type_name'=>$application_type_name,
                'form_message'=>$form_message,
                'application_type_id'=>$application_type_id
            ));
            $this->load->view('footer');
            $this->redirectMasterPage($application_type_id,2);
        }
    }

    public function addApplicationtype()
    {
        $this->validateAddForm();

        if (!$this->form_validation->run()){
            $form_message = '';
            $this->load->view('header');
            $this->load->view('nav');
            $this->load->view('assessmentinfo_add',array('form_message'=>$form_message));
            $this->load->view('footer');
        } else {
            $assessmentinfo_model = new assessmentinfo_model();
            $application_type_id = $this->input->post('application_type_id');


            $addResult = $assessmentinfo_model->addAssessmentinfoApplicationtype($application_type_id);
            if ($addResult){
                $form_message = 'Add Success!';
                $this->load->view('header');
                $this->load->view('nav');
                $this->load->view('assessmentinfo_list',array(
                    'assessmentinfo_data'=>$assessmentinfo_model->Lib_getAllApplicationtype(),
                    'list_fields'=>$this->listFields(),
                    'form_message'=>$form_message,
                    $this->redirectIndex()
                ));
                $this->load->view('footer');
            }
        }
    }

    protected function validateAddApplicationtype()
    {
        $config = array(
            array(
                'field'   => 'application_type_id',
                'label'   => 'application_type_name',
                'rules'   => 'required'
            )
        );

        return $this->form_validation->set_rules($config);
    }

  public function redirectIndex()
    {
        $page = base_url();
        $sec = "1";
        header("Refresh: $sec; url=$page");
    }

    public function refreshCurPage()
    {
        $page = current_url();
        $sec = "1";
        header("Refresh: $sec; url=$page");
    }

    public function redirectMasterPage($id,$sec = 1)
    {
        $page = base_url('assessmentinfo/assessmentinfo_masterview/' . $id . '.html');
        header("Refresh: $sec; url=$page");
    }
}