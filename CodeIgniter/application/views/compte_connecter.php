	<div class="col-md-6 border rounded my-3 mx-3 mx-md-auto"><!-- container -->
		<h3 class="section-heading text-center my-3 p-3">Connexion</h3>
<?php
	$errors = validation_errors();
	if ($errors)
	{
		// Affiche l'erreur de CodeIgniter s'il y en a une
		echo "				<div class=\"alert alert-danger\" role=\"alert\">" . $errors . "</div>\n";
	}
	elseif (isset($errorMsg))
	{
		// Affiche l'erreur pérsonalisé s'il y en a une
		echo "				<div class=\"alert alert-danger\" role=\"alert\">" . $errorMsg . "</div>\n";
	}
	echo form_open('compte/connecter');//formulaire
?>
			<div class="mb-3 mx-3">
				<label for="pseudo" class="form-label">Pseudo</label>
				<input type="text" autocomplete="off" name="pseudo" class="form-control" id="pseudo" required>
			</div>
			<div class="mb-3 mx-3">
				<label for="motDePasse" class="form-label">Mot de passe</label>
				<input type="password" minlength="8" name="mdp" class="form-control" id="motDePasse" required>
			</div>
			<div class="d-grid d-flex justify-content-center">
				<button type="submit" value="Connexion" class="btn btn-primary mb-3">Connexion</button>
			</div>
		</form><!-- //formulaire -->
	</div><!-- //container -->