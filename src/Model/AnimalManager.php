<?php

namespace App\Model;

/**
 * Class AnimalManager
 *
 */
class AnimalManager extends AbstractManager
{
    /**
     *
     */
    const TABLE = 'animal';


    /**
     * BeastManager constructor.
     *
     */
    public function __construct()
    {
        parent::__construct(self::TABLE);
    }
}
