<?php

namespace Masterclass\Model;

use PDO;

/**
 * Class BaseModel
 * @package Masterclass\Model
 */
class BaseModel
{
    /**
     * @var PDO
     */
    protected $db;

    /**
     * Set up DB.
     * @param PDO $pdo
     */
    public function __construct(PDO $pdo)
    {
        $this->db = $pdo;
    }
}
