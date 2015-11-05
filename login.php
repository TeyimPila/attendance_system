<!DOCTYPE html>
<?php
require "/thirdpartylib/class.logsys.php";
\Fr\LS::init();
if (isset($_POST['action_login'])) {
    //echo 'this';
    $username = $_POST['login'];
    echo $username.'<br>';
    $password = $_POST['password'];
    echo $password.'<br>';
    if ($username == "" || $password == "") {
        $msg = array("Error", "Username / Password Wrong !");
        print_r($msg);
        echo '<br>';
    } else {
        $login = \Fr\LS::login($username, $password, isset($_POST['remember_me']));
        print_r($login);
        if ($login === false) {
            $msg = array("Error", "Username / Password Wrong !");
            print_r($msg);
            echo '<br>';
        } else if (is_array($login) && $login['status'] == "blocked") {
            $msg = array("Error", "Too many login attempts. You can attempt login after " . $login['minutes'] . " minutes (" . $login['seconds'] . " seconds)");
        
            print_r($msg);
            echo '<br>';
        }
    }
}
?>
<html>
    <head>
        <title>Log In</title>
    </head>
    <body>
        <div class="content">
            <form method="POST">
                <label>E-Mail</label><br/>
                <input name="login" type="text"/><br/>
                <label>Password</label><br/>
                <input name="password" type="password"/><br/>
                <label>
                    <input type="checkbox" name="remember_me"/> Remember Me
                </label>
                <button name="action_login">Log In</button>
            </form>
        </div>
    </body>
</html>
