<?php
    header("Content-Type: application/json");

    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        http_response_code(405);
        echo json_encode(['error' => 'Solo método POST es permitido']);
        exit();
    }

    require 'conexionSakila.php';

    $Data = json_decode(file_get_contents('php://input'), true);
    $Tipo = $Data['Tipo'];
    $Modelo = $Data['Modelo'];
    $Año = $Data['Año'];
    $Precio = $Data['Precio'];
    $Color = $Data['Color'];

    $query = $conn->prepare("INSERT INTO carros (tipo, modelo, año, precio, color) VALUES (?, ?, ?, ?, ?)");

    if (!$query) {
        http_response_code(500);
        echo json_encode(["error" => "Ocurrió un error al preparar la consulta"]);
        exit;
    }

    $query->bind_param("ssiis", $Tipo, $Modelo, $Año, $Precio, $Color);

    if ($query->execute()) {
        echo json_encode(["mensaje" => "Carro insertado correctamente", "carro_id" => $query->insert_id]);
    } else {
        http_response_code(500);
        echo json_encode(["error" => "Fallo la inserción", "detalle" => $query->error]);
    }

    $query->close();
    $conn->close();
?>
