<?php
/**
 * Created by PhpStorm.
 * User: mblejano
 * Date: 4/13/2016
 * Time: 1:30 PM
 */
class reports extends CI_Controller {
    public function index()
    {
        $this->init_rpmb_session();
        $rpmb['regionlist'] = $this->reports_model->get_regions();

        if(isset($_SESSION['province']) or isset($_SESSION['region'])) {
            $rpmb['provlist'] = $this->reports_model->get_provinces($_SESSION['region']);
        }
        if(isset($_SESSION['city']) or isset($_SESSION['province'])) {
            $rpmb['citylist'] = $this->reports_model->get_cities($_SESSION['province']);
        }
        $this->load->view('header');
        $this->load->view('nav');
        $this->load->view('sidebar');
        $this->load->view('reports_listview',$rpmb);
        $this->load->view('footer');

    }
    public function viewTable()
    {
        $regionlist = $this->input->post('regionlist');
        $provlist = $this->input->post('prov_pass');
        $citylist = $this->input->post('city_pass');
        $LGUtype = $this->input->post('LGUtype');
        $sectorType = $this->input->post('sectorType');
        $submit = $this->input->post('submit');

        if($provlist == ""){
            $provlist = 0;
        }
        if($citylist == ""){
            $citylist = 0;
        }

        $this->load->view('header');
        $this->load->view('nav');
        $this->load->view('sidebar');
        $this->load->view('reports_listview',array(
            'regionlist2' => $regionlist,
            'provlist2' => $provlist,
            'citylist2' => $citylist,
            'LGUtype2' => $LGUtype,
            'sectorType2' => $sectorType,
            'submit' => $submit,
        ));
        $this->load->view('footer');

    }

    public function pswdo_score($regionlist){

    $pswdo_details = $this->reports_model->get_pswdoscore($regionlist);


// Create new PHPExcel object
    $objPHPExcel = new PHPExcel();

// Add some data

    $objPHPExcel->getActiveSheet()->setCellValue('B1', 'PSWDO');
    //autosize column

    $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
    $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
    $objPHPExcel->getActiveSheet()->getStyle('B1')->getFill()->getStartColor()->setRGB('FF0000');
//        $objPHPExcel->getActiveSheet()->getDefaultRowDimension()->setRowHeight(-1);a
    $objPHPExcel->getActiveSheet()->getRowDimension(1)->setRowHeight(-1);
    $objPHPExcel->getActiveSheet()->getStyle('B1')->getFont()->setBold(true);
    $objPHPExcel->getActiveSheet()->getStyle('B1')->getFont()->setSize(20);
    $objPHPExcel->getActiveSheet()->mergeCells('B1:E2');

    //Center text merge columns
    $objPHPExcel->getActiveSheet()->getStyle('B1')->getAlignment()->applyFromArray(
        array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,));
//    $col = 'A';
//        $row = 5;
    $objPHPExcel->getActiveSheet()->setCellValue('A3', 'Region');
    $objPHPExcel->getActiveSheet()->getStyle('A3')->getFont()->setBold(true);
    $objPHPExcel->getActiveSheet()->setCellValue('B3', 'Baseline Score -Sample title');
    $objPHPExcel->getActiveSheet()->mergeCells('A3:A5');
    $objPHPExcel->getActiveSheet()->mergeCells('B3:E3');
    //Center text merge columns
    $objPHPExcel->getActiveSheet()->getStyle('B3')->getAlignment()->applyFromArray(
        array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,));
    $objPHPExcel->getActiveSheet()->getStyle('A3')->getAlignment()->applyFromArray(
        array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,));

    $objPHPExcel->getActiveSheet()->getStyle('A3')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);

    $objPHPExcel->getActiveSheet()->mergeCells('B6:e6');
    $objPHPExcel->getActiveSheet()->freezePane('B6');
    //Header
    $objPHPExcel->getActiveSheet()->setCellValue('B4', 'Province');
    $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
    $objPHPExcel->getActiveSheet()->getStyle('B4')->getAlignment()->applyFromArray(
        array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,));
    $objPHPExcel->getActiveSheet()->setCellValue('C4', 'Score');
    $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
    $objPHPExcel->getActiveSheet()->getStyle('C4')->getAlignment()->applyFromArray(
        array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,));
    $objPHPExcel->getActiveSheet()->setCellValue('D4', 'Level of Functionality');
    $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
    $objPHPExcel->getActiveSheet()->getStyle('D4')->getAlignment()->applyFromArray(
        array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,));
    $objPHPExcel->getActiveSheet()->setCellValue('e4', 'Rank');
    $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);
    $objPHPExcel->getActiveSheet()->getStyle('e4')->getAlignment()->applyFromArray(
        array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,));
    $row2 = 7;
    $col2 = 'A';
    $previousvalue = '';
    $rank = 0;
    foreach ($pswdo_details as $pswdodata):
        $region = $pswdodata->region_name;
        $province = $pswdodata->prov_name;
        $baselinescore = $pswdodata->baseline_score;
        $leveloffunction = $pswdodata->level_function_baseline;

        if($previousvalue != $baselinescore)
        {
            $rank++;
        }

        $objPHPExcel->getActiveSheet()->setCellValue($col2.$row2, $region);$col2++;
        $objPHPExcel->getActiveSheet()->setCellValue($col2.$row2, $province);$col2++;
        $objPHPExcel->getActiveSheet()->setCellValue($col2.$row2, $baselinescore);$col2++;
        $objPHPExcel->getActiveSheet()->setCellValue($col2.$row2, $leveloffunction);$col2++;
        $objPHPExcel->getActiveSheet()->setCellValue($col2.$row2, $rank);
        $previousvalue = $baselinescore ;

        if($col2 == 'E'){$col2 = 'A';}
        $row2++;
    endforeach;
//    //border
    $objPHPExcel->getActiveSheet()->getStyle(
        'A1:' .
        $objPHPExcel->getActiveSheet()->getHighestColumn() .
        $objPHPExcel->getActiveSheet()->getHighestRow()
    )->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
// Rename worksheet (worksheet, not filename)
    $objPHPExcel->getActiveSheet()->setTitle('PSWDO Baseline');

// Set active sheet index to the first sheet, so Excel opens this as the first asheet
    $objPHPExcel->setActiveSheetIndex(0);

// Redirect output to a client’s web browser (Excel2007)
//clean the output buffer
    ob_end_clean();

//this is the header given from PHPExcel examples. but the output seems somewhat corrupted in some cases.
//header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
//so, we use this header instead.
//    $regionName = $this->reports_model->getRegionName($region);
    $filename = 'PSWDO Baseline.xlsx';
    header('Content-type: application/vnd.ms-excel');
    header('Content-Disposition: attachment;filename='.$filename);
    header('Cache-Control: max-age=0');

    $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
    $objWriter->save('php://output');
}
    public function pswdo_newscore($regionlist){

        $pswdo_details = $this->reports_model->get_pswdonewscore($regionlist);


// Create new PHPExcel object
        $objPHPExcel = new PHPExcel();

// Add some data

        $objPHPExcel->getActiveSheet()->setCellValue('B1', 'PSWDO');
        //autosize column

        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getStyle('B1')->getFill()->getStartColor()->setRGB('FF0000');
//        $objPHPExcel->getActiveSheet()->getDefaultRowDimension()->setRowHeight(-1);a
        $objPHPExcel->getActiveSheet()->getRowDimension(1)->setRowHeight(-1);
        $objPHPExcel->getActiveSheet()->getStyle('B1')->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->getStyle('B1')->getFont()->setSize(20);
        $objPHPExcel->getActiveSheet()->mergeCells('B1:E2');

        //Center text merge columns
        $objPHPExcel->getActiveSheet()->getStyle('B1')->getAlignment()->applyFromArray(
            array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,));
//    $col = 'A';
//        $row = 5;
        $objPHPExcel->getActiveSheet()->setCellValue('A3', 'Region');
        $objPHPExcel->getActiveSheet()->getStyle('A3')->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->setCellValue('B3', 'New Score -Sample title');
        $objPHPExcel->getActiveSheet()->mergeCells('A3:A5');
        $objPHPExcel->getActiveSheet()->mergeCells('B3:E3');
        //Center text merge columns
        $objPHPExcel->getActiveSheet()->getStyle('B3')->getAlignment()->applyFromArray(
            array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,));
        $objPHPExcel->getActiveSheet()->getStyle('A3')->getAlignment()->applyFromArray(
            array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,));

        $objPHPExcel->getActiveSheet()->getStyle('A3')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);

        $objPHPExcel->getActiveSheet()->mergeCells('B6:e6');
        $objPHPExcel->getActiveSheet()->freezePane('B6');
        //Header
        $objPHPExcel->getActiveSheet()->setCellValue('B4', 'Province');
        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getStyle('B4')->getAlignment()->applyFromArray(
            array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,));
        $objPHPExcel->getActiveSheet()->setCellValue('C4', 'Score');
        $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getStyle('C4')->getAlignment()->applyFromArray(
            array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,));
        $objPHPExcel->getActiveSheet()->setCellValue('D4', 'Level of Functionality');
        $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getStyle('D4')->getAlignment()->applyFromArray(
            array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,));
        $objPHPExcel->getActiveSheet()->setCellValue('e4', 'Rank');
        $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getStyle('e4')->getAlignment()->applyFromArray(
            array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,));
        $row2 = 7;
        $col2 = 'A';
        $previousvalue = '';
        $rank = 0;
        foreach ($pswdo_details as $pswdodata):
            $region = $pswdodata->region_name;
            $province = $pswdodata->prov_name;
            $baselinescore = $pswdodata->new_score;
            $leveloffunction = $pswdodata->level_function_new;

            if($previousvalue != $baselinescore)
            {
                $rank++;
            }

            $objPHPExcel->getActiveSheet()->setCellValue($col2.$row2, $region);$col2++;
            $objPHPExcel->getActiveSheet()->setCellValue($col2.$row2, $province);$col2++;
            $objPHPExcel->getActiveSheet()->setCellValue($col2.$row2, $baselinescore);$col2++;
            $objPHPExcel->getActiveSheet()->setCellValue($col2.$row2, $leveloffunction);$col2++;
            $objPHPExcel->getActiveSheet()->setCellValue($col2.$row2, $rank);
            $previousvalue = $baselinescore ;

            if($col2 == 'E'){$col2 = 'A';}
            $row2++;
        endforeach;
//    //border
        $objPHPExcel->getActiveSheet()->getStyle(
            'A1:' .
            $objPHPExcel->getActiveSheet()->getHighestColumn() .
            $objPHPExcel->getActiveSheet()->getHighestRow()
        )->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
// Rename worksheet (worksheet, not filename)
        $objPHPExcel->getActiveSheet()->setTitle('PSWDO');

// Set active sheet index to the first sheet, so Excel opens this as the first asheet
        $objPHPExcel->setActiveSheetIndex(0);

// Redirect output to a client’s web browser (Excel2007)
//clean the output buffer
        ob_end_clean();

//this is the header given from PHPExcel examples. but the output seems somewhat corrupted in some cases.
//header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
//so, we use this header instead.
//    $regionName = $this->reports_model->getRegionName($region);
        $filename = 'PSWDO-Updated.xlsx';
        header('Content-type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename='.$filename);
        header('Cache-Control: max-age=0');

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        $objWriter->save('php://output');
    }

    public function pswdo_scoreladderized($regionlist){

        $pswdoscoreladder = $this->reports_model->get_pswdoscoreLadder($regionlist);


// Create new PHPExcel object
        $objPHPExcel = new PHPExcel();

// Add some data

        $objPHPExcel->getActiveSheet()->setCellValue('A1', 'Score of PSWDO, by ladderized scaling');
        //autosize column


        $objPHPExcel->getActiveSheet()->getStyle('A1')->getFill()->getStartColor()->setRGB('FF0000');
//        $objPHPExcel->getActiveSheet()->getDefaultRowDimension()->setRowHeight(-1);a
        $objPHPExcel->getActiveSheet()->getRowDimension(1)->setRowHeight(-1);
        $objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setSize(12);
        $objPHPExcel->getActiveSheet()->mergeCells('A1:D2');

        //Center text merge columns
        $objPHPExcel->getActiveSheet()->getStyle('B1')->getAlignment()->applyFromArray(
            array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,));
//    $col = 'A';
//        $row = 5;
        $objPHPExcel->getActiveSheet()->setCellValue('A3', 'Province');
        $objPHPExcel->getActiveSheet()->getStyle('A3')->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->setCellValue('B3', 'Score');
        $objPHPExcel->getActiveSheet()->mergeCells('A3:A5');
        $objPHPExcel->getActiveSheet()->mergeCells('B3:D3');
        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
        //Center text merge columns
        $objPHPExcel->getActiveSheet()->getStyle('B3')->getAlignment()->applyFromArray(
            array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,));
        $objPHPExcel->getActiveSheet()->getStyle('A3')->getAlignment()->applyFromArray(
            array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,));

        $objPHPExcel->getActiveSheet()->getStyle('A3')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);

        $objPHPExcel->getActiveSheet()->mergeCells('B6:D6');
        $objPHPExcel->getActiveSheet()->freezePane('B6');
        //Header
        $objPHPExcel->getActiveSheet()->setCellValue('B4', 'Bronze');
        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getStyle('B4')->getAlignment()->applyFromArray(
            array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,));
        $objPHPExcel->getActiveSheet()->setCellValue('C4', 'Silver');
        $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getStyle('C4')->getAlignment()->applyFromArray(
            array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,));
        $objPHPExcel->getActiveSheet()->setCellValue('D4', 'Gold');
        $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getStyle('D4')->getAlignment()->applyFromArray(
            array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,));
        $row2 = 7;
        $col2 = 'A';
        $previousvalue = '';
        $rank = 0;
        foreach ($pswdoscoreladder as $pswdoscoreladderdata):
            $province = $pswdoscoreladderdata->prov_name;
            $bronze = $pswdoscoreladderdata->Bronze;
            $silver = $pswdoscoreladderdata->Silver;
            $gold = $pswdoscoreladderdata->Gold;


            $objPHPExcel->getActiveSheet()->setCellValue($col2.$row2, $province);$col2++;
            $objPHPExcel->getActiveSheet()->setCellValue($col2.$row2, $bronze);$col2++;
            $objPHPExcel->getActiveSheet()->setCellValue($col2.$row2, $silver);$col2++;
            $objPHPExcel->getActiveSheet()->setCellValue($col2.$row2, $gold);

            if($col2 == 'D'){$col2 = 'A';}
            $row2++;
        endforeach;
//    //border
        $objPHPExcel->getActiveSheet()->getStyle(
            'A1:' .
            $objPHPExcel->getActiveSheet()->getHighestColumn() .
            $objPHPExcel->getActiveSheet()->getHighestRow()
        )->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
// Rename worksheet (worksheet, not filename)
        $objPHPExcel->getActiveSheet()->setTitle('Score of PSWDO ladderized');

// Set active sheet index to the first sheet, so Excel opens this as the first asheet
        $objPHPExcel->setActiveSheetIndex(0);

// Redirect output to a client’s web browser (Excel2007)
//clean the output buffer
        ob_end_clean();

//this is the header given from PHPExcel examples. but the output seems somewhat corrupted in some cases.
//header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
//so, we use this header instead.
//    $regionName = $this->reports_model->getRegionName($region);
        $filename = 'Score of PSWDO ladderized.xlsx';
        header('Content-type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename='.$filename);
        header('Cache-Control: max-age=0');

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        $objWriter->save('php://output');
    }
    public function cswdo_scoreladderized($regionlist,$provlist){

        $cswdoscoreladder = $this->reports_model->get_cswdoscoreLadder($regionlist,$provlist);


// Create new PHPExcel object
        $objPHPExcel = new PHPExcel();

// Add some data

        $objPHPExcel->getActiveSheet()->setCellValue('A1', 'Score of CSWDO, by ladderized scaling');
        //autosize column


        $objPHPExcel->getActiveSheet()->getStyle('A1')->getFill()->getStartColor()->setRGB('FF0000');
//        $objPHPExcel->getActiveSheet()->getDefaultRowDimension()->setRowHeight(-1);a
        $objPHPExcel->getActiveSheet()->getRowDimension(1)->setRowHeight(-1);
        $objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setSize(12);
        $objPHPExcel->getActiveSheet()->mergeCells('A1:D2');

        //Center text merge columns
        $objPHPExcel->getActiveSheet()->getStyle('B1')->getAlignment()->applyFromArray(
            array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,));
//    $col = 'A';
//        $row = 5;
        $objPHPExcel->getActiveSheet()->setCellValue('A3', 'City');
        $objPHPExcel->getActiveSheet()->getStyle('A3')->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->setCellValue('B3', 'Score');
        $objPHPExcel->getActiveSheet()->mergeCells('A3:A5');
        $objPHPExcel->getActiveSheet()->mergeCells('B3:D3');
        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
        //Center text merge columns
        $objPHPExcel->getActiveSheet()->getStyle('B3')->getAlignment()->applyFromArray(
            array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,));
        $objPHPExcel->getActiveSheet()->getStyle('A3')->getAlignment()->applyFromArray(
            array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,));

        $objPHPExcel->getActiveSheet()->getStyle('A3')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);

        $objPHPExcel->getActiveSheet()->mergeCells('B6:D6');
        $objPHPExcel->getActiveSheet()->freezePane('B6');
        //Header
        $objPHPExcel->getActiveSheet()->setCellValue('B4', 'Bronze');
        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getStyle('B4')->getAlignment()->applyFromArray(
            array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,));
        $objPHPExcel->getActiveSheet()->setCellValue('C4', 'Silver');
        $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getStyle('C4')->getAlignment()->applyFromArray(
            array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,));
        $objPHPExcel->getActiveSheet()->setCellValue('D4', 'Gold');
        $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getStyle('D4')->getAlignment()->applyFromArray(
            array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,));
        $row2 = 7;
        $col2 = 'A';
        $previousvalue = '';
        $rank = 0;
        foreach ($cswdoscoreladder as $cswdoscoreladderdata):
            $city = $cswdoscoreladderdata->city_name;
            $bronze = $cswdoscoreladderdata->Bronze;
            $silver = $cswdoscoreladderdata->Silver;
            $gold = $cswdoscoreladderdata->Gold;


            $objPHPExcel->getActiveSheet()->setCellValue($col2.$row2, $city);$col2++;
            $objPHPExcel->getActiveSheet()->setCellValue($col2.$row2, $bronze);$col2++;
            $objPHPExcel->getActiveSheet()->setCellValue($col2.$row2, $silver);$col2++;
            $objPHPExcel->getActiveSheet()->setCellValue($col2.$row2, $gold);

            if($col2 == 'D'){$col2 = 'A';}
            $row2++;
        endforeach;
//    //border
        $objPHPExcel->getActiveSheet()->getStyle(
            'A1:' .
            $objPHPExcel->getActiveSheet()->getHighestColumn() .
            $objPHPExcel->getActiveSheet()->getHighestRow()
        )->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
// Rename worksheet (worksheet, not filename)
        $objPHPExcel->getActiveSheet()->setTitle('Score of CSWDO ladderized');

// Set active sheet index to the first sheet, so Excel opens this as the first asheet
        $objPHPExcel->setActiveSheetIndex(0);

// Redirect output to a client’s web browser (Excel2007)
//clean the output buffer
        ob_end_clean();

//this is the header given from PHPExcel examples. but the output seems somewhat corrupted in some cases.
//header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
//so, we use this header instead.
//    $regionName = $this->reports_model->getRegionName($region);
        $filename = 'Score of CSWDO ladderized.xlsx';
        header('Content-type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename='.$filename);
        header('Cache-Control: max-age=0');

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        $objWriter->save('php://output');
    }
    public function mswdo_scoreladderized($regionlist,$provlist){

        $mswdoscoreladder = $this->reports_model->get_mswdoscoreLadder($regionlist,$provlist);


// Create new PHPExcel object
        $objPHPExcel = new PHPExcel();

// Add some data

        $objPHPExcel->getActiveSheet()->setCellValue('A1', 'Score of MSWDO, by ladderized scaling');
        //autosize column


        $objPHPExcel->getActiveSheet()->getStyle('A1')->getFill()->getStartColor()->setRGB('FF0000');
//        $objPHPExcel->getActiveSheet()->getDefaultRowDimension()->setRowHeight(-1);a
        $objPHPExcel->getActiveSheet()->getRowDimension(1)->setRowHeight(-1);
        $objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setSize(12);
        $objPHPExcel->getActiveSheet()->mergeCells('A1:D2');

        //Center text merge columns
        $objPHPExcel->getActiveSheet()->getStyle('B1')->getAlignment()->applyFromArray(
            array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,));
//    $col = 'A';
//        $row = 5;
        $objPHPExcel->getActiveSheet()->setCellValue('A3', 'Municipality');
        $objPHPExcel->getActiveSheet()->getStyle('A3')->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->setCellValue('B3', 'Score');
        $objPHPExcel->getActiveSheet()->mergeCells('A3:A5');
        $objPHPExcel->getActiveSheet()->mergeCells('B3:D3');
        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
        //Center text merge columns
        $objPHPExcel->getActiveSheet()->getStyle('B3')->getAlignment()->applyFromArray(
            array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,));
        $objPHPExcel->getActiveSheet()->getStyle('A3')->getAlignment()->applyFromArray(
            array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,));

        $objPHPExcel->getActiveSheet()->getStyle('A3')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);

        $objPHPExcel->getActiveSheet()->mergeCells('B6:D6');
        $objPHPExcel->getActiveSheet()->freezePane('B6');
        //Header
        $objPHPExcel->getActiveSheet()->setCellValue('B4', 'Bronze');
        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getStyle('B4')->getAlignment()->applyFromArray(
            array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,));
        $objPHPExcel->getActiveSheet()->setCellValue('C4', 'Silver');
        $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getStyle('C4')->getAlignment()->applyFromArray(
            array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,));
        $objPHPExcel->getActiveSheet()->setCellValue('D4', 'Gold');
        $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getStyle('D4')->getAlignment()->applyFromArray(
            array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,));
        $row2 = 7;
        $col2 = 'A';
        foreach ($mswdoscoreladder as $mswdoscoreladderdata):
            $city = $mswdoscoreladderdata->city_name;
            $bronze = $mswdoscoreladderdata->Bronze;
            $silver = $mswdoscoreladderdata->Silver;
            $gold = $mswdoscoreladderdata->Gold;


            $objPHPExcel->getActiveSheet()->setCellValue($col2.$row2, $city);$col2++;
            $objPHPExcel->getActiveSheet()->setCellValue($col2.$row2, $bronze);$col2++;
            $objPHPExcel->getActiveSheet()->setCellValue($col2.$row2, $silver);$col2++;
            $objPHPExcel->getActiveSheet()->setCellValue($col2.$row2, $gold);

            if($col2 == 'D'){$col2 = 'A';}
            $row2++;
        endforeach;
//    //border
        $objPHPExcel->getActiveSheet()->getStyle(
            'A1:' .
            $objPHPExcel->getActiveSheet()->getHighestColumn() .
            $objPHPExcel->getActiveSheet()->getHighestRow()
        )->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
// Rename worksheet (worksheet, not filename)
        $objPHPExcel->getActiveSheet()->setTitle('Score of MSWDO ladderized');

// Set active sheet index to the first sheet, so Excel opens this as the first asheet
        $objPHPExcel->setActiveSheetIndex(0);

// Redirect output to a client’s web browser (Excel2007)
//clean the output buffer
        ob_end_clean();

//this is the header given from PHPExcel examples. but the output seems somewhat corrupted in some cases.
//header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
//so, we use this header instead.
//    $regionName = $this->reports_model->getRegionName($region);
        $filename = 'Score of MSWDO ladderized.xlsx';
        header('Content-type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename='.$filename);
        header('Cache-Control: max-age=0');

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        $objWriter->save('php://output');
    }

    public function cswdo_score($regionlist,$provlist){

        $cswdo_details = $this->reports_model->get_cswdoscore($regionlist,$provlist);


// Create new PHPExcel object
        $objPHPExcel = new PHPExcel();

// Add some data

        $objPHPExcel->getActiveSheet()->setCellValue('B1', 'CSWDO');
        //autosize column

        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getStyle('B1')->getFill()->getStartColor()->setRGB('FF0000');
//        $objPHPExcel->getActiveSheet()->getDefaultRowDimension()->setRowHeight(-1);a
        $objPHPExcel->getActiveSheet()->getRowDimension(1)->setRowHeight(-1);
        $objPHPExcel->getActiveSheet()->getStyle('B1')->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->getStyle('B1')->getFont()->setSize(20);
        $objPHPExcel->getActiveSheet()->mergeCells('B1:E2');

        //Center text merge columns
        $objPHPExcel->getActiveSheet()->getStyle('B1')->getAlignment()->applyFromArray(
            array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,));
//    $col = 'A';
//        $row = 5;
        $objPHPExcel->getActiveSheet()->setCellValue('A3', 'Region');
        $objPHPExcel->getActiveSheet()->getStyle('A3')->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->setCellValue('B3', 'Baseline Score -Sample title');
        $objPHPExcel->getActiveSheet()->mergeCells('A3:A5');
        $objPHPExcel->getActiveSheet()->mergeCells('B3:E3');
        //Center text merge columns
        $objPHPExcel->getActiveSheet()->getStyle('B3')->getAlignment()->applyFromArray(
            array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,));
        $objPHPExcel->getActiveSheet()->getStyle('A3')->getAlignment()->applyFromArray(
            array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,));

        $objPHPExcel->getActiveSheet()->getStyle('A3')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);

        $objPHPExcel->getActiveSheet()->mergeCells('B6:F6');
        $objPHPExcel->getActiveSheet()->freezePane('B6');
        //Header
        $objPHPExcel->getActiveSheet()->setCellValue('B4', 'Province');
        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getStyle('B4')->getAlignment()->applyFromArray(
            array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,));

        $objPHPExcel->getActiveSheet()->setCellValue('C4', 'Province');
        $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getStyle('C4')->getAlignment()->applyFromArray(
            array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,));

        $objPHPExcel->getActiveSheet()->setCellValue('D4', 'Score');
        $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getStyle('D4')->getAlignment()->applyFromArray(
            array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,));

        $objPHPExcel->getActiveSheet()->setCellValue('E4', 'Level of Functionality');
        $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getStyle('E4')->getAlignment()->applyFromArray(
            array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,));

        $objPHPExcel->getActiveSheet()->setCellValue('F4', 'Rank');
        $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getStyle('F4')->getAlignment()->applyFromArray(
            array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,));
        $row2 = 7;
        $col2 = 'A';
        $previousvalue = '';
        $rank = 0;
        foreach ($cswdo_details as $cswdodata):
            $region = $cswdodata->region_name;
            $province = $cswdodata->prov_name;
            $city = $cswdodata->city_name;
            $baselinescore = $cswdodata->baseline_score;
            $leveloffunction = $cswdodata->level_function_baseline;

            if($previousvalue != $baselinescore)
            {
                $rank++;
            }

            $objPHPExcel->getActiveSheet()->setCellValue($col2.$row2, $region);$col2++;
            $objPHPExcel->getActiveSheet()->setCellValue($col2.$row2, $province);$col2++;
            $objPHPExcel->getActiveSheet()->setCellValue($col2.$row2, $city);$col2++;
            $objPHPExcel->getActiveSheet()->setCellValue($col2.$row2, $baselinescore);$col2++;
            $objPHPExcel->getActiveSheet()->setCellValue($col2.$row2, $leveloffunction);$col2++;
            $objPHPExcel->getActiveSheet()->setCellValue($col2.$row2, $rank);
            $previousvalue = $baselinescore ;

            if($col2 == 'F'){$col2 = 'A';}
            $row2++;
        endforeach;
//    //border
        $objPHPExcel->getActiveSheet()->getStyle(
            'A1:' .
            $objPHPExcel->getActiveSheet()->getHighestColumn() .
            $objPHPExcel->getActiveSheet()->getHighestRow()
        )->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
// Rename worksheet (worksheet, not filename)
        $objPHPExcel->getActiveSheet()->setTitle('CSWDO-Baseline');

// Set active sheet index to the first sheet, so Excel opens this as the first asheet
        $objPHPExcel->setActiveSheetIndex(0);

// Redirect output to a client’s web browser (Excel2007)
//clean the output buffer
        ob_end_clean();

//this is the header given from PHPExcel examples. but the output seems somewhat corrupted in some cases.
//header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
//so, we use this header instead.
//    $regionName = $this->reports_model->getRegionName($region);
        $filename = 'CSWDO-Baseline.xlsx';
        header('Content-type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename='.$filename);
        header('Cache-Control: max-age=0');

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        $objWriter->save('php://output');
    }
    public function cswdo_newscore($regionlist,$provlist){

        $cswdo_details = $this->reports_model->get_cswdonewscore($regionlist,$provlist);


// Create new PHPExcel object
        $objPHPExcel = new PHPExcel();

// Add some data

        $objPHPExcel->getActiveSheet()->setCellValue('B1', 'CSWDO');
        //autosize column

        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getStyle('B1')->getFill()->getStartColor()->setRGB('FF0000');
//        $objPHPExcel->getActiveSheet()->getDefaultRowDimension()->setRowHeight(-1);a
        $objPHPExcel->getActiveSheet()->getRowDimension(1)->setRowHeight(-1);
        $objPHPExcel->getActiveSheet()->getStyle('B1')->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->getStyle('B1')->getFont()->setSize(20);
        $objPHPExcel->getActiveSheet()->mergeCells('B1:E2');

        //Center text merge columns
        $objPHPExcel->getActiveSheet()->getStyle('B1')->getAlignment()->applyFromArray(
            array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,));
//    $col = 'A';
//        $row = 5;
        $objPHPExcel->getActiveSheet()->setCellValue('A3', 'Region');
        $objPHPExcel->getActiveSheet()->getStyle('A3')->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->setCellValue('B3', 'New Score -Sample title');
        $objPHPExcel->getActiveSheet()->mergeCells('A3:A5');
        $objPHPExcel->getActiveSheet()->mergeCells('B3:E3');
        //Center text merge columns
        $objPHPExcel->getActiveSheet()->getStyle('B3')->getAlignment()->applyFromArray(
            array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,));
        $objPHPExcel->getActiveSheet()->getStyle('A3')->getAlignment()->applyFromArray(
            array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,));

        $objPHPExcel->getActiveSheet()->getStyle('A3')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);

        $objPHPExcel->getActiveSheet()->mergeCells('B6:F6');
        $objPHPExcel->getActiveSheet()->freezePane('B6');
        //Header
        $objPHPExcel->getActiveSheet()->setCellValue('B4', 'Province');
        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getStyle('B4')->getAlignment()->applyFromArray(
            array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,));

        $objPHPExcel->getActiveSheet()->setCellValue('C4', 'Province');
        $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getStyle('C4')->getAlignment()->applyFromArray(
            array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,));

        $objPHPExcel->getActiveSheet()->setCellValue('D4', 'Score');
        $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getStyle('D4')->getAlignment()->applyFromArray(
            array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,));

        $objPHPExcel->getActiveSheet()->setCellValue('E4', 'Level of Functionality');
        $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getStyle('E4')->getAlignment()->applyFromArray(
            array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,));

        $objPHPExcel->getActiveSheet()->setCellValue('F4', 'Rank');
        $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getStyle('F4')->getAlignment()->applyFromArray(
            array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,));
        $row2 = 7;
        $col2 = 'A';
        $previousvalue = '';
        $rank = 0;
        foreach ($cswdo_details as $cswdodata):
            $region = $cswdodata->region_name;
            $province = $cswdodata->prov_name;
            $city = $cswdodata->city_name;
            $baselinescore = $cswdodata->new_score;
            $leveloffunction = $cswdodata->level_function_new;

            if($previousvalue != $baselinescore)
            {
                $rank++;
            }

            $objPHPExcel->getActiveSheet()->setCellValue($col2.$row2, $region);$col2++;
            $objPHPExcel->getActiveSheet()->setCellValue($col2.$row2, $province);$col2++;
            $objPHPExcel->getActiveSheet()->setCellValue($col2.$row2, $city);$col2++;
            $objPHPExcel->getActiveSheet()->setCellValue($col2.$row2, $baselinescore);$col2++;
            $objPHPExcel->getActiveSheet()->setCellValue($col2.$row2, $leveloffunction);$col2++;
            $objPHPExcel->getActiveSheet()->setCellValue($col2.$row2, $rank);
            $previousvalue = $baselinescore ;

            if($col2 == 'F'){$col2 = 'A';}
            $row2++;
        endforeach;
//    //border
        $objPHPExcel->getActiveSheet()->getStyle(
            'A1:' .
            $objPHPExcel->getActiveSheet()->getHighestColumn() .
            $objPHPExcel->getActiveSheet()->getHighestRow()
        )->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
// Rename worksheet (worksheet, not filename)
        $objPHPExcel->getActiveSheet()->setTitle('CSWDO-Updated');

// Set active sheet index to the first sheet, so Excel opens this as the first asheet
        $objPHPExcel->setActiveSheetIndex(0);

// Redirect output to a client’s web browser (Excel2007)
//clean the output buffer
        ob_end_clean();

//this is the header given from PHPExcel examples. but the output seems somewhat corrupted in some cases.
//header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
//so, we use this header instead.
//    $regionName = $this->reports_model->getRegionName($region);
        $filename = 'CSWDO-Updated.xlsx';
        header('Content-type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename='.$filename);
        header('Cache-Control: max-age=0');

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        $objWriter->save('php://output');
    }

    public function mswdo_score($regionlist,$provlist){

        $mswdo_details = $this->reports_model->get_mswdoscore($regionlist,$provlist);


// Create new PHPExcel object
        $objPHPExcel = new PHPExcel();

// Add some data

        $objPHPExcel->getActiveSheet()->setCellValue('B1', 'MSWDO');
        //autosize column

        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getStyle('B1')->getFill()->getStartColor()->setRGB('FF0000');
//        $objPHPExcel->getActiveSheet()->getDefaultRowDimension()->setRowHeight(-1);a
        $objPHPExcel->getActiveSheet()->getRowDimension(1)->setRowHeight(-1);
        $objPHPExcel->getActiveSheet()->getStyle('B1')->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->getStyle('B1')->getFont()->setSize(20);
        $objPHPExcel->getActiveSheet()->mergeCells('B1:E2');

        //Center text merge columns
        $objPHPExcel->getActiveSheet()->getStyle('B1')->getAlignment()->applyFromArray(
            array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,));
//    $col = 'A';
//        $row = 5;
        $objPHPExcel->getActiveSheet()->setCellValue('A3', 'Region');
        $objPHPExcel->getActiveSheet()->getStyle('A3')->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->setCellValue('B3', 'Baseline Score -Sample title');
        $objPHPExcel->getActiveSheet()->mergeCells('A3:A5');
        $objPHPExcel->getActiveSheet()->mergeCells('B3:E3');
        //Center text merge columns
        $objPHPExcel->getActiveSheet()->getStyle('B3')->getAlignment()->applyFromArray(
            array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,));
        $objPHPExcel->getActiveSheet()->getStyle('A3')->getAlignment()->applyFromArray(
            array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,));

        $objPHPExcel->getActiveSheet()->getStyle('A3')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);

        $objPHPExcel->getActiveSheet()->mergeCells('B6:F6');
        $objPHPExcel->getActiveSheet()->freezePane('B6');
        //Header
        $objPHPExcel->getActiveSheet()->setCellValue('B4', 'Province');
        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getStyle('B4')->getAlignment()->applyFromArray(
            array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,));

        $objPHPExcel->getActiveSheet()->setCellValue('C4', 'Province');
        $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getStyle('C4')->getAlignment()->applyFromArray(
            array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,));

        $objPHPExcel->getActiveSheet()->setCellValue('D4', 'Score');
        $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getStyle('D4')->getAlignment()->applyFromArray(
            array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,));

        $objPHPExcel->getActiveSheet()->setCellValue('E4', 'Level of Functionality');
        $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getStyle('E4')->getAlignment()->applyFromArray(
            array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,));

        $objPHPExcel->getActiveSheet()->setCellValue('F4', 'Rank');
        $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getStyle('F4')->getAlignment()->applyFromArray(
            array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,));
        $row2 = 7;
        $col2 = 'A';
        $previousvalue = '';
        $rank = 0;
        foreach ($mswdo_details as $mswdodata):
            $region = $mswdodata->region_name;
            $province = $mswdodata->prov_name;
            $city = $mswdodata->city_name;
            $baselinescore = $mswdodata->baseline_score;
            $leveloffunction = $mswdodata->level_function_baseline;

            if($previousvalue != $baselinescore)
            {
                $rank++;
            }

            $objPHPExcel->getActiveSheet()->setCellValue($col2.$row2, $region);$col2++;
            $objPHPExcel->getActiveSheet()->setCellValue($col2.$row2, $province);$col2++;
            $objPHPExcel->getActiveSheet()->setCellValue($col2.$row2, $city);$col2++;
            $objPHPExcel->getActiveSheet()->setCellValue($col2.$row2, $baselinescore);$col2++;
            $objPHPExcel->getActiveSheet()->setCellValue($col2.$row2, $leveloffunction);$col2++;
            $objPHPExcel->getActiveSheet()->setCellValue($col2.$row2, $rank);
            $previousvalue = $baselinescore ;

            if($col2 == 'F'){$col2 = 'A';}
            $row2++;
        endforeach;
