<?php
    include 'conexion.php';
    // Este archivo puede ser tan grande y tan complejo como ustedes quieran
   
    $mesa    = $_POST['mesa'];
    $_SESSION["mesa"] =  $mesa;
    $consulta = "SELECT disponible FROM mesa WHERE idMesa='$mesa'";
    $resultado = mysqli_query($conexion, $consulta);
    $resultado = mysqli_fetch_assoc($resultado);
    $resultado = $resultado['disponible'];
    echo $resultado;
    /*if ($resultado == 'Y') {
    echo $mesa;
        
    $update = "UPDATE mesa SET disponible='N' WHERE idMesa ='$mesa'";
    $ejecutar = mysqli_query($conexion,$update);
    if(!$ejecutar){
     echo "Error".mysqli_error($conexion);
    }else{
    echo "Actualizado con éxito";
    }
    }else{

    }*/
    
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
<?php
echo $_SESSION['mesa'];
?>
</body>
</html>