/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

DELIMITER //
--
-- Procedures
--
CREATE PROCEDURE add_post (IN passID VARCHAR(60), IN post VARCHAR(140))
BEGIN
	INSERT INTO T_POST_pos (pos_text, pos_date, pos_etat, pas_id) VALUES (post, NOW(), 'P', passID);
END;

BEGIN
	DECLARE TITRE VARCHAR(90);
	DECLARE CONTENU VARCHAR(300);
	SELECT CONCAT("Ajout d'invité(s) pour ", ani_nom) INTO TITRE FROM T_ANIMATION_ani WHERE ani_id = id;
	SELECT CONCAT(ani_nom, " commence à ", ani_horaire_debut, " et fini à ", ani_horaire_fin, " avec ", get_invites(id)) INTO CONTENU FROM T_ANIMATION_ani WHERE ani_id = id;
	INSERT INTO T_ACTUALITE_act(act_titre, act_contenu, act_date, act_statut, org_id) VALUES (TITRE, CONTENU, NOW(), 'P', 1);
END;

CREATE PROCEDURE nb_anim(OUT nbAnimVenir INT, OUT nbAnimCours INT, OUT nbAnimPassees INT)
BEGIN
	SELECT COUNT(ani_id) INTO nbAnimPassees FROM T_ANIMATION_ani WHERE ani_horaire_fin < NOW();
	SELECT COUNT(ani_id) INTO nbAnimCours FROM T_ANIMATION_ani WHERE ani_horaire_debut < NOW() AND ani_horaire_fin > NOW();
	SELECT COUNT(ani_id) INTO nbAnimVenir FROM T_ANIMATION_ani WHERE ani_horaire_debut > NOW();
END;

CREATE PROCEDURE time_remaining(id INT)
BEGIN
	DECLARE jours INT;
	SELECT (SELECT EXTRACT(DAY FROM ani_horaire_debut) FROM T_ANIMATION_ani WHERE ani_id = 1) -(SELECT EXTRACT(DAY FROM NOW()) FROM T_ANIMATION_ani WHERE ani_id = 1) INTO jours;
	INSERT INTO T_ACTUALITE_act(act_titre, act_contenu, act_date, act_statut, org_id) VALUES (CONCAT("Il rest ", STR(jours), " jour(s)"), "", now(), 'P', 1);
END;

--
-- Functions
--
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

CREATE FUNCTION get_invites(id INT) RETURNS VARCHAR(300) CHARSET utf8 
BEGIN
	RETURN (SELECT GROUP_CONCAT(inv_nom) FROM T_ANIMATION_ani JOIN T_JOUE_jou USING(ani_id) JOIN T_INVITE_inv USING(inv_id) WHERE ani_id = id);
END;

CREATE FUNCTION num_ticket() RETURNS INT BEGIN
	RETURN (SELECT COUNT(tic_id) FROM T_TICKET_tic);
END;

// DELIMITER ;

-- --------------------------------------------------------

