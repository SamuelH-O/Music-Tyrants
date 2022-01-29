	<h3 class="section-heading text-center my-3"><?php echo $titre;?></h3>
	<div class="table-responsive-lg m-4"><!-- wrapper table-responsive -->
		<table class="table table-hover text-center align-middle table-bordered"><!-- table -->
			<thead>
				<tr>
					<th scope="col">Nom</th>
					<th scope="col">Activé / Désactivé</th>
					<th scope="col">Activation / Désactivation</th>
					<th scope="colgroup">Posts, Date, État & Action</th>
			</thead>
			<tbody>
<?php
	if($passeports != NULL)
	{
		foreach($passeports as $pas)
		{
			echo "			<tr>\n";
			echo "				<td>" . $pas["pas_id"] . "</td>\n";
			if($pas["pas_etat"] == 'A')
			{
				echo "				<td>Activé</td>\n";
				echo "				<td><button type=\"button\" class=\"btn btn-primary rounded-3\"><i class=\"fas fa-user-minus\"></i></button></td>\n";
			}
			else
			{
				echo "				<td>Désactivé</td>\n";
				echo "				<td><button type=\"button\" class=\"btn btn-primary rounded-3\"><i class=\"fas fa-user-plus\"></i></button></td>\n";
			}
			if($pas["pos_text"] != NULL)
			{
				// S'il y a des posts les mettre dans un tableau imbriqué
				echo "				<td colspan=4>\n\n";

				echo "					<table class=\"table table-hover table-bordered mb-0\">\n";
				echo "						<tbody>\n";

				// Sépare les strings créé par les GROUP_CONCAT
				$posts_text = explode("£££££", $pas["pos_text"]);
				$posts_date = explode("£££££", $pas["pos_date"]);
				$posts_etat = explode("£££££", $pas["pos_etat"]);
				for($i=0; $i < count($posts_date); $i++) { 
					echo "							<tr>\n";
					echo "								<td>" . $posts_text[$i] . "</td>\n";
					echo "								<td>" . $posts_date[$i] . "</td>\n";

					if($posts_etat[$i] == 'P')
					{
						echo "								<td>Publié</td>\n";
						echo "								<td><button type=\"button\" class=\"btn btn-primary rounded-3\"><i class=\"fas fa-minus-square\"></i></button></td>\n";
					}
					else
					{
						echo "								<td>Caché</td>\n";
						echo "								<td><button type=\"button\" class=\"btn btn-primary rounded-3\"><i class=\"fas fa-plus-square\"></i></button></td>\n";
					}
					echo "							</tr>\n";
				}
				echo "						</tbody>\n";
				echo "					</table>\n\n";

				echo "				</td>\n";
			}
			else
			{
				echo "				<td colspan=2>Aucun post</td>\n";
			}
			echo "			</tr>\n";
		}
	}
	else
	{
		echo "			</td colspan=4>Aucun passeport</td>\n";
	}
?>
			</tbody>
		</table><!-- //table -->
	</div><!-- //wrapper table-responsive -->
	<div class="text-center">
		<a class="btn btn-primary m-2" href="<?php echo $this->config->base_url(); ?>index.php/menu/invite">Retour</a>
	</div>