<?php
/**
 * Created by PhpStorm.
 * User: mblejano
 * Date: 3/8/2016
 * Time: 4:30 PM
 */
class dashboardc extends CI_Controller {

    public function dashboard()
    {
        $regCode = $this->session->userdata('lswdo_regioncode');
        $dashboard_model = new dashboard_model();
        $indicator_model = new indicator_model();
        $provCode = 0;
        $lgu_PSWDO = 1;
        $lgu_CSWDO = 2;
        $lgu_MSWDO = 3;

        $getIndicator = $dashboard_model->getFunctionalityScore($regCode);
        $f = '';
        $ff = '';
        $pf = '';
        $region = '';

        foreach($getIndicator as $item):

            $f .= $item->Functional.',';
            $ff .= $item->FullyFunctional.',';
            $pf .= $item->PartiallyFunctional.',';
            $region .= "'".$item->region_name."',";

        endforeach;
        $region_format =  substr($region,0,-1);
        $ffscore_format =  substr($ff,0,-1);
        $fscore_format =  substr($f,0,-1);
        $pfscore_format =  substr($pf,0,-1);

        $this->validateAddForm();

        if (!$this->form_validation->run()) {


            $this->load->view('header');
            $this->load->view('nav');
            $this->load->view('sidebar');
            $this->load->view('dashboard', array(
                'region_format' => $region_format,
                'ffscore_format' => $ffscore_format,
                'fscore_format' => $fscore_format,
                'pfscore_format' => $pfscore_format,
                'lguType' => 0,

            ));
            $this->load->view('footer');
        } else {
            $lguType = $this->input->post('LGUtype');
            $getNoncompliance = $indicator_model->getScorePartarray1($regCode,$provCode,$lguType);
            $getCompliance = $indicator_model->getScorePartarray2($regCode,$provCode,$lguType);

            $unformat = "";
            $unformat2 = "";

            foreach($getNoncompliance as $key=>$value){
                $unformat .= '"'.$value['indicator_name'].'",';
                $unformat2 .= "".$value['TotalNonCompliance'].",";
            }
            $nonComplianceName = substr($unformat,0,-1);
            $nonCompliance = substr($unformat2,0,-1);



            $unformat3 = "";
            $unformat4 = "";

            foreach($getCompliance as $key=>$value){
                $unformat3 .= '"'.$value['indicator_name'].'",';
                $unformat4 .= "".$value['TotalCompliance'].",";
            }
            $complianceName = substr($unformat3,0,-1);
            $compliance = substr($unformat4,0,-1);

            $this->load->view('header');
            $this->load->view('nav');
            $this->load->view('sidebar');
            $this->load->view('dashboard', array(
                'region_format' => $region_format,
                'ffscore_format' => $ffscore_format,
                'fscore_format' => $fscore_format,
                'pfscore_format' => $pfscore_format,
                'lguType' => $lguType,
                'nonComplianceName' => $nonComplianceName,
                'nonCompliance' => $nonCompliance,
                'complianceName' => $complianceName,
                'compliance' => $compliance,

            ));
            $this->load->view('footer');
        }
    }
    protected function validateAddForm()
    {
        $config = array(

            array(
                'field'   => 'LGUtype',
                'label'   => 'LGUtype',
                'rules'   => 'required'
            )
        );

        return $this->form_validation->set_rules($config);
    }
}
