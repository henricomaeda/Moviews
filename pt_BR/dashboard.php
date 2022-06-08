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
	
	// Verifica se o usuário e os filmes estão validados e retorna seus dados.
	$userMovies = $movieDao -> getMoviesByUserId($userData -> id);
	$userData = $userDao -> verifyToken(true);
?>

<div id="main-container" class="container-fluid">
	<h2 class="section-title">
		Dashboard
	</h2>
	<p class="section-description">
		Adicione um filme ou atualize suas informações
	</p>
	<div class="col-md-12" id="add-movie-container">
		<a href="<?= $BASE_URL ?>newmovie.php" class="btn card-btn">
			<i class="fas fa-plus"></i> Adicionar um filme
		</a>
	</div>
	<div class="col-md-12" id="movies-dashboard">
		<table class="table">
			<thead>
				<th scope="col"> ID </th>
				<th scope="col"> Título </th>
				<th scope="col"> Nota </th>
				<th scope="col" class="actions-column"> Ações </th>
			</thead>
			<tbody>
				<!-- Exibe os filmes do usuário -->
				<?php foreach($userMovies as $movie): ?>
					<tr>
						<!-- Exibe o ID dos filmes -->
						<td scope="row"><?= $movie -> id ?></td>
						
						<!-- Exibe o título dos filmes -->
						<td><a href="<?= $BASE_URL ?>movie.php?id=<?= $movie -> id ?>" class="table-movie-title"><?= $movie -> title ?></a></td>
						
						<!-- Exibe a nota de avaliação dos filmes -->
						<td><i class="fas fa-star"></i> <?= $movie -> rating ?></td>
						
						<!-- Botões de editar e remover dos filmes -->
						<td class="actions-column">
							<a href="<?= $BASE_URL ?>editmovie.php?id=<?= $movie -> id ?>" class="edit-btn">
								<i class="far fa-edit"></i> Atualizar
							</a>
							<form action="<?= $BASE_URL ?>movie_process.php" method="POST">
								<input type="hidden" name="type" value="delete">
								<input type="hidden" name="id" value="<?= $movie -> id ?>">
								<button type="submit" class="delete-btn">
									<i class="fas fa-times"></i> Remover
								</button>
							</form>
						</td>
					</tr>
				<?php endforeach; ?>
			</tbody>
		</table>
		<!-- Verifica se o usuário adicionou algum filme -->
		<?php if (count($userMovies) == 0): ?>
			<p class="empty-list">
				Você não adicionou nenhum filme ainda ...
			</p>
		<?php endif; ?>
	</div>
</div>

<?php
	// Inclue apenas uma vez o footer.
	require_once("templates/footer.php");
?>