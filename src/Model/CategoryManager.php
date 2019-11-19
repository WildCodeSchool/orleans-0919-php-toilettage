<?php

namespace App\Model;

/**
 * Class CategoryManager
 *
**/


class CategoryManager extends AbstractManager
{
    /**
     *
     */
    const TABLE = 'category';

    /**
     *  Initializes this class.
     */
    public function selectCountByCategory(): array
    {
        $statement = $this->pdo->prepare("SELECT * FROM $this->table ORDER BY name");
        $statement->execute();

        return $statement->fetchall();
    }

    /**
     * Handle item deletion
     *
     * @param int $id
     */
    public function delete(int $id)
    {
        // prepared request
        $statement = $this->pdo->prepare("DELETE FROM $this->table WHERE id=:id");
        $statement->bindValue('id', $id, \PDO::PARAM_INT);
        $statement->execute();;

    }

}