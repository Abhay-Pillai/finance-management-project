<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

var_dump($_SESSION); // Debug session data

if (!isset($_SESSION["username"])) {
    die("Session not set! Redirecting...");
    header("Location: server.html");
    exit();
}

echo "✅ Welcome, " . $_SESSION["username"];
?>