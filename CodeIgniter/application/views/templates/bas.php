
	<footer class="footer py-5 theme-bg-primary"><!-- footer -->
		<div class="container text-center"><!-- container -->
			
<?php
	if(isset($isAccueil))
	{
		// Affiche le bouton vers le formulaire pour ajouter un post
		echo "			<div class=\"d-grid d-flex justify-content-center\">";
		echo "				<a href=\"" . $this->config->base_url() . "index.php/posts/creer\" type=\"button\" class=\"btn btn-secondary rounded-3 mb-3\"><i class=\"fas fa-plus\"></i></a>";
		echo "			</div>";
	}
?>
			
			 <!--/* This template is free as long as you keep the footer attribution link. If you'd like to use the template without the attribution link, you can buy the commercial license via our website: themes.3rdwavemedia.com Thank you for your support. :) */-->
			<small class="copyright">Designed with <i class="fas fa-heart" style="color: #EC645E;"></i> by <a href="http://themes.3rdwavemedia.com" target="_blank">Xiaoying Riley</a> for developers</small>
			
		</div><!--//container-->	    
	</footer><!-- //footer -->
	
	<!-- Javascript -->          
	<script src="<?php echo base_url();?>style/assets/plugins/popper.min.js"></script>
	<script src="<?php echo base_url();?>style/assets/plugins/bootstrap/js/bootstrap.min.js"></script>  
	<script src="<?php echo base_url();?>style/assets/plugins/smoothscroll.min.js"></script>
	<script src="<?php echo base_url();?>style/assets/plugins/gumshoe/gumshoe.polyfills.js"></script> 
	<script src="<?php echo base_url();?>style/assets/js/main.js"></script>  

</body>
</html> 