<?php
	// Inclue apenas uma vez os arquivos abaixos.
	require_once("../globals.php");
	require_once("../database.php");
	require_once("models/Message.php");
	require_once("dao/UserDAO.php");
	
	// Chama o construtor.
	$userDao = new UserDAO($conn, $BASE_URL);
	$message = new Message($BASE_URL);
	
	// Verifica se o usuário está validado e retorna seus dados.
	$userData = $userDao -> verifyToken(false);

	// Recebe a mensagem que aparecerá embaixo do header.
	$flassMessage = $message -> getMessage();

	// Verifica se a mensagem recebida está vazia, se não, limpa a mensagem.
	if(!empty($flassMessage["msg"])) $message -> clearMessage();
?>

<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<title> Moviews </title>
		
		<!-- Exibe o ícone do site na aba -->
		<link rel="short icon" href="<?= $BASE_URL ?>../assets/logo.png" />
		
		<!-- Chama o bootstrap -->
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.3/css/bootstrap.css" integrity="sha512-drnvWxqfgcU6sLzAJttJv7LKdjWn0nxWCSbEAtxJ/YYaZMyoNLovG7lPqZRdhgL1gAUfa+V7tbin8y+2llC1cw==" crossorigin="anonymous" />
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css" integrity="sha512-+4zCK9k+qNFUR5X+cKL9EIR+ZOhtIloNl9GIKS57V1MyNsYpYcUrUeQc9vNfzsWfV28IaLL3i96P9sdNyeRssA==" crossorigin="anonymous" />
		
		<!-- Chama o arquivo de estilização -->
		<link rel="stylesheet" href="<?= $BASE_URL ?>../styles.css">
	</head>
	<body>
		<header>
			<nav id="main-navbar" class="navbar navbar-expand-lg">
				<a href="<?= $BASE_URL ?>" class="navbar-brand">
					<!-- Exibe a logo do site no header -->
					<img src="<?= $BASE_URL ?>../assets/logo.png" alt="Moviews" id="logo">
					<!-- Exibe o título do site na logo do header -->
					<span class="moviews-title" id="moviews-title">
						Moviews
					</span>
				</a>
				<!-- Exibe a barras ações no header, responsivo -->
				<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbar" aria-controls="navbar" aria-expanded="false" aria-label="Toggle navigation">
					<i class="fas fa-bars"></i>
				</button>
				<form action="<?= $BASE_URL ?>search.php" method="GET" id="search-form" class="form-inline my-0 my-lg-0">
					<!-- Exibe a barra de procura de filmes no header -->
					<input type="text" name="q" id="search" class="form-control" type="search" placeholder="Buscar por filmes" aria-label="Search">
					
					<!-- Exibe o ícone de procura na barra de procura -->
					<button class="btn my-2 my-sm-0" type="submit">
						<i class="fas fa-search"></i>
					</button>
				</form>
				<div class="collapse navbar-collapse" id="navbar">
					<ul class="navbar-nav">
						<!-- Verifica se o usuário está validado -->
						<?php if($userData): ?>
							<li class="nav-item">
								<a href="<?= $BASE_URL ?>newmovie.php" class="nav-link">
									<i class="far fa-plus-square"></i> Incluir filme
								</a>
							</li>
							<li class="nav-item">
								<a href="<?= $BASE_URL ?>dashboard.php" class="nav-link">
									Meus filmes
								</a>
							</li>
							<li class="nav-item">
								<a href="<?= $BASE_URL ?>editprofile.php" class="nav-link bold">
									<?= $userData -> name ?>
								</a>
							</li>
							<li class="nav-item">
								<a href="<?= $BASE_URL ?>logout.php" class="nav-link">
									Desconectar
								</a>
							</li>
						<!-- Se o usuário não estiver validado -->
						<?php else: ?>
							<li class="nav-item">
								<a href="<?= $BASE_URL ?>auth.php" class="nav-link">
									Conectar | Cadastrar
								</a>
							</li>
						<?php endif; ?>
					</ul>
				</div>
			</nav>
		</header>
		<!-- Exibe a mensagem embaixo do header -->
		<?php if(!empty($flassMessage["msg"])): ?>
			<div class="msg-container">
				<p class="msg <?= $flassMessage["type"] ?>">
					<?= $flassMessage["msg"] ?>
				</p>
			</div>
		<?php endif; ?>
		<!-- Parte dos botões de idioma -->
		<?php
			// Adiciona o protocolo de transferência de hipertexto seguro ao URL.
			if(isset($_SERVER['HTTPS']) && $_SERVER['HTTPS']) $url_temp = "https://";
			else $url_temp = "http://";
			
			// Adiciona o host (nome de domínio, IP) ao URL.
			$url_temp.= $_SERVER['HTTP_HOST'];
			
			// Adiciona o local do recurso solicitado ao URL.
			$url_temp.= $_SERVER['REQUEST_URI'];
			
			// Altera o idioma do local de recurso solitado ao URL.
			$changeLanguage_URL = str_replace("pt_BR", "en_US", $url_temp);
		?>
		<div class="container-language">
			<img src="<?= $BASE_URL ?>../assets/flags/br_flag.png"></img>
			<a href="<?= $changeLanguage_URL ?>">
				<img class="unselected" src="<?= $BASE_URL ?>../assets/flags/us_flag.png"></img>
			</a>
		</div>