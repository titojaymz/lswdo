<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class monitoring extends CI_Controller
{


    public function monitoring_list()
    {
        //require_once "Monitoring_Model.php";
        //if (!$this->session->userdata('user_id'))
        //{
        //    redirect('/users/login','location');
        //}
        $monitoring_model = new Monitoring_Model();
        $certification_model = new Certification_Model();
        //monitoring_model = new monitoring_model();

        $this->load->view('header');
        $this->load->view('nav');
        $this->load->view('sidebar');
        $this->load->view('monitoring_list', array(
            'getDataByProfileID' => $monitoring_model->getDataByProfileID(),
            'getVisitCount'=>$monitoring_model->getVisitCount(),
            'getValidity' => $monitoring_model->getValidity(),
            'monitoring_model' => $monitoring_model,
            'certification_model' => $certification_model,
        ));
        $this->load->view('footer');
    }


    public function monitoring_add()
    {
        if (!$this->session->userdata('user_id')) {
            redirect('/users/login', 'location');
        }
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
                'getVisitCount' => $monitoring_model->getVisitCount(),
                'getValidity' => $monitoring_model->getValidity(),
                //'getFirstCategory' => $indicator_model->getCategoriesFromFI(),
                //'getSecondCategory' => $indicator_model->getSecondCategoriesFromFI(),
            ));
            $this->load->view('footer');
        } else {
            $certfication_model = new Certification_Model();

            $profile_id = 9;
            $visit_count = $this->input->post('visit_count');
            //date
            $strVisitDate = $this->input->post('visit_date');
            $visitDateToDate = date_create($strVisitDate);
            $visit_date = date_format($visitDateToDate, "Y-m-d");
            //date
            $remarks = $this->input->post('remarks');
            $created_by =104;
            $date_created = 'NOW()';
            $modified_by = 104;
            $date_modified = '0000-00-00';
            $deleted = '0';

            $addResult = $monitoring_model->insertLswdoMonitoring($profile_id, $visit_count, $visit_date, $remarks, $created_by, $date_created, $modified_by, $date_modified, $deleted);

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

            if ($addResult && $addCert) {
                $form_message = 'Add Success!';
                $this->load->view('header');
                $this->load->view('nav');
                $this->load->view('sidebar');
                $this->load->view('monitoring_add', array(
                    'getDataByProfileID' => $monitoring_model->getDataByProfileID(),
                    'getVisitCount' => $monitoring_model->getVisitCount(),
                    'getValidity' => $monitoring_model->getValidity(),
                    //'getFirstCategory' => $indicator_model->getCategoriesFromFI(),
                    //'getSecondCategory' => $indicator_model->getSecondCategoriesFromFI(),
                ));
                $this->load->view('footer');


            }
        }
    }

    public function monitoring_edit()
    {

        $monitoring_model = new Monitoring_model();
        $certification_model = new Certification_Model();
        $this->validateAddMonitoring();
        if (!$this->form_validation->run()) {

            $this->load->view('header');
            $this->load->view('nav');
            $this->load->view('sidebar');
            $this->load->view('monitoring_edit',array(
                'monitoring_model'=>$monitoring_model,
                'certification_model'=>$certification_model,
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

           // $updateResult = $monitoring_model->updateLswdoMonitoring($ref_id,$profile_id, $visit_count, $visit_date,$remarks,$modified_by,$date_modified,$deleted);
            $updateResult = $certification_model->updateLswdoCertificate($ref_id,
                $certificate_no,
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
                //monitoring_model = new monitoring_model();

                $this->load->view('header');
                $this->load->view('nav');
                $this->load->view('sidebar');
                $this->load->view('monitoring_edit', array(
                    'getDataByProfileID' => $monitoring_model->getDataByProfileID(),
                    'getVisitCount'=>$monitoring_model->getVisitCount(),
                    'getValidity' => $monitoring_model->getValidity(),
                    'monitoring_model' => $monitoring_model,
                    'certification_model' => $certification_model,
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
                'field'   => 'month_valid',
                'rules'   => 'required|integer'
            )
        );

        return $this->form_validation->set_rules($config);
    }




}