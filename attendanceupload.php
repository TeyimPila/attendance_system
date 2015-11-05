<?php


//turn on php error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $name = $_FILES['file']['name'];
    $tmpName = $_FILES['file']['tmp_name'];
    $error = $_FILES['file']['error'];
    $size = $_FILES['file']['size'];
    $ext = strtolower(pathinfo($name, PATHINFO_EXTENSION));

    
    switch ($error) {
        case UPLOAD_ERR_OK:
            $valid = true;
            //validate file extensions
            if (!in_array($ext, array('xlsx', 'xls'))) {
                $valid = false;
                $response = 'Invalid file extension.';
            }
            //validate file size
            if ($size / 1024 / 1024 > 2) {
                $valid = false;
                $response = 'File size is exceeding maximum allowed size.';
            }
            //upload file
            if ($valid) {
                $name = 'file.'.$ext;
                move_uploaded_file($tmpName, "tmpdir/$name");
                header('Location: confirm.php');
                exit;
            }
            break;
        case UPLOAD_ERR_INI_SIZE:
            $response = 'The uploaded file exceeds the upload_max_filesize directive in php.ini.';
            break;
        case UPLOAD_ERR_FORM_SIZE:
            $response = 'The uploaded file exceeds the MAX_FILE_SIZE directive that was specified in the HTML form.';
            break;
        case UPLOAD_ERR_PARTIAL:
            $response = 'The uploaded file was only partially uploaded.';
            break;
        case UPLOAD_ERR_NO_FILE:
            $response = 'No file was uploaded.';
            break;
        case UPLOAD_ERR_NO_TMP_DIR:
            $response = 'Missing a temporary folder. Introduced in PHP 4.3.10 and PHP 5.0.3.';
            break;
        case UPLOAD_ERR_CANT_WRITE:
            $response = 'Failed to write file to disk. Introduced in PHP 5.1.0.';
            break;
        case UPLOAD_ERR_EXTENSION:
            $response = 'File upload stopped by extension. Introduced in PHP 5.2.0.';
            break;
        default:
            $response = 'Unknown error';
            break;
    }

    echo $response;
}





//if (isset($_POST['submit'])$file_ext = strtolower(end(explode('.', $_FILES['ex and $_FILES['excelfile']['name'] != '') {
//    $file_name = $_FILES['excelfile']['name'];
//    $file_size = $_FILES['excelfile']['size'];
//    $file_tmp = $_FILES['excelfile']['tmp_name'];
//    $file_type = $_FILES['excelfile']['type'];
//    celfile']['name'])));
//
//    $extensions = Array("xlsx", "xls");
//
//
//    if (in_array($file_ext, $extensions) == false) {
//        echo "extension not allowed, please choose an excel file.";
//    } elseif ($file_size > 2097152) {
//        echo 'File is too large';
//    } elseif ($file_size == 0) {
//        echo 'file contains no data';
//    } else {
//        
//        $excelfile = $file_tmp;
//        echo "Data You Are about to submit" . '<br/>' . '<br/>';
//        $raw_data = extract_to_array($excelfile); //extracts the excel file into an array
//        $clean_data = clean_data($raw_data); //removes all unnecessory spacess at the end of rows  
//        //print_review($clean_data);
//        //print_r(find_course_info($clean_data));
//        //print_r(students_info($clean_data));
//
////        insert_students($clean_data);
////        insert_section($clean_data);
////        insert_attendance($clean_data);
//        header('Location: confirm.php');
//    }
//} else {
//    echo 'Please choose a file' . '<br>';
//}
