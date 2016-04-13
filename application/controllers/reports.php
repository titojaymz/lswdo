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

        $this->load->view('header');
        $this->load->view('nav');
        $this->load->view('sidebar');
        $this->load->view('reports_listview');
        $this->load->view('footer');

    }
    public function pswdo_score(){

    $pswdo_details = $this->reports_model->get_pswdoscore();


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
    $filename = 'PSWDO.xlsx';
    header('Content-type: application/vnd.ms-excel');
    header('Content-Disposition: attachment;filename='.$filename);
    header('Cache-Control: max-age=0');

    $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
    $objWriter->save('php://output');
}
    public function cmswdo_score(){

        $pswdo_details = $this->reports_model->get_cmswdoscore();


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
        foreach ($pswdo_details as $pswdodata):
            $region = $pswdodata->region_name;
            $province = $pswdodata->prov_name;
            $city = $pswdodata->city_name;
            $baselinescore = $pswdodata->baseline_score;
            $leveloffunction = $pswdodata->level_function_baseline;

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
        $filename = 'C/MSWDO.xlsx';
        header('Content-type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename='.$filename);
        header('Cache-Control: max-age=0');

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        $objWriter->save('php://output');
    }
}