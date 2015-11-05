<?php

function int_to_time($int) {
    return date("Y-m-d", strtotime("30-12-1899 + $int days"));
}

function print_review($array) {

    echo "<table border=\"1\" style=\"white-space: nowrap; border-collapse:collapse\">";
    foreach ($array as $row) {
        if (preg_match('[^A(0|1)00.{5}]i', $row['A'])) {
            $student_id = $row['A'];
            $query = "select `student_id` "
                    . "FROM course_section, attendance "
                    . "WHERE course_section.section_id = attendance.section_id "
                    . "AND attendance.student_id = '" . $student_id . "'";
            if (mysql_num_rows(mysql_query($query)) === 0) {
                echo '<tr>';
                foreach ($row as $data) {
                    echo "<td bgcolor=\"#FF0000\">" . $data . "</td>";
                }
                echo '</tr>';
            } else {
                echo '<tr>';
                foreach ($row as $data) {
                    echo '<td >' . $data . '</td>';
                }
                echo '</tr>';
            }
        } else {
            echo '<tr>';
            foreach ($row as $data) {
                if (preg_match('/^\d{5}$/', $data)) {
                    echo '<td >' . date("d/M", strtotime(int_to_time($data))) . '</td>';
                } else {
                    echo '<td >' . $data . '</td>';
                }
            }
            echo '</tr>';
        }
    }
    echo '</table>';
    echo '<br>';
    echo '<br>';
    echo '<br>';
}
