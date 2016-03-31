<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class monitoring extends CI_Controller
{
    public function index()
    {
        $form_message = "";
    }

    public function monitoring_list()
    {
        $monitoring_model = new Monitoring_Model();
        $certification_model = new Certification_Model();
        $validity_model = new Validity_model();
        $visit_model = new Visit_model();
        $indi_model = new indicator_model();

        $this->load->view('header');
        $this->load->view('nav');
        $this->load->view('sidebar');
        $this->load->view('monitoring_list', array(
            'getDataByProfileID' => $monitoring_model->getDataByProfileID(),
            'getVisitCount'=>$visit_model->getVisitCount(),
            'getValidity' => $validity_model->getValidity(),
            'monitoring_model' => $monitoring_model,
            'certification_model' => $certification_model,
            'visit_model' => $visit_model,
            'validity_model' => $validity_model,
        ));
        $this->load->view('footer');
    }


    public function monitoring_add()
    {


        if (!$this->session->userdata('user_id')) {
            redirect('/users/login', 'location');
        }

        $validity_model = new Validity_model();
        $visit_model = new Visit_model();
        $monitoring_model = new Monitoring_Model();

        $this->validateAddMonitoring();

        if ($this->form_validation->run() == FALSE) {
            //if ($this->input->post('insert') <> "") {
            $form_message = '';
            $this->load->view('header');
            $this->load->view('nav');
            $this->load->view('sidebar');
            $this->load->view('monitoring_add', array(
                'getDataByProfileID' => $monitoring_model->getDataByProfileID(),
                'getVisitCount' => $visit_model->getVisitCount(),
                'getValidity' => $validity_model->getValidity(),
                'monitoring_model' => $monitoring_model,
                'visit_model' => $visit_model,
                'validity_model' => $validity_model,
            ));
            $this->load->view('footer');
        } else {
            //$certfication_model = new Certification_Model();
            /*$validity_model = new Validity_model();
            $visit_model = new Visit_model();
            $monitoring_model = new Monitoring_Model();*/

            //$profile_id ='9';
            $profile_id =$this->input->post('profile_id');
            $ref_cert_id = '0';
            $visit_count = $this->input->post('visit_count');

            //date
            $strVisitDate = $this->input->post('visit_date');
            $visitDateToDate = date_create($strVisitDate);
            $visit_date = date_format($visitDateToDate, "Y-m-d");
            //date

            $remarks = $this->input->post('remarks');
            $created_by = '115';
            $date_created = 'NOW()';
            $modified_by='115';
            $date_modified = '0000-00-00';
            $deleted='0';

            $addResult = $monitoring_model->insertLswdoMonitoring($profile_id,$ref_cert_id, $visit_count, $visit_date, $remarks, $created_by, $date_created, $modified_by, $date_modified, $deleted);

            if ($addResult) {
                $indicator_model = new indicator_model();
                /*$form_message = 'Add Success!';
                $this->load->view('header');
                $this->load->view('nav');
                $this->load->view('sidebar');
                $this->load->view('monitoring_list', array(
                    'getDataByProfileID' => $monitoring_model->getDataByProfileID(),
                    'getVisitCount' => $visit_model->getVisitCount(),
                    'getValidity' => $validity_model->getValidity(),
                    'monitoring_model' => $monitoring_model,
                    'visit_model' => $visit_model,
                    'validity_model' => $validity_model,
                ));
                $this->load->view('footer');*/

                $form_message = '';
                $this->load->view('header');
                $this->load->view('nav');
                $this->load->view('sidebar');
                $this->load->view('indicator_add', array(
                    'firstMotherIndicator' => $indicator_model->getFirstMotherIndicator(),
                    'firstIndicators' => $indicator_model->getFirstIndicators(),
                    //'getFirstCategory' => $indicator_model->getCategoriesFromFI($lguTypes->lgu_type_id),
                    //'getSecondCategory' => $indicator_model->getSecondCategoriesFromFI($lguTypes->lgu_type_id),
                    //'LGUType' => $indicator_model->getLGUtype($profID),
                    //'profileID' => $profID,
                ));
                $this->load->view('footer');

                $this->redirectIndex($profile_id,$addResult);
            }
        }
    }

    public function redirectIndex($profID,$addResult)
    {
        $page = base_url('indicator/indicatorView/'.$profID.'/'.$addResult);
//        $sec = "1";
        header("Location: $page");
    }


    public function monitoring_edit()
    {

        $monitoring_model = new Monitoring_model();
        $certification_model = new Certification_Model();
        $validity_model = new Validity_model();
        $visit_model = new Visit_model();

        $this->validateAddMonitoring();
        if (!$this->form_validation->run()) {

            $this->load->view('header');
            $this->load->view('nav');
            $this->load->view('sidebar');
            $this->load->view('monitoring_edit',array(
                'monitoring_model'=>$monitoring_model,
                'certification_model'=>$certification_model,
                'validity_model' => $validity_model,
                'visit_model' => $visit_model,
            ));
            $this->load->view('footer');
        }else {

            $profile_id = 9;
            $visit_count = $this->input->post('visit_count');

            //date
            $strVisitDate = $this->input->post('visit_date');
            $visitDateToDate = date_create($strVisitDate);
            $visit_date = date_format($visitDateToDate, "Y-m-d");
            //date

            $remarks = $this->input->post('remarks');
            $modified_by = 104;
            $date_modified = 'NOW()';
            $deleted = '0';

            //$certification_model
            $ref_id = $this->input->post('ref_cert_id');
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


            $updateResult = $monitoring_model->updateLswdoMonitoring($ref_id,$profile_id, $visit_count, $visit_date,$remarks,$modified_by,$deleted);

            if ($updateResult) {


                $monitoring_model = new Monitoring_Model();
                $certification_model = new Certification_Model();
                $visit_model = new Visit_model();
                $validity_model = new Validity_model();

                $this->load->view('header');
                $this->load->view('nav');
                $this->load->view('sidebar');
                $this->load->view('monitoring_edit', array(
                    'getDataByProfileID' => $monitoring_model->getDataByProfileID(),
                    'getVisitCount'=>$visit_model->getVisitCount(),
                    'getValidity' => $validity_model->getValidity(),
                    'monitoring_model' => $monitoring_model,
                    'certification_model' => $certification_model,
                    'validity_model' => $validity_model,
                    'visit_model' => $visit_model,
                ));
                $this->load->view('footer');


            }

        }
    }


    protected function validateAddMonitoring()
    {
        $config = array(

            array(
                'field'   => 'visit_count',
                'rules'   => 'required|integer',

            )
        );

        return $this->form_validation->set_rules($config);
    }




}