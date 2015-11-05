<?php
require_once './core_files/excel_file_extractor.php';
require_once './core_files/attendance_processor.php';
include_once './core_files/acessories.php';

$excelfile = 'tmpdir/file.xlsx';
echo "Data You Are about to submit" . '<br/>' . '<br/>';
$raw_data = extract_to_array($excelfile); //extracts the excel file into an array
$clean_data = clean_data($raw_data); //removes all unnecessory spacess at the end of rows  
print_review($clean_data);

if (isset($_GET['cancel'])) {
    header('Location: index.php');
}
if (isset($_GET['submit'])) {
    insert_students($clean_data);
    insert_section($clean_data);
    insert_attendance($clean_data);
    echo "<script>setTimeout(\"location.href = 'index.php';\",10000);</script>";
    
    //header('Location: index.php');
}
?>
<a href='confirm.php?cancel=true'>Cancel</a>
<a href='confirm.php?submit=true'>Submit</a>

