<?php
    session_start();
    if(!isset($_SESSION['Seguridad']) and $_SESSION['Seguridad'] !== "1234"){
        header("Location: bienvenido.php");
        exit;
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="./css/styles.css">
    <link rel="stylesheet" type="text/css" href="./css/mobile.css">
    <title>Super Nova</title>
</head>
<body>
<nav>
        <h2>Super Nova</a></h2>
        <ul>
            <li><a href='escogerMesa.php'  style='color: #015351' id='menu'>Crear Orden</a></li> 
            <li><a href='orden.php'  style='color: #015351' id='orden'>Órdenes</a></li>
            <?php
            if($_SESSION['idTipoUsuario'] == 1){ //Para que solo el admin pueda ver a Usuarios y el Inventario
            echo "<li><a href='inventario.php'  style='color: #015351' id='inventario'>Inventario</a></li>";
            echo "<li><a href='controlUsuarios.php'  style='color: #015351' id='ctrUsuario'>Usuarios</a></li>";
            }
            ?>
            <li><a href="salir.php"  style="color: #015351">Salir</a></li>
        </ul>
</nav>

    <article>
            <img src="./imgs/interiorCafeteria.jpg" class="background">
        </article>

    <br><br>
    <footer>
        <div class="flexbox">
            <div><img src="./imgs/usuario.jpeg"><?php echo $_SESSION['email']?></div>
        </div>
    </footer>
</body>
</html>