<?php
/**
 * Created by PhpStorm.
 * User: sylvain
 * Date: 07/03/18
 * Time: 18:20
 * PHP version 7
 */

namespace App\Model;

class RaceManager extends AbstractManager
{
    const TABLE = 'race';

    public function __construct()
    {
        parent::__construct(self::TABLE);
    }
}
