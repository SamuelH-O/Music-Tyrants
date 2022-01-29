	<div class="container">
		<div class="row justify-content-center text-center p-2">
			<div class="col-md-6 border rounded m-3">
				<h3 class="section-heading text-center my-3">Création d'un post</h3>
<?php
	$errors = validation_errors();
	if($errors)
	{
		// Affiche l'erreur de CodeIgniter s'il y en a une
		echo "				<div class=\"alert alert-danger\" role=\"alert\">" . $errors . "</div>";
	}
	elseif (isset($errorMsg))
	{
		// Affiche l'erreur pérsonalisé s'il y en a une
		echo "				<div class=\"alert alert-danger\" role=\"alert\">" . $errorMsg . "</div>";
	}
	elseif(isset($succesMsg))
	{
		// Affiche le msg de réussite pérsonalisé s'il y en a un
		echo "				<div class=\"alert alert-success\" role=\"alert\">" . $succesMsg . "</div>";
	}
	echo form_open('posts/creer');
?>
					<div class="mb-3">
						<label for="passID_id" class="form-label">Passport ID</label>
						<input type="text" autocomplete="off" pattern="\([^ /\\&quot']+_[^ /\\&quot']+)\" name="passID" class="form-control" id="passID_id" required><!-- verifie que le l'id correspond à la nomenclature -->
					</div>
					<div class="mb-3">
						<label for="password_id" class="form-label">Mot de passe</label>
						<input type="password" minlength="8" name="password" class="form-control" id="password_id" required>
					</div>
					<div class="mb-3">
						<label for="post_id" class="form-label">Contenu du post</label>
						<textarea type="text" maxlength="140" autocomplete="off" name="post" class="form-control" id="post_id" required></textarea>
					</div>
					<div class="d-grid gap-2 d-md-block">
						<a type="button" href="<?php echo $this->config->base_url(); ?>" class="btn btn-primary mb-3">Annuler</a>
						<button type="submit" value="CreerUnPost" class="btn btn-secondary mb-3">Valider</button>
					</div>
				</form>
			</div>
		</div>
	</div>