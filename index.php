<!DOCTYPE html>

<html>
    <head>
        <meta charset="UTF-8">
        <title>Home | AUN Online Attendance Management System</title>
    </head>
    <body>
        <?php
            include_once 'attendanceupload.php';
        ?>
        <form name="excel" action="index.php" method="POST" enctype="multipart/form-data">
            <input type="file" name="file" id="uploadfile"/>
            <input type="submit"  name="submit" value="Submit Attendance"/>
        </form>

    </body>
</html>
