-- ---
-- Globals
-- ---

-- SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
-- SET FOREIGN_KEY_CHECKS=0;

-- ---
-- Table 'pokemon'
-- 
-- ---

DROP TABLE IF EXISTS `pokemon`;
		
CREATE TABLE `pokemon` (
  `id` INTEGER NOT NULL AUTO_INCREMENT,
  `nom` VARCHAR(15) NULL DEFAULT NULL,
  `path_to_image` VARCHAR(100) NULL DEFAULT NULL,
  `id_categorie` INTEGER NULL DEFAULT NULL,
  `taille` VARCHAR(15) NULL DEFAULT NULL,
  `poids` VARCHAR(15) NULL DEFAULT NULL,
  `pv` INTEGER NULL DEFAULT NULL,
  `attack` INTEGER NULL DEFAULT NULL,
  `defense` INTEGER NULL DEFAULT NULL,
  `vitesse` INTEGER NULL DEFAULT NULL,
  `path_to_image_shiny` VARCHAR(100) NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
)ENGINE=INNODB;

-- ---
-- Table 'region'
-- 
-- ---

DROP TABLE IF EXISTS `region`;
		
CREATE TABLE `region` (
  `id` INTEGER NOT NULL AUTO_INCREMENT,
  `nom` VARCHAR(15) NULL DEFAULT NULL,
  `description` MEDIUMTEXT NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
)ENGINE=INNODB;

-- ---
-- Table 'type'
-- 
-- ---

DROP TABLE IF EXISTS `type`;
		
CREATE TABLE `type` (
  `id` INTEGER NOT NULL AUTO_INCREMENT,
  `nom` VARCHAR(15) NULL DEFAULT NULL,
  `description` MEDIUMTEXT NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
)ENGINE=INNODB;

-- ---
-- Table 'famille'
-- 
-- ---

DROP TABLE IF EXISTS `famille`;
		
CREATE TABLE `famille` (
  `id` INTEGER NOT NULL AUTO_INCREMENT,
  `id_pokemon_base` INTEGER NULL DEFAULT NULL,
  `id_pokemon_level_2` INTEGER NULL DEFAULT NULL,
  `id_pokemon_level_3` INTEGER NULL DEFAULT NULL,
  `id_pokemon_ex` INTEGER NULL DEFAULT NULL,
  `description` MEDIUMTEXT NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
)ENGINE=INNODB;

-- ---
-- Table 'link_region'
-- 
-- ---

DROP TABLE IF EXISTS `link_region`;
		
CREATE TABLE `link_region` (
  `id_pokemon` INTEGER NOT NULL,
  `id_region` INTEGER NOT NULL,
  PRIMARY KEY (`id_pokemon`, `id_region`)
)ENGINE=INNODB;

-- ---
-- Table 'link_type'
-- 
-- ---

DROP TABLE IF EXISTS `link_type`;
		
CREATE TABLE `link_type` (
  `id_type` INTEGER NOT NULL,
  `id_pokemon` INTEGER NOT NULL,
  PRIMARY KEY (`id_type`, `id_pokemon`)
)ENGINE=INNODB;

-- ---
-- Table 'generation'
-- 
-- ---

DROP TABLE IF EXISTS `generation`;
		
CREATE TABLE `generation` (
  `id` INTEGER NOT NULL AUTO_INCREMENT,
  `description` MEDIUMTEXT NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
)ENGINE=INNODB;

-- ---
-- Table 'link_generation'
-- 
-- ---

DROP TABLE IF EXISTS `link_generation`;
		
CREATE TABLE `link_generation` (
  `id_generation` INTEGER NOT NULL,
  `id_pokemon` INTEGER NOT NULL,
  PRIMARY KEY (`id_generation`, `id_pokemon`)
)ENGINE=INNODB;

-- ---
-- Table 'link_faiblesse'
-- 
-- ---

DROP TABLE IF EXISTS `link_faiblesse`;
		
