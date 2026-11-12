<?php

session_start();
require "conexion.php";

$user = $_POST["user"];
$pass   = $_POST["password"];

$consulta = $conexion->prepare("SELECT * FROM usuarios WHERE usuario = ?");
$consulta->execute([$user]);
$fila = $consulta->fetch();

if ($fila && password_verify($pass, $fila["clave"])) {
    $_SESSION["usuario"] = $fila["usuario"];
    header("Location: panel.php");
    exit;
}

header("Location: index.php?error=1");
?>