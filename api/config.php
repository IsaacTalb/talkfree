<?php
// api/config.php

// Load environment variables from .env file
function loadEnv($filePath) {
    if (!file_exists($filePath)) {
        die("Environment file not found: $filePath");
    }

    $env = [];
    $lines = file($filePath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    foreach ($lines as $line) {
        if (strpos(trim($line), '#') === 0) continue; // Skip comments
        list($key, $value) = explode('=', $line, 2);
        $env[trim($key)] = trim($value, " '\"");
    }
    return $env;
}

// Load the .env file
$env = loadEnv(__DIR__ . '/../.env');

function getDb() {
    global $env;

    $connection = $env['DB_CONNECTION'] ?? 'mysql';
    $host = $env['DB_HOST'] ?? '127.0.0.1';
    $port = $env['DB_PORT'] ?? 3306;
    $dbName = $env['DB_DATABASE'] ?? '';
    $username = $env['DB_USERNAME'] ?? '';
    $password = $env['DB_PASSWORD'] ?? '';

    try {
        $db = new PDO("$connection:host=$host;port=$port;dbname=$dbName;charset=utf8mb4", $username, $password);
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $db;
    } catch (PDOException $e) {
        die("Database connection failed: " . $e->getMessage());
    }
}

function jsonResponse($data, $statusCode = 200) {
    http_response_code($statusCode);
    header('Content-Type: application/json');
    echo json_encode($data);
    exit;
}

// Function to validate and sanitize input
function sanitizeInput($input) {
    return htmlspecialchars(trim($input), ENT_QUOTES, 'UTF-8');
}

// Check if user is logged in
function isLoggedIn() {
    session_start();
    return isset($_SESSION['user_id']);
}

// Get current user ID
function getCurrentUserId() {
    if (isLoggedIn()) {
        return $_SESSION['user_id'];
    }
    return null;
}
?>