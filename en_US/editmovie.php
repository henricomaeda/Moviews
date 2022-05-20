<?php
	// Inclue apenas uma vez os arquivos abaixo.
	require_once("templates/header.php");
	require_once("models/User.php");
	require_once("dao/UserDAO.php");
	require_once("dao/MovieDAO.php");
	
	// Chama o construtor.
	$user = new User();
	$userDao = new UserDao($conn, $BASE_URL);
	$movieDao = new MovieDAO($conn, $BASE_URL);
	$id = filter_input(INPUT_GET, "id");
	
	// Verifica se o usuário está validado e retorna seus dados.
	$userData = $userDao -> verifyToken(true);
	
	// Verifica se o filme que será atualizado é validado.
	if (empty($id)) $message -> setMessage("The movie was not found!", "error", "index.php");
	else {
		$movie = $movieDao -> findById($id);
		
		if (!$movie) $message -> setMessage("The movie was not found!", "error", "index.php");
	}
	
	// Define imagem padrão, caso o usuário não tenha o mesmo.
	if ($movie -> image == "") $movie -> image = "movie_cover.jpg";
?>
<div id="main-container" class="container-fluid">
	<div class="col-md-12">
		<div class="row">
			<div class="col-md-6 offset-md-1">
				<h1>
					<?= $movie -> title ?>
				</h1>
				<p class="page-description">
					Change the movie data in the form below:
				</p>
				<form id="edit-movie-form" action="<?= $BASE_URL ?>movie_process.php" method="POST" enctype="multipart/form-data">
					<input type="hidden" name="type" value="update">
					<input type="hidden" name="id" value="<?= $movie -> id ?>">
					<div class="form-group">
						<label for="title">
							Title:
						</label>
						<input type="text" class="form-control" id="title" name="title" placeholder="Enter your movie title" value="<?= $movie -> title ?>">
					</div>
					<div class="form-group">
						<label for="image">
							Image:
						</label>
						<input type="file" class="form-control-file" name="image" id="image">
					</div>
					<div class="form-group">
						<label for="length">
							Duration:
						</label>
						<input type="text" class="form-control" id="length" name="length" placeholder="Enter the movie duration" value="<?= $movie -> length ?>">
					</div>
					<div class="form-group">
						<label for="category">
							Category:
						</label>
						<select name="category" id="category" class="form-control">
							<option value="">
								Select
							</option>
							<option value="1" <?= $movie -> category === 1 ? "selected" : "" ?>>
								Action
							</option>
							<option value="2" <?= $movie -> category === 2 ? "selected" : "" ?>>
								Drama
							</option>
							<option value="3" <?= $movie -> category === 3 ? "selected" : "" ?>>
								Comedy
							</option>
							<option value="4" <?= $movie -> category === 4 ? "selected" : "" ?>>
								Fantasy / Science fiction
							</option>
							<option value="5" <?= $movie -> category === 5 ? "selected" : "" ?>>
								Romance
							</option>
						</select>
					</div>
					<div class="form-group">
						<label for="trailer">
							Trailer:
						</label>
						<input type="text" class="form-control" id="trailer" name="trailer" placeholder="Insert the movie trailer" value="<?= $movie -> trailer ?>">
					</div>
					<div class="form-group">
						<label for="description">
							Description:
						</label>
						<textarea name="description" id="description" rows="5" class="form-control" placeholder="Describe the movie. . ."><?= $movie -> description ?></textarea>
					</div>
					<input type="submit" class="btn card-btn profile" value="Edit movie">
				</form>
			</div>
			<div class="col-md-3">
				<div class="movie-image-container" style="background-image: url('<?= $BASE_URL ?>../assets/movies/<?= $movie -> image ?>')"></div>
			</div>
		</div>
	</div>
</div>

<?php
	// Inclue apenas uma vez o footer.
	require_once("templates/footer.php");
?>