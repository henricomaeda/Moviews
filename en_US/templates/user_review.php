<?php
	// Inclue apenas uma vez o arquivo abaixo.
	require_once("models/User.php");
	
	// Chama o construtor.
	$userModel = new User();

	// Define a variável com o nome completo do usuário.
	$fullName = $userModel -> getFullName($review -> user);
	
	// Define imagem padrão, caso o usuário não tenha o mesmo.
	if($review -> user -> image == "") $review -> user -> image = "user.png";
?>

<div class="col-md-12 review">
	<div class="row">
		<div class="col-md-1">
			<div class="profile-image-container review-image" style="background-image: url('<?= $BASE_URL ?>../assets/users/<?= $review -> user -> image ?>')"></div>
		</div>
		<div class="col-md-9 author-details-container">
			<h4 class="author-name">
				<!-- Exibe o nome completo do usuário -->
				<a href="<?= $BASE_URL ?>profile.php?id=<?= $review -> user -> id ?>"><?= $fullName ?></a>
			</h4>
			<!-- Exibe a avaliação do usuário -->
			<p><i class="fas fa-star"></i> <?= $review -> rating ?></p>
		</div>
		<div class="col-md-12">
			<p class="comment-title"> Comment: </p>
			<!-- Exibe o comentário do usuário -->
			<p><?= $review -> review ?></p>
		</div>
	</div>
</div>