<?php

namespace Masterclass\Database;

/**
 * Class Mysql
 * @package Masterclass\Database
 */
class Mysql extends AbstractDb
{
    /**
     * @param string $sql
     * @param array  $bind
     * @return mixed
     */
    public function fetchOne($sql, array $bind = [])
    {
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($bind);

        return $stmt->fetch();
    }

    /**
     * @param string $sql
     * @param array  $bind
     * @return array
     */
    public function fetchAll($sql, array $bind = [])
    {
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($bind);

        return $stmt->fetchAll();
    }

    /**
     * @param string $sql
     * @param array  $bind
     * @return bool
     */
    public function execute($sql, array $bind = [])
    {
        $stmt = $this->pdo->prepare($sql);

        return $stmt->execute($bind);
    }
}
