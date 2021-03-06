<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Created by PhpStorm
 * User: mglveniegas
 *
 */
class budgetallocation extends CI_Controller {

    public function index($profID,$function)
    {

        if (!$this->session->userdata('user_id'))
        {
            redirect('/users/login','location');
        }

        if($function == 0){
            $form_message = '';
        } elseif($function == 1){
            $form_message = '<div class="kode-alert kode-alert kode-alert-icon kode-alert-click alert3"><i class="fa fa-lock"></i>Save Succeeded!<a href="#" class="closed">&times;</a></div>';
        } elseif($function == 2){
            $form_message = '<div class="kode-alert kode-alert kode-alert-icon kode-alert-click alert4"><i class="fa fa-lock"></i>Update Succeeded!<a href="#" class="closed">&times;</a></div>';
        }elseif($function == 3){
            $form_message = '<div class="kode-alert kode-alert kode-alert-icon kode-alert-click alert6"><i class="fa fa-lock"></i>Delete Succeeded!<a href="#" class="closed">&times;</a></div>';
        }

        $user_region = $this->session->userdata('uregion');
        $budgetallocation_model = new budgetallocation_model();
        $assessmentinfo_model = new assessmentinfo_model();
        $monitoring_model = new Monitoring_Model();
        $certification_model = new Certification_Model();
        $validity_model = new Validity_model();
        $visit_model = new Visit_model();
        $indi_model = new indicator_model();
        $profile_id = $this->input->post('profile_id'); //cma

        $this->load->view('header');
        $this->load->view('nav');
        $this->load->view('sidebar');
        $this->load->view('budgetallocation_list',array(
            'budgetallocation_data'=>$budgetallocation_model->getBudgetAllocation($profID),
            'form_message'=>$form_message,
            'profID'=>$profID,
        ));
        $this->load->view('footer');
    }


    public function addBudgetAllocation($id,$function)
    {

        if (!$this->session->userdata('user_id'))
        {
            redirect('/users/login','location');
        }

        if($function == 0){
            $form_message = '';
        } elseif($function == 1){
            $form_message = '<div class="kode-alert kode-alert kode-alert-icon kode-alert-click alert3"><i class="fa fa-lock"></i>Save Succeeded!<a href="#" class="closed">&times;</a></div>';
        } elseif($function == 2){
            $form_message = '<div class="kode-alert kode-alert kode-alert-icon kode-alert-click alert4"><i class="fa fa-lock"></i>Update Succeeded!<a href="#" class="closed">&times;</a></div>';
        }elseif($function == 3){
            $form_message = '<div class="kode-alert kode-alert kode-alert-icon kode-alert-click alert6"><i class="fa fa-lock"></i>Delete Succeeded!<a href="#" class="closed">&times;</a></div>';
        }

        $budgetallocation_model = new budgetallocation_model();
        $sectorDropDown = $budgetallocation_model->get_sector();
        $profile_id = $budgetallocation_model->getLSWDOprofile($id);

        $this->validateAddForm();

        if (!$this->form_validation->run()){

            $this->load->view('header');
            $this->load->view('nav');
            $this->load->view('sidebar');

            $rpmb['sector_id'] = $sectorDropDown;
            $rpmb['form_message'] = $form_message;
            $this->load->view('budgetallocation_add',$rpmb);
            $this->load->view('footer');

        } else {
            $budgetallocation_model = new budgetallocation_model();

          //$profile_id = $this->input->post('profile_id');//mglv
            $sector_id = $this->input->post('sector_id');
            $year_indicated = $this->input->post('year_indicated');
            $budget_previous_year = preg_replace('/[^0-9.]*/', '', $this->input->post('budget_previous_year'));
            $budget_present_year = preg_replace('/[^0-9.]*/', '', $this->input->post('budget_present_year'));
            $utilization = preg_replace('/[^0-9.]*/', '', $this->input->post('utilization'));
            $no_bene_served = $this->input->post('no_bene_served');
            $no_target_bene = $this->input->post('no_target_bene');
            $created_by = $this->session->userdata('user_id');
            $date_created = 'NOW()';

            $checkDupli = $budgetallocation_model->checkDuplicate($id, $sector_id);
            if($checkDupli->countProf == 0) {
                $addResult = $budgetallocation_model->insertBudgetAllocation($id, $sector_id, $year_indicated, $budget_previous_year, $budget_present_year, $utilization, $no_bene_served, $no_target_bene, $created_by, $date_created);
                if ($addResult) {
                    $form_message = 'Add Succeeded!';
                    $this->load->view('header');
                    $rpmb['form_message'] = $form_message;
                    $this->load->view('nav');
                    $this->load->view('sidebar');
                    $this->load->view('budgetallocation_add', array(
                        'sector_id' => $sector_id,
                        'budgetallocation_data' => $budgetallocation_model->getBudgetAllocation($id),
                        'profile_id' => $id,
                        'form_message' => $form_message,

                    ));
                    $this->load->view('footer');
                    $this->redirectIndex($id,1);
                }
            } else {
                $sectorName = $budgetallocation_model->sectorName($sector_id);
                $form_message = '<div class="kode-alert kode-alert kode-alert-icon kode-alert-click alert6"><i class="fa fa-lock"></i>'.$sectorName->sector_name.' already exist<a href="#" class="closed">&times;</a></div>';
                $rpmb['sector_id'] = $sectorDropDown;
                $rpmb['form_message'] = $form_message;
                $this->load->view('header');
                $this->load->view('nav');
                $this->load->view('sidebar');
                $this->load->view('budgetallocation_add', $rpmb);
                $this->load->view('footer');
            }
        }
    }

