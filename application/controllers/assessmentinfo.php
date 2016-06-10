<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Created by PhpStorm
 * User: mglveniegas
 *
 */
class assessmentinfo extends CI_Controller {

    public function index()
    {

        if (!$this->session->userdata('user_id'))
        {
            redirect('/users/login','location');
        }

        $accessLevel = $this->session->userdata('accessLevel');

        if($accessLevel == -1){
            $region = '000000000';
        } else {
            $region = $this->session->userdata('lswdo_regioncode');
        }
        $assessmentinfo_model = new assessmentinfo_model();
        $form_message = '';

        $this->init_rpmb_session();
        $this->init_rpmbsearch_session();

        $rpmb['regionlist'] = $this->assessmentinfo_model->get_regions();

        if(isset($_SESSION['province']) or isset($_SESSION['region'])) {
            $rpmb['provlist'] = $this->assessmentinfo_model->get_provinces($_SESSION['region']);
        }
        if(isset($_SESSION['city']) or isset($_SESSION['province'])) {
            $rpmb['citylist'] = $this->assessmentinfo_model->get_cities($_SESSION['province']);
        }

        $this->load->view('header');
       $this->load->view('nav');
        $this->load->view('sidebar');
        $this->load->view('assessmentinfo_list',array(
            'assessmentinfo_data'=>$assessmentinfo_model->getAssessmentinfo($region),
            'list_fields'=>$this->listFields(),
            'form_message'=>$form_message
        ));
        $this->load->view('footer');
    }


    public function addAssessmentinfo()
    {
        if (!$this->session->userdata('user_id'))
        {
            redirect('/users/login','location');
        }

        $accessLevel = $this->session->userdata('accessLevel');

        if($accessLevel == -1){
            $region = '000000000';
        } else {
            $region = $this->session->userdata('lswdo_regioncode');
        }

        $assessmentinfo_model = new assessmentinfo_model();
        $application_type_name = $assessmentinfo_model->Lib_getAllApplicationtype();
        $lgu_type_name = $assessmentinfo_model->Lib_getLGUtype();

        $this->validateAddForm();

        if (!$this->form_validation->run()){
            $form_message = '';
            $this->load->view('header');
            $this->load->view('nav');
            $this->load->view('sidebar');

            $this->init_rpmb_session();
            $rpmb['regionlist'] = $this->assessmentinfo_model->get_regions();
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
            $office_address = $this->input->post('office_address');
            $swdo_name = $this->input->post('swdo_name');
            $designation = $this->input->post('designation');
            $contact_no = $this->input->post('contact_no');
            $email = $this->input->post('email');
            $website = $this->input->post('website');
            $total_ira = $this->input->post('total_ira');
            $total_budget_lswdo = $this->input->post('total_budget_lswdo');
            $created_by = $this->session->userdata('user_id');
            $date_created = 'NOW()';

            if ($citylist == 0) {
            $citylist = "null";
            }

            $addResult = $assessmentinfo_model->insertAssessmentinfo($application_type_id,$lgu_type_id,$regionlist,$provlist,$citylist,$office_address,$swdo_name,$designation,$contact_no,$email,$website,$total_ira,$total_budget_lswdo,$created_by,$date_created);
            if ($addResult){

                $this->init_rpmb_session();
                $rpmb['regionlist'] = $this->assessmentinfo_model->get_regions();

                if(isset($_SESSION['province']) or isset($_SESSION['region'])) {
                    $rpmb['provlist'] = $this->assessmentinfo_model->get_provinces($_SESSION['region']);
                }
                if(isset($_SESSION['city']) or isset($_SESSION['province'])) {
                    $rpmb['citylist'] = $this->assessmentinfo_model->get_cities($_SESSION['province']);
                }

                $form_message = 'Add Succeeded!';
                $this->load->view('header');
                $this->load->view('nav');
                $this->load->view('sidebar');

                $this->load->view('assessmentinfo_list',array(
                    'application' => $application_type_name,
                    'lgu_type' => $lgu_type_name,
                    'assessmentinfo_data'=>$assessmentinfo_model->getAssessmentinfo($region),
                    'list_fields'=>$this->listFields(),
                    'form_message'=>$form_message,

                ));
                $this->load->view('footer');
                $this->redirectIndex2($addResult);
            }
        }
    }

