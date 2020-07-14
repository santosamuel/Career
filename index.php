<!DOCTYPE html>
<title>Santo Samuel Surja</title>
<html>
<head></head><body>

<?php
require_once "pdo.php";
session_start();
?>

<?php

if (isset($_SESSION['error'])){
    echo '<p style = "color : green;">'.htmlentities($_SESSION['error'])."</p>\n";
    unset($_SESSION['error']);
} 

if (isset($_SESSION['email'])){
    $thing = 0;
    echo "<h1>Welcome to the Automobiles Database</h1>";
    echo('<table border="1">'."\n");
    $stmt = $pdo->query("SELECT make, model, year, mileage, autos_id FROM autos");
    while ( $row = $stmt->fetch(PDO::FETCH_ASSOC) ) {
        echo ("<tr><td>");
        echo (htmlentities($row['make']));
        echo ("</td><td>");
        echo (htmlentities($row['model']));
        echo ("</td><td>");
        echo (htmlentities($row['year']));
        echo ("</td><td>");
        echo (htmlentities($row['mileage']));
        echo ("</td><td>");
        echo ('<a href="edit.php?autos_id='.$row['autos_id'].'">Edit</a> / ');
        echo ('<a href="delete.php?autos_id='.$row['autos_id'].'">Delete</a>');
        echo ("</td></tr>\n");
        $thing = $thing + 1;
    }
    echo '</table>';
    if ($thing == 0){
        echo "No rows found";
    }
    echo '<br>';
    echo "<a href = add.php>Add New Entry</a>";
    echo '<br>';
    echo "<a href = logout.php>Logout</a>";

} elseif (!isset($_SESSION['email'])){
    echo "<head><h1>Welcome to the Automobiles Database</h1></head>";
    echo "<a href='login.php'>Please log in</a>";
}

?>

<?php
if (isset($_POST['logout'])){
    unset($_SESSION['email']);
    header ("Location: index.php");
}
?>
