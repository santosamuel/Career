<!DOCTYPE html>
<title>Santo Samuel Surja</title>

<?php
require_once "pdo.php";
session_start();
?>

<?php
unset($_SESSION['email']);
header ("Location: index.php");
?>