    public function editBudgetAllocation($id = 0,$prevSectorID)
    {
        if ($id > 0){
            $budgetallocation_model = new budgetallocation_model();
            $sector_id = $budgetallocation_model->get_sector();


            $this->validateEditForm();

            if (!$this->form_validation->run()){
                $form_message = '';
                $this->load->view('header');
                $this->load->view('nav');
                $this->load->view('sidebar');

              //  $this->init_rpmb_session();
                $rpmb['sector_id'] = $sector_id;
                $rpmb['form_message'] = $form_message;

                $rpmb['budgetallocation_details'] = $this->budgetallocation_model->getBudgetAllocationByID($id,$prevSectorID);
                $this->load->view('budgetallocation_edit', $rpmb);
                $this->load->view('sidepanel');
                $this->load->view('footer');

            } else {
//                $id = $this->input->post('profile_id');
                $sectorID = $this->input->post('sector_id');
                $year_indicated = $this->input->post('year_indicated');
                $budget_previous_year = preg_replace('/[^0-9.]*/', '', $this->input->post('budget_previous_year'));
                $budget_present_year = preg_replace('/[^0-9.]*/', '', $this->input->post('budget_present_year'));
                $utilization = preg_replace('/[^0-9.]*/', '', $this->input->post('utilization'));
                $no_bene_served = $this->input->post('no_bene_served');
                $no_target_bene = $this->input->post('no_target_bene');
                $modified_by= $this->session->userdata('user_id');
                $date_modified = 'NOW()';

                $checkDupli = $budgetallocation_model->checkDuplicate($id, $sectorID);
                if ($sectorID == $prevSectorID) {
                    $updateResult = $budgetallocation_model->updateBudgetAllocation($id, $sectorID, $year_indicated, $budget_previous_year, $budget_present_year, $utilization, $no_bene_served, $no_target_bene, $prevSectorID,$modified_by,$date_modified);
                    if ($updateResult) {

//                        $this->init_rpmb_session();
                        $rpmb['sector_id'] = $this->budgetallocation_model->get_sector();

                        $form_message = 'Update Success';
                        $this->load->view('header');
                        $this->load->view('nav');
                        $this->load->view('sidebar');
                        $this->load->view('budgetallocation_list', array(
                            'budgetallocation_data' => $budgetallocation_model->getBudgetAllocationByID($id,$prevSectorID),
                            'form_message' => $form_message,

                        ));
                        $this->load->view('footer');
                        $this->redirectIndex($id,2);
                    }
                } else {
                    if ($checkDupli->countProf == 0) {

                        $updateResult = $budgetallocation_model->updateBudgetAllocation($id, $sectorID, $year_indicated, $budget_previous_year, $budget_present_year, $utilization, $no_bene_served, $no_target_bene, $prevSectorID);
                        if ($updateResult) {

//                          $this->init_rpmb_session();
                            $rpmb['sector_id'] = $this->budgetallocation_model->get_sector();

                            $form_message = 'Update Success';
                            $this->load->view('header');
                            $this->load->view('nav');
                            $this->load->view('sidebar');
                            $this->load->view('budgetallocation_list', array(
                                'budgetallocation_data' => $budgetallocation_model->getBudgetAllocationByID($id),
                                'form_message' => $form_message,

                            ));
                            $this->load->view('footer');
                            $this->redirectIndex($id,2);
                        }

                    } else {
                        $sectorName = $budgetallocation_model->sectorName($sectorID);
                        $form_message = '<div class="kode-alert kode-alert kode-alert-icon kode-alert-click alert6"><i class="fa fa-lock"></i>' . $sectorName->sector_name . ' already exist<a href="#" class="closed">&times;</a></div>';

                        $rpmb['sector_id'] = $sector_id;
                        $rpmb['form_message'] = $form_message;
                        $rpmb['budgetallocation_details'] = $this->budgetallocation_model->getBudgetAllocationByID($id, $prevSectorID);
                        $this->load->view('header');
                        $this->load->view('nav');
                        $this->load->view('sidebar');
                        $this->load->view('budgetallocation_edit', $rpmb);
                        $this->load->view('footer');
                    }
                }
            }
        } else {
            $this->load->view('no_id',array('redirectIndex'=>$this->redirectIndex($id)));
        }

    }