//    //border
        $objPHPExcel->getActiveSheet()->getStyle(
            'A1:' .
            $objPHPExcel->getActiveSheet()->getHighestColumn() .
            $objPHPExcel->getActiveSheet()->getHighestRow()
        )->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
// Rename worksheet (worksheet, not filename)
        $objPHPExcel->getActiveSheet()->setTitle('MSWDO-Baseline');

// Set active sheet index to the first sheet, so Excel opens this as the first asheet
        $objPHPExcel->setActiveSheetIndex(0);

// Redirect output to a client’s web browser (Excel2007)
//clean the output buffer
        ob_end_clean();

//this is the header given from PHPExcel examples. but the output seems somewhat corrupted in some cases.
//header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
//so, we use this header instead.
//    $regionName = $this->reports_model->getRegionName($region);
        $filename = 'MSWDO-Baseline.xlsx';
        header('Content-type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename='.$filename);
        header('Cache-Control: max-age=0');

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        $objWriter->save('php://output');
    }
    public function mswdo_newscore($regionlist,$provlist){

        $mswdo_details = $this->reports_model->get_mswdonewscore($regionlist,$provlist);
        print_r($mswdo_details);

// Create new PHPExcel object
        $objPHPExcel = new PHPExcel();

// Add some data

        $objPHPExcel->getActiveSheet()->setCellValue('B1', 'MSWDO');
        //autosize column

        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getStyle('B1')->getFill()->getStartColor()->setRGB('FF0000');
//        $objPHPExcel->getActiveSheet()->getDefaultRowDimension()->setRowHeight(-1);a
        $objPHPExcel->getActiveSheet()->getRowDimension(1)->setRowHeight(-1);
        $objPHPExcel->getActiveSheet()->getStyle('B1')->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->getStyle('B1')->getFont()->setSize(20);
        $objPHPExcel->getActiveSheet()->mergeCells('B1:E2');

        //Center text merge columns
        $objPHPExcel->getActiveSheet()->getStyle('B1')->getAlignment()->applyFromArray(
            array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,));
//    $col = 'A';
//        $row = 5;
        $objPHPExcel->getActiveSheet()->setCellValue('A3', 'Region');
        $objPHPExcel->getActiveSheet()->getStyle('A3')->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->setCellValue('B3', 'New Score -Sample title');
        $objPHPExcel->getActiveSheet()->mergeCells('A3:A5');
        $objPHPExcel->getActiveSheet()->mergeCells('B3:E3');
        //Center text merge columns
        $objPHPExcel->getActiveSheet()->getStyle('B3')->getAlignment()->applyFromArray(
            array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,));
        $objPHPExcel->getActiveSheet()->getStyle('A3')->getAlignment()->applyFromArray(
            array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,));

        $objPHPExcel->getActiveSheet()->getStyle('A3')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);

        $objPHPExcel->getActiveSheet()->mergeCells('B6:F6');
        $objPHPExcel->getActiveSheet()->freezePane('B6');
        //Header
        $objPHPExcel->getActiveSheet()->setCellValue('B4', 'Province');
        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getStyle('B4')->getAlignment()->applyFromArray(
            array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,));

        $objPHPExcel->getActiveSheet()->setCellValue('C4', 'Province');
        $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getStyle('C4')->getAlignment()->applyFromArray(
            array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,));

        $objPHPExcel->getActiveSheet()->setCellValue('D4', 'Score');
        $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getStyle('D4')->getAlignment()->applyFromArray(
            array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,));

        $objPHPExcel->getActiveSheet()->setCellValue('E4', 'Level of Functionality');
        $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getStyle('E4')->getAlignment()->applyFromArray(
            array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,));

        $objPHPExcel->getActiveSheet()->setCellValue('F4', 'Rank');
        $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getStyle('F4')->getAlignment()->applyFromArray(
            array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,));
        $row2 = 7;
        $col2 = 'A';
        $previousvalue = '';
        $rank = 0;
        foreach ($mswdo_details as $mswdodata):
            $region = $mswdodata->region_name;
            $province = $mswdodata->prov_name;
            $city = $mswdodata->city_name;
            $baselinescore = $mswdodata->new_score;
            $leveloffunction = $mswdodata->level_function_new;

            if($previousvalue != $baselinescore)
            {
                $rank++;
            }

            $objPHPExcel->getActiveSheet()->setCellValue($col2.$row2, $region);$col2++;
            $objPHPExcel->getActiveSheet()->setCellValue($col2.$row2, $province);$col2++;
            $objPHPExcel->getActiveSheet()->setCellValue($col2.$row2, $city);$col2++;
            $objPHPExcel->getActiveSheet()->setCellValue($col2.$row2, $baselinescore);$col2++;
            $objPHPExcel->getActiveSheet()->setCellValue($col2.$row2, $leveloffunction);$col2++;
            $objPHPExcel->getActiveSheet()->setCellValue($col2.$row2, $rank);
            $previousvalue = $baselinescore ;

            if($col2 == 'F'){$col2 = 'A';}
            $row2++;
        endforeach;
//    //border
        $objPHPExcel->getActiveSheet()->getStyle(
            'A1:' .
            $objPHPExcel->getActiveSheet()->getHighestColumn() .
            $objPHPExcel->getActiveSheet()->getHighestRow()
        )->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
// Rename worksheet (worksheet, not filename)
        $objPHPExcel->getActiveSheet()->setTitle('MSWDO-Updated');

// Set active sheet index to the first sheet, so Excel opens this as the first asheet
        $objPHPExcel->setActiveSheetIndex(0);

// Redirect output to a client’s web browser (Excel2007)
//clean the output buffer
        ob_end_clean();

//this is the header given from PHPExcel examples. but the output seems somewhat corrupted in some cases.
//header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
//so, we use this header instead.
//    $regionName = $this->reports_model->getRegionName($region);
        $filename = 'MSWDO-Updated.xlsx';
        header('Content-type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename='.$filename);
        header('Cache-Control: max-age=0');

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        $objWriter->save('php://output');
    }

    public function cmswdo_score($regionlist,$provlist){

        $cmswdo_details = $this->reports_model->get_cmswdoscore($regionlist,$provlist);


// Create new PHPExcel object
        $objPHPExcel = new PHPExcel();

// Add some data

        $objPHPExcel->getActiveSheet()->setCellValue('B1', 'C/MSWDO');
        //autosize column

        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getStyle('B1')->getFill()->getStartColor()->setRGB('FF0000');
//        $objPHPExcel->getActiveSheet()->getDefaultRowDimension()->setRowHeight(-1);a
        $objPHPExcel->getActiveSheet()->getRowDimension(1)->setRowHeight(-1);
        $objPHPExcel->getActiveSheet()->getStyle('B1')->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->getStyle('B1')->getFont()->setSize(20);
        $objPHPExcel->getActiveSheet()->mergeCells('B1:E2');

        //Center text merge columns
        $objPHPExcel->getActiveSheet()->getStyle('B1')->getAlignment()->applyFromArray(
            array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,));
//    $col = 'A';
//        $row = 5;
        $objPHPExcel->getActiveSheet()->setCellValue('A3', 'Region');
        $objPHPExcel->getActiveSheet()->getStyle('A3')->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->setCellValue('B3', 'Baseline Score -Sample title');
        $objPHPExcel->getActiveSheet()->mergeCells('A3:A5');
        $objPHPExcel->getActiveSheet()->mergeCells('B3:E3');
        //Center text merge columns
        $objPHPExcel->getActiveSheet()->getStyle('B3')->getAlignment()->applyFromArray(
            array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,));
        $objPHPExcel->getActiveSheet()->getStyle('A3')->getAlignment()->applyFromArray(
            array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,));

        $objPHPExcel->getActiveSheet()->getStyle('A3')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);

        $objPHPExcel->getActiveSheet()->mergeCells('B6:F6');
        $objPHPExcel->getActiveSheet()->freezePane('B6');
        //Header
        $objPHPExcel->getActiveSheet()->setCellValue('B4', 'Province');
        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getStyle('B4')->getAlignment()->applyFromArray(
            array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,));

        $objPHPExcel->getActiveSheet()->setCellValue('C4', 'Province');
        $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getStyle('C4')->getAlignment()->applyFromArray(
            array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,));

        $objPHPExcel->getActiveSheet()->setCellValue('D4', 'Score');
        $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getStyle('D4')->getAlignment()->applyFromArray(
            array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,));

        $objPHPExcel->getActiveSheet()->setCellValue('E4', 'Level of Functionality');
        $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getStyle('E4')->getAlignment()->applyFromArray(
            array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,));

        $objPHPExcel->getActiveSheet()->setCellValue('F4', 'Rank');
        $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getStyle('F4')->getAlignment()->applyFromArray(
            array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,));
        $row2 = 7;
        $col2 = 'A';
        $previousvalue = '';
        $rank = 0;
        foreach ($cmswdo_details as $cmswdodata):
            $region = $cmswdodata->region_name;
            $province = $cmswdodata->prov_name;
            $city = $cmswdodata->city_name;
            $baselinescore = $cmswdodata->baseline_score;
            $leveloffunction = $cmswdodata->level_function_baseline;

            if($previousvalue != $baselinescore)
            {
                $rank++;
            }

            $objPHPExcel->getActiveSheet()->setCellValue($col2.$row2, $region);$col2++;
            $objPHPExcel->getActiveSheet()->setCellValue($col2.$row2, $province);$col2++;
            $objPHPExcel->getActiveSheet()->setCellValue($col2.$row2, $city);$col2++;
            $objPHPExcel->getActiveSheet()->setCellValue($col2.$row2, $baselinescore);$col2++;
            $objPHPExcel->getActiveSheet()->setCellValue($col2.$row2, $leveloffunction);$col2++;
            $objPHPExcel->getActiveSheet()->setCellValue($col2.$row2, $rank);
            $previousvalue = $baselinescore ;

            if($col2 == 'F'){$col2 = 'A';}
            $row2++;
        endforeach;
//    //border
        $objPHPExcel->getActiveSheet()->getStyle(
            'A1:' .
            $objPHPExcel->getActiveSheet()->getHighestColumn() .
            $objPHPExcel->getActiveSheet()->getHighestRow()
        )->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
// Rename worksheet (worksheet, not filename)
        $objPHPExcel->getActiveSheet()->setTitle('CMSWDO-Baseline');

// Set active sheet index to the first sheet, so Excel opens this as the first asheet
        $objPHPExcel->setActiveSheetIndex(0);

// Redirect output to a client’s web browser (Excel2007)
//clean the output buffer
        ob_end_clean();

//this is the header given from PHPExcel examples. but the output seems somewhat corrupted in some cases.
//header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
//so, we use this header instead.
//    $regionName = $this->reports_model->getRegionName($region);
        $filename = 'CMSWDO-Baseline.xlsx';
        header('Content-type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename='.$filename);
        header('Cache-Control: max-age=0');

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        $objWriter->save('php://output');
    }
    public function cmswdo_newscore($regionlist,$provlist){

        $cmswdo_details = $this->reports_model->get_cmswdonewscore($regionlist,$provlist);


// Create new PHPExcel object
        $objPHPExcel = new PHPExcel();

// Add some data

        $objPHPExcel->getActiveSheet()->setCellValue('B1', 'CSWDO');
        //autosize column

        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getStyle('B1')->getFill()->getStartColor()->setRGB('FF0000');
//        $objPHPExcel->getActiveSheet()->getDefaultRowDimension()->setRowHeight(-1);a
        $objPHPExcel->getActiveSheet()->getRowDimension(1)->setRowHeight(-1);
        $objPHPExcel->getActiveSheet()->getStyle('B1')->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->getStyle('B1')->getFont()->setSize(20);
        $objPHPExcel->getActiveSheet()->mergeCells('B1:E2');

        //Center text merge columns
        $objPHPExcel->getActiveSheet()->getStyle('B1')->getAlignment()->applyFromArray(
            array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,));
//    $col = 'A';
//        $row = 5;
        $objPHPExcel->getActiveSheet()->setCellValue('A3', 'Region');
        $objPHPExcel->getActiveSheet()->getStyle('A3')->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->setCellValue('B3', 'New Score -Sample title');
        $objPHPExcel->getActiveSheet()->mergeCells('A3:A5');
        $objPHPExcel->getActiveSheet()->mergeCells('B3:E3');
        //Center text merge columns
        $objPHPExcel->getActiveSheet()->getStyle('B3')->getAlignment()->applyFromArray(
            array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,));
        $objPHPExcel->getActiveSheet()->getStyle('A3')->getAlignment()->applyFromArray(
            array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,));

        $objPHPExcel->getActiveSheet()->getStyle('A3')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);

        $objPHPExcel->getActiveSheet()->mergeCells('B6:F6');
        $objPHPExcel->getActiveSheet()->freezePane('B6');
        //Header
        $objPHPExcel->getActiveSheet()->setCellValue('B4', 'Province');
        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getStyle('B4')->getAlignment()->applyFromArray(
            array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,));

        $objPHPExcel->getActiveSheet()->setCellValue('C4', 'Province');
        $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getStyle('C4')->getAlignment()->applyFromArray(
            array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,));

        $objPHPExcel->getActiveSheet()->setCellValue('D4', 'Score');
        $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getStyle('D4')->getAlignment()->applyFromArray(
            array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,));

        $objPHPExcel->getActiveSheet()->setCellValue('E4', 'Level of Functionality');
        $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getStyle('E4')->getAlignment()->applyFromArray(
            array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,));

        $objPHPExcel->getActiveSheet()->setCellValue('F4', 'Rank');
        $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getStyle('F4')->getAlignment()->applyFromArray(
            array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,));
        $row2 = 7;
        $col2 = 'A';
        $previousvalue = '';
        $rank = 0;
        foreach ($cmswdo_details as $cmswdodata):
            $region = $cmswdodata->region_name;
            $province = $cmswdodata->prov_name;
            $city = $cmswdodata->city_name;
            $baselinescore = $cmswdodata->new_score;
            $leveloffunction = $cmswdodata->level_function_new;

            if($previousvalue != $baselinescore)
            {
                $rank++;
            }

            $objPHPExcel->getActiveSheet()->setCellValue($col2.$row2, $region);$col2++;
            $objPHPExcel->getActiveSheet()->setCellValue($col2.$row2, $province);$col2++;
            $objPHPExcel->getActiveSheet()->setCellValue($col2.$row2, $city);$col2++;
            $objPHPExcel->getActiveSheet()->setCellValue($col2.$row2, $baselinescore);$col2++;
            $objPHPExcel->getActiveSheet()->setCellValue($col2.$row2, $leveloffunction);$col2++;
            $objPHPExcel->getActiveSheet()->setCellValue($col2.$row2, $rank);
            $previousvalue = $baselinescore ;

            if($col2 == 'F'){$col2 = 'A';}
            $row2++;
        endforeach;
//    //border
        $objPHPExcel->getActiveSheet()->getStyle(
            'A1:' .
            $objPHPExcel->getActiveSheet()->getHighestColumn() .
            $objPHPExcel->getActiveSheet()->getHighestRow()
        )->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
// Rename worksheet (worksheet, not filename)
        $objPHPExcel->getActiveSheet()->setTitle('CMSWDO-Updated');

// Set active sheet index to the first sheet, so Excel opens this as the first asheet
        $objPHPExcel->setActiveSheetIndex(0);

// Redirect output to a client’s web browser (Excel2007)
//clean the output buffer
        ob_end_clean();

//this is the header given from PHPExcel examples. but the output seems somewhat corrupted in some cases.
//header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
//so, we use this header instead.
//    $regionName = $this->reports_model->getRegionName($region);
        $filename = 'CMSWDO-Updated.xlsx';
        header('Content-type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename='.$filename);
        header('Cache-Control: max-age=0');

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        $objWriter->save('php://output');
    }

    public function distributionCMSWDOall($regionlist){

        $noofcities = $this->reports_model->get_noofCities($regionlist);
        $distributionCMSWDOall = $this->reports_model->get_distributionCMSWDOall();
        $noofprov = $this->reports_model->get_noofProvince($regionlist);


// Create new PHPExcel object
        $objPHPExcel = new PHPExcel();

// Add some data

        $objPHPExcel->getActiveSheet()->setCellValue('B1', 'distributionCMSWDOall-Sample Title');
        //autosize column

        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getStyle('B1')->getFill()->getStartColor()->setRGB('FF0000');
//        $objPHPExcel->getActiveSheet()->getDefaultRowDimension()->setRowHeight(-1);a
        $objPHPExcel->getActiveSheet()->getRowDimension(1)->setRowHeight(-1);
        $objPHPExcel->getActiveSheet()->getStyle('B1')->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->getStyle('B1')->getFont()->setSize(20);
        $objPHPExcel->getActiveSheet()->mergeCells('B1:E2');

        //Center text merge columns
        $objPHPExcel->getActiveSheet()->getStyle('B1')->getAlignment()->applyFromArray(
            array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,));
//    $col = 'A';
//        $row = 5;
        $objPHPExcel->getActiveSheet()->setCellValue('A3', 'Province');
        $objPHPExcel->getActiveSheet()->getStyle('A3')->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->setCellValue('B3', 'distributionCMSWDOall -Sample title');
        $objPHPExcel->getActiveSheet()->mergeCells('A3:A5');
        $objPHPExcel->getActiveSheet()->mergeCells('B3:E3');
        //Center text merge columns
        $objPHPExcel->getActiveSheet()->getStyle('B3')->getAlignment()->applyFromArray(
            array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,));
        $objPHPExcel->getActiveSheet()->getStyle('A3')->getAlignment()->applyFromArray(
            array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,));

        $objPHPExcel->getActiveSheet()->getStyle('A3')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);

        $objPHPExcel->getActiveSheet()->mergeCells('B6:e6');
        $objPHPExcel->getActiveSheet()->freezePane('B6');
        //Header
        $objPHPExcel->getActiveSheet()->setCellValue('B4', 'C/MSWDO');

        $objPHPExcel->getActiveSheet()->getStyle('B4')->getAlignment()->applyFromArray(
            array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,));
        $objPHPExcel->getActiveSheet()->setCellValue('C4', 'No. of Partially Functional');
        $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getStyle('C4')->getAlignment()->applyFromArray(
            array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,));
        $objPHPExcel->getActiveSheet()->setCellValue('D4', 'No. of Functional');
        $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getStyle('D4')->getAlignment()->applyFromArray(
            array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,));
        $objPHPExcel->getActiveSheet()->setCellValue('E4', 'No. of Fully Functional');
        $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getStyle('e4')->getAlignment()->applyFromArray(
            array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,));
        $row2 = 7;
        $col2 = 'A';
//province list
        foreach ($noofcities as $noofcitydata):
            $province = $noofcitydata->prov_name;
            $numCity = $noofcitydata->numCity;

            $objPHPExcel->getActiveSheet()->setCellValue($col2.$row2, $province);$col2++;
            $objPHPExcel->getActiveSheet()->setCellValue($col2.$row2, $numCity);$col2++;


            if($col2 == 'C'){$col2 = 'A';}
            $row2++;
        endforeach;

        $col3 = 'C';
        $row3 = 7;

        $col4 = 'A';
        $row4 = 7;



//functional
       foreach ($distributionCMSWDOall as $distributionCMSWDOalldata):
            $province = $distributionCMSWDOalldata->prov_name;
            $numFunc = $distributionCMSWDOalldata->Functional;
            $numFFunc = $distributionCMSWDOalldata->FullyFunctional;
            $numPFunc = $distributionCMSWDOalldata->PartiallyFunctional;

            for ($counter = 1; $counter <= $noofprov->numProv; $counter++ )
            {
                $prevRegion = $objPHPExcel->getActiveSheet()->getCell($col4.$row4)->getValue();
                $row4++;
                if ($prevRegion == $province)
                {
                    $objPHPExcel->getActiveSheet()->setCellValue($col3.$row3, $numPFunc);$col3++;
                    $objPHPExcel->getActiveSheet()->setCellValue($col3.$row3, $numFFunc);$col3++;
                    $objPHPExcel->getActiveSheet()->setCellValue($col3.$row3, $numFunc);$col3++;
                   break;
                }
                else
                {
                    $row3++;
                }

            }
           if($col3 == 'F'){$col3 = 'C';}
           $row3 = 7;
           $row4 = 7;
        endforeach;
//    //border
        $objPHPExcel->getActiveSheet()->getStyle(
            'A1:' .
            $objPHPExcel->getActiveSheet()->getHighestColumn() .
            $objPHPExcel->getActiveSheet()->getHighestRow()
        )->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
// Rename worksheet (worksheet, not filename)
        $objPHPExcel->getActiveSheet()->setTitle('distributionCMSWDOall');

// Set active sheet index to the first sheet, so Excel opens this as the first asheet
        $objPHPExcel->setActiveSheetIndex(0);

// Redirect output to a client’s web browser (Excel2007)
//clean the output buffer
        ob_end_clean();

//this is the header given from PHPExcel examples. but the output seems somewhat corrupted in some cases.
//header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
//so, we use this header instead.
//    $regionName = $this->reports_model->getRegionName($region);
        $filename = 'distributionCMSWDOall.xlsx';
        header('Content-type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename='.$filename);
        header('Cache-Control: max-age=0');

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        $objWriter->save('php://output');
    }
    public function distributionCSWDOall($regionlist){

        $noofcities = $this->reports_model->get_noofCities($regionlist);
        $distributionCSWDOall = $this->reports_model->get_distributionCSWDOall();
        $noofprov = $this->reports_model->get_noofProvince($regionlist);


// Create new PHPExcel object
        $objPHPExcel = new PHPExcel();

// Add some data

        $objPHPExcel->getActiveSheet()->setCellValue('B1', 'distributionCSWDOall-Sample Title');
        //autosize column

        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getStyle('B1')->getFill()->getStartColor()->setRGB('FF0000');
//        $objPHPExcel->getActiveSheet()->getDefaultRowDimension()->setRowHeight(-1);a
        $objPHPExcel->getActiveSheet()->getRowDimension(1)->setRowHeight(-1);
        $objPHPExcel->getActiveSheet()->getStyle('B1')->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->getStyle('B1')->getFont()->setSize(20);
        $objPHPExcel->getActiveSheet()->mergeCells('B1:E2');

        //Center text merge columns
        $objPHPExcel->getActiveSheet()->getStyle('B1')->getAlignment()->applyFromArray(
            array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,));
//    $col = 'A';
//        $row = 5;
        $objPHPExcel->getActiveSheet()->setCellValue('A3', 'Province');
        $objPHPExcel->getActiveSheet()->getStyle('A3')->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->setCellValue('B3', ' distributionCSWDOall-Sample title');
        $objPHPExcel->getActiveSheet()->mergeCells('A3:A5');
        $objPHPExcel->getActiveSheet()->mergeCells('B3:E3');
        //Center text merge columns
        $objPHPExcel->getActiveSheet()->getStyle('B3')->getAlignment()->applyFromArray(
            array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,));
        $objPHPExcel->getActiveSheet()->getStyle('A3')->getAlignment()->applyFromArray(
            array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,));

        $objPHPExcel->getActiveSheet()->getStyle('A3')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);

        $objPHPExcel->getActiveSheet()->mergeCells('B6:e6');
        $objPHPExcel->getActiveSheet()->freezePane('B6');
        //Header
        $objPHPExcel->getActiveSheet()->setCellValue('B4', 'C/MSWDO');

        $objPHPExcel->getActiveSheet()->getStyle('B4')->getAlignment()->applyFromArray(
            array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,));
        $objPHPExcel->getActiveSheet()->setCellValue('C4', 'No. of Partially Functional');
        $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getStyle('C4')->getAlignment()->applyFromArray(
            array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,));
        $objPHPExcel->getActiveSheet()->setCellValue('D4', 'No. of Functional');
        $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getStyle('D4')->getAlignment()->applyFromArray(
            array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,));
        $objPHPExcel->getActiveSheet()->setCellValue('E4', 'No. of Fully Functional');
        $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getStyle('e4')->getAlignment()->applyFromArray(
            array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,));
        $row2 = 7;
        $col2 = 'A';
//province list
        foreach ($noofcities as $noofcitydata):
            $province = $noofcitydata->prov_name;
            $numCity = $noofcitydata->numCity;

            $objPHPExcel->getActiveSheet()->setCellValue($col2.$row2, $province);$col2++;
            $objPHPExcel->getActiveSheet()->setCellValue($col2.$row2, $numCity);$col2++;


            if($col2 == 'C'){$col2 = 'A';}
            $row2++;
        endforeach;

        $col3 = 'C';
        $row3 = 7;

        $col4 = 'A';
        $row4 = 7;



//functional
       foreach ($distributionCSWDOall as $distributionCSWDOalldata):
            $province = $distributionCSWDOalldata->prov_name;
            $numFunc = $distributionCSWDOalldata->Functional;
            $numFFunc = $distributionCSWDOalldata->FullyFunctional;
            $numPFunc = $distributionCSWDOalldata->PartiallyFunctional;

            for ($counter = 1; $counter <= $noofprov->numProv; $counter++ )
            {
                $prevRegion = $objPHPExcel->getActiveSheet()->getCell($col4.$row4)->getValue();
                $row4++;
                if ($prevRegion == $province)
                {
                    $objPHPExcel->getActiveSheet()->setCellValue($col3.$row3, $numPFunc);$col3++;
                    $objPHPExcel->getActiveSheet()->setCellValue($col3.$row3, $numFFunc);$col3++;
                    $objPHPExcel->getActiveSheet()->setCellValue($col3.$row3, $numFunc);$col3++;
                   break;
                }
                else
                {
                    $row3++;
                }

            }
           if($col3 == 'F'){$col3 = 'C';}
           $row3 = 7;
           $row4 = 7;
        endforeach;
//    //border
        $objPHPExcel->getActiveSheet()->getStyle(
            'A1:' .
            $objPHPExcel->getActiveSheet()->getHighestColumn() .
            $objPHPExcel->getActiveSheet()->getHighestRow()
        )->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
// Rename worksheet (worksheet, not filename)
        $objPHPExcel->getActiveSheet()->setTitle('distributionCSWDOall');

// Set active sheet index to the first sheet, so Excel opens this as the first asheet
        $objPHPExcel->setActiveSheetIndex(0);

// Redirect output to a client’s web browser (Excel2007)
//clean the output buffer
        ob_end_clean();

//this is the header given from PHPExcel examples. but the output seems somewhat corrupted in some cases.
//header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
//so, we use this header instead.
//    $regionName = $this->reports_model->getRegionName($region);
        $filename = 'distributionCSWDOall.xlsx';
        header('Content-type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename='.$filename);
        header('Cache-Control: max-age=0');

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        $objWriter->save('php://output');
    }
    public function distributionMSWDOall($regionlist){

        $noofcities = $this->reports_model->get_noofCities($regionlist);
        $distributionMSWDOall = $this->reports_model->get_distributionMSWDOall();
        $noofprov = $this->reports_model->get_noofProvince($regionlist);


// Create new PHPExcel object
        $objPHPExcel = new PHPExcel();

// Add some data

        $objPHPExcel->getActiveSheet()->setCellValue('B1', 'distributionMSWDOall-Sample Title');
        //autosize column

        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getStyle('B1')->getFill()->getStartColor()->setRGB('FF0000');
//        $objPHPExcel->getActiveSheet()->getDefaultRowDimension()->setRowHeight(-1);a
        $objPHPExcel->getActiveSheet()->getRowDimension(1)->setRowHeight(-1);
        $objPHPExcel->getActiveSheet()->getStyle('B1')->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->getStyle('B1')->getFont()->setSize(20);
        $objPHPExcel->getActiveSheet()->mergeCells('B1:E2');

        //Center text merge columns
        $objPHPExcel->getActiveSheet()->getStyle('B1')->getAlignment()->applyFromArray(
            array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,));
//    $col = 'A';
//        $row = 5;
        $objPHPExcel->getActiveSheet()->setCellValue('A3', 'Province');
        $objPHPExcel->getActiveSheet()->getStyle('A3')->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->setCellValue('B3', 'Distribution of functional by Province -Sample title');
        $objPHPExcel->getActiveSheet()->mergeCells('A3:A5');
        $objPHPExcel->getActiveSheet()->mergeCells('B3:E3');
        //Center text merge columns
        $objPHPExcel->getActiveSheet()->getStyle('B3')->getAlignment()->applyFromArray(
            array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,));
        $objPHPExcel->getActiveSheet()->getStyle('A3')->getAlignment()->applyFromArray(
            array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,));

        $objPHPExcel->getActiveSheet()->getStyle('A3')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);

        $objPHPExcel->getActiveSheet()->mergeCells('B6:e6');
        $objPHPExcel->getActiveSheet()->freezePane('B6');
        //Header
        $objPHPExcel->getActiveSheet()->setCellValue('B4', 'C/MSWDO');

        $objPHPExcel->getActiveSheet()->getStyle('B4')->getAlignment()->applyFromArray(
            array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,));
        $objPHPExcel->getActiveSheet()->setCellValue('C4', 'No. of Partially Functional');
        $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getStyle('C4')->getAlignment()->applyFromArray(
            array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,));
        $objPHPExcel->getActiveSheet()->setCellValue('D4', 'No. of Functional');
        $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getStyle('D4')->getAlignment()->applyFromArray(
            array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,));
        $objPHPExcel->getActiveSheet()->setCellValue('E4', 'No. of Fully Functional');
        $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getStyle('e4')->getAlignment()->applyFromArray(
            array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,));
        $row2 = 7;
        $col2 = 'A';
//province list
        foreach ($noofcities as $noofcitydata):
            $province = $noofcitydata->prov_name;
            $numCity = $noofcitydata->numCity;

            $objPHPExcel->getActiveSheet()->setCellValue($col2.$row2, $province);$col2++;
            $objPHPExcel->getActiveSheet()->setCellValue($col2.$row2, $numCity);$col2++;


            if($col2 == 'C'){$col2 = 'A';}
            $row2++;
        endforeach;

        $col3 = 'C';
        $row3 = 7;

        $col4 = 'A';
        $row4 = 7;



//functional
       foreach ($distributionMSWDOall as $distributionMSWDOalldata):
            $province = $distributionMSWDOalldata->prov_name;
            $numFunc = $distributionMSWDOalldata->Functional;
            $numFFunc = $distributionMSWDOalldata->FullyFunctional;
            $numPFunc = $distributionMSWDOalldata->PartiallyFunctional;

            for ($counter = 1; $counter <= $noofprov->numProv; $counter++ )
            {
                $prevRegion = $objPHPExcel->getActiveSheet()->getCell($col4.$row4)->getValue();
                $row4++;
                if ($prevRegion == $province)
                {
                    $objPHPExcel->getActiveSheet()->setCellValue($col3.$row3, $numPFunc);$col3++;
                    $objPHPExcel->getActiveSheet()->setCellValue($col3.$row3, $numFFunc);$col3++;
                    $objPHPExcel->getActiveSheet()->setCellValue($col3.$row3, $numFunc);$col3++;
                   break;
                }
                else
                {
                    $row3++;
                }

            }
           if($col3 == 'F'){$col3 = 'C';}
           $row3 = 7;
           $row4 = 7;
        endforeach;
//    //border
        $objPHPExcel->getActiveSheet()->getStyle(
            'A1:' .
            $objPHPExcel->getActiveSheet()->getHighestColumn() .
            $objPHPExcel->getActiveSheet()->getHighestRow()
        )->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
// Rename worksheet (worksheet, not filename)
        $objPHPExcel->getActiveSheet()->setTitle('distributionMSWDOall');

// Set active sheet index to the first sheet, so Excel opens this as the first asheet
        $objPHPExcel->setActiveSheetIndex(0);

// Redirect output to a client’s web browser (Excel2007)
//clean the output buffer
        ob_end_clean();

//this is the header given from PHPExcel examples. but the output seems somewhat corrupted in some cases.
//header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
//so, we use this header instead.
//    $regionName = $this->reports_model->getRegionName($region);
        $filename = 'distributionMSWDOall.xlsx';
        header('Content-type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename='.$filename);
        header('Cache-Control: max-age=0');

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        $objWriter->save('php://output');
    }

    public function distributionofPSWDOFunctionalityregion(){

        $distributionofPSWDOFunctionalityregion = $this->reports_model->get_distributionofPSWDOFunctionalityregion();


// Create new PHPExcel object
        $objPHPExcel = new PHPExcel();

// Add some data

        $objPHPExcel->getActiveSheet()->setCellValue('B1','Distribution of PSWDO Functionality  by Region');
        //autosize column

//        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getStyle('B1')->getFill()->getStartColor()->setRGB('FF0000');
//        $objPHPExcel->getActiveSheet()->getDefaultRowDimension()->setRowHeight(-1);a
        $objPHPExcel->getActiveSheet()->getRowDimension(1)->setRowHeight(-1);
        $objPHPExcel->getActiveSheet()->getStyle('B1')->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->getStyle('B1')->getFont()->setSize(15);
        $objPHPExcel->getActiveSheet()->mergeCells('B1:D1');

        //Center text merge columns
        $objPHPExcel->getActiveSheet()->getStyle('B1')->getAlignment()->applyFromArray(
            array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,));

        $objPHPExcel->getActiveSheet()->setCellValue('A3', 'Region');
        $objPHPExcel->getActiveSheet()->getStyle('A3')->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->setCellValue('B3', 'Distribution of PSWDO Functionality by Region');
        $objPHPExcel->getActiveSheet()->mergeCells('A3:A5');
        $objPHPExcel->getActiveSheet()->mergeCells('B3:D3');
        $objPHPExcel->getActiveSheet()->mergeCells('B2:D2');
        $objPHPExcel->getActiveSheet()->mergeCells('B5:D5');
        //Center text merge columns
        $objPHPExcel->getActiveSheet()->getStyle('B3')->getAlignment()->applyFromArray(
            array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,));
        $objPHPExcel->getActiveSheet()->getStyle('A3')->getAlignment()->applyFromArray(
            array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,));

        $objPHPExcel->getActiveSheet()->getStyle('A3')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);

        $objPHPExcel->getActiveSheet()->mergeCells('B6:D6');
        $objPHPExcel->getActiveSheet()->freezePane('B6');
        //Header

        $objPHPExcel->getActiveSheet()->setCellValue('B4', 'Partially Functional');
        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getStyle('B4')->getAlignment()->applyFromArray(
            array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,));
        $objPHPExcel->getActiveSheet()->setCellValue('C4', 'Functional');
        $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getStyle('C4')->getAlignment()->applyFromArray(
            array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,));
        $objPHPExcel->getActiveSheet()->setCellValue('D4', 'Fully Functional');
        $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getStyle('D4')->getAlignment()->applyFromArray(
            array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,));
        $row2 = 7;
        $col2 = 'A';
//province list
        foreach ($distributionofPSWDOFunctionalityregion as $distributionofPSWDOFunctionalityregiondata):
            $region = $distributionofPSWDOFunctionalityregiondata->region_name;
            $PF = $distributionofPSWDOFunctionalityregiondata->PartiallyFunctional;
            $F = $distributionofPSWDOFunctionalityregiondata->Functional;
            $FF = $distributionofPSWDOFunctionalityregiondata->FullyFunctional;

            $objPHPExcel->getActiveSheet()->setCellValue($col2.$row2, $region);$col2++;
            $objPHPExcel->getActiveSheet()->setCellValue($col2.$row2, $PF);$col2++;
            $objPHPExcel->getActiveSheet()->setCellValue($col2.$row2, $F);$col2++;
            $objPHPExcel->getActiveSheet()->setCellValue($col2.$row2, $FF);


            if($col2 == 'D'){$col2 = 'A';}
            $row2++;
        endforeach;


//    //border
        $objPHPExcel->getActiveSheet()->getStyle(
            'A1:' .
            $objPHPExcel->getActiveSheet()->getHighestColumn() .
            $objPHPExcel->getActiveSheet()->getHighestRow()
        )->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
// Rename worksheet (worksheet, not filename)
        $objPHPExcel->getActiveSheet()->setTitle('DistributionPSWDObyRegion');

// Set active sheet index to the first sheet, so Excel opens this as the first asheet
        $objPHPExcel->setActiveSheetIndex(0);

// Redirect output to a client’s web browser (Excel2007)
//clean the output buffer
        ob_end_clean();

