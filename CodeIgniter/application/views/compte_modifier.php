	<div class="container"><!-- container -->
		<div class="row justify-content-center text-center p-2"><!-- row flex -->
			<div class="col-md-6 border rounded m-3"><!-- border -->
				<h3 class="section-heading text-center my-3">Modification du mot de passe</h3>
<?php
	$errors = validation_errors();
	if ($errors)
	{
		// Affiche l'erreur de CodeIgniter s'il y en a une
		echo "				<div class=\"alert alert-danger\" role=\"alert\">" . $errors . "</div>\n";
	}
	elseif (isset($succesMsg))
	{
		// Affiche l'erreur pérsonalisé s'il y en a une
		echo "				<div class=\"alert alert-success\" role=\"alert\">" . $succesMsg . "</div>\n";
	}
	echo form_open('compte/connecter');// formulaire
?>
					<div class="mb-3">
						<label for="vieuxMDP_id" class="form-label">Ancien mot de passe</label>
						<input type="password" name="vieuxMDP" class="form-control" id="vieuxMDP_id" required>
					</div>
					<div class="mb-3">
						<label for="nouveauMDP1_id" class="form-label">Nouveau mot de passe</label>
						<input type="password" minlength="8" name="nouveauMDP1" class="form-control" id="nouveauMDP1_id" required>
					</div>
					<div class="mb-3">
						<label for="nouveauMDP2_id" class="form-label">Confirmation du nouveau mot de passe</label>
						<input type="password" minlength="8" name="nouveauMDP2" class="form-control" id="nouveauMDP2_id" required>
					</div>
					<button type="submit" value="ChangementDeMotDePasse" class="btn btn-primary mb-3">Changer de mot de passe</button>
				</form><!-- //formulaire -->
			</div><!-- //border -->
		</div><!-- //row flex -->
	</div><!-- //container -->