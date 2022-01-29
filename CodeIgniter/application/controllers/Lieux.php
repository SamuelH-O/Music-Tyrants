<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Lieux extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('db_model');
		$this->load->helper('url_helper');
	}

	public function afficher()
	{

		$data['titre'] = "Lieux/services";
		$data['lieux'] = $this->db_model->get_all_lieux();

		//Chargement de la view haut.php
		$this->load->view('templates/haut');
		//Chargement de la view carousel.php
		$this->load->view('templates/carousel');
		//Chargement de la view du milieu : page_accueil.php
		$this->load->view('lieux', $data);
		//Chargement de la view bas.php
		$this->load->view('templates/bas');
	}
}
?>