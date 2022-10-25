<?php
    session_start();
    if(!isset($_SESSION['Seguridad']) and $_SESSION['Seguridad'] !== "1234"){
        header("Location: bienvenido.php");
        exit();
    }
    $p_idmesa = $_GET['idmesa']; //Guardando idMesa para luego hacer el select y mostrar los datos de la Orden a la cual está asociada esa Mesa
    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
    $mysqli = new mysqli();
    $mysqli->options(MYSQLI_OPT_INT_AND_FLOAT_NATIVE, 1);
    $mysqli->real_connect('localhost','root','12345','cafeteria');

    //Esto es para borrar un producto o una línea de la orden
    if(isset($_GET['idlinea'])){
        $stmt = $mysqli->prepare("DELETE FROM lineasorden WHERE idlineasOrden = ?");
        $stmt->bind_param("i",$_GET['idlinea']);
        $stmt->execute();
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="./css/styles.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <?php
     echo '<title>OrdenCompletada</title>';
    ?>
</head>
<body id="background">
<header class="submenu">
    <nav>
    <h2>Detalle de la Mesa</h2>
        <ul>
        <li><a href="orden.php"  style="color: #015351">Regresar</a></li>
        </ul>
    </nav>

</header>
<div class="ordenCabeza">
    <?php
            $result = $mysqli->query("SELECT orden.idorden AS orden,orden.fecha AS fecha,mesa.numeroMesa AS numero,usuarios.nombre AS usuario FROM mesa, orden, usuarios WHERE orden.idMesa = mesa.idmesa AND orden.idUsuario = usuarios.idUsuario AND orden.idMesa =  $p_idmesa AND orden.estado = 'A' ");
            $row = $result->fetch_assoc();
            $p_idOrden = $row['orden'];
            echo '<h1>Orden# '.$row['orden'].'</h1>';
            echo '<p>Fecha: '.$row['fecha'].'</p>';
            echo '<p>Numero de Mesa: '.$row['numero'].'</p>';
            echo '<p>Mesero: '.$row['usuario'].'</p>';
            echo '<a href="menu.php?orden='.$row['orden'].'">Agregar mas productos</a>';
            //Pasando 
            echo '<a href="cerrarOrden.php?idorden='.$row['orden'].'">Cerrar Orden</a>'
    ?>
</div>
<div class="ordenLineas">
    <ul>
    <?php
        $lineas = $mysqli->query("SELECT productos.producto AS producto,productos.precio AS precio,lineasorden.cantidad AS cantidad, lineasorden.idlineasOrden AS idlinea  FROM lineasorden, productos WHERE lineasorden.idProducto = productos.idProducto AND lineasorden.idOrden =  $p_idOrden");
        foreach ($lineas as $row) {
            echo "<li>".$row['producto']."</li>";
            echo "<li>".$row['precio']."</li>";
            echo "<li>".$row['cantidad']."</li>";
            echo '<li><a href="mostrarOrden.php?idmesa='.$p_idmesa.'&idlinea='.$row['idlinea'].'">eliminar linea</a></li>';
        }
    ?>
    </ul>
</div>
</body>
</html>