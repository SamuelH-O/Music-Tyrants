	<div class="container"><!-- inactif -->
		<div class="row justify-content-center text-center p-2">
			<div class="col-md-6 border rounded m-3">
				<h3 class="section-heading text-center my-3">Connexion</h3>
<?php
	$errors = validation_errors();
	if ($errors)
	{
		echo "				<div class=\"alert alert-danger\" role=\"alert\">" . $errors . "</div>";
	}
	elseif (isset($succesMsg))
	{
		echo "				<div class=\"alert alert-success\" role=\"alert\">" . $succesMsg . "</div>";
	}
?>
				<?php echo form_open('compte/creer'); ?>
					<div class="mb-3">
						<label for="pseudo_id" class="form-label">Pseudo</label>
						<input type="text" name="pseudo" class="form-control" id="pseudo_id" required>
					</div>
					<div class="mb-3">
						<label for="MDP1_id" class="form-label">Mot de passe</label>
						<input type="password" name="MDP1" class="form-control" id="MDP1_id" required>
					</div>
					<div class="mb-3">
						<label for="MDP2_id" class="form-label">Confirmation du mot de passe</label>
						<input type="password" name="MDP2" class="form-control" id="MDP2_id" required>
					</div>
					<button type="submit" value="Connexion" class="btn btn-primary mb-3">Connexion</button>
				</form>
			</div>
		</div>
	</div>