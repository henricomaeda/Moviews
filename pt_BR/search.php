<?php
	// Inclue apenas uma vez os arquivos abaixo.
	require_once("templates/header.php");
	require_once("dao/MovieDAO.php");
	
	// Chama o construtor.
	$movieDao = new MovieDAO($conn, $BASE_URL);
	
	// Define a variável para a busca do usuário.
	$q = filter_input(INPUT_GET, "q");
	$movies = $movieDao -> findByTitle($q);
?>

<div id="main-container" class="container-fluid">
	<h2 class="section-title" id="search-title">
		Você está buscando por: <span id="search-result"><?= $q ?></span>
	</h2>
	<p class="section-description">
		Resultados de busca com base em sua pesquisa.
	</p>
	<div class="movies-container">
		<!-- Exibe os filmes buscados -->
		<?php foreach($movies as $movie): ?>
			<?php require("templates/movie_card.php"); ?>
		<?php endforeach; ?>
		<!-- Comenta que não há filmes para essa busca -->
		<?php if (count($movies) === 0): ?>
			<p class="empty-list" id="empty-search">
				Não há filmes para o que está buscando, <a href="<?= $BASE_URL ?>" class="back-link"> aperte aqui para retornar</a> ...
			</p>
		<?php endif; ?>
	</div>
</div>

<!-- Inclue o footer da página -->
<?php require_once("templates/footer.php"); ?>