<?php


namespace Src\Model;


use Src\Config\DatabaseConnector;

class BaseModel
{
    /**
     * @var null
     */
    protected $db = null;

    /**
     * BaseModel constructor.
     */
    public function __construct()
    {
        $dbInstance = DatabaseConnector::getInstance();
        $this->db = $dbInstance->getConnection();
    }

}