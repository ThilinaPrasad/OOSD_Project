<?php
require 'Classes/PHPExcel/IOFactory.php';
$query_truncate_results = "TRUNCATE TABLE results";
function saveToDB($file_tmp,$subject){
    $inputfilename = $file_tmp;
    global $connection;
//  Read your Excel workbook
    try
    {
        $inputfiletype = PHPExcel_IOFactory::identify($inputfilename);
        $objReader = PHPExcel_IOFactory::createReader($inputfiletype);
        $objPHPExcel = $objReader->load($inputfilename);
    }
    catch(Exception $e)
    {
        die('Error loading file "'.pathinfo($inputfilename,PATHINFO_BASENAME).'": '.$e->getMessage());
    }

//  Get worksheet dimensions
    $sheet = $objPHPExcel->getSheet(0);
    $highestRow = $sheet->getHighestRow();
    $highestColumn = $sheet->getHighestColumn();

//  Loop through each row of the worksheet in turn
    $allDone = true;
    global $query_truncate_results;
    runQuery($query_truncate_results);
    for ($row = 2; $row <= $highestRow; $row++)
    {
        //  Read a row of data into an array
        $rowData = $sheet->rangeToArray('A' . $row . ':' . $highestColumn . $row, NULL, TRUE, FALSE);
        //  Insert row data array into your database of choice here
        $query_excelSend = "INSERT INTO results (indexNumber, studentName, subject, marks) VALUES ('{$rowData[0][0]}','{$rowData[0][1]}','{$subject}','{$rowData[0][2]}')";
        $test = runQuery($query_excelSend);

        if(!$test){
            $allDone = false;
            echo mysqli_error($connection);
        }

    }
    return $allDone;

}

?>
