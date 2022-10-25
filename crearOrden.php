<?php
    session_start();
    require 'conexion.php';

        $email = $_SESSION['email']; /*La variable de sesión Email se obtiene de respLogin.php es necesaria para enseñar el empleado que está haciendo la orden en el
                                        detalle de la orden (mostrarOrden.php)*/
        $idUsuario = null;//Definiendo variable para ser usada luego
        
        //Si la mesa se seleccionó, sino lo envia a la página principal
        if(isset($_GET['mesa'])){
            $mesa = $_GET['mesa']; //Guradando el idMesa que se trae de escogerMesa.php para luego crear la orden

            //Haciendo actualización de la mesa a RESERVADA para que ya no se muestre en escogerMesa.php
            $actualizar = "UPDATE mesa SET estado = 'R' WHERE idmesa = $mesa";
           if($ejecutar = mysqli_query($conexion,$actualizar)){
               echo '<p>Mesa actualizada</p>';
           }else{
            echo '<p>Errror: '.mysqli_error($conexion).'</p>';
            exit();
           }
           
           //Trayendo el idUsuario para crear la orden luego
           $consulta = "SELECT idUsuario FROM usuarios WHERE correo = '$email'";
           // para crear una orden se necesita un usuario y una mesa
           if($ejecutar = mysqli_query($conexion,$consulta)){
               $fila = mysqli_fetch_array($ejecutar);
               $idUsuario = $fila["idUsuario"];
               echo '<p>Usuario: '.$fila["idUsuario"].' </p>';
           }else{
            echo '<p>No guardado. Error: '.mysqli_error($conexion);
           }

           // Creando la orden, pasandole el idMesa y el idUsuario
           $insertar = "INSERT INTO orden (idmesa,idUsuario) VALUES ($mesa,$idUsuario)";
           $ejecutar = mysqli_query($conexion,$insertar);

           //Sí sí se hace la inserción correctamente
           if($ejecutar){
            //Trae el idOrden donde la mesa sea la que se había seleccionado y en la que el estado de la orden sea activo (osea que esté siendo procesada)
            $consulta = "SELECT * FROM orden WHERE idMesa = $mesa AND estado = 'A'";
            
            //Si si está bien, le pasa a menu.php (página donde se agregan los productos) el idOrden para mostrar la info de esta orden
                if($result = mysqli_query($conexion,$consulta)){
                    $row_cnt = mysqli_fetch_array($result); //Convierte las filas y columnas de la consulta en un array
                    header('Location: menu.php?orden='.$row_cnt['idorden']);
                }else{
                    echo '<p>No guardado. Error: '.mysqli_error($conexion);
                    exit();
                }
           }else{
                echo '<p>No guardado. Error: '.mysqli_error($conexion);
                exit();
           }           
        }else{
        //Enviandolo a la página principal
        header('Location: bienvenido.php');
        }
?>