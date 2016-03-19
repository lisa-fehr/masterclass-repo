<?php

namespace Masterclass\Database;

use PDO;

/**
 * Class AbstractDb
 * @package Masterclass\Database
 */
abstract class AbstractDb
{
    /**
     * @var PDO
     */
    protected $pdo;

    /**
     * AbstractDb constructor.
     * @param string $dsn
     * @param string $user
     * @param string $pass
     */
    public function __construct($dsn, $user, $pass)
    {
        $pdo = new PDO($dsn, $user, $pass);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        $this->pdo = $pdo;
    }

    /**
     * @param string $sql
     * @param array $bind
     * @return array
     */
    abstract public function fetchOne($sql, array $bind = []);

    /**
     * @param string $sql
     * @param array $bind
     * @return array
     */
    abstract public function fetchAll($sql, array $bind = []);

    /**
     * @param string $sql
     * @param array $bind
     * @return bool
     */
    abstract public function execute($sql, array $bind = []);

    /**
     * @return string
     */
    public function lastInsertId()
    {
        return $this->pdo->lastInsertId();
    }
}
