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
    <script src="./js/carritoRouter.js"></script>
    <title>Menú</title>

</head>
<body>
<header class="submenu">
    <nav>
    <h2>Escoger Productos</a></h2>
        <ul>
            <li><a href="index.php"  style="color: #015351">Regresar</a></li>
        </ul>
    </nav>

</header>

<table >
    <tr>   
        <td>Producto</td>
        <td>Código</td>
        <td>Imagen</td> 
        <td>Disponible</td>
        <td>Precio</td>
        <td>Descripción</td>
        <td>Cantidad</td>
        <td>Accion</td>
    </tr>
<?php
$consulta = "SELECT producto, codigo, imagen,cantidad,precio, descripcion, idTipoProducto FROM productos ORDER BY idTipoProducto";
    if ($resultado = mysqli_query($conexion, $consulta)) {

        while ($row = mysqli_fetch_assoc($resultado)) {

            $producto = $row['producto'];
            $codigo = $row['codigo'];
            $imagen = $row['imagen'];
            $stock = $row['cantidad'];
            $precio = $row['precio'];
            $descripcion = $row['descripcion'];

            echo "<tr>";
            echo "<td>$producto</td>";
            echo "<td>$codigo</td>";
            echo '<td><img src ="'.$imagen.'" style="max-width: 100px"></td>';
            echo "<td>$stock</td>";
            echo "<td>$precio</td>";
            echo "<td>$descripcion</td>";
            echo '<td><input type="number" name="cantidad" id="'.$codigo.'"<td>';
            echo '<td><input type="button" class="botonAgregar" name="agregar" value="agregar" onclick=""/></td>'; //Esto se va a "./JS/carritoRouter.js"
            echo "</tr>";
        }
    }
    ?>
</table>
<div>
    <?php
    echo '<h1>Detalle de la Orden#'.$_GET['orden'].'</h1>';
    ?>
    <div>
    <table>
    <thead>
        <tr>
            <td>Producto</td>
            <td>Código</td>
            <td>Imagen</td>
            <td>Cantidad</td>
            <td>Precio Unitario</td>
        </tr>
    </thead>
    <tbody id="tableBody">
    </tbody>
    </table>
    <?php
    echo '<a href="crearLineas.php?orden='.$_GET['orden'].'">Agregar productos a la orden</a>';
    ?>
    </div>
</div>

</body>
</html>