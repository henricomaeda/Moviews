<?php
	// A conexão desfragmentada em variáveis.
	$db_name = "moviews";
	$db_host = "localhost";
	$db_user = "administrador";
	$db_pass = "000000";
	
	// A conexão fragmentada em uma váriavel.
	$conn = new PDO("mysql:dbname=" . $db_name . ";host=" . $db_host, $db_user, $db_pass);
	
	// PDO (PHP Data Objects).
	// Desenvolverá um relatório de erros, caso encontre um erro gerado pelo PDO.
	$conn -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	
	// O PDO tentará utilizar, da Database, instruções preparadas nativas. 
	$conn -> setAttribute(PDO::ATTR_EMULATE_PREPARES, false);