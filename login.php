<!DOCTYPE html>
<title>Santo Samuel Surja</title>
<head><h1>This is the log in page</h1><head>

<?php
require_once "pdo.php";
session_start();

$salt = 'XyZzy12*_';
$stored_hash = '1a52e17fa899cf40fb04cfc42e6352f1';

if (isset($_POST['cancel'])){
    header("Location: index.php");
    return;
}


if (isset($_POST['email']) && isset($_POST['pass'])){
    if (strlen($_POST['email']) < 1 || strlen($_POST['pass']) < 1){
        $_SESSION['error'] = "Please type the email and password correctly";
        header ("Location: login.php");
        return;
    } elseif (strpos($_POST['email'], "@") == FALSE){
        $_SESSION['error'] = "Account must have an at-sign @";
        header ("Location: login.php");
        return;
    } else{
        $check = hash('md5', $salt.$_POST['pass']);
        if ($check == $stored_hash){
            $_SESSION['email'] = $_POST['email'];
            $_SESSION['error'] = "Logged in";
            header ("Location: index.php");
            return;
        } else {
            $_SESSION['error'] = "Incorrect password";
            header ("Location: login.php");
            return;
        }
    }
}

?>

<body>
<form method = "post">
<input type = "hidden" name = "user_id" value = "<?= $row['user_id'] ?>">
<p>User Name <input type = "text" name = "email"></p>
<p>Password <input type = "password" name = "pass"></p>
<input type = "submit" value = "Log In">
<input type = "submit" name = "cancel" value = "cancel">
</form>

<?php
if (isset($_SESSION['error'])){
    echo '<p style = "color : red;">'.htmlentities($_SESSION['error'])."</p>\n";
    unset ($_SESSION['error']);
}
?>

</body>
</html>