    public function redirectIndex2($addResult)
    {
        $page = base_url('budgetallocation/addBudgetAllocation/'.$addResult);
//        $sec = "1";
        header("Location: $page");
    }


    public function editAssessmentinfo($id = 0)
    {
        if (!$this->session->userdata('user_id'))
        {
            redirect('/users/login','location');
        }

        $accessLevel = $this->session->userdata('accessLevel');

        if($accessLevel == -1){
            $region = '000000000';
        } else {
            $region = $this->session->userdata('lswdo_regioncode');
        }

        if ($id > 0){
            $assessmentinfo_model = new assessmentinfo_model();

            $application_type_name = $assessmentinfo_model->Lib_getAllApplicationtype();
            $lgu_type_name = $assessmentinfo_model->Lib_getLGUtype();

            $this->validateEditForm();

            if (!$this->form_validation->run()) {
                $form_message = '';
                $this->load->view('header');
                $this->load->view('nav');
                $this->load->view('sidebar');

                $this->init_rpmb_session();
                $rpmb['regionlist'] = $this->assessmentinfo_model->get_regions();
                $rpmb['application'] = $application_type_name;
                $rpmb['lgu_type'] = $lgu_type_name;
                $rpmb['form_message'] = $form_message;

                if(isset($_SESSION['province']) or isset($_SESSION['region'])) {
                    $rpmb['provlist'] = $this->assessmentinfo_model->get_provinces($_SESSION['region']);
                }
                if(isset($_SESSION['city']) or isset($_SESSION['province'])) {
                    $rpmb['citylist'] = $this->assessmentinfo_model->get_cities($_SESSION['province']);
                }

                $rpmb['assessmentinfo_details'] = $this->assessmentinfo_model->getAssessmentinfoByID($id);
                $this->load->view('assessmentinfo_edit', $rpmb);
                $this->load->view('footer');

            } else {

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
                $modified_by= $this->session->userdata('user_id');
                $date_modified = 'NOW()';

                if ($citylist == 0) {
                   $citylist = "null";
                }

                $updateResult = $assessmentinfo_model->updateAssessmentinfo($id,$application_type_id,$lgu_type_id,$regionlist,$provlist,$citylist,$office_address,$swdo_name,$designation,$contact_no,$email,$website,$total_ira,$total_budget_lswdo,$modified_by,$date_modified);
                if ($updateResult){

                    $this->init_rpmb_session();
                    $rpmb['application_type_id'] = $this->assessmentinfo_model->Lib_getAllApplicationtype();
                    $rpmb['lgu_type_id'] = $this->assessmentinfo_model->Lib_getLGUtype();
                    $rpmb['regionlist'] = $this->assessmentinfo_model->get_regions();

                    if(isset($_SESSION['province']) or isset($_SESSION['region'])) {
                        $rpmb['provlist'] = $this->assessmentinfo_model->get_provinces($_SESSION['region']);
                    }
                    if(isset($_SESSION['city']) or isset($_SESSION['province'])) {
                        $rpmb['citylist'] = $this->assessmentinfo_model->get_cities($_SESSION['province']);
                    }

                    $form_message = 'Update Succeeded';
                    $this->load->view('header');
                    $this->load->view('nav');
                    $this->load->view('sidebar');

                    $this->load->view('assessmentinfo_list',array(
                        'application' => $application_type_name,
                        'lgu_type' => $lgu_type_name,
                        'assessmentinfo_data'=>$assessmentinfo_model->getAssessmentinfo($region),
                        'list_fields'=>$this->listFields(),
                        'form_message'=>$form_message
                    ));
                }
                $this->redirectIndex();
            }
        }
        else
        {
            $this->load->view('no_id',array('redirectIndex'=>$this->redirectIndex()));
        }
    }


