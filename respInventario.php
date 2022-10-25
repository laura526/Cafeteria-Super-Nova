<?php
//Aqui se guarda la imagen de inventario
require 'conexion.php';

if(isset($_POST['agregar'])){

    $producto = $_POST['producto'];
    $codigo = $_POST['codigo'];
    $cantidad = $_POST['cantidad'];
    $precio = $_POST['precio'];
    $descripcion = $_POST['descripcion'];
    $idTipo = $_POST['idTipoProducto'];

    if (isset($_FILES['imagen'])) { //variable tipo file en formulario
        $img = $_FILES['imagen']; // esto es un arreglo
        //Vamos a acceder a campos del arreglo
        $fileTempName = $img['tmp_name'];
        $fileName = $img['name'];
        $fileNewName = "./imgsProductos/".$fileName; //ahora lo vamos a guardar donde yo quiero, ruta de la carpeta
        move_uploaded_file($fileTempName,$fileNewName); //aqui es solo para la carpeta y poder accederla

        $insertar = "INSERT INTO productos(producto, codigo, imagen,cantidad, precio, descripcion,idTipoProducto) VALUES ('$producto','$codigo','$fileNewName','$cantidad','$precio','$descripcion','$idTipo')";
        $ejecutar = mysqli_query($conexion,$insertar); //guardar la direccion en BD
            if($ejecutar){
                header("Location: inventario.php");
            }else{
                    echo '<p>Error al ingresar el producto. Error: '.mysqli_error($conexion);
            }
    }
}

if(isset($_POST['actualizar'])){
    //cada que se actualiza se debe escoger de vuebo la imagen

    $id = $_POST['id'];
    $producto = $_POST['producto'];
    $codigo = $_POST['codigo'];
    $cantidad = $_POST['cantidad'];
    $precio = $_POST['precio'];
    $descripcion = $_POST['descripcion'];
    $idTipo = $_POST['idTipoProducto'];
    
    if (isset($_FILES['imagen'])) {

        $img = $_FILES['imagen'];
        $fileTempName = $img['tmp_name'];
        $fileName = $img['name'];
        $fileNewName = "./imgsProductos/".$fileName;
        move_uploaded_file($fileTempName,$fileNewName);

        $insertar = "UPDATE productos SET producto='$producto', codigo ='$codigo', imagen ='$fileNewName',cantidad ='$cantidad', precio ='$precio', descripcion ='$descripcion', idTipoProducto ='$idTipo'  WHERE idProducto ='$id'";
        $ejecutar = mysqli_query($conexion,$insertar);
        if($ejecutar){
                header("Location: inventario.php");
        }else{
                echo '<p>Error al ingresar el producto. Error: '.mysqli_error($conexion);
        }
    }
}

if(isset($_POST['eliminar'])) {

        $id = $_POST['id'];
        $insertar = "DELETE FROM productos WHERE idProducto ='$id'";
        $ejecutar = mysqli_query($conexion,$insertar);
        if($ejecutar){
            echo "<h1>Guardado Correctamente</h1>";
            header("Location: inventario.php");
        }else{
            echo '<p>Producto no Guardado. Error: '.mysqli_error($conexion);
        }
}
?>