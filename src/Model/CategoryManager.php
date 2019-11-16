<?php

namespace App\Model;

/**
 * Class CategoryManager
 *
 */
class CategoryManager extends AbstractManager
{
    /**
     *
     */
    const TABLE = 'category';


    /**
     * BeastManager constructor.
     *
     */
    public function __construct()
    {
        parent::__construct(self::TABLE);
    }
}
