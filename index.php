<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link href="styles.css" rel="stylesheet"/>
</head>
<body>
    <div>
        <h1>Meditech ✚</h1>
        <form action="procesar_login.php" method="POST" id="registroForm">
            <fieldset>
                <legend>Iniciar</legend>
                
                <div>   
                    <label for="user">Nombre completo</label>
                    <input type="user" id="user" name="user" placeholder="Ej: Victoria Larango" required>
                </div>

                <div>
                    <label for="password">Contraseña</label>
                    <input type="password" id="password" name="password" placeholder="Mínimo 8 caracteres" minlength="8" required>
                </div>
            </fieldset>

            <div>
                <button type="submit">Iniciar sesión</button>
                <button type="button" onclick="window.location.href='crear_usuario.php'" style="background: transparent; color: #136d88; border: 2px solid #136d88;">Registrarse</button>
            </div>
        </form>
    </div>
</body>
</html>