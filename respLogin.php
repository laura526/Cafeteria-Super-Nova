<?php
session_start();
include 'conexion.php';

if(isset($_POST['signIn'])){

    $email = mysqli_real_escape_string($conexion,$_POST['email']);
    $contra =  mysqli_real_escape_string($conexion,$_POST['contra']);

    //INDICANDOLE QUE LA COOKIE VA A EXISTIR POR UNA HORA-ESTO VIENE DE BIENVENIDO.PHP
    $_SESSION['email'] = $email;//Variable de session email necesaria en el informe de productos
    setcookie("userEmail", $email, time()+3600); 

    // Validando que exista el correo
    $consulta = "SELECT correo,estado,intentos FROM usuarios WHERE correo = '$email'";
    $resultado = mysqli_query($conexion, $consulta); //Ejecuntando query
    $usuario = mysqli_num_rows($resultado); //Cantidad de lineas de las consulta si es 1 continua si es 0 no
    

    if($usuario>0){

        // Validando que el usuario esté activo
        $usuario = mysqli_fetch_array($resultado); // para guardar lo que me tarigo de la BD
        $estado = $usuario['estado'];
        $intentos = $usuario['intentos'];

        if($estado == 'A'){

            // Verificando contraseña
            $consulta = "SELECT contrasena,idTipoUsuario FROM usuarios WHERE contrasena ='$contra' and correo='$email'";
            $resultado = mysqli_query($conexion, $consulta);
            $usuario = mysqli_num_rows($resultado);

            if($usuario>0){
            
            //Session seguridad: para validar en todos los archivos que el usuario pasó el login
            $_SESSION['Seguridad']='1234';

            //Session idTipoUsuario: dependiendo usuario se ven unas opciones y otras no
            $usuario = mysqli_fetch_array($resultado);
            $_SESSION['idTipoUsuario'] = $usuario['idTipoUsuario']; //Se utiliza en el index

            //Seteando de nuevo los intentos del usuario a 1 para que no afecte mas adelante
            $consulta = "UPDATE usuarios set intentos=1 WHERE correo ='$email' and contrasena ='$contra'";
            $resultado = mysqli_query($conexion, $consulta);
                
            header('Location: index.php');

            }else{

                $intentos++;

                if($intentos >= 5){
                $consulta = "UPDATE usuarios set estado = 'I' WHERE correo ='$email'";
                $resultado = mysqli_query($conexion, $consulta);

                    header('Location: bienvenido.php');

                }else{

                $consulta = "UPDATE usuarios set intentos = '$intentos' WHERE correo ='$email'";
                $resultado = mysqli_query($conexion, $consulta);

                header('Location: bienvenido.php');
                }
            }
        }else{
            header('Location: bienvenido.php');
        }
    }else{
        header('Location: bienvenido.php');
    }
}
?>