//this is the header given from PHPExcel examples. but the output seems somewhat corrupted in some cases.
//header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
//so, we use this header instead.
//    $regionName = $this->reports_model->getRegionName($region);
        $filename = 'Distribution of PSWDO Functionality by Region.xlsx';
        header('Content-type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename='.$filename);
        header('Cache-Control: max-age=0');

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        $objWriter->save('php://output');
    }
    public function distributionofCSWDOFunctionalityregion(){

        $distributionofCSWDOFunctionalityregion = $this->reports_model->get_distributionofCSWDOFunctionalityregion();


// Create new PHPExcel object
        $objPHPExcel = new PHPExcel();

// Add some data

        $objPHPExcel->getActiveSheet()->setCellValue('B1','Distribution of CSWDO Functionality  by Region');
        //autosize column

//        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getStyle('B1')->getFill()->getStartColor()->setRGB('FF0000');
//        $objPHPExcel->getActiveSheet()->getDefaultRowDimension()->setRowHeight(-1);a
        $objPHPExcel->getActiveSheet()->getRowDimension(1)->setRowHeight(-1);
        $objPHPExcel->getActiveSheet()->getStyle('B1')->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->getStyle('B1')->getFont()->setSize(15);
        $objPHPExcel->getActiveSheet()->mergeCells('B1:D1');

        //Center text merge columns
        $objPHPExcel->getActiveSheet()->getStyle('B1')->getAlignment()->applyFromArray(
            array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,));

        $objPHPExcel->getActiveSheet()->setCellValue('A3', 'Region');
        $objPHPExcel->getActiveSheet()->getStyle('A3')->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->setCellValue('B3', 'Distribution of CSWDO Functionality by Region');
        $objPHPExcel->getActiveSheet()->mergeCells('A3:A5');
        $objPHPExcel->getActiveSheet()->mergeCells('B3:D3');
        $objPHPExcel->getActiveSheet()->mergeCells('B2:D2');
        $objPHPExcel->getActiveSheet()->mergeCells('B5:D5');
        //Center text merge columns
        $objPHPExcel->getActiveSheet()->getStyle('B3')->getAlignment()->applyFromArray(
            array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,));
        $objPHPExcel->getActiveSheet()->getStyle('A3')->getAlignment()->applyFromArray(
            array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,));

        $objPHPExcel->getActiveSheet()->getStyle('A3')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);

        $objPHPExcel->getActiveSheet()->mergeCells('B6:D6');
        $objPHPExcel->getActiveSheet()->freezePane('B6');
        //Header

        $objPHPExcel->getActiveSheet()->setCellValue('B4', 'Partially Functional');
        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getStyle('B4')->getAlignment()->applyFromArray(
            array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,));
        $objPHPExcel->getActiveSheet()->setCellValue('C4', 'Functional');
        $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getStyle('C4')->getAlignment()->applyFromArray(
            array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,));
        $objPHPExcel->getActiveSheet()->setCellValue('D4', 'Fully Functional');
        $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getStyle('D4')->getAlignment()->applyFromArray(
            array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,));
        $row2 = 7;
        $col2 = 'A';
//province list
        foreach ($distributionofCSWDOFunctionalityregion as $distributionofCSWDOFunctionalityregiondata):
            $region = $distributionofCSWDOFunctionalityregiondata->region_name;
            $PF = $distributionofCSWDOFunctionalityregiondata->PartiallyFunctional;
            $F = $distributionofCSWDOFunctionalityregiondata->Functional;
            $FF = $distributionofCSWDOFunctionalityregiondata->FullyFunctional;

            $objPHPExcel->getActiveSheet()->setCellValue($col2.$row2, $region);$col2++;
            $objPHPExcel->getActiveSheet()->setCellValue($col2.$row2, $PF);$col2++;
            $objPHPExcel->getActiveSheet()->setCellValue($col2.$row2, $F);$col2++;
            $objPHPExcel->getActiveSheet()->setCellValue($col2.$row2, $FF);


            if($col2 == 'D'){$col2 = 'A';}
            $row2++;
        endforeach;


//    //border
        $objPHPExcel->getActiveSheet()->getStyle(
            'A1:' .
            $objPHPExcel->getActiveSheet()->getHighestColumn() .
            $objPHPExcel->getActiveSheet()->getHighestRow()
        )->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
// Rename worksheet (worksheet, not filename)
        $objPHPExcel->getActiveSheet()->setTitle('DistributionCSWDObyRegion');

// Set active sheet index to the first sheet, so Excel opens this as the first asheet
        $objPHPExcel->setActiveSheetIndex(0);

// Redirect output to a client’s web browser (Excel2007)
//clean the output buffer
        ob_end_clean();

//this is the header given from PHPExcel examples. but the output seems somewhat corrupted in some cases.
//header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
//so, we use this header instead.
//    $regionName = $this->reports_model->getRegionName($region);
        $filename = 'Distribution of CSWDO Functionality by Region.xlsx';
        header('Content-type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename='.$filename);
        header('Cache-Control: max-age=0');

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        $objWriter->save('php://output');
    }
    public function distributionofMSWDOFunctionalityregion(){

        $distributionofMSWDOFunctionalityregion = $this->reports_model->get_distributionofMSWDOFunctionalityregion();


// Create new PHPExcel object
        $objPHPExcel = new PHPExcel();

// Add some data

        $objPHPExcel->getActiveSheet()->setCellValue('B1','Distribution of MSWDO Functionality  by Region');
        //autosize column

//        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getStyle('B1')->getFill()->getStartColor()->setRGB('FF0000');
//        $objPHPExcel->getActiveSheet()->getDefaultRowDimension()->setRowHeight(-1);a
        $objPHPExcel->getActiveSheet()->getRowDimension(1)->setRowHeight(-1);
        $objPHPExcel->getActiveSheet()->getStyle('B1')->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->getStyle('B1')->getFont()->setSize(15);
        $objPHPExcel->getActiveSheet()->mergeCells('B1:D1');

        //Center text merge columns
        $objPHPExcel->getActiveSheet()->getStyle('B1')->getAlignment()->applyFromArray(
            array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,));

        $objPHPExcel->getActiveSheet()->setCellValue('A3', 'Region');
        $objPHPExcel->getActiveSheet()->getStyle('A3')->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->setCellValue('B3', 'Distribution of MSWDO Functionality by Region');
        $objPHPExcel->getActiveSheet()->mergeCells('A3:A5');
        $objPHPExcel->getActiveSheet()->mergeCells('B3:D3');
        $objPHPExcel->getActiveSheet()->mergeCells('B2:D2');
        $objPHPExcel->getActiveSheet()->mergeCells('B5:D5');
        //Center text merge columns
        $objPHPExcel->getActiveSheet()->getStyle('B3')->getAlignment()->applyFromArray(
            array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,));
        $objPHPExcel->getActiveSheet()->getStyle('A3')->getAlignment()->applyFromArray(
            array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,));

        $objPHPExcel->getActiveSheet()->getStyle('A3')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);

        $objPHPExcel->getActiveSheet()->mergeCells('B6:D6');
        $objPHPExcel->getActiveSheet()->freezePane('B6');
        //Header

        $objPHPExcel->getActiveSheet()->setCellValue('B4', 'Partially Functional');
        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getStyle('B4')->getAlignment()->applyFromArray(
            array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,));
        $objPHPExcel->getActiveSheet()->setCellValue('C4', 'Functional');
        $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getStyle('C4')->getAlignment()->applyFromArray(
            array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,));
        $objPHPExcel->getActiveSheet()->setCellValue('D4', 'Fully Functional');
        $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getStyle('D4')->getAlignment()->applyFromArray(
            array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,));
        $row2 = 7;
        $col2 = 'A';
//province list
        foreach ($distributionofMSWDOFunctionalityregion as $distributionofMSWDOFunctionalityregiondata):
            $region = $distributionofMSWDOFunctionalityregiondata->region_name;
            $PF = $distributionofMSWDOFunctionalityregiondata->PartiallyFunctional;
            $F = $distributionofMSWDOFunctionalityregiondata->Functional;
            $FF = $distributionofMSWDOFunctionalityregiondata->FullyFunctional;

            $objPHPExcel->getActiveSheet()->setCellValue($col2.$row2, $region);$col2++;
            $objPHPExcel->getActiveSheet()->setCellValue($col2.$row2, $PF);$col2++;
            $objPHPExcel->getActiveSheet()->setCellValue($col2.$row2, $F);$col2++;
            $objPHPExcel->getActiveSheet()->setCellValue($col2.$row2, $FF);


            if($col2 == 'D'){$col2 = 'A';}
            $row2++;
        endforeach;


//    //border
        $objPHPExcel->getActiveSheet()->getStyle(
            'A1:' .
            $objPHPExcel->getActiveSheet()->getHighestColumn() .
            $objPHPExcel->getActiveSheet()->getHighestRow()
        )->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
// Rename worksheet (worksheet, not filename)
        $objPHPExcel->getActiveSheet()->setTitle('DistributionMSWDObyRegion');

// Set active sheet index to the first sheet, so Excel opens this as the first asheet
        $objPHPExcel->setActiveSheetIndex(0);

// Redirect output to a client’s web browser (Excel2007)
//clean the output buffer
        ob_end_clean();

//this is the header given from PHPExcel examples. but the output seems somewhat corrupted in some cases.
//header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
//so, we use this header instead.
//    $regionName = $this->reports_model->getRegionName($region);
        $filename = 'Distribution of MSWDO Functionality by Region.xlsx';
        header('Content-type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename='.$filename);
        header('Cache-Control: max-age=0');

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        $objWriter->save('php://output');
    }

    public function avePSWDObudgetprevyearbyregion(){

        $avePSWDObudgetprevyearbyregion = $this->reports_model->get_avePSWDObudgetprevyearbyregion();


// Create new PHPExcel object
        $objPHPExcel = new PHPExcel();

// Add some data

        $objPHPExcel->getActiveSheet()->setCellValue('B1',' Average PSWDO budget allocation (previous year) per sector, by region');
        //autosize column

//        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getStyle('B1')->getFill()->getStartColor()->setRGB('FF0000');
//        $objPHPExcel->getActiveSheet()->getDefaultRowDimension()->setRowHeight(-1);a
        $objPHPExcel->getActiveSheet()->getRowDimension(1)->setRowHeight(-1);
        $objPHPExcel->getActiveSheet()->getStyle('B1')->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->getStyle('B1')->getFont()->setSize(15);
        $objPHPExcel->getActiveSheet()->mergeCells('B1:H1');

        //Center text merge columns
        $objPHPExcel->getActiveSheet()->getStyle('B1')->getAlignment()->applyFromArray(
            array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,));

        $objPHPExcel->getActiveSheet()->setCellValue('A3', 'Region');
        $objPHPExcel->getActiveSheet()->getStyle('A3')->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->setCellValue('B3', ' Average PSWDO budget allocation (previous year) per sector, by region');
        $objPHPExcel->getActiveSheet()->mergeCells('A3:A5');
        $objPHPExcel->getActiveSheet()->mergeCells('B3:H3');
        $objPHPExcel->getActiveSheet()->mergeCells('B2:H2');
        $objPHPExcel->getActiveSheet()->mergeCells('B5:H5');
        //Center text merge columns
        $objPHPExcel->getActiveSheet()->getStyle('B3')->getAlignment()->applyFromArray(
            array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,));
        $objPHPExcel->getActiveSheet()->getStyle('A3')->getAlignment()->applyFromArray(
            array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,));

        $objPHPExcel->getActiveSheet()->getStyle('A3')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);

        $objPHPExcel->getActiveSheet()->mergeCells('B6:H6');
        $objPHPExcel->getActiveSheet()->freezePane('B6');
        //Header

        $objPHPExcel->getActiveSheet()->setCellValue('B4', 'Children');
        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getStyle('B4')->getAlignment()->applyFromArray(
            array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,));
        $objPHPExcel->getActiveSheet()->setCellValue('C4', 'Youth');
        $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getStyle('C4')->getAlignment()->applyFromArray(
            array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,));
        $objPHPExcel->getActiveSheet()->setCellValue('D4', 'Women');
        $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getStyle('D4')->getAlignment()->applyFromArray(
            array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,));
        $objPHPExcel->getActiveSheet()->setCellValue('E4', 'Family and Community');
        $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getStyle('E4')->getAlignment()->applyFromArray(
            array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,));
        $objPHPExcel->getActiveSheet()->setCellValue('F4', 'Senior Citizen');
        $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getStyle('F4')->getAlignment()->applyFromArray(
            array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,));
        $objPHPExcel->getActiveSheet()->setCellValue('G4', 'PWD');
        $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getStyle('G4')->getAlignment()->applyFromArray(
            array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,));
        $objPHPExcel->getActiveSheet()->setCellValue('H4', 'IDP');
        $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getStyle('H4')->getAlignment()->applyFromArray(
            array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,));
        $row2 = 7;
        $col2 = 'A';
//province list
        foreach ($avePSWDObudgetprevyearbyregion as $avePSWDObudgetprevyearbyregiondata):
            $region = $avePSWDObudgetprevyearbyregiondata->region_name;

            $Children = $avePSWDObudgetprevyearbyregiondata->Children;
            $Youth = $avePSWDObudgetprevyearbyregiondata->Youth;
            $Women = $avePSWDObudgetprevyearbyregiondata->Women;
            $FamilyandCommunity = $avePSWDObudgetprevyearbyregiondata->FamilyandCommunity;
            $SeniorCitizen = $avePSWDObudgetprevyearbyregiondata->SeniorCitizen;
            $PWD = $avePSWDObudgetprevyearbyregiondata->PWD;
            $IDP = $avePSWDObudgetprevyearbyregiondata->IDP;

            $objPHPExcel->getActiveSheet()->setCellValue($col2.$row2, $region);$col2++;
            $objPHPExcel->getActiveSheet()->setCellValue($col2.$row2, $Children);$col2++;
            $objPHPExcel->getActiveSheet()->setCellValue($col2.$row2, $Youth);$col2++;
            $objPHPExcel->getActiveSheet()->setCellValue($col2.$row2, $Women);$col2++;
            $objPHPExcel->getActiveSheet()->setCellValue($col2.$row2, $FamilyandCommunity);$col2++;
            $objPHPExcel->getActiveSheet()->setCellValue($col2.$row2, $SeniorCitizen);$col2++;
            $objPHPExcel->getActiveSheet()->setCellValue($col2.$row2, $PWD);$col2++;
            $objPHPExcel->getActiveSheet()->setCellValue($col2.$row2, $IDP);


            if($col2 == 'H'){$col2 = 'A';}
            $row2++;
        endforeach;


//    //border
        $objPHPExcel->getActiveSheet()->getStyle(
            'A1:' .
            $objPHPExcel->getActiveSheet()->getHighestColumn() .
            $objPHPExcel->getActiveSheet()->getHighestRow()
        )->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
// Rename worksheet (worksheet, not filename)
        $objPHPExcel->getActiveSheet()->setTitle('AveragePSWDObudgetallocation');

// Set active sheet index to the first sheet, so Excel opens this as the first asheet
        $objPHPExcel->setActiveSheetIndex(0);

// Redirect output to a client’s web browser (Excel2007)
//clean the output buffer
        ob_end_clean();

//this is the header given from PHPExcel examples. but the output seems somewhat corrupted in some cases.
//header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
//so, we use this header instead.
//    $regionName = $this->reports_model->getRegionName($region);
        $filename = 'avePSWDObudgetprevyearbyregion.xlsx';
        header('Content-type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename='.$filename);
        header('Cache-Control: max-age=0');

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        $objWriter->save('php://output');
    }
    public function aveCSWDObudgetprevyearbyregion(){

    $aveCSWDObudgetprevyearbyregion = $this->reports_model->get_aveCSWDObudgetprevyearbyregion();


// Create new PHPExcel object
    $objPHPExcel = new PHPExcel();

// Add some data

    $objPHPExcel->getActiveSheet()->setCellValue('B1',' Average CSWDO budget allocation (previous year) per sector, by region');
    //autosize column

//        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
    $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
    $objPHPExcel->getActiveSheet()->getStyle('B1')->getFill()->getStartColor()->setRGB('FF0000');
//        $objPHPExcel->getActiveSheet()->getDefaultRowDimension()->setRowHeight(-1);a
    $objPHPExcel->getActiveSheet()->getRowDimension(1)->setRowHeight(-1);
    $objPHPExcel->getActiveSheet()->getStyle('B1')->getFont()->setBold(true);
    $objPHPExcel->getActiveSheet()->getStyle('B1')->getFont()->setSize(15);
    $objPHPExcel->getActiveSheet()->mergeCells('B1:H1');

    //Center text merge columns
    $objPHPExcel->getActiveSheet()->getStyle('B1')->getAlignment()->applyFromArray(
        array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,));

    $objPHPExcel->getActiveSheet()->setCellValue('A3', 'Region');
    $objPHPExcel->getActiveSheet()->getStyle('A3')->getFont()->setBold(true);
    $objPHPExcel->getActiveSheet()->setCellValue('B3', ' Average CSWDO budget allocation (previous year) per sector, by region');
    $objPHPExcel->getActiveSheet()->mergeCells('A3:A5');
    $objPHPExcel->getActiveSheet()->mergeCells('B3:H3');
    $objPHPExcel->getActiveSheet()->mergeCells('B2:H2');
    $objPHPExcel->getActiveSheet()->mergeCells('B5:H5');
    //Center text merge columns
    $objPHPExcel->getActiveSheet()->getStyle('B3')->getAlignment()->applyFromArray(
        array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,));
    $objPHPExcel->getActiveSheet()->getStyle('A3')->getAlignment()->applyFromArray(
        array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,));

    $objPHPExcel->getActiveSheet()->getStyle('A3')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);

    $objPHPExcel->getActiveSheet()->mergeCells('B6:H6');
    $objPHPExcel->getActiveSheet()->freezePane('B6');
    //Header

    $objPHPExcel->getActiveSheet()->setCellValue('B4', 'Children');
    $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
    $objPHPExcel->getActiveSheet()->getStyle('B4')->getAlignment()->applyFromArray(
        array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,));
    $objPHPExcel->getActiveSheet()->setCellValue('C4', 'Youth');
    $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
    $objPHPExcel->getActiveSheet()->getStyle('C4')->getAlignment()->applyFromArray(
        array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,));
    $objPHPExcel->getActiveSheet()->setCellValue('D4', 'Women');
    $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
    $objPHPExcel->getActiveSheet()->getStyle('D4')->getAlignment()->applyFromArray(
        array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,));
    $objPHPExcel->getActiveSheet()->setCellValue('E4', 'Family and Community');
    $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);
    $objPHPExcel->getActiveSheet()->getStyle('E4')->getAlignment()->applyFromArray(
        array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,));
    $objPHPExcel->getActiveSheet()->setCellValue('F4', 'Senior Citizen');
    $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setAutoSize(true);
    $objPHPExcel->getActiveSheet()->getStyle('F4')->getAlignment()->applyFromArray(
        array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,));
    $objPHPExcel->getActiveSheet()->setCellValue('G4', 'PWD');
    $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setAutoSize(true);
    $objPHPExcel->getActiveSheet()->getStyle('G4')->getAlignment()->applyFromArray(
        array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,));
    $objPHPExcel->getActiveSheet()->setCellValue('H4', 'IDP');
    $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setAutoSize(true);
    $objPHPExcel->getActiveSheet()->getStyle('H4')->getAlignment()->applyFromArray(
        array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,));
    $row2 = 7;
    $col2 = 'A';
//province list
    foreach ($aveCSWDObudgetprevyearbyregion as $aveCSWDObudgetprevyearbyregiondata):
        $region = $aveCSWDObudgetprevyearbyregiondata->region_name;

        $Children = $aveCSWDObudgetprevyearbyregiondata->Children;
        $Youth = $aveCSWDObudgetprevyearbyregiondata->Youth;
        $Women = $aveCSWDObudgetprevyearbyregiondata->Women;
        $FamilyandCommunity = $aveCSWDObudgetprevyearbyregiondata->FamilyandCommunity;
        $SeniorCitizen = $aveCSWDObudgetprevyearbyregiondata->SeniorCitizen;
        $PWD = $aveCSWDObudgetprevyearbyregiondata->PWD;
        $IDP = $aveCSWDObudgetprevyearbyregiondata->IDP;

        $objPHPExcel->getActiveSheet()->setCellValue($col2.$row2, $region);$col2++;
        $objPHPExcel->getActiveSheet()->setCellValue($col2.$row2, $Children);$col2++;
        $objPHPExcel->getActiveSheet()->setCellValue($col2.$row2, $Youth);$col2++;
        $objPHPExcel->getActiveSheet()->setCellValue($col2.$row2, $Women);$col2++;
        $objPHPExcel->getActiveSheet()->setCellValue($col2.$row2, $FamilyandCommunity);$col2++;
        $objPHPExcel->getActiveSheet()->setCellValue($col2.$row2, $SeniorCitizen);$col2++;
        $objPHPExcel->getActiveSheet()->setCellValue($col2.$row2, $PWD);$col2++;
        $objPHPExcel->getActiveSheet()->setCellValue($col2.$row2, $IDP);


        if($col2 == 'H'){$col2 = 'A';}
        $row2++;
    endforeach;


//    //border
    $objPHPExcel->getActiveSheet()->getStyle(
        'A1:' .
        $objPHPExcel->getActiveSheet()->getHighestColumn() .
        $objPHPExcel->getActiveSheet()->getHighestRow()
    )->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
// Rename worksheet (worksheet, not filename)
    $objPHPExcel->getActiveSheet()->setTitle('AverageCSWDObudgetallocation');

// Set active sheet index to the first sheet, so Excel opens this as the first asheet
    $objPHPExcel->setActiveSheetIndex(0);

// Redirect output to a client’s web browser (Excel2007)
//clean the output buffer
    ob_end_clean();

//this is the header given from PHPExcel examples. but the output seems somewhat corrupted in some cases.
//header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
//so, we use this header instead.
//    $regionName = $this->reports_model->getRegionName($region);
    $filename = 'aveCSWDObudgetprevyearbyregion.xlsx';
    header('Content-type: application/vnd.ms-excel');
    header('Content-Disposition: attachment;filename='.$filename);
    header('Cache-Control: max-age=0');

    $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
    $objWriter->save('php://output');
}
    public function aveMSWDObudgetprevyearbyregion(){

        $aveMSWDObudgetprevyearbyregion = $this->reports_model->get_aveMSWDObudgetprevyearbyregion();


// Create new PHPExcel object
        $objPHPExcel = new PHPExcel();

// Add some data

        $objPHPExcel->getActiveSheet()->setCellValue('B1',' Average MSWDO budget allocation (previous year) per sector, by region');
        //autosize column

//        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getStyle('B1')->getFill()->getStartColor()->setRGB('FF0000');
//        $objPHPExcel->getActiveSheet()->getDefaultRowDimension()->setRowHeight(-1);a
        $objPHPExcel->getActiveSheet()->getRowDimension(1)->setRowHeight(-1);
        $objPHPExcel->getActiveSheet()->getStyle('B1')->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->getStyle('B1')->getFont()->setSize(15);
        $objPHPExcel->getActiveSheet()->mergeCells('B1:H1');

        //Center text merge columns
        $objPHPExcel->getActiveSheet()->getStyle('B1')->getAlignment()->applyFromArray(
            array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,));

        $objPHPExcel->getActiveSheet()->setCellValue('A3', 'Region');
        $objPHPExcel->getActiveSheet()->getStyle('A3')->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->setCellValue('B3', ' Average MSWDO budget allocation (previous year) per sector, by region');
        $objPHPExcel->getActiveSheet()->mergeCells('A3:A5');
        $objPHPExcel->getActiveSheet()->mergeCells('B3:H3');
        $objPHPExcel->getActiveSheet()->mergeCells('B2:H2');
        $objPHPExcel->getActiveSheet()->mergeCells('B5:H5');
        //Center text merge columns
        $objPHPExcel->getActiveSheet()->getStyle('B3')->getAlignment()->applyFromArray(
            array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,));
        $objPHPExcel->getActiveSheet()->getStyle('A3')->getAlignment()->applyFromArray(
            array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,));

        $objPHPExcel->getActiveSheet()->getStyle('A3')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);

        $objPHPExcel->getActiveSheet()->mergeCells('B6:H6');
        $objPHPExcel->getActiveSheet()->freezePane('B6');
        //Header

        $objPHPExcel->getActiveSheet()->setCellValue('B4', 'Children');
        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getStyle('B4')->getAlignment()->applyFromArray(
            array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,));
        $objPHPExcel->getActiveSheet()->setCellValue('C4', 'Youth');
        $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getStyle('C4')->getAlignment()->applyFromArray(
            array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,));
        $objPHPExcel->getActiveSheet()->setCellValue('D4', 'Women');
        $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getStyle('D4')->getAlignment()->applyFromArray(
            array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,));
        $objPHPExcel->getActiveSheet()->setCellValue('E4', 'Family and Community');
        $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getStyle('E4')->getAlignment()->applyFromArray(
            array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,));
        $objPHPExcel->getActiveSheet()->setCellValue('F4', 'Senior Citizen');
        $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getStyle('F4')->getAlignment()->applyFromArray(
            array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,));
        $objPHPExcel->getActiveSheet()->setCellValue('G4', 'PWD');
        $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getStyle('G4')->getAlignment()->applyFromArray(
            array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,));
        $objPHPExcel->getActiveSheet()->setCellValue('H4', 'IDP');
        $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getStyle('H4')->getAlignment()->applyFromArray(
            array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,));
        $row2 = 7;
        $col2 = 'A';
//province list
        foreach ($aveMSWDObudgetprevyearbyregion as $aveMSWDObudgetprevyearbyregiondata):
            $region = $aveMSWDObudgetprevyearbyregiondata->region_name;

            $Children = $aveMSWDObudgetprevyearbyregiondata->Children;
            $Youth = $aveMSWDObudgetprevyearbyregiondata->Youth;
            $Women = $aveMSWDObudgetprevyearbyregiondata->Women;
            $FamilyandCommunity = $aveMSWDObudgetprevyearbyregiondata->FamilyandCommunity;
            $SeniorCitizen = $aveMSWDObudgetprevyearbyregiondata->SeniorCitizen;
            $PWD = $aveMSWDObudgetprevyearbyregiondata->PWD;
            $IDP = $aveMSWDObudgetprevyearbyregiondata->IDP;

            $objPHPExcel->getActiveSheet()->setCellValue($col2.$row2, $region);$col2++;
            $objPHPExcel->getActiveSheet()->setCellValue($col2.$row2, $Children);$col2++;
            $objPHPExcel->getActiveSheet()->setCellValue($col2.$row2, $Youth);$col2++;
            $objPHPExcel->getActiveSheet()->setCellValue($col2.$row2, $Women);$col2++;
            $objPHPExcel->getActiveSheet()->setCellValue($col2.$row2, $FamilyandCommunity);$col2++;
            $objPHPExcel->getActiveSheet()->setCellValue($col2.$row2, $SeniorCitizen);$col2++;
            $objPHPExcel->getActiveSheet()->setCellValue($col2.$row2, $PWD);$col2++;
            $objPHPExcel->getActiveSheet()->setCellValue($col2.$row2, $IDP);


            if($col2 == 'H'){$col2 = 'A';}
            $row2++;
        endforeach;


//    //border
        $objPHPExcel->getActiveSheet()->getStyle(
            'A1:' .
            $objPHPExcel->getActiveSheet()->getHighestColumn() .
            $objPHPExcel->getActiveSheet()->getHighestRow()
        )->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
// Rename worksheet (worksheet, not filename)
        $objPHPExcel->getActiveSheet()->setTitle('AverageMSWDObudgetallocation');

// Set active sheet index to the first sheet, so Excel opens this as the first asheet
        $objPHPExcel->setActiveSheetIndex(0);

// Redirect output to a client’s web browser (Excel2007)
//clean the output buffer
        ob_end_clean();

//this is the header given from PHPExcel examples. but the output seems somewhat corrupted in some cases.
//header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
//so, we use this header instead.
//    $regionName = $this->reports_model->getRegionName($region);
        $filename = 'aveMSWDObudgetprevyearbyregion.xlsx';
        header('Content-type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename='.$filename);
        header('Cache-Control: max-age=0');

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        $objWriter->save('php://output');
    }
//notsogood
    public function LSWDObudgetpreviousbyregionbysector($sector){

        $LSWDObudgetprevyearbyregionpersector = $this->reports_model->get_LSWDObudgetprevyearbyregionpersector($sector);


        $budgetallocation_model = new budgetallocation_model();

        $sectorName = $budgetallocation_model->sectorName($sector);
        $sName = $sectorName->sector_name;
// Create new PHPExcel object
        $objPHPExcel = new PHPExcel();

// Add some data

        $objPHPExcel->getActiveSheet()->setCellValue('B1','Distribution LSWDO with budget allocation (previous year) by sector by Region');
        //autosize column

//        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getStyle('B1')->getFill()->getStartColor()->setRGB('FF0000');
//        $objPHPExcel->getActiveSheet()->getDefaultRowDimension()->setRowHeight(-1);a
        $objPHPExcel->getActiveSheet()->getRowDimension(1)->setRowHeight(-1);
        $objPHPExcel->getActiveSheet()->getStyle('B1')->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->getStyle('B1')->getFont()->setSize(15);
        $objPHPExcel->getActiveSheet()->mergeCells('B1:F1');

        //Center text merge columns
        $objPHPExcel->getActiveSheet()->getStyle('B1')->getAlignment()->applyFromArray(
            array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,));

        $objPHPExcel->getActiveSheet()->setCellValue('A3', 'Region');
        $objPHPExcel->getActiveSheet()->getStyle('A3')->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->setCellValue('B3', ''.$sName.'');
        $objPHPExcel->getActiveSheet()->mergeCells('A3:A5');
        $objPHPExcel->getActiveSheet()->mergeCells('B3:F3');
        $objPHPExcel->getActiveSheet()->mergeCells('B2:F2');
        $objPHPExcel->getActiveSheet()->mergeCells('B5:F5');
        //Center text merge columns
        $objPHPExcel->getActiveSheet()->getStyle('B3')->getAlignment()->applyFromArray(
            array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,));
        $objPHPExcel->getActiveSheet()->getStyle('A3')->getAlignment()->applyFromArray(
            array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,));

        $objPHPExcel->getActiveSheet()->getStyle('A3')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);

        $objPHPExcel->getActiveSheet()->mergeCells('B6:e6');
        $objPHPExcel->getActiveSheet()->freezePane('B6');
        //Header
        $objPHPExcel->getActiveSheet()->setCellValue('B4', 'PSWDO');
        $objPHPExcel->getActiveSheet()->getStyle('B4')->getAlignment()->applyFromArray(
            array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,));
        $objPHPExcel->getActiveSheet()->setCellValue('C4', 'CSWDO');
        $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getStyle('C4')->getAlignment()->applyFromArray(
            array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,));
        $objPHPExcel->getActiveSheet()->setCellValue('D4', 'MSWDO');
        $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getStyle('D4')->getAlignment()->applyFromArray(
            array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,));
        $objPHPExcel->getActiveSheet()->setCellValue('E4', 'Total');
        $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getStyle('e4')->getAlignment()->applyFromArray(
            array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,));
        $objPHPExcel->getActiveSheet()->setCellValue('F4', 'Percent');
        $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getStyle('F4')->getAlignment()->applyFromArray(
            array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,));
        $row2 = 7;
        $col2 = 'A';
//province list
        foreach ($LSWDObudgetprevyearbyregionpersector as $LSWDObudgetprevyearbyregionpersectordata):
            $region = $LSWDObudgetprevyearbyregionpersectordata->region_name;
            $PSWDO = $LSWDObudgetprevyearbyregionpersectordata->PSWDO;
            $CSWDO = $LSWDObudgetprevyearbyregionpersectordata->CSWDO;
            $MSWDO = $LSWDObudgetprevyearbyregionpersectordata->MSWDO;
            $TOTAL = $LSWDObudgetprevyearbyregionpersectordata->Total;

            $objPHPExcel->getActiveSheet()->setCellValue($col2.$row2, $region);$col2++;
            $objPHPExcel->getActiveSheet()->setCellValue($col2.$row2, $PSWDO);$col2++;
            $objPHPExcel->getActiveSheet()->setCellValue($col2.$row2, $CSWDO);$col2++;
            $objPHPExcel->getActiveSheet()->setCellValue($col2.$row2, $MSWDO);$col2++;
            $objPHPExcel->getActiveSheet()->setCellValue($col2.$row2, $TOTAL);


            if($col2 == 'E'){$col2 = 'A';}
            $row2++;
        endforeach;
        $col3 = $col2;
        $row3 = $row2 -1;
        $counter = $row2 - 7;
        $objPHPExcel->getActiveSheet()->setCellValue($col3.$row2, 'Total');
        $col3++;
        $col3++;
        $col3++;
        $col3++;
        $objPHPExcel->getActiveSheet()->setCellValue($col3.$row2, '=SUM('.$col3.'7:'.$col3.$row3.')');
        $percrow = 7;
        $perccol = 'F';
        $totrow = 7;
        $totcol = 'E';
        for ($headcount = 0;$headcount < $counter;$headcount++)
        {
            $objPHPExcel->getActiveSheet()->setCellValue($perccol.$percrow,"=".$totcol.$totrow."/".$col3.$row2);
            $objPHPExcel->getActiveSheet()->getStyle($perccol.$percrow)
                ->getNumberFormat()->applyFromArray(
                    array(
                        'code' => PHPExcel_Style_NumberFormat::FORMAT_PERCENTAGE_00
                    )
                );
            $percrow++;
            $totrow++;
        }


//    //border
        $objPHPExcel->getActiveSheet()->getStyle(
            'A1:' .
            $objPHPExcel->getActiveSheet()->getHighestColumn() .
            $objPHPExcel->getActiveSheet()->getHighestRow()
        )->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
// Rename worksheet (worksheet, not filename)
        $objPHPExcel->getActiveSheet()->setTitle('DistributionLSWDObyRegion');

// Set active sheet index to the first sheet, so Excel opens this as the first asheet
        $objPHPExcel->setActiveSheetIndex(0);

// Redirect output to a client’s web browser (Excel2007)
//clean the output buffer
        ob_end_clean();

//this is the header given from PHPExcel examples. but the output seems somewhat corrupted in some cases.
//header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
//so, we use this header instead.
//    $regionName = $this->reports_model->getRegionName($region);
        $filename = 'Distribution LSWDO by Region.xlsx';
        header('Content-type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename='.$filename);
        header('Cache-Control: max-age=0');

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        $objWriter->save('php://output');
    }

    public function avePSWDObudgetpresentyearbyregion(){

        $avePSWDObudgetpreyearbyregion = $this->reports_model->get_avePSWDObudgetpresentyearbyregion();


// Create new PHPExcel object
        $objPHPExcel = new PHPExcel();

// Add some data

        $objPHPExcel->getActiveSheet()->setCellValue('B1',' Average PSWDO budget allocation (present year) per sector, by region');
        //autosize column

//        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getStyle('B1')->getFill()->getStartColor()->setRGB('FF0000');
//        $objPHPExcel->getActiveSheet()->getDefaultRowDimension()->setRowHeight(-1);a
        $objPHPExcel->getActiveSheet()->getRowDimension(1)->setRowHeight(-1);
        $objPHPExcel->getActiveSheet()->getStyle('B1')->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->getStyle('B1')->getFont()->setSize(15);
        $objPHPExcel->getActiveSheet()->mergeCells('B1:H1');

        //Center text merge columns
        $objPHPExcel->getActiveSheet()->getStyle('B1')->getAlignment()->applyFromArray(
            array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,));

        $objPHPExcel->getActiveSheet()->setCellValue('A3', 'Region');
        $objPHPExcel->getActiveSheet()->getStyle('A3')->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->setCellValue('B3', ' Average PSWDO budget allocation (present year) per sector, by region');
        $objPHPExcel->getActiveSheet()->mergeCells('A3:A5');
        $objPHPExcel->getActiveSheet()->mergeCells('B3:H3');
        $objPHPExcel->getActiveSheet()->mergeCells('B2:H2');
        $objPHPExcel->getActiveSheet()->mergeCells('B5:H5');
        //Center text merge columns
        $objPHPExcel->getActiveSheet()->getStyle('B3')->getAlignment()->applyFromArray(
            array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,));
        $objPHPExcel->getActiveSheet()->getStyle('A3')->getAlignment()->applyFromArray(
            array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,));

        $objPHPExcel->getActiveSheet()->getStyle('A3')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);

        $objPHPExcel->getActiveSheet()->mergeCells('B6:H6');
        $objPHPExcel->getActiveSheet()->freezePane('B6');
        //Header

        $objPHPExcel->getActiveSheet()->setCellValue('B4', 'Children');
        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getStyle('B4')->getAlignment()->applyFromArray(
            array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,));
        $objPHPExcel->getActiveSheet()->setCellValue('C4', 'Youth');
        $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getStyle('C4')->getAlignment()->applyFromArray(
            array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,));
        $objPHPExcel->getActiveSheet()->setCellValue('D4', 'Women');
        $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getStyle('D4')->getAlignment()->applyFromArray(
            array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,));
        $objPHPExcel->getActiveSheet()->setCellValue('E4', 'Family and Community');
        $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getStyle('E4')->getAlignment()->applyFromArray(
            array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,));
        $objPHPExcel->getActiveSheet()->setCellValue('F4', 'Senior Citizen');
        $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getStyle('F4')->getAlignment()->applyFromArray(
            array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,));
        $objPHPExcel->getActiveSheet()->setCellValue('G4', 'PWD');
        $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getStyle('G4')->getAlignment()->applyFromArray(
            array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,));
        $objPHPExcel->getActiveSheet()->setCellValue('H4', 'IDP');
        $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getStyle('H4')->getAlignment()->applyFromArray(
            array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,));
        $row2 = 7;
        $col2 = 'A';
