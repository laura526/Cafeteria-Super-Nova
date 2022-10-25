<?php
    //Este archivo es para
    session_start();
    if(!isset($_SESSION['Seguridad']) and $_SESSION['Seguridad'] !== "1234"){
        header("Location: bienvenido.php");
        exit();
    }
    $p_orden = $_GET['orden'];
    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
    $mysqli = new mysqli();
    $mysqli->options(MYSQLI_OPT_INT_AND_FLOAT_NATIVE, 1);
    $mysqli->real_connect('localhost','root','12345','cafeteria');

        if(isset($_SESSION['carrito'])){// verifica que exista el carrito y luego los inserta en la liena
            foreach ($_SESSION['carrito'] as $x){
                $stmt = $mysqli->prepare("INSERT INTO lineasorden(idOrden,idProducto,cantidad) VALUES (?,?,?)"); //agrega las lineas de la orden por cada producto
                $stmt->bind_param("iii",$p_orden, $x['idProducto'],$x['Cantidad']);
                $stmt->execute();
            }
         }
         unset($_SESSION['carrito']); //Para que se limpie mi carrito y no aparezcan los productos ingresados antes y que se pueda reutilizar para otras órdenes
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="./css/styles.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <title>OrdenCompletada</title>

</head>
<body>
<header class="submenu">
    <nav>
    <h2>Orden Solicitada</h2>
        <ul>
            <li></li>
        </ul>
    </nav>

</header>
<div class="ordenCabeza">
    <?php
            $result = $mysqli->query("SELECT orden.idorden AS orden,orden.fecha AS fecha,mesa.numeroMesa AS numero,usuarios.nombre AS usuario FROM mesa, orden, usuarios WHERE orden.idMesa = mesa.idmesa AND orden.idUsuario = usuarios.idUsuario AND orden.idorden =  $p_orden");
            $row = $result->fetch_assoc();
            echo '<h1>Orden# '.$row['orden'].'</h1>';
            echo '<p>Fecha: '.$row['fecha'].'</p>';
            echo '<p>Numero de Mesa: '.$row['numero'].'</p>';
            echo '<p>Mesero: '.$row['usuario'].'</p>';
    ?>
</div>
<div class="ordenLineas">  //lineas de la orden
    <ul>
    <?php
        $lineas = $mysqli->query("SELECT productos.producto AS producto,productos.precio AS precio,lineasorden.cantidad AS cantidad FROM lineasorden, productos WHERE lineasorden.idProducto = productos.idProducto AND lineasorden.idOrden =  $p_orden");
        foreach ($lineas as $row) {
            echo "<li>".$row['producto']."</li>";
            echo "<li>".$row['precio']."</li>";
            echo "<li>".$row['cantidad']."</li>";
        }
    ?>
    </ul>
</div>
<a href="orden.php"  style="color: #015351">Mostrar Órdenes</a> <!--Me lleva a órdenes y muestra las mesas con órdenes-->
</body>
</html>