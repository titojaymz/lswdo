<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Created by PhpStorm.
 * User: mglveniegas
 * Date: 5/20/2016
 * Time: 4:07 PM
 */

class lib_brgyc extends CI_Controller {

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

        $libbrgy_model = new libbrgy_model();
        $form_message = '';

        $this->load->view('header');
        $this->load->view('nav');
        $this->load->view('sidebar');
        $this->load->view('lib_brgylist',array(
            'brgy_data'=>$libbrgy_model->listAllbrgy(),
            'form_message'=>$form_message
        ));
        $this->load->view('footer');

    }

    public function addbrgy()
    {

        if (!$this->session->userdata('user_id'))
        {
            redirect('/users/login','location');
        }
/*
        $accessLevel = $this->session->userdata('accessLevel');

        if($accessLevel == -1){
            $region = '000000000';
        } else {
            $region = $this->session->userdata('lswdo_regioncode');
        }
*/
        $libbrgy_model = new libbrgy_model();
        $cityCode = $libbrgy_model->get_city();
        $this->validateAddForm();

        if (!$this->form_validation->run()){
            $form_message = '';
            $this->load->view('header');
            $this->load->view('nav');
            $this->load->view('sidebar');


            $rpmb['city'] = $cityCode;
            $rpmb['form_message'] = $form_message;
            $this->load->view('lib_brgyadd',$rpmb);
            $this->load->view('footer');
        } else {
            $brgy_code = $this->input->post('brgy_code');
            $brgy_name = $this->input->post('brgy_name');
            $city_code = $this->input->post('city_code');
            $rural_urban = $this->input->post('rural_urban');
            $old_brgy_psgc = $this->input->post('old_brgy_psgc');
            $total_pop = $this->input->post('total_pop');
            $Total_Poor_HHs = $this->input->post('Total_Poor_HHs');
            $Total_Poor_Families = $this->input->post('Total_Poor_Families');
            $created_by = $this->session->userdata('user_id');
            $date_created = 'NOW()';

            $libbrgy_model = new libbrgy_model();
            $addResult = $libbrgy_model->addBrgy($brgy_code,$brgy_name,$city_code,$rural_urban,$old_brgy_psgc,$total_pop,$Total_Poor_HHs,$Total_Poor_Families,$created_by,$date_created);
            if ($addResult){
                $form_message = 'Add Succeeded!';
                $rpmb['city'] = $cityCode;
                $this->load->view('header');
                $this->load->view('nav');
                $this->load->view('sidebar');
                $this->load->view('lib_brgylist',array(
                    'city' => $cityCode,
                    'brgy_data'=>$libbrgy_model->listAllbrgy(),
                    'form_message'=>$form_message,

                ));
                $this->load->view('footer');
                $this->redirectIndex();

            }
        }
    }

    public function lib_brgyview($id = 0,$form_message = '')
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

        $libbrgy_model = new libbrgy_model();
        $BrgyDetails = $libbrgy_model->getBrgyDetails($id);

        if ($BrgyDetails){
            $form_message = $form_message;
            $data = array(
                'brgy_code'                 =>      $BrgyDetails->brgy_code,
                'brgy_name'        =>      $BrgyDetails->brgy_name,
                'city_code'      =>      $BrgyDetails->city_code,
                'rural_urban'      =>      $BrgyDetails->rural_urban,
                'old_brgy_psgc'      =>      $BrgyDetails->old_brgy_psgc,
                'total_pop'      =>      $BrgyDetails->total_pop,
                'Total_Poor_HHs'      =>      $BrgyDetails->Total_Poor_HHs,
                'Total_Poor_Families'      =>      $BrgyDetails->Total_Poor_Families,
                'created_by'      =>      $BrgyDetails->created_by,
                'date_created'      =>      $BrgyDetails->date_created,
                'modified_by'      =>      $BrgyDetails->modified_by,
                'date_modified'      =>      $BrgyDetails->date_modified,

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
        $this->load->view('lib_brgyview',$data);
        $this->load->view('footer');
    }

    public function editBrgy($id = "")
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
            $libbrgy_model = new libbrgy_model();
            $cityCode = $libbrgy_model->get_city();
            //  $application_type_name = $libregion_model->Lib_getAllApplicationtype();
            //   $lgu_type_name = $libregion_model->Lib_getLGUtype();

            $this->validateEditForm();

            if (!$this->form_validation->run()){
                $form_message = '';
                $this->load->view('header');
                $this->load->view('nav');
                $this->load->view('sidebar');


                $rpmb['city'] = $cityCode;
                $rpmb['brgy_details'] = $this->libbrgy_model->getBrgyDetails($id);
                $this->load->view('lib_brgyedit', $rpmb);
                $this->load->view('footer');

            } else {

                $brgy_name = $this->input->post('brgy_name');
                $city_code = $this->input->post('city_code');
                $rural_urban = $this->input->post('rural_urban');
                $old_brgy_psgc = $this->input->post('old_brgy_psgc');
                $total_pop = $this->input->post('total_pop');
                $Total_Poor_HHs = $this->input->post('Total_Poor_HHs');
                $Total_Poor_Families = $this->input->post('Total_Poor_Families');
                $modified_by= $this->session->userdata('user_id');
                $date_modified = 'NOW()';

                $updateResult = $libbrgy_model->updateBrgy($id, $brgy_name, $city_code, $rural_urban, $old_brgy_psgc,$total_pop,$Total_Poor_HHs, $Total_Poor_Families,$modified_by,$date_modified);
                if ($updateResult){
                    $this->load->view('header');
                    $this->load->view('nav');
                    $this->load->view('sidebar');

                    $rpmb['city'] = $this->libbrgy_model->get_city();
                    $this->load->view('lib_brgylist', array(
                        'brgy_data' => $libbrgy_model->listAllbrgy()));
                    $this->load->view('footer');
                }
            }
        } else {
            $this->load->view('no_id',array('redirectIndex'=>$this->redirectIndex()));
        }
    }

    public function delete_brgy($id = 0)
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

        $libbrgy_model = new libbrgy_model();
        if ($id > 0){
            $deleteResult = $libbrgy_model->deleteBrgy($id);
            if ($deleteResult){
                $form_message = '<div class="kode-alert kode-alert kode-alert-icon kode-alert-click alert3"><i class="fa fa-lock"></i> Delete Succeeded! <a href="#" class="closed">&times;</a></div>';
                $this->load->view('header');
                $this->load->view('nav');
                $this->load->view('lib_brgylist',array(
                    'brgy_data'=>$libbrgy_model->listAllbrgy(),
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
                'field'   => 'brgy_name',
                'label'   => 'Brgy Name',
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
                'field'   => 'brgy_name',
                'rules'   => 'required'
            )

        );

        return $this->form_validation->set_rules($config);
    }

    public function redirectIndex($sec = 1)
    {
        $page = base_url('lib_brgyc/index');
        header("Refresh: $sec; url=$page");
    }

}