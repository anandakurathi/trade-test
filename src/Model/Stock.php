<?php


namespace Src\Model;


class Stock extends BaseModel
{
    /**
     * @var string DB Table name
     */
    protected $table = 'stocks';

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
            "(stock_name, stock_price, stock_date)
                VALUES (:stock_name, :stock_price, :stock_date)";
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
                       stock_id, stock_name
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
            . $this->table . "
                WHERE
                    (
                        stock_name = '$stock' OR stock_name LIKE '%$stock%'
                    )
                AND
                    (
                        DATE(stock_date) BETWEEN '$from' AND '$to'
                        OR DATE(stock_date) <= '$from' or DATE(stock_date) >= '$to'
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

    public function getStockById($id)
    {
        if (!$id) {
            return null;
        }

        $query = "
                SELECT
                       stock_id, stock_name, stock_price, stock_date
                FROM "
            . $this->table .
            " WHERE stock_id = " . $id;
        try {
            $stmt = $this->db->prepare($query);
            $stmt->execute();
            return $stmt->fetch(\PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log($e->getMessage());
            return null;
        }
    }

    public function getForecastForPurchasedStocks(string $stock, $userId)
    {
        $query = "
            SELECT *
            FROM stocks 
            WHERE ( stock_name = '$stock' OR stock_name LIKE '%$stock%' ) 
            AND `stock_date` > (
                SELECT stock_date
                FROM transactions 
                WHERE user_id = '$userId' 
                AND ( stock_name = '$stock' OR stock_name LIKE '%$stock%' ) 
                ORDER BY stock_date 
                DESC LIMIT 1
            )";
        try {
            $stmt = $this->db->prepare($query);
            $stmt->execute();
            return $stmt->fetchAll(\PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log($e->getMessage());
            return null;
        }
    }

}