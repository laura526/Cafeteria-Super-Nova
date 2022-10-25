<?php
    session_start();
    if(!isset($_SESSION['Seguridad']) and $_SESSION['Seguridad'] !== "1234" and $_SESSION['idTipoUsuario'] !== 1){
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
    <title>Usuarios | Super Nova</title>
</head>
<body id="background">
<header>
    <h1>Bitácora de Usuarios</h1>
    <nav>
        <ul>
            <li><a href="index.php">Regresar</a></li>
        </ul>

    </nav>
    <script>
        function actualizar(id,nombre,telefono,direccion,correo,estado,idTipoUsuario){
            document.getElementById("idUsuario").value = id;
            document.getElementById("nombre").value = nombre;
            document.getElementById("telefono").value = telefono;
            document.getElementById("direccion").value = direccion;
            document.getElementById("correo").value = correo;
            document.getElementById("estado").value = estado;
            document.getElementById("tipoUsuario").value = idTipoUsuario;
        }

        function eliminar(id,nombre,telefono,direccion,correo,estado,idTipoUsuario){
            document.getElementById("idUsuario").value = id;
            document.getElementById("nombre").value = nombre;
            document.getElementById("telefono").value = telefono;
            document.getElementById("direccion").value = direccion;
            document.getElementById("correo").value = correo;
            document.getElementById("estado").value = estado;
            document.getElementById("tipoUsuario").value = idTipoUsuario;
        }
    </script>
</header>
<div  id="containerIngresoUsuarios">
		<h2>Ingreso de Usuarios</h2>
    <form action="respControlUsuarios.php" method="POST">
            <input type="text" id="idUsuario" name="id" readonly placeholder="#"/><br><br>
			<input type="text" id="nombre" name="nombre" placeholder="Nombre"><br><br>
            <input type="text" id="telefono" name="telefono" placeholder="Teléfono"><br><br>
			<input type="text" id="direccion" name="direccion" placeholder="Dirección"><br><br>
			<input type="text" id="correo" name="correo" placeholder="Correo"><br><br>
            <input type="text" id="estado" name="estado" placeholder="Estado"><br><br>
            <label for="tipoUsuario">Indique su selección<br>1: Admin 2: Empleado 3: Cliente</label><br>
                <input type="text" id="tipoUsuario" name="idTipoUsuario" placeholder="Tipo"><br><br>
			<input type="submit" name="agregar" value="Agregar" class="estilo"></input>
            <input type="submit" name="actualizar" value="Actualizar" class="estilo"/></input>
            <input type="submit" name="eliminar" value="Eiminar" class="estilo"/></input>
	</form>
</div>

<br><br>

<div>
<h2>Lista de Usuarios</h2>
<table class="tableUsuarios">
    <tr>
        <td>#</td>
        <td class="showCell"> Nombre</td>
        <td>Teléfono</td>
        <td>Dirección</td>  
        <td class="showCell">Correo</td>
        <td class="showCell">Estado</td>
        <td>ID Tipo</td>
        <td>Tipo Usuario</td>
    </tr>
    
    <?php
    $consulta = "SELECT idUsuario,nombre, telefono, direccion,correo,estado, USER.idTipoUsuario, TP_USER.tipoUsuario FROM usuarios USER INNER JOIN tipo_usuario TP_USER ON TP_USER.idTipoUsuario = USER.idTipoUsuario";
    if ($resultado = mysqli_query($conexion, $consulta)) { // sigue haciendo select hasta que se hayan traido todos los datos de la tabls
        while ($row = mysqli_fetch_assoc($resultado)) { //asocia los valores
            echo "<tr>";
            echo "<td>".$row['idUsuario']."</td>"; ///asi es como se trae la informacion y la mostramos
            echo "<td class='showCell'>".$row['nombre']."</td>";
            echo "<td>".$row['telefono']."</td>";;
            echo "<td>".$row['direccion']."</td>";
            echo "<td class='showCell'>".$row['correo']."</td>";
            echo "<td class='showCell'>".$row['estado']."</td>";
            echo "<td>".$row['idTipoUsuario']."</td>";
            echo "<td>".$row['tipoUsuario']."</td>";
            echo '<td class="showCell"><input type="button" name="actualizar" class="estilo" value="Actualizar" onclick="actualizar(\''.$row['idUsuario'].'\',\''.$row['nombre'].'\',\''.$row['telefono'].'\',\''.$row['direccion'].'\',\''.$row['correo'].'\',\''.$row['estado'].'\',\''.$row['idTipoUsuario'].'\');"></td>'; // cargar datos en el formulario
            echo '<td class="showCell"><input type="button" name="eliminar" class="estilo" value="Eliminar" onclick="eliminar(\''.$row['idUsuario'].'\',\''.$row['nombre'].'\',\''.$row['telefono'].'\',\''.$row['direccion'].'\',\''.$row['correo'].'\',\''.$row['estado'].'\',\''.$row['idTipoUsuario'].'\');"></td>';
            echo "</tr>";
        }
            echo "<tr>";
            echo "<td colspan='9'>La selección devolvió n filas ".mysqli_num_rows($resultado)."</td>";
            echo "</tr>";
    }else{
        echo "<tr>";
        echo '<td colspan="9">Hubo un error al ejecutar el query. Contactese con el administrador </td>';
        echo "</tr>";
    }
    ?>
</table>
</div>