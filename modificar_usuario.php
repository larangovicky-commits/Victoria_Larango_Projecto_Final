<?php
session_start();

if (!isset($_SESSION["usuario"], $_SESSION["documento_paciente"])) {
    header("Location: index.php");
    exit;
}

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    http_response_code(405);
    header("Allow: POST");
    exit("Método no permitido.");
}

$campos = ["nombre", "telefono", "documento", "edad", "fechaNacimiento"];
foreach ($campos as $campo) {
    if (!isset($_POST[$campo]) || !is_string($_POST[$campo]) || trim($_POST[$campo]) === "") {
        http_response_code(400);
        exit("Completa todos los campos.");
    }
}

$nombre = trim($_POST["nombre"]);
$telefono = trim($_POST["telefono"]);
$documento = trim($_POST["documento"]);
$edad = filter_var($_POST["edad"], FILTER_VALIDATE_INT);
$fechaNacimiento = $_POST["fechaNacimiento"];
$fechaValida = DateTime::createFromFormat("!Y-m-d", $fechaNacimiento);

if (
    $nombre === "" ||
    !ctype_digit($telefono) ||
    !ctype_digit($documento) ||
    $edad === false ||
    $edad < 0 ||
    !$fechaValida ||
    $fechaValida->format("Y-m-d") !== $fechaNacimiento
) {
    http_response_code(400);
    exit("Verifica los datos ingresados.");
}

require "conexion.php";

$documentoAnterior = $_SESSION["documento_paciente"];

try {
    $conexion->beginTransaction();

    $buscarPaciente = $conexion->prepare(
        "SELECT ID FROM pacientes WHERE Documento = ? FOR UPDATE"
    );
    $buscarPaciente->execute([$documentoAnterior]);
    if (!$buscarPaciente->fetch()) {
        $conexion->rollBack();
        http_response_code(404);
        exit("No se encontró el paciente.");
    }

    $actualizarUsuario = $conexion->prepare(
        "UPDATE usuarios SET usuario = ? WHERE Documento_Paciente = ?"
    );
    $actualizarUsuario->execute([$nombre, $documentoAnterior]);

    $actualizarPaciente = $conexion->prepare(
        "UPDATE pacientes
        SET Nombres_Apellidos = ?, Telefono = ?, Documento = ?, Edad = ?, Fecha_Nacimiento = ?
        WHERE Documento = ?"
    );
    $actualizarPaciente->execute([
        $nombre,
        $telefono,
        $documento,
        $edad,
        $fechaNacimiento,
        $documentoAnterior
    ]);

    $conexion->commit();

    $_SESSION["usuario"] = $nombre;
    $_SESSION["documento_paciente"] = $documento;
    $_SESSION["paciente"] = [
        "Nombres_Apellidos" => $nombre,
        "Telefono" => $telefono,
        "Documento" => $documento,
        "Edad" => $edad,
        "Fecha_Nacimiento" => $fechaNacimiento
    ];

    header("Location: panel.php?actualizado=1");
    exit;
} catch (PDOException $error) {
    if ($conexion->inTransaction()) {
        $conexion->rollBack();
    }

    error_log($error->getMessage());
    http_response_code(500);
    exit("No se pudieron guardar los cambios.");
}
