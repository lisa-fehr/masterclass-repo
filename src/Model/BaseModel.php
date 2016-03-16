<?php

namespace Masterclass\Model;

use PDO;

class BaseModel
{
    /**
     * @var PDO
     */
    protected $db;

    /**
     * Set up DB.
     * @param array $config
     */
    public function __construct($config)
    {
        $dbconfig = $config['database'];
        $dsn = 'mysql:host=' . $dbconfig['host'] . ';dbname=' . $dbconfig['name'];
        $this->db = new PDO($dsn, $dbconfig['user'], $dbconfig['pass']);
        $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }
}