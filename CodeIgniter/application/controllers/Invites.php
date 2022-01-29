<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Invites extends CI_Controller {

        public function __construct()
        {
            parent::__construct();
            $this->load->model('db_model');
            $this->load->helper('url');
        }

        public function afficher()
        {

            $data['titre'] = "Invites";
            $data['invites'] = $this->db_model->get_all_invites();

            //Chargement de la view haut.php
            $this->load->view('templates/haut');
            $this->load->view('templates/carousel');
            //Chargement de la view du milieu : page_accueil.php
            $this->load->view('invites', $data);
            //Chargement de la view bas.php
            $this->load->view('templates/bas');
        }
}
?>