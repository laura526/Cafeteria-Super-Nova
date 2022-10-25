<?php
    include "conexion.php";
    
    if(isset($_POST['signUp'])) {
        
       if(strlen($_POST['nombre']) >= 1 && strlen($_POST['telefono']) >= 1 && strlen($_POST['direccion']) >= 1 && strlen($_POST['email']) >= 1 && strlen($_POST['contrasena']) >= 1 && strlen($_POST['pregunta']) >= 1){
       $nombre = $_POST['nombre'];
       $tel = $_POST['telefono'];
       $direccion = $_POST['direccion'];
       $correo = $_POST['email'];
       $contra = $_POST['contrasena'];
       $pregunta = $_POST['pregunta'];
   
           $insertar = "INSERT INTO usuarios(nombre, telefono, direccion, correo, contrasena,pregunta) VALUES ('$nombre','$tel','$direccion','$correo','$contra', '$pregunta')";
           $ejecutar = mysqli_query($conexion,$insertar);
           if($ejecutar){
               echo "<h1>Guardado Correctamente</h1>";
               header("Location: bienvenido.php");
              
           }else{
               

               echo '<p>No guardado. Error: '.mysqli_error($conexion);
           }
        $_SESSION['error']=true;
        }else{
        $_SESSION['error']=false;
        header('Location: bienvenido.php');
        }
   }
?>