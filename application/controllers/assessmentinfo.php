<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Created by PhpStorm
 * Date Time: 10/18/15 12:31 AM
 */
class assessmentinfo extends CI_Controller {

    public function index()
    {
        //grace
        //$this->load->library('pagination');
        // $this->load->library('model');
        $user_region = $this->session->userdata('uregion');
        //grace

        $assessmentinfo_model = new assessmentinfo_model();
        $form_message = '';

        //grace

        //rpmb

        $this->init_rpmb_session();
        //  $rpmb['lgu_typelist'] = $this->assessmentinfo_model->get_lgu_type();
        $rpmb['regionlist'] = $this->assessmentinfo_model->get_regions();

        // if(isset($_SESSION['region']) or isset($_SESSION['lgu_type'])) {
        //      $rpmb['regionlist'] = $this->assessmentinfo_model->get_regions($_SESSION['lgu_type']);
        //  }
        if(isset($_SESSION['province']) or isset($_SESSION['region'])) {
            $rpmb['provlist'] = $this->assessmentinfo_model->get_provinces($_SESSION['region']);
        }
        if(isset($_SESSION['city']) or isset($_SESSION['province'])) {
            $rpmb['citylist'] = $this->assessmentinfo_model->get_cities($_SESSION['province']);
        }

        //grace

        $this->load->view('header');
        $this->load->view('nav');
        $this->load->view('sidebar');
        $this->load->view('assessmentinfo_list',array(
            'assessmentinfo_data'=>$assessmentinfo_model->getAssessmentinfo(),
            'list_fields'=>$this->listFields(),
            'form_message'=>$form_message
        ));
        $this->load->view('footer');
    }