//province list
        foreach ($avePSWDObudgetpreyearbyregion as $avePSWDObudgetpreyearbyregiondata):
            $region = $avePSWDObudgetpreyearbyregiondata->region_name;

            $Children = $avePSWDObudgetpreyearbyregiondata->Children;
            $Youth = $avePSWDObudgetpreyearbyregiondata->Youth;
            $Women = $avePSWDObudgetpreyearbyregiondata->Women;
            $FamilyandCommunity = $avePSWDObudgetpreyearbyregiondata->FamilyandCommunity;
            $SeniorCitizen = $avePSWDObudgetpreyearbyregiondata->SeniorCitizen;
            $PWD = $avePSWDObudgetpreyearbyregiondata->PWD;
            $IDP = $avePSWDObudgetpreyearbyregiondata->IDP;

            $objPHPExcel->getActiveSheet()->setCellValue($col2.$row2, $region);$col2++;
            $objPHPExcel->getActiveSheet()->setCellValue($col2.$row2, $Children);$col2++;
            $objPHPExcel->getActiveSheet()->setCellValue($col2.$row2, $Youth);$col2++;
            $objPHPExcel->getActiveSheet()->setCellValue($col2.$row2, $Women);$col2++;
            $objPHPExcel->getActiveSheet()->setCellValue($col2.$row2, $FamilyandCommunity);$col2++;
            $objPHPExcel->getActiveSheet()->setCellValue($col2.$row2, $SeniorCitizen);$col2++;
            $objPHPExcel->getActiveSheet()->setCellValue($col2.$row2, $PWD);$col2++;
            $objPHPExcel->getActiveSheet()->setCellValue($col2.$row2, $IDP);


            if($col2 == 'H'){$col2 = 'A';}
            $row2++;
        endforeach;


//    //border
        $objPHPExcel->getActiveSheet()->getStyle(
            'A1:' .
            $objPHPExcel->getActiveSheet()->getHighestColumn() .
            $objPHPExcel->getActiveSheet()->getHighestRow()
        )->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
// Rename worksheet (worksheet, not filename)
        $objPHPExcel->getActiveSheet()->setTitle('AveragePSWDObudgetallocation');

// Set active sheet index to the first sheet, so Excel opens this as the first asheet
        $objPHPExcel->setActiveSheetIndex(0);

// Redirect output to a client’s web browser (Excel2007)
//clean the output buffer
        ob_end_clean();

//this is the header given from PHPExcel examples. but the output seems somewhat corrupted in some cases.
//header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
//so, we use this header instead.
//    $regionName = $this->reports_model->getRegionName($region);
        $filename = 'avePSWDObudgetpreyearbyregion.xlsx';
        header('Content-type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename='.$filename);
        header('Cache-Control: max-age=0');

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        $objWriter->save('php://output');
    }
    public function aveCSWDObudgetpresentyearbyregion(){

        $aveCSWDObudgetpreyearbyregion = $this->reports_model->get_aveCSWDObudgetpresentyearbyregion();


// Create new PHPExcel object
        $objPHPExcel = new PHPExcel();

// Add some data

        $objPHPExcel->getActiveSheet()->setCellValue('B1',' Average CSWDO budget allocation (present year) per sector, by region');
        //autosize column

//        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getStyle('B1')->getFill()->getStartColor()->setRGB('FF0000');
//        $objPHPExcel->getActiveSheet()->getDefaultRowDimension()->setRowHeight(-1);a
        $objPHPExcel->getActiveSheet()->getRowDimension(1)->setRowHeight(-1);
        $objPHPExcel->getActiveSheet()->getStyle('B1')->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->getStyle('B1')->getFont()->setSize(15);
        $objPHPExcel->getActiveSheet()->mergeCells('B1:H1');

        //Center text merge columns
        $objPHPExcel->getActiveSheet()->getStyle('B1')->getAlignment()->applyFromArray(
            array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,));

        $objPHPExcel->getActiveSheet()->setCellValue('A3', 'Region');
        $objPHPExcel->getActiveSheet()->getStyle('A3')->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->setCellValue('B3', ' Average CSWDO budget allocation (present year) per sector, by region');
        $objPHPExcel->getActiveSheet()->mergeCells('A3:A5');
        $objPHPExcel->getActiveSheet()->mergeCells('B3:H3');
        $objPHPExcel->getActiveSheet()->mergeCells('B2:H2');
        $objPHPExcel->getActiveSheet()->mergeCells('B5:H5');
        //Center text merge columns
        $objPHPExcel->getActiveSheet()->getStyle('B3')->getAlignment()->applyFromArray(
            array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,));
        $objPHPExcel->getActiveSheet()->getStyle('A3')->getAlignment()->applyFromArray(
            array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,));

        $objPHPExcel->getActiveSheet()->getStyle('A3')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);

        $objPHPExcel->getActiveSheet()->mergeCells('B6:H6');
        $objPHPExcel->getActiveSheet()->freezePane('B6');
        //Header

        $objPHPExcel->getActiveSheet()->setCellValue('B4', 'Children');
        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getStyle('B4')->getAlignment()->applyFromArray(
            array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,));
        $objPHPExcel->getActiveSheet()->setCellValue('C4', 'Youth');
        $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getStyle('C4')->getAlignment()->applyFromArray(
            array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,));
        $objPHPExcel->getActiveSheet()->setCellValue('D4', 'Women');
        $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getStyle('D4')->getAlignment()->applyFromArray(
            array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,));
        $objPHPExcel->getActiveSheet()->setCellValue('E4', 'Family and Community');
        $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getStyle('E4')->getAlignment()->applyFromArray(
            array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,));
        $objPHPExcel->getActiveSheet()->setCellValue('F4', 'Senior Citizen');
        $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getStyle('F4')->getAlignment()->applyFromArray(
            array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,));
        $objPHPExcel->getActiveSheet()->setCellValue('G4', 'PWD');
        $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getStyle('G4')->getAlignment()->applyFromArray(
            array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,));
        $objPHPExcel->getActiveSheet()->setCellValue('H4', 'IDP');
        $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getStyle('H4')->getAlignment()->applyFromArray(
            array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,));
        $row2 = 7;
        $col2 = 'A';
//province list
        foreach ($aveCSWDObudgetpreyearbyregion as $aveCSWDObudgetpreyearbyregiondata):
            $region = $aveCSWDObudgetpreyearbyregiondata->region_name;

            $Children = $aveCSWDObudgetpreyearbyregiondata->Children;
            $Youth = $aveCSWDObudgetpreyearbyregiondata->Youth;
            $Women = $aveCSWDObudgetpreyearbyregiondata->Women;
            $FamilyandCommunity = $aveCSWDObudgetpreyearbyregiondata->FamilyandCommunity;
            $SeniorCitizen = $aveCSWDObudgetpreyearbyregiondata->SeniorCitizen;
            $PWD = $aveCSWDObudgetpreyearbyregiondata->PWD;
            $IDP = $aveCSWDObudgetpreyearbyregiondata->IDP;

            $objPHPExcel->getActiveSheet()->setCellValue($col2.$row2, $region);$col2++;
            $objPHPExcel->getActiveSheet()->setCellValue($col2.$row2, $Children);$col2++;
            $objPHPExcel->getActiveSheet()->setCellValue($col2.$row2, $Youth);$col2++;
            $objPHPExcel->getActiveSheet()->setCellValue($col2.$row2, $Women);$col2++;
            $objPHPExcel->getActiveSheet()->setCellValue($col2.$row2, $FamilyandCommunity);$col2++;
            $objPHPExcel->getActiveSheet()->setCellValue($col2.$row2, $SeniorCitizen);$col2++;
            $objPHPExcel->getActiveSheet()->setCellValue($col2.$row2, $PWD);$col2++;
            $objPHPExcel->getActiveSheet()->setCellValue($col2.$row2, $IDP);


            if($col2 == 'H'){$col2 = 'A';}
            $row2++;
        endforeach;


//    //border
        $objPHPExcel->getActiveSheet()->getStyle(
            'A1:' .
            $objPHPExcel->getActiveSheet()->getHighestColumn() .
            $objPHPExcel->getActiveSheet()->getHighestRow()
        )->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
// Rename worksheet (worksheet, not filename)
        $objPHPExcel->getActiveSheet()->setTitle('AverageCSWDObudgetallocation');

// Set active sheet index to the first sheet, so Excel opens this as the first asheet
        $objPHPExcel->setActiveSheetIndex(0);

// Redirect output to a client’s web browser (Excel2007)
//clean the output buffer
        ob_end_clean();

//this is the header given from PHPExcel examples. but the output seems somewhat corrupted in some cases.
//header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
//so, we use this header instead.
//    $regionName = $this->reports_model->getRegionName($region);
        $filename = 'aveCSWDObudgetpreyearbyregion.xlsx';
        header('Content-type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename='.$filename);
        header('Cache-Control: max-age=0');

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        $objWriter->save('php://output');
    }
    public function aveMSWDObudgetpresentyearbyregion(){

        $aveMSWDObudgetpreyearbyregion = $this->reports_model->get_aveMSWDObudgetpresentyearbyregion();


// Create new PHPExcel object
        $objPHPExcel = new PHPExcel();

// Add some data

        $objPHPExcel->getActiveSheet()->setCellValue('B1',' Average MSWDO budget allocation (present year) per sector, by region');
        //autosize column

//        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getStyle('B1')->getFill()->getStartColor()->setRGB('FF0000');
//        $objPHPExcel->getActiveSheet()->getDefaultRowDimension()->setRowHeight(-1);a
        $objPHPExcel->getActiveSheet()->getRowDimension(1)->setRowHeight(-1);
        $objPHPExcel->getActiveSheet()->getStyle('B1')->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->getStyle('B1')->getFont()->setSize(15);
        $objPHPExcel->getActiveSheet()->mergeCells('B1:H1');

        //Center text merge columns
        $objPHPExcel->getActiveSheet()->getStyle('B1')->getAlignment()->applyFromArray(
            array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,));

        $objPHPExcel->getActiveSheet()->setCellValue('A3', 'Region');
        $objPHPExcel->getActiveSheet()->getStyle('A3')->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->setCellValue('B3', ' Average MSWDO budget allocation (present year) per sector, by region');
        $objPHPExcel->getActiveSheet()->mergeCells('A3:A5');
        $objPHPExcel->getActiveSheet()->mergeCells('B3:H3');
        $objPHPExcel->getActiveSheet()->mergeCells('B2:H2');
        $objPHPExcel->getActiveSheet()->mergeCells('B5:H5');
        //Center text merge columns
        $objPHPExcel->getActiveSheet()->getStyle('B3')->getAlignment()->applyFromArray(
            array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,));
        $objPHPExcel->getActiveSheet()->getStyle('A3')->getAlignment()->applyFromArray(
            array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,));

        $objPHPExcel->getActiveSheet()->getStyle('A3')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);

        $objPHPExcel->getActiveSheet()->mergeCells('B6:H6');
        $objPHPExcel->getActiveSheet()->freezePane('B6');
        //Header

        $objPHPExcel->getActiveSheet()->setCellValue('B4', 'Children');
        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getStyle('B4')->getAlignment()->applyFromArray(
            array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,));
        $objPHPExcel->getActiveSheet()->setCellValue('C4', 'Youth');
        $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getStyle('C4')->getAlignment()->applyFromArray(
            array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,));
        $objPHPExcel->getActiveSheet()->setCellValue('D4', 'Women');
        $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getStyle('D4')->getAlignment()->applyFromArray(
            array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,));
        $objPHPExcel->getActiveSheet()->setCellValue('E4', 'Family and Community');
        $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getStyle('E4')->getAlignment()->applyFromArray(
            array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,));
        $objPHPExcel->getActiveSheet()->setCellValue('F4', 'Senior Citizen');
        $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getStyle('F4')->getAlignment()->applyFromArray(
            array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,));
        $objPHPExcel->getActiveSheet()->setCellValue('G4', 'PWD');
        $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getStyle('G4')->getAlignment()->applyFromArray(
            array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,));
        $objPHPExcel->getActiveSheet()->setCellValue('H4', 'IDP');
        $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getStyle('H4')->getAlignment()->applyFromArray(
            array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,));
        $row2 = 7;
        $col2 = 'A';
//province list
        foreach ($aveMSWDObudgetpreyearbyregion as $aveMSWDObudgetpreyearbyregiondata):
            $region = $aveMSWDObudgetpreyearbyregiondata->region_name;

            $Children = $aveMSWDObudgetpreyearbyregiondata->Children;
            $Youth = $aveMSWDObudgetpreyearbyregiondata->Youth;
            $Women = $aveMSWDObudgetpreyearbyregiondata->Women;
            $FamilyandCommunity = $aveMSWDObudgetpreyearbyregiondata->FamilyandCommunity;
            $SeniorCitizen = $aveMSWDObudgetpreyearbyregiondata->SeniorCitizen;
            $PWD = $aveMSWDObudgetpreyearbyregiondata->PWD;
            $IDP = $aveMSWDObudgetpreyearbyregiondata->IDP;

            $objPHPExcel->getActiveSheet()->setCellValue($col2.$row2, $region);$col2++;
            $objPHPExcel->getActiveSheet()->setCellValue($col2.$row2, $Children);$col2++;
            $objPHPExcel->getActiveSheet()->setCellValue($col2.$row2, $Youth);$col2++;
            $objPHPExcel->getActiveSheet()->setCellValue($col2.$row2, $Women);$col2++;
            $objPHPExcel->getActiveSheet()->setCellValue($col2.$row2, $FamilyandCommunity);$col2++;
            $objPHPExcel->getActiveSheet()->setCellValue($col2.$row2, $SeniorCitizen);$col2++;
            $objPHPExcel->getActiveSheet()->setCellValue($col2.$row2, $PWD);$col2++;
            $objPHPExcel->getActiveSheet()->setCellValue($col2.$row2, $IDP);


            if($col2 == 'H'){$col2 = 'A';}
            $row2++;
        endforeach;


//    //border
        $objPHPExcel->getActiveSheet()->getStyle(
            'A1:' .
            $objPHPExcel->getActiveSheet()->getHighestColumn() .
            $objPHPExcel->getActiveSheet()->getHighestRow()
        )->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
// Rename worksheet (worksheet, not filename)
        $objPHPExcel->getActiveSheet()->setTitle('AverageMSWDObudgetallocation');

// Set active sheet index to the first sheet, so Excel opens this as the first asheet
        $objPHPExcel->setActiveSheetIndex(0);

// Redirect output to a client’s web browser (Excel2007)
//clean the output buffer
        ob_end_clean();

//this is the header given from PHPExcel examples. but the output seems somewhat corrupted in some cases.
//header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
//so, we use this header instead.
//    $regionName = $this->reports_model->getRegionName($region);
        $filename = 'aveMSWDObudgetpreyearbyregion.xlsx';
        header('Content-type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename='.$filename);
        header('Cache-Control: max-age=0');

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        $objWriter->save('php://output');
    }
//notsogood
    public function LSWDObudgetpresentbyregionbysector($sector){

        $LSWDObudgetprevyearbyregionpersector = $this->reports_model->get_LSWDObudgetprevyearbyregionpersector($sector);


        $budgetallocation_model = new budgetallocation_model();

        $sectorName = $budgetallocation_model->sectorName($sector);
        $sName = $sectorName->sector_name;
// Create new PHPExcel object
        $objPHPExcel = new PHPExcel();

// Add some data

        $objPHPExcel->getActiveSheet()->setCellValue('B1','Distribution LSWDO with budget allocation (previous year) by sector by Region');
        //autosize column

//        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getStyle('B1')->getFill()->getStartColor()->setRGB('FF0000');
//        $objPHPExcel->getActiveSheet()->getDefaultRowDimension()->setRowHeight(-1);a
        $objPHPExcel->getActiveSheet()->getRowDimension(1)->setRowHeight(-1);
        $objPHPExcel->getActiveSheet()->getStyle('B1')->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->getStyle('B1')->getFont()->setSize(15);
        $objPHPExcel->getActiveSheet()->mergeCells('B1:F1');

        //Center text merge columns
        $objPHPExcel->getActiveSheet()->getStyle('B1')->getAlignment()->applyFromArray(
            array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,));

        $objPHPExcel->getActiveSheet()->setCellValue('A3', 'Region');
        $objPHPExcel->getActiveSheet()->getStyle('A3')->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->setCellValue('B3', ''.$sName.'');
        $objPHPExcel->getActiveSheet()->mergeCells('A3:A5');
        $objPHPExcel->getActiveSheet()->mergeCells('B3:F3');
        $objPHPExcel->getActiveSheet()->mergeCells('B2:F2');
        $objPHPExcel->getActiveSheet()->mergeCells('B5:F5');
        //Center text merge columns
        $objPHPExcel->getActiveSheet()->getStyle('B3')->getAlignment()->applyFromArray(
            array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,));
        $objPHPExcel->getActiveSheet()->getStyle('A3')->getAlignment()->applyFromArray(
            array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,));

        $objPHPExcel->getActiveSheet()->getStyle('A3')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);

        $objPHPExcel->getActiveSheet()->mergeCells('B6:e6');
        $objPHPExcel->getActiveSheet()->freezePane('B6');
        //Header
        $objPHPExcel->getActiveSheet()->setCellValue('B4', 'PSWDO');
        $objPHPExcel->getActiveSheet()->getStyle('B4')->getAlignment()->applyFromArray(
            array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,));
        $objPHPExcel->getActiveSheet()->setCellValue('C4', 'CSWDO');
        $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getStyle('C4')->getAlignment()->applyFromArray(
            array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,));
        $objPHPExcel->getActiveSheet()->setCellValue('D4', 'MSWDO');
        $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getStyle('D4')->getAlignment()->applyFromArray(
            array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,));
        $objPHPExcel->getActiveSheet()->setCellValue('E4', 'Total');
        $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getStyle('e4')->getAlignment()->applyFromArray(
            array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,));
        $objPHPExcel->getActiveSheet()->setCellValue('F4', 'Percent');
        $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getStyle('F4')->getAlignment()->applyFromArray(
            array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,));
        $row2 = 7;
        $col2 = 'A';
//province list
        foreach ($LSWDObudgetprevyearbyregionpersector as $LSWDObudgetprevyearbyregionpersectordata):
            $region = $LSWDObudgetprevyearbyregionpersectordata->region_name;
            $PSWDO = $LSWDObudgetprevyearbyregionpersectordata->PSWDO;
            $CSWDO = $LSWDObudgetprevyearbyregionpersectordata->CSWDO;
            $MSWDO = $LSWDObudgetprevyearbyregionpersectordata->MSWDO;
            $TOTAL = $LSWDObudgetprevyearbyregionpersectordata->Total;

            $objPHPExcel->getActiveSheet()->setCellValue($col2.$row2, $region);$col2++;
            $objPHPExcel->getActiveSheet()->setCellValue($col2.$row2, $PSWDO);$col2++;
            $objPHPExcel->getActiveSheet()->setCellValue($col2.$row2, $CSWDO);$col2++;
            $objPHPExcel->getActiveSheet()->setCellValue($col2.$row2, $MSWDO);$col2++;
            $objPHPExcel->getActiveSheet()->setCellValue($col2.$row2, $TOTAL);


            if($col2 == 'E'){$col2 = 'A';}
            $row2++;
        endforeach;
        $col3 = $col2;
        $row3 = $row2 -1;
        $counter = $row2 - 7;
        $objPHPExcel->getActiveSheet()->setCellValue($col3.$row2, 'Total');
        $col3++;
        $col3++;
        $col3++;
        $col3++;
        $objPHPExcel->getActiveSheet()->setCellValue($col3.$row2, '=SUM('.$col3.'7:'.$col3.$row3.')');
        $percrow = 7;
        $perccol = 'F';
        $totrow = 7;
        $totcol = 'E';
        for ($headcount = 0;$headcount < $counter;$headcount++)
        {
            $objPHPExcel->getActiveSheet()->setCellValue($perccol.$percrow,"=".$totcol.$totrow."/".$col3.$row2);
            $objPHPExcel->getActiveSheet()->getStyle($perccol.$percrow)
                ->getNumberFormat()->applyFromArray(
                    array(
                        'code' => PHPExcel_Style_NumberFormat::FORMAT_PERCENTAGE_00
                    )
                );
            $percrow++;
            $totrow++;
        }


//    //border
        $objPHPExcel->getActiveSheet()->getStyle(
            'A1:' .
            $objPHPExcel->getActiveSheet()->getHighestColumn() .
            $objPHPExcel->getActiveSheet()->getHighestRow()
        )->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
// Rename worksheet (worksheet, not filename)
        $objPHPExcel->getActiveSheet()->setTitle('DistributionLSWDObyRegion');

// Set active sheet index to the first sheet, so Excel opens this as the first asheet
        $objPHPExcel->setActiveSheetIndex(0);

// Redirect output to a client’s web browser (Excel2007)
//clean the output buffer
        ob_end_clean();

//this is the header given from PHPExcel examples. but the output seems somewhat corrupted in some cases.
//header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
//so, we use this header instead.
//    $regionName = $this->reports_model->getRegionName($region);
        $filename = 'Distribution LSWDO by Region.xlsx';
        header('Content-type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename='.$filename);
        header('Cache-Control: max-age=0');

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        $objWriter->save('php://output');
    }

    public function distributionofCMSWDOFunctionalityprovince($regionlist,$provlist){

        $distributionofCMSWDOFunctionalityprovince = $this->reports_model->get_distributionofCMSWDOFunctionalityprovince($regionlist,$provlist);


// Create new PHPExcel object
        $objPHPExcel = new PHPExcel();

// Add some data

        $objPHPExcel->getActiveSheet()->setCellValue('B1','Distribution of CMSWDO Functionality  by Province');
        //autosize column

//        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getStyle('B1')->getFill()->getStartColor()->setRGB('FF0000');
//        $objPHPExcel->getActiveSheet()->getDefaultRowDimension()->setRowHeight(-1);a
        $objPHPExcel->getActiveSheet()->getRowDimension(1)->setRowHeight(-1);
        $objPHPExcel->getActiveSheet()->getStyle('B1')->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->getStyle('B1')->getFont()->setSize(15);
        $objPHPExcel->getActiveSheet()->mergeCells('B1:D1');

        //Center text merge columns
        $objPHPExcel->getActiveSheet()->getStyle('B1')->getAlignment()->applyFromArray(
            array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,));

        $objPHPExcel->getActiveSheet()->setCellValue('A3', 'Province');
        $objPHPExcel->getActiveSheet()->getStyle('A3')->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->setCellValue('B3', 'Distribution of CMSWDO Functionality by Province');
        $objPHPExcel->getActiveSheet()->mergeCells('A3:A5');
        $objPHPExcel->getActiveSheet()->mergeCells('B3:D3');
        $objPHPExcel->getActiveSheet()->mergeCells('B2:D2');
        $objPHPExcel->getActiveSheet()->mergeCells('B5:D5');
        //Center text merge columns
        $objPHPExcel->getActiveSheet()->getStyle('B3')->getAlignment()->applyFromArray(
            array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,));
        $objPHPExcel->getActiveSheet()->getStyle('A3')->getAlignment()->applyFromArray(
            array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,));

        $objPHPExcel->getActiveSheet()->getStyle('A3')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);

        $objPHPExcel->getActiveSheet()->mergeCells('B6:D6');
        $objPHPExcel->getActiveSheet()->freezePane('B6');
        //Header

        $objPHPExcel->getActiveSheet()->setCellValue('B4', 'Partially Functional');
        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getStyle('B4')->getAlignment()->applyFromArray(
            array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,));
        $objPHPExcel->getActiveSheet()->setCellValue('C4', 'Functional');
        $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getStyle('C4')->getAlignment()->applyFromArray(
            array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,));
        $objPHPExcel->getActiveSheet()->setCellValue('D4', 'Fully Functional');
        $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getStyle('D4')->getAlignment()->applyFromArray(
            array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,));
        $row2 = 7;
        $col2 = 'A';
//province list
        foreach ($distributionofCMSWDOFunctionalityprovince as $distributionofCMSWDOFunctionalityprovincedata):
            $province = $distributionofCMSWDOFunctionalityprovincedata->prov_name;
            $PF = $distributionofCMSWDOFunctionalityprovincedata->PartiallyFunctional;
            $F = $distributionofCMSWDOFunctionalityprovincedata->Functional;
            $FF = $distributionofCMSWDOFunctionalityprovincedata->FullyFunctional;

            $objPHPExcel->getActiveSheet()->setCellValue($col2.$row2, $province);$col2++;
            $objPHPExcel->getActiveSheet()->setCellValue($col2.$row2, $PF);$col2++;
            $objPHPExcel->getActiveSheet()->setCellValue($col2.$row2, $F);$col2++;
            $objPHPExcel->getActiveSheet()->setCellValue($col2.$row2, $FF);


            if($col2 == 'D'){$col2 = 'A';}
            $row2++;
        endforeach;


//    //border
        $objPHPExcel->getActiveSheet()->getStyle(
            'A1:' .
            $objPHPExcel->getActiveSheet()->getHighestColumn() .
            $objPHPExcel->getActiveSheet()->getHighestRow()
        )->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
// Rename worksheet (worksheet, not filename)
        $objPHPExcel->getActiveSheet()->setTitle('DistributionCMSWDObyProvincec');

// Set active sheet index to the first sheet, so Excel opens this as the first asheet
        $objPHPExcel->setActiveSheetIndex(0);

// Redirect output to a client’s web browser (Excel2007)
//clean the output buffer
        ob_end_clean();

//this is the header given from PHPExcel examples. but the output seems somewhat corrupted in some cases.
//header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
//so, we use this header instead.
//    $regionName = $this->reports_model->getRegionName($region);
        $filename = 'Distribution of CMSWDO Functionality by Province.xlsx';
        header('Content-type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename='.$filename);
        header('Cache-Control: max-age=0');

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        $objWriter->save('php://output');
    }

    public function distributionLSWDObyregion(){

        $distributionLSWDObyregion = $this->reports_model->get_distributionLSWDObyregion();


// Create new PHPExcel object
        $objPHPExcel = new PHPExcel();

// Add some data

        $objPHPExcel->getActiveSheet()->setCellValue('B1','Distribution LSWDO by Region');
        //autosize column

//        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getStyle('B1')->getFill()->getStartColor()->setRGB('FF0000');
//        $objPHPExcel->getActiveSheet()->getDefaultRowDimension()->setRowHeight(-1);a
        $objPHPExcel->getActiveSheet()->getRowDimension(1)->setRowHeight(-1);
        $objPHPExcel->getActiveSheet()->getStyle('B1')->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->getStyle('B1')->getFont()->setSize(15);
        $objPHPExcel->getActiveSheet()->mergeCells('B1:F1');

        //Center text merge columns
        $objPHPExcel->getActiveSheet()->getStyle('B1')->getAlignment()->applyFromArray(
            array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,));

        $objPHPExcel->getActiveSheet()->setCellValue('A3', 'Region');
        $objPHPExcel->getActiveSheet()->getStyle('A3')->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->setCellValue('B3', 'Distribution LSWDO by Region');
        $objPHPExcel->getActiveSheet()->mergeCells('A3:A5');
        $objPHPExcel->getActiveSheet()->mergeCells('B3:F3');
        $objPHPExcel->getActiveSheet()->mergeCells('B2:F2');
        $objPHPExcel->getActiveSheet()->mergeCells('B5:F5');
        //Center text merge columns
        $objPHPExcel->getActiveSheet()->getStyle('B3')->getAlignment()->applyFromArray(
            array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,));
        $objPHPExcel->getActiveSheet()->getStyle('A3')->getAlignment()->applyFromArray(
            array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,));

        $objPHPExcel->getActiveSheet()->getStyle('A3')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);

        $objPHPExcel->getActiveSheet()->mergeCells('B6:e6');
        $objPHPExcel->getActiveSheet()->freezePane('B6');
        //Header
        $objPHPExcel->getActiveSheet()->setCellValue('B4', 'PSWDO');
        $objPHPExcel->getActiveSheet()->getStyle('B4')->getAlignment()->applyFromArray(
            array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,));
        $objPHPExcel->getActiveSheet()->setCellValue('C4', 'CSWDO');
        $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getStyle('C4')->getAlignment()->applyFromArray(
            array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,));
        $objPHPExcel->getActiveSheet()->setCellValue('D4', 'MSWDO');
        $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getStyle('D4')->getAlignment()->applyFromArray(
            array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,));
        $objPHPExcel->getActiveSheet()->setCellValue('E4', 'Total');
        $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getStyle('e4')->getAlignment()->applyFromArray(
            array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,));
        $objPHPExcel->getActiveSheet()->setCellValue('F4', 'Percent');
        $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getStyle('F4')->getAlignment()->applyFromArray(
            array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,));
        $row2 = 7;
        $col2 = 'A';
//province list
        foreach ($distributionLSWDObyregion as $distributionLSWDObyregiondata):
            $region = $distributionLSWDObyregiondata->region_name;
            $PSWDO = $distributionLSWDObyregiondata->PSWDO;
            $CSWDO = $distributionLSWDObyregiondata->CSWDO;
            $MSWDO = $distributionLSWDObyregiondata->MSWDO;
            $TOTAL = $distributionLSWDObyregiondata->Total;

            $objPHPExcel->getActiveSheet()->setCellValue($col2.$row2, $region);$col2++;
            $objPHPExcel->getActiveSheet()->setCellValue($col2.$row2, $PSWDO);$col2++;
            $objPHPExcel->getActiveSheet()->setCellValue($col2.$row2, $CSWDO);$col2++;
            $objPHPExcel->getActiveSheet()->setCellValue($col2.$row2, $MSWDO);$col2++;
            $objPHPExcel->getActiveSheet()->setCellValue($col2.$row2, $TOTAL);


            if($col2 == 'E'){$col2 = 'A';}
            $row2++;
        endforeach;
        $col3 = $col2;
        $row3 = $row2 -1;
        $counter = $row2 - 7;
        $objPHPExcel->getActiveSheet()->setCellValue($col3.$row2, 'Total');
        $col3++;
        $col3++;
        $col3++;
        $col3++;
        $objPHPExcel->getActiveSheet()->setCellValue($col3.$row2, '=SUM('.$col3.'7:'.$col3.$row3.')');
        $percrow = 7;
        $perccol = 'F';
        $totrow = 7;
        $totcol = 'E';
        for ($headcount = 0;$headcount < $counter;$headcount++)
        {
            $objPHPExcel->getActiveSheet()->setCellValue($perccol.$percrow,"=".$totcol.$totrow."/".$col3.$row2);
            $objPHPExcel->getActiveSheet()->getStyle($perccol.$percrow)
                ->getNumberFormat()->applyFromArray(
                    array(
                        'code' => PHPExcel_Style_NumberFormat::FORMAT_PERCENTAGE_00
                    )
                );
            $percrow++;
            $totrow++;
        }


//    //border
        $objPHPExcel->getActiveSheet()->getStyle(
            'A1:' .
            $objPHPExcel->getActiveSheet()->getHighestColumn() .
            $objPHPExcel->getActiveSheet()->getHighestRow()
        )->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
// Rename worksheet (worksheet, not filename)
        $objPHPExcel->getActiveSheet()->setTitle('DistributionLSWDObyRegion');

// Set active sheet index to the first sheet, so Excel opens this as the first asheet
        $objPHPExcel->setActiveSheetIndex(0);

// Redirect output to a client’s web browser (Excel2007)
//clean the output buffer
        ob_end_clean();

//this is the header given from PHPExcel examples. but the output seems somewhat corrupted in some cases.
//header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
//so, we use this header instead.
//    $regionName = $this->reports_model->getRegionName($region);
        $filename = 'Distribution LSWDO by Region.xlsx';
        header('Content-type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename='.$filename);
        header('Cache-Control: max-age=0');

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        $objWriter->save('php://output');
    }
    public function distributionPSWDObyregion(){

        $distributionPSWDObyregion = $this->reports_model->get_distributionPSWDObyregion();


// Create new PHPExcel object
        $objPHPExcel = new PHPExcel();

// Add some data

//        $objPHPExcel->getActiveSheet()->setCellValue('B1','Distribution PSWDO by Region');
        //autosize column

        $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getStyle('B1')->getFill()->getStartColor()->setRGB('FF0000');
//        $objPHPExcel->getActiveSheet()->getDefaultRowDimension()->setRowHeight(-1);a
        $objPHPExcel->getActiveSheet()->getRowDimension(1)->setRowHeight(-1);
        $objPHPExcel->getActiveSheet()->getStyle('B3')->getFont()->setBold(true);

        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);

        //Center text merge columns
        $objPHPExcel->getActiveSheet()->getStyle('B1')->getAlignment()->applyFromArray(
            array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,));

        $objPHPExcel->getActiveSheet()->setCellValue('A3', 'Region');
        $objPHPExcel->getActiveSheet()->getStyle('A3')->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->setCellValue('B3', 'Distribution PSWDO by Region');
        $objPHPExcel->getActiveSheet()->mergeCells('A3:A5');
        $objPHPExcel->getActiveSheet()->mergeCells('B3:C3');
        $objPHPExcel->getActiveSheet()->mergeCells('B2:C2');
        $objPHPExcel->getActiveSheet()->mergeCells('B5:C5');
        //Center text merge columns
        $objPHPExcel->getActiveSheet()->getStyle('B3')->getAlignment()->applyFromArray(
            array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,));
        $objPHPExcel->getActiveSheet()->getStyle('A3')->getAlignment()->applyFromArray(
            array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,));

        $objPHPExcel->getActiveSheet()->getStyle('A3')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);


        $objPHPExcel->getActiveSheet()->freezePane('B6');
        //Header
        $objPHPExcel->getActiveSheet()->setCellValue('B4', 'TOTAL');
        $objPHPExcel->getActiveSheet()->getStyle('B4')->getAlignment()->applyFromArray(
            array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,));
        $objPHPExcel->getActiveSheet()->setCellValue('C4', 'Percentage');
        $objPHPExcel->getActiveSheet()->getStyle('C4')->getAlignment()->applyFromArray(
            array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,));
        $row2 = 7;
        $col2 = 'A';
//province list
        foreach ($distributionPSWDObyregion as $distributionPSWDObyregiondata):
            $region = $distributionPSWDObyregiondata->region_name;
            $PSWDO = $distributionPSWDObyregiondata->PSWDO;

            $objPHPExcel->getActiveSheet()->setCellValue($col2.$row2, $region);$col2++;
            $objPHPExcel->getActiveSheet()->setCellValue($col2.$row2, $PSWDO);

            if($col2 == 'B'){$col2 = 'A';}
            $row2++;
        endforeach;
        $col3 = $col2;
        $row3 = $row2 -1;
        $counter = $row2 - 7;
        $objPHPExcel->getActiveSheet()->setCellValue($col3.$row2, 'Total');
        $col3++;
        $objPHPExcel->getActiveSheet()->setCellValue($col3.$row2, '=SUM('.$col3.'7:'.$col3.$row3.')');
        $percrow = 7;
        $perccol = 'C';
        $totrow = 7;
        $totcol = 'B';
        for ($headcount = 0;$headcount < $counter;$headcount++)
        {
            $objPHPExcel->getActiveSheet()->setCellValue($perccol.$percrow,"=".$totcol.$totrow."/".$col3.$row2);
            $objPHPExcel->getActiveSheet()->getStyle($perccol.$percrow)
                ->getNumberFormat()->applyFromArray(
                    array(
                        'code' => PHPExcel_Style_NumberFormat::FORMAT_PERCENTAGE_00
                    )
                );
            $percrow++;
            $totrow++;
        }

//functional

//    //border
        $objPHPExcel->getActiveSheet()->getStyle(
            'A1:' .
            $objPHPExcel->getActiveSheet()->getHighestColumn() .
            $objPHPExcel->getActiveSheet()->getHighestRow()
        )->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
// Rename worksheet (worksheet, not filename)
        $objPHPExcel->getActiveSheet()->setTitle('DistributionPSWDObyRegion');

// Set active sheet index to the first sheet, so Excel opens this as the first asheet
        $objPHPExcel->setActiveSheetIndex(0);

