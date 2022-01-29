	<div id="hero-block" class="hero-block">
		<div id="hero-carousel" class="hero-carousel carousel carousel-fade slide" data-ride="carousel" data-bs-ride="carousel" data-bs-interval="10000">
			<div class="carousel-inner">
				<div class="carousel-item-1 carousel-item active">
				</div>
				<div class="carousel-item-2 carousel-item">
				</div>
				<div class="carousel-item-3 carousel-item">
				</div>
			</div>
		</div>
		<div class="hero-block-mask"></div>
		<div class="container">
			<div class="hero-text-block">
				<?php
					$festInfoObj = json_decode(file_get_contents("style/assets/info.json"));
				?>
				<h1 class="hero-heading mb-2"><?php echo $festInfoObj->nom;?></h1>
				<div class="hero-meta mb-3"><i class="far fa-calendar-alt me-2"></i><?php echo date("d/m/y", strtotime($festInfoObj->date_debut)); ?><i class="fas fa-map-marker-alt mx-2"></i><?php echo $festInfoObj->localisation ?></div>
				<div class="hero-cta"><a class="btn btn-primary btn-lg" href="https://themes.3rdwavemedia.com/bootstrap-templates/startup/devconf-free-bootstrap-4-conference-template-for-tech-conferences-and-events/" target="_blank">Billetterie</a></div>
				
			</div><!--//hero-text-block-->
		</div><!--//container-->

	</div><!--//hero-block-->
