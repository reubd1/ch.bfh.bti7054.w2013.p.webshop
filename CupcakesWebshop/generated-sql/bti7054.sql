
# This is a fix for InnoDB in MySQL >= 4.1.x
# It "suspends judgement" for fkey relationships until are tables are set.
SET FOREIGN_KEY_CHECKS = 0;

-- ---------------------------------------------------------------------
-- category
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `category`;

CREATE TABLE `category`
(
    `category_id` INTEGER NOT NULL AUTO_INCREMENT,
    `name` VARCHAR(48) NOT NULL,
    PRIMARY KEY (`category_id`)
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- item
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `item`;

CREATE TABLE `item`
(
    `item_id` INTEGER NOT NULL AUTO_INCREMENT,
    `name` VARCHAR(45) NOT NULL,
    `price` FLOAT NOT NULL,
    `image` VARCHAR(255) NOT NULL,
    `available` TINYINT(1),
    `category_id` INTEGER NOT NULL,
    PRIMARY KEY (`item_id`),
    INDEX `item_FI_1` (`category_id`),
    CONSTRAINT `item_FK_1`
        FOREIGN KEY (`category_id`)
        REFERENCES `category` (`category_id`)
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- item_description
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `item_description`;

CREATE TABLE `item_description`
(
    `item_desc_id` INTEGER NOT NULL AUTO_INCREMENT,
    `language` VARCHAR(45) NOT NULL,
    `text` VARCHAR(45) NOT NULL,
    `item_id` INTEGER NOT NULL,
    PRIMARY KEY (`item_desc_id`),
    INDEX `item_description_FI_1` (`item_id`),
    CONSTRAINT `item_description_FK_1`
        FOREIGN KEY (`item_id`)
        REFERENCES `item` (`item_id`)
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- order_items
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `order_items`;

CREATE TABLE `order_items`
(
    `order_items_id` INTEGER NOT NULL AUTO_INCREMENT,
    `amount` INTEGER NOT NULL,
    `order_id` INTEGER NOT NULL,
    `item_id` INTEGER NOT NULL,
    PRIMARY KEY (`order_items_id`),
    INDEX `order_items_FI_1` (`item_id`),
    INDEX `order_items_FI_2` (`order_id`),
    CONSTRAINT `order_items_FK_1`
        FOREIGN KEY (`item_id`)
        REFERENCES `item` (`item_id`),
    CONSTRAINT `order_items_FK_2`
        FOREIGN KEY (`order_id`)
        REFERENCES `order` (`order_id`)
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- order
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `order`;

CREATE TABLE `order`
(
    `order_id` INTEGER NOT NULL AUTO_INCREMENT,
    `total` FLOAT NOT NULL,
    `order_date` DATE NOT NULL,
    `user_id` INTEGER NOT NULL,
    `shipping_id` INTEGER NOT NULL,
    `billing_id` INTEGER NOT NULL,
    PRIMARY KEY (`order_id`),
    INDEX `order_FI_1` (`user_id`),
    INDEX `order_FI_2` (`billing_id`),
    INDEX `order_FI_3` (`shipping_id`),
    CONSTRAINT `order_FK_1`
        FOREIGN KEY (`user_id`)
        REFERENCES `user` (`user_id`),
    CONSTRAINT `order_FK_2`
        FOREIGN KEY (`billing_id`)
        REFERENCES `billing` (`billing_id`),
    CONSTRAINT `order_FK_3`
        FOREIGN KEY (`shipping_id`)
        REFERENCES `shipping_address` (`shipping_id`)
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- billing
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `billing`;

CREATE TABLE `billing`
(
    `billing_id` INTEGER NOT NULL AUTO_INCREMENT,
    `user_id` INTEGER NOT NULL,
    `card_id` INTEGER NOT NULL,
    `card_type` INTEGER NOT NULL,
    `card_number` INTEGER NOT NULL,
    `expire_date` DATE NOT NULL,
    PRIMARY KEY (`billing_id`),
    INDEX `billing_FI_1` (`user_id`),
    CONSTRAINT `billing_FK_1`
        FOREIGN KEY (`user_id`)
        REFERENCES `user` (`user_id`)
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- user
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `user`;

CREATE TABLE `user`
(
    `user_id` INTEGER NOT NULL AUTO_INCREMENT,
    `username` VARCHAR(45) NOT NULL,
    `password` VARCHAR(45) NOT NULL,
    `email` VARCHAR(45) NOT NULL,
    PRIMARY KEY (`user_id`)
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- shipping_address
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `shipping_address`;

CREATE TABLE `shipping_address`
(
    `shipping_id` INTEGER NOT NULL AUTO_INCREMENT,
    `name` VARCHAR(45) NOT NULL,
    `street` VARCHAR(45) NOT NULL,
    `zip` INTEGER NOT NULL,
    `city` VARCHAR(45) NOT NULL,
    `country` VARCHAR(45) NOT NULL,
    `available` TINYINT(1),
    `user_id` INTEGER NOT NULL,
    PRIMARY KEY (`shipping_id`),
    INDEX `shipping_address_FI_1` (`user_id`),
    CONSTRAINT `shipping_address_FK_1`
        FOREIGN KEY (`user_id`)
        REFERENCES `user` (`user_id`)
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- custom_item
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `custom_item`;

CREATE TABLE `custom_item`
(
    `custom_item_id` INTEGER NOT NULL AUTO_INCREMENT,
    `name` VARCHAR(45) NOT NULL,
    `order_id` INTEGER NOT NULL,
    `cake_id` INTEGER NOT NULL,
    `topping_id` INTEGER NOT NULL,
    `deco_id` INTEGER NOT NULL,
    PRIMARY KEY (`custom_item_id`),
    INDEX `custom_item_FI_1` (`order_id`),
    INDEX `custom_item_FI_2` (`cake_id`),
    INDEX `custom_item_FI_3` (`topping_id`),
    INDEX `custom_item_FI_4` (`deco_id`),
    CONSTRAINT `custom_item_FK_1`
        FOREIGN KEY (`order_id`)
        REFERENCES `order` (`order_id`),
    CONSTRAINT `custom_item_FK_2`
        FOREIGN KEY (`cake_id`)
        REFERENCES `cake` (`cake_id`),
    CONSTRAINT `custom_item_FK_3`
        FOREIGN KEY (`topping_id`)
        REFERENCES `topping` (`topping_id`),
    CONSTRAINT `custom_item_FK_4`
        FOREIGN KEY (`deco_id`)
        REFERENCES `decoration` (`deco_id`)
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- cake
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `cake`;

CREATE TABLE `cake`
(
    `cake_id` INTEGER NOT NULL AUTO_INCREMENT,
    `name` VARCHAR(45) NOT NULL,
    `description` VARCHAR(45) NOT NULL,
    PRIMARY KEY (`cake_id`)
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- topping
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `topping`;

CREATE TABLE `topping`
(
    `topping_id` INTEGER NOT NULL AUTO_INCREMENT,
    `name` VARCHAR(45) NOT NULL,
    `description` VARCHAR(45) NOT NULL,
    PRIMARY KEY (`topping_id`)
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- decoration
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `decoration`;

CREATE TABLE `decoration`
(
    `deco_id` INTEGER NOT NULL AUTO_INCREMENT,
    `name` VARCHAR(45) NOT NULL,
    `description` VARCHAR(45) NOT NULL,
    PRIMARY KEY (`deco_id`)
) ENGINE=InnoDB;

# This restores the fkey checks, after having unset them earlier
SET FOREIGN_KEY_CHECKS = 1;
