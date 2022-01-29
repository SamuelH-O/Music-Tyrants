	<h3 class="section-heading text-center my-3"><?php echo $titre;?></h3>
	<div class="d-flex flex-wrap justify-content-around align-items-start align-content-around"><!-- flex -->
<?php
	if ($invites != NULL)
	{
		foreach ($invites as $inv)
		{
			echo "	<div class=\"card my-3\" style=\"max-width: 20rem;\"><!-- card -->\n";
			echo "		<img src=\"" . base_url() . "style/assets/images/invites_image/" . $inv["inv_image"] . "\" class=\"card-img-top\">\n";
			echo "		<div class=\"card-body p-2\"><!-- card-body -->\n";// card-body
			echo "			<h5 class=\"card-title\">" . $inv["inv_nom"] . "</h5>\n";
			echo "			<p class=\"card-text lh-2\">" . $inv["inv_biographie"] . "</p>\n";
			echo "		</div><!-- //card-body -->\n";// !card-body

			echo "		<ul class=\"list-group list-group-flush\"><!-- card-list -->\n";// card-list
			if ($inv["pos_text"] != NULL AND $inv["pos_date"] != NULL)
			{
				// Sépare les strings créé par les GROUP_CONCAT
				$arrayPosText = explode("/#", $inv["pos_text"]);
				$arrayPosDate = explode("/#", $inv["pos_date"]);
				for ($i = 0; $i < sizeof($arrayPosText); $i++)
				{
					echo "			<li class=\"list-group-item d-flex p-2 justify-content-between align-items-center\">" . $arrayPosText[$i] . "<small class=\"align-self-start text-end text-muted\">" . $arrayPosDate[$i] . "</small></li>\n";
				}
			}
			else
			{
				echo "			<li class=\"list-group-item d-flex p-2 justify-content-between align-items-center\">Pas de post pour cet invité !</li>\n";
			}
			echo "		</ul><!-- //card-list -->\n";// !card-list

			echo "		<div class=\"card-body p-2\"><!-- card-body -->\n";// card-body
			if ($inv["url_lien"] != NULL AND $inv["url_nom"] != NULL)
			{
				// Sépare les strings créé par les GROUP_CONCAT
				$arrayUrlNom = explode("/#", $inv["url_nom"]);
				$arrayUrlLien = explode(" ", $inv["url_lien"]);
				for ($i = 0; $i < sizeof($arrayUrlLien); $i++)
				{
					echo "			<a href=\"" . $arrayUrlLien[$i] ."\" class=\"card-link\">" . $arrayUrlNom[$i] . "</a>\n";
				}
			}
			else
			{
				echo "			<span>Pas de réseau social pour cet invité !</span>\n";
			}
			echo "		</div><!-- //card-body -->\n";// !card-body
			echo "	</div><!-- //card -->\n\n";// !card
		}
	}
	else
	{
		echo "	<h4 class=\"section-heading text-center my-3\">Aucun invité pour l'instant !</h4>\n";
	}
?>
	</div><!-- //flex -->