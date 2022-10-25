<?php
    session_start();
    include "conexion.php";

    if(isset($_POST['olvidoClave'])){
        $correo = $_POST['correo'];
        $pregunta = $_POST['pregunta'];

        $consulta = "SELECT correo,pregunta,idUsuario,estado FROM usuarios WHERE correo='$correo' AND pregunta='$pregunta'";
        $resultado = mysqli_query($conexion, $consulta);
        $correcto = mysqli_num_rows($resultado);

        if($correcto>0){
            $usuario = mysqli_fetch_array($resultado);
            $_SESSION["id"] = $usuario['idUsuario']; // Se necesita para cambiar la contra en olvidoContra.php
            $_SESSION["estado"] = $usuario['estado'];

            $_SESSION['olvido']="12"; // Se necesita para poder ingresar a la página Olvidó Contra
            header('Location: olvidoContra.php');
        }else{
            header('Location: bienvenido.php');
        }
    }
    if(isset($_POST['enviar'])){
        if(strlen($_POST['contra']) > 1){
            $nuevaContra = $_POST['contra'];

            $idUsuario = $_SESSION["id"];
            $estado = $_SESSION["estado"];

            if($estado == 'I'){
                $estado='A'; /*Si paso a ser bloqueado (inactivo) al ingresar una nueva contra tiene que pasar a ser activo y los intentos deben ser = 1
                                Sino no había sido bloqueado simplemente se setea otra ves lo mismo que viene de la BD que es A (activo)*/
            }

            $insertar = "UPDATE usuarios SET contrasena='$nuevaContra',estado ='$estado',intentos = 1 WHERE idUsuario ='$idUsuario'";
            $ejecutar = mysqli_query($conexion,$insertar);
            if($ejecutar){
                header("Location: bienvenido.php"); 
            }else{
                 echo '<p>Error al actualizar contraseña. Error: '.mysqli_error($conexion);
            }
        }
    }
?>