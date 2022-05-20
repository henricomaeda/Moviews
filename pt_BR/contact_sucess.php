<?php
	// Inclue apenas uma vez os arquivos abaixo.
	require_once("templates/header.php");
	require_once("models/Message.php");
	require_once("models/User.php");
	require_once("dao/UserDAO.php");
	
	// Redireciona o usuário para a página principal.
	$message -> setMessage("Sua mensagem foi enviada com sucesso!", "success", "index.php");
	
	// Verifica se o usuário está validado e retorna seus dados.
	$userData = $userDao -> verifyToken(true);
?>