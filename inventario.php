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
    <link rel="stylesheet" type="text/css" href="./css/mobile.css">
    <title>Inventario | Super Nova</title>
</head>
<body id="background">
<header>
    <h1>Inventario de Productos</h1>
    <nav>
        <ul>
            <li><a href="reporteInventario.php">Reporte Inventario</a><br><br></li>
            <li><a href="index.php">Regresar</a></li>
        </ul> 
    </nav>
    <script>
        function actualizar(id,producto,codigo,cantidad,precio,descripcion,idTipoProducto){
            document.getElementById("idProducto").value = id;
            document.getElementById("producto").value = producto;
            document.getElementById("codigo").value = codigo;
            document.getElementById("cantidad").value = cantidad;
            document.getElementById("precio").value = precio;
            document.getElementById("descripcion").value = descripcion;
            document.getElementById("idTipoProducto").value = idTipoProducto;
        }

        function eliminar(id,producto,codigo,cantidad,precio,descripcion,idTipoProducto){
            document.getElementById("idProducto").value = id;
            document.getElementById("producto").value = producto;
            document.getElementById("codigo").value = codigo;
            document.getElementById("cantidad").value = cantidad;
            document.getElementById("precio").value = precio;
            document.getElementById("descripcion").value = descripcion;
            document.getElementById("idTipoProducto").value = idTipoProducto;
        }
    </script>
</header>
<div id="containerIngresoProductos">
		<h2>Ingreso de Productos</h2>
    <form action="respInventario.php" method="POST" enctype="multipart/form-data"> <!--Entype: necesario para cuando enviamos archivos tipo file-->
            <input type="text" id="idProducto" name="id" readonly placeholder="ID"/><br><br>
			<input  type="text" id="producto" name="producto" placeholder="Producto"><br><br>
            <input type="text" id="codigo" name="codigo" placeholder="Código"><br><br>
            <label for="imagen">Imagen </label>
                <input type="file" id="imagen" name="imagen" multiple><br><br>
			<input type="text" id="cantidad" name="cantidad" placeholder="Cantidad"><br><br>
			<input type="text" id="precio" name="precio" placeholder="Precio"><br><br>
			<input type="text" id="descripcion" name="descripcion" placeholder="Descripción"><br><br>
            <label for="idTipoProducto">1:Helado 2:Bebida 3:Postre</label><br>
                <input type="text" id="idTipoProducto" name="idTipoProducto" placeholder="Tipo"><br><br>
			<input type="submit" name="agregar" value="Agregar" class="estilo"></input>
            <input type="submit" name="actualizar" value="Actualizar" class="estilo"/></input>
            <input type="submit" name="eliminar" value="Eiminar" class="estilo"/></input>
	</form>
</div>

<br><br>

<div >
<h2>Tabla de Productos</h2>
<table  class="tableProductos">
    <tr>
        <td>ID</td>      
        <td class="showCell">Producto</td>
        <td>Código</td>
        <td>Imagen</td>  
        <td class="showCell">Cantidad</td>
        <td class="showCell">Precio</td>
        <td>Descripción</td>
        <td>ID Tipo</td>
    </tr>
    
    <?php
    $consulta = "SELECT idProducto,producto, codigo, imagen,cantidad, precio, descripcion, PRD.idTipoProducto, TP_PRD.tipoProducto FROM productos PRD
                                INNER JOIN tipo_producto TP_PRD ON TP_PRD.idTipoProducto = PRD.idTipoProducto";
    if ($resultado = mysqli_query($conexion, $consulta)) {

        while ($row = mysqli_fetch_assoc($resultado)) {
            echo "<tr>";
            echo "<td>".$row['idProducto']."</td>";
            echo '<td class="showCell">  '.$row['producto']."</td>";
            echo '<td>  '.$row['codigo']."</td>";
            echo "<td><img src ='".$row['imagen']."' style='max-width: 100px;'></td>";
            echo '<td class="showCell">'.$row['cantidad'].'</td>';
            echo '<td class="showCell">  '.$row['precio']."</td>";
            echo "<td>".$row['descripcion']."</td>";
            echo "<td>".$row['idTipoProducto']."  --"."</td>";
            echo "<td>".$row['tipoProducto']."</td>";
            echo '<td class="showCell"><input type="button" name="actualizar" class="estilo" value="Actualizar" onclick="actualizar(\''.$row['idProducto'].'\',\''.$row['producto'].'\',\''.$row['codigo'].'\',\''.$row['cantidad'].'\',\''.$row['precio'].'\',\''.$row['descripcion'].'\',\''.$row['idTipoProducto'].'\');"/></td>';
            echo '<td class="showCell"><input type="button" name="eliminar" class="estilo" value="Eliminar" onclick="eliminar(\''.$row['idProducto'].'\',\''.$row['producto'].'\',\''.$row['codigo'].'\',\''.$row['cantidad'].'\',\''.$row['precio'].'\',\''.$row['descripcion'].'\',\''.$row['idTipoProducto'].'\');"></td>';
            echo "<tr>";
        }
    }
    ?>
</table>
</div>

<?php
    $cadena = "";
    $res    = mysqli_query($conexion, "SELECT TP_PRD.tipoProducto, SUM(cantidad)  FROM productos PRD INNER JOIN tipo_producto TP_PRD
	                                        ON TP_PRD.idTipoProducto = PRD.idTipoProducto
                                       GROUP BY PRD.idTipoProducto") or die(mysqli_error($conexion));
    while ($prod = mysqli_fetch_array($res)) {
        if ($cadena != "") {
            $cadena .= ",";
        }
        $cadena .= "{name: '" . $prod[0] . "',y: " . $prod[1] . "}";
    }
?>
<div style = "margin-left:40%;">
<h1 style="text-align: center">Gráfica del Inventario</h1>
    <div id="container"></div>
    <script src="https://code.highcharts.com/highcharts.js"></script>
    <script src="https://code.highcharts.com/modules/exporting.js"></script>
    <script src="https://code.highcharts.com/modules/export-data.js"></script>
    <script src="https://code.highcharts.com/modules/accessibility.js"></script>
    <script>
        Highcharts.chart('container', {
            chart: {
                plotBackgroundColor: null,
                plotBorderWidth: null,
                plotShadow: false,
                type: 'pie'
            },
            title: {
                text: 'Inventario'
            },
            series: [{
                name: 'En Stock',
                colorByPoint: true,
                data: [<?php echo $cadena; ?>]
            }]
        });
    </script>  
</div>
</body>
</html>