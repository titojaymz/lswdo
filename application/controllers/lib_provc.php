<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Created by PhpStorm.
 * User: mglveniegas
 * Date: 5/20/2016
 * Time: 4:07 PM
 */

class lib_provc extends CI_Controller {

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

        $libprov_model = new libprov_model();
        $form_message = '';

        $this->load->view('header');
        $this->load->view('nav');
        $this->load->view('sidebar');
        $this->load->view('lib_provlist',array(
            'prov_data'=>$libprov_model->listAllprov(),
            'form_message'=>$form_message
        ));
        $this->load->view('footer');

    }

    public function addprov()
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

        $libprov_model = new libprov_model();
        $regionCode = $libprov_model->get_region();
        $this->validateAddForm();

        if (!$this->form_validation->run()){
            $form_message = '';
            $this->load->view('header');
            $this->load->view('nav');
            $this->load->view('sidebar');


            $rpmb['region'] = $regionCode;
            $rpmb['form_message'] = $form_message;
            $this->load->view('lib_provadd',$rpmb);
            $this->load->view('footer');
        } else {
            $prov_code = $this->input->post('prov_code');
            $prov_name = $this->input->post('prov_name');
            $region_code = $this->input->post('region_code');
            $income_class = $this->input->post('income_class');
            $created_by = $this->session->userdata('user_id');
            $date_created = 'NOW()';

            $libprov_model = new libprov_model();
            $addResult = $libprov_model->addProv($prov_code,$prov_name,$region_code,$income_class,$created_by,$date_created);
            if ($addResult){
                $form_message = 'Add Succeeded!';
                $rpmb['region'] = $regionCode;
                $this->load->view('header');
                $this->load->view('nav');
                $this->load->view('sidebar');
                $this->load->view('lib_provlist',array(
                    'region' => $regionCode,
                    'prov_data'=>$libprov_model->listAllprov(),
                    'form_message'=>$form_message,

                ));
                $this->load->view('footer');
                $this->redirectIndex();

            }
        }
    }

    public function lib_provview($id = 0,$form_message = '')
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

        $libprov_model = new libprov_model();
        $ProvDetails = $libprov_model->getProvDetails($id);

        if ($ProvDetails){
            $form_message = $form_message;
            $data = array(
                'prov_code'                 =>      $ProvDetails->prov_code,
                'prov_name'        =>      $ProvDetails->prov_name,
                'region_code'      =>      $ProvDetails->region_code,
                'income_class'      =>      $ProvDetails->income_class,
                'created_by'      =>      $ProvDetails->created_by,
                'date_created'      =>      $ProvDetails->date_created,
                'modified_by'      =>      $ProvDetails->modified_by,
                'date_modified'      =>      $ProvDetails->date_modified,

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
        $this->load->view('lib_provview',$data);
        $this->load->view('footer');
    }

    public function editProv($id = "")
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
            $libprov_model = new libprov_model();
            $regionCode = $libprov_model->get_region();
            //  $application_type_name = $libregion_model->Lib_getAllApplicationtype();
            //   $lgu_type_name = $libregion_model->Lib_getLGUtype();

            $this->validateEditForm();

            if (!$this->form_validation->run()){
                $form_message = '';
                $this->load->view('header');
                $this->load->view('nav');
                $this->load->view('sidebar');


                $rpmb['region'] = $regionCode;
                $rpmb['prov_details'] = $this->libprov_model->getProvDetails($id);
                $this->load->view('lib_provedit', $rpmb);
                $this->load->view('footer');

            } else {

                $prov_name = $this->input->post('prov_name');
                $region_code = $this->input->post('region_code');
                $income_class = $this->input->post('income_class');
                $modified_by= $this->session->userdata('user_id');
                $date_modified = 'NOW()';

                $updateResult = $libprov_model->updateProv($id, $prov_name, $region_code, $income_class, $modified_by,$date_modified);
                if ($updateResult){
                    $this->load->view('header');
                    $this->load->view('nav');
                    $this->load->view('sidebar');

                    $rpmb['region'] = $this->libprov_model->get_region();
                    $this->load->view('lib_provlist', array(
                        'prov_data' => $libprov_model->listAllprov()));
                    $this->load->view('footer');
                }
            }
        } else {
            $this->load->view('no_id',array('redirectIndex'=>$this->redirectIndex()));
        }
    }

    public function delete_prov($id = 0)
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

        $libprov_model = new libprov_model();
        if ($id > 0){
            $deleteResult = $libprov_model->deleteProv($id);
            if ($deleteResult){
                $form_message = '<div class="kode-alert kode-alert kode-alert-icon kode-alert-click alert3"><i class="fa fa-lock"></i> Delete Succeeded! <a href="#" class="closed">&times;</a></div>';
                $this->load->view('header');
                $this->load->view('nav');
                $this->load->view('lib_provlist',array(
                    'prov_data'=>$libprov_model->listAllprov(),
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
                'field'   => 'prov_name',
                'label'   => 'Province Name',
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
                'field'   => 'prov_name',
                'rules'   => 'required'
            )

        );

        return $this->form_validation->set_rules($config);
    }

    public function redirectIndex($sec = 1)
    {
        $page = base_url('lib_provc/index');
        header("Refresh: $sec; url=$page");
    }

}