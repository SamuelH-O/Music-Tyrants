<?php
	defined('BASEPATH') OR exit('No direct script access allowed');
	class Menu extends CI_Controller 
	{
		public function __construct()
		{
			parent::__construct();
			$this->load->model('db_model');
			$this->load->helper('url_helper');
		}

		public function invite()
		{
			if($this->session->userdata('username'))// Si un compte est connecté
			{
				if($this->db_model->is_org($this->session->userdata('username')))// Si le compte est un organisateur rediriger vers le menu administrateur
				{
					redirect("/menu/administrateur");
				}
				else// Sinon afficher le menu invité
				{
	            	$data['invite_info'] = $this->db_model->get_invite_info($this->session->userdata('username'));
	            	$data['anim_info'] = $this->db_model->get_anim_info_by_invite($this->session->userdata('username'));

					$this->load->view('templates/haut');
					$this->load->view('menu_invite', $data);
					$this->load->view('templates/bas');
				}
			}
			else// Si le compte n'est pas connecté rediriger vers la page d'acueil
			{
				redirect("/");
			}
		}

		public function invite_passeports()
		{
			if($this->session->userdata('username'))// Si un compte est connecté
			{
				if($this->db_model->is_org($this->session->userdata('username')))// Si le compte est un organisateur rediriger vers le menu administrateur
				{
					redirect("/menu/administrateur");
				}
				else// Sinon afficher la page
				{
					$data['titre'] = "Passeports & Posts";
					$data['passeports'] = $this->db_model->get_invite_passports($this->session->userdata('username'));

					$this->load->view('templates/haut');
					$this->load->view('menu_invite_passeports', $data);
					$this->load->view('templates/bas');
				}
			}
			else// Si le compte n'est pas connecté rediriger vers la page d'acueil
			{
				redirect("/");
			}
		}

		public function administrateur()
		{
			if($this->session->userdata('username'))// Si un compte est connecté
			{
				if($this->db_model->is_org($this->session->userdata('username')))// Si le compte est un organisateur afficher la page
				{
					$data['org_info'] = $this->db_model->get_org_info($this->session->userdata('username'));
					$data['programmation'] = $this->db_model->get_programmation();

					$this->load->view('templates/haut');
					$this->load->view('menu_administrateur', $data);
					$this->load->view('templates/bas');
				}
				else// Sinon rediriger vers menu invité
				{
					redirect("/menu/invite");
				}
			}
			else// Si le compte n'est pas connecté rediriger vers la page d'acueil
			{
				redirect("/");
			}
		}

		public function administrateur_programation()
		{
			$this->load->helper('form');
			if($this->session->userdata('username'))// Si un compte est connecté
			{
				if($this->db_model->is_org($this->session->userdata('username')))// Si le compte est un organisateur afficher la page
				{
					$data['programmation'] = $this->db_model->get_programmation();

					$this->load->view('templates/haut');
					$this->load->view('menu_admin_programation', $data);
					$this->load->view('templates/bas');
				}
				else// Sinon rediriger vers menu invité
				{
					redirect("/menu/invite");
				}
			}
			else// Si le compte n'est pas connecté rediriger vers la page d'acueil
			{
				redirect("/");
			}
		}

		public function supr_anim()
		{
			$id = $this->input->post('idOfAnim');
			$this->db_model->del_anim($id);
			redirect($this->config->base_url() . "index.php/menu/administrateur");
		}

		public function deconnecter()
		{
			if($this->session->userdata('username'))// Si un compte est connecté
			{
				$this->session->sess_destroy();
			}
			redirect("/");
		}
	}
?>