    public function assessmentinfo_masterview($id = 0,$form_message = '')
    {
        if (!$this->session->userdata('user_id'))
        {
            redirect('/users/login','location');
        }

        $accessLevel = $this->session->userdata('accessLevel');

        if($accessLevel == -1){
            $region = '000000000';
        } else {
            $region = $this->session->userdata('lswdo_regioncode');
        }

        $assessmentinfo_model = new assessmentinfo_model();
        $AssessmentDetails = $assessmentinfo_model->getAssessmentinfoByID($id);

        if ($AssessmentDetails){
            $form_message = $form_message;
            $data = array(
                'profile_id'                 =>      $AssessmentDetails->profile_id,
                'application_type_id'        =>      $AssessmentDetails->application_type_id,
                'application_type_name'      =>      $AssessmentDetails->application_type_name,
                'lgu_type_id'                =>      $AssessmentDetails->lgu_type_id,
                'lgu_type_name'              =>      $AssessmentDetails->lgu_type_name,
                'region_name'                =>      $AssessmentDetails->region_name,
                'prov_name'                  =>      $AssessmentDetails->prov_name,
                'city_name'                  =>      $AssessmentDetails->city_name,
                'office_address'             =>      $AssessmentDetails->office_address,
                'swdo_name'                  =>      $AssessmentDetails->swdo_name,
                'designation'                =>      $AssessmentDetails->designation,
                'contact_no'                 =>      $AssessmentDetails->contact_no,
                'email'                      =>      $AssessmentDetails->email,
                'website'                    =>      $AssessmentDetails->website,
                'total_ira'                  =>      $AssessmentDetails->total_ira,
                'total_budget_lswdo'         =>      $AssessmentDetails->total_budget_lswdo,
                'form_message'  =>      $form_message

            );
        } else {
            $form_message = 'No records found!';
            $data = array(
                'form_message'      =>      $form_message
            );
        }

        $this->load->view('header');
        $this->load->view('nav');
        $this->load->view('sidebar');
        $this->load->view('assessmentinfo_masterview',$data);
        $this->load->view('footer');
    }


    public function delete_assessmentinfo($id = 0)
    {

        if (!$this->session->userdata('user_id'))
        {
            redirect('/users/login','location');
        }

        $accessLevel = $this->session->userdata('accessLevel');

        if($accessLevel == -1){
            $region = '000000000';
        } else {
            $region = $this->session->userdata('lswdo_regioncode');
        }

        $assessmentinfo_model = new assessmentinfo_model();
        if ($id > 0){
            $deleteResult = $assessmentinfo_model->deleteAssessmentinfo($id);
            $deleteResultbudget = $assessmentinfo_model->deleteAssessmentinfoBudget($id);
            if ($deleteResult && $deleteResultbudget ){
                $form_message = 'Delete Succeeded!';
                $this->load->view('header');
                $this->load->view('nav');
                $this->load->view('assessmentinfo_list',array(
                    'assessmentinfo_data'=>$assessmentinfo_model->getAssessmentinfo($region),
                    'list_fields'=>$this->listFields(),
                    'form_message'=>$form_message,
                ));
                $this->load->view('footer');
                $this->redirectIndex();


            }
        }
    }

    public function redirectIndex()
    {
        $page = base_url('assessmentinfo/index/');
//        $sec = "1";
        header("Location: $page");
    }

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

