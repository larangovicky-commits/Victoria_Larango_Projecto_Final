<?php
    session_start();
    if (!isset($_SESSION["usuario"])) {
        header("Location: index.php");
        exit;
    }
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
    </div>
</body>
</html>