// Redirect output to a client’s web browser (Excel2007)
//clean the output buffer
        ob_end_clean();

//this is the header given from PHPExcel examples. but the output seems somewhat corrupted in some cases.
//header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
//so, we use this header instead.
//    $regionName = $this->reports_model->getRegionName($region);
        $filename = 'Distribution PSWDO by Region.xlsx';
        header('Content-type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename='.$filename);
        header('Cache-Control: max-age=0');

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        $objWriter->save('php://output');
    }
    public function distributionCSWDObyregion(){

        $distributionCSWDObyregion = $this->reports_model->get_distributionCSWDObyregion();


// Create new PHPExcel object
        $objPHPExcel = new PHPExcel();

// Add some data

//        $objPHPExcel->getActiveSheet()->setCellValue('B1','Distribution PSWDO by Region');
        //autosize column

        $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getStyle('B1')->getFill()->getStartColor()->setRGB('FF0000');
//        $objPHPExcel->getActiveSheet()->getDefaultRowDimension()->setRowHeight(-1);a
        $objPHPExcel->getActiveSheet()->getRowDimension(1)->setRowHeight(-1);
        $objPHPExcel->getActiveSheet()->getStyle('B3')->getFont()->setBold(true);

        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);

        //Center text merge columns
        $objPHPExcel->getActiveSheet()->getStyle('B1')->getAlignment()->applyFromArray(
            array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,));

        $objPHPExcel->getActiveSheet()->setCellValue('A3', 'Region');
        $objPHPExcel->getActiveSheet()->getStyle('A3')->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->setCellValue('B3', 'Distribution CSWDO by Region');
        $objPHPExcel->getActiveSheet()->mergeCells('A3:A5');
        $objPHPExcel->getActiveSheet()->mergeCells('B3:C3');
        $objPHPExcel->getActiveSheet()->mergeCells('B2:C2');
        $objPHPExcel->getActiveSheet()->mergeCells('B5:C5');
        //Center text merge columns
        $objPHPExcel->getActiveSheet()->getStyle('B3')->getAlignment()->applyFromArray(
            array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,));
        $objPHPExcel->getActiveSheet()->getStyle('A3')->getAlignment()->applyFromArray(
            array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,));

        $objPHPExcel->getActiveSheet()->getStyle('A3')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);


        $objPHPExcel->getActiveSheet()->freezePane('B6');
        //Header
        $objPHPExcel->getActiveSheet()->setCellValue('B4', 'TOTAL');
        $objPHPExcel->getActiveSheet()->getStyle('B4')->getAlignment()->applyFromArray(
            array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,));
        $objPHPExcel->getActiveSheet()->setCellValue('C4', 'Percentage');
        $objPHPExcel->getActiveSheet()->getStyle('C4')->getAlignment()->applyFromArray(
            array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,));
        $row2 = 7;
        $col2 = 'A';
//province list
        foreach ($distributionCSWDObyregion as $distributionCSWDObyregiondata):
            $region = $distributionCSWDObyregiondata->region_name;
            $CSWDO = $distributionCSWDObyregiondata->CSWDO;

            $objPHPExcel->getActiveSheet()->setCellValue($col2.$row2, $region);$col2++;
            $objPHPExcel->getActiveSheet()->setCellValue($col2.$row2, $CSWDO);


            if($col2 == 'B'){$col2 = 'A';}
            $row2++;
        endforeach;

        $col3 = $col2;
        $row3 = $row2 -1;
        $counter = $row2 - 7;
        $objPHPExcel->getActiveSheet()->setCellValue($col3.$row2, 'Total');
        $col3++;
        $objPHPExcel->getActiveSheet()->setCellValue($col3.$row2, '=SUM('.$col3.'7:'.$col3.$row3.')');
        $percrow = 7;
        $perccol = 'C';
        $totrow = 7;
        $totcol = 'B';
        for ($headcount = 0;$headcount < $counter;$headcount++)
        {
            $objPHPExcel->getActiveSheet()->setCellValue($perccol.$percrow,"=".$totcol.$totrow."/".$col3.$row2);
            $objPHPExcel->getActiveSheet()->getStyle($perccol.$percrow)
                ->getNumberFormat()->applyFromArray(
                    array(
                        'code' => PHPExcel_Style_NumberFormat::FORMAT_PERCENTAGE_00
                    )
                );
            $percrow++;
            $totrow++;
        }


//functional

//    //border
        $objPHPExcel->getActiveSheet()->getStyle(
            'A1:' .
            $objPHPExcel->getActiveSheet()->getHighestColumn() .
            $objPHPExcel->getActiveSheet()->getHighestRow()
        )->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
// Rename worksheet (worksheet, not filename)
        $objPHPExcel->getActiveSheet()->setTitle('DistributionCSWDObyRegion');

// Set active sheet index to the first sheet, so Excel opens this as the first asheet
        $objPHPExcel->setActiveSheetIndex(0);

// Redirect output to a client’s web browser (Excel2007)
//clean the output buffer
        ob_end_clean();

//this is the header given from PHPExcel examples. but the output seems somewhat corrupted in some cases.
//header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
//so, we use this header instead.
//    $regionName = $this->reports_model->getRegionName($region);
        $filename = 'Distribution CSWDO by Region.xlsx';
        header('Content-type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename='.$filename);
        header('Cache-Control: max-age=0');

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        $objWriter->save('php://output');
    }
    public function distributionMSWDObyregion(){

        $distributionMSWDObyregion = $this->reports_model->get_distributionMSWDObyregion();


// Create new PHPExcel object
        $objPHPExcel = new PHPExcel();

// Add some data

//        $objPHPExcel->getActiveSheet()->setCellValue('B1','Distribution PSWDO by Region');
        //autosize column

        $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getStyle('B1')->getFill()->getStartColor()->setRGB('FF0000');
//        $objPHPExcel->getActiveSheet()->getDefaultRowDimension()->setRowHeight(-1);a
        $objPHPExcel->getActiveSheet()->getRowDimension(1)->setRowHeight(-1);
        $objPHPExcel->getActiveSheet()->getStyle('B3')->getFont()->setBold(true);

        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);

        //Center text merge columns
        $objPHPExcel->getActiveSheet()->getStyle('B1')->getAlignment()->applyFromArray(
            array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,));

        $objPHPExcel->getActiveSheet()->setCellValue('A3', 'Region');
        $objPHPExcel->getActiveSheet()->getStyle('A3')->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->setCellValue('B3', 'Distribution MSWDO by Region');
        $objPHPExcel->getActiveSheet()->mergeCells('A3:A5');
//        $objPHPExcel->getActiveSheet()->mergeCells('B3:E3');
        //Center text merge columns
        $objPHPExcel->getActiveSheet()->getStyle('B3')->getAlignment()->applyFromArray(
            array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,));
        $objPHPExcel->getActiveSheet()->getStyle('A3')->getAlignment()->applyFromArray(
            array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,));

        $objPHPExcel->getActiveSheet()->getStyle('A3')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);


        $objPHPExcel->getActiveSheet()->freezePane('B6');
        //Header
        $objPHPExcel->getActiveSheet()->setCellValue('B4', 'TOTAL');
        $objPHPExcel->getActiveSheet()->getStyle('B4')->getAlignment()->applyFromArray(
            array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,));
        $row2 = 7;
        $col2 = 'A';
//province list
        foreach ($distributionMSWDObyregion as $distributionMSWDObyregiondata):
            $region = $distributionMSWDObyregiondata->region_name;
            $MSWDO = $distributionMSWDObyregiondata->MSWDO;

            $objPHPExcel->getActiveSheet()->setCellValue($col2.$row2, $region);$col2++;
            $objPHPExcel->getActiveSheet()->setCellValue($col2.$row2, $MSWDO);


            if($col2 == 'B'){$col2 = 'A';}
            $row2++;
        endforeach;




//functional

//    //border
        $objPHPExcel->getActiveSheet()->getStyle(
            'A1:' .
            $objPHPExcel->getActiveSheet()->getHighestColumn() .
            $objPHPExcel->getActiveSheet()->getHighestRow()
        )->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
// Rename worksheet (worksheet, not filename)
        $objPHPExcel->getActiveSheet()->setTitle('DistributionMSWDObyRegion');

// Set active sheet index to the first sheet, so Excel opens this as the first asheet
        $objPHPExcel->setActiveSheetIndex(0);

// Redirect output to a client’s web browser (Excel2007)
//clean the output buffer
        ob_end_clean();