CREATE TABLE `link_faiblesse` (
  `id_pokemon` INTEGER NOT NULL,
  `id_type` INTEGER NOT NULL,
  PRIMARY KEY (`id_pokemon`, `id_type`)
)ENGINE=INNODB;

-- ---
-- Table 'categorie'
-- 
-- ---

DROP TABLE IF EXISTS `categorie`;
		
CREATE TABLE `categorie` (
  `id` INTEGER NOT NULL AUTO_INCREMENT,
  `nom` VARCHAR(50) NULL DEFAULT NULL,
  `description` MEDIUMTEXT NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
)ENGINE=INNODB;

-- ---
-- Foreign Keys 
-- ---

ALTER TABLE `pokemon` ADD FOREIGN KEY (id_categorie) REFERENCES `categorie` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
ALTER TABLE `famille` ADD FOREIGN KEY (id_pokemon_base) REFERENCES `pokemon` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
ALTER TABLE `famille` ADD FOREIGN KEY (id_pokemon_level_2) REFERENCES `pokemon` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
ALTER TABLE `famille` ADD FOREIGN KEY (id_pokemon_level_3) REFERENCES `pokemon` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
ALTER TABLE `famille` ADD FOREIGN KEY (id_pokemon_ex) REFERENCES `pokemon` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
ALTER TABLE `link_region` ADD FOREIGN KEY (id_pokemon) REFERENCES `pokemon` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
ALTER TABLE `link_region` ADD FOREIGN KEY (id_region) REFERENCES `region` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
ALTER TABLE `link_type` ADD FOREIGN KEY (id_type) REFERENCES `type` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
ALTER TABLE `link_type` ADD FOREIGN KEY (id_pokemon) REFERENCES `pokemon` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
ALTER TABLE `link_generation` ADD FOREIGN KEY (id_generation) REFERENCES `generation` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
ALTER TABLE `link_generation` ADD FOREIGN KEY (id_pokemon) REFERENCES `pokemon` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
ALTER TABLE `link_faiblesse` ADD FOREIGN KEY (id_pokemon) REFERENCES `pokemon` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
ALTER TABLE `link_faiblesse` ADD FOREIGN KEY (id_type) REFERENCES `type` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

-- ---
-- Table Properties
-- ---

-- ALTER TABLE `pokemon` ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
-- ALTER TABLE `region` ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
-- ALTER TABLE `type` ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
-- ALTER TABLE `famille` ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
-- ALTER TABLE `link_region` ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
-- ALTER TABLE `link_type` ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
-- ALTER TABLE `generation` ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
-- ALTER TABLE `link_generation` ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
-- ALTER TABLE `link_faiblesse` ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
-- ALTER TABLE `categorie` ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- ---
-- Test Data
-- ---

-- INSERT INTO `pokemon` (`id`,`nom`,`path_to_image`,`description`,`sexe`,`id_categorie`,`taille`,`poids`,`pv`,`attack`,`defense`,`vitesse`,`path_to_image_shiny`) VALUES
-- ('','','','','','','','','','','','','');
-- INSERT INTO `region` (`id`,`nom`,`description`) VALUES
-- ('','','');
-- INSERT INTO `type` (`id`,`nom`,`description`) VALUES
-- ('','','');
-- INSERT INTO `famille` (`id`,`id_pokemon_base`,`id_pokemon_level_2`,`id_pokemon_level_3`,`id_pokemon_ex`,`description`) VALUES
-- ('','','','','','');
-- INSERT INTO `link_region` (`id_pokemon`,`id_region`) VALUES
-- ('','');
-- INSERT INTO `link_type` (`id_type`,`id_pokemon`) VALUES
-- ('','');
-- INSERT INTO `generation` (`id`,`description`) VALUES
-- ('','');
-- INSERT INTO `link_generation` (`id_generation`,`id_pokemon`) VALUES
-- ('','');
-- INSERT INTO `link_faiblesse` (`id_pokemon`,`id_type`) VALUES
-- ('','');
-- INSERT INTO `categorie` (`id`,`nom`,`description`) VALUES
-- ('','','');
