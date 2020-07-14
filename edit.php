<!DOCTYPE html>
<title>Santo Samuel Surja</title>
<head><h1>This is the editing page</h1></head>

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

if (!isset($_GET['autos_id'])){
    $_SESSION['error'] = "missing autos_id";
    header ("Location: index.php");
    return;
}

if (isset($_POST['make']) && isset($_POST['model']) && isset($_POST['year']) && isset($_POST['mileage'])){
    if (strlen($_POST['make']) < 1 || strlen($_POST['model']) < 1 || strlen($_POST['year']) < 1 || strlen($_POST['mileage']) < 1){
        $_SESSION['error'] = "All fields are required";
        header ("Location: edit.php?autos_id=".$_POST['autos_id']);
        return;
    } elseif (!is_numeric($_POST['year']) || !is_numeric($_POST['mileage']) ){
        $_SESSION['error'] = "Year and mileage must be an integer";
        header ("Location: edit.php?autos_id=".$_POST['autos_id']);
        return;
    } else {
        $make = htmlentities($_POST['make']);
        $model = htmlentities($_POST['model']);
        $year = htmlentities($_POST['year']);
        $mileage = htmlentities($_POST['mileage']);
        $sql = "UPDATE autos SET make = :make, model = :model, year = :year, mileage = :mileage WHERE autos_id = :autos_id";
        $stmt = $pdo -> prepare($sql);
        $stmt -> execute (array(
            ':make' => $make,
            ':model' => $model,
            ':year' => $year,
            ':mileage' => $mileage,
            ':autos_id' => $_POST['autos_id']));
        $_SESSION['error'] = "Record updated";
        header ("Location: index.php");
        return;
    }
}

$stmt = $pdo->prepare("SELECT * FROM autos where autos_id = :xyz");
$stmt->execute(array(":xyz" => $_GET['autos_id']));
$row = $stmt->fetch(PDO::FETCH_ASSOC);
if ( $row === false ) {
    $_SESSION['error'] = 'Bad value for autos_id';
    header( 'Location: index.php' ) ;
    return;
}

$make2 = htmlentities($row['make']);
$model2 = htmlentities($row['model']);
$year2 = htmlentities($row['year']);
$mileage2 = htmlentities($row['mileage']);
$autos_id = $row['autos_id'];
?>


<html><head></head>
<body>
<form method = "post">
<p>Make <input type = "text" name = "make" value = "<?= $make2?>"></p>
<p>Model <input type = "text" name = "model" value = "<?= $model2?>"></p>
<p>Year <input type = "text" name = "year" value = "<?= $year2?>"></p>
<p>Mileage <input type = "text" name = "mileage" value = "<?= $mileage2?>"></p>
<input type = "hidden" name = "autos_id" value = "<?= $autos_id?>">
<p><input type = "submit" value = "Save"></p>
</form>
