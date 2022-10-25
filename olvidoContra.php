<?php
    session_start();
    if(!isset($_SESSION['olvido']) and $_SESSION['olvido'] !== "12"){
        echo "Error".mysqli_error($conexion);
        echo $_SESSION['olvido'];
        //header("Location: bienvenido.php");
        exit;
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="./css/styles.css">
    <link rel="stylesheet" type="text/css" href="./css/mobile.css">

    <title>Contraseña</title>
</head>
<body>
    <header>
        <a href="bienvenido.php">Regresar</a>
    </header>

    <div id="container_olvidoContra">
	<br><br><h1>Olvidó su Contraseña</h1><br><br>
    <p>Ingrese la nueva Contraseña</p><br>
    <form action="respOlvidoContra.php" method="POST">
		<input type="text" name="contra" placeholder="Contraseña"><br><br>
		<input type="submit" name="enviar" value="Enviar" class="estilo"></input><br><br>
	</form>
    </div>

</div>
</body>
</html>