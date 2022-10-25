<?php
                $conexion = mysqli_connect('localhost','root','12345','cafeteria');
                if (mysqli_connect_errno()) {
                printf("Falló la conexión: %s\n", mysqli_connect_error());
                exit();
                }
                function showerror( )   {
                die("Se ha producido el siguiente error: " . mysqli_error($conexion));
            }
            //$conexion = mysqli_connect('107.180.41.237','usuariolatina09','$0836','grupo09');
?>