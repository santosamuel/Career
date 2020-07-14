<!DOCTYPE html>
<title>Santo Samuel Surja</title>
<head><h1>This is the adding page</h1></head>

<?php
require_once 'pdo.php';
session_start();
?>

<?php
if (!isset($_SESSION['email'])){
    die("ACCESS DENIED");
    return;
}

if (isset($_SESSION['error'])){
    echo '<p style = "color : red;">'.htmlentities($_SESSION['error'])."</p>\n";
    unset ($_SESSION['error']);
}

if (isset($_POST['make']) && isset($_POST['model']) && isset($_POST['year']) && isset($_POST['mileage'])){
    if (strlen($_POST['make']) < 1 || strlen($_POST['model']) < 1 || strlen($_POST['year']) < 1 || strlen($_POST['mileage']) < 1){
        $_SESSION['error'] = "All fields are required";
        header ("Location: add.php");
        return;
    } elseif (!is_numeric($_POST['year']) || !is_numeric($_POST['mileage']) ){
        $_SESSION['error'] = "Year and mileage must be an integer";
        header ("Location: add.php");
        return;
    } else {
        $make = htmlentities($_POST['make']);
        $model = htmlentities($_POST['model']);
        $year = htmlentities($_POST['year']);
        $mileage = htmlentities($_POST['mileage']);
        $sql = "INSERT INTO autos (make, model, year, mileage) VALUES (:make, :model, :year, :mileage)";
        $stmt = $pdo -> prepare($sql);
        $stmt -> execute (array(
            ':make' => $make,
            ':model' => $model,
            ':year' => $year,
            ':mileage' => $mileage));
        $_SESSION['error'] = "Record added";
        header ("Location: index.php");
        return;
    }
}

?>


<html><head></head>
<body>
<form method = "post">
<p>Make <input type = "text" name = "make"></p>
<p>Model <input type = "text" name = "model"></p>
<p>Year <input type = "text" name = "year"></p>
<p>Mileage <input type = "text" name = "mileage"></p>
<p><input type = "submit" value = "Add">
<a href = "index.php">Cancel</a></p>

</form>
