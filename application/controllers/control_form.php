<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class control_form extends CI_Controller {

	public function index()
	
	{
		$form_message = '';
		$this->load->helper('url');
	    $this->load->view('header');
		$this->load->view('nav');
		$this->load->view('sidebar');
        $this->init_rpmb_session();
        $rpmb['regionlist'] = $this->Model_form->get_regions();

        if(isset($_SESSION['province']) or isset($_SESSION['region'])) {
            $rpmb['provlist'] = $this->Model_form->get_provinces($_SESSION['region']);
        }
        if(isset($_SESSION['muni']) or isset($_SESSION['province'])) {
            $rpmb['munilist'] = $this->Model_form->get_muni($_SESSION['province']);
        }
        if(isset($_SESSION['brgy']) or isset($_SESSION['muni'])) {
            $rpmb['brgylist'] = $this->Model_form->get_brgy($_SESSION['muni']);
        }
        $this->load->view('view_form_all',$rpmb);
		$this->load->view('sidepanel');

		$this->load->view('footer');

    }

    public function populate_prov() {
        if($_POST['region_code'] > 0 and isset($_POST) and isset($_POST['region_code'])) {

            $region_code = $_POST['region_code'];
            $provlist = $this->Model_form->get_provinces($region_code);

            $province_list[] = "Choose Province";
            foreach($provlist as $tempprov) {
                $province_list[$tempprov->id_province] = $tempprov->prov_name;
            }

            $provlist_prop = 'id="provlist" name="provlist" class="form-control" onChange="get_muni();"';

            echo form_dropdown('provlist', $province_list, '', $provlist_prop);
        }
    }

    public function populate_muni() {
        if($_POST['prov_code'] > 0 and isset($_POST) and isset($_POST['prov_code'])) {
            $prov_code = $_POST['prov_code'];
            $munilist = $this->Model_form->get_muni($prov_code);

            $muni_list[] = "Choose Municipality";
            foreach($munilist as $tempmuni) {
                $muni_list[$tempmuni->id_municipality] = $tempmuni->city_name;
            }

            $munilist_prop = 'id="munilist" name="munilist" onchange="get_brgy();" class="form-control"';
            echo form_dropdown('munilist', $muni_list,'',$munilist_prop);
        }
    }

    public function populate_brgy() {
        if($_POST['city_code'] > 0 and isset($_POST) and isset($_POST['city_code'])) {
            $city_code = $_POST['city_code'];
            $brgylist = $this->Model_form->get_brgy($city_code);

            $brgy_list[] = "Choose Barangay";
            foreach($brgylist as $tempbrgy) {
                $brgy_list[$tempbrgy->id_barangay] = $tempbrgy->brgy_name;
            }

            $brgylist_prop = 'id="brgylist" name="brgylist" class="form-control"';
            echo form_dropdown('brgylist', $brgy_list,'',$brgylist_prop);
        }
    }
    public function init_rpmb_session() {
        if(isset($_POST['regionlist']) and $_POST['regionlist'] > 0) {
            $_SESSION['region'] = $_POST['regionlist'];
        }
        if(isset($_POST['provlist']) and $_POST['provlist'] > 0) {
            $_SESSION['province'] = $_POST['provlist'];
        }
        if(isset($_POST['munilist']) and $_POST['munilist'] > 0) {
            $_SESSION['muni'] = $_POST['munilist'];
        }
        if(isset($_POST['brgylist']) and $_POST['brgylist'] > 0) {
            $_SESSION['brgy'] = $_POST['brgylist'];
        }
    }
}
// jfsbaldo merged 020520161408



