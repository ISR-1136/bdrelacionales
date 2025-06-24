<?php
header("Content-Type: application/json");

if ($_SERVER['REQUEST_METHOD'] !== 'DELETE') {
    http_response_code(405);
    echo json_encode(['error' => 'Solo método DELETE es permitido']);
    exit();
}

require 'conexionSakila.php';

$input = json_decode(file_get_contents('php://input'), true);

if (!isset($input["id"])) {
    http_response_code(400);
    echo json_encode(["error" => "Falta el id en la solicitud"]);
    exit();
}

$id = intval($input["id"]);
if ($id <= 0) {
    http_response_code(400);
    echo json_encode(["error" => "id inválido"]);
    exit();
}

$query = "DELETE FROM carros WHERE id = ?";

$st = $conn->prepare($query);
if (!$st) {
    http_response_code(500);
    echo json_encode(["error" => "Ocurrió un error en la consulta", "detalle" => $conn->error]);
    exit();
}

$st->bind_param("i", $id);
$st->execute();

if ($st->affected_rows > 0) {
    echo json_encode(["mensaje" => "Carro eliminado con éxito"]);
} else {
    http_response_code(404);
    echo json_encode(["error" => "No se encontró el carro con id $id"]);
}

$st->close();
$conn->close();
?>
