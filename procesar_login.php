<?php

session_start();
require "conexion.php";

$user = $_POST["user"];
$pass   = $_POST["password"];

$consultaUsuario = $conexion->prepare("SELECT * FROM usuarios WHERE usuario = ?");
$consultaUsuario->execute([$user]);
$usuario = $consultaUsuario->fetch();
$paciente = false;

if ($usuario) {
    $consultaPaciente = $conexion->prepare("SELECT * FROM pacientes WHERE Documento = ?");
    $consultaPaciente->execute([$usuario["Documento_Paciente"]]);
    $paciente = $consultaPaciente->fetch();
}

if ($usuario && $paciente && password_verify($pass, $usuario["clave"])) {
    $_SESSION["usuario"] = $usuario["usuario"];
    $_SESSION["paciente"] = $paciente;
    $_SESSION["documento_paciente"] = $paciente["Documento"];

    header("Location: panel.php");
    exit;
}

header("Location: index.php?error=1");
?>