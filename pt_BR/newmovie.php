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
			Adicionar Filme
		</h1>
		<p class="page-description">
			Adicione sua avaliação e compartilhe com o mundo!
		</p>
		<form action="<?= $BASE_URL ?>movie_process.php" id="add-movie-form" method="POST" enctype="multipart/form-data">
			<input type="hidden" name="type" value="create">
			<div class="form-group">
				<label for="title">
					Título:
				</label>
				<input type="text" class="form-control" id="title" name="title" placeholder="Digite o título do seu filme">
			</div>
			<div class="form-group">
				<label for="image">
					Imagem:
				</label>
				<input type="file" class="form-control-file" name="image" id="image">
			</div>
			<div class="form-group">
				<label for="length">
					Duração em minutos:
				</label>
				<input type="number" class="form-control" id="length" name="length" placeholder="Digite a duração do filme">
			</div>
			<div class="form-group">
				<label for="category">
					Categoria:
				</label>
				<select name="category" id="category" class="form-control">
					<option value=""> Selecione </option>
					<option value="1"> Ação </option>
					<option value="2"> Drama </option>
					<option value="3"> Comédia </option>
					<option value="4"> Fantasia / Ficção </option>
					<option value="5"> Romance </option>
				</select>
			</div>
			<div class="form-group">
				<label for="trailer">
					Trailer:
				</label>
				<div class="form-trailer">
					<input type="text" class="form-control id="trailer" name="trailer" placeholder="Insira o link do trailer">
				</div>
			</div>
			<div class="form-group">
				<label for="trailer">
					Descrição:
				</label>
				<textarea name="description" id="description" rows="5" class="form-control" placeholder="Descreva o filme. . ."></textarea>
			</div>
			<input type="submit" class="btn card-btn" value="Adicionar filme">
		</form>
	</div>
</div>

<?php
	// Inclue apenas uma vez o footer.
	require_once("templates/footer.php");
?>