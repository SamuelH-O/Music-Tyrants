<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Programmation extends CI_Controller 
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('db_model');
        $this->load->helper('url');
    }

    public function afficher()
    {

        $data['titre'] = "Programmation";
        $data['programmation'] = $this->db_model->get_programmation();

        //Chargement de la view haut.php
        $this->load->view('templates/haut');
        //Chargement de la view carousel.php
        $this->load->view('templates/carousel');
        //Chargement de la view du milieu : page_accueil.php
        $this->load->view('programmation', $data);
        //Chargement de la view bas.php
        $this->load->view('templates/bas');
    }

    public function details_animation($id = FALSE)
    {
        if($id == FALSE || !is_numeric($id))// Si il n'y a pas d'id en paramètre rediriger vers la page d'accueil
        {
            redirect('/');
        }
        else
        {
            $data['titre'] = "Détails Animation : ";
            $data['animation'] = $this->db_model->get_anim_detail($id);

            //Chargement de la view haut.php
            $this->load->view('templates/haut');
            //Chargement de la view carousel.php
            $this->load->view('templates/carousel');
            //Chargement de la view du milieu : page_accueil.php
            $this->load->view('details_animation', $data);
            //Chargement de la view bas.php
            $this->load->view('templates/bas');
        }
    }

    public function details_lieu($id = FALSE)
    {
        if($id == FALSE || !is_numeric($id))// Si il n'y a pas d'id en paramètre rediriger vers la page d'accueil
        {
            redirect('/');
        }
        else
        {
            $data['titre'] = "Détails Lieu : ";
            $data['animation'] = $this->db_model->get_anim_lieu($id);

            //Chargement de la view haut.php
            $this->load->view('templates/haut');
            //Chargement de la view carousel.php
            $this->load->view('templates/carousel');
            //Chargement de la view du milieu : page_accueil.php
            $this->load->view('details_lieu', $data);
            //Chargement de la view bas.php
            $this->load->view('templates/bas');
        }
    }

    public function details_invite($id = FALSE)
    {
        if($id == FALSE || !is_numeric($id))// Si il n'y a pas d'id en paramètre rediriger vers la page d'accueil
        {
            redirect('/');
        }
        else
        {
            $data['titre'] = "Détails Lieu";
            $data['animation'] = $this->db_model->get_anim_invite($id);

            //Chargement de la view haut.php
            $this->load->view('templates/haut');
            //Chargement de la view carousel.php
            $this->load->view('templates/carousel');
            //Chargement de la view du milieu : page_accueil.php
            $this->load->view('details_invite', $data);
            //Chargement de la view bas.php
            $this->load->view('templates/bas');
        }
    }
}
?>