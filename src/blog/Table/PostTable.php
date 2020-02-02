<?php
/**
 * Created by PhpStorm.
 * User: Steph
 * Date: 02/02/2020
 * Time: 11:14
 */

namespace App\Blog\Table;

class PostTable
{


    /**
     * @var \PDO
     */
    private $pdo;

    public function __construct(\PDO $pdo)
    {

        $this->pdo = $pdo;
    }

    /**
     *
     * make a pagination of article
     * @return \stdClass[]
     */
    public function findPaginated(): array
    {
        return $this->pdo
            ->query("SELECT * FROM posts ORDER BY created_at DESC LIMIT 10")
            ->fetchAll();
    }


    /**
     * get an article with his id
     * @param int $id
     * @return \stdClass
     */
    public function find(int $id): \stdClass
    {
        $query = $this->pdo->prepare('SELECT * FROM posts WHERE id = ?');
        $query->execute([$id]);
        return $query->fetch();
    }
}
