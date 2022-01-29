<!DOCTYPE html>
<html lang="fr"> 
<head>
	<title>Music Tyrants 2021</title>
	
	<!-- Meta -->
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="description" content="Bootstrap 5 Tech Conference Template">
	<meta name="author" content="Xiaoying Riley at 3rd Wave Media">    
	<link rel="shortcut icon" href="<?php echo base_url();?>style/favicon.ico"> 
	
	<!-- Google Font -->
	<link href="https://fonts.googleapis.com/css?family=Montserrat:600,700,800|Roboto:300,400,700&display=swap" rel="stylesheet">
	
	<!-- FontAwesome JS-->
	<script defer src="<?php echo base_url();?>style/assets/fontawesome/js/all.min.js"></script>

	<!-- Theme CSS -->  
	<link id="theme-style" rel="stylesheet" href="<?php echo base_url();?>style/assets/css/theme.css">
</head>

<body>    
	<header id="header" class="header sticky-top"><!--header--> 
		<div class="branding"><!--branding-->
			<div class="container-fluid"><!--container-->
				<nav class="main-nav navbar navbar-expand-lg"><!--main-nav-->
					<div class="site-logo"><a href="<?php echo $this->config->base_url(); ?>"><i class="fas fa-compact-disc logo-icon"></i></a></div>
					
					<button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navigation" aria-controls="navigation" aria-expanded="false" aria-label="Toggle navigation">
						<span class="navbar-toggler-icon"></span>
					</button>
					
					<div id="navigation" class="navbar-collapse collapse justify-content-lg-end me-lg-3"><!--navabr-collapse-->
						<ul class="nav navbar-nav text-center"><!--nav-->
							<li class="nav-item"><a class="nav-link" href="<?php echo $this->config->base_url(); ?>">Accueil</a></li>                                              
							<li class="nav-item"><a class="nav-link" href="<?php echo $this->config->base_url(); ?>index.php/invites/afficher">Invités</a></li>
							<li class="nav-item"><a class="nav-link" href="<?php echo $this->config->base_url(); ?>index.php/programmation/afficher">Programmation</a></li>
							<li class="nav-item"><a class="nav-link" href="<?php echo $this->config->base_url(); ?>index.php/lieux/afficher">Lieux/services</a></li>
<?php
	if ($this->session->userdata('username'))
	{
		if ($this->db_model->is_org($this->session->userdata('username')))
		{
			// Si un administrateur est connecté afficher le bouton compte vers le menu admin
			echo "							<li class=\"nav-item\"><div class=\"navbar-btn\"><a class=\"btn btn-secondary\" href=\"" . $this->config->base_url() . "index.php/menu/administrateur\">Compte</a></div></li>";
		}
		else
		{
			// Si un invite est connecté afficher le bouton compte vers le menu invité
			echo "							<li class=\"nav-item\"><div class=\"navbar-btn\"><a class=\"btn btn-secondary\" href=\"" . $this->config->base_url() . "index.php/menu/invite\">Compte</a></div></li>";
		}
	}
	else
	{
		// Si aucun compte est connecté afficher le bouton de connexion
		echo "							<li class=\"nav-item\"><div class=\"navbar-btn\"><a class=\"btn btn-secondary\" href=\"" . $this->config->base_url() . "index.php/compte/connecter\">Connexion</a></div></li>";
	}
?>
						</ul><!--//nav-->
					</div><!--//navabr-collapse-->

				</nav><!--//main-nav-->
				
			</div><!--//container-->
		</div><!--//branding-->
	</header><!--//header-->
