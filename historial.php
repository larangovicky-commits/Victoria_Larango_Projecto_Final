<?php
session_start();
if (!isset($_SESSION["usuario"], $_SESSION["documento_paciente"])) {
    header("Location: index.php");
    exit;
}

require "conexion.php";

$consultaHistorial = $conexion->prepare(
    "SELECT ID_Historial, Nombre_Apellido, Medico_Tratante, Matricula, Fecha, Tratamiento
    FROM historialmedico
    WHERE Documento_Paciente = ?
    ORDER BY Fecha DESC, ID_Historial DESC"
);
$consultaHistorial->execute([$_SESSION["documento_paciente"]]);
$historial = $consultaHistorial->fetchAll();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Historial médico - Meditech</title>
    <link href="styles.css" rel="stylesheet"/>
</head>
<body>
    <div>
        <h1>Meditech ✚</h1>
        <p>Historial médico de <strong><?php echo htmlspecialchars($_SESSION["usuario"]); ?></strong></p>

        <?php if ($historial): ?>
            <?php foreach ($historial as $registro): ?>
                <section class="history-entry">
                    <h2><?php echo htmlspecialchars($registro["Fecha"] ?? ""); ?></h2>
                    <dl>
                        <dt>Paciente</dt>
                        <dd><?php echo htmlspecialchars($registro["Nombre_Apellido"] ?? ""); ?></dd>
                        <dt>Médico tratante</dt>
                        <dd><?php echo htmlspecialchars($registro["Medico_Tratante"] ?? ""); ?></dd>
                        <dt>Matrícula</dt>
                        <dd><?php echo htmlspecialchars($registro["Matricula"] ?? ""); ?></dd>
                        <dt>Tratamiento</dt>
                        <dd><?php echo nl2br(htmlspecialchars($registro["Tratamiento"] ?? "")); ?></dd>
                    </dl>
                </section>
            <?php endforeach; ?>
        <?php else: ?>
            <p>No hay registros en el historial médico.</p>
        <?php endif; ?>

        <p><a class="history-button" href="panel.php">Volver al panel</a></p>
    </div>
</body>
</html>
