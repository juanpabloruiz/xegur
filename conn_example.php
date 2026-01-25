<?php
session_start();

// Show bugs
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Change names of host
$conn = new mysqli('localhost', 'user', 'password', 'db');
$conn->set_charset('utf8mb4');
