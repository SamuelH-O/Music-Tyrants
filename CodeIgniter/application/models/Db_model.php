<?php
class Db_model extends CI_Model
{
    public function __construct()
    {
        $this->load->database();
    }

    // Inactif
    /*public function get_all_compte()
    {
        $query = $this->db->query("SELECT cpt_pseudo FROM T_COMPTE_cpt;");
        return $query->result_array();
    }

    public function set_compte()
    {
        $this->load->helper('url');
        $username = $this->input->post('id');
        $password = $this->input->post('mdp');
        $salt = "OnRajouteDuSelPourAllongerleMDP123!!45678__Test";
        $hashedPassword = hash("sha256", $salt.$mdp);
        $req = "INSERT INTO T_COMPTE_cpt VALUES (\"".$username."\",\"".$hashedPassword."\", \"A\");";
        $query = $this->db->query($req);
        return ($query);
    }*/


    // Controller Compte
    public function connect_compte($username, $password)
    {
        if(strpbrk($username, '\\\'"') != false)
        {
            return false;
        }
        $salt = "OnRajouteDuSelPourAllongerleMDP123!!45678__Test";
        $hashedPassword = hash("sha256", $salt.$password);

        $query = $this->db->select('cpt_pseudo, cpt_mdp')
            ->where('cpt_pseudo', $username)
            ->where('cpt_mdp', $hashedPassword)
            ->where('cpt_etat', 'A')
        ->get('T_COMPTE_cpt');

        // Vérifie si il y a une réponse
        if($query->num_rows() == 1)
        {
            // Vérifie si la case est correct
            $row = $query->row();
            if($row->cpt_pseudo == $username)
            {
                return true; 
            }
            else
            {
                return false;
            }
        }  
        else
        {  
            return false;
        }
    }

    // Controller Posts
    public function is_pass_valid($passID, $password)
    {
        $salt = "OnRajouteDuSelPourAllongerleMDP123!!45678__Test";
        $hashedPassword = hash("sha256", $salt.$password);

        $query = $this->db->select('pas_id')
            ->where('pas_id', $passID)
            ->where('pas_mdp', $hashedPassword)
            ->where('pas_etat', 'A')
        ->get('T_PASSEPORT_pas');

        // Vérifie si il y a une réponse
        if($query->num_rows() == 1)
        {
            // Vérifie si la case est correct
            $row = $query->row();
            if($row->pas_id == $passID)
            {
                return true; 
            }
            else
            {
                return false;
            }
        }
        else
        {
            return false;
        }
    }

    // Controller Posts
    public function add_post($passID, $postText)
    {
        $query = $this->db->query("CALL add_post(\"" . $passID . "\", \"" . $postText . "\");");
        return ($query);
    }

    // Controller Compte
    public function modify_password($username, $password)
    {
        $salt = "OnRajouteDuSelPourAllongerleMDP123!!45678__Test";
        $hashedPassword = hash("sha256", $salt.$password);

        $this->db = $this->db->set('cpt_mdp', $username)
            ->set('cpt_pseudo', $hashedPassword)
        ->update('T_COMPTE_cpt');

        return true;
    }

    // Controller Compte, controller Menu & view haut
    public function is_org($username)
    {
        $query = $this->db->select('org_id')
            ->where('cpt_pseudo', $username)
        ->get('T_ORGANISATEUR_org');

        if($query->num_rows() > 0)  
        {  
            return true;
        }  
        else  
        {  
            return false;
        }  
    }

    // Controller Menu
    public function del_anim($id)
    {
        $this->db = $this->db->where('ani_id', $id)
        ->delete('T_JOUE_jou');

        $this->db = $this->db->where('ani_id', $id)
        ->delete('T_ANIMATION_ani');
    }

    // Controller Menu
    public function get_invite_info($username)
    {
        $query = $this->db->select('inv_nom, inv_biographie, inv_discipline, inv_image')
            ->where('cpt_pseudo', $username)
        ->get('T_INVITE_inv');

        return $query->result_array();
    }

