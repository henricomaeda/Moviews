<?php
	// Inclue apenas uma vez os arquivos abaixo.
	require_once("templates/header.php");
	require_once("models/User.php");
	require_once("dao/UserDAO.php");
	require_once("dao/MovieDAO.php");
	
	// Chama o construtor.
	$user = new User();
	$userDao = new UserDAO($conn, $BASE_URL);
	$movieDao = new MovieDAO($conn, $BASE_URL);
	$id = filter_input(INPUT_GET, "id");
	
	// Verifica se o usuário e o ID do mesmo estão vazios.
	if (empty($id)) {
		if (!empty($userData)) $id = $userData -> id;
		else $message -> setMessage("User not found!", "error", "index.php");
	} else {
		// Recebe os dados do usuário.
		$userData = $userDao -> findById($id);
		if (!$userData) $message -> setMessage("User not found!", "error", "index.php");
	}
	
	// Define as variáveis com os dados do usuário.
	$fullName = $user -> getFullName($userData);
	if ($userData -> image == "") $userData -> image = "user.png";
	$userMovies = $movieDao -> getMoviesByUserId($id);
?>

<div id="main-container" class="container-fluid">
	<div class="col-md-8 offset-md-2">
		<div class="row profile-container">
			<div class="col-md-12 about-container">
				<h1 class="page-title">
					<!-- Exibe o nome completo do usuário -->
					<?= $fullName ?>
				</h1>
				<div id="profile-image-container" class="profile-image" style="background-image: url('<?= $BASE_URL ?>../assets/users/<?= $userData -> image ?>')"></div>
				<h3 class="about-title">
					About:
				</h3>
				<!-- Verifica se o usuário tem uma biografia -->
				<?php if (!empty($userData -> bio)): ?>
					<p class="profile-description">
						<!-- Exibe a biografia do usuário -->
						<?= $userData -> bio ?>
					</p>
				<?php else: ?>
					<p class="profile-description">
						The user hasn't written anything in your bio yet. . .
					</p>
				<?php endif; ?>
			</div>
			<div class="col-md-12 added-movies-container">
				<h3> Movies sent: </h3>
				<div class="movies-container">
					<!-- Exibe os filmes do usuário -->
					<?php foreach($userMovies as $movie): ?>
						<?php require("templates/movie_card.php"); ?>
					<?php endforeach; ?>
					<!-- Verifica se o usuário enviou filmes -->
					<?php if (count($userMovies) === 0): ?>
						<p class="empty-list">
							The user haven't send any movies yet. . .
						</p>
					<?php endif; ?>
				</div>
			</div>
		</div>
	</div>
</div>

<?php
	// Inclue apenas uma vez o footer.
	require_once("templates/footer.php");
?>