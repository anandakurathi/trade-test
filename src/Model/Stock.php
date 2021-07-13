<?php


namespace Src\Model;


use Src\Config\DatabaseConnector;

class Stock
{
    /**
     * @var string DB Table name
     */
    protected $table = 'stocks';

    /**
     * @var null
     */
    private $db = null;


    public function __construct()
    {
        $dbInstance = DatabaseConnector::getInstance();
        $this->db = $dbInstance->getConnection();
    }

    /**
     * Insert stock list
     * @param array $data
     * @return null
     */
    public function insertStocks(array $data)
    {
        if (!$data) {
            return null;
        }
        $query = "INSERT INTO " . $this->table .
            "(stock_name, stock_price, stock_date, created_at, updated_at)
                VALUES (:stock_name, :stock_price, :stock_date, :created_at, :updated_at)";
        $stmt = $this->db->prepare($query);
        try {
            $this->db->beginTransaction();
            foreach ($data as $row) {
                $stmt->execute($row);
            }
            $this->db->commit();
        } catch (PDOException $e) {
            error_log($e->getMessage());
            $this->db->rollback();
            return null;
        }
    }

    /**
     * Get distinct Stock names
     * @return mixed|null
     */
    public function getDistinctStocks()
    {
        $query = "
                SELECT
                       stock_name
                FROM "
            . $this->table .
            " GROUP BY stock_name
                ORDER BY stock_name DESC 
                ";
        try {
            $stmt = $this->db->prepare($query);
            $stmt->execute();
            return $stmt->fetchAll(\PDO::FETCH_OBJ);
        } catch (PDOException $e) {
            error_log($e->getMessage());
            return null;
        }
    }

    /**
     * Get distinct Stock names
     * @return mixed|null
     */
    public function getStocksByName($string)
    {
        if (!$string) {
            return null;
        }
        $query = "
                SELECT
                       stock_name
                FROM "
            . $this->table .
            " 
                WHERE
                    stock_name LIKE '%$string%'
                GROUP BY stock_name
                ORDER BY stock_name DESC 
                ";
        try {
            $stmt = $this->db->prepare($query);
            $stmt->execute();
            return $stmt->fetchAll(\PDO::FETCH_OBJ);
        } catch (PDOException $e) {
            error_log($e->getMessage());
            return null;
        }
    }

    public function getStockForecast(string $stock, string $from, string $to)
    {
        $query = "
                SELECT
                       stock_id, stock_name, stock_price, stock_date
                FROM "
            . $this->table .
            " 
                WHERE
                    (
                        stock_name = '$stock'
                        AND DATE(stock_date) BETWEEN '$from' AND '$to'
                    )
                OR
                    (
                        stock_name LIKE '%$stock%'
                        AND DATE(stock_date) <= '$from'
                    )
                ORDER BY stock_date DESC";
        try {
            $stmt = $this->db->prepare($query);
            $stmt->execute();
            return $stmt->fetchAll(\PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log($e->getMessage());
            return null;
        }
    }

    public function getStockedPurchasedDetails()
    {

    }

}