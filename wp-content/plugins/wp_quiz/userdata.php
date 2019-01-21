<?php 
	$name = $_POST['name'];
	$apellido = $_POST['apellido'];
	$email = ($_POST['email']) ? $_POST['email'] : 'test@gmail.com';
	$phone = $_POST['phone'];
	$empresa = $_POST['message'];
    $results = $_POST['json_results'];

		$conexion = mysql_connect("localhost", "demotest_wp959","9[P4SNOP8@");
		mysql_select_db('demotest_wp959') or die('No se pudo seleccionar la base de datos');

		$sql="insert into usuarios (name, apellido, email, telefono,empresa) values ('$name', '$apellido', '$email', '$telefono', '$empresa')";
		$result = mysql_query($sql) or die('Consulta fallida: ' . mysql_error());
		mysql_close($conexion);

?>