    // Controller Menu
    public function get_invite_passports($username)
    {
        $query = $this->db->select("pas_id, pas_etat, GROUP_CONCAT(DISTINCT pos_text SEPARATOR \"£££££\") AS pos_text, GROUP_CONCAT(DISTINCT pos_date SEPARATOR \"£££££\") AS pos_date, GROUP_CONCAT(pos_etat SEPARATOR \"£££££\") AS pos_etat")
            ->join('T_PASSEPORT_pas', 'T_PASSEPORT_pas.inv_id = T_INVITE_inv.inv_id')
            ->join('T_POST_pos', 'T_POST_pos.pas_id = T_PASSEPORT_pas.pas_id')
            ->where('cpt_pseudo', $username)
            ->group_by('T_PASSEPORT_pas.pas_id')
        ->get('T_INVITE_inv');

        return $query->result_array();
    }

    // Controller Menu
    public function get_anim_info_by_invite($username)
    {
        $query = $this->db->select('ani_nom, ani_horaire_debut, ani_horaire_fin, lie_nom')
            ->join('T_JOUE_jou', 'T_JOUE_jou.ani_id = T_ANIMATION_ani.ani_id')
            ->join('T_INVITE_inv', 'T_INVITE_inv.inv_id = T_JOUE_jou.inv_id')
            ->join('T_LIEU_lie', 'T_LIEU_lie.lie_id = T_ANIMATION_ani.lie_id', 'left')
            ->where('cpt_pseudo', $username)
        ->get('T_ANIMATION_ani');

        return $query->result_array();
    }

    // Controller Menu
    public function get_org_info($username)
    {
        $query = $this->db->select('org_nom, org_prenom, org_email')
            ->where('cpt_pseudo', $username)
        ->get('T_ORGANISATEUR_org');

        return $query->result_array();
    }

    // Controller Accueil
    public function get_all_actualite()
    {
        $query = $this->db->select('act_titre, act_contenu, act_date, CONCAT(org_prenom, \' \', org_nom) AS org_prenom_nom')
            ->join('T_ORGANISATEUR_org', 'T_ORGANISATEUR_org.org_id = T_ACTUALITE_act.org_id')
            ->where('act_statut', 'P')
            ->order_by('T_ACTUALITE_act.act_date', 'DESC')
        ->get('T_ACTUALITE_act');

        return $query->result_array();
    }

    // Controller Menu & controller Programation
    public function get_programmation()
    {
        $query = $this->db->select('T_ANIMATION_ani.ani_id, get_anim_etat(T_ANIMATION_ani.ani_id) AS ani_etat, ani_nom, ani_horaire_debut, ani_horaire_fin, GROUP_CONCAT(T_INVITE_inv.inv_nom ORDER BY T_INVITE_inv.inv_nom SEPARATOR \', \') AS invites, lie_nom')
            ->join('T_LIEU_lie', 'T_LIEU_lie.lie_id = T_ANIMATION_ani.lie_id', 'left')
            ->join('T_JOUE_jou', 'T_JOUE_jou.ani_id = T_ANIMATION_ani.ani_id', 'left')
            ->join('T_INVITE_inv', 'T_INVITE_inv.inv_id = T_JOUE_jou.inv_id', 'left')
            ->group_by('T_ANIMATION_ani.ani_nom')
            ->order_by('FIELD(ani_etat, \'passée\', \'en cours\', \'à venir\'), T_ANIMATION_ani.ani_horaire_debut')
        ->get('T_ANIMATION_ani');

        return $query->result_array();
    }

    // Controller Programation
    public function get_anim_detail($id)
    {
        $query = $this->db->select('ani_nom, get_anim_etat(ani_id) AS ani_etat, ani_presentation, ani_horaire_debut, ani_horaire_fin, GROUP_CONCAT(inv_nom ORDER BY inv_nom SEPARATOR \'£££££\') AS inv_nom, GROUP_CONCAT(inv_id ORDER BY inv_nom SEPARATOR \'£££££\') AS inv_id, lie_nom, lie_id')
            ->join('T_LIEU_lie', 'T_LIEU_lie.ani_id = T_ANIMATION_ani.ani_id')
            ->join('T_JOUE_jou', 'T_JOUE_jou.ani_id = T_LIEU_lie.ani_id')
            ->join('T_INVITE_inv', 'T_INVITE_inv.inv_id = T_ANIMATION_ani.inv_id')
            ->where('ani_id', $id)
            ->group_by('T_ANIMATION_ani.ani_id')
        ->get('T_ANIMATION_ani');

        return $query->row();
    }

