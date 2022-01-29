	<div class="text-center">
		<h3 class="my-3">Espace d'administration</h3>
		<h4 class="mb-2">Bienvenue <?php echo $this->session->userdata('username');?> !</h4>
	</div>

	<div class="text-center">
		<a class="btn btn-primary m-2" href="<?php echo $this->config->base_url(); ?>index.php/menu/deconnecter">Se déconnecter</a>
		<a class="btn btn-primary m-2" href="<?php echo $this->config->base_url(); ?>index.php/menu/administrateur_programation">Programmation</a>
		<a class="btn btn-primary m-2" href="<?php echo $this->config->base_url(); ?>index.php/compte/modifier">Changer de mot de passe</a>
	</div>

	<div class="col-9 border rounded text-center p-3 my-3 mx-auto"><!-- border -->
		<?php
			echo "<h5 class=\"mb-2\">Vos informations</h5>\n";
			if ($org_info != NULL)
			{
				foreach ($org_info as $orgInfo)
				{
					echo "			<h6 class=\"mb-2\">Votre prénom : " . $orgInfo['org_prenom'] . "</h6>\n";
					echo "			<h6 class=\"mb-2\">Votre nom : " . $orgInfo['org_nom'] . "</h6>\n";
					echo "			<h6 class=\"mb-2\">Votre adresse email : " . $orgInfo['org_email'] . "</h6>\n";
				}
			}
			else
			{
				echo "			<span>Impossible d'accéder à vos informations</span>\n";
			}
		?>
	</div><!-- //border -->