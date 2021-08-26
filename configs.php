<?php
// $servername = "localhost";
// $username = "root";
// $password = "";
// $database = "comics";

$servername = "remotemysql.com";
$username = "LNlwe9Djw6";
$password = "a0zJCvN2so";
$database = "LNlwe9Djw6";

// Create connection
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}