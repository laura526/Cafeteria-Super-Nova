<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="css/estilos_Login_SignUp.css">
	<link rel="stylesheet" type="text/css" href="./css/mobile.css">
    <title>Bienvenido</title>


	<!--Código JS-->
	<script>
	function mostrarSignUp(){
		document.getElementById('container_signUp').style.display = 'block';/*Para que se vea el Sign Up*/
		document.getElementById('container_login').style.display = 'none';
		document.getElementById('container_olvidoContra').style.display = 'none';
		/*document.getElementById('"caja__trasera-login').style.display = 'none';*/

	}
	function mostrarLogin(){
		document.getElementById('container_signUp').style.display = 'none';
		document.getElementById('container_login').style.display = 'block';/*Para que se vea el login*/
		document.getElementById('container_olvidoContra').style.display = 'none';
	}
	function mostrarContra(){
		document.getElementById('container_olvidoContra').style.display = 'block';
		document.getElementById('container_login').style.display = 'none';
		document.getElementById('container_signUp').style.display = 'none';
	}
	</script>
</head>
<body>

<!--MOVIMIENTO DEL FORMULARIO-->
<div class="caja__trasera">
        <div class="caja__trasera-login">
            <h3>¿Ya tienes una cuenta?</h3>
            <p>Inicia sesión para entrar en la página</p>
            <button id="btn__iniciar-sesion"  onclick="mostrarLogin();">Iniciar Sesión</button>
        </div>
        <div class="caja__trasera-register">
             <h3>¿Aún no tienes una cuenta?</h3>
             <p>Regístrate para que puedas iniciar sesión</p>
             <button id="btn__registrarse" onclick="mostrarSignUp();">Regístrarse</button>
        </div>
</div>

<!--Contenedor de Login, Sign Up y Olvido Contra-->
<div id="container">

<!--LOGIN-->
<div id="container_login">
	<h1>Login In</h1><br>
	<div class="social-container">
			<a href=" "><i class="fa fa-facebook" aria-hidden="true"></i></a>
			<a href=" "><i class="fa fa-google" aria-hidden="true"></i></a>
	</div><br>
		<p>Ingrese sus Datos</p>
	<form action="respLogin.php" method="POST">
	<!--USO DE LAS COOKIES PARA GUARDAR EL CORREO DEL USUARIO POR 1 HORA-->
	<?php
		if(isset($_COOKIE["userEmail"])){
			echo '<input type="email" name="email" placeholder="Email" value="'.$_COOKIE["userEmail"].'" >';
		}else{
			echo '<input type="email" name="email" placeholder="Email"  >';
		}
	?>
		
		<input type="password" name="contra" placeholder="Contraseña"><br><br>
		<input type="submit" name="signIn" value="Sign In" class="estilo"></input>
	</form><br>
	<button id="btn__olvidoContra" onclick="mostrarContra();" class="estilo">Olvido su Contraseña</button>
</div>

<!--SIGN UP-->
<div id="container_signUp">
		<h1>Sign Up</h1>
		<p>Ingrese sus Datos</p>
    <form action="respSignUp.php" method="POST">
			<input type="text" name="nombre" placeholder="Nombre">
			<input type="text" name="telefono" placeholder="Teléfono">
			<input type="text" name="direccion" placeholder="Dirección">
			<input type="email" name="email" placeholder="Email">
			<input type="password" name="contrasena" placeholder="Contraseña">
			<input type="pregunta" name="pregunta" placeholder="Lugar Favorito para Pasear"><br><br>
			<input type="submit" name="signUp" value="Sign Up" class="estilo"></input>
	</form>
</div>

<!--OLVIDO CONTRA-->
<div id="container_olvidoContra" style="display:none">
	<br><br><h1>Olvidó su Contraseña</h1><br><br>
	<p>Ingrese su Datos</p><br>
    <form action="respOlvidoContra.php" method="POST">
			<input type="text" name="correo" placeholder="Correo"><br><br>
			<input type="text" name="pregunta" placeholder="Lugar favorito para Pasear"><br><br>
			<input type="submit" name="olvidoClave" value="Enviar" class="estilo"></input>
	</form>
</div>

</div>

</body>
</html>