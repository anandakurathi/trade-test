<?php


namespace Src\Model;


class User extends BaseModel
{
    /**
     * @var string DB Table name
     */
    protected $table = 'users';

    public $columns = [
        'user_id', 'user_name', 'email'
    ];

    public function getUserById($id)
    {
        if(!$id)
        {
            return null;
        }

        $query = "
                SELECT
                       ".implode(', ', $this->columns)."
                FROM "
            . $this->table .
            " WHERE user_id = ".$id;
        try {
            $stmt = $this->db->prepare($query);
            $stmt->execute();
            return $stmt->fetch(\PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log($e->getMessage());
            return null;
        }
    }
}