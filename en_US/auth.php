<?php
	// Inclue apenas uma vez os arquivos abaixo.
	require_once("templates/header.php");
	require_once("models/Message.php");
	
	// Redireciona o usuário, caso o usuário esteja validado, para o seu perfil.
	if (!empty($_SESSION["use_token"])) $message -> setMessage("Seja bem-vindo!", "success", "editprofile.php");
?>

<div id="main-container" class="container-fluid">
	<div class="col-md-12">
		<div class="row" id="auth-row">
			<!-- Formulário de conexão -->
			<div class="col-md-4" id="login-container">
				<h2> Sign in </h2>
				<form action="<?=$BASE_URL ?>auth_process.php" method="POST">
					<input type="hidden" name="type" value="login">
					<div class="form-group">
						<label for="email"> Email: </label>
						<input type="email" class="form-control" id="email" name="email" placeholder="Enter your email">
					</div>
					<div class="form-group">
						<label for="password"> Password: </label>
						<input type="password" class="form-control" id="password" name="password" placeholder="Enter your password">
					</div>
					<input type="submit" class="btn card-btn" value="Connect account">
				</form>
			</div>
			<!-- Formulário de cadastro -->
			<div class="col-md-4" id="register-container">
				<h2> Sign up </h2>
				<form action="<?= $BASE_URL ?>auth_process.php" method="POST">
					<input type="hidden" name="type" value="register">
					<div class="form-group">
						<label for="email"> Email: </label>
						<input type="email" class="form-control" id="email" name="email" placeholder="Enter your email">
					</div>
					<div class="form-group">
						<label for="name"> Name: </label>
						<input type="text" class="form-control" id="name" name="name" placeholder="Enter your name">
					</div>
					<div class="form-group">
						<label for="lastname"> Lastname: </label>
						<input type="text" class="form-control" id="lastname" name="lastname" placeholder="Enter your lastname">
					</div>
					<div class="form-group">
						<label for="password"> Password: </label>
						<input type="password" class="form-control" id="password" name="password" placeholder="Enter your lastname">
					</div>
					<div class="form-group">
						<label for="confirmpassword"> Confirm password: </label>
						<input type="password" class="form-control" id="confirmpassword" name="confirmpassword" placeholder="Confirm your password">
					</div>
					<input type="submit" class="btn card-btn" value="Register account">
				</form>
			</div>
		</div>
	</div>
</div>

<?php
	// Inclue apenas uma vez o footer.
	require_once("templates/footer.php");
?>