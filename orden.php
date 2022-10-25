<?php
    session_start();
    if(!isset($_SESSION['Seguridad']) and $_SESSION['Seguridad'] !== "1234"){
        header("Location: bienvenido.php");
        exit();
    }
    $mysqli = new mysqli();
    $mysqli->real_connect('localhost','root','12345','cafeteria');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="./css/styles.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <title>Mesas</title>

</head>
<body id="background">
<header class="submenu">

<nav>
<h2>Salon Principal</h2>
        <ul>
            <li><a href="index.php"  style="color: #015351">Regresar</a></li>
        </ul>
</nav><br>
<h3>R: Reservada  |  A:Activa</h3><br>

</header>
<div class="ordenCabeza">
  <ul>
    <?php
            //Mostrando las ordenes que estén siendo procesadas (osea que están RESERVADAS)
            $result = $mysqli->query("SELECT * FROM mesa where estado = 'R'");
            foreach ($result as $row) {
            //En el href se le pasa a mostrarOrden.php el idMesa para poder hacer una consulta a la bd y traerse los datos de la orden
              echo '<li> <p>Mesa #: '. $row['numeroMesa'] .' Estado: ' .$row['estado'] .' '. '<a href="mostrarOrden.php?idmesa='. $row['idmesa'] .'">Ver Orden</a></p></li>';
          }
    ?>
    </ul>
</div>
</body>
</html>