<?php
	// Inicia uma nova sessão ou resume uma sessão existente.
	session_start();
	
	// A base da URL para incluir e acessar outras páginas.
	$BASE_URL = "http://" . $_SERVER["SERVER_NAME"] . dirname($_SERVER["REQUEST_URI"]."?") . "/";