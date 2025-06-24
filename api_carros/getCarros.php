<?php
header("Content-Type: application/json");

$host = 'localhost';  // Cambiado de 192.localhost a localhost
$user = 'root';
$pass = '';
$dbname = 'carrosdb';

$conn = new mysqli($host, $user, $pass, $dbname);

if ($conn->connect_error) {
    http_response_code(500);
    echo json_encode(['error' => 'Error de conexión: ' . $conn->connect_error]);
    exit;
}

$sql = "SELECT * FROM carros";
$result = $conn->query($sql);

$carros = [];

if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $carros[] = $row;
    }
}

$conn->close();

echo json_encode($carros);
