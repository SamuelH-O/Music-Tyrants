<?php
	defined('BASEPATH') OR exit('No direct script access allowed');
	class Compte extends CI_Controller 
	{
	 
		public function __construct()
		{
			parent::__construct();
			$this->load->model('db_model');
			$this->load->helper('url_helper');
		}

		// Inactif
		/*public function creer()//inactif
		{
			if ($this->session->userdata('username'))
			{
				if($this->db_model->is_org($this->session->userdata('username')))
				{
				    $this->load->helper('form');
					$this->load->library('form_validation');
					$this->form_validation->set_rules('id', 'id', 'required');
					$this->form_validation->set_rules('mdp', 'mdp', 'required');
					if ($this->form_validation->run() == FALSE)
					{
						$this->load->view('templates/haut');
						$this->load->view('compte_creer');
						$this->load->view('templates/bas');
					}
					else
					{
						if($this->db_model->set_compte())
						{
							$this->load->view('templates/haut');
							$this->load->view('compte_succes');
							$this->load->view('templates/bas');
						}
						else
						{
							$this->load->view('templates/haut');
							$this->load->view('compte_creer');
							$this->load->view('templates/bas');
						}
					}
				}
				else
				{
					redirect("/menu/invite");
				}
			}
			else
			{
				redirect("/");
			}
		}*/

		public function connecter()
		{
			$this->load->helper('form');
			$this->load->library('form_validation');
			$this->form_validation->set_rules('pseudo', 'Pseudo', 'required');
			$this->form_validation->set_rules('mdp', 'Mot de passe', 'required|min_length[8]');
			      
			if($this->form_validation->run() == FALSE)// Si les données ne sont pas valides recharger la page avec les erreurs CodeIgniter
			{
				$this->load->view('templates/haut');
				$this->load->view('compte_connecter');
				$this->load->view('templates/bas');
			}
			else// Sinon connecter le compte
			{
				$username = $this->input->post('pseudo');  
				$password = $this->input->post('mdp'); 
				if($this->db_model->connect_compte($username, $password))// Essaie de connecter le compte
				{
					$session_data = array('username'  =>  $username);
					$this->session->set_userdata($session_data);
					if($this->db_model->is_org($username))// Si le compte est un organisateur afficher le menu administrateur
					{
						redirect("/menu/administrateur");
					}
					else// Sinon afficher le menu invité
					{
						redirect("/menu/invite");
					}
				}
				else// Si le compte ne peut pas être connecté revoyer une erreur 
				{

					$data['errorMsg'] = "Au moins un des champs n'est pas correct.";

					$this->load->view('templates/haut');
					$this->load->view('compte_connecter', $data);//add msg
					$this->load->view('templates/bas');
				}
			}
		}

		public function modifier()
		{
			if ($this->session->userdata('username'))// Si un compte est connecté
			{
				$this->load->helper('form');
				$this->load->library('form_validation');

				$this->form_validation->set_rules('vieuxMDP', 'Ancien mot de passe', 'required');
				$this->form_validation->set_rules('nouveauMDP1', 'Nouveau mot de passe', 'required|min_length[8]');
				$this->form_validation->set_rules('nouveauMDP2', 'Confirmation du nouveau mot de passe', 'required|matches[nouveauMDP1]|min_length[8]');

				if($this->form_validation->run() == FALSE)// Si les données ne sont pas valides recharger la page avec les erreurs CodeIgniter
				{
					$this->load->view('templates/haut');
					$this->load->view('compte_modifier');
					$this->load->view('templates/bas');
				}
				else// Sinon modifier le mot de passe
				{
					if($this->db_model->modify_password($this->session->userdata('username'), $newPassword))// Essaie de changer le mot de pass
					{
						$data['succesMsg'] = "Le mot de passe a bien été changé.";

						$this->load->view('templates/haut');
						$this->load->view('compte_modifier', $data);
						$this->load->view('templates/bas');
					}
					else// Si le mot de passe ne peut pas être changé revoyer une erreur 
					{
						$data['errorMsg'] = "Au moins un des champs n'est pas correct.";

						$this->load->view('templates/haut');
						$this->load->view('compte_modifier', $data);
						$this->load->view('templates/bas');
					}
				}
			}
			else
			{
				redirect("/");
			}
		}

		// Inactif
		/*public function lister()//inactif
		{
			$data['titre'] = 'Liste des pseudos :';
			$data['pseudos'] = $this->db_model->get_all_compte();

			$this->load->view('templates/haut');
			$this->load->view('templates/carousel');
			$this->load->view('compte_liste', $data);
			$this->load->view('templates/bas');
		}*/
	 
	}
?>
