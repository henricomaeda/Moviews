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
	$fullName = $user -> getFullName($userData);
	
	// Define imagem padrão, caso o usuário não tenha o mesmo.
	if ($userData -> image == "") $userData -> image = "user.png";
?>

<div id="main-container" class="container-fluid edit-profile-page">
	<div class="col-md-12">
		<div class="row" id="auth-row">
			<div class="col-md-4">
				<form action="<?= $BASE_URL ?>user_process.php" method="POST" enctype="multipart/form-data">
					<input type="hidden" name="type" value="update">
					<div id="profile-container">
						<h2>
							<!-- Exibe o nome completo do usuário -->
							<?= $fullName ?>
						</h2>
						<p class="page-description">
							Change your data in the form below:
						</p>
						<div id="profile-image-container" style="background-image: url('<?= $BASE_URL ?>../assets/users/<?= $userData -> image ?>')"></div>
						<div class="form-group">
							<label for="image">
								Photo:
							</label>
							<input type="file" class="form-control-file" name="image">
						</div>
						<div class="form-group">
							<label for="name">
								Name:
							</label>
							<input type="text" class="form-control" id="name" name="name" placeholder="Enter your name" value="<?= $userData -> name ?>">
						</div>
						<div class="form-group">
							<label for="lastname">
								Lastname:
							</label>
							<input type="text" class="form-control" id="lastname" name="lastname" placeholder="Enter your last name" value="<?= $userData -> lastname ?>">
						</div>
						<div class="form-group">
							<label for="email">
								Email:
							</label>
							<input type="text" readonly class="form-control disabled" id="email" name="email" value="<?= $userData -> email ?>">
						</div>
						<div class="form-group">
							<label for="bio">
								About you:
							</label>
							<textarea class="form-control" name="bio" id="bio" rows="4" placeholder="Comment about yourself. . ."><?= $userData -> bio ?></textarea>
						</div>
						<!-- Exibe a imagem do usuário -->
						<input type="submit" class="btn card-btn profile" value="Change data">
					</div>
				</form>
			</div>
			<div class="col-md-4">
				<form action="<?= $BASE_URL ?>user_process.php" method="POST">
					<div id="profile-container">
						<h2>
							Change the password:
						</h2>
						<p class="page-description">
							Enter and confirme your new password:
						</p>
						<input type="hidden" name="type" value="changepassword">
						<div class="form-group">
							<label for="password">
								Password:
							</label>
							<input type="password" class="form-control" id="password" name="password" placeholder="Enter your new password">
						</div>
						<div class="form-group">
							<label for="confirmpassword">
								Confirm the password:
							</label>
							<input type="password" class="form-control" id="confirmpassword" name="confirmpassword" placeholder="Confirm your new password">
						</div>
						<input type="submit" class="btn card-btn profile" value="Change password">
					</div>
				</form>
			</div>
		</div>
	</div>
</div>

<?php
	// Inclue apenas uma vez o footer.
	require_once("templates/footer.php");
?>