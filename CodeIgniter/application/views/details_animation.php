	<h3 class="section-heading text-center my-3"><?php echo $titre . $animation->ani_nom;?></h3>
	<div class="container-fluid mb-3"><!-- container -->
		<div class="row row-cols-1 row-cols-md-3 g-4"><!-- row -->

			<div class="col"><!-- col -->
				<div class="card"><!-- card -->

					<div class="card-header"><i class="far fa-calendar-alt"></i> Date & Heure</div>

					<div class="card-body"><!-- card-body -->
						<div class="alert alert-primary text-center" role="alert"><?php echo mb_convert_case($animation->ani_etat, MB_CASE_TITLE, "UTF-8"); ?></div>
						<div class="d-flex flex-row justify-content-around">
							<?php
								// Création des objets DateTime pour convertir le format
								$dateDebut = new DateTime($animation->ani_horaire_debut);
								$dateFin = new DateTime($animation->ani_horaire_fin);
							?>
							<div>
								<strong>Début :</strong>
								<span><?php echo $dateDebut->format('d/m/Y H:i'); ?></span>
							</div>
							<div>
								<strong>Fin :</strong>
								<span><?php echo $dateFin->format('d/m/Y H:i'); ?></span>
							</div>
						</div>
					</div><!-- //card-body -->

				</div><!-- //card -->
			</div><!-- //col -->

			<div class="col"><!-- col -->
				<div class="card"><!-- card -->

					<div class="card-header"><i class="far fa-newspaper"></i> Présentation</div>

					<div class="card-body"><!-- card-body -->
						<p><?php echo $animation->ani_presentation; ?></p>
					</div><!-- //card-body -->

				</div><!-- //card -->
			</div><!-- //col -->

			<div class="col"><!-- col -->
				<div class="card"><!-- card -->

					<div class="card-header"><i class="far fa-map"></i> Emplacement</div>

					<div class="card-body"><!-- card-body -->
						<?php echo "<a href=\"" . $this->config->base_url() . "index.php/programation/details_lieux/" . $animation->lie_id . "\" class=\"text-center stretched-link\">" . $animation->lie_nom . "</a>\n";?>
					</div><!-- //card-body -->

				</div><!-- //card -->
			</div><!-- //col -->

			<div class="col"><!-- col -->
				<div class="card"><!-- card -->

					<div class="card-header"><i class="fas fa-music"></i> Invité.e.s</div>

					<div class="card-body"><!-- card-body -->
<?php
	// Sépare les strings créé par les GROUP_CONCAT
	$invNom = explode("£££££", $animation->inv_nom);
	$invId = explode("£££££", $animation->inv_id);
	for ($i=0; $i < count($invNom); $i++) {
		if ($i > 0) {
			echo ", ";
		}
		echo "<a href=\"" . $this->config->base_url() . "index.php/programation/details_invite/" . $invId[$i] . "\" class=\"text-center stretched-link\">" . $invNom[$i] . "</a>\n";
	}
?>
					</div><!-- //card-body -->

				</div><!-- //card -->
			</div><!-- //col -->

		</div><!-- //row -->
	</div><!-- //container -->
	<div class="text-center">
		<a class="btn btn-primary m-2" href="<?php echo $this->config->base_url(); ?>index.php/programmation/afficher">Retour</a>
	</div>