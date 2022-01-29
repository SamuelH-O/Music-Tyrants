<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Accueil extends CI_Controller {

        public function __construct()
        {
            parent::__construct();
            $this->load->model('db_model');
            $this->load->helper('url');
        }

        public function afficher()
        {

            $data['titre'] = "Actualités";
            $data['actualite'] = $this->db_model->get_all_actualite();
            $data2['isAccueil'] = true;

            //Chargement de la view haut.php
            $this->load->view('templates/haut');
            //Chargement de la view carousel.php
            $this->load->view('templates/carousel');
            //Chargement de la view du milieu : page_accueil.php
            $this->load->view('page_accueil', $data);
            //Chargement de la view bas.php
            $this->load->view('templates/bas', $data2);
        }
}
?>