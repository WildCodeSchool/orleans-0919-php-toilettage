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
                SET name=:name          
                WHERE id=:id
            ");
        $statement->bindValue('name', $data['category'], \PDO::PARAM_STR);
        $statement->bindValue('id', $data['id'], \PDO::PARAM_INT);
        $statement->execute();
    }

    public function insert(array $data)
    {
        $statement = $this->pdo->prepare('INSERT INTO ' . self::TABLE . " (name) VALUES (:name)");
        $statement->bindValue('name', $data['category'], \PDO::PARAM_STR);
        $statement->execute();
    }
}
