<?php
require 'bootstrap.php';

$statement = <<<EOS
    DROP TABLE IF EXISTS `stocks`;

    CREATE TABLE `stocks` (
      `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
      `stock_name` varchar(45) NOT NULL DEFAULT '',
      `stock_price` float(7,2) NOT NULL DEFAULT 0.00,
      `stock_date` date NOT NULL,
      `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
      `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
      PRIMARY KEY (`id`)
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
