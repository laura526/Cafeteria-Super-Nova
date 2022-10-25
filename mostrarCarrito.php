<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Carrito Compras</title>
</head>
<body>
    <header>
        <h1>Bienvenido al Carrito de Compras</h1>
        <nav>
            <a href="menu.php">Regresar</a>
        <nav>
    </header>

    <table>
    <tr>
        <td>Producto</td>
        <td>Código</td>
        <td>Imagen</td>
        <td>Cantidad</td>
        <td>Precio Unitario</td>
    </tr>
    <?php
    session_start();
        if(isset($_SESSION['carrito'])){
           foreach ($_SESSION['carrito'] as $x){
               echo '<tr>'.'<td>'.$x['Producto'].'</td>'.'<td>'.$x['Producto'].'</td>'.'<td>'.$x['Codigo'].'</td>'.'<td><img src ="'.$x['Imagen'].'" style="max-width: 100px;"></td>'.'<td>'.$x['Cantidad'].'</td>'.'<td>'.$x['Precio Unitario'].'</td>'.'</tr>';
           }
        }
    ?>
    </table>

</body>
</html>