            $citylist_prop = 'id="citylist" name="citylist" onchange="get_nameofCity();" class="form-control"';
            echo form_dropdown('citylist', $city_list,'',$citylist_prop);
        }
    }


    public function populate_cities1() {
        if($_POST['prov_code'] > 0 and isset($_POST) and isset($_POST['prov_code'])) {
            $prov_code = $_POST['prov_code'];
            $citylist = $this->assessmentinfo_model->get_cities1($prov_code);

            $city_list[] = "Choose City";
            foreach($citylist as $tempcity) {
                $city_list[$tempcity->city_code] = $tempcity->city_name;
            }

            $citylist_prop = 'id="citylist" name="citylist" onchange="get_brgy();" class="form-control"';
            echo form_dropdown('citylist', $city_list,'',$citylist_prop);
        }
    }

    public function populate_cities2() {
        if($_POST['prov_code'] > 0 and isset($_POST) and isset($_POST['prov_code'])) {
            $prov_code = $_POST['prov_code'];
            $citylist = $this->assessmentinfo_model->get_cities2($prov_code);

            $city_list[] = "Choose City";
            foreach($citylist as $tempcity) {
                $city_list[$tempcity->city_code] = $tempcity->city_name;
            }

            $citylist_prop = 'id="citylist" name="citylist" onchange="get_brgy();" class="form-control"';
            echo form_dropdown('citylist', $city_list,'',$citylist_prop);
        }
    }


    public function populate_countcity()
    {
        if($_POST['prov_code'] > 0 and isset($_POST) and isset($_POST['prov_code']))
        {
            $prov_code = $_POST['prov_code'];
            $numberofcities = $this->assessmentinfo_model->get_count_city($prov_code);

            $data = array(
                'type'        => 'text',
                'id'          => 'no_cities',
                'name'       => 'no_cities',
                'value'   =>  $numberofcities->value_sum,
                'class'        => 'form-control',
                'readonly' => true
            );

            echo form_input($data);

        }
    }


    public function populate_countmuni()
    {
        if($_POST['prov_code'] > 0 and isset($_POST) and isset($_POST['prov_code']))
        {
            $prov_code = $_POST['prov_code'];
            $numberofmuni = $this->assessmentinfo_model->get_count_muni($prov_code);

            $data = array(
                'type'        => 'text',
                'id'          => 'no_muni',
                'name'       => 'no_muni',
                'value'   =>  $numberofmuni->value_sum,
                'class'        => 'form-control',
                'readonly' => true
            );

            echo form_input($data);

        }
    }


    public function populate_countbrgy()
    {
        if($_POST['city_code'] > 0 and isset($_POST) and isset($_POST['city_code']))
        {
            $city_code = $_POST['city_code'];
            $numberofbrgy = $this->assessmentinfo_model->get_count_brgy($city_code);

            $data = array(
                'type'        => 'text',
                'id'          => 'no_brgy',
                'name'       => 'no_brgy',
                'value'   =>  $numberofbrgy->no_brgy,
                'class'        => 'form-control',
                'readonly' => true
            );

            echo form_input($data);

        }
    }

    public function populate_countbrgy3()
    {
        if($_POST['city_code'] > 0 and isset($_POST) and isset($_POST['city_code']))
        {
            $city_code = $_POST['city_code'];
            $numberofbrgy = $this->assessmentinfo_model->get_count_brgy3($city_code);

            $data = array(
                'type'        => 'text',
                'id'          => 'no_brgy',
                'name'       => 'no_brgy',
                'value'   =>  $numberofbrgy->no_brgy,
                'class'        => 'form-control',
                'readonly' => true
            );

            echo form_input($data);

        }
    }

    public function populate_countbrgy2()
    {
        if($_POST['prov_code'] > 0 and isset($_POST) and isset($_POST['prov_code']))
        {
            $prov_code = $_POST['prov_code'];
            $numberofbrgy = $this->assessmentinfo_model->get_count_brgy2($prov_code);

            $data = array(
                'type'        => 'text',
                'id'          => 'no_brgy',
                'name'       => 'no_brgy',
                'value'   =>  $numberofbrgy->no_brgy,
                'class'        => 'form-control',
                'readonly' => true
            );

            echo form_input($data);

        }
    }


    public function populate_incomeclass()
    {
        if($_POST['prov_code'] > 0 and isset($_POST) and isset($_POST['prov_code']))
        {
            $prov_code = $_POST['prov_code'];
            $incomeclass = $this->assessmentinfo_model->get_incomeclass($prov_code);

            $data = array(
                'type'        => 'text',
                'id'          => 'income_class',
                'name'       => 'income_class',
                'value'   =>  $incomeclass->income_class,
                'class'        => 'form-control',
                'readonly' => true
            );

            echo form_input($data);

        }
    }

    public function populate_incomeclass2()
    {
        if($_POST['city_code'] > 0 and isset($_POST) and isset($_POST['city_code']))
        {
            $city_code = $_POST['city_code'];
            $incomeclass = $this->assessmentinfo_model->get_incomeclass2($city_code);

            $data = array(
                'type'        => 'text',
                'id'          => 'income_class',
                'name'       => 'income_class',
                'value'   =>  $incomeclass->income_class,
                'class'        => 'form-control',
                'readonly' => true
            );

            echo form_input($data);

        }
    }

    public function populate_incomeclass3()
    {
        if($_POST['city_code'] > 0 and isset($_POST) and isset($_POST['city_code']))
        {
            $city_code = $_POST['city_code'];
            $incomeclass = $this->assessmentinfo_model->get_incomeclass3($city_code);

            $data = array(
                'type'        => 'text',
                'id'          => 'income_class',
                'name'       => 'income_class',
                'value'   =>  $incomeclass->income_class,
                'class'        => 'form-control',
                'readonly' => true
            );

            echo form_input($data);

        }
    }


    public function populate_total_pop()
    {
        if($_POST['prov_code'] > 0 and isset($_POST) and isset($_POST['prov_code']))
        {
            $prov_code = $_POST['prov_code'];
            $totalpop = $this->assessmentinfo_model->get_total_pop($prov_code);

            $data = array(
                'type'        => 'text',
                'id'          => 'total_pop',
                'name'       => 'total_pop',
                'value'   =>  $totalpop->total_pop,
                'class'        => 'form-control',
                'readonly' => true
            );

            echo form_input($data);

        }
    }

    public function populate_total_pop2()
    {
        if($_POST['city_code'] > 0 and isset($_POST) and isset($_POST['city_code']))
        {
            $city_code = $_POST['city_code'];
            $totalpop = $this->assessmentinfo_model->get_total_pop2($city_code);

            $data = array(
                'type'        => 'text',
                'id'          => 'total_pop',
                'name'       => 'total_pop',
                'value'   =>  $totalpop->total_pop,
                'class'        => 'form-control',
                'readonly' => true
            );

            echo form_input($data);

        }
    }

    public function populate_total_pop3()
    {
        if($_POST['city_code'] > 0 and isset($_POST) and isset($_POST['city_code']))
        {
            $city_code = $_POST['city_code'];
            $totalpop = $this->assessmentinfo_model->get_total_pop3($city_code);

            $data = array(
                'type'        => 'text',
                'id'          => 'total_pop',
                'name'       => 'total_pop',
                'value'   =>  $totalpop->total_pop,
                'class'        => 'form-control',
                'readonly' => true
            );

            echo form_input($data);

        }
    }


    public function populate_total_poor()
    {
        if($_POST['prov_code'] > 0 and isset($_POST) and isset($_POST['prov_code']))
        {
            $prov_code = $_POST['prov_code'];
            $totalpoor = $this->assessmentinfo_model->get_total_poor($prov_code);

            $data = array(
                'type'        => 'text',
                'id'          => 'total_poor',
                'name'       => 'total_poor',
                'value'   =>  $totalpoor->total_poor,
                'class'        => 'form-control',
                'readonly' => true
            );

            echo form_input($data);

        }
    }

    public function populate_total_poor2()
    {
        if($_POST['city_code'] > 0 and isset($_POST) and isset($_POST['city_code']))
        {
            $city_code = $_POST['city_code'];
            $totalpoor = $this->assessmentinfo_model->get_total_poor2($city_code);

            $data = array(
                'type'        => 'text',
                'id'          => 'total_poor',
                'name'       => 'total_poor',
                'value'   =>  $totalpoor->total_poor,
                'class'        => 'form-control',
                'readonly' => true
            );

            echo form_input($data);

        }
    }

    public function populate_total_poor3()
    {
        if($_POST['city_code'] > 0 and isset($_POST) and isset($_POST['city_code']))
        {
            $city_code = $_POST['city_code'];
            $totalpoor = $this->assessmentinfo_model->get_total_poor3($city_code);

            $data = array(
                'type'        => 'text',
                'id'          => 'total_poor',
                'name'       => 'total_poor',
                'value'   =>  $totalpoor->total_poor,
                'class'        => 'form-control',
                'readonly' => true
            );

            echo form_input($data);

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

    public function init_rpmbsearch_session() {
        if(isset($_POST['regionlistsearch']) and $_POST['regionlistsearch'] > 0) {
            $_SESSION['regionsearch'] = $_POST['regionlistsearch'];
        }
        if(isset($_POST['provlistsearch']) and $_POST['provlistsearch'] > 0) {
            $_SESSION['provincesearch'] = $_POST['provlistsearch'];
        }
        if(isset($_POST['citylistsearch']) and $_POST['citylistsearch'] > 0) {
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
        $query = $this->db->query('SELECT profile_id,application_type_id,lgu_type_id,region_code,prov_code,city_code,swdo_name,office_address,designation,contact_no,email,website,total_ira,total_budget_lswdo FROM tbl_lswdo');
        return $query->list_fields();
    }

    /*
        public function redirectIndex()
        {
                $page = base_url();
                $sec = "1";
                header("Refresh: $sec; url=$page");
        }
    */

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