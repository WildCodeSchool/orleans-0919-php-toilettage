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

    public function selectAllInAnimals(): array
    {
        $query = "SELECT r.name race_name, r.id, price, c.name category, a.name animal FROM " . self::TABLE . " r
                    JOIN category c ON c.id=r.category_id
                        JOIN animal a ON a.id=c.animal_id";
        return $this->pdo->query($query)->fetchAll();
    }
}
