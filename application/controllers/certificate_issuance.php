<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class certificate_issuance extends CI_Controller
{
    public function index()
    {
        $form_message = "";
    }

    public function certificate_issuance_list()
    {
        $profile_id = $this->input->post('profile_id'); //cma

        $monitoring_model = new Monitoring_Model();
        $certification_model = new Certification_Model();
        $validity_model = new Validity_model();
        $visit_model = new Visit_model();

        $this->load->view('header');
        $this->load->view('nav');
        $this->load->view('sidebar');
        $this->load->view('certificate_issuance_list', array(
            //'getDataByProfileID' => $monitoring_model->getDataByProfileID($profile_id),
            'getVisitCount'=>$visit_model->getVisitCount(),
            'getValidity' => $validity_model->getValidity(),
            'monitoring_model'=>$monitoring_model,
            'certification_model'=>$certification_model,
            'visit_model' => $visit_model,
            'validity_model' => $validity_model,
        ));
        $this->load->view('footer');
    }


    public function certificate_issuance_add()
    {
        if (!$this->session->userdata('user_id')) {
            redirect('/users/login', 'location');
        }
        $monitoring_model = new Monitoring_Model();
        $validity_model = new Validity_model();
        //$this->validateAddMonitoring();
        $this->validateAddCertficate();

        if ($this->form_validation->run() == FALSE) {
            //if ($this->input->post('insert') <> "") {
            $form_message = '';
            $this->load->view('header');
            $this->load->view('nav');
            $this->load->view('sidebar');
            $this->load->view('certificate_issuance_add', array(
                //'getDataByProfileID' => $monitoring_model->getDataByProfileID(),
               /* 'getVisitCount' => $monitoring_model->getVisitCount(),*/
                'getValidity' => $validity_model->getValidity(),
            ));
            $this->load->view('footer');


        } else {
            $certfication_model = new Certification_Model();
            $validity_model = new Validity_model();
            $visit_model = new Visit_model();

            $profile_id = $this->input->post('profile_id');
            $visit_count = $this->input->post('visit_count');
            //date
            $strVisitDate = $this->input->post('visit_date');
            $visitDateToDate = date_create($strVisitDate);
            $visit_date = date_format($visitDateToDate, "Y-m-d");
            //date
            $remarks = $this->input->post('remarks');
            $created_by =$this->session->userdata('user_id');
            $date_created = 'NOW()';
            $modified_by = $this->session->userdata('user_id');
            $date_modified = '0000-00-00';
            $deleted = '0';

            //$addResult = $monitoring_model->insertLswdoMonitoring($profile_id, $visit_count, $visit_date, $remarks, $created_by, $date_created, $modified_by, $date_modified, $deleted);

            $certificate_no = $this->input->post('txtCertNo');
            $current_certificate = '0';

            //date
            $strIssuedDate = $this->input->post('date_issued');
            $issuedDateToDate = date_create($strIssuedDate);
            $date_issued = date_format($issuedDateToDate, "Y-m-d");
            //date

            $validity = $this->input->post('validity');
            $month_valid = $this->input->post('month_valid');
            $day_valid = $this->input->post('day_valid');
            $year_valid = $this->input->post('year_valid');
            $DELETED = '0';

             $addCert = $certfication_model->insertLswdoCertificate($profile_id,
                   $certificate_no,
                   $current_certificate,
                   $date_issued,
                   $validity,
                   $month_valid,
                   $day_valid,
                   $year_valid,
                   $created_by,
                   $date_created,
                   $modified_by,
                   $date_modified,
                   $DELETED);

            if ($addCert) {
               /* $form_message = 'Add Success!';
                $this->load->view('header');
                $this->load->view('nav');
                $this->load->view('sidebar');
                $this->load->view('certificate_issuance_list', array(
                    'getDataByProfileID' => $monitoring_model->getDataByProfileID(),
                    'getVisitCount' => $visit_model->getVisitCount(),
                    'getValidity' => $validity_model->getValidity(),
                    'certification_model' => $certfication_model,
                    //'getFirstCategory' => $indicator_model->getCategoriesFromFI(),
                    //'getSecondCategory' => $indicator_model->getSecondCategoriesFromFI(),
                ));
                $this->load->view('footer');*/
/*
                $monitoring_model = new Monitoring_Model();
                $certification_model = new Certification_Model();
                $validity_model = new Validity_model();
                $visit_model = new Visit_model();
                $indi_model = new indicator_model();

                $this->load->view('header');
                $this->load->view('nav');
                $this->load->view('sidebar');
                $this->load->view('monitoring_list', array(
                    //'getDataByProfileID' => $monitoring_model->getDataByProfileID(),
                    'getVisitCount'=>$visit_model->getVisitCount(),
                    'getValidity' => $validity_model->getValidity(),
                    'monitoring_model' => $monitoring_model,
                    'certification_model' => $certification_model,
                    'visit_model' => $visit_model,
                    'validity_model' => $validity_model,
                ));
                $this->load->view('footer');*/


                $monitoring_model = new Monitoring_Model();
                $certification_model = new Certification_Model();
                $validity_model = new Validity_model();
                $visit_model = new Visit_model();
                $indi_model = new indicator_model();
                //$profile_id = $this->input->post('profile_id'); //cma

                $this->load->view('header');
                $this->load->view('nav');
                $this->load->view('sidebar');
                $this->load->view('monitoring_list', array(
                    //'getDataByProfileID' => $monitoring_model->getDataByProfileID($profile_id),
                    /*'getVisitCount'=>$visit_model->getVisitCount(),
                    'getValidity' => $validity_model->getValidity(),*/
                    'monitoring_model' => $monitoring_model,
                    'certification_model' => $certification_model,
                    'visit_model' => $visit_model,
                    'validity_model' => $validity_model,
                ));
                $this->load->view('footer');

                $this->redirectIndex($profile_id);

            }
        }
    }

    public function redirectIndex($profile_id)
    {
        $page = base_url('monitoring/monitoring_list/'.$profile_id);
//        $sec = "1";
        header("Location: $page");
    }

    public function certificate_issuance_edit($ref_id)
    {
        $monitoring_model = new Monitoring_model();
        $certification_model = new Certification_Model();
        $visit_model = new Visit_Model();
        $validity_model = new Validity_Model();

        $this->validateAddCertficate();


        if (!$this->form_validation->run()) {

            $this->load->view('header');
            $this->load->view('nav');
            $this->load->view('sidebar');
            $this->load->view('certificate_issuance_edit',array(
                'monitoring_model'=>$monitoring_model,
                'certification_model'=>$certification_model,
                'visit_model' => $visit_model,
                'validity_model' => $validity_model,
                'getValidity' => $validity_model->getValidity(),
                'certListByID' => $certification_model->getCertListByID($ref_id),
            ));
            $this->load->view('footer');
        }else {

            //$profile_id = 9;

            //$ref_id = $this->input->post('ref_cert_id');

            $certificate_no = $this->input->post('certificate_no');
            $current_certificate = '0';
            //date
            $strIssuedDate = $this->input->post('date_issued');
            $issuedDateToDate = date_create($strIssuedDate);
            $date_issued = date_format($issuedDateToDate, "Y-m-d");
            //date

            $validity = $this->input->post('validity');
            $month_valid = $this->input->post('month_valid');
            $day_valid = $this->input->post('day_valid');
            $year_valid = $this->input->post('year_valid');
            $DELETED = '0';
            $modified_by = 104;
            $profile_id = '9';

            $updateResult = $certification_model->updateLswdoCertificate($ref_id,$profile_id,$certificate_no,
                $current_certificate,
                $date_issued,
                $validity,
                $month_valid,
                $day_valid,
                $year_valid,
                $modified_by,
                $DELETED);


            if ($updateResult) {

                $monitoring_model = new Monitoring_Model();
                $certification_model = new Certification_Model();
                $validity_model = new Validity_model();
                $visit_model = new Visit_model();

                $this->load->view('header');
                $this->load->view('nav');
                $this->load->view('sidebar');
                $this->load->view('certificate_issuance_list', array(
                    //'getDataByProfileID' => $monitoring_model->getDataByProfileID(),
                    'getVisitCount'=>$visit_model->getVisitCount(),
                    'getValidity' => $validity_model->getValidity(),
                    'monitoring_model'=>$monitoring_model,
                    'certification_model'=>$certification_model,
                    'visit_model' => $visit_model,
                    'validity_model' => $validity_model,
                    //'updateResult' => $updateResult,
                ));
                $this->load->view('footer');


            }

        }
    }


    protected function validateAddCertficate()
    {
        $config = array(

            array(
                'field'   => 'date_issued',
                'rules'   => 'required'
            )
        );

        return $this->form_validation->set_rules($config);
    }




}