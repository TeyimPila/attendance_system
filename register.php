<!DOCTYPE html>
<?php
require "/thirdpartylib/class.logsys.php";
//\Fr\LS::init();
if (isset($_POST['register'])) {
    $fields = ['id', 'full_name', 'email', 'password'];
    foreach ($fields as $req_field) {
        if (empty($_POST[$req_field])) {
            echo $req_field . ' is Required';
            break;
        } else {
            $id = $_POST['id'];
            $instructor_name = $_POST['full_name'];
            $email = $_POST['email'];
            $password = $_POST['password'];
            \Fr\LS::register($id, $password, array("instructor_name" => $instructor_name, "email" => $email));
        }
    }
}
?>
<html>
    <head>
        <title>

        </title>
    </head>

    <body>
        <form method="POST">
            <label>Instructor ID:</label>
            <input name="id" type="text"><br>


            <label>Instructor name:</label>
            <input name="full_name" type="text"><br>

            <label>Instructor email:</label>
            <input name="email" type="text"><br>

            <label>Instructor password:</label>
            <input name="password" type="password"><br>

            <input type="submit" name="register" value="Register">
        </form>
        <a href="login.php">Login</a>
    </body>
</html>