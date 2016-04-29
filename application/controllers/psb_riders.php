<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class psb_riders extends CI_Controller
{
    public function index()
    {
        $form_message = "";
    }

    public function psb_rider_add($ref_id,$profile_id)
    {
        $PSBRider_Model = new PSBRider_Model();

        /*  if (!$this->session->userdata('user_id')) {
              redirect('/users/login', 'location');
          }*/

        $this->validateAddPSBRiderQs();

       /* $this->load->view('header');
        $this->load->view('nav');
        $this->load->view('sidebar');
        $this->load->view('psb_rider_add', array(
            'PSBRider_Model' => $PSBRider_Model,
        ));
        $this->load->view('footer');*/

         if ($this->form_validation->run() == FALSE) {
             $this->load->view('header');
             $this->load->view('nav');
             $this->load->view('sidebar');
             $this->load->view('psb_rider_add', array(
                 'PSBRider_Model' => $PSBRider_Model,
             ));
             $this->load->view('footer');
         }


        else
        {
            //carla

            $getPSBMainCategory = $PSBRider_Model->getPSBMainCategory();

            foreach($getPSBMainCategory as $key => $val)
            {
                $psbrider_main_category_id = $val['psbrider_main_category_id'];
                $psbrider_main_category_title = $val['psbrider_main_category_title'];

                $getPSBSubCategory = $PSBRider_Model->getPSBSubCategory($psbrider_main_category_id);

                foreach($getPSBSubCategory as $keySub => $valSub) {

                    $psbrider_sub_category_id = $valSub['psbrider_sub_category_id'];
                    $psbrider_sub_category_title = $valSub['psbrider_sub_category_title'];

                    $profile_id_val = $this->input->post('profile_id');
                    $ref_id_val = $this->input->post('ref_id');
                    $psbrider_main_category_id_val = $psbrider_main_category_id;
                    $psbrider_main_category_title_val = $psbrider_main_category_title;
                    $psbrider_sub_category_id_val = $psbrider_sub_category_id;
                    $psbrider_sub_category_title_val = $psbrider_sub_category_title;
                    $arrOfAns = $this->input->post('arrOfAns-' . $psbrider_sub_category_id);
                    $txtareaReason = $this->input->post('textAreaReason-' . $psbrider_sub_category_id);

                    $addResult = $PSBRider_Model->insertPSBRiderQsAns($ref_id_val,
                        $profile_id_val,
                        $psbrider_main_category_id_val,
                        $psbrider_main_category_title_val,
                        $psbrider_sub_category_id_val,
                        $psbrider_sub_category_title_val,
                        $txtareaReason,
                        $arrOfAns);
                }

            }

            if($addResult)
            {
                //$form_message = 'Add Success!';
                $this->load->view('header');
                $this->load->view('nav');
                $this->load->view('sidebar');
                $this->load->view('psb_rider_add', array(
                    'PSBRider_Model' => $PSBRider_Model,
                ));
                $this->load->view('alert_success');
                $this->load->view('footer');

                $this->redirectIndex($profile_id, $ref_id);
            }
        }
    }


    public function redirectIndex($profID,$addResult)
    {
        $page = base_url('indicator/indicatorViewAll/'.$profID.'/'.$addResult);
//        $sec = "1";
        header("Location: $page");
    }


    public function monitoring_edit()
    {

        $monitoring_model = new Monitoring_model();
        $certification_model = new Certification_Model();
        $validity_model = new Validity_model();
        $visit_model = new Visit_model();

        $this->validateAddPSBRiderQs();
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


    protected function validateAddPSBRiderQs()
    {
        $config = array(

            array(
                'field'   => 'arrOfAns-1',
                'rules'   => 'required|integer',

            )
        );

        return $this->form_validation->set_rules($config);
    }




}