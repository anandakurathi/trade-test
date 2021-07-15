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
    
    INSERT INTO `users` (`user_id`, `user_name`, `email`)
    VALUES
	    (1,'joe','joe@gmail.com');

    DROP TABLE IF EXISTS `stocks`;

    CREATE TABLE IF NOT EXISTS `stocks` (
      `stock_id` BIGINT(20) UNSIGNED NOT NULL AUTO_INCREMENT,
      `stock_name` VARCHAR(15) NOT NULL,
      `stock_price` FLOAT(7,2) NOT NULL DEFAULT 0.00,
      `stock_date` DATE NOT NULL,
      PRIMARY KEY (`stock_id`))
    ENGINE = InnoDB
    DEFAULT CHARACTER SET = utf8mb4;

    DROP TABLE IF EXISTS `transactions`;

    CREATE TABLE `transactions` (
      `transaction_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
      `transaction_ref` varchar(16) NOT NULL,
      `user_id` int(11) unsigned NOT NULL,
      `stock_name` varchar(15) NOT NULL DEFAULT '',
      `stock_price` float(6,2) NOT NULL DEFAULT 0.00,
      `stock_date` date NOT NULL,
      `quantity` float(6,2) unsigned NOT NULL DEFAULT 0.00,
      `total_price` double(10,2) NOT NULL DEFAULT 0.00,
      `transaction_type` enum('Buy','Sell') NOT NULL DEFAULT 'Buy',
      `transaction_date` datetime NOT NULL,
      PRIMARY KEY (`transaction_id`),
      UNIQUE KEY `transaction_id_UNIQUE` (`transaction_id`),
      UNIQUE KEY `transaction_ref_UNIQUE` (`transaction_ref`),
      KEY `who_made_transaction_idx` (`user_id`),
      KEY `stok_ref_id_idx` (`stock_name`),
      CONSTRAINT `who_made_transaction` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

EOS;

try {
    $dbInstance = \Src\Config\DatabaseConnector::getInstance();
    $dbConnection = $dbInstance->getConnection();

    $createTable = $dbConnection->exec($statement);
    echo "Success!\n";
} catch (\PDOException $e) {
    exit($e->getMessage());
}
