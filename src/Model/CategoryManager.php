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

    public function update(array $data)
    {
        $statement = $this->pdo->prepare("UPDATE " . self::TABLE . "
                SET name=:name, animal_id=:animal_id           
                WHERE id=:id
            ");
        $statement->bindValue('name', $data['name'], \PDO::PARAM_STR);
        $statement->bindValue('animal_id', $data['animal_id'], \PDO::PARAM_INT);
        $statement->bindValue('id', $data['id'], \PDO::PARAM_INT);
        $statement->execute();
    }
}
