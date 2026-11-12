<?php
require "conexion.php";

$mensaje = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre          = trim($_POST["nombre"]);
    $telefono        = trim($_POST["telefono"]);
    $documento       = trim($_POST["documento"]);
    $edad            = trim($_POST["edad"]);
    $fechaNacimiento = $_POST["fechaNacimiento"];
    $password        = $_POST["password"];
    $confirmPassword = $_POST["confirmPassword"];

    if ($password !== $confirmPassword) {
        $mensaje = "Las contraseñas no coinciden";
        } else {
            try {
            $conexion->beginTransaction();
            $sqlPaciente = $conexion->prepare("INSERT INTO pacientes (Nombres_Apellidos, Telefono, Documento, Edad, Fecha_Nacimiento) VALUES (?, ?, ?, ?, ?)");
            $sqlPaciente->execute([$nombre, $telefono, $documento, $edad, $fechaNacimiento]);
            $claveEncriptada = password_hash($password, PASSWORD_DEFAULT);
            $sqlUsuario = $conexion->prepare("INSERT INTO usuarios (usuario, clave, Documento_Paciente) VALUES (?, ?, ?)");
            $sqlUsuario->execute([$nombre, $claveEncriptada, $documento]);
            $conexion->commit();
            header("Location: index.php?registrado=1");
            exit;
            } catch (PDOException $e) {
            $conexion->rollBack();
            $mensaje = "Error al registrar: es posible que el número de documento ya esté registrado.";
            }
        }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrarse</title>
    <link href="styles.css" rel="stylesheet"/>
</head>
<body>
    <div>
        <h1>Registrarse</h1>
        <p>Completa con tus datos para unirte a nuestra comunidad</p>

        <?php if ($mensaje != ""): ?>
            <p style="color: red; text-align: center; font-weight: bold;"><?php echo $mensaje; ?></p>
        <?php endif; ?>
        
        <form action="crear_usuario.php" method="POST" id="registroForm">

            <fieldset>
                <legend>Datos Personales</legend>

                <div>
                    <label for="nombre">Nombre completo</label>
                    <input type="text" id="nombre" name="nombre" placeholder="Ej: Victoria Larango" required>
                </div>

                <div>
                    <label for="telefono">Teléfono</label>
                    <input type="tel" id="telefono" name="telefono" placeholder="Ej: 1198763456" required>
                </div>

                <div>
                    <label for="documento">Documento</label>
                    <input type="text" id="documento" name="documento" placeholder="Ej: 12345678" required>
                </div>

                <div>
                    <label for="edad">Edad</label>
                    <input type="number" id="edad" name="edad" placeholder="Ej: 25" required>
                </div>

                <div>
                    <label for="fechaNacimiento">Fecha de nacimiento</label>
                    <input type="date" id="fechaNacimiento" name="fechaNacimiento" required>
                </div>
            </fieldset>

            <fieldset>
                <legend>Asegurá tu cuenta</legend>

                <div>
                    <label for="password">Contraseña</label>
                    <input type="password" id="password" name="password" placeholder="Mínimo 8 caracteres" minlength="8" required>
                </div>

                <div>
                    <label for="confirmPassword">Confirmar contraseña</label>
                    <input type="password" id="confirmPassword" name="confirmPassword" placeholder="Repite tu contraseña" minlength="8" required>
                </div>
            </fieldset>

            <div>
                <label>
                    <input type="checkbox" name="terminos" required>
                    Acepto los términos y condiciones de uso y el tratamiento de mis datos médicos.
                </label>
            </div>

            <div>
                <button type="submit">Registrarse</button>

            </div>
        </form>
    </div>
</body>
</html>
