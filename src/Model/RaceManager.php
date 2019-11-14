<?php

namespace App\Model;

/**
 * Class RaceManager
 * 
 */

class RaceManager extends AbstractManager
{
    const TABLE = 'race';

    public function __construct()
    {
        parent::__construct(self::TABLE);
    }
}
