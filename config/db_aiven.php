<?php
// Copy the contents into your existing config/database file
// (or rename this one and keep the same variable name your pages use, e.g. $conn).
// Values come from Render environment variables.

$host = getenv('DB_HOST') ?: 'localhost';
$port = (int)(getenv('DB_PORT') ?: 3306);
$user = getenv('DB_USER') ?: 'root';
$pass = getenv('DB_PASS') ?: '';
$name = getenv('DB_NAME') ?: 'defaultdb';

mysqli_report(MYSQLI_REPORT_OFF);
$conn = mysqli_init();

// Aiven requires SSL
if (getenv('DB_HOST') && getenv('DB_HOST') !== 'localhost') {
    mysqli_ssl_set($conn, null, null, null, null, null);
    $flags = MYSQLI_CLIENT_SSL | MYSQLI_CLIENT_SSL_DONT_VERIFY_SERVER_CERT;
} else {
    $flags = 0;
}

if (!mysqli_real_connect($conn, $host, $user, $pass, $name, $port, null, $flags)) {
    http_response_code(500);
    die('Database connection failed.');
}
mysqli_set_charset($conn, 'utf8mb4');
