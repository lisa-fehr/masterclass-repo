<?php

namespace Masterclass\Model;

use Masterclass\Database\AbstractDb;

/**
 * Class BaseModel
 * @package Masterclass\Model
 */
class BaseModel
{
    /**
     * @var AbstractDb
     */
    protected $db;

    /**
     * Set up DB.
     * @param AbstractDb $db
     */
    public function __construct(AbstractDb $db)
    {
        $this->db = $db;
    }
}
