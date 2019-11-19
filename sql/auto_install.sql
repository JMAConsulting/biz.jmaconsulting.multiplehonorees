CREATE TABLE IF NOT EXISTS `civicrm_entity_multiple_honoree` (
   `id` INT(10) NOT NULL AUTO_INCREMENT ,
   `contribution_id` INT(10) NOT NULL COMMENT 'Contribution ID' ,
   `honoree_name` VARCHAR(255) NULL COMMENT 'Name' ,
   `amount` FLOAT(10) NOT NULL DEFAULT '0' COMMENT 'Gift Amount' ,
    PRIMARY KEY (`id`)
) ENGINE = InnoDB;
