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
        <h1>✰ DalePlay ✰</h1>
        <p>Iniciá tu sesión para ver tu nueva serie/película favorita</p>

        <form action="#" method="POST" id="registroForm">
            <fieldset>
                <legend>Iniciar</legend>
                
                <div>   
                    <label for="user">Usuario</label>
                    <input type="user" id="user" name="user" placeholder="Ej: victoria_larango" required>
                </div>

                <div>
                    <label for="password">Contraseña</label>
                    <input type="password" id="password" name="password" placeholder="Mínimo 8 caracteres" minlength="8" required>
                </div>
            </fieldset>

            <div>
                <button type="submit">Iniciar sesión</button>
                <button type="submit2">Crear usuario</button>
            </div>
        </form>
    </div>
</body>
</html>