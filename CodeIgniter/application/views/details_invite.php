<?php
	if ($animation != NULL)
	{
		// Si il y a une animation afficher les invités
		echo "	<h3 class=\"section-heading text-center my-3\">" . $titre . "</h3>\n";
		echo "	<div class=\"d-flex flex-wrap justify-content-around align-items-start align-content-around\"><!-- flex -->\n";// flex
		foreach ($animation as $anim)
		{
			echo "		<div class=\"card m-4\" style=\"max-width: 40rem;\"><!-- card -->\n";// card
			
			echo "			<img src=\"" . base_url() . "style/assets/images/invites_image/" . $anim["inv_image"] . "\" class=\"card-img-top\">\n";

			echo "			<div class=\"card-body p-2\"><!-- card-body -->\n";// card-body
			echo "				<h5 class=\"card-title\">" . $anim["inv_nom"] . "</h5>\n";
			echo "				<p class=\"card-text lh-2\">" . $anim["inv_biographie"] . "</p>\n";
			echo "			</div><!-- //card-body -->\n";// !card-body

			echo "			<ul class=\"list-group list-group-flush\">\n";
			if ($anim["pos_text"] != NULL AND $anim["pos_date"] != NULL)
			{
				// Sépare les strings créé par les GROUP_CONCAT
				$arrayPosText = explode("£££££", $anim["pos_text"]);
				$arrayPosDate = explode("£££££", $anim["pos_date"]);
				for ($i = 0; $i < sizeof($arrayPosText); $i++)
				{
					echo "				<li class=\"list-group-item d-flex p-2 justify-content-between align-items-center\">" . $arrayPosText[$i] . "<small class=\"align-self-start text-end text-muted\">" . $arrayPosDate[$i] . "</small></li>\n";
				}
			}
			else
			{
				echo "				<li class=\"list-group-item d-flex p-2 justify-content-between align-items-center\">Pas de post pour cet invité !</li>\n";
			}
			echo "			</ul>\n";

			echo "			<div class=\"card-body p-2\"><!-- card-body -->\n";// card-body
			if ($anim["url_lien"] != NULL AND $anim["url_nom"]!= NULL)
			{
				// Sépare les strings créé par les GROUP_CONCAT
				$arrayUrlNom = explode("£££££", $anim["url_nom"]);
				$arrayUrlLien = explode(" ", $anim["url_lien"]);
				for ($i = 0; $i < sizeof($arrayUrlLien); $i++)
				{
					echo "				<a href=\"" . $arrayUrlLien[$i] ."\" class=\"card-link\">" . $arrayUrlNom[$i] . "</a>\n";
				}
			}
			else
			{
				echo "				<span>Pas de réseau social pour cet invité !</span>\n";
			}
			echo "			</div><!-- //card-body -->\n";// !card-body

			echo "		</div><!-- //card -->\n";// !card
		}
		echo "	</div><!-- //flex -->\n";// !flex
	}
	else
	{
		echo "	<h3 class=\"section-heading text-center my-3\">Aucun invité</h3>\n";
	}
	echo "	<div class=\"text-center\">\n";
	echo "		<a class=\"btn btn-primary m-2\" href=\"" . $this->config->base_url() . "index.php/programmation/afficher\">Retour</a>\n";
	echo "	</div>\n";
?>