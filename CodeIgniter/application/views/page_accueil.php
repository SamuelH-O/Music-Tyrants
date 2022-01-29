	<h3 class="section-heading text-center my-3"><?php echo $titre;?></h3>
	<div class="table-responsive"><!-- table-responsive wrapper -->
		<table class="table table-striped"><!-- table -->
			<thead>
				<tr>
					<th scope="col">Titre</th>
					<th scope="col">Contenu</th>
					<th scope="col">Date</th>
					<th scope="col">Auteur</th>
				</tr>
			</thead>
			<tbody>
<?php
	if($actualite != NULL)
	{
		foreach ($actualite as $act)
		{
			echo "				<tr>\n";
			echo "					<td scope=\"row\">" . $act["act_titre"] ."</td>\n";
			if($act["act_contenu"] != NULL)
			{
				echo "					<td>" . $act["act_contenu"] . "</td>\n";
			}
			else
			{
				echo "					<td>Pas de contenu</td>\n";
			}
			echo "					<td>" . $act["act_date"] . "</td>\n";
			echo "					<td>" . $act["org_prenom_nom"] . "</td>\n";
			echo "				</tr>\n";
		}
	}
	else
	{
		echo "				<tr>\n";
		echo "					<td scope=\"row\" colspan=\"3\">Pas d'actualités</td>\n";
		echo "				</tr>\n";
	}
?>
			</tbody>
		</table><!-- //table -->
	</div><!-- //table-responsive wrapper -->