    public function addAssessmentinfo()
    {
        $assessmentinfo_model = new assessmentinfo_model();
        $application_type_name = $assessmentinfo_model->Lib_getAllApplicationtype();
        $lgu_type_name = $assessmentinfo_model->Lib_getLGUtype();
        $income_class = $assessmentinfo_model->get_incomeclass();

        // $region_name = $assessmentinfo_model->Lib_getRegion();
        //$prov_name = $assessmentinfo_model->Lib_getProvince();
        // $city_name = $assessmentinfo_model->Lib_getCity();

        $this->validateAddForm();

        if (!$this->form_validation->run()){
            $form_message = '';
            $this->load->view('header');
            $this->load->view('nav');
            $this->load->view('sidebar');

            $this->init_rpmb_session();
            $rpmb['regionlist'] = $this->assessmentinfo_model->get_regions();
            $rpmb['income_class'] = $income_class;
            $rpmb['application'] = $application_type_name;
            $rpmb['lgu_type'] = $lgu_type_name;
            $rpmb['form_message'] = $form_message;

            if(isset($_SESSION['province']) or isset($_SESSION['region'])) {
                $rpmb['provlist'] = $this->assessmentinfo_model->get_provinces($_SESSION['region']);
            }
            if(isset($_SESSION['city']) or isset($_SESSION['province'])) {
                $rpmb['citylist'] = $this->assessmentinfo_model->get_cities($_SESSION['province']);
            }


            $this->load->view('assessmentinfo_add',$rpmb);
            $this->load->view('footer');

        } else {
            $assessmentinfo_model = new assessmentinfo_model();

            $application_type_id = $this->input->post('application_type_id');
            $lgu_type_id = $this->input->post('lgu_type_id');
            $regionlist = $this->input->post('regionlist');
            $provlist = $this->input->post('provlist');
            $citylist = $this->input->post('citylist');
            $income_class = $this->input->post('income_class');
            $office_address = $this->input->post('office_address');
            $swdo_name = $this->input->post('swdo_name');
            $designation = $this->input->post('designation');
            $contact_no = $this->input->post('contact_no');
            $email = $this->input->post('email');
            $website = $this->input->post('website');
            $total_ira = $this->input->post('total_ira');
            $total_budget_lswdo = $this->input->post('total_budget_lswdo');
            $date_created = $this->input->post('date_created');

            $addResult = $assessmentinfo_model->insertAssessmentinfo($application_type_id,$lgu_type_id,$regionlist,$provlist,$citylist,$office_address,$swdo_name,$designation,$contact_no,$email,$website,$total_ira,$total_budget_lswdo,$date_created);
            if ($addResult){

                //  $data['tbl_lswdo'] = $this->assessmentinfo_model->fetch_assessmentinfo($config['per_page'], $this->uri->segment(3));
                //rpmb
                $this->init_rpmb_session();
                $rpmb['regionlist'] = $this->assessmentinfo_model->get_regions();

                if(isset($_SESSION['province']) or isset($_SESSION['region'])) {
                    $rpmb['provlist'] = $this->assessmentinfo_model->get_provinces($_SESSION['region']);
                }
                if(isset($_SESSION['city']) or isset($_SESSION['province'])) {
                    $rpmb['citylist'] = $this->assessmentinfo_model->get_cities($_SESSION['province']);
                }

                //call the model function to get the family info data

                $this->load->view('sidebar');

                $form_message = 'Add Success!';
                $this->load->view('header');
                $this->load->view('nav');


                $this->load->view('assessmentinfo_add',array(
                    'application' => $application_type_name,
                    'lgu_type' => $lgu_type_name,
                    'income_class' => $income_class,
                    //  'region' => $region_name,
                    //   'province' => $prov_name,
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
                $this->load->view('sidebar');

                $rpmb['application_type_id'] = $this->assessmentinfo_model->Lib_getAllApplicationtype();
                $rpmb['lgu_type_id'] = $this->assessmentinfo_model->Lib_getLGUtype();
                $rpmb['regionlist'] = $this->assessmentinfo_model->get_regions();
                $rpmb['assessmentinfo_details'] = $this->assessmentinfo_model->getAssessmentinfoByID($id);
                $this->load->view('assessmentinfo_edit',$rpmb);

                $this->load->view('footer');

            } else {
                $id = $this->input->post('profile_id');
                $application_type_id = $this->input->post('application_type_id');
                $lgu_type_id = $this->input->post('lgu_type_id');
                $regionlist = $this->input->post('regionlist');
                $provlist = $this->input->post('provlist');
                $citylist = $this->input->post('citylist');
                $office_address = $this->input->post('office_address');
                $swdo_name = $this->input->post('swdo_name');
                $designation = $this->input->post('designation');
                $contact_no = $this->input->post('contact_no');
                $email = $this->input->post('email');
                $website = $this->input->post('website');
                $total_ira = $this->input->post('total_ira');
                $total_budget_lswdo = $this->input->post('total_budget_lswdo');
                $date_modified = $this->input->post('date_modified');

                $updateResult = $assessmentinfo_model->updateAssessmentinfo($id,$application_type_id,$lgu_type_id,$regionlist,$provlist,$citylist,$office_address,$swdo_name,$designation,$contact_no,$email,$website,$total_ira,$total_budget_lswdo,$date_modified);
                if ($updateResult){
                    // $this->load->view('student_update_success',array('redirectIndex'=>$this->redirectIndex()));
                    $this->load->library('pagination');
                    $this->load->library('model');
                    $config=array();
                    $config['base_url'] = base_url().'assessmentinfo/index';
                    $config['total_rows'] = $this->assessmentinfo_model->record_count();
                    $config['per_page'] = 10;

                    $config['full_tag_open'] = '<div class="pagination pagination-sm"><ul>';
                    $config['full_tag_open'] = '<ul class="pagination pagination-sm">';
                    $config['full_tag_close'] = '</ul>';
                    $config['first_link'] = false;
                    $config['last_link'] = false;
                    $config['first_tag_open'] = '<li>';
                    $config['first_tag_close'] = '</li>';
                    $config['prev_link'] = '&laquo';
                    $config['prev_tag_open'] = '<li class="prev">';
                    $config['prev_tag_close'] = '</li>';
                    $config['next_link'] = '&raquo';
                    $config['next_tag_open'] = '<li>';
                    $config['next_tag_close'] = '</li>';
                    $config['last_tag_open'] = '<li>';
                    $config['last_tag_close'] = '</li>';
                    $config['cur_tag_open'] = '<li class="active"><a href="#">';
                    $config['cur_tag_close'] = '</a></li>';
                    $config['num_tag_open'] = '<li>';
                    $config['num_tag_close'] = '</li>';
                    $this->pagination->initialize($config);

                    $data['tbl_lswdo'] = $this->assessmentinfo_model->fetch_assessmentinfo($config['per_page'], $this->uri->segment(3));

                    $this->init_rpmb_session();
                    $rpmb['application_type_id'] = $this->assessmentinfo_model->Lib_getAllApplicationtype();
                    $rpmb['lgu_type_id'] = $this->assessmentinfo_model->Lib_getLGUtype();
                    $rpmb['regionlist'] = $this->assessmentinfo_model->get_regions();

                    $data['tbl_lswdo'] = $this->assessmentinfo_model->fetch_assessmentinfo($config['per_page'], $this->uri->segment(3));

                    if(isset($_SESSION['province']) or isset($_SESSION['region'])) {
                        $rpmb['provlist'] = $this->assessmentinfo_model->get_provinces($_SESSION['region']);
                    }
                    if(isset($_SESSION['city']) or isset($_SESSION['province'])) {
                        $rpmb['citylist'] = $this->assessmentinfo_model->get_cities($_SESSION['province']);
                    }

                    $datarpmb = array_merge($data,$rpmb);
                    $form_message = 'Update Success';
                    $this->load->view('header');
                    $this->load->view('nav');
                    $this->load->view('sidebar');
                    $this->load->view('assessmentinfo_listview', $datarpmb);
                    $this->load->view('sidepanel');
                    $this->load->view('footer');
                }
                $this->redirectIndex();
            }
        }
        else
        {
//                             $this->load->view('no_id',array('redirectIndex'=>$this->redirectIndex()));
        }

    }

    public function assessmentinfo_masterview($id = 0,$form_message = '')
    {
        $assessmentinfo_model = new assessmentinfo_model();
        $this->load->view('header');
        $this->load->view('nav');
        $this->load->view('sidebar');
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
                'office_address'      =>      $AssessmentDetails->office_address,
                'swdo_name'      =>      $AssessmentDetails->swdo_name,
                'designation'      =>      $AssessmentDetails->designation,
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
        $this->load->view('assessmentinfo_masterview',$data);
        $this->load->view('footer');
    }

    public function delete_assessmentinfo($id = 0)
    {
        $assessmentinfo_model = new assessmentinfo_model();
        if ($id > 0){
            $deleteResult = $assessmentinfo_model->deleteassessmentinfo($id);
            if ($deleteResult){
                $form_message = 'Delete Success!';
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
    /*
        public function populate_region() {
            if($_POST['lgu_type_id'] > 0 and isset($_POST) and isset($_POST['lgu_type_id'])) {

                $lgu_type_id = $_POST['lgu_type_id'];
                $regionlist = $this->assessmentinfo_model->get_regions($lgu_type_id);

                $region_list[] = "Choose Type of LSWDO";
                foreach($regionlist as $tempregion) {
                    $region_list[$tempregion->region_code] = $tempregion->region_name;
                }

                $regionlist_prop = 'id="regionlist" name="regionlist" class="form-control" onChange="get_prov();"';

                echo form_dropdown('regionlist', $region_list, '', $regionlist_prop);
            }
        }
    */
    public function populate_prov() {
        if($_POST['region_code'] > 0 and isset($_POST) and isset($_POST['region_code'])) {

            $region_code = $_POST['region_code'];
            $provlist = $this->assessmentinfo_model->get_provinces($region_code);

            $province_list[] = "Choose Province";
            foreach($provlist as $tempprov) {
                $province_list[$tempprov->prov_code] = $tempprov->prov_name;
            }

            $provlist_prop = 'id="provlist" name="provlist" class="form-control" onChange="get_cities();"';

            echo form_dropdown('provlist', $province_list, '', $provlist_prop);
        }
    }

    public function populate_cities() {
        if($_POST['prov_code'] > 0 and isset($_POST) and isset($_POST['prov_code'])) {
            $prov_code = $_POST['prov_code'];
            $citylist = $this->assessmentinfo_model->get_cities($prov_code);

            $city_list[] = "Choose City";
            foreach($citylist as $tempcity) {
                $city_list[$tempcity->city_code] = $tempcity->city_name;
            }

            $citylist_prop = 'id="citylist" name="citylist" onchange="get_brgy();" class="form-control"';
            echo form_dropdown('citylist', $city_list,'',$citylist_prop);
        }
    }

    public function init_rpmb_session() {

        if(isset($_POST['regionlist']) and $_POST['regionlist'] > 0) {
            $_SESSION['region'] = $_POST['regionlist'];
        }
        if(isset($_POST['provlist']) and $_POST['provlist'] > 0) {
            $_SESSION['province'] = $_POST['provlist'];
        }
        if(isset($_POST['citylist']) and $_POST['citylist'] > 0) {
            $_SESSION['city'] = $_POST['citylist'];
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
            ),
            array(
                'field'   => 'lgu_type_id',
                'label'   => 'lgu_type_id',
                'rules'   => 'required'
            )
        );

        return $this->form_validation->set_rules($config);
    }

    public function listFields()
    {
        $query = $this->db->query('SELECT profile_id,application_type_id,lgu_type_id,region_code,prov_code,city_code,office_address,swdo_name,designation,contact_no,email,website,total_ira,total_budget_lswdo FROM tbl_lswdo');
        return $query->list_fields();
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
        $page = base_url('assessmentinfo/index/' . $id . '.html');
        header("Refresh: $sec; url=$page");
    }
}