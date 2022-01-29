<?php
	if($animation != NULL)
	{
		echo "	<h3 class=\"section-heading text-center my-3\">" . $titre . $animation->lie_nom . "</h3>\n";
		echo "	<div class=\"container-fluid mb-3\"><!-- container -->\n";// container
		echo "		<div class=\"row row-cols-1 row-cols-md-2 g-4\"><!-- row -->\n";// row

		echo "			<div class=\"col\"><!-- col -->\n";// col
		echo "				<div class=\"card\"><!-- card -->\n";// card
		echo "					<div class=\"card-header\"><i class=\"fas fa-map-marked-alt\"></i> Position</div>\n";
		echo "					<div class=\"card-body\"><!-- card-body -->\n";// card-body
		echo "						<div class=\"d-flex flex-row justify-content-around\"><!-- flex -->\n";//flex

		$cords = explode(' - ', $animation->lie_adresse);// Sépare les deux coordonnés

		echo "							<div>\n";
		echo "								<strong>Longitude :</strong>\n";
		echo "								<span>" . $cords[0] . "</span>\n";
		echo "							</div>\n";
		echo "							<div>\n";
		echo "								<strong>Latitude :</strong>\n";
		echo "								<span>" . $cords[1] . "</span>\n";
		echo "							</div>\n";
		echo "						</div><!-- //flex -->\n";// !flex
		echo "					</div><!-- //card-body -->\n";// !card-body
		echo "				</div><!-- //card -->\n";// !card
		echo "			</div><!-- //col -->\n";// !col


		echo "			<div class=\"col\"><!-- col -->\n";// col
		echo "				<div class=\"card\"><!-- card -->\n";// card
		echo "					<div class=\"card-header\"><i class=\"fas fa-info-circle\"></i> Service.s</div>\n";
		echo "					<div class=\"card-body\"><!-- card-body -->\n";// card-body
		echo "						<ul class=\"list-group list-group-flush text-center\">\n";

		$serNom = explode("£££££", $animation->ser_nom);// Sépare les strings créé par les GROUP_CONCAT
		foreach ($serNom as $sN)
		{
			echo "							<li class=\"list-group-item\">" . $sN . "</li>\n";
		}

		echo "						</ul>\n";
		echo "					</div><!-- //card-body -->\n";// !card-body
		echo "				</div><!-- //card -->\n";// !card
		echo "			</div><!-- //col -->\n";// !col

		echo "		</div><!-- //row -->\n";// !row
		echo "	</div><!-- //container -->\n";// !container
	}
	else
	{
		echo "	<h3 class=\"section-heading text-center my-3\">Aucun lieu</h4>\n";
	}
	echo "	<div class=\"text-center\">\n";
	echo "		<a class=\"btn btn-primary m-2\" href=\"" . $this->config->base_url() . "index.php/programmation/afficher\">Retour</a>\n";
	echo "	</div>\n";
?>