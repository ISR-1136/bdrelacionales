<?php
header("Content-Type: application/json");

if ($_SERVER['REQUEST_METHOD'] !== 'PUT') {
    http_response_code(405);
    echo json_encode(['error' => 'Solo método PUT es permitido']);
    exit();
}

require 'conexionSakila.php';

$input = json_decode(file_get_contents('php://input'), true);

if (!isset($input["id"], $input["Tipo"], $input["Modelo"], $input["Año"], $input["Precio"], $input["Color"])) {
    http_response_code(400);
    echo json_encode(["error" => "Datos incompletos"]);
    exit();
}

$id = intval($input["id"]);
$Tipo = $conn->real_escape_string($input["Tipo"]);
$Modelo = $conn->real_escape_string($input["Modelo"]);
$Año = intval($input["Año"]);
$Precio = floatval($input["Precio"]);
$Color = $conn->real_escape_string($input["Color"]);

$query = "UPDATE carros SET Tipo = ?, Modelo = ?, Año = ?, Precio = ?, Color = ? WHERE id = ?";

$st = $conn->prepare($query);

if (!$st) {
    http_response_code(500);
    echo json_encode(["error" => "Error en la consulta", "detalle" => $conn->error]);
    exit();
}

$st->bind_param("ssisdi", $Tipo, $Modelo, $Año, $Precio, $Color, $id);

if ($st->execute()) {
    if ($st->affected_rows > 0) {
        echo json_encode(["message" => "Carro actualizado correctamente"]);
    } else {
        http_response_code(404);
        echo json_encode(["error" => "No se encontró el carro con id: $id"]);
    }
} else {
    http_response_code(500);
    echo json_encode(["error" => "Error al ejecutar", "detalle" => $st->error]);
}

$st->close();
$conn->close();
?>
