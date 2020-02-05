<?php
/**
 * Created by PhpStorm.
 * User: Steph
 * Date: 02/02/2020
 * Time: 11:14
 */

namespace App\Blog\Table;

use App\Blog\Entity\Post;
use Framework\Database\PaginatedQuery;
use Pagerfanta\Exception\OutOfRangeCurrentPageException;
use Pagerfanta\Pagerfanta;

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
     * @param int|int $perPage
     * @param int $currentPage
     * @return PaginatedQuery|Pagerfanta
     */
    public function findPaginated(int $perPage, int $currentPage): Pagerfanta
    {
        try {
            $query =  new PaginatedQuery(
                $this->pdo,
                'SELECT * FROM posts ORDER BY created_at DESC ',
                'SELECT COUNT(id) FROM posts',
                Post::class
            );
            return (new Pagerfanta($query))
                ->setMaxPerPage($perPage)
                ->setCurrentPage($currentPage);
        } catch (OutOfRangeCurrentPageException $e) {
            $query =  new PaginatedQuery(
                $this->pdo,
                'SELECT * FROM posts ORDER BY created_at DESC ',
                'SELECT COUNT(id) FROM posts',
                Post::class
            );
            $pagerFanta = (new Pagerfanta($query))
                ->setMaxPerPage($perPage);

            $lastPage = $pagerFanta->getNbPages();
            return $pagerFanta->setCurrentPage($lastPage);
        }
    }


    /**
     * get an article with his id
     * @param int $id
     * @return Post|null
     */
    public function find(int $id) : ?Post
    {
        $query = $this->pdo->prepare('SELECT * FROM posts WHERE id = ?');
        $query->execute([$id]);
        $query->setFetchMode(\PDO::FETCH_CLASS, Post::class);
        return $query->fetch() ?: null;
    }
}
