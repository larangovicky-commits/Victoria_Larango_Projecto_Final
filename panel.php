<?php
    session_start();
    if (!isset($_SESSION["usuario"])) {
        header("Location: index.php");
        exit;
    }

    $paciente = $_SESSION["paciente"] ?? null;

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
    <title>Panel - Meditech</title>
    <link href="styles.css" rel="stylesheet"/>
</head>
<body>
    <div>
        <h1>Meditech ✚</h1>
        <p>Bienvenido/a, <strong><?php echo htmlspecialchars($_SESSION["usuario"]); ?></strong></p>

        <input type="checkbox" id="editMode" class="edit-mode">
        <div class="panel-actions">
            <a class="history-button" href="#historial">Historial</a>
            <label for="editMode" class="edit-toggle">
                <span class="edit-label"><span aria-hidden="true">✎</span> Editar datos personales</span>
                <span class="cancel-label"><span aria-hidden="true">✖</span> Cancelar</span>
            </label>
        </div>

        <section id="historial" aria-label="Historial médico">
            <h2>Historial médico</h2>
            <?php if ($historial): ?>
                <?php foreach ($historial as $registro): ?>
                    <article class="history-entry">
                        <h3><?php echo htmlspecialchars($registro["Fecha"] ?? ""); ?></h3>
                        <dl>
                            <dt>Médico tratante</dt>
                            <dd><?php echo htmlspecialchars($registro["Medico_Tratante"] ?? ""); ?></dd>
                            <dt>Matrícula</dt>
                            <dd><?php echo htmlspecialchars($registro["Matricula"] ?? ""); ?></dd>
                            <dt>Tratamiento</dt>
                            <dd><?php echo nl2br(htmlspecialchars($registro["Tratamiento"] ?? "")); ?></dd>
                        </dl>
                    </article>
                <?php endforeach; ?>
            <?php else: ?>
                <p>No hay registros en el historial médico.</p>
            <?php endif; ?>
        </section>

        <form action="modificar_usuario.php" method="POST" id="updateForm">
            <fieldset>
                <legend>Datos Personales</legend>

                <div>
                    <label for="nombre">Nombre completo</label>
                    <input type="text" id="nombre" name="nombre" value="<?php echo htmlspecialchars($paciente["Nombres_Apellidos"] ?? ""); ?>" placeholder="Ej: Victoria Larango" required>
                </div>

                <div>
                    <label for="telefono">Teléfono</label>
                    <input type="tel" id="telefono" name="telefono" value="<?php echo htmlspecialchars($paciente["Telefono"] ?? ""); ?>" placeholder="Ej: 1198763456" required>
                </div>

                <div>
                    <label for="documento">Documento</label>
                    <input type="text" id="documento" name="documento" value="<?php echo htmlspecialchars($paciente["Documento"] ?? ""); ?>" placeholder="Ej: 12345678" required>
                </div>

                <div>
                    <label for="edad">Edad</label>
                    <input type="number" id="edad" name="edad" value="<?php echo htmlspecialchars($paciente["Edad"] ?? ""); ?>" placeholder="Ej: 25" required>
                </div>

                <div>
                    <label for="fechaNacimiento">Fecha de nacimiento</label>
                    <input type="date" id="fechaNacimiento" name="fechaNacimiento" value="<?php echo htmlspecialchars($paciente["Fecha_Nacimiento"] ?? ""); ?>" required>
                </div>
            </fieldset>

            <div class="form-actions">
                <button type="submit" id="saveButton">Guardar cambios</button>
            </div>
        </form>
    </div>
</body>
</html>