    // Controller Programation
    public function get_anim_lieu($id)
    {
        $query = $this->db->select('lie_id, lie_nom, lie_adresse, GROUP_CONCAT(ser_nom SEPARATOR \'£££££\') AS ser_nom')
            ->join('T_LIEU_lie', 'T_LIEU_lie.lie_id = T_ANIMATION_ani.lie_id')
            ->join('T_SERVICE_ser', 'T_SERVICE_ser.lie_id = T_LIEU_lie.lie_id')
            ->where('ani_id', $id)
            ->group_by('T_ANIMATION_ani.ani_id')
        ->get('T_ANIMATION_ani');

        return $query->row();
    }

    // Controller Programation
    public function get_anim_invite($id)
    {
        $query = $this->db->select('inv_image, inv_nom, inv_biographie, GROUP_CONCAT(DISTINCT pos_text ORDER BY pos_date DESC SEPARATOR \'£££££\') AS pos_text, GROUP_CONCAT(DISTINCT pos_date ORDER BY pos_date DESC SEPARATOR \'£££££\') AS pos_date , GROUP_CONCAT(DISTINCT url_lien ORDER BY url_nom SEPARATOR \' \') AS url_lien, GROUP_CONCAT(DISTINCT url_nom ORDER BY url_nom SEPARATOR \'£££££\') AS url_nom')
            ->join('T_JOUE_jou', 'T_JOUE_jou.ani_id = T_ANIMATION_ani.ani_id')
            ->join('T_INVITE_inv', 'T_INVITE_inv.inv_id = T_JOUE_jou.inv_id')
            ->join('T_A_POUR_pou', 'T_A_POUR_pou.inv_id = T_INVITE_inv.inv_id', 'left')
            ->join('T_URL_url', 'T_URL_url.url_id = T_A_POUR_pou.url_id', 'left')
            ->join('T_PASSEPORT_pas', 'T_PASSEPORT_pas.inv_id = T_INVITE_inv.inv_id', 'left')
            ->join('T_POST_pos', 'T_POST_pos.pas_id = T_PASSEPORT_pas.pas_id', 'left')
            ->group_start()
                ->where('pos_etat', 'P')
                ->or_where('pos_etat IS NULL', null, false)
            ->group_end()
            ->where('ani_id', $id)
            ->group_by('T_INVITE_inv.inv_id')
            ->order_by('T_INVITE_inv.inv_nom')
        ->get('T_ANIMATION_ani');

        return $query->result_array();
    }

    // Controller Invites
    public function get_all_invites()
    {
        $query = $this->db->select('inv_image, inv_nom, inv_biographie, GROUP_CONCAT(DISTINCT pos_text ORDER BY pos_date DESC SEPARATOR \'/#\' LIMIT 3) AS pos_text, GROUP_CONCAT(DISTINCT pos_date ORDER BY pos_date DESC SEPARATOR \'/#\' LIMIT 3) AS pos_date , GROUP_CONCAT(DISTINCT url_lien ORDER BY url_nom SEPARATOR \' \') AS url_lien, GROUP_CONCAT(DISTINCT url_nom ORDER BY url_nom SEPARATOR \'/#\') AS url_nom')
            ->join('T_A_POUR_pou', 'T_A_POUR_pou.inv_id = T_INVITE_inv.inv_id', 'left')
            ->join('T_URL_url', 'T_URL_url.url_id = T_A_POUR_pou.url_id', 'left')
            ->join('T_PASSEPORT_pas', 'T_PASSEPORT_pas.inv_id = T_INVITE_inv.inv_id', 'left')
            ->join('T_POST_pos', 'T_POST_pos.pas_id = T_PASSEPORT_pas.pas_id', 'left')
            ->where('pos_etat', 'P')
            ->or_where('pos_etat IS NULL', null, false)
            ->group_by('T_INVITE_inv.inv_id')
            ->order_by('T_INVITE_inv.inv_nom')
        ->get('T_INVITE_inv');

        return $query->result_array();
    }

    // Controller Lieux
    public function get_all_lieux()
    {
        $query = $this->db->select('lie_nom, lie_adresse, GROUP_CONCAT(ser_nom ORDER BY ser_nom SEPARATOR \', \') AS ser_nom')
            ->join('T_SERVICE_ser', 'T_SERVICE_ser.lie_id = T_LIEU_lie.lie_id', 'left')
            ->group_by('T_LIEU_lie.lie_id')
        ->get('T_LIEU_lie');

        return $query->result_array();
    }
}