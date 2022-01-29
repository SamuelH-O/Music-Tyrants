	<div class="text-center">
		<h3 class="my-3">Espace d'administration</h3>
		<h4 class="mb-2">Programation</h4>
	</div>
	<div class="text-center">
		<a class="btn btn-primary m-2" href="<?php echo $this->config->base_url(); ?>index.php/menu/deconnecter">Se déconnecter</a>
		<a class="btn btn-primary m-2" href="<?php echo $this->config->base_url(); ?>index.php/menu/administrateur">Accueil administrateur</a>
		<a class="btn btn-primary m-2" href="<?php echo $this->config->base_url(); ?>index.php/compte/modifier">Changer de mot de passe</a>
	</div>
	<div class="border rounded text-center p-3 my-3 mx-auto"><!-- border -->
		<div class="table-responsive"><!-- table-responsive wrapper -->
			<table class="table table-sm table-bordered table-striped border-secondary text-center"><!-- table -->
				<thead>
					<tr>
						<th scope="col">Nom</th>
						<th scope="col">Date & Horaire De Début</th>
						<th scope="col">Date & Horaire De Fin</th>
						<th scope="col">Invités</th>
						<th scope="col">Scène</th>
						<th scope="col">Modifier</th>
						<th scope="col">Supprimer</th>
					</tr>
				</thead>
				<tbody>
<?php
	if ($programmation != NULL)
	{
		$temp = NULL;
		foreach ($programmation as $prog)
		{
			if ($temp != $prog["ani_etat"])// Si l'état change entre 2 lignes affiche la ligne du nouvel état
			{
				if ($prog["ani_etat"] == "passée")
				{
					echo "					<tr>\n";
					echo "						<th scope=\"row\" colspan=\"7\" class=\"table-primary text-center align-middle\"><h4>Passée</h4></th>\n";
					echo "					</tr>\n";
				}
				elseif ($prog["ani_etat"] == "en cours")
				{
					echo "					<tr>\n";
					echo "						<th scope=\"row\" colspan=\"7\" class=\"table-primary text-center align-middle\"><h4>En Cours</h4></th>\n";
					echo "					</tr>\n";
				}
				elseif ($prog["ani_etat"] == "à venir")
				{
					echo "					<tr>\n";
					echo "						<th scope=\"row\" colspan=\"7\" class=\"table-primary text-center align-middle\"><h4>À Venir</h4></th>\n";
					echo "					</tr>\n";
				}
			}
			$temp = $prog["ani_etat"];// Sauvegarde l'état pour le comparer après
			echo "					<tr>\n";
			echo "						<td >" . $prog["ani_nom"] ."</td>\n";
			echo "						<td >" . $prog["ani_horaire_debut"] . "</td>\n";
			echo "						<td >" . $prog["ani_horaire_fin"] . "</td>\n";
			if ($prog["invites"] != NULL)
			{
				echo "						<td >" . $prog["invites"] . "</td>\n";
			}
			else
			{
				echo "						<td>Aucun invité</td>\n";
			}
			if ($prog["lie_nom"] != NULL)
			{
				echo "						<td >" . $prog["lie_nom"] . "</td>\n";
			}
			else
			{
				echo "						<td>Aucun lieu</td>\n";
			}
			echo "							<td><button type=\"button\" class=\"btn btn-primary rounded-3\" data-bs-toggle=\"modal\" data-bs-target=\"#exampleModal\"><i class=\"fas fa-edit\"></i></button></td>\n";
			echo "						<td>\n";
			echo "							<button type=\"button\" class=\"btn btn-danger rounded-3\" onclick='confirm_modal(id=" . $prog["ani_id"] . ", nom=\"" . $prog["ani_nom"] . "\")' data-bs-toggle=\"modal\" data-bs-target=\"#deleteAnimModal\">\n";
			echo "								<i class=\"fas fa-eraser\"></i>\n";
			echo "							</button>\n";
			echo "							</td>\n";
			echo "					</tr>\n";
		}
	}
	else
	{
		echo "					<tr>\n";
		echo "						<td scope=\"row\" colspan=\"8\" >Aucune animation pour l'instant !</td>\n";
		echo "					</tr>\n";
	}
?>
					</tbody>
				</table><!-- //table -->
			</div><!-- //table-responsive wrapper -->
			<button type="button" class="btn btn-primary rounded-3" data-bs-toggle="modal" data-bs-target="#exampleModal">Ajouter</button>
		</div><!-- //border -->

		<!-- Modal -->
		<div class="modal fade" id="deleteAnimModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
			<div class="modal-dialog modal-dialog-centered">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title" id="exampleModalLabel">Confirmation de suppression</h5>
						<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
					</div>
					<div class="modal-body" id="elemAChanger"></div>
					<div class="modal-footer">
						<button type="button" class="btn btn-primary" data-bs-dismiss="modal">Annuler</button>
						<?php
							echo form_open('menu/supr_anim');
						?>
							<input type="hidden" name="idOfAnim" id="idOfAnim" value="" />
							<button type="submit" class="btn btn-danger">Supprimer</button>
						</form>
					</div>
				</div>
			</div>
		</div>
		<!-- //Modal -->

		<script type="text/javascript">
			function confirm_modal(id, nom) {// fonction pour afficher le modal de confirmation 
				var elemAChanger = document.getElementById("elemAChanger");
				var textAChanger = "Êtes-vous sûr de vouloir supprimer l'animation : " + nom + " ?";
				elemAChanger.innerHTML = textAChanger;
				document.getElementById("idOfAnim").value = id;
			}
		</script>