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
		You're searching for: <span id="search-result"><?= $q ?></span>
	</h2>
	<p class="section-description">
		Search results based on your search.
	</p>
	<div class="movies-container">
		<!-- Exibe os filmes buscados -->
		<?php foreach($movies as $movie): ?>
			<?php require("templates/movie_card.php"); ?>
		<?php endforeach; ?>
		<!-- Comenta que não há filmes para essa busca -->
		<?php if (count($movies) === 0): ?>
			<p class="empty-list" id="empty-search">
				There are no movies for what you're looking for, <a href="<?= $BASE_URL ?>" class="back-link"> press here to return</a> ...
			</p>
		<?php endif; ?>
	</div>
</div>

<!-- Inclue o footer da página -->
<?php require_once("templates/footer.php"); ?>