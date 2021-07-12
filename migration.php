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
      `stock_id` BIGINT(20) UNSIGNED NOT NULL AUTO_INCREMENT,
      `stock_name` VARCHAR(15) NOT NULL,
      `stock_price` FLOAT(7,2) NOT NULL DEFAULT 0.00,
      `stock_date` DATE NOT NULL,
      `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
      `updated_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
      PRIMARY KEY (`stock_id`))
    ENGINE = InnoDB
    DEFAULT CHARACTER SET = utf8mb4;

    DROP TABLE IF EXISTS `transactions`;

    CREATE TABLE IF NOT EXISTS `transactions` (
      `transaction_id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
      `transaction_ref` VARCHAR(16) NOT NULL,
      `user_id` INT(11) UNSIGNED NOT NULL,
      `stock_id` BIGINT(20) UNSIGNED NOT NULL,
      `transaction_type` ENUM('Buy', 'Sell') NOT NULL DEFAULT 'Buy',
      `transaction_date` DATETIME NOT NULL,
      `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
      `updated_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
      PRIMARY KEY (`transaction_id`),
      UNIQUE INDEX `transaction_id_UNIQUE` (`transaction_id` ASC),
      UNIQUE INDEX `transaction_ref_UNIQUE` (`transaction_ref` ASC),
      INDEX `who_made_transaction_idx` (`user_id` ASC),
      INDEX `stok_ref_id_idx` (`stock_id` ASC),
      CONSTRAINT `who_made_transaction`
        FOREIGN KEY (`user_id`)
        REFERENCES `users` (`user_id`)
        ON DELETE NO ACTION
        ON UPDATE NO ACTION,
      CONSTRAINT `stok_ref_id`
        FOREIGN KEY (`stock_id`)
        REFERENCES `stocks` (`stock_id`)
        ON DELETE NO ACTION
        ON UPDATE NO ACTION)
    ENGINE = InnoDB
    DEFAULT CHARACTER SET = utf8mb4;

EOS;

try {
    $dbInstance = \Src\Config\DatabaseConnector::getInstance();
    $dbConnection = $dbInstance->getConnection();

    $createTable = $dbConnection->exec($statement);
    echo "Success!\n";
} catch (\PDOException $e) {
    exit($e->getMessage());
}