//this is the header given from PHPExcel examples. but the output seems somewhat corrupted in some cases.
//header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
//so, we use this header instead.
//    $regionName = $this->reports_model->getRegionName($region);
        $filename = 'Distribution MSWDO by Region.xlsx';
        header('Content-type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename='.$filename);
        header('Cache-Control: max-age=0');

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        $objWriter->save('php://output');
    }

    /*public function nonCompliantPSWDO($regCode,$provCode,$lguType){


        $indicator_model = new indicator_model();
        $reports_model = new reports_model();
        $get_AllRegion = $reports_model->get_AllRegion();
        $get_AllProvByReg = $reports_model->get_AllProvByReg($regCode);
        $get_AllCityByProv = $reports_model->get_AllCityByProv($provCode);
        $get_AllMuniByProv = $reports_model->get_AllMuniByProv($provCode);

// Create new PHPExcel object
        $objPHPExcel = new PHPExcel();

        $sheet = 0;
        if($lguType == 0 || $lguType == 4) {
            foreach ($get_AllRegion as $region):

                $firstMotherIndicator = $indicator_model->getFirstMotherIndicator();
                $secondMotherIndicator = $indicator_model->getSecondMotherIndicator();
                $fourthMotherIndicator = $indicator_model->getFourthMotherIndicator();
                $thirdMotherIndicator = $indicator_model->getThirdMotherIndicator();

                $getScorePart1 = $indicator_model->getScorePart1($region->region_code, $provCode, $lguType);
                $getPart1 = $indicator_model->getPart1($lguType);
                $getPart2 = $indicator_model->getPart2($lguType);
                $getPart3 = $indicator_model->getPart3($lguType);
                $getPart4 = $indicator_model->getPart4($lguType);
                $get_totalAssess = $reports_model->get_totalAssess($region->region_code, $provCode, $lguType);
                if ($sheet > 0) {
                    $objWorksheet = new PHPExcel_Worksheet($objPHPExcel);
                    $objPHPExcel->addSheet($objWorksheet);

// Add some data

                    $objWorksheet->setCellValue('B1', 'Sample Title');

                    //autosize column

                    $objWorksheet->getColumnDimension('B')->setAutoSize(true);
                    $objWorksheet->getColumnDimension('A')->setAutoSize(true);
                    $objWorksheet->getStyle('B1')->getFill()->getStartColor()->setRGB('FF0000');
//        $objWorksheet->getDefaultRowDimension()->setRowHeight(-1);a
                    $objWorksheet->getRowDimension(1)->setRowHeight(-1);
                    $objWorksheet->getStyle('B1')->getFont()->setBold(true);
                    $objWorksheet->getStyle('B1')->getFont()->setSize(20);
                    $objWorksheet->mergeCells('B1:E2');

                    //Center text merge columns
                    $objWorksheet->getStyle('B1')->getAlignment()->applyFromArray(
                        array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,));
//    $col = 'A';
//        $row = 5;
                    $objWorksheet->setCellValue('A3', 'Areas');
                    $objWorksheet->getStyle('A3')->getFont()->setBold(true);
                    $objWorksheet->setCellValue('B3', 'Distribution of functional by Province -Sample title');
                    $objWorksheet->mergeCells('A3:A5');
                    $objWorksheet->mergeCells('B3:E3');
                    //Center text merge columns
                    $objWorksheet->getStyle('B3')->getAlignment()->applyFromArray(
                        array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,));
                    $objWorksheet->getStyle('A3')->getAlignment()->applyFromArray(
                        array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,));

                    $objWorksheet->getStyle('A3')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);

                    $objWorksheet->mergeCells('B6:e6');
                    $objWorksheet->freezePane('B6');
                    //Header
                    $objWorksheet->setCellValue('B4', 'Indicators');

                    $objWorksheet->getStyle('B4')->getAlignment()->applyFromArray(
                        array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,));
                    $objWorksheet->setCellValue('C4', 'Non-Compliant');
                    $objWorksheet->getColumnDimension('C')->setAutoSize(true);
                    $objWorksheet->getStyle('C4')->getAlignment()->applyFromArray(
                        array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,));
                    $objWorksheet->setCellValue('D4', 'Percent');
                    $objWorksheet->getColumnDimension('D')->setAutoSize(true);
                    $objWorksheet->getStyle('D4')->getAlignment()->applyFromArray(
                        array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,));


//Start Editing
                    //Part1
                    $row2 = 7;
                    $col2 = 'A';
                    $objWorksheet->setCellValue($col2 . $row2, $firstMotherIndicator->indicator_name);
                    $col2++;
                    $row2++;
                    foreach ($getPart1 as $firstPartIndicator):
                        if ($firstPartIndicator->indicator_checklist_id == 1) {
                            $arr = explode("-", $firstPartIndicator->indicator_id);
                            $indicatorID = $arr[0];
                            foreach ($getScorePart1 as $scorePart1):
                                if ($scorePart1->indicator_id == $firstPartIndicator->indicator_id) {
                                    $indicator_name = $indicatorID . '.' . $firstPartIndicator->indicator_name;
                                    $totalNonCompliance = $scorePart1->TotalNonCompliance;
                                    $totalAssess = $get_totalAssess->totalAssess;

                                    $percent = ($totalNonCompliance / $totalAssess);


                                    $objWorksheet->setCellValue($col2 . $row2, $indicator_name);
                                    $col2++;
                                    $objWorksheet->setCellValue($col2 . $row2, $totalNonCompliance);
                                    $col2++;
                                    $objWorksheet->setCellValue($col2 . $row2, $percent);
                                    $objWorksheet->getStyle($col2 . $row2)
                                        ->getNumberFormat()->applyFromArray(
                                            array(
                                                'code' => PHPExcel_Style_NumberFormat::FORMAT_PERCENTAGE_00
                                            )
                                        );
                                    if ($col2 == 'D') {
                                        $col2 = 'B';
                                    }
                                    $row2++;
                                }
                            endforeach;
                        }
                    endforeach;
                    //Part2
                    $col2 = 'A';
                    $objWorksheet->setCellValue($col2 . $row2, $secondMotherIndicator->indicator_name);
                    $col2++;
                    $row2++;
                    foreach ($getPart2 as $secondPartIndicator):
                        if ($secondPartIndicator->indicator_checklist_id == 1) {
                            $arr = explode("-", $secondPartIndicator->indicator_id);
                            $indicatorID = $arr[0];
                            foreach ($getScorePart1 as $scorePart1):
                                if ($scorePart1->indicator_id == $secondPartIndicator->indicator_id) {
                                    $indicator_name = $indicatorID . '.' . $secondPartIndicator->indicator_name;
                                    $totalNonCompliance = $scorePart1->TotalNonCompliance;
                                    $totalAssess = $get_totalAssess->totalAssess;

                                    $percent = ($totalNonCompliance / $totalAssess);

                                    $objWorksheet->setCellValue($col2 . $row2, $indicator_name);
                                    $col2++;
                                    $objWorksheet->setCellValue($col2 . $row2, $totalNonCompliance);
                                    $col2++;
                                    $objWorksheet->setCellValue($col2 . $row2, $percent);
                                    $objWorksheet->getStyle($col2 . $row2)
                                        ->getNumberFormat()->applyFromArray(
                                            array(
                                                'code' => PHPExcel_Style_NumberFormat::FORMAT_PERCENTAGE_00
                                            )
                                        );
                                    if ($col2 == 'D') {
                                        $col2 = 'B';
                                    }
                                    $row2++;
                                }
                            endforeach;
                        }
                    endforeach;
                    //Part3
                    $col2 = 'A';
                    $objWorksheet->setCellValue($col2 . $row2, $thirdMotherIndicator->indicator_name);
                    $col2++;
                    $row2++;
                    foreach ($getPart3 as $thirdPartIndicator):
                        if ($thirdPartIndicator->indicator_checklist_id == 1) {
                            $arr = explode("-", $thirdPartIndicator->indicator_id);
                            $indicatorID = $arr[0];
                            foreach ($getScorePart1 as $scorePart1):
                                if ($scorePart1->indicator_id == $thirdPartIndicator->indicator_id) {
                                    $indicator_name = $indicatorID . '.' . $thirdPartIndicator->indicator_name;
                                    $totalNonCompliance = $scorePart1->TotalNonCompliance;
                                    $totalAssess = $get_totalAssess->totalAssess;

                                    $percent = ($totalNonCompliance / $totalAssess);

                                    $objWorksheet->setCellValue($col2 . $row2, $indicator_name);
                                    $col2++;
                                    $objWorksheet->setCellValue($col2 . $row2, $totalNonCompliance);
                                    $col2++;
                                    $objWorksheet->setCellValue($col2 . $row2, $percent);
                                    $objWorksheet->getStyle($col2 . $row2)
                                        ->getNumberFormat()->applyFromArray(
                                            array(
                                                'code' => PHPExcel_Style_NumberFormat::FORMAT_PERCENTAGE_00
                                            )
                                        );
                                    if ($col2 == 'D') {
                                        $col2 = 'B';
                                    }
                                    $row2++;
                                }
                            endforeach;
                        }
                    endforeach;
                    //Part4
                    $col2 = 'A';
                    $objWorksheet->setCellValue($col2 . $row2, $fourthMotherIndicator->indicator_name);
                    $col2++;
                    $row2++;
                    foreach ($getPart4 as $fourthPartIndicator):
                        if ($fourthPartIndicator->indicator_checklist_id == 1) {
                            $arr = explode("-", $fourthPartIndicator->indicator_id);
                            $indicatorID = $arr[0];
                            foreach ($getScorePart1 as $scorePart1):
                                if ($scorePart1->indicator_id == $fourthPartIndicator->indicator_id) {
                                    $indicator_name = $indicatorID . '.' . $fourthPartIndicator->indicator_name;
                                    $totalNonCompliance = $scorePart1->TotalNonCompliance;
                                    $totalAssess = $get_totalAssess->totalAssess;

                                    $percent = ($totalNonCompliance / $totalAssess);

                                    $objWorksheet->setCellValue($col2 . $row2, $indicator_name);
                                    $col2++;
                                    $objWorksheet->setCellValue($col2 . $row2, $totalNonCompliance);
                                    $col2++;
                                    $objWorksheet->setCellValue($col2 . $row2, $percent);
                                    $objWorksheet->getStyle($col2 . $row2)
                                        ->getNumberFormat()->applyFromArray(
                                            array(
                                                'code' => PHPExcel_Style_NumberFormat::FORMAT_PERCENTAGE_00
                                            )
                                        );
                                    if ($col2 == 'D') {
                                        $col2 = 'B';
                                    }
                                    $row2++;
                                }
                            endforeach;
                        }
                    endforeach;

//End Editing

//    //border
                    $objWorksheet->getStyle(
                        'A1:' .
                        $objWorksheet->getHighestColumn() .
                        $objWorksheet->getHighestRow()
                    )->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
// Rename worksheet (worksheet, not filename)
                    $objWorksheet->setTitle('Non-Compliant');
                    // Add new sheet

                    $objWorksheet->setTitle($region->region_nick);
                } else {
// Add some data

                    $objPHPExcel->getActiveSheet()->setCellValue('B1', 'Sample Title');

                    //autosize column

                    $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
                    $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
                    $objPHPExcel->getActiveSheet()->getStyle('B1')->getFill()->getStartColor()->setRGB('FF0000');
//        $objPHPExcel->getActiveSheet()->getDefaultRowDimension()->setRowHeight(-1);a
                    $objPHPExcel->getActiveSheet()->getRowDimension(1)->setRowHeight(-1);
                    $objPHPExcel->getActiveSheet()->getStyle('B1')->getFont()->setBold(true);
                    $objPHPExcel->getActiveSheet()->getStyle('B1')->getFont()->setSize(20);
                    $objPHPExcel->getActiveSheet()->mergeCells('B1:E2');

                    //Center text merge columns
                    $objPHPExcel->getActiveSheet()->getStyle('B1')->getAlignment()->applyFromArray(
                        array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,));
//    $col = 'A';
//        $row = 5;
                    $objPHPExcel->getActiveSheet()->setCellValue('A3', 'Areas');
                    $objPHPExcel->getActiveSheet()->getStyle('A3')->getFont()->setBold(true);
                    $objPHPExcel->getActiveSheet()->setCellValue('B3', 'Distribution of functional by Province -Sample title');
                    $objPHPExcel->getActiveSheet()->mergeCells('A3:A5');
                    $objPHPExcel->getActiveSheet()->mergeCells('B3:E3');
                    //Center text merge columns
                    $objPHPExcel->getActiveSheet()->getStyle('B3')->getAlignment()->applyFromArray(
                        array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,));
                    $objPHPExcel->getActiveSheet()->getStyle('A3')->getAlignment()->applyFromArray(
                        array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,));

                    $objPHPExcel->getActiveSheet()->getStyle('A3')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);

                    $objPHPExcel->getActiveSheet()->mergeCells('B6:e6');
                    $objPHPExcel->getActiveSheet()->freezePane('B6');
                    //Header
                    $objPHPExcel->getActiveSheet()->setCellValue('B4', 'Indicators');

                    $objPHPExcel->getActiveSheet()->getStyle('B4')->getAlignment()->applyFromArray(
                        array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,));
                    $objPHPExcel->getActiveSheet()->setCellValue('C4', 'Non-Compliant');
                    $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
                    $objPHPExcel->getActiveSheet()->getStyle('C4')->getAlignment()->applyFromArray(
                        array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,));
                    $objPHPExcel->getActiveSheet()->setCellValue('D4', 'Percent');
                    $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
                    $objPHPExcel->getActiveSheet()->getStyle('D4')->getAlignment()->applyFromArray(
                        array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,));


//Start Editing
                    //Part1
                    $row2 = 7;
                    $col2 = 'A';
                    $objPHPExcel->getActiveSheet()->setCellValue($col2 . $row2, $firstMotherIndicator->indicator_name);
                    $col2++;
                    $row2++;
                    foreach ($getPart1 as $firstPartIndicator):
                        if ($firstPartIndicator->indicator_checklist_id == 1) {
                            $arr = explode("-", $firstPartIndicator->indicator_id);
                            $indicatorID = $arr[0];
                            foreach ($getScorePart1 as $scorePart1):
                                if ($scorePart1->indicator_id == $firstPartIndicator->indicator_id) {
                                    $indicator_name = $indicatorID . '.' . $firstPartIndicator->indicator_name;
                                    $totalNonCompliance = $scorePart1->TotalNonCompliance;
                                    $totalAssess = $get_totalAssess->totalAssess;

                                    $percent = ($totalNonCompliance / $totalAssess);


                                    $objPHPExcel->getActiveSheet()->setCellValue($col2 . $row2, $indicator_name);
                                    $col2++;
                                    $objPHPExcel->getActiveSheet()->setCellValue($col2 . $row2, $totalNonCompliance);
                                    $col2++;
                                    $objPHPExcel->getActiveSheet()->setCellValue($col2 . $row2, $percent);
                                    $objPHPExcel->getActiveSheet()->getStyle($col2 . $row2)
                                        ->getNumberFormat()->applyFromArray(
                                            array(
                                                'code' => PHPExcel_Style_NumberFormat::FORMAT_PERCENTAGE_00
                                            )
                                        );
                                    if ($col2 == 'D') {
                                        $col2 = 'B';
                                    }
                                    $row2++;
                                }
                            endforeach;
                        }
                    endforeach;
                    //Part2
                    $col2 = 'A';
                    $objPHPExcel->getActiveSheet()->setCellValue($col2 . $row2, $secondMotherIndicator->indicator_name);
                    $col2++;
                    $row2++;
                    foreach ($getPart2 as $secondPartIndicator):
                        if ($secondPartIndicator->indicator_checklist_id == 1) {
                            $arr = explode("-", $secondPartIndicator->indicator_id);
                            $indicatorID = $arr[0];
                            foreach ($getScorePart1 as $scorePart1):
                                if ($scorePart1->indicator_id == $secondPartIndicator->indicator_id) {
                                    $indicator_name = $indicatorID . '.' . $secondPartIndicator->indicator_name;
                                    $totalNonCompliance = $scorePart1->TotalNonCompliance;
                                    $totalAssess = $get_totalAssess->totalAssess;

                                    $percent = ($totalNonCompliance / $totalAssess);

                                    $objPHPExcel->getActiveSheet()->setCellValue($col2 . $row2, $indicator_name);
                                    $col2++;
                                    $objPHPExcel->getActiveSheet()->setCellValue($col2 . $row2, $totalNonCompliance);
                                    $col2++;
                                    $objPHPExcel->getActiveSheet()->setCellValue($col2 . $row2, $percent);
                                    $objPHPExcel->getActiveSheet()->getStyle($col2 . $row2)
                                        ->getNumberFormat()->applyFromArray(
                                            array(
                                                'code' => PHPExcel_Style_NumberFormat::FORMAT_PERCENTAGE_00
                                            )
                                        );
                                    if ($col2 == 'D') {
                                        $col2 = 'B';
                                    }
                                    $row2++;
                                }
                            endforeach;
                        }
                    endforeach;
                    //Part3
                    $col2 = 'A';
                    $objPHPExcel->getActiveSheet()->setCellValue($col2 . $row2, $thirdMotherIndicator->indicator_name);
                    $col2++;
                    $row2++;
                    foreach ($getPart3 as $thirdPartIndicator):
                        if ($thirdPartIndicator->indicator_checklist_id == 1) {
                            $arr = explode("-", $thirdPartIndicator->indicator_id);
                            $indicatorID = $arr[0];
                            foreach ($getScorePart1 as $scorePart1):
                                if ($scorePart1->indicator_id == $thirdPartIndicator->indicator_id) {
                                    $indicator_name = $indicatorID . '.' . $thirdPartIndicator->indicator_name;
                                    $totalNonCompliance = $scorePart1->TotalNonCompliance;
                                    $totalAssess = $get_totalAssess->totalAssess;

                                    $percent = ($totalNonCompliance / $totalAssess);

                                    $objPHPExcel->getActiveSheet()->setCellValue($col2 . $row2, $indicator_name);
                                    $col2++;
                                    $objPHPExcel->getActiveSheet()->setCellValue($col2 . $row2, $totalNonCompliance);
                                    $col2++;
                                    $objPHPExcel->getActiveSheet()->setCellValue($col2 . $row2, $percent);
                                    $objPHPExcel->getActiveSheet()->getStyle($col2 . $row2)
                                        ->getNumberFormat()->applyFromArray(
                                            array(
                                                'code' => PHPExcel_Style_NumberFormat::FORMAT_PERCENTAGE_00
                                            )
                                        );
                                    if ($col2 == 'D') {
                                        $col2 = 'B';
                                    }
                                    $row2++;
                                }
                            endforeach;
                        }
                    endforeach;
                    //Part4
                    $col2 = 'A';
                    $objPHPExcel->getActiveSheet()->setCellValue($col2 . $row2, $fourthMotherIndicator->indicator_name);
                    $col2++;
                    $row2++;
                    foreach ($getPart4 as $fourthPartIndicator):
                        if ($fourthPartIndicator->indicator_checklist_id == 1) {
                            $arr = explode("-", $fourthPartIndicator->indicator_id);
                            $indicatorID = $arr[0];
                            foreach ($getScorePart1 as $scorePart1):
                                if ($scorePart1->indicator_id == $fourthPartIndicator->indicator_id) {
                                    $indicator_name = $indicatorID . '.' . $fourthPartIndicator->indicator_name;
                                    $totalNonCompliance = $scorePart1->TotalNonCompliance;
                                    $totalAssess = $get_totalAssess->totalAssess;

                                    $percent = ($totalNonCompliance / $totalAssess);

                                    $objPHPExcel->getActiveSheet()->setCellValue($col2 . $row2, $indicator_name);
                                    $col2++;
                                    $objPHPExcel->getActiveSheet()->setCellValue($col2 . $row2, $totalNonCompliance);
                                    $col2++;
                                    $objPHPExcel->getActiveSheet()->setCellValue($col2 . $row2, $percent);
                                    $objPHPExcel->getActiveSheet()->getStyle($col2 . $row2)
                                        ->getNumberFormat()->applyFromArray(
                                            array(
                                                'code' => PHPExcel_Style_NumberFormat::FORMAT_PERCENTAGE_00
                                            )
                                        );
                                    if ($col2 == 'D') {
                                        $col2 = 'B';
                                    }
                                    $row2++;
                                }
                            endforeach;
                        }
                    endforeach;

//End Editing

//    //border
                    $objPHPExcel->getActiveSheet()->getStyle(
                        'A1:' .
                        $objPHPExcel->getActiveSheet()->getHighestColumn() .
                        $objPHPExcel->getActiveSheet()->getHighestRow()
                    )->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
// Rename worksheet (worksheet, not filename)
                    $objPHPExcel->setActiveSheetIndex(0)->setTitle($region->region_nick);
                    // Add new sheet

                }
                $row6++;
                $sheet++;
            endforeach;
        } elseif($lguType == 1){
            foreach ($get_AllProvByReg as $region):

                $firstMotherIndicator = $indicator_model->getFirstMotherIndicator();
                $secondMotherIndicator = $indicator_model->getSecondMotherIndicator();
                $fourthMotherIndicator = $indicator_model->getFourthMotherIndicator();
                $thirdMotherIndicator = $indicator_model->getThirdMotherIndicator();

                $getScorePart1 = $indicator_model->getScorePart1($regCode, $region->prov_code, $lguType);
                $getPart1 = $indicator_model->getPart1($lguType);
                $getPart2 = $indicator_model->getPart2($lguType);
                $getPart3 = $indicator_model->getPart3($lguType);
                $getPart4 = $indicator_model->getPart4($lguType);
                $get_totalAssess = $reports_model->get_totalAssess($regCode, $region->prov_code, $lguType);
                if ($sheet > 0) {
                    $objWorksheet = new PHPExcel_Worksheet($objPHPExcel);
                    $objPHPExcel->addSheet($objWorksheet);

// Add some data

                    $objWorksheet->setCellValue('B1', 'Sample Title');

                    //autosize column

                    $objWorksheet->getColumnDimension('B')->setAutoSize(true);
                    $objWorksheet->getColumnDimension('A')->setAutoSize(true);
                    $objWorksheet->getStyle('B1')->getFill()->getStartColor()->setRGB('FF0000');
//        $objWorksheet->getDefaultRowDimension()->setRowHeight(-1);a
                    $objWorksheet->getRowDimension(1)->setRowHeight(-1);
                    $objWorksheet->getStyle('B1')->getFont()->setBold(true);
                    $objWorksheet->getStyle('B1')->getFont()->setSize(20);
                    $objWorksheet->mergeCells('B1:E2');

                    //Center text merge columns
                    $objWorksheet->getStyle('B1')->getAlignment()->applyFromArray(
                        array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,));
//    $col = 'A';
//        $row = 5;
                    $objWorksheet->setCellValue('A3', 'Areas');
                    $objWorksheet->getStyle('A3')->getFont()->setBold(true);
                    $objWorksheet->setCellValue('B3', 'Distribution of functional by Province -Sample title');
                    $objWorksheet->mergeCells('A3:A5');
                    $objWorksheet->mergeCells('B3:E3');
                    //Center text merge columns
                    $objWorksheet->getStyle('B3')->getAlignment()->applyFromArray(
                        array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,));
                    $objWorksheet->getStyle('A3')->getAlignment()->applyFromArray(
                        array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,));

                    $objWorksheet->getStyle('A3')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);

                    $objWorksheet->mergeCells('B6:e6');
                    $objWorksheet->freezePane('B6');
                    //Header
                    $objWorksheet->setCellValue('B4', 'Indicators');

                    $objWorksheet->getStyle('B4')->getAlignment()->applyFromArray(
                        array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,));
                    $objWorksheet->setCellValue('C4', 'Non-Compliant');
                    $objWorksheet->getColumnDimension('C')->setAutoSize(true);
                    $objWorksheet->getStyle('C4')->getAlignment()->applyFromArray(
                        array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,));
                    $objWorksheet->setCellValue('D4', 'Percent');
                    $objWorksheet->getColumnDimension('D')->setAutoSize(true);
                    $objWorksheet->getStyle('D4')->getAlignment()->applyFromArray(
                        array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,));


//Start Editing
                    //Part1
                    $row2 = 7;
                    $col2 = 'A';
                    $objWorksheet->setCellValue($col2 . $row2, $firstMotherIndicator->indicator_name);
                    $col2++;
                    $row2++;
                    foreach ($getPart1 as $firstPartIndicator):
                        if ($firstPartIndicator->indicator_checklist_id == 1) {
                            $arr = explode("-", $firstPartIndicator->indicator_id);
                            $indicatorID = $arr[0];
                            foreach ($getScorePart1 as $scorePart1):
                                if ($scorePart1->indicator_id == $firstPartIndicator->indicator_id) {
                                    $indicator_name = $indicatorID . '.' . $firstPartIndicator->indicator_name;
                                    $totalNonCompliance = $scorePart1->TotalNonCompliance;
                                    $totalAssess = $get_totalAssess->totalAssess;

                                    $percent = ($totalNonCompliance / $totalAssess);


                                    $objWorksheet->setCellValue($col2 . $row2, $indicator_name);
                                    $col2++;
                                    $objWorksheet->setCellValue($col2 . $row2, $totalNonCompliance);
                                    $col2++;
                                    $objWorksheet->setCellValue($col2 . $row2, $percent);
                                    $objWorksheet->getStyle($col2 . $row2)
                                        ->getNumberFormat()->applyFromArray(
                                            array(
                                                'code' => PHPExcel_Style_NumberFormat::FORMAT_PERCENTAGE_00
                                            )
                                        );
                                    if ($col2 == 'D') {
                                        $col2 = 'B';
                                    }
                                    $row2++;
                                }
                            endforeach;
                        }
                    endforeach;
                    //Part2
                    $col2 = 'A';
                    $objWorksheet->setCellValue($col2 . $row2, $secondMotherIndicator->indicator_name);
                    $col2++;
                    $row2++;
                    foreach ($getPart2 as $secondPartIndicator):
                        if ($secondPartIndicator->indicator_checklist_id == 1) {
                            $arr = explode("-", $secondPartIndicator->indicator_id);
                            $indicatorID = $arr[0];
                            foreach ($getScorePart1 as $scorePart1):
                                if ($scorePart1->indicator_id == $secondPartIndicator->indicator_id) {
                                    $indicator_name = $indicatorID . '.' . $secondPartIndicator->indicator_name;
                                    $totalNonCompliance = $scorePart1->TotalNonCompliance;
                                    $totalAssess = $get_totalAssess->totalAssess;

                                    $percent = ($totalNonCompliance / $totalAssess);

                                    $objWorksheet->setCellValue($col2 . $row2, $indicator_name);
                                    $col2++;
                                    $objWorksheet->setCellValue($col2 . $row2, $totalNonCompliance);
                                    $col2++;
                                    $objWorksheet->setCellValue($col2 . $row2, $percent);
                                    $objWorksheet->getStyle($col2 . $row2)
                                        ->getNumberFormat()->applyFromArray(
                                            array(
                                                'code' => PHPExcel_Style_NumberFormat::FORMAT_PERCENTAGE_00
                                            )
                                        );
                                    if ($col2 == 'D') {
                                        $col2 = 'B';
                                    }
                                    $row2++;
                                }
                            endforeach;
                        }
                    endforeach;
                    //Part3
                    $col2 = 'A';
                    $objWorksheet->setCellValue($col2 . $row2, $thirdMotherIndicator->indicator_name);
                    $col2++;
                    $row2++;
                    foreach ($getPart3 as $thirdPartIndicator):
                        if ($thirdPartIndicator->indicator_checklist_id == 1) {
                            $arr = explode("-", $thirdPartIndicator->indicator_id);
                            $indicatorID = $arr[0];
                            foreach ($getScorePart1 as $scorePart1):
                                if ($scorePart1->indicator_id == $thirdPartIndicator->indicator_id) {
                                    $indicator_name = $indicatorID . '.' . $thirdPartIndicator->indicator_name;
                                    $totalNonCompliance = $scorePart1->TotalNonCompliance;
                                    $totalAssess = $get_totalAssess->totalAssess;

                                    $percent = ($totalNonCompliance / $totalAssess);

                                    $objWorksheet->setCellValue($col2 . $row2, $indicator_name);
                                    $col2++;
                                    $objWorksheet->setCellValue($col2 . $row2, $totalNonCompliance);
                                    $col2++;
                                    $objWorksheet->setCellValue($col2 . $row2, $percent);
                                    $objWorksheet->getStyle($col2 . $row2)
                                        ->getNumberFormat()->applyFromArray(
                                            array(
                                                'code' => PHPExcel_Style_NumberFormat::FORMAT_PERCENTAGE_00
                                            )
                                        );
                                    if ($col2 == 'D') {
                                        $col2 = 'B';
                                    }
                                    $row2++;
                                }
                            endforeach;
                        }
                    endforeach;
                    //Part4
                    $col2 = 'A';
                    $objWorksheet->setCellValue($col2 . $row2, $fourthMotherIndicator->indicator_name);
                    $col2++;
                    $row2++;
                    foreach ($getPart4 as $fourthPartIndicator):
                        if ($fourthPartIndicator->indicator_checklist_id == 1) {
                            $arr = explode("-", $fourthPartIndicator->indicator_id);
                            $indicatorID = $arr[0];
                            foreach ($getScorePart1 as $scorePart1):
                                if ($scorePart1->indicator_id == $fourthPartIndicator->indicator_id) {
                                    $indicator_name = $indicatorID . '.' . $fourthPartIndicator->indicator_name;
                                    $totalNonCompliance = $scorePart1->TotalNonCompliance;
                                    $totalAssess = $get_totalAssess->totalAssess;

                                    $percent = ($totalNonCompliance / $totalAssess);

                                    $objWorksheet->setCellValue($col2 . $row2, $indicator_name);
                                    $col2++;
                                    $objWorksheet->setCellValue($col2 . $row2, $totalNonCompliance);
                                    $col2++;
                                    $objWorksheet->setCellValue($col2 . $row2, $percent);
                                    $objWorksheet->getStyle($col2 . $row2)
                                        ->getNumberFormat()->applyFromArray(
                                            array(
                                                'code' => PHPExcel_Style_NumberFormat::FORMAT_PERCENTAGE_00
                                            )
                                        );
                                    if ($col2 == 'D') {
                                        $col2 = 'B';
                                    }
                                    $row2++;
                                }
                            endforeach;
                        }
                    endforeach;

//End Editing

//    //border
                    $objWorksheet->getStyle(
                        'A1:' .
                        $objWorksheet->getHighestColumn() .
                        $objWorksheet->getHighestRow()
                    )->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
// Rename worksheet (worksheet, not filename)
                    // Add new sheet

                    $objWorksheet->setTitle($region->prov_name);
                } else {
// Add some data

                    $objPHPExcel->getActiveSheet()->setCellValue('B1', 'Sample Title');

                    //autosize column

                    $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
                    $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
                    $objPHPExcel->getActiveSheet()->getStyle('B1')->getFill()->getStartColor()->setRGB('FF0000');
//        $objPHPExcel->getActiveSheet()->getDefaultRowDimension()->setRowHeight(-1);a
                    $objPHPExcel->getActiveSheet()->getRowDimension(1)->setRowHeight(-1);
                    $objPHPExcel->getActiveSheet()->getStyle('B1')->getFont()->setBold(true);
                    $objPHPExcel->getActiveSheet()->getStyle('B1')->getFont()->setSize(20);
                    $objPHPExcel->getActiveSheet()->mergeCells('B1:E2');

                    //Center text merge columns
                    $objPHPExcel->getActiveSheet()->getStyle('B1')->getAlignment()->applyFromArray(
                        array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,));
//    $col = 'A';
//        $row = 5;
                    $objPHPExcel->getActiveSheet()->setCellValue('A3', 'Areas');
                    $objPHPExcel->getActiveSheet()->getStyle('A3')->getFont()->setBold(true);
                    $objPHPExcel->getActiveSheet()->setCellValue('B3', 'Distribution of functional by Province -Sample title');
                    $objPHPExcel->getActiveSheet()->mergeCells('A3:A5');
                    $objPHPExcel->getActiveSheet()->mergeCells('B3:E3');
                    //Center text merge columns
                    $objPHPExcel->getActiveSheet()->getStyle('B3')->getAlignment()->applyFromArray(
                        array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,));
                    $objPHPExcel->getActiveSheet()->getStyle('A3')->getAlignment()->applyFromArray(
                        array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,));

                    $objPHPExcel->getActiveSheet()->getStyle('A3')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);

                    $objPHPExcel->getActiveSheet()->mergeCells('B6:e6');
                    $objPHPExcel->getActiveSheet()->freezePane('B6');
                    //Header
                    $objPHPExcel->getActiveSheet()->setCellValue('B4', 'Indicators');

                    $objPHPExcel->getActiveSheet()->getStyle('B4')->getAlignment()->applyFromArray(
                        array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,));
                    $objPHPExcel->getActiveSheet()->setCellValue('C4', 'Non-Compliant');
                    $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
                    $objPHPExcel->getActiveSheet()->getStyle('C4')->getAlignment()->applyFromArray(
                        array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,));
                    $objPHPExcel->getActiveSheet()->setCellValue('D4', 'Percent');
                    $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
                    $objPHPExcel->getActiveSheet()->getStyle('D4')->getAlignment()->applyFromArray(
                        array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,));


//Start Editing
                    //Part1
                    $row2 = 7;
                    $col2 = 'A';
                    $objPHPExcel->getActiveSheet()->setCellValue($col2 . $row2, $firstMotherIndicator->indicator_name);
                    $col2++;
                    $row2++;
                    foreach ($getPart1 as $firstPartIndicator):
                        if ($firstPartIndicator->indicator_checklist_id == 1) {
                            $arr = explode("-", $firstPartIndicator->indicator_id);
                            $indicatorID = $arr[0];
                            foreach ($getScorePart1 as $scorePart1):
                                if ($scorePart1->indicator_id == $firstPartIndicator->indicator_id) {
                                    $indicator_name = $indicatorID . '.' . $firstPartIndicator->indicator_name;
                                    $totalNonCompliance = $scorePart1->TotalNonCompliance;
                                    $totalAssess = $get_totalAssess->totalAssess;

                                    $percent = ($totalNonCompliance / $totalAssess);


                                    $objPHPExcel->getActiveSheet()->setCellValue($col2 . $row2, $indicator_name);
                                    $col2++;
                                    $objPHPExcel->getActiveSheet()->setCellValue($col2 . $row2, $totalNonCompliance);
                                    $col2++;
                                    $objPHPExcel->getActiveSheet()->setCellValue($col2 . $row2, $percent);
                                    $objPHPExcel->getActiveSheet()->getStyle($col2 . $row2)
                                        ->getNumberFormat()->applyFromArray(
                                            array(
                                                'code' => PHPExcel_Style_NumberFormat::FORMAT_PERCENTAGE_00
                                            )
                                        );
                                    if ($col2 == 'D') {
                                        $col2 = 'B';
                                    }
                                    $row2++;
                                }
                            endforeach;
                        }
                    endforeach;
                    //Part2
                    $col2 = 'A';
                    $objPHPExcel->getActiveSheet()->setCellValue($col2 . $row2, $secondMotherIndicator->indicator_name);
                    $col2++;
                    $row2++;
                    foreach ($getPart2 as $secondPartIndicator):
                        if ($secondPartIndicator->indicator_checklist_id == 1) {
                            $arr = explode("-", $secondPartIndicator->indicator_id);
                            $indicatorID = $arr[0];
                            foreach ($getScorePart1 as $scorePart1):
                                if ($scorePart1->indicator_id == $secondPartIndicator->indicator_id) {
                                    $indicator_name = $indicatorID . '.' . $secondPartIndicator->indicator_name;
                                    $totalNonCompliance = $scorePart1->TotalNonCompliance;
                                    $totalAssess = $get_totalAssess->totalAssess;

                                    $percent = ($totalNonCompliance / $totalAssess);

                                    $objPHPExcel->getActiveSheet()->setCellValue($col2 . $row2, $indicator_name);
                                    $col2++;
                                    $objPHPExcel->getActiveSheet()->setCellValue($col2 . $row2, $totalNonCompliance);
                                    $col2++;
                                    $objPHPExcel->getActiveSheet()->setCellValue($col2 . $row2, $percent);
                                    $objPHPExcel->getActiveSheet()->getStyle($col2 . $row2)
                                        ->getNumberFormat()->applyFromArray(
                                            array(
                                                'code' => PHPExcel_Style_NumberFormat::FORMAT_PERCENTAGE_00
                                            )
                                        );
                                    if ($col2 == 'D') {
                                        $col2 = 'B';
                                    }
                                    $row2++;
                                }
                            endforeach;
                        }
                    endforeach;
                    //Part3
                    $col2 = 'A';
                    $objPHPExcel->getActiveSheet()->setCellValue($col2 . $row2, $thirdMotherIndicator->indicator_name);
                    $col2++;
                    $row2++;
                    foreach ($getPart3 as $thirdPartIndicator):
                        if ($thirdPartIndicator->indicator_checklist_id == 1) {
                            $arr = explode("-", $thirdPartIndicator->indicator_id);
                            $indicatorID = $arr[0];
                            foreach ($getScorePart1 as $scorePart1):
                                if ($scorePart1->indicator_id == $thirdPartIndicator->indicator_id) {
                                    $indicator_name = $indicatorID . '.' . $thirdPartIndicator->indicator_name;
                                    $totalNonCompliance = $scorePart1->TotalNonCompliance;
                                    $totalAssess = $get_totalAssess->totalAssess;

                                    $percent = ($totalNonCompliance / $totalAssess);

                                    $objPHPExcel->getActiveSheet()->setCellValue($col2 . $row2, $indicator_name);
                                    $col2++;
                                    $objPHPExcel->getActiveSheet()->setCellValue($col2 . $row2, $totalNonCompliance);
                                    $col2++;
                                    $objPHPExcel->getActiveSheet()->setCellValue($col2 . $row2, $percent);
                                    $objPHPExcel->getActiveSheet()->getStyle($col2 . $row2)
                                        ->getNumberFormat()->applyFromArray(
                                            array(
                                                'code' => PHPExcel_Style_NumberFormat::FORMAT_PERCENTAGE_00
                                            )
                                        );
                                    if ($col2 == 'D') {
                                        $col2 = 'B';
                                    }
                                    $row2++;
                                }
                            endforeach;
                        }
                    endforeach;
                    //Part4
                    $col2 = 'A';
                    $objPHPExcel->getActiveSheet()->setCellValue($col2 . $row2, $fourthMotherIndicator->indicator_name);
                    $col2++;
                    $row2++;
                    foreach ($getPart4 as $fourthPartIndicator):
                        if ($fourthPartIndicator->indicator_checklist_id == 1) {
                            $arr = explode("-", $fourthPartIndicator->indicator_id);
                            $indicatorID = $arr[0];
                            foreach ($getScorePart1 as $scorePart1):
                                if ($scorePart1->indicator_id == $fourthPartIndicator->indicator_id) {
                                    $indicator_name = $indicatorID . '.' . $fourthPartIndicator->indicator_name;
                                    $totalNonCompliance = $scorePart1->TotalNonCompliance;
                                    $totalAssess = $get_totalAssess->totalAssess;

                                    $percent = ($totalNonCompliance / $totalAssess);

                                    $objPHPExcel->getActiveSheet()->setCellValue($col2 . $row2, $indicator_name);
                                    $col2++;
                                    $objPHPExcel->getActiveSheet()->setCellValue($col2 . $row2, $totalNonCompliance);
                                    $col2++;
                                    $objPHPExcel->getActiveSheet()->setCellValue($col2 . $row2, $percent);
                                    $objPHPExcel->getActiveSheet()->getStyle($col2 . $row2)
                                        ->getNumberFormat()->applyFromArray(
                                            array(
                                                'code' => PHPExcel_Style_NumberFormat::FORMAT_PERCENTAGE_00
                                            )
                                        );
                                    if ($col2 == 'D') {
                                        $col2 = 'B';
                                    }
                                    $row2++;
                                }
                            endforeach;
                        }
                    endforeach;

//End Editing

//    //border
                    $objPHPExcel->getActiveSheet()->getStyle(
                        'A1:' .
                        $objPHPExcel->getActiveSheet()->getHighestColumn() .
                        $objPHPExcel->getActiveSheet()->getHighestRow()
                    )->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
// Rename worksheet (worksheet, not filename)
                    $objPHPExcel->setActiveSheetIndex(0)->setTitle($region->prov_name);
                    // Add new sheet

                }
                $sheet++;
            endforeach;
        } elseif($lguType == 2){
            foreach ($get_AllCityByProv as $region):

                $firstMotherIndicator = $indicator_model->getFirstMotherIndicator();
                $secondMotherIndicator = $indicator_model->getSecondMotherIndicator();
                $fourthMotherIndicator = $indicator_model->getFourthMotherIndicator();
                $thirdMotherIndicator = $indicator_model->getThirdMotherIndicator();

                $getScorePart1 = $indicator_model->getScorePart1($regCode, $provCode, $lguType);
                $getPart1 = $indicator_model->getPart1($lguType);
                $getPart2 = $indicator_model->getPart2($lguType);
                $getPart3 = $indicator_model->getPart3($lguType);
                $getPart4 = $indicator_model->getPart4($lguType);
                $get_totalAssess = $reports_model->get_totalAssess($regCode, $provCode, $lguType);
                if ($sheet > 0) {
                    $objWorksheet = new PHPExcel_Worksheet($objPHPExcel);
                    $objPHPExcel->addSheet($objWorksheet);

// Add some data

                    $objWorksheet->setCellValue('B1', 'Sample Title');

                    //autosize column

                    $objWorksheet->getColumnDimension('B')->setAutoSize(true);
                    $objWorksheet->getColumnDimension('A')->setAutoSize(true);
                    $objWorksheet->getStyle('B1')->getFill()->getStartColor()->setRGB('FF0000');
//        $objWorksheet->getDefaultRowDimension()->setRowHeight(-1);a
                    $objWorksheet->getRowDimension(1)->setRowHeight(-1);
                    $objWorksheet->getStyle('B1')->getFont()->setBold(true);
                    $objWorksheet->getStyle('B1')->getFont()->setSize(20);
                    $objWorksheet->mergeCells('B1:E2');

                    //Center text merge columns
                    $objWorksheet->getStyle('B1')->getAlignment()->applyFromArray(
                        array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,));
//    $col = 'A';
//        $row = 5;
                    $objWorksheet->setCellValue('A3', 'Areas');
                    $objWorksheet->getStyle('A3')->getFont()->setBold(true);
                    $objWorksheet->setCellValue('B3', 'Distribution of functional by Province -Sample title');
                    $objWorksheet->mergeCells('A3:A5');
                    $objWorksheet->mergeCells('B3:E3');
                    //Center text merge columns
                    $objWorksheet->getStyle('B3')->getAlignment()->applyFromArray(
                        array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,));
                    $objWorksheet->getStyle('A3')->getAlignment()->applyFromArray(
                        array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,));

                    $objWorksheet->getStyle('A3')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);

                    $objWorksheet->mergeCells('B6:e6');
                    $objWorksheet->freezePane('B6');
                    //Header
                    $objWorksheet->setCellValue('B4', 'Indicators');

                    $objWorksheet->getStyle('B4')->getAlignment()->applyFromArray(
                        array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,));
                    $objWorksheet->setCellValue('C4', 'Non-Compliant');
                    $objWorksheet->getColumnDimension('C')->setAutoSize(true);
                    $objWorksheet->getStyle('C4')->getAlignment()->applyFromArray(
                        array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,));
                    $objWorksheet->setCellValue('D4', 'Percent');
                    $objWorksheet->getColumnDimension('D')->setAutoSize(true);
                    $objWorksheet->getStyle('D4')->getAlignment()->applyFromArray(
                        array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,));


//Start Editing
                    //Part1
                    $row2 = 7;
                    $col2 = 'A';
                    $objWorksheet->setCellValue($col2 . $row2, $firstMotherIndicator->indicator_name);
                    $col2++;
                    $row2++;
                    foreach ($getPart1 as $firstPartIndicator):
                        if ($firstPartIndicator->indicator_checklist_id == 1) {
                            $arr = explode("-", $firstPartIndicator->indicator_id);
                            $indicatorID = $arr[0];
                            foreach ($getScorePart1 as $scorePart1):
                                if ($scorePart1->indicator_id == $firstPartIndicator->indicator_id) {
                                    $indicator_name = $indicatorID . '.' . $firstPartIndicator->indicator_name;
                                    $totalNonCompliance = $scorePart1->TotalNonCompliance;
                                    $totalAssess = $get_totalAssess->totalAssess;

                                    $percent = ($totalNonCompliance / $totalAssess);


                                    $objWorksheet->setCellValue($col2 . $row2, $indicator_name);
                                    $col2++;
                                    $objWorksheet->setCellValue($col2 . $row2, $totalNonCompliance);
                                    $col2++;
                                    $objWorksheet->setCellValue($col2 . $row2, $percent);
                                    $objWorksheet->getStyle($col2 . $row2)
                                        ->getNumberFormat()->applyFromArray(
                                            array(
                                                'code' => PHPExcel_Style_NumberFormat::FORMAT_PERCENTAGE_00
                                            )
                                        );
                                    if ($col2 == 'D') {
                                        $col2 = 'B';
                                    }
                                    $row2++;
                                }
                            endforeach;
                        }
                    endforeach;
                    //Part2
                    $col2 = 'A';
                    $objWorksheet->setCellValue($col2 . $row2, $secondMotherIndicator->indicator_name);
                    $col2++;
                    $row2++;
                    foreach ($getPart2 as $secondPartIndicator):
                        if ($secondPartIndicator->indicator_checklist_id == 1) {
                            $arr = explode("-", $secondPartIndicator->indicator_id);
                            $indicatorID = $arr[0];
                            foreach ($getScorePart1 as $scorePart1):
                                if ($scorePart1->indicator_id == $secondPartIndicator->indicator_id) {
                                    $indicator_name = $indicatorID . '.' . $secondPartIndicator->indicator_name;
                                    $totalNonCompliance = $scorePart1->TotalNonCompliance;
                                    $totalAssess = $get_totalAssess->totalAssess;

                                    $percent = ($totalNonCompliance / $totalAssess);

                                    $objWorksheet->setCellValue($col2 . $row2, $indicator_name);
                                    $col2++;
                                    $objWorksheet->setCellValue($col2 . $row2, $totalNonCompliance);
                                    $col2++;
                                    $objWorksheet->setCellValue($col2 . $row2, $percent);
                                    $objWorksheet->getStyle($col2 . $row2)
                                        ->getNumberFormat()->applyFromArray(
                                            array(
                                                'code' => PHPExcel_Style_NumberFormat::FORMAT_PERCENTAGE_00
                                            )
                                        );
                                    if ($col2 == 'D') {
                                        $col2 = 'B';
                                    }
                                    $row2++;
                                }
                            endforeach;
                        }
                    endforeach;
                    //Part3
                    $col2 = 'A';
                    $objWorksheet->setCellValue($col2 . $row2, $thirdMotherIndicator->indicator_name);
                    $col2++;
                    $row2++;
                    foreach ($getPart3 as $thirdPartIndicator):
                        if ($thirdPartIndicator->indicator_checklist_id == 1) {
                            $arr = explode("-", $thirdPartIndicator->indicator_id);
                            $indicatorID = $arr[0];
                            foreach ($getScorePart1 as $scorePart1):
                                if ($scorePart1->indicator_id == $thirdPartIndicator->indicator_id) {
                                    $indicator_name = $indicatorID . '.' . $thirdPartIndicator->indicator_name;
                                    $totalNonCompliance = $scorePart1->TotalNonCompliance;
                                    $totalAssess = $get_totalAssess->totalAssess;

                                    $percent = ($totalNonCompliance / $totalAssess);

                                    $objWorksheet->setCellValue($col2 . $row2, $indicator_name);
                                    $col2++;
                                    $objWorksheet->setCellValue($col2 . $row2, $totalNonCompliance);
                                    $col2++;
                                    $objWorksheet->setCellValue($col2 . $row2, $percent);
                                    $objWorksheet->getStyle($col2 . $row2)
                                        ->getNumberFormat()->applyFromArray(
                                            array(
                                                'code' => PHPExcel_Style_NumberFormat::FORMAT_PERCENTAGE_00
                                            )
                                        );
                                    if ($col2 == 'D') {
                                        $col2 = 'B';
                                    }
                                    $row2++;
                                }
                            endforeach;
                        }
                    endforeach;
                    //Part4
                    $col2 = 'A';
                    $objWorksheet->setCellValue($col2 . $row2, $fourthMotherIndicator->indicator_name);
                    $col2++;
                    $row2++;
                    foreach ($getPart4 as $fourthPartIndicator):
                        if ($fourthPartIndicator->indicator_checklist_id == 1) {
                            $arr = explode("-", $fourthPartIndicator->indicator_id);
                            $indicatorID = $arr[0];
                            foreach ($getScorePart1 as $scorePart1):
                                if ($scorePart1->indicator_id == $fourthPartIndicator->indicator_id) {
                                    $indicator_name = $indicatorID . '.' . $fourthPartIndicator->indicator_name;
                                    $totalNonCompliance = $scorePart1->TotalNonCompliance;
                                    $totalAssess = $get_totalAssess->totalAssess;

                                    $percent = ($totalNonCompliance / $totalAssess);

                                    $objWorksheet->setCellValue($col2 . $row2, $indicator_name);
                                    $col2++;
                                    $objWorksheet->setCellValue($col2 . $row2, $totalNonCompliance);
                                    $col2++;
                                    $objWorksheet->setCellValue($col2 . $row2, $percent);
                                    $objWorksheet->getStyle($col2 . $row2)
                                        ->getNumberFormat()->applyFromArray(
                                            array(
                                                'code' => PHPExcel_Style_NumberFormat::FORMAT_PERCENTAGE_00
                                            )
                                        );
                                    if ($col2 == 'D') {
                                        $col2 = 'B';
                                    }
                                    $row2++;
                                }
                            endforeach;
                        }
                    endforeach;

//End Editing

//    //border
                    $objWorksheet->getStyle(
                        'A1:' .
                        $objWorksheet->getHighestColumn() .
                        $objWorksheet->getHighestRow()
                    )->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
// Rename worksheet (worksheet, not filename)
                    // Add new sheet

                    $objWorksheet->setTitle($region->city_name);
                } else {
// Add some data

                    $objPHPExcel->getActiveSheet()->setCellValue('B1', 'Sample Title');

                    //autosize column

                    $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
                    $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
                    $objPHPExcel->getActiveSheet()->getStyle('B1')->getFill()->getStartColor()->setRGB('FF0000');
//        $objPHPExcel->getActiveSheet()->getDefaultRowDimension()->setRowHeight(-1);a
                    $objPHPExcel->getActiveSheet()->getRowDimension(1)->setRowHeight(-1);
                    $objPHPExcel->getActiveSheet()->getStyle('B1')->getFont()->setBold(true);
                    $objPHPExcel->getActiveSheet()->getStyle('B1')->getFont()->setSize(20);
                    $objPHPExcel->getActiveSheet()->mergeCells('B1:E2');

                    //Center text merge columns
                    $objPHPExcel->getActiveSheet()->getStyle('B1')->getAlignment()->applyFromArray(
                        array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,));
//    $col = 'A';
//        $row = 5;
                    $objPHPExcel->getActiveSheet()->setCellValue('A3', 'Areas');
                    $objPHPExcel->getActiveSheet()->getStyle('A3')->getFont()->setBold(true);
                    $objPHPExcel->getActiveSheet()->setCellValue('B3', 'Distribution of functional by Province -Sample title');
                    $objPHPExcel->getActiveSheet()->mergeCells('A3:A5');
                    $objPHPExcel->getActiveSheet()->mergeCells('B3:E3');
                    //Center text merge columns
                    $objPHPExcel->getActiveSheet()->getStyle('B3')->getAlignment()->applyFromArray(
                        array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,));
                    $objPHPExcel->getActiveSheet()->getStyle('A3')->getAlignment()->applyFromArray(
                        array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,));

                    $objPHPExcel->getActiveSheet()->getStyle('A3')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);

                    $objPHPExcel->getActiveSheet()->mergeCells('B6:e6');
                    $objPHPExcel->getActiveSheet()->freezePane('B6');
                    //Header
                    $objPHPExcel->getActiveSheet()->setCellValue('B4', 'Indicators');

                    $objPHPExcel->getActiveSheet()->getStyle('B4')->getAlignment()->applyFromArray(
                        array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,));
                    $objPHPExcel->getActiveSheet()->setCellValue('C4', 'Non-Compliant');
                    $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
                    $objPHPExcel->getActiveSheet()->getStyle('C4')->getAlignment()->applyFromArray(
                        array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,));
                    $objPHPExcel->getActiveSheet()->setCellValue('D4', 'Percent');
                    $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
                    $objPHPExcel->getActiveSheet()->getStyle('D4')->getAlignment()->applyFromArray(
                        array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,));


//Start Editing
                    //Part1
                    $row2 = 7;
                    $col2 = 'A';
                    $objPHPExcel->getActiveSheet()->setCellValue($col2 . $row2, $firstMotherIndicator->indicator_name);
                    $col2++;
                    $row2++;
                    foreach ($getPart1 as $firstPartIndicator):
                        if ($firstPartIndicator->indicator_checklist_id == 1) {
                            $arr = explode("-", $firstPartIndicator->indicator_id);
                            $indicatorID = $arr[0];
                            foreach ($getScorePart1 as $scorePart1):
                                if ($scorePart1->indicator_id == $firstPartIndicator->indicator_id) {
                                    $indicator_name = $indicatorID . '.' . $firstPartIndicator->indicator_name;
                                    $totalNonCompliance = $scorePart1->TotalNonCompliance;
                                    $totalAssess = $get_totalAssess->totalAssess;

                                    $percent = ($totalNonCompliance / $totalAssess);


                                    $objPHPExcel->getActiveSheet()->setCellValue($col2 . $row2, $indicator_name);
                                    $col2++;
                                    $objPHPExcel->getActiveSheet()->setCellValue($col2 . $row2, $totalNonCompliance);
                                    $col2++;
                                    $objPHPExcel->getActiveSheet()->setCellValue($col2 . $row2, $percent);
                                    $objPHPExcel->getActiveSheet()->getStyle($col2 . $row2)
                                        ->getNumberFormat()->applyFromArray(
                                            array(
                                                'code' => PHPExcel_Style_NumberFormat::FORMAT_PERCENTAGE_00
                                            )
                                        );
                                    if ($col2 == 'D') {
                                        $col2 = 'B';
                                    }
                                    $row2++;
                                }
                            endforeach;
                        }
                    endforeach;
                    //Part2
                    $col2 = 'A';
                    $objPHPExcel->getActiveSheet()->setCellValue($col2 . $row2, $secondMotherIndicator->indicator_name);
                    $col2++;
                    $row2++;
                    foreach ($getPart2 as $secondPartIndicator):
                        if ($secondPartIndicator->indicator_checklist_id == 1) {
                            $arr = explode("-", $secondPartIndicator->indicator_id);
                            $indicatorID = $arr[0];
                            foreach ($getScorePart1 as $scorePart1):
                                if ($scorePart1->indicator_id == $secondPartIndicator->indicator_id) {
                                    $indicator_name = $indicatorID . '.' . $secondPartIndicator->indicator_name;
                                    $totalNonCompliance = $scorePart1->TotalNonCompliance;
                                    $totalAssess = $get_totalAssess->totalAssess;

                                    $percent = ($totalNonCompliance / $totalAssess);

                                    $objPHPExcel->getActiveSheet()->setCellValue($col2 . $row2, $indicator_name);
                                    $col2++;
                                    $objPHPExcel->getActiveSheet()->setCellValue($col2 . $row2, $totalNonCompliance);
                                    $col2++;
                                    $objPHPExcel->getActiveSheet()->setCellValue($col2 . $row2, $percent);
                                    $objPHPExcel->getActiveSheet()->getStyle($col2 . $row2)
                                        ->getNumberFormat()->applyFromArray(
                                            array(
                                                'code' => PHPExcel_Style_NumberFormat::FORMAT_PERCENTAGE_00
                                            )
                                        );
                                    if ($col2 == 'D') {
                                        $col2 = 'B';
                                    }
                                    $row2++;
                                }
                            endforeach;
                        }
                    endforeach;
                    //Part3
                    $col2 = 'A';
                    $objPHPExcel->getActiveSheet()->setCellValue($col2 . $row2, $thirdMotherIndicator->indicator_name);
                    $col2++;
                    $row2++;
                    foreach ($getPart3 as $thirdPartIndicator):
                        if ($thirdPartIndicator->indicator_checklist_id == 1) {
                            $arr = explode("-", $thirdPartIndicator->indicator_id);
                            $indicatorID = $arr[0];
                            foreach ($getScorePart1 as $scorePart1):
                                if ($scorePart1->indicator_id == $thirdPartIndicator->indicator_id) {
                                    $indicator_name = $indicatorID . '.' . $thirdPartIndicator->indicator_name;
                                    $totalNonCompliance = $scorePart1->TotalNonCompliance;
                                    $totalAssess = $get_totalAssess->totalAssess;

                                    $percent = ($totalNonCompliance / $totalAssess);

                                    $objPHPExcel->getActiveSheet()->setCellValue($col2 . $row2, $indicator_name);
                                    $col2++;
                                    $objPHPExcel->getActiveSheet()->setCellValue($col2 . $row2, $totalNonCompliance);
                                    $col2++;
                                    $objPHPExcel->getActiveSheet()->setCellValue($col2 . $row2, $percent);
                                    $objPHPExcel->getActiveSheet()->getStyle($col2 . $row2)
                                        ->getNumberFormat()->applyFromArray(
                                            array(
                                                'code' => PHPExcel_Style_NumberFormat::FORMAT_PERCENTAGE_00
                                            )
                                        );
                                    if ($col2 == 'D') {
                                        $col2 = 'B';
                                    }
                                    $row2++;
                                }
                            endforeach;
                        }
                    endforeach;
                    //Part4
                    $col2 = 'A';
                    $objPHPExcel->getActiveSheet()->setCellValue($col2 . $row2, $fourthMotherIndicator->indicator_name);
                    $col2++;
                    $row2++;
                    foreach ($getPart4 as $fourthPartIndicator):
                        if ($fourthPartIndicator->indicator_checklist_id == 1) {
                            $arr = explode("-", $fourthPartIndicator->indicator_id);
                            $indicatorID = $arr[0];
                            foreach ($getScorePart1 as $scorePart1):
                                if ($scorePart1->indicator_id == $fourthPartIndicator->indicator_id) {
                                    $indicator_name = $indicatorID . '.' . $fourthPartIndicator->indicator_name;
                                    $totalNonCompliance = $scorePart1->TotalNonCompliance;
                                    $totalAssess = $get_totalAssess->totalAssess;

                                    $percent = ($totalNonCompliance / $totalAssess);

                                    $objPHPExcel->getActiveSheet()->setCellValue($col2 . $row2, $indicator_name);
                                    $col2++;
                                    $objPHPExcel->getActiveSheet()->setCellValue($col2 . $row2, $totalNonCompliance);
                                    $col2++;
                                    $objPHPExcel->getActiveSheet()->setCellValue($col2 . $row2, $percent);
                                    $objPHPExcel->getActiveSheet()->getStyle($col2 . $row2)
                                        ->getNumberFormat()->applyFromArray(
                                            array(
                                                'code' => PHPExcel_Style_NumberFormat::FORMAT_PERCENTAGE_00
                                            )
                                        );
                                    if ($col2 == 'D') {
                                        $col2 = 'B';
                                    }
                                    $row2++;
                                }
                            endforeach;
                        }
                    endforeach;

//End Editing

//    //border
                    $objPHPExcel->getActiveSheet()->getStyle(
                        'A1:' .
                        $objPHPExcel->getActiveSheet()->getHighestColumn() .
                        $objPHPExcel->getActiveSheet()->getHighestRow()
                    )->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
// Rename worksheet (worksheet, not filename)
                    $objPHPExcel->setActiveSheetIndex(0)->setTitle($region->city_name);
                    // Add new sheet

                }
                $sheet++;
            endforeach;
        } elseif($lguType == 3){
            foreach ($get_AllMuniByProv as $region):

                $firstMotherIndicator = $indicator_model->getFirstMotherIndicator();
                $secondMotherIndicator = $indicator_model->getSecondMotherIndicator();
                $fourthMotherIndicator = $indicator_model->getFourthMotherIndicator();
                $thirdMotherIndicator = $indicator_model->getThirdMotherIndicator();

                $getScorePart1 = $indicator_model->getScorePart1($regCode, $provCode, $lguType);
                $getPart1 = $indicator_model->getPart1($lguType);
                $getPart2 = $indicator_model->getPart2($lguType);
                $getPart3 = $indicator_model->getPart3($lguType);
                $getPart4 = $indicator_model->getPart4($lguType);
                $get_totalAssess = $reports_model->get_totalAssess($regCode, $provCode, $lguType);
                if ($sheet > 0) {
                    $objWorksheet = new PHPExcel_Worksheet($objPHPExcel);
                    $objPHPExcel->addSheet($objWorksheet);

// Add some data

                    $objWorksheet->setCellValue('B1', 'Sample Title');

                    //autosize column

                    $objWorksheet->getColumnDimension('B')->setAutoSize(true);
                    $objWorksheet->getColumnDimension('A')->setAutoSize(true);
                    $objWorksheet->getStyle('B1')->getFill()->getStartColor()->setRGB('FF0000');
//        $objWorksheet->getDefaultRowDimension()->setRowHeight(-1);a
                    $objWorksheet->getRowDimension(1)->setRowHeight(-1);
                    $objWorksheet->getStyle('B1')->getFont()->setBold(true);
                    $objWorksheet->getStyle('B1')->getFont()->setSize(20);
                    $objWorksheet->mergeCells('B1:E2');

                    //Center text merge columns
                    $objWorksheet->getStyle('B1')->getAlignment()->applyFromArray(
                        array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,));
//    $col = 'A';
//        $row = 5;
                    $objWorksheet->setCellValue('A3', 'Areas');
                    $objWorksheet->getStyle('A3')->getFont()->setBold(true);
                    $objWorksheet->setCellValue('B3', 'Distribution of functional by Province -Sample title');
                    $objWorksheet->mergeCells('A3:A5');
                    $objWorksheet->mergeCells('B3:E3');
                    //Center text merge columns
                    $objWorksheet->getStyle('B3')->getAlignment()->applyFromArray(
                        array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,));
                    $objWorksheet->getStyle('A3')->getAlignment()->applyFromArray(
                        array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,));

                    $objWorksheet->getStyle('A3')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);

                    $objWorksheet->mergeCells('B6:e6');
                    $objWorksheet->freezePane('B6');
                    //Header
                    $objWorksheet->setCellValue('B4', 'Indicators');

                    $objWorksheet->getStyle('B4')->getAlignment()->applyFromArray(
                        array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,));
                    $objWorksheet->setCellValue('C4', 'Non-Compliant');
                    $objWorksheet->getColumnDimension('C')->setAutoSize(true);
                    $objWorksheet->getStyle('C4')->getAlignment()->applyFromArray(
                        array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,));
                    $objWorksheet->setCellValue('D4', 'Percent');
                    $objWorksheet->getColumnDimension('D')->setAutoSize(true);
                    $objWorksheet->getStyle('D4')->getAlignment()->applyFromArray(
                        array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,));


//Start Editing
                    //Part1
                    $row2 = 7;
                    $col2 = 'A';
                    $objWorksheet->setCellValue($col2 . $row2, $firstMotherIndicator->indicator_name);
                    $col2++;
                    $row2++;
                    foreach ($getPart1 as $firstPartIndicator):
                        if ($firstPartIndicator->indicator_checklist_id == 1) {
                            $arr = explode("-", $firstPartIndicator->indicator_id);
                            $indicatorID = $arr[0];
                            foreach ($getScorePart1 as $scorePart1):
                                if ($scorePart1->indicator_id == $firstPartIndicator->indicator_id) {
                                    $indicator_name = $indicatorID . '.' . $firstPartIndicator->indicator_name;
                                    $totalNonCompliance = $scorePart1->TotalNonCompliance;
                                    $totalAssess = $get_totalAssess->totalAssess;

                                    $percent = ($totalNonCompliance / $totalAssess);


                                    $objWorksheet->setCellValue($col2 . $row2, $indicator_name);
                                    $col2++;
                                    $objWorksheet->setCellValue($col2 . $row2, $totalNonCompliance);
                                    $col2++;
                                    $objWorksheet->setCellValue($col2 . $row2, $percent);
                                    $objWorksheet->getStyle($col2 . $row2)
                                        ->getNumberFormat()->applyFromArray(
                                            array(
                                                'code' => PHPExcel_Style_NumberFormat::FORMAT_PERCENTAGE_00
                                            )
                                        );
                                    if ($col2 == 'D') {
                                        $col2 = 'B';
                                    }
                                    $row2++;
                                }
                            endforeach;
                        }
                    endforeach;
                    //Part2
                    $col2 = 'A';
                    $objWorksheet->setCellValue($col2 . $row2, $secondMotherIndicator->indicator_name);
                    $col2++;
                    $row2++;
                    foreach ($getPart2 as $secondPartIndicator):
                        if ($secondPartIndicator->indicator_checklist_id == 1) {
                            $arr = explode("-", $secondPartIndicator->indicator_id);
                            $indicatorID = $arr[0];
                            foreach ($getScorePart1 as $scorePart1):
                                if ($scorePart1->indicator_id == $secondPartIndicator->indicator_id) {
                                    $indicator_name = $indicatorID . '.' . $secondPartIndicator->indicator_name;
                                    $totalNonCompliance = $scorePart1->TotalNonCompliance;
                                    $totalAssess = $get_totalAssess->totalAssess;

                                    $percent = ($totalNonCompliance / $totalAssess);

                                    $objWorksheet->setCellValue($col2 . $row2, $indicator_name);
                                    $col2++;
                                    $objWorksheet->setCellValue($col2 . $row2, $totalNonCompliance);
                                    $col2++;
                                    $objWorksheet->setCellValue($col2 . $row2, $percent);
                                    $objWorksheet->getStyle($col2 . $row2)
                                        ->getNumberFormat()->applyFromArray(
                                            array(
                                                'code' => PHPExcel_Style_NumberFormat::FORMAT_PERCENTAGE_00
                                            )
                                        );
                                    if ($col2 == 'D') {
                                        $col2 = 'B';
                                    }
                                    $row2++;
                                }
                            endforeach;
                        }
                    endforeach;
                    //Part3
                    $col2 = 'A';
                    $objWorksheet->setCellValue($col2 . $row2, $thirdMotherIndicator->indicator_name);
                    $col2++;
                    $row2++;
                    foreach ($getPart3 as $thirdPartIndicator):
                        if ($thirdPartIndicator->indicator_checklist_id == 1) {
                            $arr = explode("-", $thirdPartIndicator->indicator_id);
                            $indicatorID = $arr[0];
                            foreach ($getScorePart1 as $scorePart1):
                                if ($scorePart1->indicator_id == $thirdPartIndicator->indicator_id) {
                                    $indicator_name = $indicatorID . '.' . $thirdPartIndicator->indicator_name;
                                    $totalNonCompliance = $scorePart1->TotalNonCompliance;
                                    $totalAssess = $get_totalAssess->totalAssess;

                                    $percent = ($totalNonCompliance / $totalAssess);

                                    $objWorksheet->setCellValue($col2 . $row2, $indicator_name);
                                    $col2++;
                                    $objWorksheet->setCellValue($col2 . $row2, $totalNonCompliance);
                                    $col2++;
                                    $objWorksheet->setCellValue($col2 . $row2, $percent);
                                    $objWorksheet->getStyle($col2 . $row2)
                                        ->getNumberFormat()->applyFromArray(
                                            array(
                                                'code' => PHPExcel_Style_NumberFormat::FORMAT_PERCENTAGE_00
                                            )
                                        );
                                    if ($col2 == 'D') {
                                        $col2 = 'B';
                                    }
                                    $row2++;
                                }
                            endforeach;
                        }
                    endforeach;
                    //Part4
                    $col2 = 'A';
                    $objWorksheet->setCellValue($col2 . $row2, $fourthMotherIndicator->indicator_name);
                    $col2++;
                    $row2++;
                    foreach ($getPart4 as $fourthPartIndicator):
                        if ($fourthPartIndicator->indicator_checklist_id == 1) {
                            $arr = explode("-", $fourthPartIndicator->indicator_id);
                            $indicatorID = $arr[0];
                            foreach ($getScorePart1 as $scorePart1):
                                if ($scorePart1->indicator_id == $fourthPartIndicator->indicator_id) {
                                    $indicator_name = $indicatorID . '.' . $fourthPartIndicator->indicator_name;
                                    $totalNonCompliance = $scorePart1->TotalNonCompliance;
                                    $totalAssess = $get_totalAssess->totalAssess;

                                    $percent = ($totalNonCompliance / $totalAssess);

                                    $objWorksheet->setCellValue($col2 . $row2, $indicator_name);
                                    $col2++;
                                    $objWorksheet->setCellValue($col2 . $row2, $totalNonCompliance);
                                    $col2++;
                                    $objWorksheet->setCellValue($col2 . $row2, $percent);
                                    $objWorksheet->getStyle($col2 . $row2)
                                        ->getNumberFormat()->applyFromArray(
                                            array(
                                                'code' => PHPExcel_Style_NumberFormat::FORMAT_PERCENTAGE_00
                                            )
                                        );
                                    if ($col2 == 'D') {
                                        $col2 = 'B';
                                    }
                                    $row2++;
                                }
                            endforeach;
                        }
                    endforeach;

//End Editing

//    //border
                    $objWorksheet->getStyle(
                        'A1:' .
                        $objWorksheet->getHighestColumn() .
                        $objWorksheet->getHighestRow()
                    )->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
// Rename worksheet (worksheet, not filename)
                    // Add new sheet

                    $objWorksheet->setTitle($region->city_name);
                } else {
// Add some data

                    $objPHPExcel->getActiveSheet()->setCellValue('B1', 'Sample Title');

                    //autosize column

                    $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
                    $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
                    $objPHPExcel->getActiveSheet()->getStyle('B1')->getFill()->getStartColor()->setRGB('FF0000');
//        $objPHPExcel->getActiveSheet()->getDefaultRowDimension()->setRowHeight(-1);a
                    $objPHPExcel->getActiveSheet()->getRowDimension(1)->setRowHeight(-1);
                    $objPHPExcel->getActiveSheet()->getStyle('B1')->getFont()->setBold(true);
                    $objPHPExcel->getActiveSheet()->getStyle('B1')->getFont()->setSize(20);
                    $objPHPExcel->getActiveSheet()->mergeCells('B1:E2');

                    //Center text merge columns
                    $objPHPExcel->getActiveSheet()->getStyle('B1')->getAlignment()->applyFromArray(
                        array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,));
//    $col = 'A';
//        $row = 5;
                    $objPHPExcel->getActiveSheet()->setCellValue('A3', 'Areas');
                    $objPHPExcel->getActiveSheet()->getStyle('A3')->getFont()->setBold(true);
                    $objPHPExcel->getActiveSheet()->setCellValue('B3', 'Distribution of functional by Province -Sample title');
                    $objPHPExcel->getActiveSheet()->mergeCells('A3:A5');
                    $objPHPExcel->getActiveSheet()->mergeCells('B3:E3');
                    //Center text merge columns
                    $objPHPExcel->getActiveSheet()->getStyle('B3')->getAlignment()->applyFromArray(
                        array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,));
                    $objPHPExcel->getActiveSheet()->getStyle('A3')->getAlignment()->applyFromArray(
                        array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,));

                    $objPHPExcel->getActiveSheet()->getStyle('A3')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);

                    $objPHPExcel->getActiveSheet()->mergeCells('B6:e6');
                    $objPHPExcel->getActiveSheet()->freezePane('B6');
                    //Header
                    $objPHPExcel->getActiveSheet()->setCellValue('B4', 'Indicators');

                    $objPHPExcel->getActiveSheet()->getStyle('B4')->getAlignment()->applyFromArray(
                        array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,));
                    $objPHPExcel->getActiveSheet()->setCellValue('C4', 'Non-Compliant');
                    $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
                    $objPHPExcel->getActiveSheet()->getStyle('C4')->getAlignment()->applyFromArray(
                        array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,));
                    $objPHPExcel->getActiveSheet()->setCellValue('D4', 'Percent');
                    $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
                    $objPHPExcel->getActiveSheet()->getStyle('D4')->getAlignment()->applyFromArray(
                        array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,));


//Start Editing
                    //Part1
                    $row2 = 7;
                    $col2 = 'A';
                    $objPHPExcel->getActiveSheet()->setCellValue($col2 . $row2, $firstMotherIndicator->indicator_name);
                    $col2++;
                    $row2++;
                    foreach ($getPart1 as $firstPartIndicator):
                        if ($firstPartIndicator->indicator_checklist_id == 1) {
                            $arr = explode("-", $firstPartIndicator->indicator_id);
                            $indicatorID = $arr[0];
                            foreach ($getScorePart1 as $scorePart1):
                                if ($scorePart1->indicator_id == $firstPartIndicator->indicator_id) {
                                    $indicator_name = $indicatorID . '.' . $firstPartIndicator->indicator_name;
                                    $totalNonCompliance = $scorePart1->TotalNonCompliance;
                                    $totalAssess = $get_totalAssess->totalAssess;

                                    $percent = ($totalNonCompliance / $totalAssess);


                                    $objPHPExcel->getActiveSheet()->setCellValue($col2 . $row2, $indicator_name);
                                    $col2++;
                                    $objPHPExcel->getActiveSheet()->setCellValue($col2 . $row2, $totalNonCompliance);
                                    $col2++;
                                    $objPHPExcel->getActiveSheet()->setCellValue($col2 . $row2, $percent);
                                    $objPHPExcel->getActiveSheet()->getStyle($col2 . $row2)
                                        ->getNumberFormat()->applyFromArray(
                                            array(
                                                'code' => PHPExcel_Style_NumberFormat::FORMAT_PERCENTAGE_00
                                            )
                                        );
                                    if ($col2 == 'D') {
                                        $col2 = 'B';
                                    }
                                    $row2++;
                                }
                            endforeach;
                        }
                    endforeach;
                    //Part2
                    $col2 = 'A';
                    $objPHPExcel->getActiveSheet()->setCellValue($col2 . $row2, $secondMotherIndicator->indicator_name);
                    $col2++;
                    $row2++;
                    foreach ($getPart2 as $secondPartIndicator):
                        if ($secondPartIndicator->indicator_checklist_id == 1) {
                            $arr = explode("-", $secondPartIndicator->indicator_id);
                            $indicatorID = $arr[0];
                            foreach ($getScorePart1 as $scorePart1):
                                if ($scorePart1->indicator_id == $secondPartIndicator->indicator_id) {
                                    $indicator_name = $indicatorID . '.' . $secondPartIndicator->indicator_name;
                                    $totalNonCompliance = $scorePart1->TotalNonCompliance;
                                    $totalAssess = $get_totalAssess->totalAssess;

                                    $percent = ($totalNonCompliance / $totalAssess);

                                    $objPHPExcel->getActiveSheet()->setCellValue($col2 . $row2, $indicator_name);
                                    $col2++;
                                    $objPHPExcel->getActiveSheet()->setCellValue($col2 . $row2, $totalNonCompliance);
                                    $col2++;
                                    $objPHPExcel->getActiveSheet()->setCellValue($col2 . $row2, $percent);
                                    $objPHPExcel->getActiveSheet()->getStyle($col2 . $row2)
                                        ->getNumberFormat()->applyFromArray(
                                            array(
                                                'code' => PHPExcel_Style_NumberFormat::FORMAT_PERCENTAGE_00
                                            )
                                        );
                                    if ($col2 == 'D') {
                                        $col2 = 'B';
                                    }
                                    $row2++;
                                }
                            endforeach;
                        }
                    endforeach;
                    //Part3
                    $col2 = 'A';
                    $objPHPExcel->getActiveSheet()->setCellValue($col2 . $row2, $thirdMotherIndicator->indicator_name);
                    $col2++;
                    $row2++;
                    foreach ($getPart3 as $thirdPartIndicator):
                        if ($thirdPartIndicator->indicator_checklist_id == 1) {
                            $arr = explode("-", $thirdPartIndicator->indicator_id);
                            $indicatorID = $arr[0];
                            foreach ($getScorePart1 as $scorePart1):
                                if ($scorePart1->indicator_id == $thirdPartIndicator->indicator_id) {
                                    $indicator_name = $indicatorID . '.' . $thirdPartIndicator->indicator_name;
                                    $totalNonCompliance = $scorePart1->TotalNonCompliance;
                                    $totalAssess = $get_totalAssess->totalAssess;

                                    $percent = ($totalNonCompliance / $totalAssess);

                                    $objPHPExcel->getActiveSheet()->setCellValue($col2 . $row2, $indicator_name);
                                    $col2++;
                                    $objPHPExcel->getActiveSheet()->setCellValue($col2 . $row2, $totalNonCompliance);
                                    $col2++;
                                    $objPHPExcel->getActiveSheet()->setCellValue($col2 . $row2, $percent);
                                    $objPHPExcel->getActiveSheet()->getStyle($col2 . $row2)
                                        ->getNumberFormat()->applyFromArray(
                                            array(
                                                'code' => PHPExcel_Style_NumberFormat::FORMAT_PERCENTAGE_00
                                            )
                                        );
                                    if ($col2 == 'D') {
                                        $col2 = 'B';
                                    }
                                    $row2++;
                                }
                            endforeach;
                        }
                    endforeach;
                    //Part4
                    $col2 = 'A';
                    $objPHPExcel->getActiveSheet()->setCellValue($col2 . $row2, $fourthMotherIndicator->indicator_name);
                    $col2++;
                    $row2++;
                    foreach ($getPart4 as $fourthPartIndicator):
                        if ($fourthPartIndicator->indicator_checklist_id == 1) {
                            $arr = explode("-", $fourthPartIndicator->indicator_id);
                            $indicatorID = $arr[0];
                            foreach ($getScorePart1 as $scorePart1):
                                if ($scorePart1->indicator_id == $fourthPartIndicator->indicator_id) {
                                    $indicator_name = $indicatorID . '.' . $fourthPartIndicator->indicator_name;
                                    $totalNonCompliance = $scorePart1->TotalNonCompliance;
                                    $totalAssess = $get_totalAssess->totalAssess;

                                    $percent = ($totalNonCompliance / $totalAssess);

                                    $objPHPExcel->getActiveSheet()->setCellValue($col2 . $row2, $indicator_name);
                                    $col2++;
                                    $objPHPExcel->getActiveSheet()->setCellValue($col2 . $row2, $totalNonCompliance);
                                    $col2++;
                                    $objPHPExcel->getActiveSheet()->setCellValue($col2 . $row2, $percent);
                                    $objPHPExcel->getActiveSheet()->getStyle($col2 . $row2)
                                        ->getNumberFormat()->applyFromArray(
                                            array(
                                                'code' => PHPExcel_Style_NumberFormat::FORMAT_PERCENTAGE_00
                                            )
                                        );
                                    if ($col2 == 'D') {
                                        $col2 = 'B';
                                    }
                                    $row2++;
                                }
                            endforeach;
                        }
                    endforeach;

//End Editing

//    //border
                    $objPHPExcel->getActiveSheet()->getStyle(
                        'A1:' .
                        $objPHPExcel->getActiveSheet()->getHighestColumn() .
                        $objPHPExcel->getActiveSheet()->getHighestRow()
                    )->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
// Rename worksheet (worksheet, not filename)
                    $objPHPExcel->setActiveSheetIndex(0)->setTitle($region->city_name);
                    // Add new sheet

                }
                $sheet++;
            endforeach;
        }

// Add some data

// Set active sheet index to the first sheet, so Excel opens this as the first asheet
        $objPHPExcel->setActiveSheetIndex(0);

// Redirect output to a client’s web browser (Excel2007)
//clean the output buffer
        ob_end_clean();

//this is the header given from PHPExcel examples. but the output seems somewhat corrupted in some cases.
//header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
//so, we use this header instead.
//    $regionName = $this->reports_model->getRegionName($region);
        $filename = 'Non-CompliantIndicator.xlsx';
        header('Content-type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename='.$filename);
        header('Cache-Control: max-age=0');

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        $objWriter->save('php://output');
    }*/ //nonCompliantPSWDOREAL
    public function nonCompliantPSWDO($regCode,$provCode,$lguType){


        $indicator_model = new indicator_model();
        $reports_model = new reports_model();
// Create new PHPExcel object
        $objPHPExcel = new PHPExcel();



                $firstMotherIndicator = $indicator_model->getFirstMotherIndicator();
                $secondMotherIndicator = $indicator_model->getSecondMotherIndicator();
                $fourthMotherIndicator = $indicator_model->getFourthMotherIndicator();
                $thirdMotherIndicator = $indicator_model->getThirdMotherIndicator();

                $getScorePart1 = $indicator_model->getScorePart1($regCode, $provCode, $lguType);
                $getPart1 = $indicator_model->getPart1($lguType);
                $getPart2 = $indicator_model->getPart2($lguType);
                $getPart3 = $indicator_model->getPart3($lguType);
                $getPart4 = $indicator_model->getPart4($lguType);
                $get_totalAssess = $reports_model->get_totalAssess($regCode, $provCode, $lguType);


                    $objPHPExcel->getActiveSheet()->setCellValue('B1', 'Sample Title');

                    //autosize column

                    $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
                    $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
                    $objPHPExcel->getActiveSheet()->getStyle('B1')->getFill()->getStartColor()->setRGB('FF0000');
//        $objPHPExcel->getActiveSheet()->getDefaultRowDimension()->setRowHeight(-1);a
                    $objPHPExcel->getActiveSheet()->getRowDimension(1)->setRowHeight(-1);
                    $objPHPExcel->getActiveSheet()->getStyle('B1')->getFont()->setBold(true);
                    $objPHPExcel->getActiveSheet()->getStyle('B1')->getFont()->setSize(20);
                    $objPHPExcel->getActiveSheet()->mergeCells('B1:E2');

                    //Center text merge columns
                    $objPHPExcel->getActiveSheet()->getStyle('B1')->getAlignment()->applyFromArray(
                        array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,));
