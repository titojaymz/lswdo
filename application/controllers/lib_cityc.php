<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Created by PhpStorm.
 * User: mglveniegas
 * Date: 5/20/2016
 * Time: 4:07 PM
 */

class lib_cityc extends CI_Controller {

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

        $libcity_model = new libcity_model();
        $form_message = '';

        $this->load->view('header');
        $this->load->view('nav');
        $this->load->view('sidebar');
        $this->load->view('lib_citylist',array(
            'city_data'=>$libcity_model->listAllcity(),
            'form_message'=>$form_message
        ));
        $this->load->view('footer');

    }

    public function addcity()
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

        $libcity_model = new libcity_model();
        $provCode = $libcity_model->get_prov();
        $this->validateAddForm();

        if (!$this->form_validation->run()){
            $form_message = '';
            $this->load->view('header');
            $this->load->view('nav');
            $this->load->view('sidebar');


            $rpmb['prov'] = $provCode;
            $rpmb['form_message'] = $form_message;
            $this->load->view('lib_cityadd',$rpmb);
            $this->load->view('footer');
        } else {
            $city_code = $this->input->post('city_code');
            $city_name = $this->input->post('city_name');
            $prov_code = $this->input->post('prov_code');
            $district = $this->input->post('district');
            $city_class = $this->input->post('city_class');
            $income_class = $this->input->post('income_class');
            $created_by = $this->session->userdata('user_id');
            $date_created = 'NOW()';

            $libcity_model = new libcity_model();
            $addResult = $libcity_model->addCity($city_code,$city_name,$prov_code,$district,$city_class,$income_class,$created_by,$date_created);
            if ($addResult){
                $form_message = 'Add Succeeded!';
                $rpmb['region'] = $provCode;
                $this->load->view('header');
                $this->load->view('nav');
                $this->load->view('sidebar');
                $this->load->view('lib_citylist',array(
                    'prov' => $provCode,
                    'city_data'=>$libcity_model->listAllcity(),
                    'form_message'=>$form_message,

                ));
                $this->load->view('footer');
                $this->redirectIndex();

            }
        }
    }

    public function lib_cityview($id = 0,$form_message = '')
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

        $libcity_model = new libcity_model();
        $CityDetails = $libcity_model->getCityDetails($id);

        if ($CityDetails){
            $form_message = $form_message;
            $data = array(
                'city_code'                 =>      $CityDetails->city_code,
                'city_name'        =>      $CityDetails->city_name,
                'prov_code'      =>      $CityDetails->prov_code,
                'district'      =>      $CityDetails->district,
                'city_class'      =>      $CityDetails->city_class,
                'income_class'      =>      $CityDetails->income_class,
                'created_by'      =>      $CityDetails->created_by,
                'date_created'      =>      $CityDetails->date_created,
                'modified_by'      =>      $CityDetails->modified_by,
                'date_modified'      =>      $CityDetails->date_modified,

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
        $this->load->view('lib_cityview',$data);
        $this->load->view('footer');
    }

    public function editCity($id = "")
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
            $libcity_model = new libcity_model();
            $provCode = $libcity_model->get_prov();
            //  $application_type_name = $libregion_model->Lib_getAllApplicationtype();
            //   $lgu_type_name = $libregion_model->Lib_getLGUtype();

            $this->validateEditForm();

            if (!$this->form_validation->run()){
                $form_message = '';
                $this->load->view('header');
                $this->load->view('nav');
                $this->load->view('sidebar');


                $rpmb['prov'] = $provCode;
                $rpmb['city_details'] = $this->libcity_model->getCityDetails($id);
                $this->load->view('lib_cityedit', $rpmb);
                $this->load->view('footer');

            } else {

                $city_name = $this->input->post('city_name');
                $prov_code = $this->input->post('prov_code');
                $district = $this->input->post('district');
                $city_class = $this->input->post('city_class');
                $income_class = $this->input->post('income_class');
                $modified_by= $this->session->userdata('user_id');
                $date_modified = 'NOW()';

                $updateResult = $libcity_model->updateCity($id, $city_name, $prov_code, $district, $city_class, $income_class, $modified_by, $date_modified);
                if ($updateResult){
                    $this->load->view('header');
                    $this->load->view('nav');
                    $this->load->view('sidebar');

                    $rpmb['prov'] = $this->libcity_model->get_prov();
                    $this->load->view('lib_citylist', array(
                        'city_data' => $libcity_model->listAllcity()));
                    $this->load->view('footer');
                }
            }
        } else {
            $this->load->view('no_id',array('redirectIndex'=>$this->redirectIndex()));
        }
    }

    public function delete_city($id = 0)
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

        $libcity_model = new libcity_model();
        if ($id > 0){
            $deleteResult = $libcity_model->deleteCity($id);
            if ($deleteResult){
                $form_message = '<div class="kode-alert kode-alert kode-alert-icon kode-alert-click alert3"><i class="fa fa-lock"></i> Delete Succeeded! <a href="#" class="closed">&times;</a></div>';
                $this->load->view('header');
                $this->load->view('nav');
                $this->load->view('lib_citylist',array(
                    'city_data'=>$libcity_model->listAllcity(),
                    'form_message'=>$form_message,
                    $this->redirectIndex()
                ));
                $this->load->view('footer');

            }
        }
    }

    protected function validateAddForm()
    {
        $config = array(
            array(
                'field'   => 'city_name',
                'label'   => 'City Name',
                'rules'   => 'required'
            )/*,
            array(
                'field'   => 'city_code',
                'label'   => 'City Code',
                'rules'   => 'required|integer'
            ),
            array(
                'field'   => 'rural_urban',
                'label'   => 'Rural Urban',
                'rules'   => 'required|integer'
            ),
            array(
                'field'   => 'Total_Poor_HHs',
                'label'   => 'Total Poor HouseHolds',
                'rules'   => 'required|integer'
            )*/
        );

        return $this->form_validation->set_rules($config);
    }

    protected function validateEditForm()
    {
        $config = array(
            array(
                'field'   => 'city_name',
                'rules'   => 'required'
            )

        );

        return $this->form_validation->set_rules($config);
    }

    public function redirectIndex($sec = 1)
    {
        $page = base_url('lib_cityc/index');
        header("Refresh: $sec; url=$page");
    }

}