<?php

namespace App\Model;

/**
 * Class RaceManager
 * @package Model
 */
class RaceManager extends AbstractManager
{

    /**
     *
     */
    const TABLE = 'race';


    /**
     * RaceManager constructor.
     * @param \PDO $pdo
     */
    public function __construct()
    {
        parent::__construct(self::TABLE);
    }

    public function selectOneById(int $id)
    {
        $statement = $this->pdo->prepare("
            SELECT r.*, c.name category_name FROM " . self::TABLE . " r 
                JOIN category c ON c.id = r.category_id
                WHERE r.id=:id
            ");
        $statement->bindValue('id', $id, \PDO::PARAM_INT);
        $statement->execute();

        return $statement->fetch();
    }
}


