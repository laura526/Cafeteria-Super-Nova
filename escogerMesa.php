<?php
    session_start();
    if(!isset($_SESSION['Seguridad']) and $_SESSION['Seguridad'] !== "1234"){
        header("Location: bienvenido.php");
        exit;
    }
    require 'conexion.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="./css/styles.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <link rel="stylesheet" type="text/css" href="./css/styles.css">
    <link rel="stylesheet" type="text/css" href="./css/mobile.css">
    <script src="./js/carritoRouter.js"></script>
    <title>Menú</title>

</head>
<body id="background">
<header class="submenu">
    <nav>
    <h2>Escoger Mesa</a></h2>
        <ul>
            <li><a href="index.php"  style="color: #015351">Regresar</a></li>
        </ul>
    </nav>

</header>

<table class="tablemenu">
    <tr>   
        <td># Mesa </td>
        <td> | Estado</td>
        <td>-</td> 
    </tr>
    <?php
            //Va a mostrar únicamente las mesas que están Activas, osea que no están reservadas, solo las que estan activas
           $consulta = "SELECT * FROM mesa WHERE estado = 'A'";
           if ($resultado = mysqli_query($conexion, $consulta)) {
            while ($row = mysqli_fetch_assoc($resultado)) { //es usado para regresar una representación asociativa de la siguiente fila en el resultado
                echo "<tr>";
                echo "<td>".$row['numeroMesa']."</td>";
                echo "<td> | ".$row['estado']."</td>";
                echo "<td><a href='crearOrden.php?mesa=".$row['idmesa']."'>Escoger</a>"; //Le pasamos la mesa a (crearOrden.php) para crearle a la mesa su respectiva orden
                echo "<tr>"; //cuando se selecciona escoger se pasa el # de la mesa escogida, y pasamos a crearOrden.php
            }
        }
    ?>
</table>

</body>
</html>

