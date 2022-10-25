<?php
    session_start();
    if(!isset($_SESSION['Seguridad']) and $_SESSION['Seguridad'] !== "1234"){
        header("Location: bienvenido.php");
        exit;
    }
    require 'conexion.php';

    $p_codigo = $_POST['p_codigo']; // valores de la llamada
    $p_cantidad = $_POST['p_cantidad'];

    //Con el select count >Verificando que cantidad sea mayor a 0 y menor a lo disponible en stock -- 1 si hay , 0 no hay
    $consulta ="SELECT COUNT(*) AS campos,producto,codigo,imagen,precio,idProducto  FROM productos WHERE codigo='$p_codigo' AND cantidad >= '$p_cantidad'";
    $resultado = mysqli_query($conexion, $consulta);

    $resultado = mysqli_fetch_array($resultado); //se guardan los valores consultados en la base de datos
    // aca se guardan
    $campos = $resultado[0];
    //Datos para hacer lista
    $producto = $resultado[1];
    $codigo = $resultado[2];
    $imagen = $resultado[3];
    $precio = $resultado[4];
    $idProducto = $resultado[5];
    $disponible = "";

    if($campos == 1){ //si si existe el producto que lo guarde en nuestro array
        if(!isset($_SESSION['carrito'])){
            $_SESSION['items'] = 1;
            $_SESSION['carrito'] = array(); //aqui se crea el array

            $_SESSION['carrito'][$_SESSION['items']] = array("Producto" => $producto,"Codigo" => $codigo, "Imagen" => $imagen, "Cantidad" => $p_cantidad, "Precio Unitario" => $precio, "idProducto" => $idProducto); // aqui se setean los datos
        }else{
            $_SESSION['items'] = $_SESSION['items']+1;
            $_SESSION['carrito'][$_SESSION['items']] = array("Producto" => $producto,"Codigo" => $codigo, "Imagen" => $imagen, "Cantidad" => $p_cantidad, "Precio Unitario" => $precio, "idProducto" => $idProducto);
        }
        if(isset($_SESSION['carrito'])){ //aca se guardan los datos
            foreach ($_SESSION['carrito'] as $x){
                $disponible = $disponible.'<tr>'.'<td>'.$x['Producto'].'</td>'.'<td>'.$x['Producto'].'</td>'.'<td>'.$x['Codigo'].'</td>'.'<td><img src ="'.$x['Imagen'].'" style="max-width: 100px;"></td>'.'<td>'.$x['Cantidad'].'</td>'.'<td>'.$x['Precio Unitario'].'</td>'.'</tr>';
            }
         }
    }else{
        $disponible = "Cantidad no disponible";
    }

    echo $disponible;
?>