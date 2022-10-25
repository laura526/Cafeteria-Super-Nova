<?php
    session_start();

    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
    $mysqli = new mysqli();
    $mysqli->options(MYSQLI_OPT_INT_AND_FLOAT_NATIVE, 1);
    $mysqli->real_connect('localhost','root','12345','cafeteria');

    if(isset($_GET['idorden'])){
        $p_idOrden = $_GET['idorden'];
        $cantidades = $mysqli->query("SELECT SUM(cantidad) AS cantidad, idProducto FROM lineasorden WHERE idOrden = $p_idOrden GROUP BY idProducto");
        foreach ($cantidades as $row) {
            //En el href se le pasa a mostrarOrden.php el idMesa para poder hacer una consulta a la bd y traerse los datos de la orden
            $p_idProducto = $row['idProducto'];
            $p_cantidadConsumo = $row['cantidad'];
            $cantidadProducto = $mysqli->query("select cantidad from productos where idProducto = $p_idProducto");
            $inventario = $cantidadProducto->fetch_assoc();
            $p_cantidadExistente = $inventario['cantidad'];
            $p_cantidadTotal = $p_cantidadExistente - $p_cantidadConsumo;
            $stmt = $mysqli->prepare("UPDATE productos SET cantidad = ? WHERE idProducto = ?");
            $stmt->bind_param("ii",$p_cantidadTotal,$p_idProducto);
            $stmt->execute();
          }

        $result = $mysqli->query("SELECT idmesa FROM  orden WHERE estado = 'A' and idorden=".$_GET['idorden']);
        $row = $result->fetch_assoc();
        $p_idmesa = $row['idmesa'];
        $stmt = $mysqli->prepare("UPDATE orden SET estado = 'C' WHERE idorden = ?");
        $stmt->bind_param("i",$_GET['idorden']);
        $stmt->execute();
        $stmt = $mysqli->prepare("UPDATE mesa SET estado = 'A' WHERE idmesa = ?");
        $stmt->bind_param("i",$p_idmesa);
        $stmt->execute();
    }

    header("Location: escogerMesa.php");
?>