//    $col = 'A';
//        $row = 5;
                    $objPHPExcel->getActiveSheet()->setCellValue('A3', 'Areas');
                    $objPHPExcel->getActiveSheet()->getStyle('A3')->getFont()->setBold(true);
                    $objPHPExcel->getActiveSheet()->setCellValue('B3', 'Distribution of functional by Province -Sample title');
                    $objPHPExcel->getActiveSheet()->mergeCells('A3:A5');
                    $objPHPExcel->getActiveSheet()->mergeCells('B3:E3');
                    //Center text merge columns
                    $objPHPExcel->getActiveSheet()->getStyle('B3')->getAlignment()->applyFromArray(
                        array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,));
                    $objPHPExcel->getActiveSheet()->getStyle('A3')->getAlignment()->applyFromArray(
                        array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,));

                    $objPHPExcel->getActiveSheet()->getStyle('A3')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);

                    $objPHPExcel->getActiveSheet()->mergeCells('B6:e6');
                    $objPHPExcel->getActiveSheet()->freezePane('B6');
                    //Header
                    $objPHPExcel->getActiveSheet()->setCellValue('B4', 'Indicators');

                    $objPHPExcel->getActiveSheet()->getStyle('B4')->getAlignment()->applyFromArray(
                        array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,));
                    $objPHPExcel->getActiveSheet()->setCellValue('C4', 'Non-Compliant');
                    $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
                    $objPHPExcel->getActiveSheet()->getStyle('C4')->getAlignment()->applyFromArray(
                        array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,));
                    $objPHPExcel->getActiveSheet()->setCellValue('D4', 'Percent');
                    $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
                    $objPHPExcel->getActiveSheet()->getStyle('D4')->getAlignment()->applyFromArray(
                        array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,));


//Start Editing
                    //Part1
                    $row2 = 7;
                    $col2 = 'A';
                    $objPHPExcel->getActiveSheet()->setCellValue($col2 . $row2, $firstMotherIndicator->indicator_name);
                    $col2++;
                    $row2++;
                    foreach ($getPart1 as $firstPartIndicator):
                        if ($firstPartIndicator->indicator_checklist_id == 1) {
                            $arr = explode("-", $firstPartIndicator->indicator_id);
                            $indicatorID = $arr[0];
                            foreach ($getScorePart1 as $scorePart1):
                                if ($scorePart1->indicator_id == $firstPartIndicator->indicator_id) {
                                    $indicator_name = $indicatorID . '.' . $firstPartIndicator->indicator_name;
                                    $totalNonCompliance = $scorePart1->TotalNonCompliance;
                                    $totalAssess = $get_totalAssess->totalAssess;

                                    $percent = ($totalNonCompliance / $totalAssess);


                                    $objPHPExcel->getActiveSheet()->setCellValue($col2 . $row2, $indicator_name);
                                    $col2++;
                                    $objPHPExcel->getActiveSheet()->setCellValue($col2 . $row2, $totalNonCompliance);
                                    $col2++;
                                    $objPHPExcel->getActiveSheet()->setCellValue($col2 . $row2, $percent);
                                    $objPHPExcel->getActiveSheet()->getStyle($col2 . $row2)
                                        ->getNumberFormat()->applyFromArray(
                                            array(
                                                'code' => PHPExcel_Style_NumberFormat::FORMAT_PERCENTAGE_00
                                            )
                                        );
                                    if ($col2 == 'D') {
                                        $col2 = 'B';
                                    }
                                    $row2++;
                                }
                            endforeach;
                        }
                    endforeach;
                    //Part2
                    $col2 = 'A';
                    $objPHPExcel->getActiveSheet()->setCellValue($col2 . $row2, $secondMotherIndicator->indicator_name);
                    $col2++;
                    $row2++;
                    foreach ($getPart2 as $secondPartIndicator):
                        if ($secondPartIndicator->indicator_checklist_id == 1) {
                            $arr = explode("-", $secondPartIndicator->indicator_id);
                            $indicatorID = $arr[0];
                            foreach ($getScorePart1 as $scorePart1):
                                if ($scorePart1->indicator_id == $secondPartIndicator->indicator_id) {
                                    $indicator_name = $indicatorID . '.' . $secondPartIndicator->indicator_name;
                                    $totalNonCompliance = $scorePart1->TotalNonCompliance;
                                    $totalAssess = $get_totalAssess->totalAssess;

                                    $percent = ($totalNonCompliance / $totalAssess);

                                    $objPHPExcel->getActiveSheet()->setCellValue($col2 . $row2, $indicator_name);
                                    $col2++;
                                    $objPHPExcel->getActiveSheet()->setCellValue($col2 . $row2, $totalNonCompliance);
                                    $col2++;
                                    $objPHPExcel->getActiveSheet()->setCellValue($col2 . $row2, $percent);
                                    $objPHPExcel->getActiveSheet()->getStyle($col2 . $row2)
                                        ->getNumberFormat()->applyFromArray(
                                            array(
                                                'code' => PHPExcel_Style_NumberFormat::FORMAT_PERCENTAGE_00
                                            )
                                        );
                                    if ($col2 == 'D') {
                                        $col2 = 'B';
                                    }
                                    $row2++;
                                }
                            endforeach;
                        }
                    endforeach;
                    //Part3
                    $col2 = 'A';
                    $objPHPExcel->getActiveSheet()->setCellValue($col2 . $row2, $thirdMotherIndicator->indicator_name);
                    $col2++;
                    $row2++;
                    foreach ($getPart3 as $thirdPartIndicator):
                        if ($thirdPartIndicator->indicator_checklist_id == 1) {
                            $arr = explode("-", $thirdPartIndicator->indicator_id);
                            $indicatorID = $arr[0];
                            foreach ($getScorePart1 as $scorePart1):
                                if ($scorePart1->indicator_id == $thirdPartIndicator->indicator_id) {
                                    $indicator_name = $indicatorID . '.' . $thirdPartIndicator->indicator_name;
                                    $totalNonCompliance = $scorePart1->TotalNonCompliance;
                                    $totalAssess = $get_totalAssess->totalAssess;

                                    $percent = ($totalNonCompliance / $totalAssess);

                                    $objPHPExcel->getActiveSheet()->setCellValue($col2 . $row2, $indicator_name);
                                    $col2++;
                                    $objPHPExcel->getActiveSheet()->setCellValue($col2 . $row2, $totalNonCompliance);
                                    $col2++;
                                    $objPHPExcel->getActiveSheet()->setCellValue($col2 . $row2, $percent);
                                    $objPHPExcel->getActiveSheet()->getStyle($col2 . $row2)
                                        ->getNumberFormat()->applyFromArray(
                                            array(
                                                'code' => PHPExcel_Style_NumberFormat::FORMAT_PERCENTAGE_00
                                            )
                                        );
                                    if ($col2 == 'D') {
                                        $col2 = 'B';
                                    }
                                    $row2++;
                                }
                            endforeach;
                        }
                    endforeach;
                    //Part4
                    $col2 = 'A';
                    $objPHPExcel->getActiveSheet()->setCellValue($col2 . $row2, $fourthMotherIndicator->indicator_name);
                    $col2++;
                    $row2++;
                    foreach ($getPart4 as $fourthPartIndicator):
                        if ($fourthPartIndicator->indicator_checklist_id == 1) {
                            $arr = explode("-", $fourthPartIndicator->indicator_id);
                            $indicatorID = $arr[0];
                            foreach ($getScorePart1 as $scorePart1):
                                if ($scorePart1->indicator_id == $fourthPartIndicator->indicator_id) {
                                    $indicator_name = $indicatorID . '.' . $fourthPartIndicator->indicator_name;
                                    $totalNonCompliance = $scorePart1->TotalNonCompliance;
                                    $totalAssess = $get_totalAssess->totalAssess;

                                    $percent = ($totalNonCompliance / $totalAssess);

                                    $objPHPExcel->getActiveSheet()->setCellValue($col2 . $row2, $indicator_name);
                                    $col2++;
                                    $objPHPExcel->getActiveSheet()->setCellValue($col2 . $row2, $totalNonCompliance);
                                    $col2++;
                                    $objPHPExcel->getActiveSheet()->setCellValue($col2 . $row2, $percent);
                                    $objPHPExcel->getActiveSheet()->getStyle($col2 . $row2)
                                        ->getNumberFormat()->applyFromArray(
                                            array(
                                                'code' => PHPExcel_Style_NumberFormat::FORMAT_PERCENTAGE_00
                                            )
                                        );
                                    if ($col2 == 'D') {
                                        $col2 = 'B';
                                    }
                                    $row2++;
                                }
                            endforeach;
                        }
                    endforeach;

//End Editing

//    //border
                    $objPHPExcel->getActiveSheet()->getStyle(
                        'A1:' .
                        $objPHPExcel->getActiveSheet()->getHighestColumn() .
                        $objPHPExcel->getActiveSheet()->getHighestRow()
                    )->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
// Rename worksheet (worksheet, not filename)
                    $objPHPExcel->setActiveSheetIndex(0)->setTitle('Non-Compliant Indicator');
                    // Add new sheet



// Add some data

// Set active sheet index to the first sheet, so Excel opens this as the first asheet
        $objPHPExcel->setActiveSheetIndex(0);

// Redirect output to a client’s web browser (Excel2007)
//clean the output buffer
        ob_end_clean();

//this is the header given from PHPExcel examples. but the output seems somewhat corrupted in some cases.
//header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
//so, we use this header instead.
//    $regionName = $this->reports_model->getRegionName($region);
        $filename = 'Non-CompliantIndicator.xlsx';
        header('Content-type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename='.$filename);
        header('Cache-Control: max-age=0');

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        $objWriter->save('php://output');
    }
    public function nonCompliantLSWDO($regCode,$provCode,$cityCode,$lguType){


        $indicator_model = new indicator_model();
        $reports_model = new reports_model();
// Create new PHPExcel object
        $objPHPExcel = new PHPExcel();



        $firstMotherIndicator = $indicator_model->getFirstMotherIndicator();
        $secondMotherIndicator = $indicator_model->getSecondMotherIndicator();
        $fourthMotherIndicator = $indicator_model->getFourthMotherIndicator();
        $thirdMotherIndicator = $indicator_model->getThirdMotherIndicator();

        $getScorePart1 = $indicator_model->getNCperLSWDO($regCode, $provCode, $cityCode);
        $getPart1 = $indicator_model->getPart1($lguType);
        $getPart2 = $indicator_model->getPart2($lguType);
        $getPart3 = $indicator_model->getPart3($lguType);
        $getPart4 = $indicator_model->getPart4($lguType);
        $get_totalAssess = $reports_model->get_totalAssess($regCode, $provCode, $lguType);


        $objPHPExcel->getActiveSheet()->setCellValue('B1', 'Sample Title');

        //autosize column

        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getStyle('B1')->getFill()->getStartColor()->setRGB('FF0000');
//        $objPHPExcel->getActiveSheet()->getDefaultRowDimension()->setRowHeight(-1);a
        $objPHPExcel->getActiveSheet()->getRowDimension(1)->setRowHeight(-1);
        $objPHPExcel->getActiveSheet()->getStyle('B1')->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->getStyle('B1')->getFont()->setSize(20);
        $objPHPExcel->getActiveSheet()->mergeCells('B1:E2');

        //Center text merge columns
        $objPHPExcel->getActiveSheet()->getStyle('B1')->getAlignment()->applyFromArray(
            array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,));
//    $col = 'A';
//        $row = 5;
        $objPHPExcel->getActiveSheet()->setCellValue('A3', 'Areas');
        $objPHPExcel->getActiveSheet()->getStyle('A3')->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->setCellValue('B3', 'Distribution of functional by Province -Sample title');
        $objPHPExcel->getActiveSheet()->mergeCells('A3:A5');
        $objPHPExcel->getActiveSheet()->mergeCells('B3:E3');
        //Center text merge columns
        $objPHPExcel->getActiveSheet()->getStyle('B3')->getAlignment()->applyFromArray(
            array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,));
        $objPHPExcel->getActiveSheet()->getStyle('A3')->getAlignment()->applyFromArray(
            array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,));

        $objPHPExcel->getActiveSheet()->getStyle('A3')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);

        $objPHPExcel->getActiveSheet()->mergeCells('B6:e6');
        $objPHPExcel->getActiveSheet()->freezePane('B6');
        //Header
        $objPHPExcel->getActiveSheet()->setCellValue('B4', 'Indicators');

        $objPHPExcel->getActiveSheet()->getStyle('B4')->getAlignment()->applyFromArray(
            array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,));



//Start Editing
        //Part1
        $row2 = 7;
        $col2 = 'A';
        $objPHPExcel->getActiveSheet()->setCellValue($col2 . $row2, $firstMotherIndicator->indicator_name);
        $col2++;
        $row2++;
        foreach ($getPart1 as $firstPartIndicator):
            if ($firstPartIndicator->indicator_checklist_id == 1) {
                $arr = explode("-", $firstPartIndicator->indicator_id);
                $indicatorID = $arr[0];
                foreach ($getScorePart1 as $scorePart1):
                    if ($scorePart1->indicator_id == $firstPartIndicator->indicator_id) {
                        $indicator_id = $firstPartIndicator->indicator_name;

                        $objPHPExcel->getActiveSheet()->setCellValue($col2 . $row2, $indicator_id);
                        if ($col2 == 'B') {
                            $col2 = 'B';
                        }
                        $row2++;
                    }
                endforeach;
            }
        endforeach;
        //Part2
        $col2 = 'A';
        $objPHPExcel->getActiveSheet()->setCellValue($col2 . $row2, $secondMotherIndicator->indicator_name);
        $col2++;
        $row2++;
        foreach ($getPart2 as $secondPartIndicator):
            if ($secondPartIndicator->indicator_checklist_id == 1) {
                $arr = explode("-", $secondPartIndicator->indicator_id);
                $indicatorID = $arr[0];
                foreach ($getScorePart1 as $scorePart1):
                    if ($scorePart1->indicator_id == $secondPartIndicator->indicator_id) {
                        $indicator_id = $secondPartIndicator->indicator_name;

                        $objPHPExcel->getActiveSheet()->setCellValue($col2 . $row2, $indicator_id);
                        if ($col2 == 'B') {
                            $col2 = 'B';
                        }
                        $row2++;
                    }
                endforeach;
            }
        endforeach;
        //Part3
        $col2 = 'A';
        $objPHPExcel->getActiveSheet()->setCellValue($col2 . $row2, $thirdMotherIndicator->indicator_name);
        $col2++;
        $row2++;
        foreach ($getPart3 as $thirdPartIndicator):
            if ($thirdPartIndicator->indicator_checklist_id == 1) {
                $arr = explode("-", $thirdPartIndicator->indicator_id);
                $indicatorID = $arr[0];
                foreach ($getScorePart1 as $scorePart1):
                    if ($scorePart1->indicator_id == $thirdPartIndicator->indicator_id) {
                        $indicator_id = $thirdPartIndicator->indicator_name;

                        $objPHPExcel->getActiveSheet()->setCellValue($col2 . $row2, $indicator_id);
                        if ($col2 == 'B') {
                            $col2 = 'B';
                        }
                        $row2++;
                    }
                endforeach;
            }
        endforeach;
        //Part4
        $col2 = 'A';
        $objPHPExcel->getActiveSheet()->setCellValue($col2 . $row2, $fourthMotherIndicator->indicator_name);
        $col2++;
        $row2++;
        foreach ($getPart4 as $fourthPartIndicator):
            if ($fourthPartIndicator->indicator_checklist_id == 1) {
                $arr = explode("-", $fourthPartIndicator->indicator_id);
                $indicatorID = $arr[0];
                foreach ($getScorePart1 as $scorePart1):
                    if ($scorePart1->indicator_id == $fourthPartIndicator->indicator_id) {
                        $indicator_id = $fourthPartIndicator->indicator_name;

                        $objPHPExcel->getActiveSheet()->setCellValue($col2 . $row2, $indicator_id);
                        if ($col2 == 'B') {
                            $col2 = 'B';
                        }
                        $row2++;
                    }
                endforeach;
            }
        endforeach;

//End Editing

//    //border
        $objPHPExcel->getActiveSheet()->getStyle(
            'A1:' .
            $objPHPExcel->getActiveSheet()->getHighestColumn() .
            $objPHPExcel->getActiveSheet()->getHighestRow()
        )->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
// Rename worksheet (worksheet, not filename)
        $objPHPExcel->setActiveSheetIndex(0)->setTitle('LSWDO-NonCompliantIndicator');
        // Add new sheet



// Add some data

// Set active sheet index to the first sheet, so Excel opens this as the first asheet
        $objPHPExcel->setActiveSheetIndex(0);

// Redirect output to a client’s web browser (Excel2007)
//clean the output buffer
        ob_end_clean();

//this is the header given from PHPExcel examples. but the output seems somewhat corrupted in some cases.
//header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
//so, we use this header instead.
//    $regionName = $this->reports_model->getRegionName($region);
        $filename = 'Non-CompliantIndicator.xlsx';
        header('Content-type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename='.$filename);
        header('Cache-Control: max-age=0');

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        $objWriter->save('php://output');
    }

    public function LCPC($regCode,$provCode,$lguType){

        $reports_model = new reports_model();
        $objPHPExcel = new PHPExcel();


// Create new PHPExcel object
        if($lguType == 1) { // PSWDO LERI BOY

            $getLCPC = $reports_model->getLCPC($regCode, $provCode, $lguType);


            $objPHPExcel->getActiveSheet()->setCellValue('B1', 'a PSWDO Functionality for Local Council for the Protection of Children');

            //autosize column

            $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
            $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
            $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
            $objPHPExcel->getActiveSheet()->getStyle('B1')->getFill()->getStartColor()->setRGB('FF0000');
//        $objPHPExcel->getActiveSheet()->getDefaultRowDimension()->setRowHeight(-1);a
            $objPHPExcel->getActiveSheet()->getRowDimension(1)->setRowHeight(-1);
            $objPHPExcel->getActiveSheet()->getStyle('B1')->getFont()->setBold(true);
            $objPHPExcel->getActiveSheet()->getStyle('B1')->getFont()->setSize(20);
            $objPHPExcel->getActiveSheet()->mergeCells('B1:C2');

            //Center text merge columns
            $objPHPExcel->getActiveSheet()->getStyle('B1')->getAlignment()->applyFromArray(
                array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,));
//    $col = 'A';
//        $row = 5;
            $objPHPExcel->getActiveSheet()->setCellValue('A3', 'Province');
            $objPHPExcel->getActiveSheet()->getStyle('A3')->getFont()->setBold(true);
            $objPHPExcel->getActiveSheet()->setCellValue('B3','Sample Title');
            $objPHPExcel->getActiveSheet()->mergeCells('A3:A5');
            $objPHPExcel->getActiveSheet()->mergeCells('B3:C3');
            //Center text merge columns
            $objPHPExcel->getActiveSheet()->getStyle('B3')->getAlignment()->applyFromArray(
                array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,));
            $objPHPExcel->getActiveSheet()->getStyle('A3')->getAlignment()->applyFromArray(
                array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,));

            $objPHPExcel->getActiveSheet()->getStyle('A3')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);

            $objPHPExcel->getActiveSheet()->mergeCells('B6:C6');
            $objPHPExcel->getActiveSheet()->freezePane('B6');
            //Header

            $objPHPExcel->getActiveSheet()->setCellValue('B4', 'Score');
            $objPHPExcel->getActiveSheet()->getStyle('B4')->getAlignment()->applyFromArray(
                array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,));

            $objPHPExcel->getActiveSheet()->setCellValue('C4', 'Rank');
            $objPHPExcel->getActiveSheet()->getStyle('B4')->getAlignment()->applyFromArray(
                array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,));




