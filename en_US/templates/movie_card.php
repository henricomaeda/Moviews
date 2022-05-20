<?php
	// Define imagem padrão, caso o usuário não tenha o mesmo.
	if (empty($movie -> image)) $movie -> image = "movie_cover.jpg";
?>

<div class="card movie-card">
	<!-- Exibe a imagem do filme no card -->
	<div class="card-img-top" style="background-image: url('<?= $BASE_URL ?>../assets/movies/<?= $movie -> image ?>')"></div>
	<div class="card-body">
		<p class="card-rating">
			<i class="fas fa-star"></i>
			<!-- Exibe o rating do filme no card -->
			<span class="rating"><?= $movie -> rating ?></span>
		</p>
		<h5 class="card-title">
			<!-- Exibe o título do filme no card -->
			<a href="<?= $BASE_URL ?>movie.php?id=<?= $movie -> id ?>"><?= $movie -> title ?></a>
		</h5>
		<!-- Exibe os botões de avaliar e conhecer no card -->
		<a href="<?= $BASE_URL ?>movie.php?id=<?= $movie -> id ?>" class="btn btn-primary rate-btn"> Evaluate </a>
		<a href="<?= $BASE_URL ?>movie.php?id=<?= $movie -> id ?>" class="btn btn-primary card-btn"> Details </a>
	</div>
</div>