<?php

include_once 'dbconnect.inc.php';
include_once 'acessories.php';

function find_course_info($arr) {
    if(!preg_match('/^[a-zA-Z]{3}\d{3}$/i', $arr[0]['B'])){
                $code = 'AAA000';
                $sec = '0';
                die("The Course Code is Invalid");
            }
    $dates = Array();
    foreach ($arr as $row) {
        foreach ($row as $data) {
            $data = preg_replace('/\s+/', '', $data);
            if (preg_match('/^[a-zA-Z]{3}\d{3}$/i', $data)) {
                $code = $data;
            } elseif (preg_match('/^[1-9]{1}$/', $data)) {
                $sec = $data;
            } elseif (preg_match('/^\d{5}$/', $data)) {
                array_push($dates, $data);
            }
        }
    }
    return [[$code, $sec], $dates];
}






function students_info($arr) {
    $students = Array();

    foreach ($arr as $row) {
        $data = preg_replace('/\s+/', '', $row['A']);
        if (preg_match('[^A(0|1)00.{5}]i', $data)) {
            $student = Array();
            foreach ($row as $data) {
               array_push($student, $data);
            }
            array_push($students, $student);
        }
    }
    return $students;
}





function insert_students($data_array) {
    $added = 0;
    foreach (students_info($data_array) as $student) {
        $q1 = "SELECT `student_id` FROM `Student` "
                . "WHERE `student_id` LIKE '" . mysql_escape_string($student[0]) . "'";

        $q2 = "INSERT INTO `Student`(`student_id`,`full_names`,`email`) "
                . "VALUES ('" . mysql_escape_string($student[0]) . "',"
                . "'" . mysql_escape_string($student[1]) . "', "
                . "'" . mysql_escape_string($student[2]) . "')";

        if (mysql_num_rows(mysql_query($q1)) == 0) {
            mysql_query($q2);
            $added += mysql_affected_rows();
        }
    }
    echo $added ." Student(s) Updated".'<br>';
}

function insert_section($data_array) {
    $q1 = "SELECT `instructor_id` FROM `Instructor` "
            . "WHERE `instructor_name` LIKE '" . mysql_escape_string($data_array[3]["B"]) . "'";
    $instructor_id = mysql_result(mysql_query($q1), 0);

    $course_code = find_course_info($data_array)[0][0];
    $q2 = "SELECT `CRN` FROM `course` "
            . "WHERE `course_code` LIKE '" . $course_code . "'";

    //check if the course exists in the database
    if (mysql_num_rows(mysql_query($q2)) == 1) {
        $crn = mysql_result(mysql_query($q2), 0);

        $section = find_course_info($data_array)[0][1];

        $q5 = "INSERT INTO `Course_Section` (`section_id`, `course_CRN`, `instructor_id`, `section`)"
                . "SELECT * FROM (SELECT '',  '" . $crn . "', '" . $instructor_id . "',  '" . $section . "') AS tmp
                WHERE NOT EXISTS (
                SELECT '" . $crn . "', '" . $instructor_id . "',  '" . $section . "' "
                . "FROM `Course_Section` "
                . "WHERE `course_CRN` = '" . $crn . "' AND `instructor_id` = '" . $instructor_id . "' AND `section`='" . $section . "') LIMIT 1";

        mysql_query($q5);
        $feed_back = mysql_affected_rows();
    } else {
        $feed_back = "The Course Code not in database";
        die($feed_back);
        //echo $feed_back.'<br>';
    }
    if (preg_match('/[1-9]/', $feed_back)) {
        echo $feed_back.' Section(s) Added'.'<br>';
    } else {
        echo "no new section has been added".'<br>';
    }
}


function insert_attendance($data_array) {
    $dates = find_course_info($data_array)[1];
    $course_code = find_course_info($data_array)[0][0];

    $section = find_course_info($data_array)[0][1];
    $crn_query = "SELECT `CRN` FROM `course` "
            . "WHERE `course_code`='" . $course_code . "'";
    $crn = mysql_result(mysql_query($crn_query), 0);

    //the assumption here is that no two rows in Course_section have same values for course_crn
    $sec_query = "SELECT `section_id`, `instructor_id` FROM `Course_Section` "
            . "WHERE `course_CRN` = '" . $crn . "' AND `section` = '" . $section . "'";
    $section_id = mysql_result(mysql_query($sec_query), 0);
    //echo $section_id;
    $instructor_id = mysql_result(mysql_query($sec_query), 0, "instructor_id");
    $tot = 0;

    foreach (students_info($data_array) as $student) {
        $student_id = $student[0];
        
        for ($i = 3; $i < count($student); $i++) {
            $date = int_to_time($dates[$i - 3]);
            $status = mysql_real_escape_string($student[$i]);

        
            //print_r($student);
            $insert_attendance = "INSERT INTO `Attendance` (`attendance_id`, `student_id`, `section_id`, `course_CRN`, `instructor_id`, `status`, `date`, `timestamp`) "
                    . "SELECT '',  '" . $student_id . "', '" . $section_id . "',  '" . $crn . "',  '" . $instructor_id . "',  NULLIF('" . $status . "', ' '), '" . $date . "', NOW() FROM dual "
                    . "WHERE NOT EXISTS ("
                    . " SELECT * FROM `Attendance` "
                    . "WHERE "
                    . "`student_id` = '" . $student_id . "' "
                    . "AND `section_id` = '" . $section_id . "' "
                    . "AND `course_CRN` = '" . $crn . "' "                    
                    . "AND `instructor_id`='" . $instructor_id . "' "
                    . "AND `date` = '" . $date . "' ) "
                    . "LIMIT 1";

            mysql_query($insert_attendance);
            $tot = $tot + mysql_affected_rows();
            echo mysql_error();
           
        }
    }
    echo $tot ." new attendances added".'<br>';
    echo mysql_error();
}