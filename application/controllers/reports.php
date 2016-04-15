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
        $citylist = $this->input->post('citylist');
        $this->load->view('header');
        $this->load->view('nav');
        $this->load->view('sidebar');
        $this->load->view('reports_listview',array(
            'regionlist2' => $regionlist,
            'provlist2' => $provlist,
            'citylist2' => $citylist
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
        $objPHPExcel->getActiveSheet()->mergeCells('B1:E1');

        //Center text merge columns
        $objPHPExcel->getActiveSheet()->getStyle('B1')->getAlignment()->applyFromArray(
            array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,));

        $objPHPExcel->getActiveSheet()->setCellValue('A3', 'Region');
        $objPHPExcel->getActiveSheet()->getStyle('A3')->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->setCellValue('B3', 'Distribution LSWDO by Region');
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




//functional

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

        //Center text merge columns
        $objPHPExcel->getActiveSheet()->getStyle('B1')->getAlignment()->applyFromArray(
            array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,));

        $objPHPExcel->getActiveSheet()->setCellValue('A3', 'Region');
        $objPHPExcel->getActiveSheet()->getStyle('A3')->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->setCellValue('B3', 'Distribution PSWDO by Region');
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
        foreach ($distributionPSWDObyregion as $distributionPSWDObyregiondata):
            $region = $distributionPSWDObyregiondata->region_name;
            $PSWDO = $distributionPSWDObyregiondata->PSWDO;

            $objPHPExcel->getActiveSheet()->setCellValue($col2.$row2, $region);$col2++;
            $objPHPExcel->getActiveSheet()->setCellValue($col2.$row2, $PSWDO);


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

        //Center text merge columns
        $objPHPExcel->getActiveSheet()->getStyle('B1')->getAlignment()->applyFromArray(
            array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,));

        $objPHPExcel->getActiveSheet()->setCellValue('A3', 'Region');
        $objPHPExcel->getActiveSheet()->getStyle('A3')->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->setCellValue('B3', 'Distribution CSWDO by Region');
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
        foreach ($distributionCSWDObyregion as $distributionCSWDObyregiondata):
            $region = $distributionCSWDObyregiondata->region_name;
            $CSWDO = $distributionCSWDObyregiondata->CSWDO;

            $objPHPExcel->getActiveSheet()->setCellValue($col2.$row2, $region);$col2++;
            $objPHPExcel->getActiveSheet()->setCellValue($col2.$row2, $CSWDO);


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
    public function tableView($lguType)
    {
        $indicator_model = new indicator_model();
        $this->load->view('header');
        $this->load->view('nav');
        $this->load->view('sidebar');
        $this->load->view('reports_tableview',array(
            'getFirstMotherIndicator'=>$indicator_model->getFirstMotherIndicator(),
            'getSecondMotherIndicator'=>$indicator_model->getSecondMotherIndicator(),
            'getThirdMotherIndicator'=>$indicator_model->getThirdMotherIndicator(),
            'getFourthMotherIndicator'=>$indicator_model->getFourthMotherIndicator(),
            'getPart1'=>$indicator_model->getPart1($lguType),
            'getPart2'=>$indicator_model->getPart2($lguType),
            'getPart3'=>$indicator_model->getPart3($lguType),
            'getPart4'=>$indicator_model->getPart4($lguType),
            'getScorePart1'=>$indicator_model->getScorePart1(),
        ));
        $this->load->view('footer');

    }
}