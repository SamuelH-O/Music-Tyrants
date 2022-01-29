	<h3 class="section-heading text-center my-3"><?php echo $titre;?></h3>
	
	<div class="table-responsive"><!-- table-responsive wrapper -->
		<table class="table table-striped text-center"><!-- table -->
			<thead>
				<tr>
					<th scope="col">Nom</th>
					<th scope="col">Emplacement</th>
					<th scope="col">Services</th>
				</tr>
			</thead>
			<tbody>
<?php
	if ($lieux != NULL)
	{
		foreach ($lieux as $lie)
		{
			echo "				<tr>\n";
			echo "					<td>" . $lie['lie_nom'] . "</td>\n";
			echo "					<td>" . $lie['lie_adresse'] . "</td>\n";
			if ($lie['ser_nom'] != NULL)
			{
				echo "					<td>" . $lie['ser_nom'] . "</td>\n";
			}
			else
			{
				echo "					<td>Pas de service dans ce lieu !</td>\n";
			}
			echo "				</tr>\n\n";
		}
	}
	else
	{
		echo "				<tr>\n";
		echo "					<td scope=\"row\" colspan=\"3\">Aucun lieu pour l'instant !</td>\n";
		echo "				</tr>\n";
	}
?>
			</tbody>
		</table><!-- //table -->
	</div><!-- //table-responsive wrapper -->