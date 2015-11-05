<?php

include_once 'C:/xampp/htdocs/aun_attendance_system/thirdpartylib/PHPExcel.php';


/* * this function takes in an excel file as its arguments and returns a 2 dimentional
 * php array containing the data in the excel file
 */

function extract_to_array($attendance_sheet) {
    $objPHPExcel = PHPExcel_IOFactory::load($attendance_sheet); //creates a PHPExcel object
    //get only the Cell Collection
    $cell_collection = $objPHPExcel->getActiveSheet()->getCellCollection();

    //extract to a PHP readable array format

    $data_array = Array();
    foreach ($cell_collection as $cell) {
        $column = $objPHPExcel->getActiveSheet()->getCell($cell)->getColumn();
        $row = $objPHPExcel->getActiveSheet()->getCell($cell)->getRow();
        $data_value = $objPHPExcel->getActiveSheet()->getCell($cell)->getValue();


        //header will/should be in row 1 only. 
        if ($row == 1) {
            $header[$row][$column] = $data_value;
        } else {
            $data_array[$row][$column] = $data_value;
        }
    }

    return $data_array;
}

/*
 * The function, clean_data takes in a 2-dimentional array, and "cleans" the data
 * in the array by removing all the unnecessory blank spaces at the end of all the
 * sub-arrays of the 2d array
 */

function clean_data($array_of_data) {
    $array_of_data1 = Array();

    $num_rows = count($array_of_data) + 1; //the number of rows in the data

    for ($row = 2; $row < $num_rows; $row++) {

        //this loop removes all the blan spaces at the end of rows
        while (('' == end($array_of_data[$row]) OR preg_match('/^[a-zA-Z\/]{5}$/', end($array_of_data[$row]))) && !empty($array_of_data[$row])) {
            array_pop($array_of_data[$row]);
            //echo end($array_of_data[$row]);
            //echo '<br>';
        }

        //this condition checks if a row is entirely empty, and deletes it if true
        if (count($array_of_data[$row]) != 0) {
            array_push($array_of_data1, $array_of_data[$row]);
            continue;
        }
    }
    return $array_of_data1;
}

