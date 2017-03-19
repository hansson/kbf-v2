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
    checkResponsible();

    require_once dirname(__FILE__) . '/../../../classes/PHPExcel.php';

    if ($_SERVER['REQUEST_METHOD'] === 'GET') {
        access_log($_SESSION["pnr"] . " - " . $_SERVER['REQUEST_METHOD'] ." - /api/private/report/ - " . http_build_query($_GET));
        $mysqli = getDBConnection($config);
        $year = cleanField($_GET["year"], $mysqli);
        $month = cleanField($_GET["month"], $mysqli);
        
        $objPHPExcel = new PHPExcel();
        $objPHPExcel->getProperties()->setCreator("Karlskrona Bergsportsförening")
                                    ->setLastModifiedBy("Karlskrona Bergsportsförening")
                                    ->setTitle("Kassablad");

        $open_reports = [];
        $from = "$year-$month-01 00:00:00";
        $month++;
        $to = "$year-$month-01 00:00:00";
        $sql = "select id from `open` WHERE `date` > '$from' AND `date` < '$to'";
        $result = $mysqli->query($sql);
        while($row = $result->fetch_row()) {
            $open_reports[] = $row[0];
        }
        $result->close();
        $i = 0;
        for($i = 0  ; $i < count($open_reports) ; $i++) {
            $open_id = $open_reports[$i];

            $sheet = $objPHPExcel->getActiveSheet();
            $objWorkSheet = $objPHPExcel->createSheet($i); 
            $objPHPExcel->setActiveSheetIndex($i)
                        ->setCellValue('A5', 'Namn')
                        ->setCellValue('B5', 'Medlemsnummer')
                        ->setCellValue('C5', 'Total');

            $sql = "SELECT o.date, o.total, r.name, s.name, op.pnr, p.name, op.name, COALESCE(SUM(oi.price),0) 
                        FROM `open` as o 
                        INNER JOIN person AS r ON r.pnr = o.responsible 
                        INNER JOIN person AS s ON s.pnr = o.`signed` 
                        INNER JOIN open_person AS op ON o.id = op.open_id 
                        LEFT JOIN person as p ON p.pnr = op.pnr 
                        LEFT JOIN open_item AS oi ON oi.open_person = op.id 
                    WHERE o.id = $open_id 
                    GROUP BY op.id";
            $result = $mysqli->query($sql);
            $counter = 6;
            while($row = $result->fetch_row()) {
                $pnr = $row[4];
                $name = "";
                if($pnr) {
                    $name = $row[5];
                } else {
                    $name = $row[6];
                }
                $sum = $row[7];
                $objPHPExcel->setActiveSheetIndex($i)
                        ->setCellValue("A$counter", $name)
                        ->setCellValue("B$counter", $pnr ? $pnr : "")
                        ->setCellValue("C$counter", $sum);
                if($counter === 6) {
                    $time = strtotime($row[0]);
                    $formated_date = date("Y-m-d", $time);
                    $objPHPExcel->getActiveSheet()->setTitle("$formated_date");
                    $total = $row[1];
                    $responsible = $row[2];
                    $signed = $row[3];
                    $objPHPExcel->setActiveSheetIndex($i)
                        ->setCellValue("A1", "Öppetansvarig: ")
                        ->setCellValue("A2", "Signerad av: ")
                        ->setCellValue("B1", "$responsible")
                        ->setCellValue("B2", "$signed");
                }
                $counter++;
            }
        }
        $mysqli->close();

        // Redirect output to a client’s web browser (Excel2007)
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="kassablad.xlsx"');
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

