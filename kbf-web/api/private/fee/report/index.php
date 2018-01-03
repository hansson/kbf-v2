<?php
    include_once '../../../db.php';
    include_once '../../../../helpers.php';

    $config = require "../../../../kbf.config.php";
    session_start([
        'cookie_lifetime' => 86400,
        'read_and_close'  => true,
    ]);
    forceHttps($config);
    checkSessionApi($config);
    checkAdmin();

    require_once dirname(__FILE__) . '/../../../classes/PHPExcel.php';

    if ($_SERVER['REQUEST_METHOD'] === 'GET') {
        access_log($_SESSION["pnr"] . " - " . $_SERVER['REQUEST_METHOD'] ." - /api/private/fee/report/ - " . http_build_query($_GET));
        $mysqli = getDBConnection($config);
        $year = cleanField($_GET["year"], $mysqli);
        
        $objPHPExcel = new PHPExcel();
        $objPHPExcel->getProperties()->setCreator("Karlskrona Bergsportsförening")
                                    ->setLastModifiedBy("Karlskrona Bergsportsförening")
                                    ->setTitle("Avgifter");

        $from = "$year-01-01 00:00:00";
        $to = "$year-12-31 23:59:59";
        
        $sheet = $objPHPExcel->getActiveSheet();
        $objWorkSheet = $objPHPExcel->createSheet(0); 
        $objPHPExcel->setActiveSheetIndex(0)
                    ->setCellValue('A1', "Avgifter betalda under: $year")
                    ->setCellValue('A3', 'Avgift')
                    ->setCellValue('B3', 'Pris')
                    ->setCellValue('C3', 'Datum')
                    ->setCellValue('D3', 'Såld av');
        $formated_date = date("Y-m-d", strtotime($from));
        $objPHPExcel->getActiveSheet()->setTitle("$formated_date");

        $sql = "SELECT i.name, i.price, i.paymentDate, p.name FROM item as i
	                INNER JOIN person as p on p.pnr = i.signed
	                WHERE paymentDate > '$from' AND paymentDate < '$to'";
        $result = $mysqli->query($sql);
        $i = 4;
        while($row = $result->fetch_row()) {
            $name = $row[0];
            $price = $row[1];
            $payment_date = $row[2];
            $sold_by = $row[3];
            $objPHPExcel->setActiveSheetIndex(0)
                    ->setCellValue("A$i", $name)
                    ->setCellValue("B$i", $price)
                    ->setCellValue("C$i", $payment_date)
                    ->setCellValue("D$i", $sold_by);
            $i++;
        }
        
        $mysqli->close();

        // Redirect output to a client’s web browser (Excel2007)
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="avgifter.xlsx"');
        header('Cache-Control: max-age=0');
        // If you're serving to IE 9, then the following may be needed
        header('Cache-Control: max-age=1');

        // If you're serving to IE over SSL, then the following may be needed
        header ('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
        header ('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT'); // always modified
        header ('Cache-Control: cache, must-revalidate'); // HTTP/1.1
        header ('Pragma: public'); // HTTP/1.0

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        $objWriter->save('php://output');
        exit;
    } else {
        error("Not implemented");
    }

?>