    public function budgetallocation_masterview($id = 0,$prevSectorID)
    {

        $budgetallocation_model = new budgetallocation_model();

        $this->load->view('header');
        $this->load->view('nav');
        $this->load->view('sidebar');
        $BudgetDetails = $budgetallocation_model->getBudgetAllocationByID($id, $prevSectorID);
        $budgetData['BudgetDetails'] = $BudgetDetails;

        $this->load->view('budgetallocation_masterview',$budgetData);
        $this->load->view('footer');

    }

    public function delete_budgetallocation($id = 0)
    {
        $budgetallocation_model = new budgetallocation_model();
        if ($id > 0){
            $deleteResult = $budgetallocation_model->deleteBudgetAllocation($id);
            if ($deleteResult){
                $form_message = 'Delete Success!';
                $this->load->view('header');
                $this->load->view('nav');
                $this->load->view('budgetallocation_list',array(
                    'budgetallocation_data'=>$budgetallocation_model->getBudgetAllocation(),
                    'form_message'=>$form_message,
                    $this->redirectIndex($id)
                ));
                $this->load->view('footer');
            }
        }
    }

    protected function validateEditForm()
    {
        $config = array(

            array(
                'field'   => 'sector_id',
                'label'   => 'Sector',
                'rules'   => 'required'
            )
        );

        return $this->form_validation->set_rules($config);
    }

    protected function validateAddForm()
    {
        $config = array(

            array(
                'field'   => 'sector_id',
                'label'   => 'Sector',
                'rules'   => 'required'
            )
        );

        return $this->form_validation->set_rules($config);
    }

    public function redirectIndex($profID,$function)
    {
        $page = base_url('budgetallocation/index/'.$profID.'/'.$function.'');
//        $sec = "1";
        header("Location: $page");
    }


    public function refreshCurPage()
    {
        $page = current_url();
        $sec = "1";
        header("Refresh: $sec; url=$page");
    }

    public function redirectMasterPage($id,$sec = 1)
    {
        $page = base_url('budgetallocation/index/' . $id . '.html');
        header("Refresh: $sec; url=$page");
    }

}