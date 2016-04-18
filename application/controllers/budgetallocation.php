<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Created by PhpStorm
 * User: mglveniegas
 *
 */
class budgetallocation extends CI_Controller {

    public function index()
    {

        if (!$this->session->userdata('user_id'))
        {
            redirect('/users/login','location');
        }

        $user_region = $this->session->userdata('uregion');
        $budgetallocation_model = new budgetallocation_model();
        $form_message = '';

        $this->load->view('header');
        $this->load->view('nav');
        $this->load->view('sidebar');
        $this->load->view('budgetallocation_list',array(
            'budgetallocation_data'=>$budgetallocation_model->getBudgetAllocation(),
            'list_fields'=>$this->listFields(),
            'form_message'=>$form_message
        ));
        $this->load->view('footer');
    }

    public function addBudgetAllocation($id=0)
    {

        if (!$this->session->userdata('user_id'))
        {
            redirect('/users/login','location');
        }

        $budgetallocation_model = new budgetallocation_model();
        $sector_id = $budgetallocation_model->get_sector();
        $profile_id = $budgetallocation_model->getLSWDOprofile($id);

        $this->validateAddForm();

        if (!$this->form_validation->run()){
            $form_message = '';
            $this->load->view('header');
            $this->load->view('nav');
            $this->load->view('sidebar');

            $rpmb['sector_id'] = $sector_id;

            $this->load->view('budgetallocation_add',$rpmb);
            $this->load->view('footer');

        } else {
            $budgetallocation_model = new budgetallocation_model();

          //  $profile_id = $this->input->post('profile_id');//mglv
            $sector_id = $this->input->post('sector_id');
            $year_indicated = $this->input->post('year_indicated');
            $budget_present_year = $this->input->post('budget_present_year');
            $utilization = $this->input->post('utilization');
            $no_bene_served = $this->input->post('no_bene_served');
            $no_target_bene = $this->input->post('no_target_bene');

            $addResult = $budgetallocation_model->insertBudgetAllocation($profile_id,$sector_id,$year_indicated,$budget_present_year,$utilization,$no_bene_served,$no_target_bene);

            if ($addResult){
                $form_message = 'Add Success!';
                $this->load->view('header');
                $this->load->view('nav');
                $this->load->view('budgetallocation_add',array(
                    'sector_id' => $sector_id,
                    'budgetallocation_data'=>$budgetallocation_model->getBudgetAllocation(),
                    //'getSecondCategory' => $budgetallocation_model->getSecondCategoriesFromFI($lguTypes->lgu_type_id),
                    'profile_id' => $profile_id,
                    'list_fields'=>$this->listFields(),
                    'form_message'=>$form_message,

                ));
                $this->load->view('footer');
                $this->redirectIndex();
            }
        }
    }

    public function editBudgetAllocation($id = 0)
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

            //    $this->init_rpmb_session();
                $rpmb['sector_id'] = $sector_id;
                $rpmb['form_message'] = $form_message;

                $rpmb['budgetallocation_details'] = $this->budgetallocation_model->getBudgetAllocationByID($id);
                $this->load->view('budgetallocation_edit', $rpmb);
                $this->load->view('sidepanel');
                $this->load->view('footer');

            } else {
                $id = $this->input->post('profile_id');
                $sector_id = $this->input->post('sector_id');
                $year_indicated = $this->input->post('year_indicated');
                $budget_present_year = $this->input->post('budget_present_year');
                $utilization = $this->input->post('utilization');
                $no_bene_served = $this->input->post('no_bene_served');
                $no_target_bene = $this->input->post('no_target_bene');

                $updateResult = $budgetallocation_model->updateBudgetAllocation($id,$sector_id,$year_indicated,$budget_present_year,$utilization,$no_bene_served,$no_target_bene);
                if ($updateResult){

                    $this->init_rpmb_session();
                    $rpmb['sector_id'] = $this->budgetallocation_model->get_sector();

                    $form_message = 'Update Success';
                    $this->load->view('header');
                    $this->load->view('nav');
                    $this->load->view('sidebar');
                    $this->load->view('budgetallocation_list',array(
                        'budgetallocation_data'=>$budgetallocation_model->getBudgetAllocationByID(),
                        'list_fields'=>$this->listFields(),
                        'form_message'=>$form_message,
                        $this->redirectIndex()
                    ));
                    $this->load->view('footer');
                }
            }
        } else {
            $this->load->view('no_id',array('redirectIndex'=>$this->redirectIndex()));
        }

    }

    public function budgetallocation_masterview($id = 0,$form_message = '')
    {
        $budgetallocation_model = new budgetallocation_model();
        $this->load->view('header');
        $this->load->view('nav');
        $this->load->view('sidebar');
        $BudgetDetails = $budgetallocation_model->getBudgetAllocationByID($id);
        if ($BudgetDetails){
            $form_message = $form_message;
            $data = array(
                'profile_id'                 =>      $BudgetDetails->profile_id,
                'sector_id'                 =>      $BudgetDetails->sector_id,
                'year_indicated'      =>      $BudgetDetails->year_indicated,
                'budget_present_year'      =>      $BudgetDetails->budget_present_year,
                'utilization'      =>      $BudgetDetails->utilization,
                'no_bene_served'      =>      $BudgetDetails->no_bene_served,
                'no_target_bene'      =>      $BudgetDetails->no_target_bene

            );
        } else {
            $form_message = 'No records found!';
            $data = array(
                'form_message'      =>      $form_message
            );
        }
        $this->load->view('budgetallocation_masterview',$data);
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
                    'list_fields'=>$this->listFields(),
                    'form_message'=>$form_message,
                    $this->redirectIndex()
                ));
                $this->load->view('footer');
            }
        }
    }

    protected function validateEditForm()
    {
        $config = array(
            array(
                'field'   => 'profile_id',
                'label'   => 'profile_id',
                'rules'   => 'required'
            ),
            array(
                'field'   => 'sector_id',
                'label'   => 'sector_id',
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
                'label'   => 'sector_id',
                'rules'   => 'required'
            ),
            array(
                'field'   => 'year_indicated',
                'label'   => 'year_indicated',
                'rules'   => 'required'
            )
        );

        return $this->form_validation->set_rules($config);
    }

    public function listFields()
    {
        $query = $this->db->query('SELECT profile_id,sector_id,year_indicated,budget_present_year,utilization,no_bene_served,no_target_bene FROM tbl_lswdo_budget');
        return $query->list_fields();
    }

    public function redirectIndex()
    {
        $page = base_url();
        $sec = "1";
        header("Refresh: $sec; url=$page");
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