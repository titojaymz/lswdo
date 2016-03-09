<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Created by PhpStorm.
 * User: mglveniegas
 * Date: 3/7/2016
 * Time: 9:56 AM
 */

class Assessmentinfo extends CI_Controller
{

    public function index()
    {
        //pagination
        $this->load->library('pagination');
        $this->load->library('model');
        $user_region = $this->session->userdata('uregion');
        /*  $config=array();
          $config['base_url'] = base_url().'familyinfo/index';
          $config['total_rows'] = $this->familyinfo_model->record_count();
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

          $this->pagination->initialize($config);*/
        $rpmb['tbl_lswdo'] = $this->assessmentinfo_model->fetch_assessmentinfo($user_region);
        //rpmb


        $this->init_rpmb_session();
        $this->init_rpmbsearch_session();
        $rpmb['regionlist'] = $this->assessmentinfo_model->get_regions();
        // $rpmb['fposition_id'] = $this->familyinfo_model->get_fposition();

        if(isset($_SESSION['region']) or isset($_SESSION['type'])) {
            $rpmb['typelist'] = $this->assessmentinfo_model->get_regions($_SESSION['type']);
        }
        if(isset($_SESSION['province']) or isset($_SESSION['region'])) {
            $rpmb['provlist'] = $this->assessmentinfo_model->get_provinces($_SESSION['region']);
        }
        if(isset($_SESSION['muni']) or isset($_SESSION['province'])) {
            $rpmb['citylist'] = $this->assessmentinfo_model->get_muni($_SESSION['province']);
        }
        if(isset($_SESSION['brgy']) or isset($_SESSION['muni'])) {
            $rpmb['brgylist'] = $this->assessmentinfo_model->get_brgy($_SESSION['muni']);
        }
        //call the model function to get the family info data
        $this->load->view('header');
        $this->load->view('nav');
        $this->load->view('sidebar');
        $this->load->view('assessmentinfo_listview', $rpmb);
        $this->load->view('sidepanel');
        $this->load->view('footer');


    }
    public function addAssessmentinfo()
    {

        $this->validateAddForm();

        if ($this->form_validation->run() == FALSE)
        {
            //fail validation
            $this->load->view('header');
            $this->init_rpmb_session();
            $rpmb['regionlist'] = $this->assessmentinfo_model->get_regions();
            //  $rpmb['fposition_id'] = $this->familyinfo_model->get_fposition();

            if(isset($_SESSION['region']) or isset($_SESSION['type'])) {
                $rpmb['typelist'] = $this->assessmentinfo_model->get_regions($_SESSION['type']);
            }
            if(isset($_SESSION['province']) or isset($_SESSION['region'])) {
                $rpmb['provlist'] = $this->assessmentinfo_model->get_provinces($_SESSION['region']);
            }
            if(isset($_SESSION['muni']) or isset($_SESSION['province'])) {
                $rpmb['citylist'] = $this->assessmentinfo_model->get_muni($_SESSION['province']);
            }
            if(isset($_SESSION['brgy']) or isset($_SESSION['muni'])) {
                $rpmb['brgylist'] = $this->assessmentinfo_model->get_brgy($_SESSION['muni']);
            }

            $this->load->view('assessmentinfo_add',$rpmb);

        }
        else
        {
            $assessmentinfo_model = new assessmentinfo_model();
            //pass validation
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
//                $status = $this->input->post('status');
//                $region = $this->input->post('region');


            $addResult = $assessmentinfo_model->insertAssessmentinfo($application_type_id,$lgu_type_id,$region_code,$prov_code,$city_code,$brgy_code,$street_address,$swdo_name,$contact_no,$email,$website,$total_ira,$total_budget_lswdo);
            if ($addResult){
                //$this->load->view('header');
                //$this->load->view('nav');
                //$this->load->view('sidebar');
                //$this->load->view('familyinfo_listview', array(
                //    /*familyinfolist to be use on familylist view*/
                //    'familyinfolist' => $familyinfo_model->get_familyinfo_list()));
//                  //  redirect('familyinfo/addFamilyinfo');
                //$this->load->view('sidepanel');
                //$this->load->view('footer');
                //pagination
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
                $data['tbl_family_information'] = $this->assessmentinfo_model->fetch_assessmentinfo($config['per_page'], $this->uri->segment(3));
                //rpmb
                $this->init_rpmb_session();
                $rpmb['regionlist'] = $this->assessmentinfo_model->get_regions();
                $rpmb['fposition_id'] = $this->assessmentinfo_model->get_fposition();

                if(isset($_SESSION['province']) or isset($_SESSION['region'])) {
                    $rpmb['provlist'] = $this->assessmentinfo_model->get_provinces($_SESSION['region']);
                }
                if(isset($_SESSION['muni']) or isset($_SESSION['province'])) {
                    $rpmb['citylist'] = $this->assessmentinfo_model->get_muni($_SESSION['province']);
                }
                if(isset($_SESSION['brgy']) or isset($_SESSION['muni'])) {
                    $rpmb['brgylist'] = $this->assessmentinfo_model->get_brgy($_SESSION['muni']);
                }
                //call the model function to get the family info data
                $datarpmb = array_merge($data,$rpmb); //added array merge
                $this->load->view('header');
                $this->load->view('nav');
                $this->load->view('sidebar');
                $this->load->view('assessmentinfo_listview', $datarpmb);
                $this->load->view('sidepanel');
                $this->load->view('footer');
            }
            //paalis e2 para makita ung error na fetch_familyinfo user_region unknown
            $this->redirectIndex();
        }

    }
    public function editAssessmentinfo($profile_id = 0)
    {
        if ($profile_id > 0)
        {

            $assessmentinfo_model = new assessmentinfo_model();
            $this->validateEditForm();

            if (!$this->form_validation->run())

            {
                $this->load->view('header');
                $this->load->view('nav');
                $this->load->view('sidebar');
                //  $this->init_rpmb_session();
                $rpmb['regionlist'] = $this->assessmentinfo_model->get_regions();
                $rpmb['application_type_id'] = $this->assessmentinfo_model->get_application_type();

                /*family details base on Family_ID*/
                $rpmb['assessmentinfo_details'] = $this->assessmentinfo_model->getprofileiD($profile_id);
                $this->load->view('assessmentinfo_edit',$rpmb);
                $this->load->view('sidepanel');
                $this->load->view('footer');

            }

            else
            {
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

//                             $status = $this->input->post('status');
//                             $region = $this->input->post('region');

                $updateResult = $assessmentinfo_model->updateAssessmentinfo($profile_id,$application_type_id,$lgu_type_id,$region_code,$prov_code,$city_code,$brgy_code,$street_address,$swdo_name,$contact_no,$email,$website,$total_ira,$total_budget_lswdo);
                if ($updateResult){
                    //$this->load->view('header');
                    //$this->load->view('nav');
                    //$this->load->view('sidebar');
                    //$this->load->view('familyinfo_listview',array(
                    //    'familyinfolist'=>$familyinfo_model->get_familyinfo_list()
                    //));
                    //$this->load->view('sidepanel');
                    //$this->load->view('footer');
                    //pagination
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
                    //rpmb
                    $this->init_rpmb_session();
                    $rpmb['regionlist'] = $this->assessmentinfo_model->get_regions();
                    // $rpmb['fposition_id'] = $this->assessmentinfo_model->get_fposition();

                    if(isset($_SESSION['region']) or isset($_SESSION['type'])) {
                        $rpmb['typelist'] = $this->assessmentinfo_model->get_regions($_SESSION['type']);
                    }
                    if(isset($_SESSION['province']) or isset($_SESSION['region'])) {
                        $rpmb['provlist'] = $this->assessmentinfo_model->get_provinces($_SESSION['region']);
                    }
                    if(isset($_SESSION['muni']) or isset($_SESSION['province'])) {
                        $rpmb['citylist'] = $this->assessmentinfo_model->get_muni($_SESSION['province']);
                    }
                    if(isset($_SESSION['brgy']) or isset($_SESSION['muni'])) {
                        $rpmb['brgylist'] = $this->assessmentinfo_model->get_brgy($_SESSION['muni']);
                    }
                    //call the model function to get the family info data
                    $datarpmb = array_merge($data,$rpmb); //added array merge
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
    public function delete_assessmentinfo($fam_id = 0)
    {
        $assessmentinfo_model = new assessmentinfo_model();
        if ($fam_id > 0){
            $deleteResult = $assessmentinfo_model->deleteAssessmentinfo($fam_id);
            if ($deleteResult){
                $this->load->view('header');
                $this->load->view('assessmentinfo_listview',array(
                    'assessmentinfolist'=>$assessmentinfo_model->get_assessmentinfo_list()

                ));
                $this->redirectIndex();
            }
        }
    }

    //search
    //public function search(){
    //	$this->load->model('familyinfor_model');
    //	$regionlist = $this->input->post('regionlist');
    //	$provlist = $this->input->post('provlist');}
    //	$munilist = $this->input->post('munilist');
    //	$brgylist = $this->input->post('brgylist');
    //	$datarpmb = array_merge($data,$rpmb); //added array merge
    //	$this->load->view('header');
    //	$this->load->view('nav');
    //	$this->load->view('sidebar');
    //	$this->load->view('familyinfo_listview', $datarpmb);
    //	$this->load->view('sidepanel');
    //	$this->load->view('footer');
    //
    //	if(isset($regionlist) and !empty($regionlist)){
    //		$data['tbl_family_information'] = $this->familyinfo_model->search($regionlist);
    //		$this->load->view('familyinfo_listview',$datarpmb)
    //	}else{
    //
    //	}
    //}

    //fposition_id
    public function fposition_session(){
        if(isset($_POST['fposition_id']) and $_POST['fposition_id'] > 0) {
            $_SESSION['fposition'] = $_POST['fposition_id'];
        }
    }




    public function populate_prov() {
        if($_POST['region_code'] > 0 and isset($_POST) and isset($_POST['region_code'])) {

            $region_code = $_POST['region_code'];
            $provlist = $this->assessmentinfo_model->get_provinces($region_code);

            $province_list[] = "Choose Province";
            foreach($provlist as $tempprov) {
                $province_list[$tempprov->id_province] = $tempprov->prov_name;
            }

            $provlist_prop = 'id="provlist" name="provlist" class="form-control" onChange="get_muni();"';

            echo form_dropdown('provlist', $province_list, '', $provlist_prop);
        }
    }
    //grace
    public function populate_type() {
        if($_POST['type_code'] > 0 and isset($_POST) and isset($_POST['type_code'])) {

            $type_code = $_POST['type_code'];
            $typelist = $this->assessmentinfo_model->get_regions($type_code);

            $type_list[] = "Choose Type of LSWDO";
            foreach($typelist as $tempregion) {
                $type_list[$tempregion->type_code] = $tempregion->type_name;
            }

            $typelist_prop = 'id="typelist" name="typelist" class="form-control" onChange="get_regions();"';

            echo form_dropdown('typelist', $type_list, '', $typelist_prop);
        }
    }

    public function populate_city() {
        if($_POST['prov_code'] > 0 and isset($_POST) and isset($_POST['prov_code'])) {
            $prov_code = $_POST['prov_code'];
            $citylist = $this->assessmentinfo_model->get_city($prov_code);

            $city_list[] = "Choose Municipality";
            foreach($citylist as $tempcity) {
                $city_list[$tempcity->id_municipality] = $tempcity->city_name;
            }

            $citylist_prop = 'id="citylist" name="citylist" onchange="get_brgy();" class="form-control"';
            echo form_dropdown('citylist', $city_list,'',$citylist_prop);
        }
    }
    public function populate_brgy() {
        if($_POST['city_code'] > 0 and isset($_POST) and isset($_POST['city_code'])) {
            $city_code = $_POST['city_code'];
            $brgylist = $this->assessmentinfo_model->get_brgy($city_code);

            $brgy_list[] = "Choose Barangay";
            foreach($brgylist as $tempbrgy) {
                $brgy_list[$tempbrgy->id_barangay] = $tempbrgy->brgy_name;
            }

            $brgylist_prop = 'id="brgylist" name="brgylist" class="form-control"';
            echo form_dropdown('brgylist', $brgy_list,'',$brgylist_prop);
        }
    }
    public function init_rpmb_session() {
        if(isset($_POST['typelist']) and $_POST['typelist'] > 0) {
            $_SESSION['type'] = $_POST['typelist'];
        }
        if(isset($_POST['regionlist']) and $_POST['regionlist'] > 0) {
            $_SESSION['region'] = $_POST['regionlist'];
        }
        if(isset($_POST['provlist']) and $_POST['provlist'] > 0) {
            $_SESSION['province'] = $_POST['provlist'];
        }
        if(isset($_POST['citylist']) and $_POST['citylist'] > 0) {
            $_SESSION['city'] = $_POST['citylist'];
        }
        if(isset($_POST['brgylist']) and $_POST['brgylist'] > 0) {
            $_SESSION['brgy'] = $_POST['brgylist'];
        }
    }

    public function init_rpmbsearch_session() {
        if(isset($_POST['typelistsearch']) and $_POST['typelistsearch'] > 0) {
            $_SESSION['typesearch'] = $_POST['typelistsearch'];
        }
        if(isset($_POST['regionlistsearch']) and $_POST['regionlistsearch'] > 0) {
            $_SESSION['regionsearch'] = $_POST['regionlistsearch'];
        }
        if(isset($_POST['provlistsearch']) and $_POST['provlistsearch'] > 0) {
            $_SESSION['provincesearch'] = $_POST['provlistsearch'];
        }
        if(isset($_POST['citylistsearch']) and $_POST['citylistsearch'] > 0) {
            $_SESSION['city'] = $_POST['citylist'];
        }
        if(isset($_POST['brgylist']) and $_POST['brgylist'] > 0) {
            $_SESSION['brgy'] = $_POST['brgylist'];
        }
    }
    protected function validateAddForm()
    {
        $config = array(
            array(
                'field' => 'application_type_id',
                'label' => 'application_type_id',
                'rules' => 'alpha'
            )

        );
        return $this->form_validation->set_rules($config);

    }
    protected function validateEditForm()
    {
        $config = array(
            array(
                'field' => 'application_type_id',
                'label' => 'application_type_id',
                'rules' => 'alpha'
            )

        );
        return $this->form_validation->set_rules($config);

    }
    public function redirectIndex()
    {
        $page = base_url('assessmentinfo/index');

        header("LOCATION: $page");
    }



}

?>