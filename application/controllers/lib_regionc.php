<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Created by PhpStorm.
 * User: mglveniegas
 * Date: 5/20/2016
 * Time: 4:07 PM
 */

class lib_regionc extends CI_Controller {

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

        $libregion_model = new libregion_model();
        $form_message = '';

        $this->load->view('header');
        $this->load->view('nav');
        $this->load->view('sidebar');
        $this->load->view('lib_regionlist',array(
            'region_data'=>$libregion_model->listAllregion(),
            'form_message'=>$form_message
        ));
        $this->load->view('footer');

    }

    public function addregion()
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

        $libregion_model = new libregion_model();
        $this->validateAddForm();

        if (!$this->form_validation->run()){
            $form_message = '';
            $this->load->view('header');
            $this->load->view('nav');
            $this->load->view('sidebar');
            $this->load->view('lib_regionadd',array('form_message'=>$form_message));
            $this->load->view('footer');
        } else {
            $region_code = $this->input->post('region_code');
            $region_name = $this->input->post('region_name');
            $region_nick = $this->input->post('region_nick');
            $created_by = $this->session->userdata('user_id');
            $date_created = 'NOW()';

            $libregion_model = new libregion_model();
            $addResult = $libregion_model->addRegion($region_code,$region_name,$region_nick,$created_by,$date_created);
            if ($addResult){
                $form_message = 'Add Succeeded!';
                $this->load->view('header');
                $this->load->view('nav');
                $this->load->view('sidebar');
                $this->load->view('lib_regionlist',array(
                    'region_data'=>$libregion_model->listAllregion(),
                    'form_message'=>$form_message,

                ));
                $this->load->view('footer');
                $this->redirectIndex();

            }
        }
    }

    public function lib_regionview($id = 0,$form_message = '')
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

        $libregion_model = new libregion_model();
        $RegionDetails = $libregion_model->getRegionDetails($id);

        if ($RegionDetails){
            $form_message = $form_message;
            $data = array(
                'region_code'                 =>      $RegionDetails->region_code,
                'region_name'        =>      $RegionDetails->region_name,
                'region_nick'      =>      $RegionDetails->region_nick,
                'created_by'      =>      $RegionDetails->created_by,
                'date_created'      =>      $RegionDetails->date_created,
                'modified_by'      =>      $RegionDetails->modified_by,
                'date_modified'      =>      $RegionDetails->date_modified,

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
        $this->load->view('lib_regionview',$data);
        $this->load->view('footer');
    }

    public function editRegion($id = "")
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
            $libregion_model = new libregion_model();

          //  $application_type_name = $libregion_model->Lib_getAllApplicationtype();
         //   $lgu_type_name = $libregion_model->Lib_getLGUtype();

            $this->validateEditForm();

            if (!$this->form_validation->run()){
                $form_message = '';
                $this->load->view('header');
                $this->load->view('nav');
                $this->load->view('sidebar');
                $this->load->view('lib_regionedit',array(
                    'region_details'=>$libregion_model->getRegionDetails($id)));
                $this->load->view('footer');
            } else {

                $region_name = $this->input->post('region_name');
                $region_nick = $this->input->post('region_nick');
                $modified_by= $this->session->userdata('user_id');
                $date_modified = 'NOW()';

                $updateResult = $libregion_model->updateRegion($id, $region_name, $region_nick,$modified_by,$date_modified);
                if ($updateResult){
                    $this->load->view('header');
                    $this->load->view('nav');
                    $this->load->view('sidebar');
                    $this->load->view('lib_regionlist', array(
                        'region_data' => $libregion_model->listAllregion()));
                    $this->load->view('footer');
                }
            }
        } else {
            $this->load->view('no_id',array('redirectIndex'=>$this->redirectIndex()));
        }
    }

    public function delete_region($id = 0)
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

        $libregion_model = new libregion_model();
        if ($id > 0){
            $deleteResult = $libregion_model->deleteRegion($id);
            if ($deleteResult){
                $form_message = '<div class="kode-alert kode-alert kode-alert-icon kode-alert-click alert3"><i class="fa fa-lock"></i> Delete Succeeded! <a href="#" class="closed">&times;</a></div>';
                $this->load->view('header');
                $this->load->view('nav');
                $this->load->view('lib_regionlist',array(
                    'region_data'=>$libregion_model->listAllregion(),
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
                'field'   => 'region_name',
                'label'   => 'Region Name',
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
                'field'   => 'region_name',
                'rules'   => 'required'
            )

        );

        return $this->form_validation->set_rules($config);
    }

    public function redirectIndex($sec = 1)
    {
        $page = base_url('lib_regionc/index');
        header("Refresh: $sec; url=$page");
    }

}