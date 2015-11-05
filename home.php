<!DOCTYPE html>

<html>
    <head>
        <meta charset="UTF-8">
        <title>Home | AUN Online Attendance Management System</title>
    </head>
    <body>
        <?php
        include_once 'attendanceupload.php';
        require "/thirdpartylib/class.logsys.php";
        session_start();
        //\Fr\LS::init();
        print_r($_SESSION);
        if (isset($_GET['logout'])){
            \Fr\LS::logout();
        }
        ?>
        <form name="excel" action="index.php" method="POST" enctype="multipart/form-data">
            <input type="file" name="file" id="uploadfile"/>
            <input type="submit"  name="submit" value="Submit Attendance"/>
        </form>

        <a href="/aun_attendance_system/home.php?logout=logingout">Log Out</a>
    </body>
</html>
