<?php


namespace Src\Model;

use PDO as PDO;

class Transaction extends BaseModel
{
    /**
     * Types of transactions can perform
     */
    const TRANSACTION_TYPE = [
        'Buy' => 'Buy',
        'Sell' => 'Sell'
    ];

    /**
     * @var string DB Table name
     */
    protected $table = 'transactions';

    /**
     * @param $stockInfo
     * @param $quantity
     * @param $userId
     * @param $totalAmount
     * @param $transactionType
     * @return mixed|null
     * @throws \Exception
     */
    public function createTransaction(
        $stockInfo,
        $quantity,
        $userId,
        $totalAmount,
        $transactionType
    ) {
        $transRef = bin2hex(random_bytes(8));
        $now = date('Y-m-d H:i:s');
        $query = "INSERT INTO " . $this->table .
            "(transaction_ref, user_id, stock_name, stock_price, stock_date,
                quantity, total_price,
                transaction_type, transaction_date)
            VALUES (:transaction_ref, :user_id, 
                    :stock_name, :stock_price, :stock_date,
                    :quantity, :total_price,
                    :transaction_type, :transaction_date)";
        $statement = $this->db->prepare($query);
        $statement->bindParam(":transaction_ref", $transRef, PDO::PARAM_STR, 16);
        $statement->bindParam(":user_id", $userId, PDO::PARAM_INT);
        $statement->bindParam(":stock_name", $stockInfo['stock_name'], PDO::PARAM_STR, 15);
        $statement->bindParam(":stock_price", $stockInfo['stock_price'], PDO::PARAM_STR, 6);
        $statement->bindParam(":stock_date", $stockInfo['stock_date'], PDO::PARAM_STR);
        $statement->bindParam(":quantity", $quantity, PDO::PARAM_STR, 6);
        $statement->bindParam(":total_price", $totalAmount, PDO::PARAM_STR, 10);
        $statement->bindParam(":transaction_type", $transactionType, PDO::PARAM_STR, 5);
        $statement->bindParam(":transaction_date", $now);

        try {
            $this->db->beginTransaction();
            $statement->execute();
            $id = $this->db->lastInsertId();
            $this->db->commit();
            return $transRef;
        } catch (\PDOException $e) {
            error_log($e->getMessage());
            $this->db->rollback();
            return null;
        }
    }

    public function getList($userId, $stockName = '')
    {
        $subQuery = '';
        if ($stockName) {
            $subQuery .= " AND stock_name = '$stockName'";
        }
        $query = "
                SELECT
                    transaction_id, transaction_ref, 
                    stock_name, stock_price, stock_date,
                    quantity, total_price,
                    transaction_type, transaction_date
                FROM "
            . $this->table . "
            WHERE user_id = " . $userId . $subQuery;
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