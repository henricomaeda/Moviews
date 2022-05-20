<?php
	// Inclue apenas uma vez os arquivos abaixo.
	require_once("templates/header.php");
	require_once("dao/MovieDAO.php");
	
	// Chama o construtor.
	$movieDao = new MovieDAO($conn, $BASE_URL);

	// Define nas variáveis, os filmes de cada categoria.
	$latestMovies_01 = $movieDao -> getLatestMovies(1);
	$latestMovies_02 = $movieDao -> getLatestMovies(2);

	// Define nas variáveis, os filmes de cada categoria.
	// Categoria (1) para ação. Categoria (2) para drama.
	// Categoria (3) para comédia. Categoria (5) para romance.
	// Categoria (4) para fantasia e ficção científica.
	$actionMovies = $movieDao -> getMoviesByCategory(1);
	$dramaMovies = $movieDao -> getMoviesByCategory(2);
	$comedyMovies = $movieDao -> getMoviesByCategory(3);
	$fictionMovies = $movieDao -> getMoviesByCategory(4);
	$romanceMovies = $movieDao -> getMoviesByCategory(5);
?>

<div id="main-container" class="container-fluid">
	<!-- Parte dos Carroussel -->
	<h2 class="section-title"> New movies </h2>
	<p class="section-description">
		See the reviews of the latest movies added.
	</p>
	<div class="container-carousel">
		<div id="carousel" class="carousel slide" data-ride="carousel" data-interval="3600">
			<div class="carousel-inner">
				<div class="item active">
					<div class="row">
						<!-- Exibe 0 de 5 novos filmes -->
						<?php foreach($latestMovies_01 as $movie): ?>
							<?php require("templates/movie_card.php"); ?>
						<?php endforeach; ?>
						<!-- Exibe cartões vazios, caso não haja novos filmes -->
						<?php for ($t = count($latestMovies_01); $t <= 4; $t++): ?>
							<div class="card movie-card" id="empty"></div>
						<?php endfor ?>
					</div>
				</div>
				<div class="item">
					<div class="row">
						<!-- Exibe 5 de 10 novos filmes -->
						<?php foreach($latestMovies_02 as $movie): ?>
							<?php require("templates/movie_card.php"); ?>
						<?php endforeach; ?>
						<!-- Exibe cartões vazios, caso não haja novos filmes -->
						<?php for ($t = count($latestMovies_02); $t < 5; $t++): ?>
							<div class="card movie-card" id="empty"></div>
						<?php endfor ?>
					</div>
				</div>
			</div>
		</div>
		<div id="float-left">
			<a class="fa fa-chevron-left btn fa-design" href="#carousel" data-slide="prev"></a>
		</div>
		<div id="float-right">
			<a class="fa fa-chevron-right btn fa-design" href="#carousel" data-slide="next"></a>
		</div>
	</div><br><br><br>
	<!-- Exibe os filmes de Ação, caso haja -->
	<?php if (count($actionMovies) != 0): ?>
	<h2 class="section-title"> Action </h2>
		<p class="section-description"> See the best action movies. </p>
		<div class="movies-container">
			<?php foreach($actionMovies as $movie): ?>
				<?php require("templates/movie_card.php"); ?>
			<?php endforeach; ?>
		</div>
	<?php endif; ?>
	<!-- Exibe os filmes de Drama, caso haja -->
	<?php if (count($dramaMovies) != 0): ?>
	<h2 class="section-title"> Drama </h2>
		<p class="section-description"> See the best drama movies. </p>
		<div class="movies-container">
			<?php foreach($dramaMovies as $movie): ?>
				<?php require("templates/movie_card.php"); ?>
			<?php endforeach; ?>
		</div>
	<?php endif; ?>
	<!-- Exibe os filmes de Comédia, caso haja -->
	<?php if (count($comedyMovies) != 0): ?>
	<h2 class="section-title"> Comedy </h2>
		<p class="section-description"> See the best comedy movies. </p>
		<div class="movies-container">
			<?php foreach($comedyMovies as $movie): ?>
				<?php require("templates/movie_card.php"); ?>
			<?php endforeach; ?>
		</div>
	<?php endif; ?>
	<!-- Exibe os filmes de Fantasia, caso haja -->
	<?php if (count($fictionMovies) != 0): ?>
	<h2 class="section-title"> Science fiction </h2>
		<p class="section-description"> See the best fantasy and science fiction movies. </p>
		<div class="movies-container">
			<?php foreach($fictionMovies as $movie): ?>
				<?php require("templates/movie_card.php"); ?>
			<?php endforeach; ?>
		</div>
	<?php endif; ?>
	<!-- Exibe os filmes de Romance, caso haja -->
	<?php if (count($romanceMovies) != 0): ?>
	<h2 class="section-title"> Romance </h2>
		<p class="section-description"> See the best romance movies. </p>
		<div class="movies-container">
			<?php foreach($romanceMovies as $movie): ?>
				<?php require("templates/movie_card.php"); ?>
			<?php endforeach; ?>
		</div>
	<?php endif; ?>
</div>

<?php
	// Inclue apenas uma vez o footer.
	require_once("templates/footer.php");
?>