<?php
	// Inclue apenas uma vez os arquivos abaixo.
	require_once("templates/header.php");
	require_once("models/User.php");
	require_once("dao/UserDAO.php");
	
	// Chama o construtor.
	$user = new User();
	$userDao = new UserDao($conn, $BASE_URL);

	// Verifica se o usuário está validado e retorna seus dados.
	$userData = $userDao -> verifyToken(true);
?>

<div id="main-container" class="container-fluid">
	<div class="new-movie-container">
		<h1 class="page-title">
			Add Movie
		</h1>
		<p class="page-description">
			Add your review and share with the world!
		</p>
		<form action="<?= $BASE_URL ?>movie_process.php" id="add-movie-form" method="POST" enctype="multipart/form-data">
			<input type="hidden" name="type" value="create">
			<div class="form-group">
				<label for="title">
					Title:
				</label>
				<input type="text" class="form-control" id="title" name="title" placeholder="Enter your movie title">
			</div>
			<div class="form-group">
				<label for="image">
					Image:
				</label>
				<input type="file" class="form-control-file" name="image" id="image">
			</div>
			<div class="form-group">
				<label for="length">
					Duration in minutes:
				</label>
				<input type="number" class="form-control" id="length" name="length" placeholder="Enter the movie duration">
			</div>
			<div class="form-group">
				<label for="category">
					Category:
				</label>
				<select name="category" id="category" class="form-control">
					<option value=""> Select </option>
					<option value="1"> Action </option>
					<option value="2"> Drama </option>
					<option value="3"> Comedy </option>
					<option value="4"> Fantasy / Fiction </option>
					<option value="5"> Romance </option>
				</select>
			</div>
			<div class="form-group">
				<label for="trailer">
					Trailer:
				</label>
				<div class="form-trailer">
					<input type="text" class="form-control" id="trailer" name="trailer" placeholder="Insert the trailer link">
				</div>
			</div>
			<div class="form-group">
				<label for="trailer">
					Description:
				</label>
				<textarea name="description" id="description" rows="5" class="form-control" placeholder="Describe your movie. . ."></textarea>
			</div>
			<input type="submit" class="btn card-btn" value="Add movie">
		</form>
	</div>
</div>

<?php
	// Inclue apenas uma vez o footer.
	require_once("templates/footer.php");
?>