--
-- Stand-in structure for view `anim_lie1`
-- (See below for the actual view)
--
CREATE TABLE `anim_lie1` (
`ani_id` int(11)
,`ani_nom` varchar(60)
,`ani_horaire_debut` datetime
,`ani_horaire_fin` datetime
,`lie_id` int(11)
,`lie_nom` varchar(60)
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `inv_by_anim`
-- (See below for the actual view)
--
CREATE TABLE `inv_by_anim` (
`ani_id` int(11)
,`inv_id` int(11)
,`inv_nom` varchar(60)
,`cpt_pseudo` varchar(60)
,`inv_biographie` varchar(600)
,`inv_image` varchar(200)
,`ani_nom` varchar(60)
,`ani_horaire_debut` datetime
,`ani_horaire_fin` datetime
,`lie_id` int(11)
);

-- --------------------------------------------------------

--
-- Table structure for table `T_ACTUALITE_act`
--

CREATE TABLE `T_ACTUALITE_act` (
  `act_id` int(11) NOT NULL,
  `act_titre` varchar(90) NOT NULL,
  `act_contenu` varchar(300) DEFAULT NULL,
  `act_date` datetime NOT NULL,
  `act_statut` char(1) NOT NULL,
  `org_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `T_ANIMATION_ani`
--

CREATE TABLE `T_ANIMATION_ani` (
  `ani_id` int(11) NOT NULL,
  `ani_nom` varchar(60) NOT NULL,
  `ani_presentation` varchar(200) NOT NULL,
  `ani_horaire_debut` datetime NOT NULL,
  `ani_horaire_fin` datetime NOT NULL,
  `lie_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Triggers `T_ANIMATION_ani`
--
DELIMITER //
CREATE TRIGGER del_act_after_anim BEFORE DELETE ON T_ANIMATION_ani 
FOR EACH ROW
BEGIN
	DECLARE id INT;
	SELECT act_id INTO id FROM T_ACTUALITE_act WHERE act_titre LIKE CONCAT('', '%', ani_nom, '%');
	DELETE FROM T_ACTUALITE_act WHERE act_id = id;
END;
// DELIMITER ;

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

-- --------------------------------------------------------

--
-- Table structure for table `T_A_POUR_pou`
--

CREATE TABLE `T_A_POUR_pou` (
  `inv_id` int(11) NOT NULL,
  `url_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `T_COMPTE_cpt`
--

CREATE TABLE `T_COMPTE_cpt` (
  `cpt_pseudo` varchar(60) NOT NULL,
  `cpt_mdp` char(64) NOT NULL,
  `cpt_etat` char(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `T_INVITE_inv`
--

CREATE TABLE `T_INVITE_inv` (
  `inv_id` int(11) NOT NULL,
  `inv_nom` varchar(60) NOT NULL,
  `cpt_pseudo` varchar(60) NOT NULL,
  `inv_biographie` varchar(600) DEFAULT NULL,
  `inv_discipline` varchar(90) NOT NULL,
  `inv_image` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `T_JOUE_jou`
--

CREATE TABLE `T_JOUE_jou` (
  `inv_id` int(11) NOT NULL,
  `ani_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Table structure for table `T_LIEU_lie`
--

CREATE TABLE `T_LIEU_lie` (
  `lie_id` int(11) NOT NULL,
  `lie_nom` varchar(60) NOT NULL,
  `lie_adresse` varchar(300) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Triggers `T_LIEU_lie`
--
DELIMITER //
CREATE TRIGGER new_lieu BEFORE INSERT ON T_LIEU_lie 
FOR EACH ROW
BEGIN
	INSERT INTO T_ACTUALITE_act(act_titre, act_contenu, act_date, act_statut, org_id) VALUES ("lieu ajouté", new.lie_adresse, NOW(), 'P', 1);
END;
// DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `T_OBJET_TROUVE_obj`
--

CREATE TABLE `T_OBJET_TROUVE_obj` (
  `obj_id` int(11) NOT NULL,
  `obj_nom` varchar(60) NOT NULL,
  `obj_description` varchar(300) DEFAULT NULL,
  `lie_id` int(11) NOT NULL,
  `tic_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Triggers `T_OBJET_TROUVE_obj`
--
DELIMITER //
CREATE TRIGGER new_obj_trouve BEFORE INSERT ON T_OBJET_TROUVE_obj 
FOR EACH ROW
BEGIN
	INSERT INTO T_ACTUALITE_act(act_titre, act_contenu, act_date, act_statut, org_id) VALUES ("Objet trouvé", new.obj_nom, NOW(), 'P', 1);
END;
// DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `T_ORGANISATEUR_org`
--

CREATE TABLE `T_ORGANISATEUR_org` (
  `org_id` int(11) NOT NULL,
  `org_nom` varchar(60) NOT NULL,
  `org_prenom` varchar(60) NOT NULL,
  `org_email` varchar(254) NOT NULL,
  `cpt_pseudo` varchar(60) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `T_PASSEPORT_pas`
--

CREATE TABLE `T_PASSEPORT_pas` (
  `pas_id` varchar(60) NOT NULL,
  `pas_mdp` char(64) NOT NULL,
  `pas_etat` char(1) NOT NULL,
  `inv_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `T_POST_pos`
--

CREATE TABLE `T_POST_pos` (
  `pos_id` int(11) NOT NULL,
  `pos_text` varchar(140) NOT NULL,
  `pos_date` datetime NOT NULL,
  `pos_etat` char(1) NOT NULL,
  `pas_id` varchar(60) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `T_SERVICE_ser`
--

CREATE TABLE `T_SERVICE_ser` (
  `ser_id` int(11) NOT NULL,
  `ser_nom` varchar(60) NOT NULL,
  `lie_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `T_TICKET_tic`
--

CREATE TABLE `T_TICKET_tic` (
  `tic_id` int(11) NOT NULL,
  `tic_numero` int(11) NOT NULL,
  `tic_chaine_car` varchar(60) NOT NULL,
  `tic_type` char(1) NOT NULL,
  `tic_nom` varchar(60) NOT NULL,
  `tic_prenom` varchar(60) NOT NULL,
  `tic_email` varchar(254) NOT NULL,
  `tic_tel` varchar(15) NOT NULL,
  `tic_billetrie` varchar(60) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `T_URL_url`
--

CREATE TABLE `T_URL_url` (
  `url_id` int(11) NOT NULL,
  `url_nom` varchar(60) NOT NULL,
  `url_lien` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure for view `anim_lie1`
--
DROP TABLE IF EXISTS `anim_lie1`;

CREATE ALGORITHM=UNDEFINED DEFINER=`zheron-sa`@`%` SQL SECURITY DEFINER VIEW `anim_lie1`  AS  select `T_ANIMATION_ani`.`ani_id` AS `ani_id`,`T_ANIMATION_ani`.`ani_nom` AS `ani_nom`,`T_ANIMATION_ani`.`ani_horaire_debut` AS `ani_horaire_debut`,`T_ANIMATION_ani`.`ani_horaire_fin` AS `ani_horaire_fin`,`T_ANIMATION_ani`.`lie_id` AS `lie_id`,`T_LIEU_lie`.`lie_nom` AS `lie_nom` from (`T_ANIMATION_ani` join `T_LIEU_lie` on(`T_ANIMATION_ani`.`lie_id` = `T_LIEU_lie`.`lie_id`)) where `T_ANIMATION_ani`.`lie_id` = 1 ;

-- --------------------------------------------------------

--
-- Structure for view `inv_by_anim`
--
DROP TABLE IF EXISTS `inv_by_anim`;

CREATE ALGORITHM=UNDEFINED DEFINER=`zheron-sa`@`%` SQL SECURITY DEFINER VIEW `inv_by_anim`  AS  select `T_JOUE_jou`.`ani_id` AS `ani_id`,`T_INVITE_inv`.`inv_id` AS `inv_id`,`T_INVITE_inv`.`inv_nom` AS `inv_nom`,`T_INVITE_inv`.`cpt_pseudo` AS `cpt_pseudo`,`T_INVITE_inv`.`inv_biographie` AS `inv_biographie`,`T_INVITE_inv`.`inv_image` AS `inv_image`,`T_ANIMATION_ani`.`ani_nom` AS `ani_nom`,`T_ANIMATION_ani`.`ani_horaire_debut` AS `ani_horaire_debut`,`T_ANIMATION_ani`.`ani_horaire_fin` AS `ani_horaire_fin`,`T_ANIMATION_ani`.`lie_id` AS `lie_id` from ((`T_INVITE_inv` join `T_JOUE_jou` on(`T_INVITE_inv`.`inv_id` = `T_JOUE_jou`.`inv_id`)) join `T_ANIMATION_ani` on(`T_JOUE_jou`.`ani_id` = `T_ANIMATION_ani`.`ani_id`)) ;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `T_ACTUALITE_act`
--
ALTER TABLE `T_ACTUALITE_act`
  ADD PRIMARY KEY (`act_id`),
  ADD KEY `fk_T_ACTUALITE_act_T_ORGANISATEUR_org1_idx` (`org_id`);

--
-- Indexes for table `T_ANIMATION_ani`
--
ALTER TABLE `T_ANIMATION_ani`
  ADD PRIMARY KEY (`ani_id`),
  ADD KEY `fk_T_ANIMATION_ani_T_LIEU_lie1_idx` (`lie_id`);

--
-- Indexes for table `T_A_POUR_pou`
--
ALTER TABLE `T_A_POUR_pou`
  ADD KEY `fk_T_A_POUR_pou_T_INVITE_inv1_idx` (`inv_id`),
  ADD KEY `fk_T_A_POUR_pou_T_URL_url1_idx` (`url_id`);

--
-- Indexes for table `T_COMPTE_cpt`
--
ALTER TABLE `T_COMPTE_cpt`
  ADD PRIMARY KEY (`cpt_pseudo`);

--
-- Indexes for table `T_INVITE_inv`
--
ALTER TABLE `T_INVITE_inv`
  ADD PRIMARY KEY (`inv_id`),
  ADD UNIQUE KEY `cpt_pseudo_UNIQUE` (`cpt_pseudo`),
  ADD KEY `fk_T_INVITE_inv_T_COMPTE_cpt1_idx` (`cpt_pseudo`);

--
-- Indexes for table `T_JOUE_jou`
--
ALTER TABLE `T_JOUE_jou`
  ADD KEY `fk_T_JOUE_jou_T_INVITE_inv1_idx` (`inv_id`),
  ADD KEY `fk_T_JOUE_jou_T_ANIMATION_ani1_idx` (`ani_id`);

--
-- Indexes for table `T_LIEU_lie`
--
ALTER TABLE `T_LIEU_lie`
  ADD PRIMARY KEY (`lie_id`);

--
-- Indexes for table `T_OBJET_TROUVE_obj`
--
ALTER TABLE `T_OBJET_TROUVE_obj`
  ADD PRIMARY KEY (`obj_id`),
  ADD KEY `fk_T_OBJET_TROUVE_obj_T_LIEU_lie1_idx` (`lie_id`),
  ADD KEY `fk_T_OBJET_TROUVE_obj_T_TICKET_tic1_idx` (`tic_id`);

--
-- Indexes for table `T_ORGANISATEUR_org`
--
ALTER TABLE `T_ORGANISATEUR_org`
  ADD PRIMARY KEY (`org_id`),
  ADD UNIQUE KEY `cpt_pseudo_UNIQUE` (`cpt_pseudo`),
  ADD KEY `fk_T_ORGANISATEUR_org_T_COMPTE_cpt1_idx` (`cpt_pseudo`);

--
-- Indexes for table `T_PASSEPORT_pas`
--
ALTER TABLE `T_PASSEPORT_pas`
  ADD PRIMARY KEY (`pas_id`),
  ADD KEY `fk_T_PASSEPORT_pas_T_INVITE_inv1_idx` (`inv_id`);

--
-- Indexes for table `T_POST_pos`
--
ALTER TABLE `T_POST_pos`
  ADD PRIMARY KEY (`pos_id`),
  ADD KEY `fk_T_POST_pos_T_PASSEPORT_pas1_idx` (`pas_id`);

--
-- Indexes for table `T_SERVICE_ser`
--
ALTER TABLE `T_SERVICE_ser`
  ADD PRIMARY KEY (`ser_id`),
  ADD KEY `fk_T_SERVICE_ser_T_LIEU_lie1_idx` (`lie_id`);

--
-- Indexes for table `T_TICKET_tic`
--
ALTER TABLE `T_TICKET_tic`
  ADD PRIMARY KEY (`tic_id`);

--
-- Indexes for table `T_URL_url`
--
ALTER TABLE `T_URL_url`
  ADD PRIMARY KEY (`url_id`);

--
-- AUTO_INCREMENT for table `T_ACTUALITE_act`
--
ALTER TABLE `T_ACTUALITE_act`
  MODIFY `act_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=60;

--
-- AUTO_INCREMENT for table `T_ANIMATION_ani`
--
ALTER TABLE `T_ANIMATION_ani`
  MODIFY `ani_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `T_INVITE_inv`
--
ALTER TABLE `T_INVITE_inv`
  MODIFY `inv_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `T_LIEU_lie`
--
ALTER TABLE `T_LIEU_lie`
  MODIFY `lie_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `T_OBJET_TROUVE_obj`
--
ALTER TABLE `T_OBJET_TROUVE_obj`
  MODIFY `obj_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `T_ORGANISATEUR_org`
--
ALTER TABLE `T_ORGANISATEUR_org`
  MODIFY `org_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `T_POST_pos`
--
ALTER TABLE `T_POST_pos`
  MODIFY `pos_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `T_SERVICE_ser`
--
ALTER TABLE `T_SERVICE_ser`
  MODIFY `ser_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `T_URL_url`
--
ALTER TABLE `T_URL_url`
  MODIFY `url_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- Constraints for table `T_ACTUALITE_act`
--
ALTER TABLE `T_ACTUALITE_act`
  ADD CONSTRAINT `fk_T_ACTUALITE_act_T_ORGANISATEUR_org1` FOREIGN KEY (`org_id`) REFERENCES `T_ORGANISATEUR_org` (`org_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `T_ANIMATION_ani`
--
ALTER TABLE `T_ANIMATION_ani`
  ADD CONSTRAINT `fk_T_ANIMATION_ani_T_LIEU_lie1` FOREIGN KEY (`lie_id`) REFERENCES `T_LIEU_lie` (`lie_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `T_A_POUR_pou`
--
ALTER TABLE `T_A_POUR_pou`
  ADD CONSTRAINT `fk_T_A_POUR_pou_T_INVITE_inv1` FOREIGN KEY (`inv_id`) REFERENCES `T_INVITE_inv` (`inv_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_T_A_POUR_pou_T_URL_url1` FOREIGN KEY (`url_id`) REFERENCES `T_URL_url` (`url_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `T_INVITE_inv`
--
ALTER TABLE `T_INVITE_inv`
  ADD CONSTRAINT `fk_T_INVITE_inv_T_COMPTE_cpt1` FOREIGN KEY (`cpt_pseudo`) REFERENCES `T_COMPTE_cpt` (`cpt_pseudo`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `T_JOUE_jou`
--
ALTER TABLE `T_JOUE_jou`
  ADD CONSTRAINT `fk_T_JOUE_jou_T_ANIMATION_ani1` FOREIGN KEY (`ani_id`) REFERENCES `T_ANIMATION_ani` (`ani_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_T_JOUE_jou_T_INVITE_inv1` FOREIGN KEY (`inv_id`) REFERENCES `T_INVITE_inv` (`inv_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `T_OBJET_TROUVE_obj`
--
ALTER TABLE `T_OBJET_TROUVE_obj`
  ADD CONSTRAINT `fk_T_OBJET_TROUVE_obj_T_LIEU_lie1` FOREIGN KEY (`lie_id`) REFERENCES `T_LIEU_lie` (`lie_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_T_OBJET_TROUVE_obj_T_TICKET_tic1` FOREIGN KEY (`tic_id`) REFERENCES `T_TICKET_tic` (`tic_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `T_ORGANISATEUR_org`
--
ALTER TABLE `T_ORGANISATEUR_org`
  ADD CONSTRAINT `fk_T_ORGANISATEUR_org_T_COMPTE_cpt1` FOREIGN KEY (`cpt_pseudo`) REFERENCES `T_COMPTE_cpt` (`cpt_pseudo`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `T_PASSEPORT_pas`
--
ALTER TABLE `T_PASSEPORT_pas`
  ADD CONSTRAINT `fk_T_PASSEPORT_pas_T_INVITE_inv1` FOREIGN KEY (`inv_id`) REFERENCES `T_INVITE_inv` (`inv_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `T_POST_pos`
--
ALTER TABLE `T_POST_pos`
  ADD CONSTRAINT `fk_T_POST_pos_T_PASSEPORT_pas1` FOREIGN KEY (`pas_id`) REFERENCES `T_PASSEPORT_pas` (`pas_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `T_SERVICE_ser`
--
ALTER TABLE `T_SERVICE_ser`
  ADD CONSTRAINT `fk_T_SERVICE_ser_T_LIEU_lie1` FOREIGN KEY (`lie_id`) REFERENCES `T_LIEU_lie` (`lie_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
