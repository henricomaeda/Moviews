<?php
	// Adiciona o protocolo de transferência de hipertexto seguro ao URL.
	if(isset($_SERVER['HTTPS']) && $_SERVER['HTTPS']) $url = "https://";
	else $url = "http://";
	
	// Adiciona o host (nome de domínio, IP) ao URL.
	$url.= $_SERVER['HTTP_HOST'];
	
	// Adiciona o local do recurso solicitado ao URL.
	$url.= $_SERVER['REQUEST_URI'];
	
	// Redireciona o usuário ao index.php do pt_BR..
	header("Location: $url/pt_BR");
?>
