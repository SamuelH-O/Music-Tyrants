<?php
	defined('BASEPATH') OR exit('No direct script access allowed');
	class Posts extends CI_Controller 
	{
	 
		public function __construct()
		{
			parent::__construct();
			$this->load->model('db_model');
			$this->load->helper('url_helper');
		}

		public function creer()
		{
			$this->load->helper('form');
			$this->load->library('form_validation');

			$this->form_validation->set_rules('passID', 'Passport ID', 'required|regex_match[/([^ \/\\"\']+_[^ \/\\"\']+)/]');// Regex pour verifier la nomenclature
			$this->form_validation->set_rules('password', 'Mot de passe', 'required');
			$this->form_validation->set_rules('post', 'Post', 'required|max_length[140]');

			if ($this->form_validation->run() == FALSE)// Si les données ne sont pas valides recharger la page avec les erreurs CodeIgniter
			{
				$this->load->view('templates/haut');
				$this->load->view('posts_creer');
				$this->load->view('templates/bas');
			}
			else// Si les données passe la première verification
			{
				$passID = $this->input->post('passID');
				$password = $this->input->post('password');
				if($this->db_model->is_pass_valid($passID, $password))// Vérifie que l'id et le mot de passe sont valides
				{
					$post = $this->input->post('post');
					if($this->db_model->add_post($passID, $post))// Ajoute un post
					{
						$data['succesMsg'] = "Le post a bien été ajouté !";

						$this->load->view('templates/haut');
						$this->load->view('posts_creer', $data);
						$this->load->view('templates/bas');
					}
					else// Si le mot de passe ne peut pas être ajouté envoyer un message d'erreur
					{

						$data['errorMsg'] = "Impossible d'ajouter le post.";

						$this->load->view('templates/haut');
						$this->load->view('posts_creer', $data);
						$this->load->view('templates/bas');
					}
				}
				else// Si les identifiants ne sont pas valides envoyer une erreur
				{

					$data['errorMsg'] = "Code(s) erroné(s), aucun passeport trouvé !";

					$this->load->view('templates/haut');
					$this->load->view('posts_creer', $data);
					$this->load->view('templates/bas');
				}
			}
		}
	 
	}
?>
