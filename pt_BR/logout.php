<?php
	// Inclue apenas uma vez os arquivos abaixo.
	require_once("templates/header.php");
	
	// Remove a token do usuário, desvalidando o mesmo.
	if ($userDao) $userDao -> destroyToken();