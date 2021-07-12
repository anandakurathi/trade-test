<?php
require 'bootstrap.php';

$statement = <<<EOS
    DROP TABLE IF EXISTS `users`;

    CREATE TABLE IF NOT EXISTS `users` (
      `user_id` INT(11) UNSIGNED NOT NULL,
      `user_name` VARCHAR(25) NOT NULL,
      `email` VARCHAR(45) NOT NULL,
      `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
      `updated_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
      PRIMARY KEY (`user_id`),
      UNIQUE INDEX `user_id_UNIQUE` (`user_id` ASC))
    ENGINE = InnoDB
    DEFAULT CHARACTER SET = utf8mb4;

    DROP TABLE IF EXISTS `stocks`;

    CREATE TABLE IF NOT EXISTS `stocks` (
      `stock_id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
      `stock_name` VARCHAR(45) NOT NULL DEFAULT '',
      `stock_status` ENUM('A', 'B') NOT NULL DEFAULT 'A' COMMENT 'A=> Active, B=> Blocked',
      `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
      `updated_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
      PRIMARY KEY (`stock_id`),
      UNIQUE INDEX `stock_id_UNIQUE` (`stock_id` ASC))
    ENGINE = InnoDB
    DEFAULT CHARACTER SET = utf8mb4;

    DROP TABLE IF EXISTS `stock_exchange`;

    CREATE TABLE IF NOT EXISTS `stock_exchange` (
      `stock_exchange_id` BIGINT(20) UNSIGNED NOT NULL,
      `stock_id` INT(11) UNSIGNED NOT NULL,
      `stock_price` FLOAT(7,2) NOT NULL DEFAULT 0.00,
      `stock_date` DATE NOT NULL,
      `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
      `updated_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
      PRIMARY KEY (`stock_exchange_id`),
      INDEX `stock_foreign_relation_idx` (`stock_id` ASC),
      CONSTRAINT `stock_foreign_relation`
        FOREIGN KEY (`stock_id`)
        REFERENCES `stocks` (`stock_id`)
        ON DELETE NO ACTION
        ON UPDATE NO ACTION)
    ENGINE = InnoDB
    DEFAULT CHARACTER SET = utf8mb4;

    DROP TABLE IF EXISTS `transactions`;

    CREATE TABLE IF NOT EXISTS `transactions` (
      `transaction_id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
      `transaction_ref` VARCHAR(16) NOT NULL,
      `user_id` INT(11) UNSIGNED NOT NULL,
      `stock_id` INT(11) UNSIGNED NOT NULL,
      `stock_exchange_id` BIGINT(20) UNSIGNED NOT NULL,
      `transaction_type` ENUM('Buy', 'Sell') NOT NULL DEFAULT 'Buy',
      `transaction_date` DATETIME NOT NULL,
      `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
      `updated_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
      PRIMARY KEY (`transaction_id`),
      UNIQUE INDEX `transaction_id_UNIQUE` (`transaction_id` ASC),
      UNIQUE INDEX `transaction_ref_UNIQUE` (`transaction_ref` ASC),
      INDEX `stock_refence_key_idx` (`stock_id` ASC),
      INDEX `exchange_refernce_key_idx` (`stock_exchange_id` ASC),
      INDEX `who_made_transaction_idx` (`user_id` ASC),
      CONSTRAINT `stock_refence_key`
        FOREIGN KEY (`stock_id`)
        REFERENCES `stocks` (`stock_id`)
        ON DELETE NO ACTION
        ON UPDATE NO ACTION,
      CONSTRAINT `exchange_refernce_key`
        FOREIGN KEY (`stock_exchange_id`)
        REFERENCES `stock_exchange` (`stock_exchange_id`)
        ON DELETE NO ACTION
        ON UPDATE NO ACTION,
      CONSTRAINT `who_made_transaction`
        FOREIGN KEY (`user_id`)
        REFERENCES `users` (`user_id`)
        ON DELETE NO ACTION
        ON UPDATE NO ACTION)
    ENGINE = InnoDB;

EOS;

try {
    $dbInstance = \Src\Config\DatabaseConnector::getInstance();
    $dbConnection = $dbInstance->getConnection();

    $createTable = $dbConnection->exec($statement);
    echo "Success!\n";
} catch (\PDOException $e) {
    exit($e->getMessage());
}
