<?php
include "conexion.php";

if(isset($_POST['agregar'])) {
// strlen para verificar que si se esten ingresando datos
    if( strlen($_POST['nombre']) >= 1 && strlen($_POST['telefono']) >= 1 && strlen($_POST['direccion']) >= 1 && strlen($_POST['correo']) >= 1
        && strlen($_POST['idTipoUsuario']) >= 1){

    $nombre = $_POST['nombre'];
    $tel = $_POST['telefono'];
    $direccion = $_POST['direccion'];
    $correo = $_POST['correo'];
    $contra = $_POST['contrasena'];
    $idTipo = $_POST['idTipoUsuario'];
   
    $insertar = "INSERT INTO usuarios(nombre, telefono, direccion, correo, idTipoUsuario) VALUES ('$nombre','$tel','$direccion','$correo','$idTipo')";
    $ejecutar = mysqli_query($conexion,$insertar);
    if($ejecutar){
        echo "<h1>Guardado Correctamente</h1>";
        header("Location: controlUsuarios.php"); 
    }else{
         echo '<p>No guardado correctamente. Error: '.mysqli_error($conexion);
    }
    }
}

if(isset($_POST['actualizar'])){

    $id = $_POST['id'];

    if(strlen($_POST['nombre']) >= 1 && strlen($_POST['telefono']) >= 1 && strlen($_POST['direccion']) >= 1 && strlen($_POST['correo']) >= 1 
    && strlen($_POST['idTipoUsuario']) >= 1){
    
    $nombre = $_POST['nombre'];
    $tel = $_POST['telefono'];
    $direccion = $_POST['direccion'];
    $correo = $_POST['correo'];
    $estado = $_POST['estado'];
    $idTipo = $_POST['idTipoUsuario'];

    //Al actualizar el estado a "activo" se necesitan poner los intentos en 1, para que otra vez el usuario tenga la posibilidad de equivocarse 4 veces al ingresar en el login.
    if($estado == 'A'){
        $intentos = 1; //aqui se hace la actualizacion de inactivo a activo
    }else{
        $intentos = 5;
    }
   
    $insertar = "UPDATE usuarios SET nombre='$nombre', telefono='$tel', direccion='$direccion', correo='$correo',estado ='$estado',intentos = '$intentos',idTipoUsuario='$idTipo' WHERE idUsuario ='$id'";
    $ejecutar = mysqli_query($conexion,$insertar);
    if($ejecutar){
        echo "<h1>Guardado Correctamente</h1>";
        header("Location: controlUsuarios.php"); 
    }else{
         echo '<p>No guardado correctamente. Error: '.mysqli_error($conexion);
    }
    }
}

if(isset($_POST['eliminar'])) {

    $id = $_POST['id'];
    $insertar = "DELETE FROM usuarios WHERE idUsuario ='$id'";
    $ejecutar = mysqli_query($conexion,$insertar);
    if($ejecutar){
        echo "<h1>Guardado Correctamente</h1>";
        header("Location: controlUsuarios.php");
    }else{
        echo '<p>Producto no Guardado. Error: '.mysqli_error($conexion);
    }
}
?>