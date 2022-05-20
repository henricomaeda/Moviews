<?php
	// Inclue apenas uma vez os arquivos abaixo.
	require_once("templates/header.php");
	require_once("models/Movie.php");
	require_once("dao/MovieDAO.php");
	require_once("dao/ReviewDAO.php");
	
	// Chama o construtor.
	$movieDao = new MovieDAO($conn, $BASE_URL);
	$reviewDao = new ReviewDAO($conn, $BASE_URL);
	$id = filter_input(INPUT_GET, "id");
	$movie;
	
	// Verifica se o filme e o ID do mesmo estão vazios.
	if (empty($id)) {
		$message -> setMessage("O filme não foi encontrado!", "error", "index.php");
	} else {
		// Recebe os dados do filme.
		$movie = $movieDao -> findById($id);
		$movie_category = $movieDao -> findCategory($movie -> category);
		
		if (!$movie) $message -> setMessage("O filme não foi encontrado!", "error", "index.php");
	}
	
	// Define as variáveis com os dados do filme.
	if ($movie -> image == "") $movie -> image = "movie_cover.jpg";
	
	$userOwnsMovie = false;
	if (!empty($userData)) {
		if ($userData -> id === $movie -> users_id) $userOwnsMovie = true;
		$alreadyReviewed = $reviewDao -> hasAlreadyReviewed($id, $userData -> id);
	}
	
	$movieReviews = $reviewDao -> getMoviesReview($movie -> id);
?>

<div id="main-container" class="container-fluid">
	<div class="row">
		<div class="offset-md-1 col-md-6 movie-container">
			<h1 class="page-title">
				<!-- Exibe o nome do filme -->
				<?= $movie -> title ?>
			</h1>
			<p class="movie-details">
				<span>
					<!-- Exibe a duração do filme e verifica está em minuto (s) -->
					Duração:
					<?php
						$min = $movie -> length;
						echo $min;
						
						if ($min <= 1) echo " minuto";
						else echo " minutos";
					?>
				</span>
				<span class="pipe"></span>
				<span>
					<!-- Exibe a categoria do filme -->
					<?= $movie_category ?>
				</span>
				<span class="pipe"></span>
				<span>
					<!-- Exibe o rating do filme -->
					<i class="fas fa-star"></i> <?= $movie -> rating ?>
				</span>
			</p>
			<!-- Exibe o trailer do filme -->
			<iframe src="<?= $movie -> trailer ?>" width="560" height="315" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encryted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
			<p>
				<!-- Exibe a descrição do filme -->
				<?= $movie -> description ?>
			</p>
		</div>
		<div class="col-md-4">
			<div class="movie-image-container" style="background-image: url('<?= $BASE_URL ?>../assets/movies/<?= $movie -> image ?>')"></div>
		</div>
		<div class="offset-md-1 col-md-10" id="reviews-container">
			<h3 id="reviews-title">
				Avaliações:
			</h3>
			
			<!-- Verifica se o usuário já fez uma avaliação -->
			<?php if (!empty($userData) && !$userOwnsMovie && !$alreadyReviewed): ?>
				<div class="col-md-12" id="review-form-container">
					<h4>
						Envie sua avaliação:
					</h4>
					<p class="page-description">
						Preencha o formulário com a nota e comentário sobre o filme.
					</p>
					<form action="<?= $BASE_URL ?>review_process.php" id="review-form" method="POST">
						<input type="hidden" name="type" value="create">
						<input type="hidden" name="movies_id" value="<?= $movie -> id ?>">
						<div class="form-group">
							<label for="rating"> Nota do filme: </label>
							<select name="rating" id="rating" class="form-control">
								<option value=""> Selecione </option>
								<option value="10"> 10 </option>
								<option value="9"> 9 </option>
								<option value="8"> 8 </option>
								<option value="7"> 7 </option>
								<option value="6"> 6 </option>
								<option value="5"> 5 </option>
								<option value="4"> 4 </option>
								<option value="3"> 3 </option>
								<option value="2"> 2 </option>
								<option value="1"> 1 </option>
							</select>
						</div>
						<div class="form-group">
							<label for="review">
								Seu comentário:
							</label>
							<textarea name="review" id="review" rows="4" class="form-control" placeholder="O que você achou do filme?"></textarea>
						</div>
						<input type="submit" class="btn card-btn" value="Enviar comentário">
					</form>
				</div>
			<?php endif; ?>
			<!-- Exibe os comentários e a avaliações -->
			<?php foreach($movieReviews as $review): ?>
				<?php require("templates/user_review.php"); ?>
			<?php endforeach; ?>
			<!-- Verifica há comentários e avaliações -->
			<?php if (count($movieReviews) == 0): ?>
				<p class="empty-list">
					Não há comentários para este filme ainda. . .
				</p>
			<?php endif; ?>
		</div>
	</div>
</div>

<?php
	// Inclue apenas uma vez o footer.
	require_once("templates/footer.php");
?>