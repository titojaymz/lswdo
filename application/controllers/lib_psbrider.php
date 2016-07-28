<?php
/**
 * Created by PhpStorm.
 * User: ljesaclayan
 * Date: 7/22/2016
 * Time: 2:01 PM
 */
class lib_psbrider extends CI_Controller {

    public function psblist()
    {
        $psbriders = new lib_psbriders_model();
        $this->load->view('header');
        $this->load->view('nav');
        $this->load->view('sidebar');
        $this->load->view('lib_psbriders_list',array(
            'PSBMain'=>$psbriders->getPSBmain(),
            'PSBSub'=>$psbriders->getPSBmainSub(),
            'psbRidersC'=>$psbriders,
        ));
        $this->load->view('footer');
    }

    public function psbSubCategory($main)
    {
        $psbriders = new lib_psbriders_model();
        $this->load->view('lib_psbriders_subCat', array('psbSubCat' => $psbriders->getPSBsubByMain($main)));
    }

    public function psbadd()
    {
        $psbriders = new lib_psbriders_model();
        $this->validatePSBRidersIndicator();
        if (!$this->form_validation->run()) {

            $this->load->view('header');
            $this->load->view('nav');
            $this->load->view('sidebar');
            $this->load->view('lib_psbriders_add', array(
                'psbMain' => $psbriders->getPSBmain(),
            ));
            $this->load->view('footer');
        } else {
            $mainCat = $this->input->post('mainCat');
            $subCategory = $this->input->post('subCategory');

            $addResult = $psbriders->insertPSBRiders($mainCat,$subCategory);
            if($addResult){
                $this->redirectIndex();

            }
        }
    }
    public function psbedit($psbrider_sub_category_id)
    {
        $psbriders = new lib_psbriders_model();
        $this->validatePSBRidersIndicator();
        if (!$this->form_validation->run()) {
            $this->load->view('header');
            $this->load->view('nav');
            $this->load->view('sidebar');
            $this->load->view('lib_psbriders_edit', array(
                'psbSub' => $psbriders->getPSBmainSubEdit($psbrider_sub_category_id),
                'psbMain' => $psbriders->getPSBmain(),
                ));
            $this->load->view('footer');
        } else {
            $mainCat = $this->input->post('mainCat');
            $subCategory = $this->input->post('subCategory');

            $updateResult = $psbriders->updatePSBRiders($mainCat,$subCategory,$psbrider_sub_category_id);
            if($updateResult){
                $this->redirectIndex();

            }
        }
    }

    protected function validatePSBRidersIndicator()
    {
        $config = array(

            array(
                'field'   => 'subCategory',
                'label'   => 'subCategory',
                'rules'   => 'required'
            )
        );

        return $this->form_validation->set_rules($config);

    }
    public function redirectIndex()
    {
        $page = base_url('lib_psbrider/psblist/');
//        $sec = "1";
        header("Location: $page");
    }

}