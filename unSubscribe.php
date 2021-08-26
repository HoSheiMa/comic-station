<?php
include 'configs.php';

if (isset($_GET['e'])) {
    $e = $_GET['e'];
    $conn->query("DELETE FROM `emails` WHERE `email`='". $e."'");
    echo "<center>You have successfully Unsubsribe from Comic Station.</center>";
}