//Start Editing
            //Part1
            $row2 = 7;
            $col2 = 'A';
            foreach ($getLCPC as $lcpc):

                $objPHPExcel->getActiveSheet()->setCellValue($col2 . $row2, $lcpc->prov_name);
                $col2++;
                $objPHPExcel->getActiveSheet()->setCellValue($col2 . $row2, $lcpc->ScoreIndicator);
                if ($col2 == 'B') {
                    $col2 = 'A';
                }
                $row2++;

            endforeach;

//End Editing
//    //border
            $objPHPExcel->getActiveSheet()->getStyle(
                'A1:' .
                $objPHPExcel->getActiveSheet()->getHighestColumn() .
                $objPHPExcel->getActiveSheet()->getHighestRow()
            )->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
// Rename worksheet (worksheet, not filename)
            $objPHPExcel->setActiveSheetIndex(0)->setTitle('LCPCPSWDO');
            // Add new sheet
        } else if($lguType == 2){

            $getLCPC = $reports_model->getLCPC($regCode, $provCode, $lguType);


            $objPHPExcel->getActiveSheet()->setCellValue('B1', 'a CSWDO Functionality for Local Council for the Protection of Children');

            //autosize column

            $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
            $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
            $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
            $objPHPExcel->getActiveSheet()->getStyle('B1')->getFill()->getStartColor()->setRGB('FF0000');
//        $objPHPExcel->getActiveSheet()->getDefaultRowDimension()->setRowHeight(-1);a
            $objPHPExcel->getActiveSheet()->getRowDimension(1)->setRowHeight(-1);
            $objPHPExcel->getActiveSheet()->getStyle('B1')->getFont()->setBold(true);
            $objPHPExcel->getActiveSheet()->getStyle('B1')->getFont()->setSize(20);
            $objPHPExcel->getActiveSheet()->mergeCells('B1:C2');

            //Center text merge columns
            $objPHPExcel->getActiveSheet()->getStyle('B1')->getAlignment()->applyFromArray(
                array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,));
//    $col = 'A';
//        $row = 5;
            $objPHPExcel->getActiveSheet()->setCellValue('A3', 'City');
            $objPHPExcel->getActiveSheet()->getStyle('A3')->getFont()->setBold(true);
            $objPHPExcel->getActiveSheet()->setCellValue('B3','Sample Title');
            $objPHPExcel->getActiveSheet()->mergeCells('A3:A5');
            $objPHPExcel->getActiveSheet()->mergeCells('B3:C3');
            //Center text merge columns
            $objPHPExcel->getActiveSheet()->getStyle('B3')->getAlignment()->applyFromArray(
                array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,));
            $objPHPExcel->getActiveSheet()->getStyle('A3')->getAlignment()->applyFromArray(
                array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,));

            $objPHPExcel->getActiveSheet()->getStyle('A3')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);

            $objPHPExcel->getActiveSheet()->mergeCells('B6:C6');
            $objPHPExcel->getActiveSheet()->freezePane('B6');
            //Header

            $objPHPExcel->getActiveSheet()->setCellValue('B4', 'Score');
            $objPHPExcel->getActiveSheet()->getStyle('B4')->getAlignment()->applyFromArray(
                array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,));

            $objPHPExcel->getActiveSheet()->setCellValue('C4', 'Rank');
            $objPHPExcel->getActiveSheet()->getStyle('B4')->getAlignment()->applyFromArray(
                array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,));




//Start Editing
            //Part1
            $row2 = 7;
            $col2 = 'A';
            foreach ($getLCPC as $lcpc):

                $objPHPExcel->getActiveSheet()->setCellValue($col2 . $row2, $lcpc->city_name);
                $col2++;
                $objPHPExcel->getActiveSheet()->setCellValue($col2 . $row2, $lcpc->ScoreIndicator);
                if ($col2 == 'B') {
                    $col2 = 'A';
                }
                $row2++;

            endforeach;

//End Editing
//    //border
            $objPHPExcel->getActiveSheet()->getStyle(
                'A1:' .
                $objPHPExcel->getActiveSheet()->getHighestColumn() .
                $objPHPExcel->getActiveSheet()->getHighestRow()
            )->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
// Rename worksheet (worksheet, not filename)
            $objPHPExcel->setActiveSheetIndex(0)->setTitle('LCPCCSWDO');
            // Add new sheet
        } elseif($lguType == 3){

            $getLCPC = $reports_model->getLCPC($regCode, $provCode, $lguType);


            $objPHPExcel->getActiveSheet()->setCellValue('B1', 'a MSWDO Functionality for Local Council for the Protection of Children');

            //autosize column

            $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
            $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
            $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
            $objPHPExcel->getActiveSheet()->getStyle('B1')->getFill()->getStartColor()->setRGB('FF0000');
//        $objPHPExcel->getActiveSheet()->getDefaultRowDimension()->setRowHeight(-1);a
            $objPHPExcel->getActiveSheet()->getRowDimension(1)->setRowHeight(-1);
            $objPHPExcel->getActiveSheet()->getStyle('B1')->getFont()->setBold(true);
            $objPHPExcel->getActiveSheet()->getStyle('B1')->getFont()->setSize(20);
            $objPHPExcel->getActiveSheet()->mergeCells('B1:C2');

            //Center text merge columns
            $objPHPExcel->getActiveSheet()->getStyle('B1')->getAlignment()->applyFromArray(
                array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,));
//    $col = 'A';
//        $row = 5;
            $objPHPExcel->getActiveSheet()->setCellValue('A3', 'City');
            $objPHPExcel->getActiveSheet()->getStyle('A3')->getFont()->setBold(true);
            $objPHPExcel->getActiveSheet()->setCellValue('B3','Sample Title');
            $objPHPExcel->getActiveSheet()->mergeCells('A3:A5');
            $objPHPExcel->getActiveSheet()->mergeCells('B3:C3');
            //Center text merge columns
            $objPHPExcel->getActiveSheet()->getStyle('B3')->getAlignment()->applyFromArray(
                array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,));
            $objPHPExcel->getActiveSheet()->getStyle('A3')->getAlignment()->applyFromArray(
                array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,));

            $objPHPExcel->getActiveSheet()->getStyle('A3')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);

            $objPHPExcel->getActiveSheet()->mergeCells('B6:C6');
            $objPHPExcel->getActiveSheet()->freezePane('B6');
            //Header

            $objPHPExcel->getActiveSheet()->setCellValue('B4', 'Score');
            $objPHPExcel->getActiveSheet()->getStyle('B4')->getAlignment()->applyFromArray(
                array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,));

            $objPHPExcel->getActiveSheet()->setCellValue('C4', 'Rank');
            $objPHPExcel->getActiveSheet()->getStyle('B4')->getAlignment()->applyFromArray(
                array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,));




//Start Editing
            //Part1
            $row2 = 7;
            $col2 = 'A';
            foreach ($getLCPC as $lcpc):

                $objPHPExcel->getActiveSheet()->setCellValue($col2 . $row2, $lcpc->city_name);
                $col2++;
                $objPHPExcel->getActiveSheet()->setCellValue($col2 . $row2, $lcpc->ScoreIndicator);
                if ($col2 == 'B') {
                    $col2 = 'A';
                }
                $row2++;

            endforeach;

//End Editing
//    //border
            $objPHPExcel->getActiveSheet()->getStyle(
                'A1:' .
                $objPHPExcel->getActiveSheet()->getHighestColumn() .
                $objPHPExcel->getActiveSheet()->getHighestRow()
            )->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
// Rename worksheet (worksheet, not filename)
            $objPHPExcel->setActiveSheetIndex(0)->setTitle('LCPCMSWDO');
        }

// Add some data

// Set active sheet index to the first sheet, so Excel opens this as the first asheet
            $objPHPExcel->setActiveSheetIndex(0);

// Redirect output to a client’s web browser (Excel2007)
//clean the output buffer
            ob_end_clean();

//this is the header given from PHPExcel examples. but the output seems somewhat corrupted in some cases.
//header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
//so, we use this header instead.
//    $regionName = $this->reports_model->getRegionName($region);
            $filename = 'LCPCPSWDO.xlsx';
            header('Content-type: application/vnd.ms-excel');
            header('Content-Disposition: attachment;filename=' . $filename);
            header('Cache-Control: max-age=0');

            $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
            $objWriter->save('php://output');

    }
    public function DRRMC($regCode,$provCode,$lguType){

        $reports_model = new reports_model();
        $objPHPExcel = new PHPExcel();


// Create new PHPExcel object
        if($lguType == 1) { // PSWDO LERI BOY

            $getLCPC = $reports_model->getDRRMC($regCode, $provCode, $lguType);


            $objPHPExcel->getActiveSheet()->setCellValue('B1', 'a PSWDO Functionality for Disaster Risk Reduction and Management Council (DRRMC)');

            //autosize column

            $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
            $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
            $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
            $objPHPExcel->getActiveSheet()->getStyle('B1')->getFill()->getStartColor()->setRGB('FF0000');
//        $objPHPExcel->getActiveSheet()->getDefaultRowDimension()->setRowHeight(-1);a
            $objPHPExcel->getActiveSheet()->getRowDimension(1)->setRowHeight(-1);
            $objPHPExcel->getActiveSheet()->getStyle('B1')->getFont()->setBold(true);
            $objPHPExcel->getActiveSheet()->getStyle('B1')->getFont()->setSize(20);
            $objPHPExcel->getActiveSheet()->mergeCells('B1:C2');

            //Center text merge columns
            $objPHPExcel->getActiveSheet()->getStyle('B1')->getAlignment()->applyFromArray(
                array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,));
//    $col = 'A';
//        $row = 5;
            $objPHPExcel->getActiveSheet()->setCellValue('A3', 'Province');
            $objPHPExcel->getActiveSheet()->getStyle('A3')->getFont()->setBold(true);
            $objPHPExcel->getActiveSheet()->setCellValue('B3','Sample Title');
            $objPHPExcel->getActiveSheet()->mergeCells('A3:A5');
            $objPHPExcel->getActiveSheet()->mergeCells('B3:C3');
            //Center text merge columns
            $objPHPExcel->getActiveSheet()->getStyle('B3')->getAlignment()->applyFromArray(
                array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,));
            $objPHPExcel->getActiveSheet()->getStyle('A3')->getAlignment()->applyFromArray(
                array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,));

            $objPHPExcel->getActiveSheet()->getStyle('A3')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);

            $objPHPExcel->getActiveSheet()->mergeCells('B6:C6');
            $objPHPExcel->getActiveSheet()->freezePane('B6');
            //Header

            $objPHPExcel->getActiveSheet()->setCellValue('B4', 'Score');
            $objPHPExcel->getActiveSheet()->getStyle('B4')->getAlignment()->applyFromArray(
                array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,));

            $objPHPExcel->getActiveSheet()->setCellValue('C4', 'Rank');
            $objPHPExcel->getActiveSheet()->getStyle('B4')->getAlignment()->applyFromArray(
                array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,));




//Start Editing
            //Part1
            $row2 = 7;
            $col2 = 'A';
            foreach ($getLCPC as $lcpc):

                $objPHPExcel->getActiveSheet()->setCellValue($col2 . $row2, $lcpc->prov_name);
                $col2++;
                $objPHPExcel->getActiveSheet()->setCellValue($col2 . $row2, $lcpc->ScoreIndicator);
                if ($col2 == 'B') {
                    $col2 = 'A';
                }
                $row2++;

            endforeach;

//End Editing
//    //border
            $objPHPExcel->getActiveSheet()->getStyle(
                'A1:' .
                $objPHPExcel->getActiveSheet()->getHighestColumn() .
                $objPHPExcel->getActiveSheet()->getHighestRow()
            )->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
// Rename worksheet (worksheet, not filename)
            $objPHPExcel->setActiveSheetIndex(0)->setTitle('LCPCPSWDO');
            // Add new sheet
        } else if($lguType == 2){

            $getLCPC = $reports_model->getLCPC($regCode, $provCode, $lguType);


            $objPHPExcel->getActiveSheet()->setCellValue('B1', 'a CSWDO Functionality for Disaster Risk Reduction and Management Council (DRRMC)');

            //autosize column

            $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
            $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
            $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
            $objPHPExcel->getActiveSheet()->getStyle('B1')->getFill()->getStartColor()->setRGB('FF0000');
//        $objPHPExcel->getActiveSheet()->getDefaultRowDimension()->setRowHeight(-1);a
            $objPHPExcel->getActiveSheet()->getRowDimension(1)->setRowHeight(-1);
            $objPHPExcel->getActiveSheet()->getStyle('B1')->getFont()->setBold(true);
            $objPHPExcel->getActiveSheet()->getStyle('B1')->getFont()->setSize(20);
            $objPHPExcel->getActiveSheet()->mergeCells('B1:C2');

            //Center text merge columns
            $objPHPExcel->getActiveSheet()->getStyle('B1')->getAlignment()->applyFromArray(
                array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,));
//    $col = 'A';
//        $row = 5;
            $objPHPExcel->getActiveSheet()->setCellValue('A3', 'City');
            $objPHPExcel->getActiveSheet()->getStyle('A3')->getFont()->setBold(true);
            $objPHPExcel->getActiveSheet()->setCellValue('B3','Sample Title');
            $objPHPExcel->getActiveSheet()->mergeCells('A3:A5');
            $objPHPExcel->getActiveSheet()->mergeCells('B3:C3');
            //Center text merge columns
            $objPHPExcel->getActiveSheet()->getStyle('B3')->getAlignment()->applyFromArray(
                array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,));
            $objPHPExcel->getActiveSheet()->getStyle('A3')->getAlignment()->applyFromArray(
                array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,));

            $objPHPExcel->getActiveSheet()->getStyle('A3')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);

            $objPHPExcel->getActiveSheet()->mergeCells('B6:C6');
            $objPHPExcel->getActiveSheet()->freezePane('B6');
            //Header

            $objPHPExcel->getActiveSheet()->setCellValue('B4', 'Score');
            $objPHPExcel->getActiveSheet()->getStyle('B4')->getAlignment()->applyFromArray(
                array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,));

            $objPHPExcel->getActiveSheet()->setCellValue('C4', 'Rank');
            $objPHPExcel->getActiveSheet()->getStyle('B4')->getAlignment()->applyFromArray(
                array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,));




//Start Editing
            //Part1
            $row2 = 7;
            $col2 = 'A';
            foreach ($getLCPC as $lcpc):

                $objPHPExcel->getActiveSheet()->setCellValue($col2 . $row2, $lcpc->city_name);
                $col2++;
                $objPHPExcel->getActiveSheet()->setCellValue($col2 . $row2, $lcpc->ScoreIndicator);
                if ($col2 == 'B') {
                    $col2 = 'A';
                }
                $row2++;

            endforeach;

//End Editing
//    //border
            $objPHPExcel->getActiveSheet()->getStyle(
                'A1:' .
                $objPHPExcel->getActiveSheet()->getHighestColumn() .
                $objPHPExcel->getActiveSheet()->getHighestRow()
            )->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
// Rename worksheet (worksheet, not filename)
            $objPHPExcel->setActiveSheetIndex(0)->setTitle('LCPCCSWDO');
            // Add new sheet
        } elseif($lguType == 3){

            $getLCPC = $reports_model->getLCPC($regCode, $provCode, $lguType);


            $objPHPExcel->getActiveSheet()->setCellValue('B1', 'a MSWDO Functionality for Disaster Risk Reduction and Management Council (DRRMC)');

            //autosize column

            $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
            $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
            $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
            $objPHPExcel->getActiveSheet()->getStyle('B1')->getFill()->getStartColor()->setRGB('FF0000');
//        $objPHPExcel->getActiveSheet()->getDefaultRowDimension()->setRowHeight(-1);a
            $objPHPExcel->getActiveSheet()->getRowDimension(1)->setRowHeight(-1);
            $objPHPExcel->getActiveSheet()->getStyle('B1')->getFont()->setBold(true);
            $objPHPExcel->getActiveSheet()->getStyle('B1')->getFont()->setSize(20);
            $objPHPExcel->getActiveSheet()->mergeCells('B1:C2');

            //Center text merge columns
            $objPHPExcel->getActiveSheet()->getStyle('B1')->getAlignment()->applyFromArray(
                array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,));
//    $col = 'A';
//        $row = 5;
            $objPHPExcel->getActiveSheet()->setCellValue('A3', 'City');
            $objPHPExcel->getActiveSheet()->getStyle('A3')->getFont()->setBold(true);
            $objPHPExcel->getActiveSheet()->setCellValue('B3','Sample Title');
            $objPHPExcel->getActiveSheet()->mergeCells('A3:A5');
            $objPHPExcel->getActiveSheet()->mergeCells('B3:C3');
            //Center text merge columns
            $objPHPExcel->getActiveSheet()->getStyle('B3')->getAlignment()->applyFromArray(
                array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,));
            $objPHPExcel->getActiveSheet()->getStyle('A3')->getAlignment()->applyFromArray(
                array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,));

            $objPHPExcel->getActiveSheet()->getStyle('A3')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);

            $objPHPExcel->getActiveSheet()->mergeCells('B6:C6');
            $objPHPExcel->getActiveSheet()->freezePane('B6');
            //Header

            $objPHPExcel->getActiveSheet()->setCellValue('B4', 'Score');
            $objPHPExcel->getActiveSheet()->getStyle('B4')->getAlignment()->applyFromArray(
                array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,));

            $objPHPExcel->getActiveSheet()->setCellValue('C4', 'Rank');
            $objPHPExcel->getActiveSheet()->getStyle('B4')->getAlignment()->applyFromArray(
                array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,));




//Start Editing
            //Part1
            $row2 = 7;
            $col2 = 'A';
            foreach ($getLCPC as $lcpc):

                $objPHPExcel->getActiveSheet()->setCellValue($col2 . $row2, $lcpc->city_name);
                $col2++;
                $objPHPExcel->getActiveSheet()->setCellValue($col2 . $row2, $lcpc->ScoreIndicator);
                if ($col2 == 'B') {
                    $col2 = 'A';
                }
                $row2++;

            endforeach;

//End Editing
//    //border
            $objPHPExcel->getActiveSheet()->getStyle(
                'A1:' .
                $objPHPExcel->getActiveSheet()->getHighestColumn() .
                $objPHPExcel->getActiveSheet()->getHighestRow()
            )->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
// Rename worksheet (worksheet, not filename)
            $objPHPExcel->setActiveSheetIndex(0)->setTitle('LCPCMSWDO');
        }

// Add some data

// Set active sheet index to the first sheet, so Excel opens this as the first asheet
        $objPHPExcel->setActiveSheetIndex(0);

// Redirect output to a client’s web browser (Excel2007)
//clean the output buffer
        ob_end_clean();

//this is the header given from PHPExcel examples. but the output seems somewhat corrupted in some cases.
//header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
//so, we use this header instead.
//    $regionName = $this->reports_model->getRegionName($region);
        $filename = 'LCPCPSWDO.xlsx';
        header('Content-type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename=' . $filename);
        header('Cache-Control: max-age=0');

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        $objWriter->save('php://output');

    }
    //Budget Utilization! :D
    public function budgetUtilization($sectorID){



        $reports_model = new reports_model();
        $budgetallocation_model = new budgetallocation_model();

        $sectorName = $budgetallocation_model->sectorName($sectorID);
        $sName = $sectorName->sector_name;
// Create new PHPExcel object
        $objPHPExcel = new PHPExcel();

        $getBudgetUtil = $reports_model->getBudgetUtil($sectorID);


        $objPHPExcel->getActiveSheet()->setCellValue('B1', 'Table 5.a Average LSWDO budget utilization (previous year) in '.$sName.' sector, by region, Philippines ');

        //autosize column

        $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getStyle('B1')->getFill()->getStartColor()->setRGB('FF0000');
//        $objPHPExcel->getActiveSheet()->getDefaultRowDimension()->setRowHeight(-1);a
        $objPHPExcel->getActiveSheet()->getRowDimension(1)->setRowHeight(-1);
        $objPHPExcel->getActiveSheet()->getStyle('B1')->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->getStyle('B1')->getFont()->setSize(20);
        $objPHPExcel->getActiveSheet()->mergeCells('B1:G2');

        //Center text merge columns
        $objPHPExcel->getActiveSheet()->getStyle('B1')->getAlignment()->applyFromArray(
            array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,));
//    $col = 'A';
//        $row = 5;
        $objPHPExcel->getActiveSheet()->setCellValue('A3', 'Region');
        $objPHPExcel->getActiveSheet()->getStyle('A3')->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->setCellValue('B3', $sName. ' Sector');
        $objPHPExcel->getActiveSheet()->mergeCells('A3:A5');
        $objPHPExcel->getActiveSheet()->mergeCells('B3:G3');
        //Center text merge columns
        $objPHPExcel->getActiveSheet()->getStyle('B3')->getAlignment()->applyFromArray(
            array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,));
        $objPHPExcel->getActiveSheet()->getStyle('A3')->getAlignment()->applyFromArray(
            array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,));

        $objPHPExcel->getActiveSheet()->getStyle('A3')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);

        $objPHPExcel->getActiveSheet()->mergeCells('B6:e6');
        $objPHPExcel->getActiveSheet()->freezePane('B6');
        //Header

        $objPHPExcel->getActiveSheet()->setCellValue('B4', 'Average PSWDO Utilization');
        $objPHPExcel->getActiveSheet()->getStyle('B4')->getAlignment()->applyFromArray(
            array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,));

        $objPHPExcel->getActiveSheet()->setCellValue('C4', 'Average No. of Beneficiaries Served');
        $objPHPExcel->getActiveSheet()->getStyle('B4')->getAlignment()->applyFromArray(
            array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,));

        $objPHPExcel->getActiveSheet()->setCellValue('D4', 'Average CSWDO Utilization');
        $objPHPExcel->getActiveSheet()->getStyle('B4')->getAlignment()->applyFromArray(
            array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,));

        $objPHPExcel->getActiveSheet()->setCellValue('E4', 'Average No. of Beneficiaries Served');
        $objPHPExcel->getActiveSheet()->getStyle('B4')->getAlignment()->applyFromArray(
            array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,));

        $objPHPExcel->getActiveSheet()->setCellValue('F4', 'Average MSWDO Utilization');
        $objPHPExcel->getActiveSheet()->getStyle('B4')->getAlignment()->applyFromArray(
            array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,));

        $objPHPExcel->getActiveSheet()->setCellValue('G4', 'Average No. of Beneficiaries Served');
        $objPHPExcel->getActiveSheet()->getStyle('B4')->getAlignment()->applyFromArray(
            array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,));



//Start Editing
        //Part1
        $row2 = 7;
        $col2 = 'A';
        foreach ($getBudgetUtil as $budgetUtil):

            $objPHPExcel->getActiveSheet()->setCellValue($col2 . $row2, $budgetUtil->region_name);$col2++;
            $objPHPExcel->getActiveSheet()->setCellValue($col2 . $row2, $budgetUtil->AverageUtilizationP);$col2++;
            $objPHPExcel->getActiveSheet()->setCellValue($col2 . $row2, $budgetUtil->BeneServedP);$col2++;
            $objPHPExcel->getActiveSheet()->setCellValue($col2 . $row2, $budgetUtil->AverageUtilizationC);$col2++;
            $objPHPExcel->getActiveSheet()->setCellValue($col2 . $row2, $budgetUtil->BeneServedC);$col2++;
            $objPHPExcel->getActiveSheet()->setCellValue($col2 . $row2, $budgetUtil->AverageUtilizationM);$col2++;
            $objPHPExcel->getActiveSheet()->setCellValue($col2 . $row2, $budgetUtil->BeneServedM);
            if ($col2 == 'G') {
                $col2 = 'A';
            }
            $row2++;

        endforeach;
        $col3 = 'B';
        $row3 = $row2 -1;
        $objPHPExcel->getActiveSheet()->setCellValue('A'.$row2, 'Total');
        for($i = 0; $i < 6; $i++) {
            $objPHPExcel->getActiveSheet()->setCellValue($col3 . $row2, '=SUM(' . $col3 . '7:' . $col3 . $row3 . ')');
            $col3++;
        }
//End Editing
//    //border
        $objPHPExcel->getActiveSheet()->getStyle(
            'A1:' .
            $objPHPExcel->getActiveSheet()->getHighestColumn() .
            $objPHPExcel->getActiveSheet()->getHighestRow()
        )->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
// Rename worksheet (worksheet, not filename)
        $objPHPExcel->setActiveSheetIndex(0)->setTitle('Budget Utilization (Previous Year)');
        // Add new sheet



// Add some data

// Set active sheet index to the first sheet, so Excel opens this as the first asheet
        $objPHPExcel->setActiveSheetIndex(0);

// Redirect output to a client’s web browser (Excel2007)
//clean the output buffer
        ob_end_clean();

//this is the header given from PHPExcel examples. but the output seems somewhat corrupted in some cases.
//header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
//so, we use this header instead.
//    $regionName = $this->reports_model->getRegionName($region);
        $filename = 'Non-CompliantIndicator.xlsx';
        header('Content-type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename='.$filename);
        header('Cache-Control: max-age=0');

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        $objWriter->save('php://output');
    }
    public function budgetAllocation($sectorID){



        $reports_model = new reports_model();
        $budgetallocation_model = new budgetallocation_model();

        $sectorName = $budgetallocation_model->sectorName($sectorID);
        $sName = $sectorName->sector_name;
// Create new PHPExcel object
        $objPHPExcel = new PHPExcel();

        $getBudgetAllocation = $reports_model->getBudgetAlloc($sectorID);


        $objPHPExcel->getActiveSheet()->setCellValue('B1', 'Distribution of LSWDO with budget allocation (present year) in '.$sName.' sector, by region, Philippines');

        //autosize column

        $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getStyle('B1')->getFill()->getStartColor()->setRGB('FF0000');
//        $objPHPExcel->getActiveSheet()->getDefaultRowDimension()->setRowHeight(-1);a
        $objPHPExcel->getActiveSheet()->getRowDimension(1)->setRowHeight(-1);
        $objPHPExcel->getActiveSheet()->getStyle('B1')->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->getStyle('B1')->getFont()->setSize(20);
        $objPHPExcel->getActiveSheet()->mergeCells('B1:G2');

        //Center text merge columns
        $objPHPExcel->getActiveSheet()->getStyle('B1')->getAlignment()->applyFromArray(
            array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,));
//    $col = 'A';
//        $row = 5;
        $objPHPExcel->getActiveSheet()->setCellValue('A3', 'Region');
        $objPHPExcel->getActiveSheet()->getStyle('A3')->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->setCellValue('B3', $sName. ' Sector');
        $objPHPExcel->getActiveSheet()->mergeCells('A3:A5');
        $objPHPExcel->getActiveSheet()->mergeCells('B3:G3');
        //Center text merge columns
        $objPHPExcel->getActiveSheet()->getStyle('B3')->getAlignment()->applyFromArray(
            array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,));
        $objPHPExcel->getActiveSheet()->getStyle('A3')->getAlignment()->applyFromArray(
            array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,));

        $objPHPExcel->getActiveSheet()->getStyle('A3')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);

        $objPHPExcel->getActiveSheet()->mergeCells('B6:e6');
        $objPHPExcel->getActiveSheet()->freezePane('B6');
        //Header

        $objPHPExcel->getActiveSheet()->setCellValue('B4', 'Average PSWDO Allocation');
        $objPHPExcel->getActiveSheet()->getStyle('B4')->getAlignment()->applyFromArray(
            array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,));

        $objPHPExcel->getActiveSheet()->setCellValue('C4', 'Average No. of Target Beneficiaries');
        $objPHPExcel->getActiveSheet()->getStyle('B4')->getAlignment()->applyFromArray(
            array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,));

        $objPHPExcel->getActiveSheet()->setCellValue('D4', 'Average CSWDO Allocation');
        $objPHPExcel->getActiveSheet()->getStyle('B4')->getAlignment()->applyFromArray(
            array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,));

        $objPHPExcel->getActiveSheet()->setCellValue('E4', 'Average No. of Target Beneficiaries');
        $objPHPExcel->getActiveSheet()->getStyle('B4')->getAlignment()->applyFromArray(
            array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,));

        $objPHPExcel->getActiveSheet()->setCellValue('F4', 'Average MSWDO Allocation');
        $objPHPExcel->getActiveSheet()->getStyle('B4')->getAlignment()->applyFromArray(
            array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,));

        $objPHPExcel->getActiveSheet()->setCellValue('G4', 'Average No. of Target Beneficiaries');
        $objPHPExcel->getActiveSheet()->getStyle('B4')->getAlignment()->applyFromArray(
            array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,));



//Start Editing
        //Part1
        $row2 = 7;
        $col2 = 'A';
        foreach ($getBudgetAllocation as $budgetUtil):

            $objPHPExcel->getActiveSheet()->setCellValue($col2 . $row2, $budgetUtil->region_name);$col2++;
            $objPHPExcel->getActiveSheet()->setCellValue($col2 . $row2, $budgetUtil->BudgetPresentP);$col2++;
            $objPHPExcel->getActiveSheet()->setCellValue($col2 . $row2, $budgetUtil->BeneTargetP);$col2++;
            $objPHPExcel->getActiveSheet()->setCellValue($col2 . $row2, $budgetUtil->BudgetPresentC);$col2++;
            $objPHPExcel->getActiveSheet()->setCellValue($col2 . $row2, $budgetUtil->BeneTargetC);$col2++;
            $objPHPExcel->getActiveSheet()->setCellValue($col2 . $row2, $budgetUtil->BudgetPresentM);$col2++;
            $objPHPExcel->getActiveSheet()->setCellValue($col2 . $row2, $budgetUtil->BeneTargetM);
            if ($col2 == 'G') {
                $col2 = 'A';
            }
            $row2++;

        endforeach;
        $col3 = 'B';
        $row3 = $row2 -1;
        $objPHPExcel->getActiveSheet()->setCellValue('A'.$row2, 'Total');
        for($i = 0; $i < 6; $i++) {
            $objPHPExcel->getActiveSheet()->setCellValue($col3 . $row2, '=SUM(' . $col3 . '7:' . $col3 . $row3 . ')');
            $col3++;
        }
//End Editing
//    //border
        $objPHPExcel->getActiveSheet()->getStyle(
            'A1:' .
            $objPHPExcel->getActiveSheet()->getHighestColumn() .
            $objPHPExcel->getActiveSheet()->getHighestRow()
        )->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
// Rename worksheet (worksheet, not filename)
        $objPHPExcel->setActiveSheetIndex(0)->setTitle('Budget Allocation)');
        // Add new sheet



// Add some data

// Set active sheet index to the first sheet, so Excel opens this as the first asheet
        $objPHPExcel->setActiveSheetIndex(0);

// Redirect output to a client’s web browser (Excel2007)
//clean the output buffer
        ob_end_clean();

//this is the header given from PHPExcel examples. but the output seems somewhat corrupted in some cases.
//header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
//so, we use this header instead.
//    $regionName = $this->reports_model->getRegionName($region);
        $filename = 'Non-CompliantIndicator.xlsx';
        header('Content-type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename='.$filename);
        header('Cache-Control: max-age=0');

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        $objWriter->save('php://output');
    }

    //cmalvarez

    public function pswdo_psb_rider($regionlist){

        $pswdoscoreladder = $this->reports_model->get_pswdoscoreLadder($regionlist);


// Create new PHPExcel object
        $objPHPExcel = new PHPExcel();

// Add some data

        $objPHPExcel->getActiveSheet()->setCellValue('A1', 'Score of PSWDO, by ladderized scaling');
        //autosize column


        $objPHPExcel->getActiveSheet()->getStyle('A1')->getFill()->getStartColor()->setRGB('FF0000');
//        $objPHPExcel->getActiveSheet()->getDefaultRowDimension()->setRowHeight(-1);a
        $objPHPExcel->getActiveSheet()->getRowDimension(1)->setRowHeight(-1);
        $objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setSize(12);
        $objPHPExcel->getActiveSheet()->mergeCells('A1:D2');

        //Center text merge columns
        $objPHPExcel->getActiveSheet()->getStyle('B1')->getAlignment()->applyFromArray(
            array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,));
//    $col = 'A';
//        $row = 5;
        $objPHPExcel->getActiveSheet()->setCellValue('A3', 'Province');
        $objPHPExcel->getActiveSheet()->getStyle('A3')->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->setCellValue('B3', 'Score');
        $objPHPExcel->getActiveSheet()->mergeCells('A3:A5');
        $objPHPExcel->getActiveSheet()->mergeCells('B3:D3');
        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
        //Center text merge columns
        $objPHPExcel->getActiveSheet()->getStyle('B3')->getAlignment()->applyFromArray(
            array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,));
        $objPHPExcel->getActiveSheet()->getStyle('A3')->getAlignment()->applyFromArray(
            array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,));

        $objPHPExcel->getActiveSheet()->getStyle('A3')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);

        $objPHPExcel->getActiveSheet()->mergeCells('B6:D6');
        $objPHPExcel->getActiveSheet()->freezePane('B6');
        //Header
        $objPHPExcel->getActiveSheet()->setCellValue('B4', 'Bronze');
        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getStyle('B4')->getAlignment()->applyFromArray(
            array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,));
        $objPHPExcel->getActiveSheet()->setCellValue('C4', 'Silver');
        $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getStyle('C4')->getAlignment()->applyFromArray(
            array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,));
        $objPHPExcel->getActiveSheet()->setCellValue('D4', 'Gold');
        $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getStyle('D4')->getAlignment()->applyFromArray(
            array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,));
        $row2 = 7;
        $col2 = 'A';
        $previousvalue = '';
        $rank = 0;
        foreach ($pswdoscoreladder as $pswdoscoreladderdata):
            $province = $pswdoscoreladderdata->prov_name;
            $bronze = $pswdoscoreladderdata->Bronze;
            $silver = $pswdoscoreladderdata->Silver;
            $gold = $pswdoscoreladderdata->Gold;


            $objPHPExcel->getActiveSheet()->setCellValue($col2.$row2, $province);$col2++;
            $objPHPExcel->getActiveSheet()->setCellValue($col2.$row2, $bronze);$col2++;
            $objPHPExcel->getActiveSheet()->setCellValue($col2.$row2, $silver);$col2++;
            $objPHPExcel->getActiveSheet()->setCellValue($col2.$row2, $gold);

            if($col2 == 'D'){$col2 = 'A';}
            $row2++;
        endforeach;
//    //border
        $objPHPExcel->getActiveSheet()->getStyle(
            'A1:' .
            $objPHPExcel->getActiveSheet()->getHighestColumn() .
            $objPHPExcel->getActiveSheet()->getHighestRow()
        )->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
// Rename worksheet (worksheet, not filename)
        $objPHPExcel->getActiveSheet()->setTitle('Score of PSWDO ladderized');

// Set active sheet index to the first sheet, so Excel opens this as the first asheet
        $objPHPExcel->setActiveSheetIndex(0);

// Redirect output to a client’s web browser (Excel2007)
//clean the output buffer
        ob_end_clean();

//this is the header given from PHPExcel examples. but the output seems somewhat corrupted in some cases.
//header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
//so, we use this header instead.
//    $regionName = $this->reports_model->getRegionName($region);
        $filename = 'Score of PSWDO ladderized.xlsx';
        header('Content-type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename='.$filename);
        header('Cache-Control: max-age=0');

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        $objWriter->save('php://output');
    }

    //cmalvarez

    public function populate_prov() {
        if($_POST['region_code'] > 0 and isset($_POST) and isset($_POST['region_code'])) {

            $region_code = $_POST['region_code'];
            $provlist = $this->reports_model->get_provinces($region_code);

            $province_list[] = "Choose Province";
            foreach($provlist as $tempprov) {
                $province_list[$tempprov->prov_code] = $tempprov->prov_name;
            }

            $provlist_prop = 'id="provlist" name="provlist" class="form-control" onChange="get_cities();"';

            echo form_dropdown('provlist', $province_list, '', $provlist_prop);
        }
    }
    public function populate_cities() {
        if($_POST['prov_code'] > 0 and isset($_POST) and isset($_POST['prov_code'])) {
            $prov_code = $_POST['prov_code'];
            $citylist = $this->reports_model->get_cities($prov_code);

            $city_list[] = "Choose City";
            foreach($citylist as $tempcity) {
                $city_list[$tempcity->city_code] = $tempcity->city_name;
            }

            $citylist_prop = 'id="citylist" name="citylist" onchange="get_brgy();" class="form-control"';
            echo form_dropdown('citylist', $city_list,'',$citylist_prop);
        }
    }
    public function init_rpmb_session() {

        if(isset($_POST['regionlist']) and $_POST['regionlist'] > 0) {
            $_SESSION['region'] = $_POST['regionlist'];
        }
        if(isset($_POST['provlist']) and $_POST['provlist'] > 0) {
            $_SESSION['province'] = $_POST['provlist'];
        }
        if(isset($_POST['citylist']) and $_POST['citylist'] > 0) {
            $_SESSION['city'] = $_POST['citylist'];
        }
    }




}