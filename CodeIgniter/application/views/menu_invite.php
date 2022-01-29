	<div class="text-center">
		<h3 class="my-3">Espace invité</h3>
		<h4 class="mb-3">Bienvenue <?php echo $this->session->userdata('username');?> !</h4>
	</div>
	<div class="py-3 d-flex flex-row flex-wrap align-content-stretch justify-content-around"><!-- flex -->
		<?php
			echo "<div class=\"border rounded text-center p-3 my-3\"><!-- border -->\n";// border
			echo "	<h5 class=\"mb-2\">Liste des animations auxquelles vous participez</h5>\n";
			if ($anim_info != NULL)
			{
				echo "	<div class=\"table-responsive\"><!-- wrapper table-responsive -->\n";// wrapper table-responsive
				echo "		<table class=\"table table-sm\"><!-- table -->\n";// table
				echo "			<thead>\n";
				echo "				<tr>\n";
				echo "					<th scope=\"col\">Nom</th>\n";
				echo "					<th scope=\"col\">Horaire début</th>\n";
				echo "					<th scope=\"col\">Horaire fin</th>\n";
				echo "					<th scope=\"col\">Nom du lieu</th>\n";
				echo "				</tr>\n";
				echo "			</thead>\n";
				echo "			<tbody>\n";
				foreach ($anim_info as $animInfo)
				{
					echo "				<tr>\n";
					echo "					<td>" . $animInfo["ani_nom"] . "</td>\n";
					echo "					<td>" . $animInfo["ani_horaire_debut"] . "</td>\n";
					echo "					<td>" . $animInfo["ani_horaire_fin"] . "</td>\n";
					if ($animInfo["lie_nom"] != NULL)
					{
						echo "					<td>" . $animInfo["lie_nom"] . "</td>\n";
					}
					else
					{
						echo "					<td>Aucun lieu</td>\n";
					}
					echo "				</tr>\n";
				}
				echo "			</tbody>\n";
				echo "		</table><!-- //table -->\n";// !table
				echo "	</div><!-- //wrapper table-responsive -->\n";// !wrapper table-responsive
			}
			else
			{
				echo "	<span>Vous participez à aucune animation</span>\n";
			}
			echo "</div><!-- //border -->\n";// !border
			

			echo "<div class=\"border rounded text-center p-3 my-3\" style=\"max-width: 40rem;\"><!-- border -->\n";
			echo "	<h5 class=\"mb-2\">Les informations que les visiteurs verront à propos de vous</h5>\n";
			if ($invite_info != NULL)
			{
				foreach ($invite_info as $invInfo)
				{
					echo "	<h6 class=\"mb-2\">Votre nom de scène est " . $invInfo["inv_nom"] . "</h6>\n";
					echo "	<h6 class=\"mb-2\">Votre biographie : </h6>\n";
					echo "	<p class=\"mb-2\">" . $invInfo["inv_biographie"] . "</p>\n";
					echo "	<h6 class=\"mb-2\">Vos disciplines : </h6>\n";
					if ($invInfo["inv_discipline"] != NULL)
					{
						echo "	<p class=\"mb-2\">" . $invInfo["inv_discipline"] . "</p>\n";
					}
					else
					{
						echo "	<span class=\"mb-2\">Pas de discipline enregistrée</span>\n";
					}
					echo "	<h6 class=\"mb-2\">Votre image : </h6>\n";
					if ($invInfo["inv_image"] != NULL)
					{
						echo "	<img src=\"" . base_url() . "style/assets/images/invites_image/" . $invInfo["inv_image"] . "\" style=\"max-width: 10rem;\">\n";
					}
					else
					{
						echo "	<span>Pas d'image enregistrée</span>\n";
					}
				}
			}
			else
			{
				echo "	<span>Aucune information enregistrée</span>\n";
			}
			echo "</div><!-- //border -->\n";
		?>
	</div><!-- //flex -->
	<div class="text-center">
		<a class="btn btn-primary m-2" href="<?php echo $this->config->base_url(); ?>index.php/menu/deconnecter">Se déconnecter</a>
		<a class="btn btn-primary m-2" href="<?php echo $this->config->base_url(); ?>index.php/compte/modifier">Changer de mot de passe</a>
		<a class="btn btn-primary m-2" href="<?php echo $this->config->base_url(); ?>index.php/menu/invite_passeports">Vos passeports & posts</a>
	</div>
	</div>