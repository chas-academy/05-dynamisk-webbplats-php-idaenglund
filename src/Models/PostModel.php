<?php

namespace Blogg\Models;

use Blogg\Domain\Post;
use Blogg\Exceptions\DbException;
use Blogg\Exceptions\NotFoundException;
use PDO;

class PostModel extends AbstractModel
{
    const CLASSNAME = '\Blogg\Domain\Post';

    public function get(int $postId): Post
    {
        $query = 'SELECT * FROM posts WHERE id = :id';
        $sth = $this->db->prepare($query);
        $sth->execute(['id' => $postId]);

        $posts = $sth->fetchAll(PDO::FETCH_CLASS, self::CLASSNAME);
        if (empty($posts)) {
            throw new NotFoundException();
        }

        return $posts[0];
    }

    public function getAll(int $page, int $pageLength): array
    {
        $start = $pageLength * ($page - 1);

        $query = 'SELECT * FROM posts LIMIT :page, :length';
        $sth = $this->db->prepare($query);
        $sth->bindParam('page', $start, PDO::PARAM_INT);
        $sth->bindParam('length', $pageLength, PDO::PARAM_INT);
        $sth->execute();

        return $sth->fetchAll(PDO::FETCH_CLASS, self::CLASSNAME);
    }

    public function search(string $title, string $content): array
    {
        $query = <<<SQL
SELECT * FROM posts
WHERE title LIKE :title AND content LIKE :content
SQL;
        $sth = $this->db->prepare($query);
        $sth->bindValue('title', "%$title%");
        $sth->bindValue('content', "%$content%");
        $sth->execute();

        return $sth->fetchAll(PDO::FETCH_CLASS, self::CLASSNAME);
    }
}
