<?php
defined("BASEPATH") or exit("No direct script access allowed");// inactif
class Actualite extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model("db_model");
        $this->load->helper("url_helper");
    }

    public function afficher($numero = FALSE)
    {
    	if ($numero==FALSE) 
    	{ $url=base_url(); header("Location:$url");}
    	else
		{
			$data["titre"] = "Actualité :";
    		$data["actu"] = $this->db_model->get_actualite($numero);
		}

        $this->load->view("templates/haut");
        $this->load->view('templates/carousel');
        $this->load->view("actualite_afficher.php", $data);
        $this->load->view("templates/bas");
    }
}
