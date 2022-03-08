# Music-Tyrants

## Description

Music Tyrants est un exemple d'implementation d'un site Bootstrap 5 Showroom de festival de music avec CodeIgniter V3.1.11. Le template utilisé : [DevConf](https://github.com/xriley/DevConf-Theme)

## Instalation

1. Placer le projet sur un serveur web supportant PHP 5.6 minimum
2. Organiser sa base de données comme sur le schéma ci-dessous ou importer le fichier à importer
3. Changer les paramètres de connexion dans CodeIgniter/application/config/database.php en fonction de votre serveur sql
4. Ajouter les Déclancheurs, Fonctions et Procédures SQL/PSM à la base de données

### Schéma relationnel
![Schéma relationnel](/sch%C3%A9ma%20relationnel.png)

### Déclancheurs SQL/PSM à ajouter à la base de données

**del_act_after_anim** supprime les actualités concernant l’animation qui est
supprimer :

	DELIMITER //
	CREATE TRIGGER del_act_after_anim BEFORE DELETE ON T_ANIMATION_ani 
	FOR EACH ROW
	BEGIN
		DECLARE id INT;
		SELECT act_id INTO id FROM T_ACTUALITE_act WHERE act_titre LIKE CONCAT('', '%', ani_nom, '%');
		DELETE FROM T_ACTUALITE_act WHERE act_id = id;
	END;
	// DELIMITER ;

**modif_anim** ajoute une actualité à chaque fois qu’une animation est modifier :

	DELIMITER //
	CREATE TRIGGER modif_anim AFTER UPDATE ON T_ANIMATION_ani
	FOR EACH ROW
	BEGIN
		IF (old.ani_horaire_debut != new.ani_horaire_debut) THEN
			INSERT INTO T_ACTUALITE_act (act_titre, act_contenu, act_date, act_statut, org_id) VALUES (CONCAT("Attention! ", old.ani_nom, " report de la date de début ", new.ani_horaire_debut), NULL, NOW(), 'P', 1);
		ELSEIF (old.ani_horaire_fin != new.ani_horaire_fin) THEN
			INSERT INTO T_ACTUALITE_act (act_titre, act_contenu, act_date, act_statut, org_id) VALUES (CONCAT("Attention! ", old.ani_nom, " report de la date de fin ", new.ani_horaire_fin), NULL, NOW(), 'P', 1);
		ELSEIF (old.ani_nom != new.ani_nom) THEN
			INSERT INTO T_ACTUALITE_act (act_titre, act_contenu, act_date, act_statut, org_id) VALUES (CONCAT("Attention! ", old.ani_nom, " changement du nom de l’animation ", new.ani_nom), NULL, NOW(), 'P', 1);
		ELSEIF (old.lie_id != new.lie_id) THEN
			INSERT INTO T_ACTUALITE_act (act_titre, act_contenu, act_date, act_statut, org_id) VALUES (CONCAT("Attention! ", old.ani_nom, " changement du lieu à ", (SELECT lie_nom FROM T_LIEU_lie WHERE lie_id = new.lie_id)), NULL, NOW(), 'P', 1);
		ELSE
			INSERT INTO T_ACTUALITE_act (act_titre, act_contenu, act_date, act_statut, org_id) VALUES ("MODIFICATIONS MAJEURES", CONCAT(old.ani_nom," cf récapitulatif des animations !"), NOW(), 'P', 1);
		END IF;
	END;
	//
	DELIMITER ;

**new_lieu** ajoute une actualité à chaque fois qu’un lieu est ajouté :
	
	DELIMITER //
	CREATE TRIGGER new_lieu BEFORE INSERT ON T_LIEU_lie 
	FOR EACH ROW
	BEGIN
		INSERT INTO T_ACTUALITE_act(act_titre, act_contenu, act_date, act_statut, org_id) VALUES ("lieu ajouté", new.lie_adresse, NOW(), 'P', 1);
	END;
	// DELIMITER ;

**new_obj_trouve**  ajoute une actualité à chaque fois qu’un objet est trouvé :

	DELIMITER //
	CREATE TRIGGER new_obj_trouve BEFORE INSERT ON T_OBJET_TROUVE_obj 
	FOR EACH ROW
	BEGIN
		INSERT INTO T_ACTUALITE_act(act_titre, act_contenu, act_date, act_statut, org_id) VALUES ("Objet trouvé", new.obj_nom, NOW(), 'P', 1);
	END;
	// DELIMITER ;

### Fonctions SQL/PSM à ajouter à la base de données

**new_obj_trouve**  retourne "à venir", "en cours" ou "passée" en fonction de l’id d’une animation passé en paramètre :

	DELIMITER //
	CREATE FUNCTION get_anim_etat(id INT) RETURNS TEXT CHARSET utf8 
	BEGIN
		DECLARE debut TYPE OF T_ANIMATION_ani.ani_horaire_debut;
		DECLARE fin TYPE OF T_ANIMATION_ani.ani_horaire_fin;
		SELECT ani_horaire_debut INTO debut FROM T_ANIMATION_ani WHERE ani_id = id;
		SELECT ani_horaire_fin INTO fin FROM T_ANIMATION_ani WHERE ani_id = id;
		IF now() < debut THEN
			RETURN "à venir";
		ELSEIF now() > debut AND now() < fin THEN
			RETURN "en cours";
		ELSE
			RETURN "passée";
		END IF;
	END;
	// DELIMITER ;

**get_invites** retourne la liste des invités en fonction de l’id d’une animation passé en paramètre :

	DELIMITER //
	CREATE FUNCTION get_invites(id INT) RETURNS VARCHAR(300) CHARSET utf8 
	BEGIN
		RETURN (SELECT GROUP_CONCAT(inv_nom) FROM T_ANIMATION_ani JOIN T_JOUE_jou USING(ani_id) JOIN T_INVITE_inv USING(inv_id) WHERE ani_id = id);
	END;
	// DELIMITER ;
	
**num_ticket** retourne le nombre de tickets :
	
	DELIMITER //
	CREATE FUNCTION num_ticket() RETURNS INT BEGIN
		RETURN (SELECT COUNT(tic_id) FROM T_TICKET_tic);
	END;
	// DELIMITER ;

### Procédures SQL/PSM à ajouter à la base de données

**add_post** ajoute un post :

	DELIMITER //
	CREATE PROCEDURE add_post (IN passID VARCHAR(60), IN post VARCHAR(140))
	BEGIN
		INSERT INTO T_POST_pos (pos_text, pos_date, pos_etat, pas_id) VALUES (post, NOW(), 'P', passID);
	END;
	// DELIMITER ;

**insert_act** ajoute une actualité pour l’ajout d’un invité :

	DELIMITER //
	CREATE PROCEDURE insert_act(IN id INT)
	BEGIN
		DECLARE TITRE VARCHAR(90);
		DECLARE CONTENU VARCHAR(300);
		SELECT CONCAT("Ajout d'invité(s) pour ", ani_nom) INTO TITRE FROM T_ANIMATION_ani WHERE ani_id = id;
		SELECT CONCAT(ani_nom, " commence à ", ani_horaire_debut, " et fini à ", ani_horaire_fin, " avec ", get_invites(id)) INTO CONTENU FROM T_ANIMATION_ani WHERE ani_id = id;
		INSERT INTO T_ACTUALITE_act(act_titre, act_contenu, act_date, act_statut, org_id) VALUES (TITRE, CONTENU, NOW(), 'P', 1);
	END;
	// DELIMITER ;

**nb_anim** affiche un compte rendu du nombre d’animations en fonction des états de get_anim_etat :

	DELIMITER //
	CREATE PROCEDURE nb_anim(OUT nbAnimVenir INT, OUT nbAnimCours INT, OUT nbAnimPassees INT)
	BEGIN
		SELECT COUNT(ani_id) INTO nbAnimPassees FROM T_ANIMATION_ani WHERE ani_horaire_fin < NOW();
		SELECT COUNT(ani_id) INTO nbAnimCours FROM T_ANIMATION_ani WHERE ani_horaire_debut < NOW() AND ani_horaire_fin > NOW();
		SELECT COUNT(ani_id) INTO nbAnimVenir FROM T_ANIMATION_ani WHERE ani_horaire_debut > NOW();
	END;
	// DELIMITER ;

**time_remaining** ajoute une actualite avec le temps restant en fonction de l’id d’une animation passé en paramètre :

	DELIMITER //
	CREATE PROCEDURE time_remaining(id INT)
	BEGIN
		DECLARE jours INT;
		SELECT (SELECT EXTRACT(DAY FROM ani_horaire_debut) FROM T_ANIMATION_ani WHERE ani_id = 1) -(SELECT EXTRACT(DAY FROM NOW()) FROM T_ANIMATION_ani WHERE ani_id = 1) INTO jours;
		INSERT INTO T_ACTUALITE_act(act_titre, act_contenu, act_date, act_statut, org_id) VALUES (CONCAT("Il rest ", STR(jours), " jour(s)"), "", now(), 'P', 1);
	END;
	// DELIMITER ;
