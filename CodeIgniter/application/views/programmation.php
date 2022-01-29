	<h3 class="section-heading text-center my-3"><?php echo $titre;?></h3>
	<div class="table-responsive m-4"><!-- table-responsive wrapper -->
		<table class="table table-striped text-center"><!-- table -->
			<thead>
				<tr>
					<th scope="col">Nom</th>
					<th scope="col">Détails animation</th>
					<th scope="col">Date & Horaire De Début</th>
					<th scope="col">Date & Horaire De Fin</th>
					<th scope="col">Invités</th>
					<th scope="col">Détails des invité.e.s</th>
					<th scope="col">Scène</th>
					<th scope="col">Détails du lieu</th>
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
					echo "				<tr>\n";
					echo "					<th scope=\"row\" colspan=\"8\" class=\"table-primary text-center align-middle\"><h4>Passée</h4></th>\n";
					echo "				</tr>\n";
				}
				elseif ($prog["ani_etat"] == "en cours")
				{
					echo "				<tr>\n";
					echo "					<th scope=\"row\" colspan=\"8\" class=\"table-primary text-center align-middle\"><h4>En Cours</h4></th>\n";
					echo "				</tr>\n";
				}
				elseif ($prog["ani_etat"] == "à venir")
				{
					echo "				<tr>\n";
					echo "					<th scope=\"row\" colspan=\"8\" class=\"table-primary text-center align-middle\"><h4>À Venir</h4></th>\n";
					echo "				</tr>\n";
				}
			}
			$temp = $prog["ani_etat"];// Sauvegarde l'état pour le comparer après
			echo "				<tr>\n";

			echo "					<td>" . $prog["ani_nom"] ."</td>\n";

			echo "					<td><a type=\"button\" href=\"" . $this->config->base_url() . "index.php/programmation/details_animation/" . $prog["ani_id"] . "\" class=\"btn btn-primary rounded-3\"><i class=\"fas fa-info-circle\"></i></a></td>\n";

			echo "					<td>" . $prog["ani_horaire_debut"] . "</td>\n";

			echo "					<td>" . $prog["ani_horaire_fin"] . "</td>\n";

			if ($prog["invites"] != NULL)
			{
				echo "					<td>" . $prog["invites"] . "</td>\n";
				echo "					<td><a type=\"button\" href=\"" . $this->config->base_url() . "index.php/programmation/details_invite/" . $prog["ani_id"] . "\" class=\"btn btn-primary rounded-3 mx-1\"><i class=\"fas fa-users\"></i></a></td>\n";
			}
			else
			{
				echo "					<td colspan=\"2\">Aucun invité</td>\n";
			}

			if ($prog["lie_nom"] != NULL)
			{
				echo "					<td>" . $prog["lie_nom"] . "</td>\n";
				echo "					<td><a type=\"button\" href=\"" . $this->config->base_url() . "index.php/programmation/details_lieu/" . $prog["ani_id"] . "\" class=\"btn btn-primary rounded-3\"><i class=\"fas fa-map-marker-alt\"></i></a></td>\n";
			}
			else
			{
				echo "					<td colspan=\"2\">Aucun lieu</td>\n";
			}

			echo "				</tr>\n";
		}
	}
	else
	{
		echo "				<tr>\n";
		echo "					<td scope=\"row\" colspan=\"8\">Aucune animation pour l'instant !</td>\n";
		echo "				</tr>\n";
	}
?>
			</tbody>
		</table><!-- //table -->
	</div><!-- //table-responsive wrapper -->